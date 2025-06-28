@extends('vapp.admin.layout.admin_template')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

<!-- <div class="content"> -->
<!-- <div class="container-fluid"> -->
<div class="d-flex justify-content-between m-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{route('home')}}"><?= get_label('home', 'Home') ?></a>
                </li>
                <li class="breadcrumb-item active">
                    <?= get_label('bookings', 'Bookings') ?>
                </li>
            </ol>
        </nav>
    </div>
    <div>
        <x-formy.button
            url="{{route('vapp.admin.booking.create')}}"
            title="New Booking"
            icon="fa-solid fa-plus"
            class="btn btn-subtle-primary px-3 px-sm-5 me-2" />
        {{-- <x-button title='New Booking' url="{{ route('vapp.admin.booking.create') }}" /> --}}
        {{-- <a href="{{route('vapp.admin.booking.create')}}"><button class="btn btn-subtle-primary px-3 px-sm-5 me-2"><span class="fa-solid fa-plus me-sm-2"></span><span class="d-none d-sm-inline">New Booking</span></button></a> --}}
        {{-- <a href="{{route('vapp.admin.booking.create')}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_booking', 'Create a new booking') ?>"><i class="bx bx-plus"></i></button></a> --}}
    </div>
</div>
<div class="d-flex justify-content-center">
    <div id="cover-spin" style="display:none;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="col-12 col-sm-auto">
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
            <input class="form-control datetimepicker" id="mds_date_range_filter" type="text" placeholder="d/m/y to d/m/y"
                data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
        </div>

        <!-- <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0">More filters</button> -->
    </div>
</div>
<x-vapp.admin.booking-card :bookings="$bookings" />
<!-- </div> -->

@include('vapp.admin.modals.request_modal')

<script src="{{asset('assets/js/pages/vapp/booking.js')}}"></script>
@endsection

@push('script')


@endpush