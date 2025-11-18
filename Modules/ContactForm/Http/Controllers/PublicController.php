<?php

namespace Modules\ContactForm\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactForm\Events\SentContactEvent;
use Modules\ContactForm\Http\Requests\ContactRequest;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use EmailHandler;

class PublicController extends Controller
{
    /**
     * @var ContactInterface
     */
    protected $contactRepository;

    /**
     * @param ContactInterface $contactRepository
     */
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param ContactRequest $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Throwable
     */
    public function postSendContact(ContactRequest $request, DboardHttpResponse $response)
    {
        try {
            $contact = $this->contactRepository->getModel();
            $contact->fill($request->input());
            $this->contactRepository->createOrUpdate($contact);

            event(new SentContactEvent($contact));

            if ($contact->name && $contact->email) {
                $args = ['replyTo' => [$contact->name => $contact->email]];
            }

//            EmailHandler::setModule(CONTACT_MODULE_SCREEN_NAME)
//                ->setVariableValues([
//                    'contact_name'    => $contact->name ?? 'N/A',
//                    'contact_subject' => $contact->subject ?? 'N/A',
//                    'contact_email'   => $contact->email ?? 'N/A',
//                    'contact_phone'   => $contact->phone ?? 'N/A',
//                    'contact_address' => $contact->address ?? 'N/A',
//                    'contact_content' => $contact->content ?? 'N/A',
//                ])
//                ->sendUsingTemplate('notice', null, $args);

            return $response->setMessage(__('Send message successfully!'));
        } catch (Exception $exception) {
            info($exception->getMessage());
            return $response
                ->setError()
                ->setMessage(__('Can\'t send message on this time, please try again later!'));
        }
    }
}
