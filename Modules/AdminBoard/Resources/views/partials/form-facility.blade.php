@foreach ($educations as $education)
    <x-kamruldashboard::form.checkbox
        :label="$education->name"
        name="educations[]"
        :value="$education->id"
        :checked="in_array($education->id, $selectedEducations->toArray())"
        inline
    />
@endforeach
