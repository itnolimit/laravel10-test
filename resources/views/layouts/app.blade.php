<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ $pageTitle ?? 'DOTDriverFiles' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">

    @livewireStyles
    @production
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5CJGT9M');</script>
    <!-- End Google Tag Manager -->


        <!-- Hotjar Tracking Code for https://app.dotdriverfiles.com -->
            <script>
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:3090854,hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
            </script>
    @endproduction
</head>

<body>
@production
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5CJGT9M"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endproduction
<!-- Begin page -->
<div class="wrapper" id="app" v-cloak>


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <div class="slimscroll-menu" id="left-side-menu-container">

            <!-- LOGO -->
            <a href="/" class="logo text-center tw-mt-3">
                <span class="logo-lg">
                    <img src="{{ url('images/dto-logo.svg') }}" alt="DOTDriverFiles" class="img-fluid" >
                </span>
                <span class="logo-sm">
                    <img src="{{ url('images/dto-logo.svg') }}" alt="DOTDriverFiles" height="16">
                </span>
            </a>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav -mx-2 space-y-1">

                <li class="side-nav-item">
                    <a href="{{ route('dashboard') }}" class="side-nav-link" >
                        <svg class="h-6 w-6 shrink-0 align-middle" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(config('menu.drivers') && auth()->user()->canany(['create driver','view driver']))
                    <li class="side-nav-item {{ request()->segment(1) == 'drivers' ? 'active' : ' ' }}">
                        <a href="javascript: void(0);" class="side-nav-link">
                            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                            </svg>
                            <span>Drivers</span>
                            <svg class="icon-arrow h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            @can('create driver')
                                <li>
                                    <a href="{{ route('drivers.create') }}">Add New Driver</a>
                                </li>
                                <li>
                                    <a href="{{ route('driver.import') }}" >
                                        Bulk Import
                                    </a>
                                </li>
                            @endcan
                            @can('view driver')
                                <li>
                                    <a href="{{ route('drivers.index', [ 'status' => 'ACTIVE' ]) }}">Active Drivers</a>
                                </li>
                                <li>
                                    <a href="{{ route('drivers.index', [ 'status' => 'NEW' ]) }}">New Applicants</a>
                                </li>
                                <li>
                                    <a href="{{ route('drivers.index', [ 'status' => 'PENDING' ]) }}">Pending Drivers</a>
                                </li>
                                <li>
                                    <a href="{{ route('drivers.index', [ 'status' => 'INACTIVE' ]) }}">Inactive Drivers</a>
                                </li>
                                <li>
                                    <a href="{{ route('drivers.index', [ 'status' => 'REJECT' ]) }}">Rejected Applicants</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if((auth()->user()->company->features()->active(\Prime\Features\FleetMaintenanceFeature::class) || auth()->user()->company->features()->active(\Prime\Features\InsuranceManagementFeature::class)) && auth()->user()->can('view vehicle'))
                    <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"></path>
                        </svg>
                        <span> Assets </span>
                        <svg class="icon-arrow h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        @can('view vehicle')
                            <li>
                                <a href="{{ route('vehicle.index', ['table-filters' => ['status' => 'ACTIVE'], 'type' =>'TRUCK']) }}">Vehicles</a>
                            </li>
                            <li>
                                <a href="{{ route('vehicle.index', ['table-filters' => ['status' => 'ACTIVE'], 'type' =>'TRAILER']) }}">Trailers</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (auth()->user()->company->features()->active(\Prime\Features\FleetMaintenanceFeature::class) && auth()->user()->canany(['view service logs','view schedules','view upcoming']))
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            <span> Maintenance </span>
                            <svg class="icon-arrow h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            @can('view service logs')
                                <li>
                                    <a href="{{ route('maintenance.index') }}">Service Logs</a>
                                </li>
                            @endcan
                            @can('view schedules')
                                <li>
                                    <a href="{{ route('maintenance.schedule') }}">Schedule</a>
                                </li>
                            @endcan
                            @can('view upcoming')
                                <li>
                                    <a href="{{ route('maintenance.upcoming') }}">Upcoming</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->company->features()->active(\Prime\Features\InsuranceManagementFeature::class))
                    <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                        </svg>
                        <span> Insurance </span>
                        <svg class="icon-arrow h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        @can('view insurance dashboard')
                            <li>
                                <a href="{{ route('insurance.companies.index') }}">Dashboard Insurance</a>
                            </li>
                        @endcan
                        @can('view insurance company')
                            <li>
                                <a href="{{ route('insurance.companies.index') }}">Insurance Companies</a>
                            </li>
                        @endcan
                        @can('view insurance policy')
                            <li>
                                <a href="{{ route('insurance.policies.index') }}">Policies</a>
                            </li>
                        @endcan
                        @can('view insurance claim')
                            <li>
                                <a href="{{ route('insurance.claims.index') }}">Claims</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endif


                @if(config('menu.users') && auth()->user()->canany(['invite user','edit user','delete user']))
                    <li class="side-nav-item {{ request()->segment(1) == 'users' ? 'in' : '' }}">
                        <a href="{{ route('users.index') }}" class="side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                            </svg>
                            <span>Users</span>
                        </a>
                    </li>
                @endif

                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span> Settings </span>
                        <svg class="icon-arrow h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('account.user.edit') }}">My Account</a>
                        </li>

                        @can('view company documents')
                            <li>
                                <a href="{{ route('account.company.documents') }}">Company Documents</a>
                            </li>
                        @endcan

                        @can('manage company profile')
                            <li>
                                <a href="{{ route('account.company.edit') }}">Organization Profile</a>
                            </li>
                        @endcan
                        @can('manage billing')
                            <li>
                                <a href="{{ route('account.billing.index') }}">Billing</a>
                            </li>
                        @endcan
                </ul>
            </li>

                <li>
                    <div class="relative tw-py-2">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full hr-1 bg-gray-300"></div>
                        </div>
                    </div>
                    <a href="{{ url('/apps') }}" class="side-nav-link apps" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-50 text-indigo-600&quot;, Default: &quot;text-gray-700 hover:text-indigo-600 hover:bg-gray-50&quot;">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Marketplace Apps</span>
                    </a>
                </li>

        </ul>
            <!--
        <div class="clearfix"></div>
        <div class="text-center mt-5">
            <img src="//cdn.livechatinc.com/cloud/?uri=https://livechat.s3.amazonaws.com/default/buttons/button_online003.png" id="chat-btn" class="cursor-pointer" height="45">
        </div>
        -->

    </div>
    </div>


