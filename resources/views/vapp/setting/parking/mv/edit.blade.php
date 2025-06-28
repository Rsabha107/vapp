<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="parking_table" />
<input type="hidden" id="edit_parking_capacity_id" name="id" value="{{$parking->id}}">
<!-- <input type="hidden" id="page_refresh_type" value="page_refresh"> -->

<div>
    <div class="card">
        <div class="card-header d-flex align-items-center border-bottom">
            <div class="ms-3">
                <h5 class="mb-0 fs-sm">Edit Booking Schedule</h5>
            </div>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $parking->parking_code }}"
                    name="parking_code" elementId="add_title" inputType="text" label="Parking Number" required="required" disabled="0"  inputAttributes=""/>
            </div>
            <div class="row mb-3">
                <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $parking->event_id }}"
                    name="event_id" elementId="add_event_id" label="Event" required="required"
                    :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style="" addDynamicButton="0" />
            </div>
            <div class="row mb-3">
                <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $parking->venue_id }}"
                    name="venue_id" elementId="add_venue_id" label="Venue" required="required"
                    :forLoopCollection="$venues" itemIdForeach="id" itemTitleForeach="title" style="" addDynamicButton="0" />
            </div>
            <div class="row mb-3">
                <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $parking->vehicle_type_id }}"
                    name="vehicle_type_id" elementId="add_vehicle_type_id" label="Vehicle Type" required="required"
                    :forLoopCollection="$vehicleTypes" itemIdForeach="id" itemTitleForeach="title" style="" addDynamicButton="0" />
            </div>
            <div class="row mb-3">
                <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $parking->capacity }}"
                    name="capacity" elementId="add_capacity" inputType="text" label="Capacity" required="required" disabled="0"  inputAttributes=""/>
            </div>
            <div class="col-12 gy-3">
                <div class="row g-3 justify-content-end">
                    <a href="javascript:void(0)" class="col-auto">
                        <button type="button" class="btn btn-phoenix-danger px-5"
                            data-bs-toggle="tooltip" data-bs-placement="right"
                            data-bs-dismiss="offcanvas">
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
</div>