<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Admission\Http\Models\Admission;
use Modules\Admission\Http\Models\AdmissionMerit;
use Modules\Admission\Http\Requests\AdmissionUpdateRollByRequest;
use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\Admission\Tables\AdmissionClassStudentTable;
use Modules\Admission\Tables\AdmissionClassTable;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Option\Tables\OptionClassTable;
use Exception;
use Mpdf\Mpdf;
use Throwable;
use Assets;

class AdmissionClassController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionClassInterface
     */
    protected $optionclassRepository;
    /**
     * @var AdmissionInterface
     */
    protected $admissionRepository;

    /**
     * OptionClassController constructor.
     * @param OptionClassInterface $optionclassRepository
     */
    public function __construct(OptionClassInterface $optionclassRepository, AdmissionInterface $admissionRepository)
    {
        $this->optionclassRepository = $optionclassRepository;
        $this->admissionRepository = $admissionRepository;
    }

    /**
     * @param OptionClassTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdmissionClassTable $dataTable)
    {
        if (!auth()->user()->can('admission_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionclass'));

        return $dataTable->renderTable();
    }
    /**
     * @param AdmissionClassStudentTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function getAllStudentList(AdmissionClassStudentTable $dataTable, $class, $year)
    {
        if (!auth()->user()->can('admission_access')) {
            abort(403, 'Unauthorized action.');
        }
        Assets::addScripts(['bootstrap3-editable'])
            ->addStyles(['bootstrap3-editable']);
        page_title()->setTitle(trans('admission::lang.admissionclassstudent'));

        return $dataTable->renderTable(['class_id' => $class, 'year_id' => $year]);
    }
    public function postUpdateRollby(AdmissionUpdateRollByRequest $request, DboardHttpResponse $response)
    {
        $admission = $this->admissionRepository->findOrFail($request->input('pk'));
        $admission->roll = $request->input('value', 0);
        $this->admissionRepository->createOrUpdate($admission);

        return $response->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }
    public function site_plan($class_id, $year_id)
    {
        //  if (!auth()->user()->can('admission_show')) {
        //         abort(403, 'Unauthorized action.');
        //     }
        page_title()->setTitle(trans('admission::lang.site_plan'));
//        $admission = Admission::where('class', $class_id)->where('year', $year_id)->whereRaw('roll NOT IN (0)')->get();
        $admission =  $this->admissionRepository->advancedGet([
            'condition' => [
                'class' => $class_id,
                'year' => $year_id,
                ['roll', 'NOT_IN', 0],
            ],
            'order_by'  => ['roll'=>'asc'],
//            'take'      => 1,
        ]);
//        dd($admission);
        $data = array();
//        $data['admission']        = $admission;
        $data['record']        = $admission;
        $data['title']        = 'site_plan';

//        return view('admission::admission.site_plan_pdf')->with('data',$data);
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
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 5,
            'margin-bottom' => 10,
        ]);
//        $mpdf->SetMargins(1, 1, 3);
        $mpdf->SetFont('nikosh');
        $html = view('admission::admission.site_plan', $data)->render();
        $mpdf->WriteHTML($html);
//        $mpdf->Cell(50,10,"ক্লাস: One",'LR',1,'C');
        $mpdf->Output("site-plan" . ".pdf", 'I');
    }
    public function merit_result($class_id, $year_id)
    {
        //  if (!auth()->user()->can('admission_show')) {
        //         abort(403, 'Unauthorized action.');
        //     }
        page_title()->setTitle(trans('admission::lang.site_plan'));
        $merit = AdmissionMerit::with('admissions')
            ->select('id', 'name')
            ->whereHas('admissions', function ($query) use($class_id, $year_id) {
                $query->where('year', $year_id)
                    ->where('class', $class_id);
            })
            ->get();;
//            ->join(
//                'admissions',
//                'admissions.admission_merits_id',
//                '=',
//                'admission_merits.id'
//            )->groupBy('admission_merits.id')->get();
//        $admission = Admission::where('class', $class_id)
//            ->where('year', $year_id)
//            ->whereRaw('roll NOT IN (0)')
//            ->whereRaw('admission_merits_id NOT IN (0)')
//            ->get();
//        $admission =  $this->admissionRepository->advancedGet([
//            'condition' => [
//                'class' => $class_id,
//                'year' => $year_id,
//                ['roll', 'NOT_IN', 0],
//                ['admission_merits_id', 'NOT_IN', 0],
//            ],
//            'order_by'  => ['roll'=>'asc'],
////            'take'      => 1,
//        ]);
//        dd($merit);
        $data = array();
//        $data['admission']        = $admission;
        $data['record']        = $merit;
        $data['class_id']        = $class_id;
        $data['year_id']        = $year_id;
        $data['title']        = 'site_plan';

//        return view('admission::admission.site_plan_pdf')->with('data',$data);
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
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 5,
            'margin-bottom' => 10,
        ]);
//        $mpdf->SetMargins(1, 1, 3);
        $mpdf->SetFont('nikosh');
        $html = view('admission::admission.merit_result', $data)->render();
        $mpdf->WriteHTML($html);
//        $mpdf->Cell(50,10,"ক্লাস: One",'LR',1,'C');
        $mpdf->Output("site-plan" . ".pdf", 'I');
    }
}