<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
<div class="content">

<!-- Topbar Start -->
<div class="navbar-custom">
    <button class="button-menu-mobile open-left disable-btn">
        <i class="mdi mdi-menu"></i>
    </button>
    <ul class="list-unstyled topbar-right-menu float-right mb-0">
        <li class="dropdown notification-list">
    <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <span class="account-user-avatar">
            <img src="/images/users/avatar.png" alt="user-image" class="rounded-circle">
        </span>
        <span class="nav-user-name" >
            <span class="account-user-name text-yankees">{{ auth()->user()->name }}</span>
            <span class="account-position text-yankees" >{{ auth()->user()->roles()->first()->name ?? '' }}</span>
        </span>
        <span class="nav-user-arrow text-yankees">
            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
        <!-- item-->
        <div class=" dropdown-header noti-title">
         <h6 class="text-overflow m-0">Welcome!</h6>
        </div>

                <!-- item-->
                <a href="{{ route('account.user.edit') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle mr-1"></i>
                    <span>My Account</span>
                </a>
                <a href="{{ route('account.user.password') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-lock mr-1"></i>
                    <span>Change Password</span>
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"
                >
                 <i class="mdi mdi-logout mr-1"></i>
                 <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
                </form>
            </div>
        </li>
    </ul>



    <Notifications></Notifications>

    <ul class="list-unstyled topbar-right-menu whats-news-ul float-right mb-0">
        <li>
            <a class="nav-link" href="{{ route('news') }}" >
                <i class="dripicons-star"></i>
                What's New
                @if(auth()->user()->flagsUnReadedNews()->count() > 0)
                    <span class="text-white badge rounded-pill bg-danger">
                        {{ auth()->user()->flagsUnReadedNews()->count() }}
                    </span>
                @endif
            </a>
        </li>

    </ul>

