@if ($contact)
    <div id="reply-wrapper">
        @if (count($contact->replies) > 0)
            @foreach($contact->replies as $reply)
                <p>{{ trans('contactform::contact.tables.time') }}: <i>{{ $reply->created_at }}</i></p>
                <p>{{ trans('contactform::contact.tables.content') }}:</p>
                <pre class="message-content">{!! DboardHelper::clean($reply->message) !!}</pre>
            @endforeach
        @else
            <p>{{ trans('contactform::contact.no_reply') }}</p>
        @endif
    </div>

    <p><button class="btn btn-info answer-trigger-button">{{ trans('contactform::contact.reply') }}</button></p>

    <div class="answer-wrapper">
        <div class="form-group mb-3">
            <input type="hidden" name="input_contact_id" value="{{ $contact->id }}">
            <textarea id="message" name="message" class="form-control"></textarea>
        </div>

        <div class="form-group mb-3">
            <input type="hidden" value="{{ $contact->id }}" id="input_contact_id">
            <button class="btn btn-success answer-send-button"><i class="fas fa-reply"></i> {{ trans('contactform::contact.send') }}</button>
        </div>
    </div>
@endif
