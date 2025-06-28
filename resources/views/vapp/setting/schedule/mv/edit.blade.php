<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="schedules_table" />
<input type="hidden" id="edit_schedule_id" name="id" value="{{$schedule->id}}">
<!-- <input type="hidden" id="page_refresh_type" value="page_refresh"> -->

<div>
    <div class="card">
        <div class="card-header d-flex align-items-center border-bottom">
            <div class="ms-3">
                <h5 class="mb-0 fs-sm">Add Booking Schedule</h5>
            </div>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-sm-6 col-md-4  mb-3">
                    <div class="form-floating input-group">
                        <select name="event_id"
                            class="form-select  @error('project_type_id') is-invalid @enderror"
                            id="add_project_project_type" required>
                            <option selected="selected" value="">Select event...</option>
                            @foreach ($events as $key => $item)
                            <option value="{{ $item->id }}" @if ($item->id == $schedule->event_id) selected @endif>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-phoenix-primary px-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-plus-circle text-success"></i>
                        </button>
                        <div class="invalid-feedback">
                            Please select event.
                        </div>
                        <label for="floatingSelectPrivacy">Event</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4  mb-3">
                    <div class="form-floating input-group">
                        <select name="venue_id" class="form-select" id="add_project_client" required>
                            <option selected="selected" value="">Select venue...</option>
                            @foreach ($venues as $key => $item)
                            <option value="{{ $item->id }}" @if ($item->id == $schedule->venue_id) selected @endif>
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
                            <option value="{{ $item->id }}" @if ($item->id == $schedule->rsp_id) selected @endif>
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
                                type="text" placeholder="dd/mm/yyyy" placeholder="booking date"
                                name="booking_date"
                                value="{{ $schedule->booking_date ? \Carbon\Carbon::parse($schedule->booking_date)->format('d/m/Y') : null }}"
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
                                type="text" placeholder="dd/mm/yyyy" placeholder="booking date"
                                name="slot_visibility"
                                value="{{ $schedule->slot_visibility ? \Carbon\Carbon::parse($schedule->slot_visibility)->format('d/m/Y') : null }}"
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
                            type="text" placeholder="Booking Slot" value="{{ $schedule->rsp_booking_slot }}" />
                        <label for="floatingInputBookingSlot">Booking Slot Time</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="form-floating">
                        <input name="venue_arrival_time" class="form-control" id="add_venue_arrival_time"
                            type="text" placeholder="Venue Arrival Time"  value="{{ $schedule->venue_arrival_time }}" />
                        <label for="floatingInputBookingSlot">Venue Arrival Time</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6 col-md-3">
                    <div class="form-floating">
                        <input name="bookings_slots_all" class="form-control" id="add_bookings_slots_all"
                            type="number" step="1" placeholder="Budget"  value="{{ $schedule->bookings_slots_all }}" />
                        <label for="floatingInputBudget">Booking Slot (All)</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="form-floating">
                        <input name="bookings_slots_cat" class="form-control" id="add_bookings_slots_cat"
                            type="number" step="1" placeholder="Budget"  value="{{ $schedule->bookings_slots_cat }}" />
                        <label for="floatingInputBudget">Booking Slot(Category)</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="form-floating">
                        <input name="available_slots" class="form-control" id="add_available_slots"
                            type="number" step="1" placeholder="Budget"  value="{{ $schedule->available_slots }}" />
                        <label for="floatingInputBudget">Available Slots</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="form-floating">
                        <input name="used_slots" class="form-control" id="add_used_slots" type="number"
                            step="1" placeholder="Budget"  value="{{ $schedule->used_slots }}" />
                        <label for="floatingInputBudget">Used Slots</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="form-floating">
                        <input name="match_day" class="form-control"
                            id="edit_project_match_day" type="number" step="0.01"
                            placeholder="Budget"  value="{{ $schedule->match_day }}" />
                        <label for="floatingInputBudget">Match Day</label>
                    </div>
                </div>
            </div>

            <div class="col-12 gy-3 mb-3">
                <div class="form-floating">
                    <textarea class="form-control  @error('comments') is-invalid @enderror" name="comments"
                        id="floatingProjectOverview" placeholder="Leave a comment here" style="height: 100px">{{ $schedule->comments }}</textarea>
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
                        <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>