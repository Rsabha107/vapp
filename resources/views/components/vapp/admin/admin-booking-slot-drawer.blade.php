<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="add_table" name="table" value="schedule_table" />
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add Booking Schedule</h5>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-4  mb-3">
                                <div class="input-group">
                                    <div class="form-floating">
                                        <select name="event_id"
                                            class="form-select  @error('project_type_id') is-invalid @enderror"
                                            id="add_project_project_type" required>
                                            <option selected="selected" value="">Select event...</option>
                                            @foreach ($events as $key => $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelectPrivacy">Event</label>
                                    </div>
                                    <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please select event.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating input-group">
                                    <select name="venue_id" class="form-select" id="add_project_client" required>
                                        <option selected="selected" value="">Select venue...</option>
                                        @foreach ($venues as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please select venue.
                                    </div>
                                    <label for="floatingSelectAdmin">Venue</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="form-floating input-group">
                                    <select name="rsp_id" class="form-select" id="add_rsp" required>
                                        <option selected="selected" value="">Select RSP...</option>
                                        @foreach ($rsps as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please select rsp.
                                    </div>
                                    <label for="floatingSelectTeam">RSP </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating">
                                        <input class="form-control datetimepicker" id="floatingInputBookingDate"
                                            type="date" placeholder="dd/mm/yyyy" placeholder="booking date"
                                            name="booking_date"
                                            data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required />
                                        <div class="invalid-feedback">
                                            Please enter booking date.
                                        </div>
                                        <label class="ps-6" for="floatingInputBookingDate">Booking date</label><span
                                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating">
                                        <input class="form-control datetimepicker" id="floatingInputBookingDate"
                                            type="date" placeholder="dd/mm/yyyy" placeholder="booking date"
                                            name="slot_visibility"
                                            data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required />
                                        <div class="invalid-feedback">
                                            Please enter slot visibility date.
                                        </div>
                                        <label class="ps-6" for="floatingInputBookingDate">Visible on date</label><span
                                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="rsp_booking_slot" class="form-control" id="add_rsp_booking_slot"
                                        type="text" placeholder="Booking Slot" />
                                    <label for="floatingInputBookingSlot">Booking Slot Time</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="venue_arrival_time" class="form-control" id="add_venue_arrival_time"
                                        type="text" placeholder="Venue Arrival Time" />
                                    <label for="floatingInputBookingSlot">Venue Arrival Time</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-floating">
                                    <input name="bookings_slots_all" class="form-control" id="add_bookings_slots_all"
                                        type="number" step="1" placeholder="Budget" value="0" />
                                    <label for="floatingInputBudget">Booking Slot (All)</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="bookings_slots_cat" class="form-control" id="add_bookings_slots_cat"
                                        type="number" step="1" placeholder="Budget" value="0" />
                                    <label for="floatingInputBudget">Booking Slot(Category)</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="available_slots" class="form-control" id="add_available_slots"
                                        type="number" step="1" placeholder="Budget" value="0" />
                                    <label for="floatingInputBudget">Available Slots</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="used_slots" class="form-control" id="add_used_slots" type="number"
                                        step="1" placeholder="Budget" value="0" />
                                    <label for="floatingInputBudget">Used Slots</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating input-group">
                                    <select name="match_day" class="form-select" id="add_match_day">
                                        <option selected="selected" value="">Select match day flag...</option>
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                    <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please select match day flag.
                                    </div>
                                    <label for="floatingSelectAdmin">Match Day</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 gy-3 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control  @error('comments') is-invalid @enderror" name="comments"
                                    id="floatingProjectOverview" placeholder="Leave a comment here" style="height: 100px"></textarea>
                                <div class="invalid-feedback">
                                    Please enter comments.
                                </div>
                                <label for="floatingProjectOverview">comments</label>
                            </div>
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
                                    <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Create
                                        Project</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>