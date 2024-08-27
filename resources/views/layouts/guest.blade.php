<!DOCTYPE html>
<!--
  HOW TO USE: 
  data-layout: fluid (default), boxed
  data-sidebar-theme: dark (default), colored, light
  data-sidebar-position: left (default), right
  data-sidebar-behavior: sticky (default), fixed, compact
-->
<html
    lang="en"
    data-bs-theme="light"
    data-layout="fluid"
    data-sidebar-theme="dark"
    data-sidebar-position="left"
    data-sidebar-behavior="sticky"
>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta
            name="description"
            content="Responsive Bootstrap 5 Admin &amp; Dashboard Template"
        />
        <meta name="author" content="Bootlab" />
        <title>@yield('title', '') - {{ config("app.name") }}</title>
        <link rel="stylesheet" href="{{ mix('css/layout.css') }}" />

        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css"
        />

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

        <link
            rel="canonical"
            href="https://appstack.bootlab.io/dashboard-default.html"
        />

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap"
            rel="stylesheet"
        />

        <link
            href="{{ URL::asset('build/assets/layout.css'); }}"
            rel="stylesheet"
        />

        <script
            async
            src="https://www.googletagmanager.com/gtag/js?id=G-Q3ZYEKLQ68"
        ></script>
    </head>

    <body>
        @yield('content')
        <script src="{{ URL::asset('build/assets/layout.js'); }}"></script>
    </body>
</html>
