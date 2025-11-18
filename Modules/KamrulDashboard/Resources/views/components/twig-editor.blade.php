@props([
    'variables' => [],
    'functions' => [],
    'value' => null,
    'name' => null,
    'mode' => 'html',
    'helperText' => null,
])

<div class="twig-template">
    <div class="mb-3 btn-list">
        @if (! empty($variables))
            <x-kamruldashboard::dropdown
                :label="__('Variables')"
                icon="ti ti-code"
            >
                @foreach ($variables as $key => $label)
                    <x-kamruldashboard::dropdown.item
                        data-bb-toggle="twig-variable"
                        :data-key="$key"
                    >
                        <span class="text-danger">{{ $key }}</span>: {{ trans($label) }}
                    </x-kamruldashboard::dropdown.item>
                @endforeach
            </x-kamruldashboard::dropdown>
        @endif

        @if (! empty($functions))
            <x-kamruldashboard::dropdown
                :label="__('Functions')"
                icon="ti ti-code"
            >
                @foreach ($functions as $key => $function)
                    <x-kamruldashboard::dropdown.item
                        data-bb-toggle="twig-function"
                        :data-key="$key"
                        :data-sample="$function['sample']"
                    >
                        <span class="text-danger">{{ $key }}</span>: {{ trans($function['label']) }}
                    </x-kamruldashboard::dropdown.item>
                @endforeach
            </x-kamruldashboard::dropdown>
        @endif
    </div>

    <x-kamruldashboard::form-group>
        <x-kamruldashboard::form.code-editor
            :name="$name"
            :value="$value"
            :mode="$mode"
        >
            <x-slot:helper-text>
                @if($helperText)
                    {{ $helperText }}
                @else
                    {!! BaseHelper::clean(
                        __('Learn more about Twig template: :url', [
                            'url' => Html::link('https://twig.symfony.com/doc/3.x/', null, ['target' => '_blank']),
                        ]),
                    ) !!}
                @endif
            </x-slot:helper-text>
        </x-kamruldashboard::form.code-editor>
    </x-kamruldashboard::form-group>
</div>
