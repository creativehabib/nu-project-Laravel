<!DOCTYPE html>
<html @yield('html-attribute')>

<head>
    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')
</head>

<body @yield('body-attribute')>

    @yield('content')

    @include('layouts.partials/vendor-scripts')

</body>

</html>
