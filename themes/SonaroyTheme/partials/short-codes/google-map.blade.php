<div class="column block mt-3">
    <h5 class="bk-org title">
        {{ addslashes($shortcode->title) }}
    </h5>
    <iframe src="https://maps.google.com/maps?q={{ addslashes($address) }}&output=embed"
            width="718"
            height="450"
            frameborder="0"
            style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>
