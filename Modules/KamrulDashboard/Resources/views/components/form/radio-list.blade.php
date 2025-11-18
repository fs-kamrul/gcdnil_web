@props([
    'id' => null,
    'label' => null,
    'labelHelperText' => null,
    'name' => null,
    'value' => null,
    'options' => [],
    'helperText' => null,
    'wrapperClass' => null,
])

<x-kamruldashboard::form-group :class="$wrapperClass">
    @if ($label)
        <x-kamruldashboard::form.label
            :label="$label"
            :for="$id"
            :helperText="$labelHelperText"
        />
    @endif
    <div class="position-relative form-check-group">
        @foreach ($options as $key => $option)
            <x-kamruldashboard::form.radio
                :name="$name"
                :value="$key"
                :checked="$key == $value"
                {{ $attributes }}
            >
                {{ $option }}
            </x-kamruldashboard::form.radio>
        @endforeach
    </div>
    @if ($helperText)
        <x-kamruldashboard::form.helper-text>{!! $helperText !!}</x-kamruldashboard::form.helper-text>
    @endif
</x-kamruldashboard::form-group>
