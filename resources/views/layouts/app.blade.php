<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $title = 'Dashboard'; // Set default title

        if (Request::is('user*')) {
            $title = 'User';
        } elseif (Request::is('monitoring*')) {
            $title = 'Monitoring';
        } elseif (Request::is('sumur*')) {
            $title = 'Sumur Pantau';
        } elseif (Request::is('laporan*')) {
            $title = 'Laporan';
        }
    @endphp
    <title>{{ $title . ' | SIPKAT'  }}</title>

    <meta name="description" content="" />
  
    @stack('style')
    @include('layouts.partials.css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        <!-- / Sidebar -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Navbar -->
          @if (!Request::is('setting'))
            @include('layouts.partials.navbar')
          @endif
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                @include('layouts.partials.header')
                @yield('content')
            </div>
            <!-- / Content -->

            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @stack('script')
    @include('layouts.partials.js')
  </body>
</html>
