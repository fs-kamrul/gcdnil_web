<x-kamruldashboard::alert type="warning">
    @if ($manageLicense = auth()->guard()->user()->can('kamruldashboard.manage.license'))
        <div>Your license is invalid. Please activate your license!</div>
    @else
        <div>You doesn't have permission to activate the license!</div>
    @endif
</x-kamruldashboard::alert>

<x-kamruldashboard::form.text-input
    label="Your username on kamruldashboard"
    name="buyer"
    id="buyer"
    placeholder="Your kamruldashboard's username"
    :disabled="!$manageLicense"
>
    <x-slot:helper-text>
        If your profile page is <a
            href="#"
            rel="nofollow"
        >xxxxxxxxx</a>, kamrul islam
        <strong>john-smith</strong>.
    </x-slot:helper-text>
</x-kamruldashboard::form.text-input>

<x-kamruldashboard::form.text-input
    label="Purchase code"
    name="purchase_code"
    id="purchase_code"
    :disabled="!$manageLicense"
    placeholder="Ex: 10101000-0101-0100-0010-001101000010"
>
    <x-slot:helper-text>
        <a
            href="#"
            target="_blank"
        >What's this?</a>
    </x-slot:helper-text>
</x-kamruldashboard::form.text-input>

<x-kamruldashboard::form.on-off.checkbox
    name="license_rules_agreement"
    id="licenseRulesAgreement"
    :disabled="!$manageLicense"
>
    Confirm that, according to the kamruldashboard License Terms, each license entitles one person for a single
    project. Creating multiple unregistered installations is a copyright violation.
    <a
        href="#"
        target="_blank"
        rel="nofollow"
    >More info</a>.
</x-kamruldashboard::form.on-off.checkbox>

<x-kamruldashboard-setting::form-group>
    <x-kamruldashboard::button
        type="submit"
        color="primary"
        :disabled="!$manageLicense"
    >
        Activate license
    </x-kamruldashboard::button>

    <div class="form-hint">
        <a
            href="{{ $licenseURL = Modules\kamruldashboard::make()->getLicenseUrl() }}"
            target="_blank"
            class="d-inline-block mt-2"
        > Need reset your license?
        </a> <span class="text-body">Please log in to our <a href="{{ $licenseURL }}" target="_blank">customer license manager site</a> to reset your license.</span>
    </div>

</x-kamruldashboard-setting::form-group>

<div>
    <p class="text-danger">Note: Your site IP will be added to blacklist after 5 failed attempts.</p>

    <p>
        A purchase code (license) is only valid for One Domain. Are you using this theme on a new domain?
        Purchase a
        <a
            href="{{ Modules\kamruldashboard::make()->getLicenseUrl('/buy') }}"
            target="_blank"
            rel="nofollow"
        >
            new license here
        </a>
        to get a new purchase code.
    </p>
</div>
