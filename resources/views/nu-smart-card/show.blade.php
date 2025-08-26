@extends('layouts.vertical', ['subtitle' => 'Nu Smart Card'])

@section('content')
    <div class="row row-cols-lg-1 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="flex-box justify-content-between">
                        <h5 class="card-title mb-0">Nu Staff Info View</h5>
                        <a class="btn btn-sm btn-info" href="{{ route('nu-smart-card.index') }}">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <table class="table table-centered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $nuSmartCard->name }}</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{ $nuSmartCard->designation?->name }}</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ $nuSmartCard->department?->name }}</td>
                            </tr>
                            <tr>
                                <th>PF No</th>
                                <td>{{ $nuSmartCard->pf_number }}</td>
                            </tr>
                            <tr>
                                <th>ID Card Number</th>
                                <td>{{ $nuSmartCard->id_card_number }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ \App\Helpers\DateHelpers::dateFormat($nuSmartCard->birth_date) }}</td>
                            </tr>
                            <tr>
                                <th>PRL Date</th>
                                <td>{{ \App\Helpers\DateHelpers::dateFormat($nuSmartCard->prl_date, 'd/m/Y') }}</td>
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
                                <td><img alt="" src="{{ asset('uploads/signature/' .$nuSmartCard->signature) }}"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td><img alt="" src="{{ asset('uploads/images/' .$nuSmartCard->image) }}"></td>
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