{{--    <div class="dropdown btn-group">--}}
{{--        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--            Animated Dropdown--}}
{{--        </button>--}}
{{--        <div class="dropdown-menu dropdown-menu-animated">--}}
{{--            <a class="dropdown-item" href="#">Action</a>--}}
{{--            <a class="dropdown-item" href="#">Another action</a>--}}
{{--            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="d-flex align-items-center text-yankees " role="button" aria-haspopup="false" aria-expanded="false">

        <div class="tw-shadow-lg p-1 bg-white tw-rounded">
            <svg aria-hidden="true" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--business-svg Icon-color-svg Icon-color--gray300-svg" height="16" width="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M3 7.5V12h10V7.5c.718 0 1.398-.168 2-.468V15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7.032c.602.3 1.282.468 2 .468zM0 3 1.703.445A1 1 0 0 1 2.535 0h10.93a1 1 0 0 1 .832.445L16 3a3 3 0 0 1-5.5 1.659C9.963 5.467 9.043 6 8 6s-1.963-.533-2.5-1.341A3 3 0 0 1 0 3z" fill-rule="evenodd"></path></svg>
        </div>

        <ul class="list-unstyled float-right mb-0">
            <li class="dropdown notification-list nav-company-list">
                <a class="nav-link dropdown-toggle text-yankees font-weight-bold arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                   <span class="active" >
                        {{ auth()->user()->company->name }}
                   </span>
                    <span>
                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="ml-2 h-5 w-5 text-gray-400"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path></svg>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-animated topbar-dropdown-menu">

                    <modal-switch-company :companies="{{auth()->user()->companies()->get()}}"  :company="{{ auth()->user()->company }}" ></modal-switch-company>

                    <a href="{{ route('account.company.create') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-plus"></i>
                        <span>Create New Organization</span>
                    </a>

                </div>

            </li>
        </ul>

    </div>

</div>
<!-- end Topbar -->

    <!-- Start Content-->
    <div>

        <x-subscription-payment-alert></x-subscription-payment-alert>

        @yield('content')
    </div> <!-- container -->

</div> <!-- content -->

<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
            {{ date('Y') }} © DOTDriverFiles
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    Version {{ env('APP_VERSION') }}
            {{--        <a href="javascript: void(0);">About</a>--}}
            {{--        <a href="javascript: void(0);">Support</a>--}}
            {{--        <a href="javascript: void(0);">Contact Us</a>--}}
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

<modal-delete :url="destroyUrl"></modal-delete>

</div>
<!-- END wrapper -->


<!-- Right Sidebar -->
<div class="right-bar">

<div class="rightbar-title">
<a href="javascript:void(0);" class="right-bar-toggle float-right">
<i class="dripicons-cross noti-icon"></i>
</a>
<h5 class="m-0">Settings</h5>
</div>

<div class="slimscroll-menu rightbar-content">

<!-- Settings -->
<hr class="mt-0" />
<h5 class="pl-3">Basic Settings</h5>
<hr class="mb-0" />

<div class="p-3">
<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="notifications-check" checked>
<label class="custom-control-label" for="notifications-check">Notifications</label>
</div>

<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="api-access-check">
<label class="custom-control-label" for="api-access-check">API Access</label>
</div>

<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="auto-updates-check" checked>
<label class="custom-control-label" for="auto-updates-check">Auto Updates</label>
</div>

<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="online-status-check" checked>
<label class="custom-control-label" for="online-status-check">Online Status</label>
</div>

<div class="custom-control custom-checkbox mb-2">
<input type="checkbox" class="custom-control-input" id="auto-payout-check">
<label class="custom-control-label" for="auto-payout-check">Auto Payout</label>
</div>

</div>


<!-- Timeline -->
<hr class="mt-0" />
<h5 class="pl-3">Recent Activity</h5>
<hr class="mb-0" />
<div class="pl-2 pr-2">
<div class="timeline-alt">
<div class="timeline-item">
<i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
<div class="timeline-item-info">
<a href="javascript:void(0)" class="text-info font-weight-bold mb-1 d-block">You sold an item</a>
<small>Paul Burgess just purchased “Hyper - Admin Dashboard”!</small>
<p class="mb-0 pb-2">
<small class="text-muted">5 minutes ago</small>
</p>
</div>
</div>

<div class="timeline-item">
<i class="mdi mdi-airplane bg-primary-lighten text-primary timeline-icon"></i>
<div class="timeline-item-info">
<a href="javascript:void(0)" class="text-primary font-weight-bold mb-1 d-block">Product on the Bootstrap Market</a>
<small>Dave Gamache added
<span class="font-weight-bold">Admin Dashboard</span>
</small>
<p class="mb-0 pb-2">
<small class="text-muted">30 minutes ago</small>
</p>
</div>
</div>

<div class="timeline-item">
<i class="mdi mdi-microphone bg-info-lighten text-info timeline-icon"></i>
<div class="timeline-item-info">
<a href="javascript:void(0)" class="text-info font-weight-bold mb-1 d-block">Robert Delaney</a>
<small>Send you message
<span class="font-weight-bold">"Are you there?"</span>
</small>
<p class="mb-0 pb-2">
<small class="text-muted">2 hours ago</small>
</p>
</div>
</div>

<div class="timeline-item">
<i class="mdi mdi-upload bg-primary-lighten text-primary timeline-icon"></i>
<div class="timeline-item-info">
<a href="javascript:void(0)" class="text-primary font-weight-bold mb-1 d-block">Audrey Tobey</a>
<small>Uploaded a photo
<span class="font-weight-bold">"Error.jpg"</span>
</small>
<p class="mb-0 pb-2">
<small class="text-muted">14 hours ago</small>
</p>
</div>
</div>

<div class="timeline-item">
<i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
<div class="timeline-item-info">
<a href="javascript:void(0)" class="text-info font-weight-bold mb-1 d-block">You sold an item</a>
<small>Paul Burgess just purchased “Hyper - Admin Dashboard”!</small>
<p class="mb-0 pb-2">
<small class="text-muted">1 day ago</small>
</p>
</div>
</div>

</div>
</div>
</div>
</div>


    <div class="rightbar-overlay"></div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Be Careful, This Is Permanent!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="dripicons-warning text-danger font-30"></i>
                        <h4>Are you sure you want to delete?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-confirm-delete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

<!-- /Right-bar -->
@include ('footer')
@livewireScripts

<script src="//maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GOOGLE_KEY') }}&language=en"></script>

<script src="/js/manifest.js"></script>
<script src="{{ mix('js/vendor.js') }}" ></script>
<script src="{{ mix('js/app.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>



@stack('scripts')

@yield('js')

    <script type="text/javascript">



        @foreach (session('flash_notification', collect())->toArray() as $message)
        $.NotificationApp.send("",
        " {!! $message['message'] !!}",
        'top-right',
        'rgba(0,0,0,0.2)', '{{ $message['level'] == 'danger' ? 'error' : $message['level'] }}');
        @endforeach
    </script>

    {{ session()->forget('flash_notification') }}

@production
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = 14393946;
        ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
        LiveChatWidget.call("set_customer_name", '{{ auth()->user()->name }}');
        LiveChatWidget.call("set_customer_email", '{{ auth()->user()->email }}');
    </script>
@endproduction


<script>
    var chatButton = document.getElementById('chat-btn');

    if (chatButton != null) {
        chatButton.addEventListener('click', function() {
            // Initialize Chat Widget

            LiveChatWidget.init();
            LiveChatWidget.call("maximize");

        })
    }
</script>
</body>
</html>
