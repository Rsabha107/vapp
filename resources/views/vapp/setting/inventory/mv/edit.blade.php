<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="vapp_inventory_table" />
<input type="hidden" id="edit_vapp_inventory_id" name="id" value="{{$vapp_inventory->id}}">
<!-- <input type="hidden" id="page_refresh_type" value="page_refresh"> -->

<div>
    <div class="card">
        <div class="card-header d-flex align-items-center border-bottom">
            <div class="ms-3">
                <h5 class="mb-0 fs-sm">Edit VAPP Inventory...</h5>
            </div>
        </div>
        <div class="card-body">

            <div class="card-body">
                <div class="row mb-3">
                    <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $vapp_inventory->event_id }}"
                        name="event_id" elementId="add_event_id" label="Event" required="required"
                        :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style="" addDynamicButton="0" />
                </div>
                <div class="row mb-3">
                    <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $vapp_inventory->venue_id }}"
                        name="venue_id" elementId="add_venue_id" label="Venue" required="required"
                        :forLoopCollection="$venues" itemIdForeach="id" itemTitleForeach="title" style="" addDynamicButton="0" />
                </div>
                <div class="row mb-3">
                    <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $vapp_inventory->parking_id }}"
                        name="parking_id" elementId="add_parking_id" label="Parcking Code" required="required"
                        :forLoopCollection="$parkings" itemIdForeach="id" itemTitleForeach="parking_code" style="" addDynamicButton="0" />
                </div>
                <div class="row mb-3">
                    <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue="{{ $vapp_inventory->vapp_size_id }}"
                        name="vapp_size_id" elementId="add_vapp_size_id" label="Vapp Size" required="required"
                        :forLoopCollection="$vappSizes" itemIdForeach="id" itemTitleForeach="title" style="" addDynamicButton="0" />
                </div>

                <div class="row mb-3">
                    <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $vapp_inventory->total_vaps }}"
                        name="total_vaps" elementId="add_total_vaps" inputType="number" label="Total Vapps" required="required" disabled="0" inputAttributes="" />
                </div>
                <div class="row mb-3">
                    <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue="{{ $vapp_inventory->printed_vaps }}"
                        name="printed_vaps" elementId="add_printed_vaps" inputType="number" label="Printed A5" required="required" disabled="0" inputAttributes="" />
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