class Location {
    static getStates($el, countryId, $button = null) {
        $.ajax({
            url: $el.data('url'),
            data: {
                country_id: countryId,
            },
            type: 'GET',
            beforeSend: () => {
                $button && $button.prop('disabled', true);
            },
            success: res => {
                if (res.error) {
                    kamruldashboard.showError(res.message);
                } else {
                    let options = '';
                    $.each(res.data, (index, item) => {
                        options += '<option value="' + (item.id || '') + '">' + item.name + '</option>';
                    });

                    $el.html(options);
                }
            },
            complete: () => {
                $button && $button.prop('disabled', false);
            }
        });
    }

    static getCities($el, stateId, $button = null) {
        $.ajax({
            url: $el.data('url'),
            data: {
                state_id: stateId,
            },
            type: 'GET',
            beforeSend: () => {
                $button && $button.prop('disabled', true);
            },
            success: res => {
                if (res.error) {
                    kamruldashboard.showError(res.message);
                } else {
                    let options = '';
                    $.each(res.data, (index, item) => {
                        options += '<option value="' + (item.id || '') + '">' + item.name + '</option>';
                    });

                    $el.html(options);
                    $el.trigger('change');
                }
            },
            complete: () => {
                $button && $button.prop('disabled', false);
            }
        });
    }

    init() {

        const country = 'select[data-type="country"]';
        const state = 'select[data-type="state"]';
        const city = 'select[data-type="city"]';

        const per_country = 'select[data-type="per_country"]';
        const per_state = 'select[data-type="per_state"]';
        const per_city = 'select[data-type="per_city"]';

        $(document).on('change', country, function (e) {
            e.preventDefault();

            const $parent = getParent($(e.currentTarget));

            const $state = $parent.find(state);
            const $city = $parent.find(city);

            $state.find('option:not([value=""]):not([value="0"])').remove();
            $city.find('option:not([value=""]):not([value="0"])').remove();

            if ($state.length) {
                const val = $(e.currentTarget).val();
                if (val) {
                    const $button = $(e.currentTarget).closest('form').find('button[type=submit], input[type=submit]');
                    Location.getStates($state, val, $button);
                }
            }
        });

        $(document).on('change', state, function (e) {
            e.preventDefault();

            const $parent = getParent($(e.currentTarget));
            const $city = $parent.find(city);

            if ($city.length) {
                $city.find('option:not([value=""]):not([value="0"])').remove();
                const val = $(e.currentTarget).val();
                if (val) {
                    const $button = $(e.currentTarget).closest('form').find('button[type=submit], input[type=submit]');
                    Location.getCities($city, val, $button);
                }
            }
        });

        $(document).on('change', per_country, function (e) {
            e.preventDefault();

            const $per_parent = getParent($(e.currentTarget));

            const $per_state = $per_parent.find(per_state);
            const $per_city = $per_parent.find(per_city);

            $per_state.find('option:not([value=""]):not([value="0"])').remove();
            $per_city.find('option:not([value=""]):not([value="0"])').remove();

            if ($per_state.length) {
                const val = $(e.currentTarget).val();
                if (val) {
                    const $button = $(e.currentTarget).closest('form').find('button[type=submit], input[type=submit]');
                    Location.getStates($per_state, val, $button);
                }
            }
        });

        $(document).on('change', per_state, function (e) {
            e.preventDefault();

            const $per_parent = getParent($(e.currentTarget));
            const $per_city = $per_parent.find(per_city);

            if ($per_city.length) {
                $per_city.find('option:not([value=""]):not([value="0"])').remove();
                const val = $(e.currentTarget).val();
                if (val) {
                    const $button = $(e.currentTarget).closest('form').find('button[type=submit], input[type=submit]');
                    Location.getCities($per_city, val, $button);
                }
            }
        });
        function getParent($el) {
            let $parent = $(document);
            let formParent = $el.data('form-parent');
            if (formParent && $(formParent).length) {
                $parent = $(formParent);
            }

            return $parent;
        }
    }
}

$(() => {
    (new Location()).init();
});
