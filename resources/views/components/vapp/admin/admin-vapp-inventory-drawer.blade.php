<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="add_table" name="table" value="match_table" />
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add VAPP Inventory Schedule</h5>
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
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="venue_id" elementId="add_venue_id" label="Venue" required="required"
                                :forLoopCollection="$venues" itemIdForeach="id" itemTitleForeach="title" style=""
                                addDynamicButton="0" />
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <div class="form-floating">
                                    <select class="form-select" id="add_variation_code" name="variation_code_id"
                                        data-with="100%" data-placeholder="Variation Code">
                                        <option selected="selected" value="">Select Variation Code...</option>
                                        @foreach ($vappVirationCodes as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->parking->parking_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="add_variation_code">Variation Code</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <div class="form-floating">
                                    <select class="form-select" id="add_variation_code" name="variation_code_id"
                                        data-with="100%" data-placeholder="Variation Code">
                                        <option selected="selected" value="">Select Variation Code...</option>
                                        @foreach ($vappVariations as $item)
                                            @foreach($item->vapp_sizes as $size)
                                            <option value="{{ $size->id }}">
                                                {{ $size->title }}
                                            </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <label for="add_variation_code">Variation Code</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="parking_code_id" elementId="add_parking_code_id" label="Parking Code"
                                required="required" :forLoopCollection="$vappVirationCodes" itemIdForeach="id"
                                itemTitleForeach="parking_code" style="" addDynamicButton="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="a5_total" elementId="add_a5_total" inputType="number"
                                label="Total A5" required="" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="a5_printed" elementId="add_a5_printed" inputType="number"
                                label="Printed A5" required="" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="a4_total" elementId="add_a4_total" inputType="number"
                                label="Total A4" required="" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="a4_printed" elementId="add_a4_printed" inputType="number"
                                label="Printed A4" required="" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="x20_total" elementId="add_x20_total" inputType="number"
                                label="Total 20X" required="" disabled="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_input class="col-sm-6 col-md-12" floating="1" inputAttributes=""
                                inputValue="" name="x20_printed" elementId="add_x20_printed" inputType="number"
                                label="Printed 20X" required="" disabled="0" />
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
            </form>
        </div>
    </div>
</div>
