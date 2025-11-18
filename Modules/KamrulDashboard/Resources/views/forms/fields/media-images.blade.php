
<x-kamruldashboard::form.field
    :showLabel="$showLabel"
    :showField="$showField"
    :options="$options"
    :name="$name"
    :prepend="$prepend ?? null"
    :append="$append ?? null"
    :showError="$showError"
    :nameKey="$nameKey"
>
    @php
//        dd($name);
    @endphp
    @include('kamruldashboard::forms.partials.images2', ['name' => $name,
                                                            'value' => Arr::get($options, 'value'),
                                                            'choices' => Arr::get($options, 'choices')
                                                         ])
</x-kamruldashboard::form.field>
