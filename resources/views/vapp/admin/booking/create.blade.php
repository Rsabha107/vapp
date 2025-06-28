@extends('vapp.admin.layout.admin_template')
@section('main')

    <link rel="stylesheet" href="{{ asset('assets/css/vapp_box.css') }}">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    {{-- <div class="content"> --}}

    <div class="d-flex justify-content-between m-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('vapp.admin.booking') }}">
                            <?= get_label('request', 'Requests') ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= get_label('save', 'Save') ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div id="cover-spin" style="display:none;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container">
        @if (session('message'))
            <div class="alert">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow-none border my-4 col-md-10" style="margin:0 auto;"
            data-component-card="data-component-card">
            <div class="card-header p-4 border-bottom bg-body">
                <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-body mb-0" data-anchor="data-anchor">Creat a new Request</h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                    <form class="row g-3  px-3 needs-validation" action="{{ route('vapp.admin.request.store') }}"
                        id="form-1" novalidate method="POST">
                        @csrf
                        <input type="hidden" id="add_schedule_period_id" name="schedule_period_id" value="">
                        <input type="hidden" id="add_booking_date" name="booking_date">
                        <input type="hidden" id="add_variation_id" name="variation_id">

                        <div class="row py-2">
                            <div class="col-sm-6 col-md-8">
                                <div class="card shadow-none border col-md-12" style="margin:0 auto;"
                                    data-component-card="data-component-card">
                                    <div class="card-body p-3">
                                        <div class="row mb-3">
                                            <x-formy.form_select class="col-sm-6 col-md-6" floating="0" selectedValue=""
                                                name="parking_id" elementId="add_var_parking_id" label="VAPP Code"
                                                required="required" :forLoopCollection="$varParkingCode" itemIdForeach="id"
                                                itemTitleForeach="parking_code" style="" addDynamicButton="0" />

                                            <x-formy.form_select class="col-sm-6 col-md-6" floating="0" selectedValue=""
                                                name="match_category_id" elementId="add_var_category_id" label="Category"
                                                required="required" :forLoopCollection="$matchCategories" itemIdForeach="id"
                                                itemTitleForeach="title" style="" addDynamicButton="0" />
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-6 col-md-12">
                                                <label class="form-label" for="add_var_match_id">Match</label>
                                                <select class="form-select" id="add_var_match_id" name="match_id"
                                                    data-with="100%" data-placeholder="Select VAPP Size...">
                                                    <option value="">Select Match</option>
                                                    <!-- Options loaded dynamically -->
                                                </select>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                        <div class="row mb-3">
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label" for="add_var_venue_id">Venue</label>
                                                <select class="form-select" id="add_var_venue_id" name="venue_id"
                                                    data-with="100%" data-placeholder="Select VAPP Size...">
                                                    <option value="">Select Venue</option>
                                                    <!-- Options loaded dynamically -->
                                                </select>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- <div class="row mb-3"> --}}
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label" for="add_var_match_id">Functional Area</label>
                                                <select class="form-select" id="add_var_functional_area_id"
                                                    name="var_functional_area_id" data-with="100%"
                                                    data-placeholder="Select Functional Area Size...">
                                                    <option value="">Select FA</option>
                                                    <!-- Options loaded dynamically -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label" for="add_var_vapp_size_id">VAPP Size</label>
                                                <select class="form-select" id="add_var_vapp_size_id" name="vapp_size_id"
                                                    data-with="100%" data-placeholder="Select VAPP Size...">
                                                    <option value="">Select Vap Size</option>
                                                    <!-- Options loaded dynamically -->
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label" for="add_requested_vapps"># VAPPS
                                                </label>
                                                <input class="form-control" id="add_requested_vapps" name="requested_vapps" type="number"
                                                    placeholder="Quantity of Vapps requested" requered />
                                            </div>

                                            {{-- <x-formy.form_input class="col-sm-6 col-md-6" floating="1"
                                                inputAttributes="" inputValue="" name="requested_vapps"
                                                elementId="add_requested_vapps" inputType="number" label="#VAPPS"
                                                required="" disabled="0" /> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="card shadow-none border-none col-md-12" style="margin:0 auto;">
                                    <div class="main-card">
                                        <div class="day-label">DAY1</div>
                                        <div class="logo">2024 FIFA<br>Intercontinental Cup</div>
                                        <div class="sub-card lma">LMA</div>
                                        <div class="sub-card p14">P14</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- <div class="row py-2">
                            <div class="col-sm-6 col-md-12">
                                <div class="card shadow-none border col-md-12" style="margin:0 auto;"
                                    data-component-card="data-component-card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class=" col-sm-6 col-md-3">
                                                <label class="form-label" for="add_requested_vapp_a5">A5 </label>
                                                <input class="form-control" id="add_requested_vapp_a5" type="number"
                                                    name="requested_vapp_a5" min="0" placeholder="A5" disabled />
                                            </div>
                                            <div class=" col-sm-6 col-md-3">
                                                <label class="form-label" for="add_requested_vapp_a4">A4 </label>
                                                <input class="form-control" id="add_requested_vapp_a4" type="number"
                                                    name="requested_vapp_a4" min="0" placeholder="A4" disabled />
                                            </div>
                                            <div class=" col-sm-6 col-md-3">
                                                <label class="form-label" for="add_requested_vapp_20">20x20 </label>
                                                <input class="form-control" id="add_requested_vapp_20" type="number"
                                                    name="requested_vapp_20" min="0" placeholder="20x20"
                                                    disabled />
                                            </div>
                                            <div class=" col-sm-6 col-md-3">
                                                <label class="form-label" for="add_requested_vapp_hanger">Hanger </label>
                                                <input class="form-control" id="add_requested_vapp_hanger" type="number"
                                                    name="requested_vapp_hanger" min="0" placeholder="Hanger"
                                                    disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-6 col-md-12">
                                <div class="card shadow-none border col-md-12" style="margin:0 auto;"
                                    data-component-card="data-component-card">

                                    <x-formy.form_textarea class="col-sm-12 col-md-12 p-3" floating="1" inputValue=""
                                        name="comments" elementId="add_comments" label="Comments" required=""
                                        disabled="0" />
                                </div>
                            </div>
                        </div>
                        <!-- <div class="invisible">.</div> -->
                        <div class="col-12 d-flex justify-content-end mt-6">
                            <button class="btn btn-primary" type="submit">Save booking</button>
                        </div>
                        <!-- <button class="btn btn-primary" type="submit">Submit</button> -->
                    </form>
                </div>
            </div>
            <!-- <br /> -->
            <!-- &nbsp; -->
        </div>
        {{-- <div class="main-card">
            <div class="day-label">DAY1</div>
            <div class="logo">2024 FIFA<br>Intercontinental Cup</div>
            <div class="sub-card lma">LMA</div>
            <div class="sub-card p14">P14</div>
        </div> --}}
    </div>
    <script src="{{ asset('assets/js/pages/vapp/booking.js') }}"></script>

    <!-- Confirm Modal -->
    <!-- <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="confirmModalLabel">Order Placed</h5>
                                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">Congratulations! Your order is placed.</div>
                                                                                                                <div id="jsonOutput"></div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <button type="button" class="btn btn-primary" onclick="closeModal()">
                                                                                                                        Ok, close and reset
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div> -->

    <script src="{{ asset('assets/js/pages/vapp/booking_request.js') }}"></script>
@endsection

@push('script')
@endpush
