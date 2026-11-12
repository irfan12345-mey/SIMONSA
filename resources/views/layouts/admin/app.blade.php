<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'SIMONSA')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    {{-- Start CSS --}}
    @include('layouts.admin.css')
    {{-- End CSS --}}
</head>

<body class="index-page">

    {{-- Start Header --}}
    @include('layouts.admin.header')
    {{-- End Header --}}

    <main class="main">
        {{-- Start Main Content --}}
        @yield('content')
        {{-- End Main Content --}}
    </main>

    {{-- Start Footer --}}
    @include('layouts.admin.footer')
    {{-- End Footer --}}

    {{-- Start JS --}}
    @include('layouts.admin.js')
    {{-- End JS --}}

</body>

</html>
