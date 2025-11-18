<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admission\Http\Models\AdmissionSslCommerce;
use Modules\Admission\Http\Models\AdmissionSslPayment;
use Modules\Admission\Http\Requests\StoreAdmissionDataRequest;
use Modules\Admission\Http\Requests\StoreAdmissionRequest;
use Modules\Admission\Rules\ImageDimensions;
use Modules\Admission\Services\SaveSetSubjectsService;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Admission\Http\Models\Admission;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\Admission\Http\Imports\AdmissionImport;
use Modules\Admission\Tables\AdmissionTable;
use Exception;
use Modules\Option\Http\Models\OptionSet;
use Mpdf\Mpdf;
use Throwable;
use MetaBox;
use Theme;
use SeoHelper;
use Option;

class AdmissionController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdmissionInterface
     */
    protected $admissionRepository;

    /**
     * AdmissionController constructor.
     * @param AdmissionInterface $admissionRepository
     */
    public function __construct(AdmissionInterface $admissionRepository)
    {
        $this->admissionRepository = $admissionRepository;
    }
    protected $photo_path = 'uploads/admission/';

    /**
     * @param AdmissionTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdmissionTable $dataTable)
    {
        if (!auth()->user()->can('admission_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admission_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission_import'));
        $data = array();
        $data['title']        = 'admission_import';
        return view('admission::admission.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admission_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdmissionImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('admission::lang.record_save_successfully');
        return redirect()->route('admission.index')->with('response_data', $response_data);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('admission_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission_create'));
        $data = array();
        $data['title']        = 'admission_create';
        return view('admission::admission.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
//    public function store(StoreAdmissionRequest $request, DboardHttpResponse $response)
    public function store(StoreAdmissionDataRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admission_create')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);

        try {
            $record = $this->admissionRepository->createOrUpdate(array_merge($request->input(), [
//                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));

            $file_name = 'photo';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
                $request->validate([
                    "$file_name" => 'required|image|mimes:jpeg,jpg,png|max:151'
                ]);
                $path = $this->photo_path;
                deleteFile($record->photo, $path);
                // Open the image file
                $uploadedImage = $request->file($file_name);

                $img = \Intervention\Image\Facades\Image::make($uploadedImage);

                // Get image width and height
                $width = $img->width();
                $height = $img->height();

                // Check width and height
                if ($width > 301 || $height > 301) {
//                    return redirect()->back()->withErrors(['message' => 'Image dimensions are too large.']);
                    return $response
                        ->setPreviousUrl(route('admission.index'))
                        ->setMessage(trans('Image dimensions are too large.'));
                }

                $record->$file_name      = processUpload($request, $record,$file_name, $path);
                $record->save();
            }

            event(new CreatedContentEvent(ADMISSION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admission.index'))
                ->setNextUrl(route('admission.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admission.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function admission_store(StoreAdmissionRequest $request, DboardHttpResponse $response, SaveSetSubjectsService $setSubjectsService)
    {
//        if (!auth()->user()->can('admission_create')) {
//            abort(403, 'Unauthorized action.');
//        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);
//        dd(json_encode($subjectData));
        try {
            $record = $this->admissionRepository->createOrUpdate(array_merge($request->input(), [
//                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'subject_id_')) {
                    $setId = str_replace('subject_id_', '', $key);
                    $subjectData[$setId] = $value; // $value is an array of IDs
                }
            }
            $setSubjectsService->execute($record, $subjectData);
//            dd($setSubjectsService);
//            dd($record);
            $file_name = 'photo';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
//                $validator = $request->validate([
////                    "$file_name" => 'required|image|mimes:jpeg,jpg,png|max:150'
//                    "photo" => [
//                        'required',
//                        'image',
//                        'mimes:jpeg,png,jpg,gif',
//                        'max:15',
//                        new ImageDimensions(300, 300), // Adjust the dimensions as needed
//                    ],
//                ]);
//                dd($validator);
                $path = $this->photo_path;
                deleteFile($record->photo, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
            $file_name = 'ssc_transcript';
            if ($request->hasFile($file_name))
            {
                $path = $this->photo_path;
                deleteFile($record->photo, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
            $file_name = 'ssc_testimonial';
            if ($request->hasFile($file_name))
            {
                $path = $this->photo_path;
                deleteFile($record->photo, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
//            $file_name = 'payment_img';
//            if ($request->hasFile($file_name))
//            {
//                $path = $this->photo_path;
//                deleteFile($record->photo, $path);
//
//                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
//                $record->save();
//            }

            event(new CreatedContentEvent(ADMISSION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(URL::previous())
                ->setNextUrl(route('admission_payment', $record->uuid))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (Exception $e){
            return $response
                ->setPreviousUrl(URL::previous())
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function admission_update(StoreAdmissionRequest $request, Admission $admission, DboardHttpResponse $response, SaveSetSubjectsService $setSubjectsService)
    {
//        dd($request->all());
//        dd($admission);
//        return response()->json(['success' => true]);
//        if (!auth()->user()->can('admission_create')) {
//            abort(403, 'Unauthorized action.');
//        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);
//        dd(json_encode($subjectData));
        try {
            $id = $admission->id;
            $admission = $this->admissionRepository->firstOrNew(compact('id'));
            $admission->fill($request->input());
            $this->admissionRepository->createOrUpdate($admission);

//            $record = $this->admissionRepository->createOrUpdate(array_merge($request->input(), [
////                'user_id' => Auth::id(),
//                'uuid'    => gen_uuid(),
//                'slug'    => checkSlugFunction($request->input('name')),
//            ]));
            $subjectData[] = array();
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'subject_id_')) {
                    $setId = str_replace('subject_id_', '', $key);
                    $subjectData[$setId] = $value; // $value is an array of IDs
                }
            }
            $setSubjectsService->execute($admission, $subjectData);
//            dd($setSubjectsService);
//            dd($record);
            $file_name = 'photo';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
//                $validator = $request->validate([
////                    "$file_name" => 'required|image|mimes:jpeg,jpg,png|max:150'
//                    "photo" => [
//                        'required',
//                        'image',
//                        'mimes:jpeg,png,jpg,gif',
//                        'max:15',
//                        new ImageDimensions(300, 300), // Adjust the dimensions as needed
//                    ],
//                ]);
//                dd($validator);
                $path = $this->photo_path;
                deleteFile($admission->photo, $path);

                $admission->$file_name      = documentProcessUpload($request, $admission,$file_name, $path);
                $admission->save();
            }
            $file_name = 'ssc_transcript';
            if ($request->hasFile($file_name))
            {
                $path = $this->photo_path;
                deleteFile($admission->photo, $path);

                $admission->$file_name      = documentProcessUpload($request, $admission,$file_name, $path);
                $admission->save();
            }
            $file_name = 'ssc_testimonial';
            if ($request->hasFile($file_name))
            {
                $path = $this->photo_path;
                deleteFile($admission->photo, $path);

                $admission->$file_name      = documentProcessUpload($request, $admission,$file_name, $path);
                $admission->save();
            }
//            $file_name = 'payment_img';
//            if ($request->hasFile($file_name))
//            {
//                $path = $this->photo_path;
//                deleteFile($admission->photo, $path);
//
//                $admission->$file_name      = documentProcessUpload($admission, $admission,$file_name, $path);
//                $admission->save();
//            }

            event(new CreatedContentEvent(ADMISSION_MODULE_SCREEN_NAME, $request, $admission));

            return response()->json(['status' => true,'id' => $admission->uuid , 'message' => trans('kamruldashboard::notices.update_success_message')]);
//            return $response
//                ->setPreviousUrl(URL::previous())
//                ->setNextUrl(route('admission_payment', $admission->uuid))
//                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (Exception $e){
            return response()->json(['status' => false, 'message' => trans('kamruldashboard::notices.something_error_please_try_again_later')]);
//            return $response
//                ->setPreviousUrl(URL::previous())
//                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Admission\Http\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function admission_search($id)
    {
        $admission = Admission::where('student_id',$id)->first();
        if (! $admission) {
            abort(404);
        }
        return $admission;
//        dd($admission);
    }
    public function admission_payment($id)
    {
        $admission = Admission::where('uuid',$id)->first();
        if (! $admission) {
            abort(404);
        }
//        dd($admission);
        SeoHelper::setTitle('Admission Payment');

//        $newses = AdminBoardHelper::getNewsFilter((int) theme_option('number_of_news_per_page') ?: 12, []);

//        theme_option('site_title','');
        $layout = MetaBox::getMetaData($admission, 'layout', true);
        $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//        dd($layout);
        Theme::uses(Theme::getThemeName())->layout(theme_option($layout, 'admin-default'));

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('adminboard::lang.adminnews'));
//        Theme::uses(Theme::getThemeName())->layout('other_page');
//        dd($projects);
//        dd($projects);

        return Theme::scope('admission.payment', compact('admission', 'id'), 'pag')->render();
    }
    public function admission_ssl_payment_success(Request $request)
    {
//        dd($request);
        $tran_id = $request->tran_id;
        $sslPayment = AdmissionSslPayment::where('tran_id', $tran_id)->first();
        if($sslPayment and $sslPayment->status == 0 ) {
            $ssl_val_id = $this->sslValidate_recheck($sslPayment->tran_id);

            $sslCommerce = AdmissionSslCommerce::create([
                'tran_id'                   => $ssl_val_id['element'][0]['tran_id'],
                'val_id'                    => $ssl_val_id['element'][0]['val_id'],
                'student_id'                => $ssl_val_id['element'][0]['value_b'],
                'status'                    => $ssl_val_id['element'][0]['status'],

                'message'                   => $ssl_val_id['element'][0]['error'],

                'tran_date'                 => $ssl_val_id['element'][0]['tran_date'],
                'amount'              => $ssl_val_id['element'][0]['amount'],
                'store_amount'              => $ssl_val_id['element'][0]['store_amount'],
                'currency'                  => $ssl_val_id['element'][0]['currency_type'],
                'bank_tran_id'              => $ssl_val_id['element'][0]['bank_tran_id'],
                'card_type'                 => $ssl_val_id['element'][0]['card_type'],
                'card_no'                   => $ssl_val_id['element'][0]['card_no'],
                'card_issuer'               => $ssl_val_id['element'][0]['card_issuer'],
                'card_brand'                => $ssl_val_id['element'][0]['card_brand'],
                'card_issuer_country'       => $ssl_val_id['element'][0]['card_issuer_country'],
                'card_issuer_country_code'  => $ssl_val_id['element'][0]['card_issuer_country_code'],
                'currency_type'             => $ssl_val_id['element'][0]['currency_type'],
                'currency_amount'           => $ssl_val_id['element'][0]['currency_amount'],
                'currency_rate'             => $ssl_val_id['element'][0]['currency_rate'],
                'base_fair'                 => $ssl_val_id['element'][0]['base_fair'],
                'emi_instalment'            => $ssl_val_id['element'][0]['emi_instalment'],
                'emi_amount'                => $ssl_val_id['element'][0]['emi_amount'],
                'emi_description'           => $ssl_val_id['element'][0]['emi_description'],
                'emi_issuer'                => $ssl_val_id['element'][0]['emi_issuer'],
                'risk_title'                => $ssl_val_id['element'][0]['risk_title'],
                'risk_level'                => $ssl_val_id['element'][0]['risk_level'],
                'discount_percentage'       => $ssl_val_id['element'][0]['discount_percentage'],
                'discount_remarks'          => $ssl_val_id['element'][0]['discount_remarks'],
                'discount_amount'          => $ssl_val_id['element'][0]['discount_amount'],
                'validated_on'              => $ssl_val_id['element'][0]['validated_on'],
                'inv_uuid'                  => $ssl_val_id['element'][0]['value_c'],

                'payment_type' => $request->value_a, // e.g. "SSLCommerz"
            ]);

            $admission = Admission::where('uuid', $ssl_val_id['element'][0]['value_c'])->first();
            $maxRoll = Admission::where('year', $admission->year)
                ->where('admission_group', $admission->admission_group)
                ->where('class', $admission->class)
                ->max('roll');

//            dd($maxRoll+1);
            Admission::where('uuid', $ssl_val_id['element'][0]['value_c'])
                ->update([
                    'payment_status' => 'paid',
                    'roll'           => $maxRoll + 1,
                ]);
//            dd($admission);
            AdmissionSslPayment::where('tran_id', $tran_id)
                ->update([
                    'val_id' => $request->val_id,
                    'status' => 1, // e.g. 1 for success, 0 for initial and 2 for cancel
                ]);
        }
//        dd($sslPayment);
        return redirect(route('admission_payment',$request->value_c))->with('success', 'Payment Successful!');
    }
    public function admission_ssl_payment_cancel(Request $request)
    {
        $tran_id = $request->tran_id;

//        dd($request);
        AdmissionSslPayment::where('tran_id', $tran_id)
            ->update([
//                'val_id' => $newValId, // your new val_id
                'status' => 2, // e.g. 1 for success, 0 for initial and 2 for cancel
            ]);
        $sslPayment = AdmissionSslPayment::where('tran_id', $tran_id)->first();
//        dd($sslPayment);
        $sslCommerce = AdmissionSslCommerce::create([
            'tran_id'      => $tran_id,
//            'val_id'       => null, // or actual value
            'student_id'   => $sslPayment->student_id,
            'status'       => $request->status,

            'message'       => $request->error,

            'tran_date'     => $request->tran_date,
            'store_amount'     => $request->amount,
            'currency'     => $request->currency,
            'bank_tran_id'     => $request->bank_tran_id,
            'card_type'     => $request->card_type,
            'card_no'     => $request->card_no,
            'card_issuer'     => $request->card_issuer,
            'card_brand'     => $request->card_brand,
            'card_issuer_country'     => $request->card_issuer_country,
            'card_issuer_country_code'     => $request->card_issuer_country_code,
            'currency_type'     => $request->currency_type,
            'currency_amount'     => $request->currency_amount,
            'currency_rate'     => $request->currency_rate,
            'base_fair'     => $request->base_fair,
//            'emi_instalment'     => $request->emi_instalment,
//            'emi_amount'     => $request->emi_amount,
//            'emi_description'     => $request->emi_description,
//            'emi_issuer'     => $request->emi_issuer,
//            'risk_title'     => $request->risk_title,
//            'risk_level'     => $request->risk_level,
//            'discount_percentage'     => $request->discount_percentage,
//            'discount_remarks'     => $request->discount_remarks,
//            'validated_on'     => $request->validated_on,
            'inv_uuid'     => $request->value_c,

            'payment_type' => $request->value_a, // e.g. "SSLCommerz"
        ]);
        return redirect(route('admission_payment',$request->value_c))->with('error', 'Payment Cancel!');
//        dd($sslCommerce);
    }
    public function admission_ssl_payment_fail(Request $request)
    {
        $tran_id = $request->tran_id;

//        dd($request);
        AdmissionSslPayment::where('tran_id', $tran_id)
            ->update([
//                'val_id' => $newValId, // your new val_id
                'status' => 3, // e.g. 1 for success, 0 for initial and 2 for cancel, 3 for fail
            ]);
        $sslPayment = AdmissionSslPayment::where('tran_id', $tran_id)->first();
//        dd($sslPayment);
        $sslCommerce = AdmissionSslCommerce::create([
            'tran_id'      => $tran_id,
//            'val_id'       => null, // or actual value
            'student_id'   => $sslPayment->student_id,
            'status'       => $request->status,

            'message'       => $request->error,

            'tran_date'     => $request->tran_date,
            'store_amount'     => $request->amount,
            'currency'     => $request->currency,
            'bank_tran_id'     => $request->bank_tran_id,
            'card_type'     => $request->card_type,
            'card_no'     => $request->card_no,
            'card_issuer'     => $request->card_issuer,
            'card_brand'     => $request->card_brand,
            'card_issuer_country'     => $request->card_issuer_country,
            'card_issuer_country_code'     => $request->card_issuer_country_code,
            'currency_type'     => $request->currency_type,
            'currency_amount'     => $request->currency_amount,
            'currency_rate'     => $request->currency_rate,
            'base_fair'     => $request->base_fair,
//            'emi_instalment'     => $request->emi_instalment,
//            'emi_amount'     => $request->emi_amount,
//            'emi_description'     => $request->emi_description,
//            'emi_issuer'     => $request->emi_issuer,
//            'risk_title'     => $request->risk_title,
//            'risk_level'     => $request->risk_level,
//            'discount_percentage'     => $request->discount_percentage,
//            'discount_remarks'     => $request->discount_remarks,
//            'validated_on'     => $request->validated_on,
            'inv_uuid'     => $request->value_c,

            'payment_type' => $request->value_a, // e.g. "SSLCommerz"
        ]);
        return redirect(route('admission_payment',$request->value_c))->with('error', 'Payment Fail!');
    }
    public function admission_ssl_payment(Request $request)
    {
        $admission = Admission::where('uuid', $request->ref_id)->first();
        if (! $admission) {
            abort(404);
        }
        if (! $admission->payment_amount > 5) {
            abort(404);
        }
////        $url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
//        $url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";


        try {
            $tranId = 'SSDC_' . round(microtime(true) * 1000) . '_' . rand(100000, 999999);


            $sslPayment = AdmissionSslPayment::create([
                'tran_id'      => $tranId,
                'val_id'       => null, // or actual value
                'student_id'   => $admission->student_id, // your student ID variable
                'amount'       => $admission->payment_amount, // payment amount
                'inv_uuid'     => $admission->uuid, // unique invoice UUID
                'payment_type' => 'Admission', // e.g. "SSLCommerz"
                'status'       => 0, // or "paid", "failed" etc.
            ]);
//            if ($sslPayment) {
//
//            }
            $data = [
//                'store_id'         => 'ssdcniledubdlive',
//                'store_passwd'     => '68749D8CEEE2515917',
                'store_id'         => 'gcdniledubdlive',
                'store_passwd'     => '689B21D91232448886',
                'total_amount'     => $admission->payment_amount,
//                'total_amount'     => 10,
                'currency'         => 'BDT',
                'tran_id'          => $tranId,
                'success_url'      => url('admission_ssl_payment_success'),
                'fail_url'         => url('admission_ssl_payment_fail'),
                'cancel_url'       => url('admission_ssl_payment_cancel'),
                'cus_name'         => $admission->name,
                'cus_email'        => 'sonaroy.songolshi@gmail.com',
                'cus_add1'         => 'Sonaroy sangalshi',
                'cus_add2'         => 'Nilphamari',
                'cus_city'         => 'Nilphamari',
                'cus_state'        => 'Nilphamari',
                'cus_postcode'     => '5300',
                'cus_country'      => 'Bangladesh',
                'cus_phone'        => $admission->phone ??'01711111111',
                'cus_fax'          => '01711111111',
                'ship_name'        => $admission->name,
                'ship_add1'        => 'Sonaroy sangalshi',
                'ship_add2'        => 'Nilphamari',
                'ship_city'        => 'Nilphamari',
                'ship_state'       => 'Nilphamari',
                'ship_postcode'    => '5300',
                'ship_country'     => 'Bangladesh',
    //            'multi_card_name'  => 'mastercard,visacard,amexcard',
                'value_a'          => 'Admission',
                'value_b'          => $admission->student_id,
                'value_c'          => $admission->uuid,
                'value_d'          => '',
            ];
            $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $direct_api_url );
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1 );
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


            $content = curl_exec($handle );

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if($code == 200 && !( curl_errno($handle))) {
                curl_close( $handle);
                $sslcommerzResponse = $content;
            } else {
                curl_close( $handle);
                echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                exit;
            }
            $sslcz = json_decode($sslcommerzResponse, true );

            if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
                echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                # header("Location: ". $sslcz['GatewayPageURL']);
                exit;
            } else {
                echo "JSON Data parsing error!";
            }
        }catch (Exception $e){
            Log::error($e->getMessage());
            return redirect()->back();
        }
    }
    public function sslValidate_recheck($tran_id)
    {
//        $store_id = 'ssdcniledubdlive';
//        $store_passwd = '68749D8CEEE2515917';
        $store_id         = 'gcdniledubdlive';
        $store_passwd     = '689B21D91232448886';
//        $store_id = 'appda686e5ea255235';
//        $store_passwd = 'appda686e5ea255235@ssl';
        $url = "https://securepay.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php";
//        $url = '{$this->ssl_url}/validator/api/validationserverAPI.php?wsdl';


        $query = http_build_query([
            'tran_id'       => $tran_id,
            'store_id'      => $store_id,
            'store_passwd'  => $store_passwd,
            'format'        => 'json'
        ]);

        $fullUrl = $url . '?' . $query;

        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HEADER, true);  // optional: get headers too
//        curl_setopt($ch, CURLOPT_VERBOSE, true); // optional: for debugging
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // optional: 5 seconds timeout
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // NOTE: In production, consider setting this to true

        $result = curl_exec($ch);
//        echo '<pre>';
//        print_r($result);
//        exit;
        if ($result === false) {
            log_message('error', 'SSLCommerz CURL Error: ' . curl_error($ch));
            curl_close($ch);
            return ['error' => 'CURL_FAILED'];
        }

        curl_close($ch);

        $res = json_decode($result, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'SSLCommerz JSON Decode Error: ' . json_last_error_msg());
            return ['error' => 'JSON_DECODE_FAILED'];
        }

        return $res;
    }
    public function admission_show($id)
    {
      //  if (!auth()->user()->can('admission_show')) {
   //         abort(403, 'Unauthorized action.');
   //     }
        page_title()->setTitle(trans('admission::lang.admission_show'));
        $admission = Admission::where('uuid', $id)->first();
//        dd($admission);
        $data = array();
        $data['admission']        = $id;
        $data['record']        = $this->admissionRepository->findOrFail($admission->id);
        $data['payment']        = AdmissionSslPayment::where('inv_uuid', $admission->uuid)->where('status',1)->first();
        $data['title']        = 'admission_show';
// Specify the path to the Bangla font file
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $fontPath = public_path('vendor/Modules/KamrulDashboard/fonts');
        $mpdf = new Mpdf([
            'format'        => 'A4',
            'orientation'   => 'p',
            'fontDir'       => array_merge($fontDirs, [$fontPath]),
            'fontdata' => $fontData + [
                "solaimanlipi" => [
                    'R' => 'SolaimanLipi.ttf',
                    'useOTL' => 0xFF,
                ],
                'rupali' => [
                    'R' => "Rupali.ttf",
                    'useOTL' => 0xFF,
                ],
                'nikosh' => [
                    'R' => 'Nikosh.ttf',
                    'useOTL' => 0xFF,
                ],
            ],
            'default_font' => 'nikosh'
        ]);
        $mpdf->AddPageByArray([
            'margin-left' => 10,
            'margin-right' => 10,
            'margin-top' => 15,
            'margin-bottom' => 10,
        ]);
//        $mpdf->SetMargins(1, 1, 3);
        $mpdf->SetFont('rupali');
        $html = view('admission::admission.admission_pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output("$admission->name" . ".pdf", 'I');
    }
    /**
     * Show the specified resource.
     * @param  Admission\Http\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function show(Admission $admission)
    {
        if (!auth()->user()->can('admission_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission_show'));
        $data = array();
        $data['admission']        = $admission;
        $data['title']        = 'admission_show';
        return view('admission::admission.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Admission\Http\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function pdf(Admission $admission)
    {
        if (!auth()->user()->can('admission_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission_show'));
        $data = array();
        $data['admission']        = $admission;
        $data['title']        = 'admission_show';
        return view('admission::admission.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Admission\Http\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function edit(Admission $admission)
    {
        if (!auth()->user()->can('admission_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admission_edit'));
        $data = array();
        $data['title']        = 'admission_edit';
        $data['record']        = $this->admissionRepository->findOrFail($admission->id);

        $data['subject_list'] = [];
        $sets = Option::getSetClassSubject($admission->class, $admission->admission_group);
        foreach ($sets as $setId => $value) {
            $subjects = OptionSet::find($value->id)->subjects()->pluck('option_subjects.name', 'option_subjects.id');
            $data['subject_list'][] = [
                'set_id' => $value->id,
                'set_name' => $value->name,
                'subjects' => $subjects,
                'selected_subject_num' => $value->selected_subjects ?? 1
            ];
        }
//        dd($data);

        return view('admission::admission.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Admission\Http\Models\Admission  $admission
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admission  $admission, DboardHttpResponse $response, SaveSetSubjectsService $setSubjectsService)
    {
        if (!auth()->user()->can('admission_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admission->id;
        $admission = $this->admissionRepository->firstOrNew(compact('id'));
        $admission->fill($request->input());
//        dd($admission);
        $admission = $this->admissionRepository->createOrUpdate($admission);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admission->$file_name, $path);

            $admission->$file_name      = processUpload($request, $admission,$file_name,$path);
            $admission->save();
        }
        $subjectData[] = array();
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'subjects_')) {
                $setId = str_replace('subjects_', '', $key);
                $subjectData[$setId] = $value; // $value is an array of IDs
            }
        }
//        dd($subjectData);
        $setSubjectsService->execute($admission, $subjectData);
        event(new UpdatedContentEvent(ADMISSION_MODULE_SCREEN_NAME, $request, $admission));
        return $response
            ->setPreviousUrl(route('admission.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy(Request $request, $id, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admission_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admission = $this->admissionRepository->findOrFail($id);
            $this->admissionRepository->delete($admission);

            event(new DeletedContentEvent(ADMISSION_MODULE_SCREEN_NAME, $request, $admission));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch ( \Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->admissionRepository, ADMISSION_MODULE_SCREEN_NAME);
    }
}
