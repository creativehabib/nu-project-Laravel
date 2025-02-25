@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])
@section('css')
@endsection
@section('content')

    @include('layouts.partials/page-title', ['title' => 'Users', 'subtitle' => 'User List'])

    <div class="row row-cols-lg-1 gx-3">
        <div class="">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Users</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td scope="row">{{ ++$loop->index }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>Cell</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

@endsection
