@extends('layouts.vertical', ['subtitle' => 'Settings'])

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Nu Module', 'subtitle' => 'Settings'])

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Settings</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" name="key" class="form-control" placeholder="Key" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="value" class="form-control" placeholder="Value">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-centered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $setting->key }}</td>
                                <td>{{ $setting->value }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No settings found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
