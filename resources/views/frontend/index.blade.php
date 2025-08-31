@extends('layouts.base', ['subtitle' => 'Home'])

@section('content')
    @include('frontend.layouts.top-nav')

    <section class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-4">Welcome to National University</h1>
            <p class="lead">Discover our services and recent work.</p>
        </div>
    </section>

    <section id="services" class="py-5">
        <div class="container">
            <h2 class="mb-4 text-center">Our Services</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service One</h5>
                            <p class="card-text">Brief description of service one.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service Two</h5>
                            <p class="card-text">Brief description of service two.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service Three</h5>
                            <p class="card-text">Brief description of service three.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service Four</h5>
                            <p class="card-text">Brief description of service four.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="works" class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4 text-center">Our Work</h2>
            <p class="text-center">Showcase of our recent projects and achievements.</p>
        </div>
    </section>
@endsection
