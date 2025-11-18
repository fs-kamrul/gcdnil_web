
<div class="modal fade {{ $name }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-{{ $type }}">
                <h4 class="modal-title"><i class="icon-line2-tag"></i><strong> {{ $title }}</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body with-padding">
                <div>{!! $content !!}</div>
            </div>

            <div class="modal-footer">
                <button type="button" class="float-start btn btn-warning" data-dismiss="modal">{{ trans('kamruldashboard::lang.cancel') }}</button>
                <button class="float-end btn btn-{{ $type }} {{ Arr::get($action_button_attributes, 'class') }}" {!! Html::attributes(Arr::except($action_button_attributes, 'class')) !!}>{{ $action_name }}</button>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
