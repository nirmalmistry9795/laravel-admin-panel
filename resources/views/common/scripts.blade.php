<script>
    // Get countries
    function load_countries(id) {
        $("#" + id).select2({
            ajax: {
                url: "{{ route('getCountries') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        // branch_id: branch,
                        // type: type
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: "Select Country Name",
            allowClear: true
        });
    }

    // Get states
    function load_states(id, country_id = null) {
        $("#" + id).select2({
            ajax: {
                url: "{{ route('getStates') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        country_id: country_id,
                        // type: type
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: "Select State Name",
            allowClear: true
        });
    }

    // Get Cities
    function load_cities(id, state_id = null) {
        $("#" + id).select2({
            ajax: {
                url: "{{ route('getCities') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        state_id: state_id,
                        // type: type
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: "Select City Name",
            allowClear: true
        });
    }

    // Get pincodes
    function load_pincodes(id, city_id = null) {
        $("#" + id).select2({
            ajax: {
                url: "{{ route('getPincodes') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        city_id: city_id,
                        // type: type
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: "Select Pincode",
            allowClear: true
        });
    }

    $(document).ready(function() {
        setTimeout(function() {
            $('.alert-dismissible').hide();
        }, 3000);

    });
</script>
