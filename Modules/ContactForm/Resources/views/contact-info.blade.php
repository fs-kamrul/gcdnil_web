@if ($contact)
    <p>{{ trans('contactform::contact.tables.time') }}: <i>{{ $contact->created_at }}</i></p>
    <p>{{ trans('contactform::contact.tables.full_name') }}: <i>{{ $contact->name }}</i></p>
    <p>{{ trans('contactform::contact.tables.email') }}: <i><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i></p>
    <p>{{ trans('contactform::contact.tables.phone') }}: <i>@if ($contact->phone) <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a> @else N/A @endif</i></p>
    <p>{{ trans('contactform::contact.tables.address') }}: <i>{{ $contact->address ?: 'N/A' }}</i></p>
    <p>{{ trans('contactform::contact.tables.organization') }}: <i>{{ $contact->organization ?: 'N/A' }}</i></p>
    <p>{{ trans('contactform::contact.tables.date_time') }}: <i>{{ $contact->contact_data ?: 'N/A' }}, {{ $contact->contact_time ?: 'N/A' }}</i> </p>
{{--    <p>{{ trans('contactform::contact.tables.contact_time') }}: <i>{{ $contact->contact_time ?: 'N/A' }}</i></p>--}}
    <p>{{ trans('contactform::contact.tables.subject') }}: <i>{{ $contact->subject ?: 'N/A' }}</i></p>
    <p>{{ trans('contactform::contact.tables.content') }}:</p>
    <pre class="message-content">{{ $contact->content ?: '...' }}</pre>
@endif
