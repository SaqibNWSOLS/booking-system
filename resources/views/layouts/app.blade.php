<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    @php echo header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    header('Content-Type: text/html'); @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="public/assets/css/accordion.css"> -->
    <!-- <link rel="stylesheet" href="public/assets/css/liteAccordion.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/editor.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/dropzone/css/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dataTables/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style type="text/css">
        .text-help {
            color: red;
        }
    </style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css">
<style>
* {
 font-family: 'Poppins', sans-serif;
}
</style>

</head>

<body onload="init()">
{{--  <div id="preloader">
        <div id="status" class="text-center">
             <img src="{{asset('assets/images/edu-loader.gif')}}" id="preloader_image" alt="loader">
        </div>
    </div> --}}
    <header class="stie-header">
        <div class="container">
            <div class="nav-bar">
                <div class="d-flex align-items-center gap-10">
                    <img class="mobile-menu mt-2" src="{{ asset('assets/icons/menu-svgrepo-com.svg') }}" />
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" />
                    </a>
                </div>
                <div>
                    <ul class="navigation list-unstyle">
                        <li class="cross-menu">
                            <img src="{{ asset('assets/icons/cross-svgrepo-com.svg') }}" />
                        </li>
                        <li>
                            <a href="{{ url('/') }}"
                                class="@if (Request::is('/')) {{ 'active' }} @endif">Home</a>
                        </li>
                        @if (!Auth::id() || Auth::user()->roles_id == 3)


                            <li>
                                <a href="#">How it works</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="@if (Request::is('contact-us')) {{ 'active' }} @endif">Contact Us</a>
                            </li>
                        @else
                            @if (Gate::allows('view_dashboard'))
                                <li>
                                    <a href="{{ url('dashboard') }}"
                                        class="@if (Request::is('dashboard')) {{ 'active' }} @endif">{{ __('nav.dashboard') }}</a>
                                </li>
                            @endif
                            @if (Gate::allows('view_services'))
                                <li>
                                    <a href="{{ url('services') }}">Services</a>
                                </li>
                            @endif
                             @if (Gate::allows('view_bookings'))
                                <li>
                                    <a href="{{ url('bookings') }}">Booking</a>
                                </li>
                            @endif
                        


                        @endif
                    </ul>
                    <div class="filter-backdrop"></div>
                </div>
                <!-- after -->
               @if (!Auth::id())
    <div class="h-list justify-content-end gap-10">
        <a href="{{ url('login') }}" class="btn btn-primary auth-btn">Sign In</a>
        <a href="{{ url('register') }}" class="btn btn-secondary auth-btn">Sign Up</a>
    </div>
