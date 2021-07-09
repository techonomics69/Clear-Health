<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{URL('/')}}">
    <meta name="guard" content="admin">

    <title>@yield('title')</title>




    <!-- <link rel="apple-touch-icon" href="{{ asset('theme/mini-logo.png') }}"> -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('theme/mini-logo.png') }}"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/app-assets/vendors/css/weather-icons/climacons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/fonts/meteocons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/vendors/css/forms/icheck/custom.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/app.css') }}">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/pages/timeline.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('theme/app-assets/css/plugins/forms/checkboxes-radios.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/app-assets/css/loader.css') }}">

    @toastr_css
    <!-- END Page Level CSS-->
    <link href="{{ asset('theme/telerik/styles/kendo.common.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/telerik/styles/kendo.bootstrap-v4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/style.css') }}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    <style type="text/css">
    .swal-icon.swal-icon--custom {
        width: 80px
    }
    </style>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <!-- END Custom CSS-->
    @yield('stylesection')
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">
    <!-- fixed-top-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark bg-gradient-x-primary navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row custome-nav">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="{{ route('home.dashboard') }}">
                            <img class="brand-logo" alt="stack admin logo" src="{{ asset('theme/logo.png') }}">
                            <img class="mini-logo" alt="stack admin logo" src="{{ asset('theme/mini-logo.png') }}">
                            <!-- <h3 class="mini-logo">CH</h3> -->
                            <!-- <h2 class="brand-text">Ise-Breaker</h2> -->
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="fa fa-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"></i></a></li>
                        <!--  <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Mega</a>
            <ul class="mega-dropdown-menu dropdown-menu row">
              <li class="col-md-2">
                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="fa fa-newspaper-o"></i> News</h6>
                <div id="mega-menu-carousel-example">
                  <div>
                    <img class="rounded img-fluid mb-1" src="{{ asset('theme/app-assets/images/slider/slider-2.png') }}"
                    alt="First slide"><a class="news-title mb-0" href="#">Poster Frame PSD</a>
                    <p class="news-content">
                      <span class="font-small-2">January 26, 2016</span>
                    </p>
                  </div>
                </div>
              </li>
              <li class="col-md-3">
                <h6 class="dropdown-menu-header text-uppercase"><i class="fa fa-random"></i> Drill down menu</h6>
                <ul class="drilldown-menu">
                  <li class="menu-list">
                    <ul>
                      <li>
                        <a class="dropdown-item" href="layout-2-columns.html"><i class="ft-file"></i> Page layouts & Templates</a>
                      </li>
                      <li><a href="#"><i class="ft-align-left"></i> Multi level menu</a>
                        <ul>
                          <li><a class="dropdown-item" href="#"><i class="fa fa-bookmark-o"></i>  Second level</a></li>
                          <li><a href="#"><i class="fa fa-lemon-o"></i> Second level menu</a>
                            <ul>
                              <li><a class="dropdown-item" href="#"><i class="fa fa-heart-o"></i>  Third level</a></li>
                              <li><a class="dropdown-item" href="#"><i class="fa fa-file-o"></i> Third level</a></li>
                              <li><a class="dropdown-item" href="#"><i class="fa fa-trash-o"></i> Third level</a></li>
                              <li><a class="dropdown-item" href="#"><i class="fa fa-clock-o"></i> Third level</a></li>
                            </ul>
                          </li>
                          <li><a class="dropdown-item" href="#"><i class="fa fa-hdd-o"></i> Second level, third link</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fa fa-floppy-o"></i> Second level, fourth link</a></li>
                        </ul>
                      </li>
                      <li>
                        <a class="dropdown-item" href="color-palette-primary.html"><i class="ft-camera"></i> Color pallet system</a>
                      </li>
                      <li><a class="dropdown-item" href="sk-2-columns.html"><i class="ft-edit"></i> Page starter kit</a></li>
                      <li><a class="dropdown-item" href="changelog.html"><i class="ft-minimize-2"></i> Change log</a></li>
                      <li>
                        <a class="dropdown-item" href="https://pixinvent.ticksy.com/"><i class="fa fa-life-ring"></i> Customer support center</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="col-md-3">
                <h6 class="dropdown-menu-header text-uppercase"><i class="fa fa-list-ul"></i> Accordion</h6>
                <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                  <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                    <div class="card-header p-0 pb-2 border-0" id="headingOne" role="tab"><a data-toggle="collapse" data-parent="#accordionWrap" href="#accordionOne"
                      aria-expanded="true" aria-controls="accordionOne">Accordion Item #1</a></div>
                      <div class="card-collapse collapse show" id="accordionOne" role="tabpanel" aria-labelledby="headingOne"
                      aria-expanded="true">
                      <div class="card-content">
                        <p class="accordion-text text-small-3">Caramels dessert chocolate cake pastry jujubes bonbon.
                          Jelly wafer jelly beans. Caramels chocolate cake liquorice
                        cake wafer jelly beans croissant apple pie.</p>
                      </div>
                    </div>
                    <div class="card-header p-0 pb-2 border-0" id="headingTwo" role="tab"><a class="collapsed" data-toggle="collapse" data-parent="#accordionWrap"
                      href="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Accordion Item #2</a></div>
                      <div class="card-collapse collapse" id="accordionTwo" role="tabpanel" aria-labelledby="headingTwo"
                      aria-expanded="false">
                      <div class="card-content">
                        <p class="accordion-text">Sugar plum bear claw oat cake chocolate jelly tiramisu
                          dessert pie. Tiramisu macaroon muffin jelly marshmallow
                        cake. Pastry oat cake chupa chups.</p>
                      </div>
                    </div>
                    <div class="card-header p-0 pb-2 border-0" id="headingThree" role="tab"><a class="collapsed" data-toggle="collapse" data-parent="#accordionWrap"
                      href="#accordionThree" aria-expanded="false" aria-controls="accordionThree">Accordion Item #3</a></div>
                      <div class="card-collapse collapse" id="accordionThree" role="tabpanel" aria-labelledby="headingThree"
                      aria-expanded="false">
                      <div class="card-content">
                        <p class="accordion-text">Candy cupcake sugar plum oat cake wafer marzipan jujubes
                          lollipop macaroon. Cake dragée jujubes donut chocolate
                        bar chocolate cake cupcake chocolate topping.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="col-md-4">
                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="fa fa-envelope-o"></i> Contact Us</h6>
                <form class="form form-horizontal">
                  <div class="form-body">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label" for="inputName1">Name</label>
                      <div class="col-sm-9">
                        <div class="position-relative has-icon-left">
                          <input class="form-control" type="text" id="inputName1" placeholder="John Doe">
                          <div class="form-control-position pl-1"><i class="fa fa-user-o"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label" for="inputEmail1">Email</label>
                      <div class="col-sm-9">
                        <div class="position-relative has-icon-left">
                          <input class="form-control" type="email" id="inputEmail1" placeholder="john@example.com">
                          <div class="form-control-position pl-1"><i class="fa fa-envelope-o"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label" for="inputMessage1">Message</label>
                      <div class="col-sm-9">
                        <div class="position-relative has-icon-left">
                          <textarea class="form-control" id="inputMessage1" rows="2" placeholder="Simple Textarea"></textarea>
                          <div class="form-control-position pl-1"><i class="fa fa-commenting-o"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 mb-1">
                        <button class="btn btn-primary float-right" type="button"><i class="fa fa-paper-plane-o"></i> Send</button>
                      </div>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </li> -->
                        <!-- <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
          <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
            <div class="search-input">
              <input class="input" type="text" placeholder="Explore Stack...">
            </div>
          </li> -->
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <!-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a>
            </div>
          </li> -->
                        <!--   <li class="dropdown dropdown-notification nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
              <span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0">
                  <span class="grey darken-2">Notifications</span>
                  <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                </h6>
              </li>
              <li class="scrollable-container media-list">
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                    <div class="media-body">
                      <h6 class="media-heading">You have new order!</h6>
                      <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                    <div class="media-body">
                      <h6 class="media-heading red darken-1">99% Server load</h6>
                      <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                    <div class="media-body">
                      <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                      <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                    <div class="media-body">
                      <h6 class="media-heading">Complete the task</h6>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                    <div class="media-body">
                      <h6 class="media-heading">Generate monthly report</h6>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time>
                      </small>
                    </div>
                  </div>
                </a>
              </li>
              <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
            </ul>
          </li> -->
                        <!-- <li class="dropdown dropdown-notification nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i>
              <span class="badge badge-pill badge-default badge-warning badge-default badge-up">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0">
                  <span class="grey darken-2">Messages</span>
                  <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
                </h6>
              </li>
              <li class="scrollable-container media-list">
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-online rounded-circle">
                        <img src="{{ URL::asset('public/app-assets/images/portrait/small/avatar-s-1.png') }}" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Margaret Govan</h6>
                        <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-busy rounded-circle">
                          <img src="{{ URL::asset('public/app-assets/images/portrait/small/avatar-s-2.png') }}" alt="avatar"><i></i></span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Bret Lezama</h6>
                          <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                          <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time>
                          </small>
                        </div>
                      </div>
                    </a>
                    <a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left">
                          <span class="avatar avatar-sm avatar-online rounded-circle">
                            <img src="{{ URL::asset('public/app-assets/images/portrait/small/avatar-s-3.png') }}" alt="avatar"><i></i></span>
                          </div>
                          <div class="media-body">
                            <h6 class="media-heading">Carie Berra</h6>
                            <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                            <small>
                              <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time>
                            </small>
                          </div>
                        </div>
                      </a>
                      <a href="javascript:void(0)">
                        <div class="media">
                          <div class="media-left">
                            <span class="avatar avatar-sm avatar-away rounded-circle">
                              <img src="{{ URL::asset('public/app-assets/images/portrait/small/avatar-s-6.png') }}" alt="avatar"><i></i></span>
                            </div>
                            <div class="media-body">
                              <h6 class="media-heading">Eric Alsobrook</h6>
                              <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                              <small>
                                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time>
                              </small>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
                    </ul>
                  </li> -->
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">
                                    <img src="{{ asset('theme/app-assets/images/portrait/small/avatar-s-1.png') }}"
                                        alt="avatar"><i></i></span>

                                <span class="user-name">{{Auth::user()->name}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL('/logout')}}"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>



    @section('sidebar')
    @php $user = Auth::user(); @endphp
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <!-- <li class=" navigation-header">
                  <span>General</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right"
                  data-original-title="General"></i>
                </li> -->
                @canany(['dashboard-show'])
                <li class="nav-item dashboard">
                    <a class="menu-item" href="{{ url('admin/dashboard') }}">

                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20" height="20"
                            viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                            <g>
                                <path
                                    d="M23.1,0H4.4C2,0,0,1.9,0,4.3v11.2C0,18,2,20,4.4,20h18.8c2.4,0,4.4-2,4.4-4.4V4.3C27.5,1.9,25.5,0,23.1,0z" />
                                <path
                                    d="M23.1,25H4.4C2,25,0,26.9,0,29.3v26.3C0,58,2,60,4.4,60h18.8c2.4,0,4.4-2,4.4-4.4V29.3C27.5,26.9,25.5,25,23.1,25z" />
                                <path
                                    d="M55.6,40H36.9c-2.4,0-4.4,2-4.4,4.4v11.2c0,2.4,2,4.4,4.4,4.4h18.8c2.4,0,4.4-2,4.4-4.4V44.3C60,41.9,58,40,55.6,40z" />
                                <path
                                    d="M55.6,0H36.9c-2.4,0-4.4,2-4.4,4.4v26.2c0,2.4,2,4.4,4.4,4.4h18.8c2.4,0,4.4-2,4.4-4.4V4.3C60,1.9,58,0,55.6,0z" />
                            </g>
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">Dashboard</span></a>

                </li>
                @endcanany
                @canany(['user-list', 'user-create', 'user-edit', 'user-delete','role-list', 'role-create', 'role-edit',
                'role-delete'])
                <li
                    class="nav-item sub-menu has-sub {{ Request::is('admin/users*') ? 'active' : '' }} {{ Request::is('admin/roles*') ? 'active' : '' }} ">
                    <a class="menu-item" href="#">

                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 512 512"
                            height="20" viewBox="0 0 512 512" width="20">
                            <g>
                                <path
                                    d="m128.503 376v-95.557l-60.649 142.689c-1.97 4.633-1.483 9.945 1.295 14.144 2.777 4.199 7.476 6.724 12.51 6.724h80.323l-3.391-31.239c-17.14-3.451-30.088-18.621-30.088-36.761z" />
                                <path
                                    d="m444.152 423.147-60.653-143.125-.002 95.978c0 18.14-12.948 33.31-30.088 36.761l-3.391 31.239h80.323c5.031 0 9.728-2.522 12.506-6.717s3.268-9.503 1.305-14.136z" />
                                <circle cx="256" cy="67.14" r="67.14" />
                                <path d="m246.062 203.571 9.938 12.878 9.938-12.878-9.938-25.401z" />
                                <path
                                    d="m353.497 376 .003-173.5h11.5c37.22 0 67.5-30.28 67.5-67.5v-74c0-20.677-16.822-37.5-37.5-37.5s-37.5 16.823-37.5 37.5v66.468l-25.428.008c-12.716 15.998-30.363 27.907-50.619 33.414l15.516 39.659c1.92 4.906 1.125 10.458-2.094 14.629l-27 34.987c-2.84 3.68-7.227 5.835-11.875 5.835s-9.035-2.155-11.875-5.836l-27-34.987c-3.219-4.17-4.014-9.723-2.094-14.629l15.521-39.671c-11.418-3.105-22.013-8.23-31.357-14.99-4.512 3.261-8.793 6.908-12.77 10.966-18.006 18.377-27.922 42.578-27.922 68.143v151.004c0 4.142 3.357 7.5 7.5 7.5h179.994c4.142 0 7.5-3.358 7.5-7.5z" />
                                <path
                                    d="m198.088 498.619c.826 7.613 7.255 13.381 14.912 13.381h86c7.657 0 14.086-5.768 14.912-13.381l9.241-85.119h-134.306z" />
                            </g>
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">Roles and Responsibilities</span>

                    </a>
                    <ul class="menu-content">
                        @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                        <li class="sub-menu user-sub-menu ">
                            <a href="#">
                                Users
                            </a>
                            <ul class="menu-content">
                                <li class="user-list">
                                    <a href="{{ url('admin/users') }}">Users List</a>
                                </li>
                                <li class="user-create">
                                    <a href="{{ url('admin/users/create') }}">User Create</a>
                                </li>
                            </ul>
                        </li>
                        @endcanany
                        @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])

                        <li class="sub-menu role-sub-menu ">
                            <a href="#">
                                Roles
                            </a>
                            <ul class="menu-content">
                                <li class="role-list">
                                    <a href="{{ url('admin/roles') }}">Role List</a>
                                </li>
                                <li class="role-create">
                                    <a href="{{ url('admin/roles/create') }}">Role Create</a>
                                </li>
                            </ul>
                        </li>
                        @endcanany
                    </ul>
                </li>
                @endcanany
                @canany(['category-list', 'category-create', 'category-edit', 'category-delete'])
                <li
                    class="nav-item sub-menu has-sub categori-sub-menu {{ Request::is('admin/categories*') ? 'active' : '' }}">
                    <a class="menu-item" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -52 512 512" width="20">
                            <path d="m0 0h113.292969v113.292969h-113.292969zm0 0" />
                            <path d="m149.296875 0h362.703125v113.292969h-362.703125zm0 0" />
                            <path d="m0 147.007812h113.292969v113.292969h-113.292969zm0 0" />
                            <path d="m149.296875 147.007812h362.703125v113.292969h-362.703125zm0 0" />
                            <path d="m0 294.011719h113.292969v113.296875h-113.292969zm0 0" />
                            <path d="m149.296875 294.011719h362.703125v113.296875h-362.703125zm0 0" />
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">Categories</span>

                    </a>
                    <ul class="menu-content">
                        <li class="sub-menu categori-list">
                            <a href="{{ route('categories.index') }}">
                                Categories List
                            </a>
                        </li>
                        <li class="sub-menu categori-create">
                            <a href="{{ route('categories.create') }}">
                                Category Create
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['customer-list', 'customer-create', 'customer-edit', 'customer-delete'])
                <li
                    class="nav-item sub-menu has-sub customer-sub-menu {{ Request::is('admin/customer*') ? 'active' : '' }}">
                    <a class="menu-item" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" enable-background="new 0 0 512 512"
                            height="20" viewBox="0 0 512 512" width="20">
                            <g>
                                <circle cx="256" cy="119.631" r="87" />
                                <circle cx="432" cy="151.63" r="55" />
                                <circle cx="80" cy="151.63" r="55" />
                                <path
                                    d="m134.19 256.021c-21.65-17.738-41.257-15.39-66.29-15.39-37.44 0-67.9 30.28-67.9 67.49v109.21c0 16.16 13.19 29.3 29.41 29.3 70.026 0 61.59 1.267 61.59-3.02 0-77.386-9.166-134.137 43.19-187.59z" />
                                <path
                                    d="m279.81 241.03c-43.724-3.647-81.729.042-114.51 27.1-54.857 43.94-44.3 103.103-44.3 175.48 0 19.149 15.58 35.02 35.02 35.02 211.082 0 219.483 6.809 232-20.91 4.105-9.374 2.98-6.395 2.98-96.07 0-71.226-61.673-120.62-111.19-120.62z" />
                                <path
                                    d="m444.1 240.63c-25.17 0-44.669-2.324-66.29 15.39 51.965 53.056 43.19 105.935 43.19 187.59 0 4.314-7.003 3.02 60.54 3.02 16.8 0 30.46-13.61 30.46-30.34v-108.17c0-37.21-30.46-67.49-67.9-67.49z" />
                            </g>
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">Customers</span>

                    </a>
                    <ul class="menu-content">
                        <li class="sub-menu customer-list {{ Request::is('admin/customer') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}">
                                Customers List
                            </a>
                        </li>
                        <li
                            class="sub-menu  customer-create {{ Request::is('admin/customer/create') ? 'active' : '' }}">
                            <a href="{{ route('customers.create') }}">
                                Customer Create
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['product-list', 'product-create', 'product-edit', 'product-delete'])
                <li
                    class="nav-item sub-menu has-sub product-sub-menu {{ Request::is('admin/products*') ? 'active' : '' }}">
                    <a class="menu-item" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 511.938 511.938"
                            height="20" viewBox="0 0 511.938 511.938" width="20">
                            <g>
                                <path d="m217.941 11.378h73.482v88.591h-73.482z" />
                                <path d="m217.941 134.067h73.482v45.448h-73.482z" />
                                <path
                                    d="m27.275 134.067v162.625c10.57 2.002 20.58 7.315 28.39 15.793l56.29 61.1c.144.157.298.303.445.458v-12.434c0-26.147 21.272-47.418 47.418-47.418h78.825c9.787 1.106 35.702-13.721 44.638-17.274 37.94-17.638 81.122-16.941 118.472 1.912l22.715 11.538c6.361-20.427 24.622-35.225 46.112-35.225h13.471v-141.075h-158.53v62.497c0 9.416-7.633 17.049-17.049 17.049h-107.58c-9.416 0-17.049-7.633-17.049-17.049v-62.497z" />
                                <path
                                    d="m325.521 99.969h158.529v-64.943c0-13.061-8.798-23.648-19.651-23.648h-138.878z" />
                                <path
                                    d="m470.578 309.24c-7.956 0-14.428 7.637-14.428 17.024v152.404c0 9.387 6.473 17.024 14.428 17.024h26.931c7.956 0 14.429-7.637 14.429-17.024v-152.404c0-9.387-6.473-17.024-14.429-17.024z" />
                                <path
                                    d="m183.844 11.378h-140.238c-9.019 0-16.331 8.799-16.331 19.653v68.938h156.569z" />
                                <path
                                    d="m30.587 335.588c-15.064-15.064-40.707 4.627-26.378 22.147l76.792 93.094c26.07 31.604 64.519 49.73 105.488 49.73h86.856c32.255 0 64.519-3.788 95.895-11.259l52.813-12.631v-129.284l-35.704-18.136c-27.936-14.101-60.279-14.623-88.693-1.412l-30.367 14.118c-8.912 4.143-18.818 6.333-28.646 6.333h-78.825c-7.345 0-13.321 5.975-13.321 13.321v25.827h153.113c9.416 0 17.049 7.633 17.049 17.049s-7.633 17.049-17.049 17.049h-156.062c-19.78.239-42.502-9.027-56.671-24.845z" />
                            </g>
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">Products</span>

                    </a>
                    <ul class="menu-content">
                        <li class="sub-menu product-list {{ Request::is('admin/products') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">
                                Products List
                            </a>
                        </li>
                        <li
                            class="sub-menu  product-create {{ Request::is('admin/products/create') ? 'active' : '' }} ">
                            <a href="{{ route('products.create') }}">
                                Product Create
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                @canany(['cms-list', 'cms-create', 'cms-edit', 'cms-delete'])
                <li class="nav-item sub-menu has-sub cms-sub-menu {{ Request::is('admin/cms*') ? 'active' : '' }}">
                    <a class="menu-item" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 512 512" width="20">
                            <path d="m0 330h512v92h-512zm0 0" />
                            <path
                                d="m166 165c8.277344 0 15-6.722656 15-15s-6.722656-15-15-15-15 6.722656-15 15 6.722656 15 15 15zm0 0" />
                            <path
                                d="m166 225c41.351562 0 75-33.648438 75-75s-33.648438-75-75-75-75 33.648438-75 75 33.648438 75 75 75zm0-120c24.8125 0 45 20.1875 45 45s-20.1875 45-45 45-45-20.1875-45-45 20.1875-45 45-45zm0 0" />
                            <path
                                d="m0 300h512v-300h-512zm451-105h-90v-30h90zm-90-150h90v30h-90zm-60 0h30v30h-30zm0 60h150v30h-150zm0 60h30v30h-30zm0 60h150v30h-150zm-135-180c57.890625 0 105 47.109375 105 105s-47.109375 105-105 105-105-47.109375-105-105 47.109375-105 105-105zm0 0" />
                            <path d="m181 452v30h-60v30h270v-30h-60v-30zm0 0" />
                        </svg>
                        <span class="menu-title siebartext" data-i18n="">CMS</span>

                    </a>
                    <ul class="menu-content">
                        <li class="sub-menu cms-list ">
                            <a href="{{ route('cms.index') }}">
                                CMS Page List
                            </a>
                        </li>
                        <li class="sub-menu cms-create">
                            <a href="{{ route('cms.create') }}">
                                CMS Page Create
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['quiz-list','quiz-create', 'quiz-edit',
                'quiz-delete','quizCategory-list','quizCategory-create','quizCategory-edit','quizCategory-delete'])
                <li class="nav-item sub-menu has-sub faq-sub-menu {{ Request::is('admin/quiz*') ? 'active' : '' }}">
                    <a class="menu-item" href="#">

                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 512 512" width="20">
                            <path
                                d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 405.332031c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031 21.332031 9.554687 21.332031 21.332031-9.554687 21.332031-21.332031 21.332031zm33.769531-135.636719c-7.550781 3.476563-12.4375 11.09375-12.4375 19.394532v9.578125c0 11.773437-9.535156 21.332031-21.332031 21.332031s-21.332031-9.558594-21.332031-21.332031v-9.578125c0-24.898438 14.632812-47.722656 37.226562-58.15625 21.738281-10.003906 37.4375-36.566406 37.4375-49.601563 0-29.394531-23.914062-53.332031-53.332031-53.332031s-53.332031 23.9375-53.332031 53.332031c0 11.777344-9.539063 21.335938-21.335938 21.335938s-21.332031-9.558594-21.332031-21.335938c0-52.925781 43.070312-96 96-96s96 43.074219 96 96c0 28.824219-25.003906 71.191407-62.230469 88.363281zm0 0" />
                        </svg>
                        <span class="" data-i18n="">Questions</span>

                    </a>
                    <ul class="menu-content">
                        <li class="sub-menu quiz-list">
                            <a href="{{ route('quiz.index') }}">
                                Question's List
                            </a>
                        </li>
                        {{-- <li class="sub-menu quiz-create">
                        <a href="{{ route('quiz.create') }}">
                        Question Create
                        </a>
                </li> --}}
                @canany(['quizCategory-list', 'quizCategory-edit', 'quizCategory-delete'])
                <li class="sub-menu quiz-category-list {{ Request::is('admin/quizcategory') ? 'active' : '' }} ">
                    <a href="{{ route('quizCategory.index') }}">
                        Question Category List
                    </a>
                </li>
                @endcanany
                @canany(['quizCategory-create'])
                <li
                    class="sub-menu quiz-category-create {{ Request::is('admin/quizcategory/create') ? 'active' : '' }} ">
                    <a href="{{ route('quizCategory.create') }}">
                        Question Category Create
                    </a>
                </li>
                @endcanany
            </ul>
            </li>
            @endcanany


            <!-- -->
            {{--   @canany(['quiz-list','quiz-create', 'quiz-edit', 'quiz-delete','quizCategory-list','quizCategory-create','quizCategory-edit','quizCategory-delete']) --}}
            <li
                class="nav-item sub-menu has-sub casemanagement-sub-menu {{-- {{ Request::is('admin/ipledgeimports') ? 'active' : '' }} --}}">
                <a class="menu-item" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20"
                        version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 449.353 449.353"
                        style="enable-background:new 0 0 449.353 449.353;" xml:space="preserve">
                        <g>
                            <g>
                                <g>
                                    <circle cx="224.676" cy="39.729" r="39.184" />
                                    <path
                                        d="M239.86,88.33c-0.185-0.005-0.37-0.01-0.555-0.013h-29.257c-30.003,0.564-53.867,25.344-53.303,55.347     c0.003,0.185,0.008,0.37,0.013,0.555v8.359c0,4.18,1.567,8.882,6.269,8.882h123.298c4.702,0,6.269-4.702,6.269-8.882v-8.359     C293.465,114.224,269.855,89.201,239.86,88.33z" />
                                    <path
                                        d="M54.88,260.725c4.328,0,7.837-3.509,7.837-7.837c-0.109-49.175,22.201-95.718,60.604-126.433     c3.281-2.356,4.032-6.926,1.676-10.207c-0.193-0.269-0.404-0.524-0.631-0.764c-2.753-3.295-7.646-3.761-10.971-1.045     c-41.948,33.715-66.349,84.631-66.351,138.449C47.044,257.217,50.552,260.725,54.88,260.725z" />
                                    <path
                                        d="M276.399,406.488L276.399,406.488c-33.431,10.967-69.491,10.967-102.922,0c-4.118-1.333-8.536,0.924-9.87,5.041     c-0.02,0.061-0.039,0.122-0.057,0.183c-1.067,4.16,1.192,8.451,5.224,9.927c18.054,5.869,36.918,8.866,55.902,8.882     c19.37,0.019,38.611-3.158,56.947-9.404c3.845-1.986,5.353-6.714,3.367-10.559C283.37,407.421,279.852,405.755,276.399,406.488z" />
                                    <path
                                        d="M318.094,120.64c0.033,0.023,0.067,0.046,0.101,0.069c42.84,30.405,68.337,79.646,68.441,132.18     c0,4.328,3.509,7.837,7.837,7.837s7.837-3.509,7.837-7.837c-0.144-57.724-28.166-111.822-75.233-145.241     c-3.654-2.207-8.384-1.306-10.971,2.09C313.643,113.298,314.534,118.179,318.094,120.64z" />
                                    <circle cx="67.941" cy="327.076" r="39.184" />
                                    <path
                                        d="M83.125,375.677c-0.185-0.005-0.37-0.01-0.555-0.013H53.313C23.31,376.228-0.555,401.008,0.01,431.011     c0.003,0.185,0.008,0.37,0.013,0.555v8.359c0,4.18,1.567,8.882,6.269,8.882H129.59c4.702,0,6.269-4.702,6.269-8.882v-8.359     C136.731,401.57,113.121,376.548,83.125,375.677z" />
                                    <circle cx="381.411" cy="327.076" r="39.184" />
                                    <path
                                        d="M396.594,375.677c-0.185-0.005-0.37-0.01-0.555-0.013h-29.257c-30.003,0.564-53.867,25.344-53.303,55.347     c0.003,0.185,0.008,0.37,0.013,0.555v8.359c0,4.18,1.567,8.882,6.269,8.882H443.06c4.702,0,6.269-4.702,6.269-8.882v-8.359     C450.2,401.57,426.59,376.548,396.594,375.677z" />
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span class="" data-i18n="">Case Management</span>
                </a>
                <ul class="menu-content">
                    <li class="sub-menu casemanagement-list">
                        <a href="{{ route('casemanagement.index') }}">
                            Case Management List
                        </a>
                    </li>
                    {{-- <li class="sub-menu ipledgeimports-create">
                      <a href="{{ route('ipledgeimports.create') }}">
                    Ipledge Imports Create
                    </a>
            </li> --}}
            </ul>
            </li>
            {{-- @endcanany --}}
            <!-- -->
            <!---->

            <li
                class="nav-item sub-menu has-sub mdmanagement-sub-menu {{ Request::is('admin/mdmanagement*') ? 'active' : '' }}">
                <a class="menu-item" href="#">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 511.938 511.938" height="20" viewBox="0 0 511.938 511.938" width="20"><g><path d="m217.941 11.378h73.482v88.591h-73.482z"/><path d="m217.941 134.067h73.482v45.448h-73.482z"/><path d="m27.275 134.067v162.625c10.57 2.002 20.58 7.315 28.39 15.793l56.29 61.1c.144.157.298.303.445.458v-12.434c0-26.147 21.272-47.418 47.418-47.418h78.825c9.787 1.106 35.702-13.721 44.638-17.274 37.94-17.638 81.122-16.941 118.472 1.912l22.715 11.538c6.361-20.427 24.622-35.225 46.112-35.225h13.471v-141.075h-158.53v62.497c0 9.416-7.633 17.049-17.049 17.049h-107.58c-9.416 0-17.049-7.633-17.049-17.049v-62.497z"/><path d="m325.521 99.969h158.529v-64.943c0-13.061-8.798-23.648-19.651-23.648h-138.878z"/><path d="m470.578 309.24c-7.956 0-14.428 7.637-14.428 17.024v152.404c0 9.387 6.473 17.024 14.428 17.024h26.931c7.956 0 14.429-7.637 14.429-17.024v-152.404c0-9.387-6.473-17.024-14.429-17.024z"/><path d="m183.844 11.378h-140.238c-9.019 0-16.331 8.799-16.331 19.653v68.938h156.569z"/><path d="m30.587 335.588c-15.064-15.064-40.707 4.627-26.378 22.147l76.792 93.094c26.07 31.604 64.519 49.73 105.488 49.73h86.856c32.255 0 64.519-3.788 95.895-11.259l52.813-12.631v-129.284l-35.704-18.136c-27.936-14.101-60.279-14.623-88.693-1.412l-30.367 14.118c-8.912 4.143-18.818 6.333-28.646 6.333h-78.825c-7.345 0-13.321 5.975-13.321 13.321v25.827h153.113c9.416 0 17.049 7.633 17.049 17.049s-7.633 17.049-17.049 17.049h-156.062c-19.78.239-42.502-9.027-56.671-24.845z"/></g></svg> -->
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 297 297"
                        xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 297 297">
                        <g>
                            <path
                                d="m148.5,70.879c-15.685,0-28.445,12.761-28.445,28.446 0,15.685 12.761,28.445 28.445,28.445s28.445-12.761 28.445-28.445c0-15.686-12.76-28.446-28.445-28.446zm0,40.087c-6.419,0-11.641-5.222-11.641-11.641 0-6.419 5.222-11.642 11.641-11.642s11.641,5.222 11.641,11.642c0,6.418-5.222,11.641-11.641,11.641z" />
                            <path
                                d="m256.741,86.593h-18.101c-1.419-4.256-3.143-8.411-5.159-12.433l12.806-12.805c3.281-3.281 3.281-8.602 0-11.883l-30.616-30.616c-3.282-3.28-8.601-3.28-11.883,0l-12.805,12.806c-4.024-2.016-8.177-3.74-12.433-5.159v-18.101c0-4.64-3.762-8.402-8.402-8.402h-43.297c-4.64,0-8.402,3.762-8.402,8.402v18.101c-4.255,1.419-8.409,3.143-12.433,5.159l-12.805-12.805c-3.28-3.28-8.6-3.279-11.882,0l-30.616,30.614c-1.575,1.576-2.461,3.713-2.461,5.942 0,2.228 0.885,4.365 2.461,5.942l12.806,12.805c-2.016,4.023-3.74,8.177-5.159,12.433h-18.101c-4.64,0-8.402,3.762-8.402,8.402v43.296c0,4.64 3.762,8.402 8.402,8.402h18.101c1.419,4.256 3.143,8.41 5.159,12.433l-12.806,12.805c-1.575,1.576-2.461,3.714-2.461,5.942 0,2.229 0.885,4.365 2.461,5.942l30.616,30.615c3.282,3.28 8.601,3.28 11.883,0l7.41-7.41c0.21,0.529 0.454,1.046 0.77,1.526l14.517,22.09v57.962c0,4.64 3.762,8.402 8.402,8.402h48.381c4.64,0 8.402-3.762 8.402-8.402v-57.962l14.517-22.09c0.316-0.48 0.56-0.997 0.769-1.526l7.41,7.41c3.28,3.278 8.599,3.28 11.883,0l30.616-30.615c1.575-1.576 2.461-3.713 2.461-5.942 0-2.228-0.885-4.365-2.461-5.942l-12.806-12.805c2.016-4.024 3.74-8.178 5.159-12.433h18.101c4.64,0 8.402-3.762 8.402-8.402v-43.296c-0.002-4.64-3.764-8.402-8.404-8.402zm-76.556,114.825l-14.517,22.09c-0.901,1.371-1.38,2.974-1.38,4.614v52.074h-31.576v-52.074c0-1.64-0.48-3.244-1.38-4.614l-14.517-22.09v-40.701c0-4.883 3.093-9.203 7.706-10.78l1.796-.551 15.896,17.925c1.595,1.798 3.883,2.827 6.286,2.827s4.692-1.029 6.286-2.827l15.896-17.925 1.796,.551c4.613,1.576 7.706,5.897 7.706,10.78v40.701zm-2.472-67.451c-0.065-0.021-7.267-2.231-7.267-2.231-3.15-0.966-6.568-0.004-8.75,2.458l-13.194,14.877-13.194-14.878c-2.184-2.462-5.607-3.424-8.75-2.458 0,0-7.202,2.21-7.267,2.231-7.177,2.393-12.886,7.463-16.176,13.88-6.124-8.878-9.72-19.626-9.72-31.204 0-30.386 24.721-55.107 55.107-55.107s55.107,24.721 55.107,55.107c0,11.576-3.601,22.319-9.725,31.196-3.29-6.413-8.997-11.479-16.171-13.871zm70.628-4.078h-15.974c-3.834,0-7.182,2.595-8.137,6.308-1.816,7.056-4.63,13.837-8.363,20.156-1.95,3.3-1.418,7.504 1.293,10.215l11.306,11.305-18.733,18.732-11.306-11.305c-0.439-0.439-0.928-0.799-1.435-1.121v-17.214c13.208-12.726 21.445-30.575 21.445-50.322 0-38.562-31.372-69.934-69.934-69.934s-69.934,31.372-69.934,69.934c0,19.747 8.237,37.595 21.445,50.32v17.214c-0.508,0.323-0.997,0.683-1.436,1.123l-11.306,11.305-18.733-18.732 11.306-11.305c2.711-2.712 3.243-6.915 1.292-10.216-3.732-6.316-6.545-13.097-8.362-20.154-0.955-3.714-4.302-6.308-8.137-6.308h-15.975v-26.492h15.974c3.834,0 7.182-2.596 8.137-6.308 1.817-7.058 4.63-13.839 8.362-20.155 1.951-3.301 1.419-7.504-1.292-10.216l-11.305-11.306 18.733-18.732 11.306,11.305c2.71,2.71 6.914,3.244 10.214,1.293 6.319-3.733 13.101-6.547 20.155-8.363 3.714-0.955 6.308-4.302 6.308-8.137v-15.974h26.493v15.974c0,3.834 2.595,7.182 6.308,8.137 7.055,1.816 13.836,4.63 20.155,8.363 3.3,1.951 7.503,1.417 10.215-1.293l11.306-11.306 18.733,18.733-11.306,11.305c-2.711,2.712-3.243,6.915-1.292,10.216 3.732,6.316 6.545,13.098 8.362,20.155 0.955,3.713 4.302,6.308 8.137,6.308h15.974v26.492z" />
                        </g>
                    </svg>
                    <span class="menu-title siebartext" data-i18n="">Md Management</span>

                </a>
                <ul class="menu-content">
                    <li class="sub-menu mdmanagement-list ">
                        <a href="{{ route('mdmanagement.index') }}">
                            Md List
                        </a>
                    </li>
                    <li class="sub-menu  mdmanagement-create">
                        <a href="{{ route('mdmanagement.create') }}">
                            Md Create
                        </a>
                    </li>
                </ul>
            </li>

            <!-- -->
            <!---->

            @canany(['cms-list', 'cms-create', 'cms-edit', 'cms-delete'])
            <li
                class="nav-item sub-menu has-sub guides-sub-menu {{ Request::is('admin/treatmentGuides*') ? 'active' : '' }}">
                <a class="menu-item" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" enable-background="new 0 0 512 512" height="20"
                        viewBox="0 0 512 512" width="20">
                        <g>
                            <circle cx="256" cy="119.631" r="87" />
                            <circle cx="432" cy="151.63" r="55" />
                            <circle cx="80" cy="151.63" r="55" />
                            <path
                                d="m134.19 256.021c-21.65-17.738-41.257-15.39-66.29-15.39-37.44 0-67.9 30.28-67.9 67.49v109.21c0 16.16 13.19 29.3 29.41 29.3 70.026 0 61.59 1.267 61.59-3.02 0-77.386-9.166-134.137 43.19-187.59z" />
                            <path
                                d="m279.81 241.03c-43.724-3.647-81.729.042-114.51 27.1-54.857 43.94-44.3 103.103-44.3 175.48 0 19.149 15.58 35.02 35.02 35.02 211.082 0 219.483 6.809 232-20.91 4.105-9.374 2.98-6.395 2.98-96.07 0-71.226-61.673-120.62-111.19-120.62z" />
                            <path
                                d="m444.1 240.63c-25.17 0-44.669-2.324-66.29 15.39 51.965 53.056 43.19 105.935 43.19 187.59 0 4.314-7.003 3.02 60.54 3.02 16.8 0 30.46-13.61 30.46-30.34v-108.17c0-37.21-30.46-67.49-67.9-67.49z" />
                        </g>
                    </svg>
                    <span class="menu-title siebartext" data-i18n="">Treatment Guides</span>

                </a>
                <ul class="menu-content">
                    <li class="sub-menu guides-list ">
                        <a href="{{ route('treatmentGuides.index') }}">
                            Guides List
                        </a>
                    </li>
                    <li class="sub-menu guides-create">
                        <a href="{{ route('treatmentGuides.create') }}">
                            Guides Create
                        </a>
                    </li>
                </ul>
            </li>
            @endcanany

            <li
                class="nav-item sub-menu has-sub ordermanagement-sub-menu {{ Request::is('admin/ordermanagement*') ? 'active' : '' }}">
                <a class="menu-item" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 511.938 511.938"
                        height="20" viewBox="0 0 511.938 511.938" width="20">
                        <g>
                            <path d="m217.941 11.378h73.482v88.591h-73.482z" />
                            <path d="m217.941 134.067h73.482v45.448h-73.482z" />
                            <path
                                d="m27.275 134.067v162.625c10.57 2.002 20.58 7.315 28.39 15.793l56.29 61.1c.144.157.298.303.445.458v-12.434c0-26.147 21.272-47.418 47.418-47.418h78.825c9.787 1.106 35.702-13.721 44.638-17.274 37.94-17.638 81.122-16.941 118.472 1.912l22.715 11.538c6.361-20.427 24.622-35.225 46.112-35.225h13.471v-141.075h-158.53v62.497c0 9.416-7.633 17.049-17.049 17.049h-107.58c-9.416 0-17.049-7.633-17.049-17.049v-62.497z" />
                            <path d="m325.521 99.969h158.529v-64.943c0-13.061-8.798-23.648-19.651-23.648h-138.878z" />
                            <path
                                d="m470.578 309.24c-7.956 0-14.428 7.637-14.428 17.024v152.404c0 9.387 6.473 17.024 14.428 17.024h26.931c7.956 0 14.429-7.637 14.429-17.024v-152.404c0-9.387-6.473-17.024-14.429-17.024z" />
                            <path d="m183.844 11.378h-140.238c-9.019 0-16.331 8.799-16.331 19.653v68.938h156.569z" />
                            <path
                                d="m30.587 335.588c-15.064-15.064-40.707 4.627-26.378 22.147l76.792 93.094c26.07 31.604 64.519 49.73 105.488 49.73h86.856c32.255 0 64.519-3.788 95.895-11.259l52.813-12.631v-129.284l-35.704-18.136c-27.936-14.101-60.279-14.623-88.693-1.412l-30.367 14.118c-8.912 4.143-18.818 6.333-28.646 6.333h-78.825c-7.345 0-13.321 5.975-13.321 13.321v25.827h153.113c9.416 0 17.049 7.633 17.049 17.049s-7.633 17.049-17.049 17.049h-156.062c-19.78.239-42.502-9.027-56.671-24.845z" />
                        </g>
                    </svg>
                    <span class="menu-title siebartext" data-i18n="">Order Management</span>

                </a>
                <ul class="menu-content">
                    <li class="sub-menu ordermanagement-list ">
                        <a href="{{ route('ordermanagement.index') }}">
                            Order Management List
                        </a>
                    </li>
                    <!-- <li class="sub-menu  mdmanagement-create">
                          <a href="{{ route('mdmanagement.create') }}">
                            Md Management Create
                          </a>                          
                        </li>  -->
                </ul>
            </li>

            <!---->
            <!-- -->
            {{--   @canany(['quiz-list','quiz-create', 'quiz-edit', 'quiz-delete','quizCategory-list','quizCategory-create','quizCategory-edit','quizCategory-delete']) --}}
            <li
                class="nav-item sub-menu has-sub ipledgeimports-sub-menu {{-- {{ Request::is('admin/ipledgeimports') ? 'active' : '' }} --}}">
                <a class="menu-item" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        id="Icons" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;"
                        width="20px" height="20px" xml:space="preserve">
                        <style type="text/css">
                        .st0 {
                            fill: none;
                            stroke: #000000;
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }

                        .st1 {
                            fill: none;
                            stroke: #000000;
                            stroke-width: 2;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }
                        </style>
                        <polyline class="st0" points="7,16 7,29 25,29 25,9 " />
                        <polyline class="st0" points="19,3 19,9 25,9 19,3 7,3 7,16 " />
                        <line class="st0" x1="3" y1="16" x2="16" y2="16" />
                        <polyline class="st0" points="12,12 16,16 12,20 " />
                    </svg>
                    <span class="" data-i18n="">Ipledge Imports</span>
                </a>
                <ul class="menu-content">
                    <li class="sub-menu ipledgeimports-list">
                        <a href="{{ route('ipledgeimports.index') }}">
                            Ipledge Imports List
                        </a>
                    </li>
                    <li class="sub-menu ipledgeimports-create">
                        <a href="{{ route('ipledgeimports.create') }}">
                            Ipledge Imports Create
                        </a>
                    </li>
                </ul>
            </li>
            {{-- @endcanany --}}

            <!-- -->
            {{--   @Offers & Promotions(['quiz-list','quiz-create', 'quiz-edit', 'quiz-delete','quizCategory-list','quizCategory-create','quizCategory-edit','quizCategory-delete']) --}}
            <li
                class="nav-item sub-menu has-sub offer-promotion-sub-menu {{-- {{ Request::is('admin/ipledgeimports') ? 'active' : '' }} --}}">
                <a class="menu-item" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        id="Capa_1" x="0px" y="0px" viewBox="0 0 486.982 486.982" width="20px" height="20px"
                        style="enable-background:new 0 0 486.982 486.982;" xml:space="preserve" height="20" width="20">
                        <g>
                            <path
                                d="M131.35,422.969c14.6,14.6,38.3,14.6,52.9,0l181.1-181.1c5.2-5.2,9.2-11.4,11.8-18c18.2,5.1,35.9,7.8,51.5,7.7   c38.6-0.2,51.4-17.1,55.6-27.2c4.2-10,7.2-31-19.9-58.6c-0.3-0.3-0.6-0.6-0.9-0.9c-16.8-16.8-41.2-32.3-68.9-43.8   c-5.1-2.1-10.2-4-15.2-5.8v-0.3c-0.3-22.2-18.2-40.1-40.4-40.4l-108.5-1.5c-14.4-0.2-28.2,5.4-38.3,15.6l-181.2,181.1   c-14.6,14.6-14.6,38.3,0,52.9L131.35,422.969z M270.95,117.869c12.1-12.1,31.7-12.1,43.8,0c7.2,7.2,10.1,17.1,8.7,26.4   c11.9,8.4,26.1,16.2,41.3,22.5c5.4,2.2,10.6,4.2,15.6,5.9l-0.6-43.6c0.9,0.4,1.7,0.7,2.6,1.1c23.7,9.9,45,23.3,58.7,37   c0.2,0.2,0.4,0.4,0.6,0.6c13,13.3,14.4,21.8,13.3,24.4c-3.4,8.1-39.9,15.3-95.3-7.8c-16.2-6.8-31.4-15.2-43.7-24.3   c-0.4,0.5-0.9,1-1.3,1.5c-12.1,12.1-31.7,12.1-43.8,0C258.85,149.569,258.85,129.969,270.95,117.869z" />
                        </g>
                    </svg>
                    <span class="" data-i18n="">Offers & Promotions</span>
                </a>
                <ul class="menu-content">
                    <li class="sub-menu offer-promotion-list">
                        <a href="{{ route('offers.index') }}">
                            Offers & Promotions List
                        </a>
                    </li>
                    <li class="sub-menu offer-promotion-create">
                        <a href="{{ route('offers.create') }}">
                            Offers & Promotions Create
                        </a>
                    </li>
                </ul>
            </li>
            {{-- @endcanany --}}

            <!---->

            @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete, faq-list','faq-create', 'faq-edit',
            'faq-delete', 'tag-list', 'tag-create', 'tag-edit', 'tag-delete', 'testimonial-list', 'testimonial-create',
            'testimonial-edit', 'testimonial-delete'])
            <li class="nav-item sub-menu has-sub setting-sub-menu">
                <a class="menu-item" href="#">

                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="20"
                        viewBox="0 0 24 24" width="20">
                        <path
                            d="m22.683 9.394-1.88-.239c-.155-.477-.346-.937-.569-1.374l1.161-1.495c.47-.605.415-1.459-.122-1.979l-1.575-1.575c-.525-.542-1.379-.596-1.985-.127l-1.493 1.161c-.437-.223-.897-.414-1.375-.569l-.239-1.877c-.09-.753-.729-1.32-1.486-1.32h-2.24c-.757 0-1.396.567-1.486 1.317l-.239 1.88c-.478.155-.938.345-1.375.569l-1.494-1.161c-.604-.469-1.458-.415-1.979.122l-1.575 1.574c-.542.526-.597 1.38-.127 1.986l1.161 1.494c-.224.437-.414.897-.569 1.374l-1.877.239c-.753.09-1.32.729-1.32 1.486v2.24c0 .757.567 1.396 1.317 1.486l1.88.239c.155.477.346.937.569 1.374l-1.161 1.495c-.47.605-.415 1.459.122 1.979l1.575 1.575c.526.541 1.379.595 1.985.126l1.494-1.161c.437.224.897.415 1.374.569l.239 1.876c.09.755.729 1.322 1.486 1.322h2.24c.757 0 1.396-.567 1.486-1.317l.239-1.88c.477-.155.937-.346 1.374-.569l1.495 1.161c.605.47 1.459.415 1.979-.122l1.575-1.575c.542-.526.597-1.379.127-1.985l-1.161-1.494c.224-.437.415-.897.569-1.374l1.876-.239c.753-.09 1.32-.729 1.32-1.486v-2.24c.001-.757-.566-1.396-1.316-1.486zm-10.683 7.606c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z" />
                    </svg>
                    <span class="menu-title siebartext" data-i18n="">Settings</span>

                </a>
                <ul class="menu-content">
                    @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
                    <li
                        class="nav-item sub-menu has-sub blog-sub-menu {{ Request::is('admin/blog*') ? 'active' : '' }}">
                        <a class="menu-item" href="#">

                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="1 0 511 511.99995" width="20">
                                <path
                                    d="m450.675781 125.457031-63.636719-63.636719-118.496093 119.488282 63.648437 63.644531zm0 0" />
                                <path
                                    d="m211.527344 282.316406c-5.152344 12.371094 7.269531 24.777344 19.632812 19.609375l76.175782-39.40625-56.4375-56.4375zm0 0" />
                                <path
                                    d="m508.105469 68.027344c5.859375-5.859375 5.859375-15.355469 0-21.214844l-42.421875-42.417969c-5.859375-5.859375-15.355469-5.859375-21.214844 0l-36.214844 36.214844 63.632813 63.636719zm0 0" />
                                <path
                                    d="m45.5 421h15v76c0 6.0625 3.648438 11.542969 9.257812 13.855469 5.527344 2.308593 12.015626 1.078125 16.347657-3.25l86.605469-86.605469h174.789062c24.8125 0 45-20.1875 45-45v-148.933594l-47.316406 47.316406c-4.128906 4.132813-8.949219 7.382813-14.355469 9.652344l-85.882813 44.53125c-7.808593 3.371094-13.667968 4.558594-19.644531 4.558594-4.464843 0-8.769531-.859375-12.929687-2.125h-106.871094c-8.292969 0-15-6.710938-15-15 0-8.292969 6.707031-15 15-15h75.957031c-2.960937-9.820312-1.691406-20.457031 2.390625-30.21875l46.289063-89.898438c1.316406-3.324218 4.570312-8.160156 8.6875-12.273437l47.609375-47.609375h-240.933594c-24.8125 0-45 20.1875-45 45v210c0 24.8125 20.1875 45 45 45zm0 0" />
                            </svg>
                            <span class="" data-i18n="">Blogs</span>

                        </a>
                        <ul class="menu-content">
                            <li class="sub-menu blog-list">
                                <a href="{{ route('blog.index') }}">
                                    Blog List
                                </a>
                            </li>
                            <li class="sub-menu blog-create">
                                <a href="{{ route('blog.create') }}">
                                    Blog Create
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcanany
                    @canany(['faq-list','faq-create', 'faq-edit',
                    'faq-delete','faq_category-list','faq-category-create','faq-category-edit','faq-category-delete'])
                    <li class="nav-item sub-menu has-sub faq-sub-menu {{ Request::is('admin/faq*') ? 'active' : '' }}">
                        <a class="menu-item" href="#">

                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 512 512" width="20">
                                <path
                                    d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 405.332031c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031 21.332031 9.554687 21.332031 21.332031-9.554687 21.332031-21.332031 21.332031zm33.769531-135.636719c-7.550781 3.476563-12.4375 11.09375-12.4375 19.394532v9.578125c0 11.773437-9.535156 21.332031-21.332031 21.332031s-21.332031-9.558594-21.332031-21.332031v-9.578125c0-24.898438 14.632812-47.722656 37.226562-58.15625 21.738281-10.003906 37.4375-36.566406 37.4375-49.601563 0-29.394531-23.914062-53.332031-53.332031-53.332031s-53.332031 23.9375-53.332031 53.332031c0 11.777344-9.539063 21.335938-21.335938 21.335938s-21.332031-9.558594-21.332031-21.335938c0-52.925781 43.070312-96 96-96s96 43.074219 96 96c0 28.824219-25.003906 71.191407-62.230469 88.363281zm0 0" />
                            </svg>
                            <span class="" data-i18n="">FAQ's</span>

                        </a>
                        <ul class="menu-content">
                            <li class="sub-menu faq-list">
                                <a href="{{ route('faqs.index') }}">
                                    FAQ's List
                                </a>
                            </li>
                            <li class="sub-menu faq-create">
                                <a href="{{ route('faqs.create') }}">
                                    FAQ Create
                                </a>
                            </li>
                            @canany(['faqCategory-list', 'faqCategory-edit', 'faqCategory-delete'])
                            <li
                                class="sub-menu faq-category-list {{ Request::is('admin/faqcategory') ? 'active' : '' }} ">
                                <a href="{{ route('faqcategory.index') }}">
                                    FAQ Category List
                                </a>
                            </li>
                            @endcanany
                            @canany(['faqCategory-create'])
                            <li
                                class="sub-menu faq-category-create {{ Request::is('admin/faqcategory/create') ? 'active' : '' }} ">
                                <a href="{{ route('faqcategory.create') }}">
                                    FAQ Category Create
                                </a>
                            </li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany



                    @canany(['tag-list', 'tag-create', 'tag-edit', 'tag-delete'])
                    <li class="nav-item sub-menu has-sub tag-sub-menu {{ Request::is('admin/tags*') ? 'active' : '' }}">
                        <a class="menu-item" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 486.982 486.982"
                                style="enable-background:new 0 0 486.982 486.982;" xml:space="preserve" height="20"
                                width="20">
                                <g>
                                    <path
                                        d="M131.35,422.969c14.6,14.6,38.3,14.6,52.9,0l181.1-181.1c5.2-5.2,9.2-11.4,11.8-18c18.2,5.1,35.9,7.8,51.5,7.7   c38.6-0.2,51.4-17.1,55.6-27.2c4.2-10,7.2-31-19.9-58.6c-0.3-0.3-0.6-0.6-0.9-0.9c-16.8-16.8-41.2-32.3-68.9-43.8   c-5.1-2.1-10.2-4-15.2-5.8v-0.3c-0.3-22.2-18.2-40.1-40.4-40.4l-108.5-1.5c-14.4-0.2-28.2,5.4-38.3,15.6l-181.2,181.1   c-14.6,14.6-14.6,38.3,0,52.9L131.35,422.969z M270.95,117.869c12.1-12.1,31.7-12.1,43.8,0c7.2,7.2,10.1,17.1,8.7,26.4   c11.9,8.4,26.1,16.2,41.3,22.5c5.4,2.2,10.6,4.2,15.6,5.9l-0.6-43.6c0.9,0.4,1.7,0.7,2.6,1.1c23.7,9.9,45,23.3,58.7,37   c0.2,0.2,0.4,0.4,0.6,0.6c13,13.3,14.4,21.8,13.3,24.4c-3.4,8.1-39.9,15.3-95.3-7.8c-16.2-6.8-31.4-15.2-43.7-24.3   c-0.4,0.5-0.9,1-1.3,1.5c-12.1,12.1-31.7,12.1-43.8,0C258.85,149.569,258.85,129.969,270.95,117.869z" />
                                </g>
                            </svg>
                            <span class="" data-i18n="">Tags</span>

                        </a>
                        <ul class="menu-content">
                            <li class="sub-menu tag-list">
                                <a href="{{ route('tags.index') }}">
                                    Tags List
                                </a>
                            </li>
                            <li class="sub-menu tag-create">
                                <a href="{{ route('tags.create') }}">
                                    Tag Create
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcanany
                    @canany(['testimonial-list', 'testimonial-create', 'testimonial-edit', 'testimonial-delete'])
                    <li
                        class="nav-item sub-menu has-sub testimonial-sub-menu {{ Request::is('admin/testimonials*') ? 'active' : '' }}">
                        <a class="menu-item" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 372.96 372.96" style="enable-background:new 0 0 372.96 372.96;"
                                xml:space="preserve">

                                <g>
                                    <path
                                        d="M133.04,128.128c-8.922-8.95-21.043-13.974-33.68-13.96c26.311-0.007-47.646,21.316-47.653,47.627    s21.316,47.646,47.627,47.653s47.646-21.316,47.653-47.627C146.99,149.185,141.973,137.065,133.04,128.128z" />
                                </g>


                                <g>
                                    <path
                                        d="M101.92,225.008h-5.08C43.411,225.14,0.132,268.42,0,321.848v6.84c0,3.756,3.044,6.8,6.8,6.8h185.12    c3.756,0,6.8-3.044,6.8-6.8v-6.84C198.566,268.444,155.324,225.184,101.92,225.008z" />
                                </g>

                                <g>
                                    <path
                                        d="M340.64,60.568c-22.035-15.432-48.382-23.509-75.28-23.08c-26.898-0.429-53.245,7.648-75.28,23.08    c-20,14.72-32.32,35.2-32.32,58c0.032,10.316,2.557,20.471,7.36,29.6c4.292,8.129,9.963,15.451,16.76,21.64l-17.08,35.48    c-1.635,3.357-0.239,7.403,3.118,9.037c2.102,1.024,4.584,0.889,6.562-0.357l39.28-24.24c7.471,3.05,15.212,5.394,23.12,7    c9.372,1.919,18.914,2.884,28.48,2.88c26.898,0.429,53.245-7.648,75.28-23.08c20-14.72,32.32-35.2,32.32-58    C372.96,95.728,360.6,75.288,340.64,60.568z M316.372,107.636c-0.004,0.017-0.008,0.035-0.012,0.052h0    c-0.266,1.185-0.846,2.277-1.68,3.16l-17.44,20l2.32,26.84c0.327,3.741-2.44,7.039-6.182,7.367    c-1.307,0.114-2.619-0.152-3.778-0.767l-24.24-10.2l-24.8,10.52c-3.43,1.474-7.406-0.111-8.88-3.541    c-0.446-1.039-0.625-2.173-0.52-3.299l2.32-26.84l-17.64-20.44c-2.443-2.853-2.11-7.145,0.743-9.588    c0.823-0.705,1.803-1.203,2.857-1.452l26.2-6.08l13.88-22.88c1.924-3.225,6.098-4.28,9.323-2.357    c0.969,0.578,1.779,1.388,2.357,2.357l13.8,22.96l26.2,6.08C314.867,100.339,317.183,103.969,316.372,107.636z" />
                                </g>
                            </svg>
                            <span class="" data-i18n="">Testimonials</span>

                        </a>
                        <ul class="menu-content">
                            <li class="sub-menu testimonial-list">
                                <a href="{{ route('testimonials.index') }}">
                                    Testimonials List
                                </a>
                            </li>
                            <li class="sub-menu testimonial-create">
                                <a href="{{ route('testimonials.create') }}">
                                    Testimonial Create
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan

                    <!--fees-->
                    {{--  @canany(['testimonial-list', 'testimonial-create', 'testimonial-edit', 'testimonial-delete']) --}}
                    <li class="nav-item sub-menu has-sub fee-sub-menu {{ Request::is('admin/fees*') ? 'active' : '' }}">
                        <a class="menu-item" href="#">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 372.96 372.96" style="enable-background:new 0 0 372.96 372.96;" xml:space="preserve">

                              <g>
                                <path d="M133.04,128.128c-8.922-8.95-21.043-13.974-33.68-13.96c26.311-0.007-47.646,21.316-47.653,47.627    s21.316,47.646,47.627,47.653s47.646-21.316,47.653-47.627C146.99,149.185,141.973,137.065,133.04,128.128z"/>
                              </g>


                              <g>
                                <path d="M101.92,225.008h-5.08C43.411,225.14,0.132,268.42,0,321.848v6.84c0,3.756,3.044,6.8,6.8,6.8h185.12    c3.756,0,6.8-3.044,6.8-6.8v-6.84C198.566,268.444,155.324,225.184,101.92,225.008z"/>
                              </g>

                              <g>
                                <path d="M340.64,60.568c-22.035-15.432-48.382-23.509-75.28-23.08c-26.898-0.429-53.245,7.648-75.28,23.08    c-20,14.72-32.32,35.2-32.32,58c0.032,10.316,2.557,20.471,7.36,29.6c4.292,8.129,9.963,15.451,16.76,21.64l-17.08,35.48    c-1.635,3.357-0.239,7.403,3.118,9.037c2.102,1.024,4.584,0.889,6.562-0.357l39.28-24.24c7.471,3.05,15.212,5.394,23.12,7    c9.372,1.919,18.914,2.884,28.48,2.88c26.898,0.429,53.245-7.648,75.28-23.08c20-14.72,32.32-35.2,32.32-58    C372.96,95.728,360.6,75.288,340.64,60.568z M316.372,107.636c-0.004,0.017-0.008,0.035-0.012,0.052h0    c-0.266,1.185-0.846,2.277-1.68,3.16l-17.44,20l2.32,26.84c0.327,3.741-2.44,7.039-6.182,7.367    c-1.307,0.114-2.619-0.152-3.778-0.767l-24.24-10.2l-24.8,10.52c-3.43,1.474-7.406-0.111-8.88-3.541    c-0.446-1.039-0.625-2.173-0.52-3.299l2.32-26.84l-17.64-20.44c-2.443-2.853-2.11-7.145,0.743-9.588    c0.823-0.705,1.803-1.203,2.857-1.452l26.2-6.08l13.88-22.88c1.924-3.225,6.098-4.28,9.323-2.357    c0.969,0.578,1.779,1.388,2.357,2.357l13.8,22.96l26.2,6.08C314.867,100.339,317.183,103.969,316.372,107.636z"/>
                              </g></svg>  -->
                          
                          <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="-18 -19 581.33331 581" width="20"><path d="m488.21875.0820312h-256.128906c-31.34375.0351568-56.746094 25.4414068-56.78125 56.7851568v7.25l-120.644532 100.59375c-.289062.242187-.5625.496093-.828124.757812-10.457032 10.601562-16.304688 24.902344-16.265626 39.789062v220.5625h-26.320312c-6.210938 0-11.25 5.035157-11.25 11.25v94.484376c0 6.210937 5.039062 11.25 11.25 11.25h244.75c6.210938 0 11.25-5.039063 11.25-11.25v-94.484376c0-6.214843-5.039062-11.25-11.25-11.25h-18.351562v-24.148437c26.46875-5.390625 45.496093-28.652344 45.535156-55.664063v-91.0625h-22.5v91.066407c-.023438 18.925781-15.363282 34.261719-34.285156 34.285156-6.21875 0-11.25 5.035156-11.25 11.25v34.273437h-155.078126v-220.5625c-.027343-8.808593 3.367188-17.285156 9.457032-23.644531l105.777344-88.199219v80.140626l-69.929688 55.367187c-4.871094 3.855469-5.691406 10.933594-1.835938 15.800781 3.859376 4.871094 10.933594 5.691406 15.800782 1.835938l101.503906-80.371094.960938.960938c8.933593 8.949218 8.933593 23.4375 0 32.386718l-48.292969 48.296875c-1.953125 1.949219-3.117188 4.550781-3.277344 7.304688l-.609375 10.53125c-.015625.214843-.019531.429687-.019531.652343.046875 8.363282 1.953125 16.609376 5.574219 24.152344 7.433593 15.949219 6.035156 34.621094-3.6875 49.289063-1.226563 1.84375-1.886719 4.019531-1.886719 6.238281v22.765625c0 6.214844 5.039062 11.25 11.25 11.25 6.214843 0 11.25-5.035156 11.25-11.25v-19.511719c12.371093-20.8125 13.660156-46.390625 3.441406-68.339844-2.164063-4.464843-3.339844-9.335937-3.441406-14.292968l.347656-5.902344 12.710937-12.714844c8.273438 4.453125 17.523438 6.785156 26.914063 6.800782h256.128906c31.347657-.027344 56.757813-25.433594 56.792969-56.78125v-141.15625c-.035156-31.34375-25.4375-56.75-56.78125-56.7851568zm-243.46875 520.2265628h-222.25v-71.988282h222.25zm-12.660156-497.726563h256.121094c18.929687.019531 34.269531 15.359375 34.289062 34.285157v5.828124h-324.695312v-5.824218c.023437-18.925782 15.359374-34.269532 34.285156-34.289063zm-34.285156 62.613281h324.695312v23.03125h-324.695312zm290.414062 147.109376h-256.128906c-3.308594 0-6.605469-.484376-9.785156-1.429688l15.421874-15.429688c17.699219-17.746093 17.699219-46.464843 0-64.203124l-8.054687-8.054688c-4.039063-4.035156-10.457031-4.40625-14.9375-.863281l-16.929687 13.410156v-25.007813h324.695312v67.296876c-.023438 18.925781-15.355469 34.261718-34.28125 34.28125zm0 0"/><path d="m32.441406 485.453125c.3125 15.566406 13.128906 27.96875 28.699219 27.765625 15.574219-.207031 28.058594-12.945312 27.957031-28.515625-.105468-15.570313-12.761718-28.144531-28.332031-28.144531-15.789063.175781-28.460937 13.101562-28.324219 28.894531zm28.324219-6.394531c2.640625-.246094 5.164063 1.15625 6.34375 3.53125 1.1875 2.371094.785156 5.226562-1 7.1875-1.78125 1.960937-4.589844 2.621094-7.066406 1.664062-2.472657-.957031-4.101563-3.335937-4.101563-5.988281-.144531-3.367187 2.457032-6.222656 5.824219-6.394531zm0 0"/><path d="m445.527344 144.652344c-5.910156-.003906-11.742188 1.320312-17.074219 3.875-16.691406-7.976563-36.675781-3.371094-48.195313 11.101562-11.511718 14.472656-11.511718 34.980469 0 49.453125 11.519532 14.472657 31.503907 19.078125 48.195313 11.105469 14.726563 7.015625 32.242187 4.316406 44.167969-6.808594 11.925781-11.128906 15.832031-28.417968 9.855468-43.589844-5.984374-15.175781-20.636718-25.144531-36.949218-25.140624zm-51.355469 39.707031c-.011719-8.105469 5.632813-15.117187 13.546875-16.84375 7.921875-1.722656 15.96875 2.304687 19.332031 9.671875 3.371094 7.375 1.136719 16.09375-5.355469 20.949219-2.96875 2.238281-6.59375 3.445312-10.320312 3.4375-9.496094-.015625-17.195312-7.710938-17.203125-17.214844zm52.996094 17.136719c.128906-.253906.230469-.519532.347656-.773438.144531-.320312.292969-.644531.429687-.964844.15625-.378906.300782-.753906.445313-1.128906.125-.324218.246094-.644531.375-.972656.136719-.378906.261719-.777344.382813-1.160156.109374-.328125.21875-.644532.3125-.972656.128906-.40625.222656-.8125.335937-1.222657.078125-.316406.167969-.632812.246094-.949219.097656-.425781.183593-.855468.265625-1.28125.0625-.3125.136718-.625.191406-.933593.078125-.449219.132812-.90625.199219-1.355469.042969-.296875.089843-.585938.125-.878906.058593-.5.09375-1.007813.136719-1.507813.019531-.25.050781-.503906.0625-.753906.046874-.757813.070312-1.511719.070312-2.273437 0-.769532-.023438-1.523438-.070312-2.28125-.011719-.257813-.046876-.519532-.066407-.773438-.039062-.5-.074219-1-.132812-1.488281-.035157-.3125-.085938-.613281-.125-.925781-.058594-.4375-.121094-.875-.195313-1.308594-.054687-.332032-.132812-.660156-.195312-.988282-.082032-.410156-.160156-.816406-.25-1.21875-.082032-.34375-.175782-.675781-.261719-1.011718-.105469-.390625-.203125-.78125-.3125-1.167969-.105469-.335937-.222656-.671875-.328125-1.011719-.125-.375-.242188-.746094-.371094-1.121094-.128906-.335937-.253906-.667968-.386718-1-.140626-.367187-.28125-.730468-.433594-1.089843-.136719-.332031-.289063-.660157-.441406-.988281-.109376-.246094-.214844-.507813-.335938-.753907 8.824219.847657 15.5625 8.265625 15.5625 17.128907 0 8.867187-6.738281 16.277343-15.5625 17.132812zm0 0"/></svg>
                            <span class="" data-i18n="">Fees</span>
                        </a>
                        <ul class="menu-content">
                            <li class="sub-menu fee-list">
                                <a href="{{ route('fees.index') }}">
                                    Fees List
                                </a>
                            </li>
                            <li class="sub-menu fee-create">
                                <a href="{{ route('fees.create') }}">
                                    Fees Create
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!--end of fees-->

                </ul>
            </li>
            @endcan
            </ul>
        </div>
    </div>

    @show

    <div class="container-fluid p-0">
        @yield('content')
    </div>

    <footer class="footer footer-static footer-light navbar-border">
        <p class="clearfix blue-grey lighten-2 text-sm-center text-center mb-0 px-2">
            <span class=" d-block d-md-inline-block">Copyright &copy; <?php echo date("Y"); ?> <a
                    class="text-bold-800 grey darken-2" href="{{ route('home.dashboard') }}" target="_blank">clearHealth
                </a>, All rights reserved. </span>
        </p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2020.1.219/js/kendo.all.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('theme/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{ asset('theme/app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/vendors/js/extensions/unslider-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/vendors/js/timeline/horizontal-timeline.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('theme/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('theme/app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript">
    </script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN STACK JS-->
    <script src="{{ asset('theme/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/js/core/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
    <!-- END STACK JS-->

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{ asset('theme/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}" type="text/javascript">
    </script>
    <!-- END PAGE LEVEL JS-->
    <script src="{{ asset('theme/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/js/scripts/extensions/sweet-alerts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <!-- <script src="{{ asset('theme/js/main.js') }}"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>

    @toastr_js
    @toastr_render
    @yield('scriptsection')
    <script type="text/javascript">
    $(document).ready(function() {
        /* $('.select2').select2({width:'100%'});*/

        /* For Active Sidebar */
        var url = window.location.href;
        var splitUrl = url.split('/');

        var pagename = splitUrl[splitUrl.length - 1];

        if (pagename == "" || pagename == "create") {
            pagename = splitUrl[splitUrl.length - 2];
        } else if (pagename == "edit") {
            pagename = splitUrl[splitUrl.length - 3];
        }
        console.log(pagename)
        if (pagename == "dashboard") {
            $(".dashboard").addClass('open active');
        } else if (pagename == "users") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".user-sub-menu").addClass('open active');
                $(".user-create").addClass('active');
            } else {

                $(".user-sub-menu").addClass('open active');
                $(".user-list").addClass('active');
            }
        } else if (pagename == "customer") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".customer-sub-menu").addClass('open active');
                $(".customer-create").addClass('active');
            } else {
                $(".customer-menu").addClass('open active');
                $(".customer-list").addClass('active');
            }
        } else if (pagename == "roles") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".role-sub-menu").addClass('open active');
                $(".role-create").addClass('active');
            } else {
                $(".role-sub-menu").addClass('open active');
                $(".role-list").addClass('active');
            }
        } else if (pagename == "categories") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".categori-sub-menu").addClass('open active');
                $(".categori-create").addClass('active');
            } else {
                $(".categori-sub-menu").addClass('open active');
                $(".categori-list").addClass('active');
            }
        } else if (pagename == "products") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".product-sub-menu").addClass('open active');
                $(".product-create").addClass('active');
            } else {
                $(".product-sub-menu").addClass('open active');
                $(".product-list").addClass('active');
            }
        } else if (pagename == "ipledgeimports") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".ipledgeimports-sub-menu").addClass('open active');
                $(".ipledgeimports-create").addClass('active');
            } else {
                $(".ipledgeimports-sub-menu").addClass('open active');
                $(".ipledgeimports-list").addClass('active');
            }
        } else if (pagename == "casemanagement") {
            if (splitUrl[splitUrl.length - 1] == "show") {
                $(".casemanagement-sub-menu").addClass('open active');
                $(".casemanagement-create").addClass('active');
            } else {
                $(".casemanagement-sub-menu").addClass('open active');
                $(".casemanagement-list").addClass('active');
            }
        } else if (pagename == "cms") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".cms-sub-menu").addClass('open active');
                $(".cms-create").addClass('active');
            } else {
                $(".cms-sub-menu").addClass('open active');
                $(".cms-list").addClass('active');
            }
        } else if (pagename == "mdmanagement") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".mdmanagement-sub-menu").addClass('open active');
                $(".mdmanagement-create").addClass('active');
            } else {
                $(".mdmanagement-sub-menu").addClass('open active');
                $(".mdmanagement-list").addClass('active');
            }
        } else if (pagename == "treatmentGuides") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".guides-sub-menu").addClass('open active');
                $(".guides-create").addClass('active');
            } else {
                $(".guides-sub-menu").addClass('open active');
                $(".guides-list").addClass('active');
            }
        } else if (pagename == "ordermanagement") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".ordermanagement-sub-menu").addClass('open active');
                $(".ordermanagement-create").addClass('active');
            } else {
                $(".ordermanagement-sub-menu").addClass('open active');
                $(".ordermanagement-list").addClass('active');
            }
        } else if (pagename == "offers") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".offer-promotion-sub-menu").addClass('open active');
                $(".offer-promotion-create").addClass('active');
            } else {
                $(".offer-promotion-sub-menu").addClass('open active');
                $(".offer-promotion-list").addClass('active');
            }
        } else if (pagename == "blog") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".blog-sub-menu").addClass('open active');
                $(".blog-create").addClass('active');
            } else {
                $(".blog-sub-menu").addClass('open active');
                $(".blog-list").addClass('active');
            }
        } else if (pagename == "faq") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".faq-sub-menu").addClass('open active');
                $(".faq-create").addClass('active');
            } else {
                $(".faq-sub-menu").addClass('open active');
                $(".faq-list").addClass('active');
            }
        } else if (pagename == "tags") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".tag-sub-menu").addClass('open active');
                $(".tag-create").addClass('active');
            } else {
                $(".tag-sub-menu").addClass('open active');
                $(".tag-list").addClass('active');
            }
        } else if (pagename == "testimonials") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".testimonial-sub-menu").addClass('open active');
                $(".testimonial-create").addClass('active');
            } else {
                $(".testimonial-sub-menu").addClass('open active');
                $(".testimonial-list").addClass('active');
            }
        } else if (pagename == "fees") {
            if (splitUrl[splitUrl.length - 1] == "create") {
                $(".fee-sub-menu").addClass('open active');
                $(".fee-create").addClass('active');
            } else {
                $(".fee-sub-menu").addClass('open active');
                $(".fee-list").addClass('active');
            }
        } else {
            $(".dashboard").removeClass('open active');
            $(".user-sub-menu").removeClass('open');
            $(".user-list").removeClass('active');
            $(".user-create").removeClass('active');
            $(".role-sub-menu").removeClass('open');
            $(".role-list").removeClass('active');
            $(".role-create").removeClass('active');
            $(".categori-sub-menu").removeClass('open');
            $(".categori-list").removeClass('active');
            $(".categori-create").removeClass('active');
        }

    });
    </script>

    <style>
    .main-menu.menu-light .navigation>li.active>a {
        color: #43bfc1 !important;
        font-weight: 600;
    }

    .main-menu.menu-light .navigation>li ul .active>a {
        color: #43bfc1 !important;
        font-weight: 600;
    }

    .main-menu.menu-light .navigation>li ul {
        padding: 0;
        margin: 0;
        font-size: 16px;
    }

    .main-menu.menu-light .navigation .sub>li ul.menu-content li:hover>a.menu-item,
    .main-menu.menu-light .navigation>li:hover>a {
        color: #43bfc1;
    }
    </style>
</body>
<!--   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

</html>