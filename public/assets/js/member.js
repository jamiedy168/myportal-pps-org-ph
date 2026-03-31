document.getElementById('tin_number').addEventListener('blur', function() {
  if (!this.checkValidity()) {
    this.reportValidity(); // show the browser’s built-in popup immediately
  }
});

$(document).ready(function () {



    // Region
    $('#region').select2({
        placeholder: 'Select Region',
        width: '100%',   // ✅ make responsive
        ajax: {
            url: '/api/address/regions',
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(function (item) {
                    return item.name.toLowerCase().includes(term);
                });
                return {
                    results: filtered.map(item => ({
                        id: item.code,
                        text: item.name
                    }))
                };
            }
        }
    });

    // Province
    $('#province').select2({
        placeholder: 'Select Province',
        width: '100%',   // ✅ make responsive
        ajax: {
            url: '/api/address/provinces',
            data: function () {
                return {
                    region: $('#region').val()
                };
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(function (item) {
                    return item.name.toLowerCase().includes(term);
                });
                return {
                    results: filtered.map(item => ({
                        id: item.province_id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // City
    $('#city').select2({
        placeholder: 'Select City',
        width: '100%',   // ✅ make responsive
        ajax: {
            url: function () {
                return '/api/address/cities/' + $('#province').val();
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(function (item) {
                    return item.name.toLowerCase().includes(term);
                });
                return {
                    results: filtered.map(item => ({
                        id: item.city_id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // Barangay
    $('#barangay').select2({
        placeholder: 'Select Barangay',
        width: '100%',   // ✅ make responsive
        ajax: {
            url: function () {
                return '/api/address/barangays/' + $('#city').val();
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(function (item) {
                    return item.name.toLowerCase().includes(term);
                });
                return {
                    results: filtered.map(item => ({
                        id: item.code,
                        text: item.name
                    }))
                };
            }
        }
    });

    // 🔑 Auto-focus search field when dropdown opens
    $(document).on('select2:open', () => {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    });

    $.getJSON('https://restcountries.com/v3.1/all?fields=name,cca2', function (data) {
        let countries = data.map(item => ({
            id: item.cca2,         // ISO2 code
            text: item.name.common // country name
        }));

        $('#country_name').select2({
            placeholder: 'Select Country',
            data: countries,
            width: '100%',
            allowClear: true
        });

        // ✅ Set default to Philippines (PH)
        $('#country_name').val('PH').trigger('change');
    });


    $('#updateNewMemberInfoForm').on('submit', function (e) {
        e.preventDefault();

        var url = $("#urlUpdateNewInfoUrl").val();
        var token = $("#token").val();
        var member_type_id = parseInt($("#member_type_id").val(), 10);

        // Reset all required first
        $(".member_required").removeAttr("required");

        // If member_type_id is 2, 3, or 4 → make fields required
        if ([2, 3, 4].includes(member_type_id)) {
            $(".member_required").attr("required", true);
        }

        // Now check validity using built-in browser validation
        if (!this.checkValidity()) {
            this.reportValidity(); // show native error messages
            return false;
        }

        var form = this;

        // 🔹 Confirmation Swal
        Swal.fire({
                customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger"
            },
            buttonsStyling: !1,
            
            title: "Are you sure?",
            text: "All the details are correct?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                var formData = new FormData(form);

                // Add the display text from select2 fields
                formData.append('region_name',   $('#region').select2('data')[0]?.text || null);
                formData.append('province_name', $('#province').select2('data')[0]?.text || null);
                formData.append('city_name',     $('#city').select2('data')[0]?.text || null);
                formData.append('barangay_name', $('#barangay').select2('data')[0]?.text || null);
                formData.append('country_text', $('#country_name').val()); // e.g. "PH"
                formData.append('country_name', $('#country_name').select2('data')[0]?.text || null); // e.g. "Philippines"



                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        Swal.fire({
                            title: "Success!",
                            text: "Member info has been updated successfully.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            window.location.href = '/dashboard';
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        console.error(xhr.responseText);
                    }
                });

            }
        });
    });





});

