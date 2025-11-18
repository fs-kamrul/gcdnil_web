@include('table::partials.modal-item', [
    'type' => 'danger',
    'name' => 'modal-confirm-delete',
    'title' => trans('table::lang.confirm_delete'),
    'content' => trans('table::lang.confirm_delete_msg'),
    'action_name' => trans('table::lang.delete'),
    'action_button_attributes' => [
        'class' => 'delete-crud-entry',
    ],
])

@include('table::partials.modal-item', [
    'type' => 'danger',
    'name' => 'delete-many-modal',
    'title' => trans('table::lang.confirm_delete'),
    'content' => trans('table::lang.confirm_delete_many_msg'),
    'action_name' => trans('table::lang.delete'),
    'action_button_attributes' => [
        'class' => 'delete-many-entry-button',
    ],
])

@include('table::partials.modal-item', [
    'type' => 'info',
    'name' => 'modal-bulk-change-items',
    'title' => trans('table::lang.bulk_changes'),
    'content' => '<div class="modal-bulk-change-content"></div>',
    'action_name' => trans('table::lang.submit'),
    'action_button_attributes' => [
        'class' => 'confirm-bulk-change-button',
        'data-load-url' => route('tables.bulk-change.data'),
    ],
])
