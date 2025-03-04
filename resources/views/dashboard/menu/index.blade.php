@extends('layouts.vertical', ['subtitle' => 'Manage Menus'])
@section('css')
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Manage Menu', 'subtitle' => 'Manage Menu'])

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Add Menu Items </h5>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                    Categories
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                 aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">Category</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                    Posts
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                 aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is
                                    intended to demonstrate the
                                    <code>.accordion-flush</code> class. This is the second item's accordion
                                    body. Let's imagine this
                                    being
                                    filled with some actual content.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">
                                    Custom Links
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                 aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is
                                    intended to demonstrate the
                                    <code>.accordion-flush</code> class. This is the third item's accordion
                                    body. Nothing more exciting
                                    happening here in terms of content, but just filling up the space to
                                    make it look, at least at first
                                    glance, a bit more representative of how this would look in a real-world
                                    application.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Menu Structure</h5>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>

    </div>

@endsection