@else
@php 
$notifications=App\Models\Notification::where('users_id',Auth::id())->get();
@endphp
    <div class="h-list justify-content-end gap-20">
        <!-- Notification Dropdown -->
        <div class=" notification-dropdown">
            <button class="btn " type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/icons/bell-svgrepo-com.svg') }}" style="width: 16px;" />
                <span class="count">{{ count($notifications) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" id="notifications" style="height: 100px; overflow-y: scroll;" aria-labelledby="notificationDropdown">
                @if($notifications->isEmpty())
                    <li><span class="dropdown-item">No new notifications</span></li>
                @else
                    @foreach($notifications as $notification)
                        <li>
                            <a href="#" class="dropdown-item">
                                {{ $notification->data }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown profile-dropdown">
            <button class="btn p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span>{{ Auth::user()->name }}</span>
                <span class="user-img"><img src="{{ asset('assets/icons/profile-icon.png') }}"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a href="{{ url('change-password') }}" class="dropdown-item">Change Password</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endif

                <!-- before -->
            </div>
        </div>
    </header>




    @yield('content')

    <footer class="py-5 bg-gray border-top">
        <div class="container">
            <div class="row align-items-center justify-content-between gx-5">
                <div class="col-lg-5 col-md-6 col-sm-12 mb-sm-4">
                    <div class="grid gap-15">
                        <p>With years of experience, help in choosing a location, optimized operational processes, our
                            network and numerous support measures, you can work from day 1 as if you had never done
                            anything else in your life. </p>
                        <div>
                            <!--                         <button class="btn btn-primary">Become a Franchise</button>
                        -->
                        </div>
                        <div>
                            <a href="#">
                                <img  style="max-width: 200px" src="{{ asset('assets/images/logo.png') }}" />
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-20">
                            <a href="#" class="icon">
                                <img src="{{ asset('assets/icons/fb.svg') }}" />
                            </a>
                            <a href="#" target="_blank"
                                class="icon">
                                <img src="{{ asset('assets/icons/ins.svg') }}" />
                            </a>
                            <a href="#" class="icon">
                                <img src="{{ asset('assets/icons/in.svg') }}" />
                            </a>
                            <a href="#" target="_blank" class="icon">
                                <img src="{{ asset('assets/icons/youtube.svg') }}" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="grid gap-20 px-lg-5">
                        <ul class="grid gap-10 list-unstyle">
                            <li>
                                <a href="#"
                                    class="@if (Request::is('/')) {{ 'active' }} @endif">Home</a>
                            </li>
                            <li>
                                <a href="#">How it works</a>
                            </li>
                            <li>
                                <a href="{{ url('contact-us') }}"
                                    class="@if (Request::is('contact-us')) {{ 'active' }} @endif">Contact
                                    us</a>
                            </li>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Terms and Conditions</a>
                            </li>
                        </ul>
                        <h4>Engage with us</h4>
                        <div class="grid gap-10">
                            <div class="h-list gap-5">
                                <span>Contact:</span>
                                <a href="https://api.whatsapp.com/send?phone=447440964032" target="_blank">+44 7440 964032 </a>
                            </div>
                            <div class="h-list gap-5">
                                <span>Email:</span>
                                <a href="mailto:support@clientxhosting.com">support@clientxhosting.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <!-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
         -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
        <script src="{{ asset('assets/js/slick.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-slider.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/editor.js') }}"></script>
        <script src="{{ asset('assets/pristine_master/dist/pristine.min.js') }}"></script>
        <script src="{{ asset('assets/dropzone/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/dropzone/js/dropzone.js') }}"></script>
        <script src="{{ asset('assets/dropzone/js/dropzone-script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

        <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

        <script src="{{ asset('assets/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/dataTables.buttons.min.js') }}"></script>

        <script src="{{ asset('assets/dataTables/js/pdfmake.min.js') }}"></script>

        <script src="{{ asset('assets/dataTables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/dataTables/js/buttons.print.min.js') }}"></script>
        <script>
           function getPropertyPrices(propertyId) {
             showPreloader();
                 // Fire off the request to /form.php
                    $.ajax({
                        url: "{{url('getPropertyPrices')}}",
                        type: "post",
                        data: {_token: "{{ csrf_token() }}",propertyId:propertyId},
                    }).done(function(response) {
                        if (response!=false) {
                       $('#priceSection').html(response);
                       hidePreloader();
                   } else {

                    $('#grant-chat--modal').modal('hide');
                      scheduler.deleteEvent(localStorage.getItem('eventId'));
                      Swal.fire(
                    'Warning!',
                    'Property is not available for booking.',
                    'warning'
                );
                   }
                    });
                 return 1;
           }
           $(document).ready(function(){
    setTimeout(function() {
     hidePreloader();
    }, 1000);
});
    function showPreloader(){
         $('#preloader').fadeIn();
          $('#status').fadeIn();
    }

    function hidePreloader() {
          setTimeout(function() {
        $('#preloader').fadeOut();
          $('#status').fadeOut();
          }, 1000);
    }

            var x = document.getElementById("demo");

            function getCoordinates(address) {
                fetch("https://maps.googleapis.com/maps/api/geocode/json?address=" + address +
                        '&key=AIzaSyDXGsx1M8NgD6v08sSROn2Wud8j-XKjK0U')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.results);
                        const latitude = data.results[0].geometry.location.lat;
                        const longitude = data.results[0].geometry.location.lng;
                        $.ajax({
                            url: 'set-location',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                latitude: latitude,
                                longitude: longitude
                            },
                            success: function(data) {
                                console.log(1);
                                localStorage.setItem('lat&long', data);
                            },
                            error: function() {
                                console.log('error');
                            },
                        });
                    });
            }

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                $.ajax({
                    url: 'setLatitudeAndLogitude',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(data) {
                        localStorage.setItem('lat&long', data);
                    },
                    error: function() {
                        console.log('error');
                    },
                });

            }
            // CKEDITOR.replace('editor1');

            function mobileNumber(input) {
                var regex = /[a-z,-,-,!,@,#,$,%,^,&.*.(,)._]/g;
                input.value = input.value.replace(regex, "");
            }

            function numbersOnly(input) {
                var regex = /[a-z,-,-,!,@,#,$,%,^,&*(,)_]/g;
                input.value = input.value.replace(regex, "");
            }
        </script>
        <script src="{{ asset('assets/jsPDF/jspdf.debug.js') }}"></script>

        @if (old('modal'))
            <script type="text/javascript">
                $('#{{ old('modal') }}').modal('show');
            </script>
        @endif
        @if (!empty(session('success')))
            <script type="text/javascript">
                Swal.fire(
                    'Success!',
                    '<?php echo session('success'); ?>',
                    'success'
                )
            </script>
        @endif
        @if (!empty(session('error')))
            <script type="text/javascript">
                Swal.fire(
                    'Danger!',
                    '<?php echo session('error'); ?>',
                    'error'
                )
            </script>
        @endif
        @if (!empty(session('warning')))
            <script type="text/javascript">
                Swal.fire(
                    'Warning!',
                    '<?php echo session('warning'); ?>',
                    'warning'
                )
            </script>
        @endif
        <script src="{{ asset('assets/dropzone/js/scripts.js') }}"></script>

        @yield('js')

        <script>


                $(".select-2").select2({
                    placeholder: "Select below",
                    // dropdownParent: $('#grant-chat--modal')
                });
            function deleteConfirm() {
                var result = confirm("Are you sure to delete this item?");
                if (result == true) {
                    return true;
                } else {
                    return false;
                }
            }

            function confirmChangePassword() {
                var result = confirm("Are you sure to delete this item?");
                if (result == true) {
                    alert(result);
                    return true;
                } else {
                    return false;
                }
            }

           
            $("#login-close").click(function() {
                $('.invalid-feedback').css('display', 'none');

                 var formrd = document.getElementById("form3");
                formrd.reset();
                scheduler.hideCover();
                $('#priceSection').html('');
                console.log(2);
            });
            $("#btn-close").click(function() {
                $('.invalid-feedback').css('display', 'none');
                var form = document.getElementById("form2");
                form.reset();
                scheduler.hideCover();
                var pristine = new Pristine(form);
                pristine.reset();
                var pristine = new Pristine(form);
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var valid = pristine.validate();
                    if (valid == true) {
                        form.submit();
                    }

                });
            });
            window.onload = function() {

                var formss = document.getElementById("form2");

                var pristines = new Pristine(formss);

                formss.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var valid = pristines.validate();
                    if (valid == true) {
                        formss.submit();
                    }

                });
                var form = document.getElementById("form1");

                var pristine = new Pristine(form);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var valid = pristine.validate();
                    if (valid == true) {
                        form.submit();
                    }

                });


            };
            @if (Request::segment(1) != 'property')
                window.onload = function() {
                    var formss = document.getElementById("form2");
                    var pristines = new Pristine(formss);

                    formss.addEventListener('submit', function(e) {
                        e.preventDefault();
                        var valid = pristines.validate();
                        if (valid == true) {
                            formss.submit();
                        }

                    });
                    var form = document.getElementById("form1");

                    var pristine = new Pristine(form);

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        var valid = pristine.validate();
                        if (valid == true) {
                            form.submit();
                        }

                    });
                };
            @endif
            @if (Request::segment(1) == 'property')
                window.onload = function() {



                    $("#capacity-1").add("#low_season_price_1").add("#high_season_price_1").on('keydown', function() {
                        $(this).parent().find('.pristine-error').remove();
                    });


                    var form = document.getElementById("form99");

                    var pristine = new Pristine(form);
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        var valid = pristine.validate();
                        var first_capcity = document.getElementById("capacity-1");
                        var low_season_price_1 = document.getElementById("low_season_price_1");
                        var high_season_price_1 = document.getElementById("high_season_price_1");
                        var all_true = true;
                        if (!first_capcity.value) {
                            $(first_capcity).parent().find('.pristine-error').remove();
                            $('<div class="pristine-error text-help">This field is required</div>').insertAfter(
                                first_capcity);
                            all_true = false;
                        }
                        if (!low_season_price_1.value) {
                            $(low_season_price_1).parent().find('.pristine-error').remove();
                            $('<div class="pristine-error text-help">This field is required</div>').insertAfter(
                                low_season_price_1);
                            all_true = false;
                        }
                        if (!high_season_price_1.value) {
                            $(high_season_price_1).parent().find('.pristine-error').remove();
                            $('<div class="pristine-error text-help">This field is required</div>').insertAfter(
                                high_season_price_1);
                            all_true = false;
                        }
                        if (valid == true && all_true) {
                            form.submit();
                        }

                    });


                };
            @endif
        </script>



        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $(document).ready(function() {
                if (localStorage.getItem('view') == 'list') {
                    $('body').removeClass('grid-preview').addClass('list-preview');
                    $('.grid-view').removeClass("active");
                }
                $('.btn-close').on("click", function() {
                    $('.modal').hide();
                    $('.modal-backdrop').hide();
                });

                $("#banner-slider").slick({
                    slideToShow: 1,
                    SlideToScroll: 1,
                    dots: false,
                    arrows: false,
                });

                $("#testimonial-slider").slick({
                    slideToShow: 1,
                    SlideToScroll: 1,
                    dots: false,
                    arrows: true,
                });

                $(".property-slider").slick({
                    slidesToShow: 7,
                    SlidesToScroll: 1,
                    dots: false,
                    arrows: true,
                    infinite: false
                });

                $('input[name="daterange"]').daterangepicker({
                    "opens": "left"
                });

                $('.datepicker').datepicker();


                $('#grant-chat--modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })

                $(this).addClass("active")
                $('.icon-holder').on('click', function(e) {
                    if ($(this).hasClass('grid-view')) {
                        $('body').removeClass('list-preview').addClass('grid-preview');
                        $('.list-view').removeClass("active");
                        $(this).addClass("active")


                        localStorage.setItem('view', 'grid');
                    } else if ($(this).hasClass('list-view')) {
                        $('body').removeClass('grid-preview').addClass('list-preview');
                        $('.grid-view').removeClass("active");
                        $(this).addClass("active")
                        localStorage.setItem('view', 'list');
                    }
                });

                $("#custom-accordion .image").on("click", function() {
                    $(".image").removeClass("active");
                    $(this).addClass("active");
                })

                var items = $('#custom-accordion .image');

                var currentItem = items.filter('.active');
                $('#next-button').on('click', function() {
                    var nextItem = currentItem.next();
                    currentItem.removeClass('active');
                    if (nextItem.length) {
                        currentItem = nextItem.addClass('active');
                    } else {
                        currentItem = items.first().addClass('active');
                    }
                });

                $('#prev-button').on('click', function() {
                    var prevItem = currentItem.prev();
                    currentItem.removeClass('active');
                    if (prevItem.length) {
                        currentItem = prevItem.addClass('active');
                    } else {
                        currentItem = items.first().addClass('active');
                    }
                });

                $("#ex2").slider({});

                $(".btn-view-filter").on("click", function() {
                    $("body").addClass("show-filter");
                })

                $(".hide-filter-view").on("click", function() {
                    $("body").removeClass("show-filter")
                })
                $(".filter-backdropv2").on("click", function() {
                    $("body").removeClass("show-filter")
                })

                $("div#myId").dropzone({
                    url: "/file/post"
                });


                $(".mobile-menu").on("click", function() {
                    $("body").addClass("show-mobile-nav")
                });
                $(".cross-menu").on("click", function() {
                    $("body").removeClass("show-mobile-nav")
                });
                $(".filter-backdrop").on("click", function() {
                    $("body").removeClass("show-mobile-nav")
                });


                $('.media-for').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.media-nav'
                });
                $('.media-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.media-for',
                    dots: false,
                    arrows: false,
                    centerMode: true,
                    focusOnSelect: true,
                    responsive: [{
                        breakpoint: 700,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }, ]
                });


                $(".sticky-bar li > a").on("click", function(e) {
                    e.preventDefault();
                    // $(".sticky-bar ul").find(".active").removeClass("active");
                    // $(this).parent().addClass("active");
                    var data_id = $(this).attr("href");
                    $("html, body").animate({
                        scrollTop: $(data_id).offset().top - 90
                    }, 0);
                });

                $(window).scroll(function() {
                    var position = $(this).scrollTop();
                    $('.section-holder').each(function() {
                        var target = $(this).offset().top - 110;
                        var id = $(this).attr('id');
                        if (position >= target) {
                            $('.sticky-bar li').removeClass('active');
                            $('.sticky-bar ul a[href="#' + id + '"]').parents('li').addClass('active');
                        }
                    });
                });

                $('.password-group').find('.password-box').each(function(index, input) {
                    var $input = $(input);
                    $input.parent().find('.password-visibility').click(function() {
                        var change = "";
                        if ($(this).find('i').hasClass('fa-eye')) {
                            $(this).find('i').removeClass('fa-eye')
                            $(this).find('i').addClass('fa-eye-slash')
                            change = "text";
                        } else {
                            $(this).find('i').removeClass('fa-eye-slash')
                            $(this).find('i').addClass('fa-eye')
                            change = "password";
                        }
                        var rep = $("<input type='" + change + "' />")
                            .attr('id', $input.attr('id'))
                            .attr('name', $input.attr('name'))
                            .attr('class', $input.attr('class'))
                            .val($input.val())
                            .insertBefore($input);
                        $input.remove();
                        $input = rep;
                    }).insertAfter($input);
                });

            });

            $(document).ready(function() {
                // size_li = $("#feature-list li").size();
                const x = 6;
                $('#feature-list li:lt(' + x + ')').show();
                $('#loadless').hide();
                $('#loadMore').click(function() {
                    $('#feature-list li').show();
                    $('#loadMore').hide();
                    $('#loadless').show();
                });
                $('#loadless').click(function() {
                    $('#feature-list li').hide();
                    $('#feature-list li:lt(' + x + ')').show();
                    $('#loadMore').show();
                    $('#loadless').hide();
                });
            });

            $('.modal').on('shown.bs.modal', function(e) {
                $('.media-for').slick('setPosition');
                $('.media-nav').slick('setPosition');
            })

            function mobileOnlySlider() {
                $('#custom-accordion').slick({
                    autoplay: false,
                    prevArrow: $('#prev-button'),
                    nextArrow: $('#next-button'),
                });
            }
            if (window.innerWidth < 991) {
                mobileOnlySlider();
            }

            $(window).resize(function(e) {
                if (window.innerWidth < 991) {
                    if (!$('#custom-accordion').hasClass('slick-initialized')) {
                        mobileOnlySlider();
                    }

                } else {
                    if ($('#custom-accordion').hasClass('slick-initialized')) {
                        $('#custom-accordion').slick('unslick');
                    }
                }
            });

            $(function() {
                function count($this) {
                    var current = parseInt($this.html(), 10);
                    current = current + 20;

                    $this.html(++current);
                    if (current > $this.data('count')) {
                        $this.html($this.data('count'));
                    } else {
                        setTimeout(function() {
                            count($this)
                        }, 10);
                    }
                }


                $(".stat-count").each(function() {
                    $(this).data('count', parseInt($(this).html(), 10));
                    $(this).html('0');
                    count($(this));
                });

                //  var dateToday = new Date();
                if ($('#search_start_date, #search_end_date').length) {
                    // check if element is available to bind ITS ONLY ON HOMEPAGE
                    var currentDate = moment().format("DD-MM-YYYY");

                    $('#search_start_date, #search_end_date').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY'
                        },
                        "opens": "center",
                        "alwaysShowCalendars": true,

                        "maxDate": moment().add('months', 2),
                        autoApply: true,
                        autoUpdateInput: false
                    }, function(start, end, label) {
                        // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                        // Lets update the fields manually this event fires on selection of range
                        var selectedStartDate = start.format('DD-MM-YYYY'); // selected start
                        var selectedEndDate = end.format('DD-MM-YYYY'); // selected end

                        $checkinInput = $('#search_start_date');
                        $checkoutInput = $('#search_end_date');

                        // Updating Fields with selected dates
                        $checkinInput.val(selectedStartDate);
                        $checkoutInput.val(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
                        var checkOutPicker = $checkoutInput.data('daterangepicker');
                        checkOutPicker.setStartDate(selectedStartDate);
                        checkOutPicker.setEndDate(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
                        var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(selectedStartDate);
                        checkInPicker.setEndDate(selectedEndDate);

                    });

                }
                if ($('#search_checkin, #search_checkout').length) {
                    // check if element is available to bind ITS ONLY ON HOMEPAGE
                    var currentDate = moment().format("DD-MM-YYYY");
                    $('#search_checkin').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY'
                        },
                        "opens": "center",
                        "drops":"up",
                        "alwaysShowCalendars": true,
                        "minDate": currentDate,
                        "maxDate": moment().add('months', 2).subtract('days', 1),
                        "maxSpan": {
                            "months": 12
                        },
                        "minSpan": {
                            "days": 30
                        },
                        autoApply: true,
                        autoUpdateInput: false
                    }, function(start, end, label) {
                        // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                        // Lets update the fields manually this event fires on selection of range
                        var selectedStartDate = start.format('DD-MM-YYYY'); // selected start
                        var selectedEndDate = end.format('DD-MM-YYYY'); // selected end
                              console.log(selectedStartDate);
                        $checkinInput = $('#search_checkin');
                        $checkoutInput = $('#search_checkout');

                        // Updating Fields with selected dates
                        $checkinInput.val(selectedStartDate);
                        $checkoutInput.val(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
                        var checkOutPicker = $checkoutInput.data('daterangepicker');
                        checkOutPicker.setStartDate(selectedStartDate);
                        checkOutPicker.setEndDate(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
                        var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(selectedStartDate);
                        checkInPicker.setEndDate(selectedEndDate);

                    });

                    $('#search_checkout').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY'
                        },
                        "opens": "center",
                        "alwaysShowCalendars": true,
                        "minDate": moment().add('months', 2).subtract('days', 1),
                        "maxDate": moment().add('months', 2).subtract('days', 1),
                        "maxSpan": {
                            "months": 12
                        },
                        autoApply: true,
                        autoUpdateInput: false
                    }, function(start, end, label) {
                        // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                        // Lets update the fields manually this event fires on selection of range
                        var selectedStartDate = start.format('DD-MM-YYYY'); // selected start
                        var selectedEndDate = end.format('DD-MM-YYYY'); // selected end

                        $checkinInput = $('#search_checkin');
                        $checkoutInput = $('#search_checkout');

                        // Updating Fields with selected dates
                        $checkinInput.val(selectedStartDate);
                        $checkoutInput.val(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
                        var checkOutPicker = $checkoutInput.data('daterangepicker');
                        checkOutPicker.setStartDate(selectedStartDate);
                        checkOutPicker.setEndDate(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
                        var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(selectedStartDate);
                        checkInPicker.setEndDate(selectedEndDate);

                    });

                    $('#search_checkout').add("#search_checkin").on('showCalendar.daterangepicker', function(ev,
                        picker) {
                        picker.container.find('.drp-calendar').on('mouseup.daterangepicker', 'td.available',
                            function() {
                                //   picker.maxDate = true;
                                picker.updateCalendars();
                            });
                    });

                } // End Daterange Picker

                $('.modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })


            });

            function print_invoice(printpage) {
                var headstr = "<html><head><title></title></head><body>";
                var footstr = "</body>";
                var newstr = document.all.item(printpage).innerHTML;
                var oldstr = document.body.innerHTML;
                document.body.innerHTML = headstr + newstr + footstr;
                window.print();
                document.body.innerHTML = oldstr;
                return false;
            }

            function download_pdf(id) {
                var n = Math.floor((Math.random() * 100) + 1);
                var pdf = new jsPDF('p', 'pt', 'A4');
                pdf.addHTML($('#' + id), function() {
                    pdf.save('invoice' + n + '.pdf');
                });
            }


        </script>

     <script src="https://js.pusher.com/7.2/pusher.min.js"></script>


<script>
  Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

@if(Auth::user())

      var channel = pusher.subscribe('notifications.{{ auth()->user()->id }}');
    channel.bind('notification.sent', function(data) {
console.log(data);
$('#notifications').append('<li><a href="#" class="dropdown-item">'+data.notification.data+'</a></li>');
        
    });
    @endif
</script>
    </footer>

