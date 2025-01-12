<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }} | @yield('title')</title>
    <meta name="title" content="{{ $website->name }}">
    <meta name="description" content="{{ $website->deskrpsi }}">
    <meta name="keywords" content="RZW Panel, RZW Smm Panel, SMM Panel, SMM, SMM Murah">
    <meta name="author" content="Rozir Wobari">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ $website->name }}">
    <meta property="og:description" content="{{ $website->deskripsi }}">
    <meta property="og:image" content="{{ $website->logo }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="{{ $website->name }}">
    <meta property="twitter:description" content="{{ $website->deskripsi }}">
    <meta property="twitter:image" content="{{ $website->logo }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ $website->favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $website->favicon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $website->favicon }}">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "{{ $website->name }}",
            "description": "{{ $website->name }}",
            "publisher": {
                "@type": "{{ $website->name }}",
                "name": "{{ $website->name }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ $website->favicon }}"
                }
            }
        }
    </script>   
    
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('panels/css/adminlte.css') }}">
</head>

@yield('css')

<body class="login-page bg-body-secondary">
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <script src="{{ asset('panels/js/adminlte.js') }}"></script>
    @yield('js')

    @if (session('alert'))
        <script>
            Swal.fire({
                title: '{{ session('alert')['title'] }}',
                text: '{{ session('alert')['description'] }}',
                icon: '{{ session('alert')['type'] }}',
            });
        </script>
    @endif
</body

</html>