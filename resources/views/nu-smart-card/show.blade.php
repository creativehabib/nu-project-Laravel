@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])

@section('content')
    <div class="row row-cols-lg-1 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nu Smart Data Edit</h5>
                </div>

                <div class="card-body">
                    <div>
                        <table class="table table-centered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $nuSmartCard->name }}</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ $nuSmartCard->department }}</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{ $nuSmartCard->designation }}</td>
                            </tr>
                            <tr>
                                <th>PF No</th>
                                <td>{{ $nuSmartCard->pf_number }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $nuSmartCard->birth_date }}</td>
                            </tr>
                            <tr>
                                <th>PRL Date</th>
                                <td>{{ $nuSmartCard->prl_date }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td>{{ $nuSmartCard->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $nuSmartCard->blood->name }}</td>
                            </tr>
                            <tr>
                                <th>Present Address</th>
                                <td>{{ $nuSmartCard->present_address }}</td>
                            </tr>
                            <tr>
                                <th>Emergency Contact</th>
                                <td>{{ $nuSmartCard->emergency_contact }}</td>
                            </tr>
                            <tr>
                                <th>Signature</th>
                                <td><img src="{{ asset('uploads/signature/' .$nuSmartCard->signature) }}"></td>
                            </tr>
                            <tr>
                                <th>Signature</th>
                                <td><img src="{{ asset('uploads/images/' .$nuSmartCard->image) }}"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
