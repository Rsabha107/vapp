@extends('vapp.admin.layout.admin_template')


@section('main')
<div class="container-fluid p-3" style="background-color: #e8ebee;">
    <div class="bg-white border rounded shadow-sm p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center bg-warning text-white px-3 py-2 rounded">
            <h5 class="mb-0">Processing Request No: <strong>{{ $vapp->request_number }}</strong></h5>
            <div>
                <!-- <button class="btn btn-light btn-sm">💾 Save</button> -->
                <a href="{{ route('vapp.admin') }}" class="btn btn-light btn-sm">🔙 Back</a>
            </div>
        </div>

        <!-- Form Inputs -->
        <form action="{{ route('vapp.admin.booking.request.save') }}" method="POST" class="mt-3">
            @csrf
            <!-- @method('PUT') -->

            <input type="hidden" name="id" value="{{ $vapp->id }}">
            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label">Parking Code</label>
                    <select class="form-select">
                        <option value="STAFF" selected>{{ $vapp->parking->parking_code }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Match</label>
                    <select class="form-select">
                        <option value="ALL" selected>{{ $vapp->match->match_code_date }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Venue</label>
                    <select class="form-select">
                        <option value="LMA" selected>{{ $vapp->venue->title }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Functional Area</label>
                    <select class="form-select">
                        <option value="LMA" selected>{{ $vapp->functional_area->title }}</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-6 col-md-3">
                    <label class="form-label">VAPP Size</label>
                    <select class="form-select">
                        <option value="LMA" selected>{{ $vapp->vapp_size->title }}</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-3">
                    <label class="form-label"># Requested</label>
                    <input type="text" class="form-control" readonly value="{{ $vapp->requested_vapps }}">
                </div>
                <div class="col-sm-6 col-md-3">
                    <label class="form-label"># Approved</label>
                    <input name="approved_vapps" type="number" class="form-control" value="{{ $vapp->approved_vapps }}">
                </div>
                <x-formy.form_select class="col-sm-6 col-md-3" floating="0" selectedValue="{{ $vapp->request_status_id }}"
                    name="request_status_id" elementId="add_var_request_status_id" label="Request Satus"
                    required="required" :forLoopCollection="$requestStatus" itemIdForeach="id"
                    itemTitleForeach="title" style="" addDynamicButton="0" />

            </div>

            <div class="mb-2">
                <label class="form-label">Justification</label>
                <textarea class="form-control" rows="2" readonly>{{ $vapp->justification }}</textarea>
            </div>

            <!-- <div class="mt-4">
                <label class="form-label">Send Message to Focal Point:</label>
                <div class="d-flex align-items-center mb-2">
                    <a href="mailto:m.endriga@sc.qa">m.endriga@sc.qa</a>
                    <span class="ms-4">FA: Marketing & Promotions & Signage</span>
                    <button type="button" class="btn btn-primary btn-sm ms-auto">✉ Send</button>
                </div>
                <textarea class="form-control" rows="4" placeholder="Write your message..."></textarea>
            </div> -->

            <button type="submit" class="btn btn-success mt-3">✅ Save Changes</button>
        </form>
    </div>

    <!-- Availability / Inventory -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="bg-white p-3 border rounded shadow-sm">
                <h6>Availability Infos</h6>
                <p><strong>{{ $vapp->parking_code }} {{ $vapp->match_code }} {{ $vapp->venue_code }}</strong></p>
                <ul class="list-unstyled">
                    <li>🚗 Parking Capacity: {{ $capacity }}</li>
                    <li class="text-danger">🚗 Approved Request: {{ $total_approved_capacity }}</li>
                    <li class="text-success">🚗 Available Parkings: {{ $available_capacity }}</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="bg-white p-3 border rounded shadow-sm">
                <h6>Inventory Infos</h6>
                <ul class="list-unstyled">
                    <li>🖨️ Total to be printed: {{ $inventory?->total_vaps }}</li>
                    <li>✅ VAPPs Printed: {{ $inventory?->printed_vaps }}</li>
                    <li>📤 VAPPs Distributed: {{ $inv_total_collected_vaps }}</li>
                    <li>📦 Available Stock: {{ $inv_total_available_vaps }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection