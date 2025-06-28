@extends('vapp.admin.layout.admin_template')
@section('main')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    {{-- <div class="content"> --}}
    <div class="container-fluid">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('vehicle_types', 'Vehicle Type') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <x-button_insert_modal bstitle='Add Vehicle Type' bstarget="#create_vehicle_types_modal" />
                {{-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_vehicle_types_modal"><button
                        type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title=" <?= get_label('create_vehicle_type', 'Create Vehicle Type') ?>"><i
                            class="bx bx-plus"></i></button></a> --}}
            </div>
        </div>
        <x-setting.vehicle-type-card :vehicletypes="$vehicle_types" />
    </div>

    @include('vapp.setting.modal.vehicle_type_modals')
    <script>
        var label_update = '<?= get_label('update', 'Update') ?>';
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
        var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
        var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
    </script>
    <script src="{{ asset('assets/js/pages/vapp/vehicle_type.js') }}"></script>
@endsection

@push('script')
@endpush
