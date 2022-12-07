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
<html lang="en" class="dark">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="dist/images/logo.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Enigma admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Enigma Admin Template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard - M3-CRM</title>
        <!-- BEGIN: CSS Assets-->

        <link rel="stylesheet" href="{{ asset('theme/dist/css/app.css')}}" />
        {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet"> --}}
        
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="py-5 md:py-0">
        <div class="container">
            <!-- BEGIN: Error Page -->
            <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
                <div class="-intro-x lg:mr-20">
                    <img alt="Midone - HTML Admin Template" class="h-48 lg:h-auto" src="{{ asset('theme/dist/images/error-illustration.svg')}}">
                </div>
                <div class="text-white mt-10 lg:mt-0">
                    <div class="intro-x text-8xl font-medium">400</div>
                    <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. You do not have permission.</div>
                    {{-- <div class="intro-x text-lg mt-3">Asked admin for.</div> --}}
                    <a href="{{route('dashboard')}}" class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Back to Dashboard</a>
                </div>
            </div>
            <!-- END: Error Page -->
        </div>
        
        <!-- BEGIN: JS Assets-->
      
        <script src="{{ asset('theme/dist/js/app.js')}}"></script>
        <!-- END: JS Assets-->
    </body>
</html>