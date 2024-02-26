<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />


    @php
        $title = ucwords(str_replace('.', '-', request()->route()->getName()));
        $title = ucwords(str_replace('-', ' ', $title));
    @endphp

    <title>lpt - {{ $title }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/assets/images/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.min.js"></script> -->

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />



    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/codenepal.css') }}" /> -->


    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" integrity="sha512-2eMmukTZtvwlfQoG8ztapwAH5fXaQBzaMqdljLopRSA0i6YKM8kBAOrSSykxu9NN9HrtD45lIqfONLII2AFL/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}




    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>



    <style>
        .invalid-validation-select {
            border-color: #ea5455;
            background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5 7.5L10 12.5L15 7.5' stroke='%236f6b7d' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3Cpath d='M5 7.5L10 12.5L15 7.5' stroke='white' stroke-opacity='0.2' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"),
            url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ea5455'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ea5455' stroke='none'/%3e%3c/svg%3e");
            background-position: right 0.875rem center, center right 2.45rem;
        }
    </style>

    @livewireStyles

  </head>

  <body>

    {{ $slot }}

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- <script src="{{ asset('assets/js/codenepal.js') }}"></script> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script> -->



    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js" integrity="sha512-vUJTqeDCu0MKkOhuI83/MEX5HSNPW+Lw46BA775bAWIp1Zwgz3qggia/t2EnSGB9GoS2Ln6npDmbJTdNhHy1Yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}





    @livewireScripts

    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sortablejs/sortable.js') }}"></script>

    <!--DropZone Upload File-->
    <!-- <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{asset('assets/js/forms-file-upload.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" /> -->

    <script>
        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
                confirmButtonText: event.detail[0].buttonText ?? 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.livewire.emit(event.detail[0].method, event.detail[0].id);
                }
            });
        });

        window.addEventListener('swal:success', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        });

        window.addEventListener('swal:error', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        });

        $('.flatpickr-date').flatpickr({
            monthSelectorType: 'static'
        });
    </script>

    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Success", {
                positionClass: "toast-top-right",
                progressBar: true,
                timeOut: 3000,
                extendedTimeOut: 2000,
                closeButton: true,
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}", "Error", {
                positionClass: "toast-top-right",
                progressBar: true,
                timeOut: 3000,
                extendedTimeOut: 2000,
                closeButton: true,
            });
        </script>
    @endif

    <script>
        // ! Removed following code if you do't wish to use jQuery. Remember that navbar search functionality will stop working on removal.
        if (typeof $ !== 'undefined') {
            $(function () {
                // ! TODO: Required to load after DOM is ready, did this now with jQuery ready.
                window.Helpers.initSidebarToggle();
                // Toggle Universal Sidebar

                // Navbar Search with autosuggest (typeahead)
                // ? You can remove the following JS if you don't want to use search functionality.
                //----------------------------------------------------------------------------------

                var searchToggler = $('.search-toggler'),
                    searchInputWrapper = $('.search-input-wrapper'),
                    searchInput = $('.search-input'),
                    contentBackdrop = $('.content-backdrop');

                // Open search input on click of search icon
                if (searchToggler.length) {
                    searchToggler.on('click', function () {
                        if (searchInputWrapper.length) {
                            searchInputWrapper.toggleClass('d-none');
                            searchInput.focus();
                        }
                    });
                }
                // Open search on 'CTRL+/'
                $(document).on('keydown', function (event) {
                    let ctrlKey = event.ctrlKey,
                        slashKey = event.which === 191;

                    if (ctrlKey && slashKey) {
                        if (searchInputWrapper.length) {
                            searchInputWrapper.toggleClass('d-none');
                            searchInput.focus();
                        }
                    }
                });
                // Todo: Add container-xxl to twitter-typeahead
                searchInput.on('focus', function () {
                    if (searchInputWrapper.hasClass('container-xxl')) {
                        searchInputWrapper.find('.twitter-typeahead').addClass('container-xxl');
                    }
                });

                if (searchInput.length) {
                    // Filter config
                    var filterConfig = function (data) {
                        return function findMatches(q, cb) {
                            let matches;
                            matches = [];
                            data.filter(function (i) {
                                if (i.name.toLowerCase().startsWith(q.toLowerCase())) {
                                    matches.push(i);
                                } else if (
                                    !i.name.toLowerCase().startsWith(q.toLowerCase()) &&
                                    i.name.toLowerCase().includes(q.toLowerCase())
                                ) {
                                    matches.push(i);
                                    matches.sort(function (a, b) {
                                        return b.name < a.name ? 1 : -1;
                                    });
                                } else {
                                    return [];
                                }
                            });
                            cb(matches);
                        };
                    };

                    // Search API AJAX call

                     var searchData = $.ajax({

                        url: "{{ route('pages') }}",
                        dataType: 'json',
                        async: false
                    }).responseJSON;

                    // Init typeahead on searchInput
                    searchInput.each(function () {
                        var $this = $(this);
                        searchInput
                            .typeahead(
                                {
                                    hint: false,
                                    classNames: {
                                        menu: 'tt-menu navbar-search-suggestion',
                                        cursor: 'active',
                                        suggestion: 'suggestion d-flex justify-content-between px-3 py-2 w-100'
                                    }
                                },
                                // ? Add/Update blocks as per need
                                // Pages
                                {
                                    name: 'pages',
                                    display: 'name',
                                    limit: 5,
                                    source: filterConfig(searchData.pages),
                                    templates: {
                                        header: '<h6 class="suggestions-header text-primary mb-0 mx-3 mt-3 pb-2">Pages</h6>',
                                        suggestion: function ({ url, icon, name }) {
                                            return (
                                                '<a href="' +
                                                url +
                                                '">' +
                                                '<div>' +
                                                '<i class="ti ' +
                                                icon +
                                                ' me-2"></i>' +
                                                '<span class="align-middle">' +
                                                name +
                                                '</span>' +
                                                '</div>' +
                                                '</a>'
                                            );
                                        },
                                        notFound:
                                            '<div class="not-found px-3 py-2">' +
                                            '<h6 class="suggestions-header text-primary mb-2">Pages</h6>' +
                                            '<p class="py-2 mb-0"><i class="ti ti-alert-circle ti-xs me-2"></i> No Results Found</p>' +
                                            '</div>'
                                    }
                                },
                            )
                            //On typeahead result render.
                            .bind('typeahead:render', function () {
                                // Show content backdrop,
                                contentBackdrop.addClass('show').removeClass('fade');
                            })
                            // On typeahead select
                            .bind('typeahead:select', function (ev, suggestion) {
                                // Open selected page
                                if (suggestion.url) {
                                    window.location = suggestion.url;
                                }
                            })
                            // On typeahead close
                            .bind('typeahead:close', function () {
                                // Clear search
                                searchInput.val('');
                                $this.typeahead('val', '');
                                // Hide search input wrapper
                                searchInputWrapper.addClass('d-none');
                                // Fade content backdrop
                                contentBackdrop.addClass('fade').removeClass('show');
                            });

                        // On searchInput keyup, Fade content backdrop if search input is blank
                        searchInput.on('keyup', function () {
                            if (searchInput.val() == '') {
                                contentBackdrop.addClass('fade').removeClass('show');
                            }
                        });
                    });

                    // Init PerfectScrollbar in search result
                    var psSearch;
                    $('.navbar-search-suggestion').each(function () {
                        psSearch = new PerfectScrollbar($(this)[0], {
                            wheelPropagation: false,
                            suppressScrollX: true
                        });
                    });

                    searchInput.on('keyup', function () {
                        psSearch.update();
                    });
                }
            });
        }
    </script>

    <!-- cropper -->
    <script>

        // document.addEventListener('DOMContentLoaded', function () {

        //     var $modal = $('#modal');
        //     var cropper;
        //     var image=document.getElementById('image');
        //     var ratio=0;
        //     var image_width=0;
        //     var image_height=0;
        //     var image_count=0;

        //     // const uploadInput = document.getElementById('image_test');

        //     $(".crop_image").on('change', function (e) {

        //         image_width=$(this).attr("width");
        //         image_height=$(this).attr("height");
        //         image_count=$(this).attr("count");

        //         ratio=parseInt(image_width)/parseInt(image_height);

        //         var files = e.target.files;
        //         var maxFileSize = 1024 * 1024;
        //         var done = function (url) {
        //             image.src = url;
        //             $("#popupCropImage").removeClass('hidden');
        //             $modal.modal('show');
        //             // alert("!");
        //         };

        //         var reader;
        //         var file;
        //         var url;

        //         if (files && files.length > 0) {
        //             file = files[0];

        //             if(file.size > maxFileSize) {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Oops...',
        //                     text: 'File size must be less than 1MB!',
        //                 });
        //                 uploadInput.value = ''; // Clear the input
        //                 return; // Prevent further execution
        //             }

        //             if (URL) {
        //                 done(URL.createObjectURL(file));
        //             } else if (FileReader) {
        //                 reader = new FileReader();
        //                 reader.onload = function (e) {
        //                     done(reader.result);
        //                 };
        //                 reader.readAsDataURL(file);
        //             }
        //         }
        //     });

        //     $modal.on('shown.bs.modal', function () {
        //         cropper = new Cropper(image, {
        //             aspectRatio: parseInt(ratio),
        //             viewMode: 0,
        //             // preview: '.preview',
        //         });
        //     }).on('hidden.bs.modal', function () {
        //         cropper.destroy();
        //         cropper = null;
        //     });

        //     // $modal.modal('show');

        //     $("#crop").click(function(){

        //         canvas = cropper.getCroppedCanvas({
        //             // width: ,
        //             // height: ,
        //         });

        //         canvas.toBlob(function(blob) {
        //             url = URL.createObjectURL(blob);
        //             var reader = new FileReader();
        //             reader.readAsDataURL(blob);
        //             reader.onloadend = function() {
        //                 var base64data = reader.result;
        //                 document.getElementById('previewImage'+image_count).src = base64data;
        //                 console.log(base64data);
        //                 $("#cropLoader").removeClass("hidden");
        //                 window.livewire.emit('croppedImage', base64data,image_count);
        //             }
        //         },'image/jpg',0.9);

        //     });

        //     $(".closeBtn").click(function(){
        //         $("#cropLoader").addClass("hidden");
        //         $modal.modal('hide');
        //     });

        //     Livewire.on('hideCropTool', function () {
        //         console.log("hide");
        //         $("#cropLoader").addClass("hidden");
        //         $modal.modal('hide');
        //     });

        // });

       </script>
    <script>
            const inputElements = document.querySelectorAll('.numberInput');

            inputElements.forEach(function(inputElement) {
                inputElement.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
    </script>

  <script>
      $(document).ready(function () {
          $('.dataTable').dataTable()
      })
  </script>

  </body>

</html>
