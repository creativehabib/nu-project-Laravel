<!DOCTYPE html>
<html @yield('html-attribute')>

<head>
    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')
</head>

<body @yield('body-attribute')>
    <button id="light-dark-mode" class="btn btn-sm btn-outline-secondary position-fixed top-0 end-0 m-3">
        Toggle Theme
    </button>

    @yield('content')

    @include('layouts.partials/vendor-scripts')

</body>

</html>
