<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <title inertia>{{ config('app.name', 'RS') }}</title> --}}

    {{-- set favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
  </head>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.google.analytics_id')}}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', {{config('app.google.analytics_id')}});
  </script>

  <body class="font-sans antialiased">
    @inertia
  </body>
</html>
