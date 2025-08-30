<!DOCTYPE html>
<html @yield('html-attribute')>

<head>
    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')
    <style>
        #light-dark-mode .dark-mode {display: none;}
        [data-bs-theme="dark"] #light-dark-mode .light-mode {display: none;}
        [data-bs-theme="dark"] #light-dark-mode .dark-mode {display: inline;}
    </style>
</head>

<body @yield('body-attribute')>
    <button id="light-dark-mode" class="btn btn-sm btn-outline-secondary position-fixed top-0 end-0 m-3">
        <iconify-icon icon="solar:moon-outline" class="fs-22 align-middle light-mode"></iconify-icon>
        <iconify-icon icon="solar:sun-2-outline" class="fs-22 align-middle dark-mode"></iconify-icon>
    </button>

    @yield('content')

    @include('layouts.partials/vendor-scripts')

</body>

</html>
