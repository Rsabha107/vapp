<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="add_table" name="table" value="parking_master_table" />
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add Parking Master</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="event_id" elementId="add_event_id" label="Event" required="required"
                                :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style=""
                                addDynamicButton="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue=""
                                name="parking_code" elementId="add_title" inputType="text" label="Parking Code"
                                required="required" disabled="0" inputAttributes="" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.select_multiple class="col-md-12 mb-3" name="vapp_size_id[]"
                                elementId="add_vapp_size_id" label="VAPP Size assignment (multiple)" :forLoopCollection="$vappSizes"
                                itemIdForeach="id" edit="0" itemTitleForeach="title" required=""
                                style="width: 100%" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_textarea class="col-sm-6 col-md-12" floating="1" inputValue=""
                                name="description" elementId="add_description" inputType="text" label="Description"
                                required="required" disabled="0" inputAttributes="" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputValue=""
                                name="vapp_color" elementId="add_color" inputType="text" label="Color" required="required" disabled="0" inputAttributes="" />
                        </div>
                        {{-- <div class="row mb-3"> --}}
                        {{-- <x-formy.select_multiple class="col-md-12 mb-3" name="fa_id[]" elementId="add_fa_id"
                            label="FA assignment (multiple)" :forLoopCollection="$functionalAreas" itemIdForeach="id" edit="0"
                            itemTitleForeach="title" required="" style="width: 100%" />
                        </div> --}}

                        <div class="col-12 gy-3">
                            <div class="row g-3 justify-content-end">
                                <a href="javascript:void(0)" class="col-auto">
                                    <button type="button" class="btn btn-phoenix-danger px-5" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </a>
                                <div class="col-auto">
                                    <button class="btn btn-primary px-5 px-sm-10" id="submit_btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
