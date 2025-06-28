@extends('vapp.admin.layout.admin_template')
@section('main')
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

{{-- <div class="content"> --}}
{{-- <div class="container-fluid"> --}}
<div class="d-flex justify-content-between m-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/home') }}"><?= get_label('home', 'Home') ?></a>
                </li>
                <li class="breadcrumb-item active">
                    <?= get_label('schedules', 'schedules') ?>
                </li>
            </ol>
        </nav>
    </div>
    <div>
        {{-- <a class="btn btn-sm btn-phoenix-warning preview-btn ms-2" href="{{ route('vapp.setting.schedule.import') }}"><span
            class="fa-solid fa-add"></span> Import</a>
        <a class="btn btn-sm btn-phoenix-success preview-btn me-5"
            href="{{ route('vapp.setting.schedule.export.store') }}"><span class="fa-solid fa-download"></span>
            Export</a> --}}
        <x-button_insert_js title='Add Booking Schedule' selectionId="offcanvas-add-booking-slot" dataId="0"
            table="schedule_table" />
        <button class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover action-btn" type="button"
            data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"
            data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis" data-fa-transform="shrink-2"
                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""
                style="transform-origin: 0.4375em 0.5em;">
                <g transform="translate(224 256)">
                    <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                        <path fill="currentColor"
                            d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"
                            transform="translate(-224 -256)"></path>
                    </g>
                </g>
            </svg><!-- <span class="fas fa-ellipsis-h" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com -->
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="">
            <li><a class="dropdown-item ms-2 text-warning" href="{{ route('vapp.setting.schedule.import') }}">
                    <span class="fa-solid fa-upload text-warning me-2"></span>Import</a></li>
            <li><a class="dropdown-item ms-2 text-success me-2" href="{{ route('vapp.setting.schedule.export.store') }}">
                    <span class="fa-solid fa-download text-success me-2"></span>Export</a></li>
        </ul>
    </div>
</div>
<div class="col col-md-auto">
    <nav class="nav nav-underline justify-content-start doc-tab-nav align-items-center" role="tablist">
        <!-- <button class="btn btn-primary me-4" type="button" data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop" aria-haspopup="true" aria-expanded="false"
                                                            data-bs-reference="parent"><span class="fas fa-plus me-2"></span>Add
                                                            Deal</button> -->
        {{-- <a class="btn btn-sm btn-phoenix-warning preview-btn ms-2"
            href="{{ route('vapp.setting.schedule.import') }}"><span class="fa-solid fa-add"></span> Import</a>
        <a class="btn btn-sm btn-phoenix-success preview-btn ms-2"
            href="{{ route('vapp.setting.schedule.export.store') }}"><span class="fa-solid fa-download"></span> Export</a> --}}

        <div class="col-12 col-sm-auto">
            {{-- <input class="form-control datetimepicker" id="mds_date_range_filter" type="text"
                    placeholder="d/m/y to d/m/y"
                    data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' /> --}}
            <div class="btn-group position-static" role="group">
                <div class="py-0 me-2">
                    <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                        id="mds_schedule_event_filter">
                        <option value="" selected>Filter by Event .... </option>
                        @foreach ($events as $key => $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="py-0 me-2">
                    <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                        id="mds_schedule_venue_filter">
                        <option value="" selected>Filter by Venue .... </option>
                        @foreach ($venues as $key => $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="py-0 me-2">
                    <select class="form-select form-select-sm py-2 ms-n2 border-0 shadow-none"
                        id="mds_schedule_rsp_filter">
                        <option value="" selected>Filter by RSP .... </option>
                        @foreach ($rsps as $key => $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="py-0 me-2">
                    <input class="form-control datetimepicker" id="mds_date_range_filter" type="text"
                        placeholder="d/m/y to d/m/y"
                        data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
                </div>
                <!-- <script>
                    $(document).ready(function() {
                        $('#mds_date_range_filter').flatpickr({
                            mode: "range",
                            dateFormat: "d/m/Y",
                            disableMobile: true,
                            onChange: function(selectedDates, dateStr, instance) {
                                var startDate = selectedDates[0];
                                var endDate = selectedDates[1];
                                console.log(startDate, endDate);
                                // Set the value of the input field to the selected date range
                                // if (startDate && endDate) {
                                //     $('#mds_date_range_filter').val(startDate.toLocaleDateString() + ' to ' + endDate.toLocaleDateString());
                                // }
                            }
                        });
                    });
                </script> -->

                <!-- <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters</button> -->
            </div>
        </div>
    </nav>
</div>

@include('vapp.admin.partials.schedule_modals')

<x-setting.schedule-card :schedules="$schedules" />

<script src="{{ asset('assets/js/pages/vapp/schedule.js') }}"></script>
@endsection

@push('script')
@endpush