@extends('vapp.admin.layout.admin_template')
@section('main')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    {{-- <div class="container-fluid"> --}}
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= get_label('events', 'Events') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <x-button_insert_modal bstitle='Add Event' bstarget="#create_event_modal" />
                <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_event_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_event', 'Create Event') ?>"><i class="bx bx-plus"></i></button></a> -->
            </div>
        </div>
        <x-setting.event-card />
    {{-- </div> --}}

    @include('vapp.setting.modal.event_modals')
        <script src="{{ asset('assets/js/pages/vapp/events.js') }}"></script>

    <script>
        var label_update = '<?= get_label('update', 'Update') ?>';
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
        var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
        var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
    </script>
@endsection

@push('script')
@endpush
