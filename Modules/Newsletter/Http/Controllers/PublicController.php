<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Newsletter\Events\SubscribeNewsletterEvent;
use Modules\Newsletter\Http\Models\Newsletter;
use Modules\Newsletter\Http\packages\NewsletterStatus;
use Modules\Newsletter\Http\Requests\NewsletterRequest;
use Modules\Newsletter\Repositories\Interfaces\NewsletterInterface;
use URL;

class PublicController extends Controller
{
    /**
     * @var NewsletterInterface
     */
    protected $newsletterRepository;

    /**
     * NewsletterController constructor.
     * @param NewsletterInterface $newsletterRepository
     */
    public function __construct(NewsletterInterface $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }
    protected $photo_path = 'uploads/newsletter/';


    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function postSubscribe(Request $request, DboardHttpResponse $response)
    {
        $validated = $request->validate([
            'email'              => 'email|required|max:255',
            'newsletter_agree'   => 'required',
        ],
            [
                'email.required' => __('An email address is required.'),
                'email.email' => __('Please enter a valid email address.'),
                'email.max' => __('The email address must be less than 255 characters.'),
                'newsletter_agree.required' => __('I agree to the user terms and email updates from HRDI.'),
            ]
        );
//            dd(json_decode($request->input('newsletter_agree')));
        if(!json_decode($request->input('newsletter_agree'))){
            return $response
                ->setError()
                ->setMessage('I agree to the user terms and email updates from HRDI.');
        }
        $newsletter = $this->newsletterRepository->getFirstBy(['email' => $request->input('email')]);
        if($request->input('course_id') == null){
            $course_id = 0;
        }else{
            $course_id = $request->input('course_id');
        }
        if (!$newsletter) {
            $newsletter = new Newsletter();
            $newsletter->product_id = $course_id;
            $newsletter->email = $request->input('email');
            $newsletter->save();
        }else{
            return $response
                ->setError()
                ->setMessage('The email has already been taken.!');
        }

        event(new SubscribeNewsletterEvent($newsletter));

        return $response->setMessage(__('Subscribe to newsletter successfully!'));
    }

    /**
     * Unsubscribe newsletter with token. change status to false
     * @param string $email
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function getUnsubscribe($id, Request $request, DboardHttpResponse $response)
    {
        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        $newsletter = $this->newsletterRepository->getFirstBy([
            'id' => $id,
            'status' => NewsletterStatus::SUBSCRIBED,
        ]);

        if ($newsletter) {
            $newsletter->status = NewsletterStatus::UNSUBSCRIBED;
            $this->newsletterRepository->createOrUpdate($newsletter);
            return $response
                ->setNextUrl(url('/'))
                ->setMessage(__('Unsubscribe to newsletter successfully'));
        }

        return $response
            ->setError()
            ->setNextUrl(url('/'))
            ->setMessage(__('Your email does not exist in the system or you have unsubscribed already!'));
    }
}
