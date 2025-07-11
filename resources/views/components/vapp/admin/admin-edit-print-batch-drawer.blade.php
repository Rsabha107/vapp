<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="edit_table" name="table" value="vapp_variation_table" />
                <input type="hidden" id="edit_variation_id" name="id" value="">
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Edit Parking variation</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="event_id" elementId="edit_event_id" label="Event" required="required"
                                :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style=""
                                addDynamicButton="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="parking_id" elementId="edit_parking_id" label="VAPP Code" required="required"
                                :forLoopCollection="$parkings" itemIdForeach="id" itemTitleForeach="parking_code" style=""
                                addDynamicButton="0" />
                        </div>
                        {{-- <div class="row mb-3">
                            <x-formy.form_select class="col-sm-6 col-md-12" floating="1" selectedValue=""
                                name="match_id" elementId="edit_match_id" label="Match Code" required="required"
                                :forLoopCollection="$matchs" itemIdForeach="id" itemTitleForeach="match_code" style=""
                                addDynamicButton="0" />
                        </div> --}}

                        <div class="row mb-3">
                            <x-formy.select_multiple class="col-sm-6 col-md-12" name="match_id[]"
                                elementId="edit_match_id" label="Match Code assignment (multiple)" :forLoopCollection="$matchs"
                                itemIdForeach="id" itemTitleForeach="match_venue" required="" style="width: 100%"
                                edit="0" />
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <label class="form-label" for="edit_match_id">Match Code assignment (multiple)</label>
                                <select class="form-select js-select-event-assign-multiple-edit_match_id" id="edit_match_id"
                                    name="match_id[]" multiple="multiple" data-with="100%"
                                    data-placeholder="Match Code assignment (multiple)">
                                    @foreach ($matchs as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->match_venue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-12">
                                <label class="form-label" for="edit_fa_id">Functional Area</label>
                                <select class="form-select js-select-event-assign-multiple-edit_fa_id" id="edit_fa_id"
                                    name="fa_id[]" multiple="multiple" data-with="100%"
                                    data-placeholder="Select Fuctional Area...">
                                    <!-- Options loaded dynamically -->
                                </select>
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <x-formy.select_multiple class="col-sm-6 col-md-12" name="fa_id[]"
                                elementId="edit_fa_id" label="Functioanl Area assignment (multiple)" :forLoopCollection="$functionalAreas"
                                itemIdForeach="id" itemTitleForeach="title" required="" style="width: 100%"
                                edit="0" />
                        </div> --}}
                        <div class="row mb-3">
                            <x-formy.select_multiple class="col-sm-6 col-md-12" name="venue_id[]"
                                elementId="edit_venue_id" label="Venue assignment (multiple)" :forLoopCollection="$venues"
                                itemIdForeach="id" itemTitleForeach="title" required="" style="width: 100%"
                                edit="0" />
                        </div>
                        <div class="row mb-3">
                            <x-formy.select_multiple class="col-sm-6 col-md-12" name="vapp_size_id[]"
                                elementId="edit_vapp_size_id" label="VAPP Size assignment (multiple)" :forLoopCollection="$vappSizes"
                                itemIdForeach="id" itemTitleForeach="title" required="" style="width: 100%"
                                edit="0" />
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
