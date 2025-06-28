@php
    $globalEventId = session()->get('EVENT_ID');
    // echo $globalEventId;
@endphp
<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="add_table" name="table" value="vapp_variation_table" />
                <input type="hidden" id="add_inv_parking_id" name="parking_id" value="" />
                <input type="hidden" id="add_inv_variation_id" name="variation_id" value="" />
                <input type="hidden" id="add_inv_event_id" name="event_id" value="" />
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add Inventory</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <label class="form-label" for="add_inv_venue_id">Venue</label>
                                <select class="form-select" id="add_inv_venue_id" name="venue_id"
                                    data-with="100%" data-placeholder="Select VAPP Size...">
                                    <option value="">Select Venue</option>
                                    <!-- Options loaded dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <label class="form-label" for="add_inv_vapp_size_id">VAPP Size</label>
                                <select class="form-select" id="add_inv_vapp_size_id" name="vapp_size_id"
                                    data-with="100%" data-placeholder="Select VAPP Size...">
                                    <option value="">Select Size</option>
                                    <!-- Options loaded dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="total_vaps" elementId="add_total_vaps" inputType="text"
                                label="Total" required="required" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="printed_vaps" elementId="add_printed_vaps" inputType="text"
                                label="Printed" required="required" disabled="0" />
                        </div>
                        <div class="col-12 gy-3">
                            <div class="row g-3 justify-content-end">
                                <a href="javascript:void(0)" class="col-auto">
                                    <button type="button" class="btn btn-phoenix-danger px-5" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </a>
                                <div class="col-auto">
                                    <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
