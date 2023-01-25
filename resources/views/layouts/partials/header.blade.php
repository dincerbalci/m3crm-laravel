<!DOCTYPE html>
<!--
Template Name: Enigma - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="{{ Session::get('dark_mode') }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Enigma admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Enigma Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    {{-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - M3-CRM</title>
    <!-- BEGIN: CSS Assets-->

    <link rel="stylesheet" href="{{ asset('theme/dist/css/app.css') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet"> --}}

    <!-- END: CSS Assets-->
</head>
@if (Session::get('dark_mode') == 'light')
    <style>
        .colorchange {
            color: #1517a7;
            font: bold;
        }

        .colorchange:hover {
            text-decoration: underline;
            -webkit-text-decoration-color: #1517a7;
            /* Safari */
            text-decoration-color: #1517a7;
        }
    </style>
@endif
@if (Session::get('dark_mode') == 'dark')
    <style>
        .colorchange {
            color: #8ea8ff;
            font: bold;
        }

        .colorchange:hover {
            text-decoration: underline;
            -webkit-text-decoration-color: #8ea8ff;
            /* Safari */
            text-decoration-color: #8ea8ff;
        }
    </style>
@endif
<!-- END: Head -->

<body class="py-5 md:py-0">
    <!-- BEGIN: Mobile Menu -->


    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('theme/dist/images/logo.svg') }}">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>

    </div>
    <!-- END: Mobile Menu -->
    <!-- BEGIN: Top Bar -->
    <div
        class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] -mt-7 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
        <div class="h-full flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="logo -intro-x hidden md:flex xl:w-[180px] block">
                <img alt="Midone - HTML Admin Template" class="logo__image w-6"
                    src="{{ asset('theme/dist/images/logo.svg') }}">
                <span class="logo__text text-white text-lg ml-3">M3-CRM</span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
                <ol class="breadcrumb breadcrumb-light">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Application</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Route::currentRouteName() == 'dashboard' ? 'Dashboard' : '' }}
                        @php
                            $newLi = '';
                            $newLiText = '';
                            if (Route::currentRouteName() == 'e_form_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'E-Form Management';
                                $newLiText = 'Add E-Form';
                            }
                            if (Route::currentRouteName() == 'e_form_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'E-Form Management';
                                $newLiText = 'View E-Form';
                            }
                            if (Route::currentRouteName() == 'e_form_type.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'E-Form Management';
                                $newLiText = 'Add E-Form Type';
                            }
                            if (Route::currentRouteName() == 'e_form_type.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'E-Form Management';
                                $newLiText = 'Edit E-Form Type';
                            }
                            if (Route::currentRouteName() == 'e_form_type.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'E-Form Management';
                                $newLiText = 'View E-Form Type';
                            }
                            if (Route::currentRouteName() == 'complaint_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'Add Complaint';
                            }
                            if (Route::currentRouteName() == 'complaint_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'View Complaint';
                            }
                            if (Route::currentRouteName() == 'complaint_show') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'Complaint Details';
                            }
                            if (Route::currentRouteName() == 'complaint_type_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'Add Complaint Type';
                            }
                            if (Route::currentRouteName() == 'complaint_type_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'Edit Complaint Type';
                            }
                            if (Route::currentRouteName() == 'complaint_type_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Complaint Management';
                                $newLiText = 'View Complaint Type';
                            }
                            if (Route::currentRouteName() == 'lead_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Leads Management';
                                $newLiText = 'Add Leads';
                            }
                            if (Route::currentRouteName() == 'lead_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Leads Management';
                                $newLiText = 'View Leads';
                            }
                            if (Route::currentRouteName() == 'user.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Add User';
                            }
                            if (Route::currentRouteName() == 'user.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit User';
                            }
                            if (Route::currentRouteName() == 'user.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View User';
                            }
                            if (Route::currentRouteName() == 'group.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Group';
                            }
                            if (Route::currentRouteName() == 'group.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Group';
                            }
                            if (Route::currentRouteName() == 'group.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Group';
                            }
                            if (Route::currentRouteName() == 'role.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Role';
                            }
                            if (Route::currentRouteName() == 'role.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Role';
                            }
                            if (Route::currentRouteName() == 'role.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Role';
                            }
                            if (Route::currentRouteName() == 'unit.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Unit';
                            }
                            if (Route::currentRouteName() == 'unit.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Unit';
                            }
                            if (Route::currentRouteName() == 'unit.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Unit';
                            }
                            if (Route::currentRouteName() == 'template.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Template';
                            }
                            if (Route::currentRouteName() == 'template.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Template';
                            }
                            if (Route::currentRouteName() == 'template.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Template';
                            }
                            if (Route::currentRouteName() == 'daily_calendar') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Calendar Management';
                            }
                            if (Route::currentRouteName() == 'escalation_group.create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Escalation';
                            }
                            if (Route::currentRouteName() == 'escalation_group.edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Escalation';
                            }
                            if (Route::currentRouteName() == 'escalation_group.index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Escalation';
                            }
                            if (Route::currentRouteName() == 'announcement_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Add Message & Announcement';
                            }
                            if (Route::currentRouteName() == 'announcement_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'View Message & Announcement';
                            }
                            if (Route::currentRouteName() == 'announcement_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Administration';
                                $newLiText = 'Edit Message & Announcement';
                            }
                            if (Route::currentRouteName() == 'complaint_category_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Add Complaint Category';
                            }
                            if (Route::currentRouteName() == 'complaint_category_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Edit Complaint Category';
                            }
                            if (Route::currentRouteName() == 'complaint_category_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'View Complaint Category';
                            }
                            if (Route::currentRouteName() == 'e_form_category_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Add E-Form Category';
                            }
                            if (Route::currentRouteName() == 'e_form_category_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Edit E-Form Category';
                            }
                            if (Route::currentRouteName() == 'e_form_category_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'View E-Form Category';
                            }
                            if (Route::currentRouteName() == 'complaint_product_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Add Product Complaint';
                            }
                            if (Route::currentRouteName() == 'complaint_product_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Edit Product Complaint';
                            }
                            if (Route::currentRouteName() == 'complaint_product_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'View Product Complaint';
                            }
                            if (Route::currentRouteName() == 'e_form_product_create') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Add E-Form Product';
                            }
                            if (Route::currentRouteName() == 'e_form_product_edit') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'Edit E-Form Product';
                            }
                            if (Route::currentRouteName() == 'e_form_product_index') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Product Management';
                                $newLiText = 'View E-Form Product';
                            }
                            if (Route::currentRouteName() == 'customer_search') {
                                echo 'Customer Search';
                            }
                            if (Route::currentRouteName() == 'customer_info') {
                                $newLi = 'breadcrumb-item active';
                                echo 'Customer Search';
                                $newLiText = 'Customer Infomation';
                            }
                            if (Route::currentRouteName() == 'chat') {
                                // $newLi = 'breadcrumb-item active';
                                echo 'Chat';
                                // $newLiText = 'Customer Infomation';
                            }
                        @endphp
                    </li>
                    <li class="{{ $newLi }}" aria-current="page">
                        {{ $newLiText }}
                    </li>
                </ol>
            </nav>
            <div id="success-notification" class="p-5">
                <div class="preview">
                    <div class="text-center">
                        <!-- BEGIN: Notification Content -->
                        <div id="success-notification-content" class="toastify-content hidden flex">
                            <i class="text-success" data-lucide="check-circle"></i>
                            <div class="ml-4 mr-4">
                                <div class="font-medium" id="success-notification-text">Successfully Saved!</div>
                            </div>
                        </div>
                        <button id="success-notification-toggle" hidden class="btn btn-primary">Show
                            Notification</button>
                    </div>
                </div>
            </div>
            <div class="intro-x dropdown mr-4 sm:mr-6">
                <div class="dropdown-toggle notification " role="button">{{ Session::get('user_name') }} </div>
                <div class="dropdown-toggle notification " role="button"> {{ Session::get('unit_name') }}</div>

            </div>
            <div class="intro-x dropdown mr-4 sm:mr-6">
                <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
                    aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell"
                        class="notification__icon dark:text-slate-500"></i> </div>
                <div class="notification-content pt-2 dropdown-menu">
                    <div class="notification-content__box dropdown-content">
                        <div class="notification-content__title">Notifications</div>
                        <div class="cursor-pointer relative flex items-center ">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ asset('theme/dist/images/profile-10.jpg') }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Al Pacino</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">01:10 PM</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">It is a long established fact that a
                                    reader will be distracted by the readable content of a page when looking at its
                                    layout. The point of using Lorem </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ asset('theme/dist/images/profile-7.jpg') }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Robert De Niro</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">06:05 AM</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">It is a long established fact that a
                                    reader will be distracted by the readable content of a page when looking at its
                                    layout. The point of using Lorem </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ asset('theme/dist/images/profile-3.jpg') }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Keanu Reeves</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">Contrary to popular belief, Lorem
                                    Ipsum is not simply random text. It has roots in a piece of classical Latin
                                    literature from 45 BC, making it over 20</div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ asset('theme/dist/images/profile-10.jpg') }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Denzel Washington</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">01:10 PM</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">Lorem Ipsum is simply dummy text of
                                    the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s
                                    standard dummy text ever since the 1500</div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ asset('theme/dist/images/profile-14.jpg') }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Christian Bale</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">It is a long established fact that a
                                    reader will be distracted by the readable content of a page when looking at its
                                    layout. The point of using Lorem </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Notifications -->
            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                    role="button" aria-expanded="false" data-tw-toggle="dropdown">
                    <img alt="Midone - HTML Admin Template" src="{{ asset('theme/dist/images/profile-14.jpg') }}">
                </div>
                <div class="dropdown-menu w-56">
                    <ul
                        class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                        <li class="p-2">
                            <div class="font-medium">{{ Session::get('user_name') }}</div>
                            <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">
                                {{ Session::get('unit_name') }}</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li>
                        {{-- <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user"
                                    class="w-4 h-4 mr-2"></i> Profile </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="edit"
                                    class="w-4 h-4 mr-2"></i> Add Account </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock"
                                    class="w-4 h-4 mr-2"></i> Reset Password </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="help-circle"
                                    class="w-4 h-4 mr-2"></i> Help </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li> --}}
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5"> <i
                                    data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>

    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id='myModalLgHeading'>
                    </h2>
                    {{-- <button class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </button> --}}
                    {{-- <div class="dropdown sm:hidden">
                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-body" id='modalBodyLarge'>

                </div>
            </div>
        </div>
    </div>
    <!-- END: Top Bar -->
    <!--begin::Aside-->
    @include('layouts.partials.sidebar')
