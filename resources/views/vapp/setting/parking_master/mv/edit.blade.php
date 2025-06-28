<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>
<script>
    $(".js-select-event-assign-multiple-edit_fa_id").select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    $(".js-select-event-assign-multiple-edit_vapp_size_id").select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });
</script>
<!-- <script src="{{asset('assets/js/pages/vapp/parking_master.js')}}"></script> -->


<input type="hidden" name="table" value="parking_master_table" />
<input type="hidden" id="edit_parking_master_id" name="id" value="{{$parking->id}}">
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
                <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $parking->event_id }}"
                    name="event_id" elementId="edit_event_id" label="Event" required="required"
                    :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style="" addDynamicButton="0" />
            </div>
            <div class="row mb-3">
                <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $parking->parking_code }}"
                    name="parking_code" elementId="edit_parking_code" inputType="text" label="Parking Code" required="required" disabled="0" inputAttributes="" />
            </div>
            <div class="row mb-3">
                <x-formy.select_multiple class="col-md-12 mb-3" name="vapp_size_id[]" elementId="edit_vapp_size_id"
                    label="VAPP Size assignment (multiple)" :forLoopCollection="$vappSizes" itemIdForeach="id"
                    :baseModel="$parking" relation="vapp_sizes" edit="1"
                    itemTitleForeach="title" required="" style="width: 100%" />
            </div>
            <div class="row mb-3">
                <x-formy.form_textarea class="col-sm-6 col-md-12" floating="1" inputValue="{{ $parking->description }}"
                    name="description" elementId="edit_description" inputType="text" label="Description" required="required" disabled="0" inputAttributes="" />
            </div>
            {{-- <div class="row mb-3">
                <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $parking->vapp_color }}"
                    name="vapp_color" elementId="edit_color" inputType="text" label="Color" required="required" disabled="0" inputAttributes="" />
            </div>
            <div class="row mb-3">
                <x-formy.select_multiple class="col-md-12 mb-3" name="fa_id[]" elementId="edit_fa_id"
                    label="FA assignment (multiple)" :forLoopCollection="$functionalAreas" itemIdForeach="id"
                    itemTitleForeach="title" required="" style="width: 100%" edit="1"
                    :baseModel="$parking" relation="functional_areas" />
            </div> --}}
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