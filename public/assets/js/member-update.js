
document.getElementById('tin_number').addEventListener('blur', function() {
  if (!this.checkValidity()) {
    this.reportValidity(); // show the browser’s built-in popup immediately
  }
});

$(document).ready(function() {

    $(document).on('select2:open', function() {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    });

    // ------------------------------
    // REGION
    // ------------------------------
    $('#region').select2({
        placeholder: 'Select Region',
        width: '100%',
        ajax: {
            url: '/api/address/regions',
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(item =>
                    item.name.toLowerCase().includes(term)
                );
                return {
                    results: filtered.map(item => ({
                        id: item.code || item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // ------------------------------
    // PROVINCE
    // ------------------------------
    $('#province').select2({
        placeholder: 'Select Province',
        width: '100%',
        ajax: {
            url: '/api/address/provinces',
            data: function () {
                return { region: $('#region').val() };
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(item =>
                    item.name.toLowerCase().includes(term)
                );
                return {
                    results: filtered.map(item => ({
                        id: item.province_id || item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // ------------------------------
    // CITY
    // ------------------------------
    $('#city').select2({
        placeholder: 'Select City',
        width: '100%',
        ajax: {
            url: function () {
                return '/api/address/cities/' + ($('#province').val() || 0);
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(item =>
                    item.name.toLowerCase().includes(term)
                );
                return {
                    results: filtered.map(item => ({
                        id: item.city_id || item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // ------------------------------
    // BARANGAY
    // ------------------------------
    $('#barangay').select2({
        placeholder: 'Select Barangay',
        width: '100%',
        ajax: {
            url: function () {
                return '/api/address/barangays/' + ($('#city').val() || 0);
            },
            processResults: function (data, params) {
                var term = (params.term || '').toLowerCase();
                var filtered = data.filter(item =>
                    item.name.toLowerCase().includes(term)
                );
                return {
                    results: filtered.map(item => ({
                        id: item.code || item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // ------------------------------
    // CASCADE RESET
    // ------------------------------
    $('#region').on('change', function () {
        $('#province, #city, #barangay').val(null).trigger('change');
    });
    $('#province').on('change', function () {
        $('#city, #barangay').val(null).trigger('change');
    });
    $('#city').on('change', function () {
        $('#barangay').val(null).trigger('change');
    });

    // ------------------------------
    // PRELOAD SELECTIONS (CHAINED PROMISES)
    // ------------------------------
    function preloadRegion() {
        return new Promise((resolve) => {
            if (window.userRegion && window.userRegion.id) {
                $.ajax({
                    url: '/api/address/regions',
                    type: 'GET',
                    success: function (data) {
                        const region = data.find(r =>
                            r.code == window.userRegion.id || r.id == window.userRegion.id
                        );
                        if (region) {
                            let option = new Option(region.name, region.code || region.id, true, true);
                            $('#region').append(option).trigger('change');
                        }
                        resolve();
                    }
                });
            } else resolve();
        });
    }

    function preloadProvince() {
        return new Promise((resolve) => {
            if (window.userProvince && window.userProvince.id) {
                $.ajax({
                    url: '/api/address/provinces',
                    type: 'GET',
                    data: { region: $('#region').val() },
                    success: function (data) {
                        const province = data.find(p =>
                            p.province_id == window.userProvince.id || p.id == window.userProvince.id
                        );
                        if (province) {
                            let option = new Option(province.name, province.province_id || province.id, true, true);
                            $('#province').append(option).trigger('change');
                        }
                        resolve();
                    }
                });
            } else resolve();
        });
    }

    function preloadCity() {
        return new Promise((resolve) => {
            if (window.userCity && window.userCity.id) {
                $.ajax({
                    url: '/api/address/cities/' + ($('#province').val() || 0),
                    type: 'GET',
                    success: function (data) {
                        const city = data.find(c =>
                            c.city_id == window.userCity.id || c.id == window.userCity.id
                        );
                        if (city) {
                            let option = new Option(city.name, city.city_id || city.id, true, true);
                            $('#city').append(option).trigger('change');
                        }
                        resolve();
                    }
                });
            } else resolve();
        });
    }

    function preloadBarangay() {
        return new Promise((resolve) => {
            if (window.userBarangay && window.userBarangay.id) {
                $.ajax({
                    url: '/api/address/barangays/' + ($('#city').val() || 0),
                    type: 'GET',
                    success: function (data) {
                        const barangay = data.find(b =>
                            b.code == window.userBarangay.id || b.id == window.userBarangay.id
                        );
                        if (barangay) {
                            let option = new Option(barangay.name, barangay.code || barangay.id, true, true);
                            $('#barangay').append(option).trigger('change');
                        }
                        resolve();
                    }
                });
            } else resolve();
        });
    }

    // Run in sequence to ensure proper hierarchy
    preloadRegion()
        .then(preloadProvince)
        .then(preloadCity)
        .then(preloadBarangay);


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

        // ? Set default to Philippines (PH)
        $('#country_name').val('PH').trigger('change');
    });

    
    if($('.gender').length > 0)
    {
        $('.gender').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }
    if($('.country_code').length > 0)
    {
        $('.country_code').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.member_chapter').length > 0)
    {
        $('.member_chapter').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    
});

$('#member-info-update-form').submit(function(e) {
    e.preventDefault();


    Swal.fire({
        customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to update your information?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
  }).then((result) => {
    if (result.isConfirmed) {
        var url = $( "#urlMemberInfoUpdate" ).val();
        var token = $( "#token2" ).val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });


    
        var formData = new FormData(this);

        
        formData.append('pps_no',$( "#pps_no" ).val());
        formData.append('user_id',$( "#user_id" ).val());
        formData.append('first_name',$( "#first_name" ).val());
        formData.append('middle_name',$( "#middle_name" ).val());
        formData.append('last_name',$( "#last_name" ).val());
        formData.append('suffix',$( "#suffix" ).val());
        formData.append('birthdate',$( "#birthdate" ).val());
        formData.append('gender',$( "#gender" ).val());
        formData.append('telephone_number',$( "#telephone_number" ).val());
        formData.append('country_code',$( "#country_code" ).val());
        formData.append('mobile_number',$( "#mobile_number" ).val());
        formData.append('email_address',$( "#email_address" ).val());
        formData.append('prc_number',$( "#prc_number" ).val());
        formData.append('prc_registration_dt',$( "#prc_registration_dt" ).val());
        formData.append('prc_validity',$( "#prc_validity" ).val());
        formData.append('pma_number',$( "#pma_number" ).val());
        formData.append('member_chapter',$( "#member_chapter" ).val());
        formData.append('id',$( "#infoids" ).val());

        formData.append('tin_number',$( "#tin_number" ).val());
        formData.append('house_number',$( "#house_number" ).val());
        formData.append('street_name',$( "#street_name" ).val());
        formData.append('region_id',$( "#region" ).val());
        formData.append('province_id',$( "#province" ).val());
        formData.append('city_id',$( "#city" ).val());
        formData.append('barangay_id',$( "#barangay" ).val());
        formData.append('postal_code',$( "#postal_code" ).val());

        
        

        formData.append('region_name',   $('#region').select2('data')[0]?.text || null);
        formData.append('province_name', $('#province').select2('data')[0]?.text || null);
        formData.append('city_name',     $('#city').select2('data')[0]?.text || null);
        formData.append('barangay_name', $('#barangay').select2('data')[0]?.text || null);
        formData.append('country_text', $('#country_name').val()); // e.g. "PH"
        formData.append('country_name', $('#country_name').select2('data')[0]?.text || null); // e.g. "Philippines"


        
        

    
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                
                if(data=="success")
                {
                    Swal.fire({
                        title: "Saved!",
                        text: "Member information successfully update.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                            
                        }
                        else{
                            location.reload();
                        }
                    });
                }
                else
                {
                    Swal.fire({
                        title: "Warning!",
                        text: "Email already taken, please try another one.",
                        icon: "warning",
                        confirmButtonText: "Okay"
                      })
                }
         
        
            },
            error: function(data) {
                // console.log(data);
            }
        });
    }

  });


  
});


$('#user-update-image').submit(function(e) {
    e.preventDefault();

    if (document.getElementById("file-input-profile").files.length == 0) {
        notif.showNotification('top', 'right', 'Warning, please upload picture!', 'warning');
        document.getElementById("file-input-profile").focus();
    }
    else
    {
        Swal.fire({

            customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger"
            },
            buttonsStyling: !1,
            
            title: "Are you sure?",
            text: "You want to update your image?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
            
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loading2").fadeIn();
                var token = $("#token").val();
                var url = $( "#urlUserMaintenanceUpdateImage" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
    
                var picture = $('#file-input-profile').prop('files')[0];
    
                var formData = new FormData(this);
                        
                formData.append('pps_no',$( "#pps_no" ).val());
                formData.append('picture', picture);
    
    
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#loading2").fadeOut();
                        Swal.fire({
                            title: "Saved!",
                            text: "User image successfully updated",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                                
                            }
                            else{
                                location.reload();
                            }
                        });
    
                    },
                    error: function(data) {
                        $("#loading2").fadeOut();
                        Swal.fire({
                            title: "Warning!",
                            text: "Something error",
                            icon: "error",
                            confirmButtonText: "Okay"
                        })
                    }
                });
    
    
            }
        });
        
    } 



});



