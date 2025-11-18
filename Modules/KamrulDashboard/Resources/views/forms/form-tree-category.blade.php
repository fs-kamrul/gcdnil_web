@extends($layout ?? DboardHelper::getAdminMasterLayoutTemplate())
{{--@extends(DboardHelper::getAdminMasterLayoutTemplate())--}}

@section('content')
    @php
        $categories = $form->getFormOption('categories', collect());
        $canCreate = $form->getFormOption('canCreate');
        $canEdit = $form->getFormOption('canEdit');
        $canDelete = $form->getFormOption('canDelete');
        $indexRoute = $form->getFormOption('indexRoute');
        $createRoute = $form->getFormOption('createRoute');
        $editRoute = $form->getFormOption('editRoute');
        $deleteRoute = $form->getFormOption('deleteRoute');
        $updateTreeRoute = $form->getFormOption('updateTreeRoute');

        Assets::addStyles('jquery-nestable')->addScripts('jquery-nestable');
    @endphp

    <div class="row row-cards">
        <div class="col-12">
            <div class="my-2 text-end">
                @php
                    do_action(BASE_ACTION_META_BOXES, 'head', $form->getModel());
                @endphp
            </div>
        </div>

        <div class="col-md-4">
            <x-kamruldashboard::alert type="info">
                {{ trans('kamruldashboard::tree-category.drag_drop_info') }}
            </x-kamruldashboard::alert>

            <x-kamruldashboard::card class="tree-categories-container">
                <x-kamruldashboard::card.header>
                    <x-kamruldashboard::card.actions>
                        @if($createRoute)
                            <x-kamruldashboard::button
                                tag="a"
                                type="button"
                                color="primary"
                                :href="route($createRoute)"
                                icon="ti ti-plus"
                                class="tree-categories-create mx-2"
{{--                                @class(['tree-categories-create mx-2', 'd-none' => !$canCreate])--}}
                            >
                                {{ trans('kamruldashboard::forms.create') }}
                            </x-kamruldashboard::button>
                        @endif
                    </x-kamruldashboard::card.actions>
                </x-kamruldashboard::card.header>
                <x-kamruldashboard::card.body class="tree-categories-body">
                    <div
                        class="file-tree-wrapper"
                        data-url="{{ $indexRoute ? route($indexRoute) : '' }}"
                        @if($updateTreeRoute)
                            data-update-url="{{ route($updateTreeRoute) }}"
                        @endif
                    >
                        @include('kamruldashboard::forms.partials.tree-categories', compact('categories'))
                    </div>
                </x-kamruldashboard::card.body>
            </x-kamruldashboard::card>
        </div>

        <div class="col-md-8">
            <x-kamruldashboard::card class="tree-form-container">
                <x-kamruldashboard::card.body class="tree-form-body">
                    @include('kamruldashboard::forms.form-no-wrap')
                </x-kamruldashboard::card.body>
            </x-kamruldashboard::card>
        </div>
    </div>
@endsection

@push('footer')
    <x-kamruldashboard::modal.action
        type="danger"
        class="modal-confirm-delete"
        :title="trans('kamruldashboard::tree-category.delete_modal.title')"
        :description="trans('kamruldashboard::tree-category.delete_modal.message')"
        :submit-button-label="trans('kamruldashboard::tree-category.delete_button')"
        :submit-button-attrs="['data-bb-toggle' => 'modal-confirm-delete']"
    />
@endpush
