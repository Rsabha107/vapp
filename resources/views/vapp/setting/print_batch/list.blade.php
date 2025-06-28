@extends('vapp.admin.layout.admin_template')
@section('main')


<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->


<div class="d-flex justify-content-between m-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{route('home')}}"><?= get_label('home', 'Home') ?></a>
                </li>
                <li class="breadcrumb-item active">
                    <?= get_label('variation', 'Printing Batch') ?>
                </li>
            </ol>
        </nav>
    </div>
    <div>
        <x-button_insert_js title='Add Printing Batch' selectionId="offcanvas-add-print-batch" dataId="0"
            table="vapp_print_batch_table" />
    </div>
</div>
<x-setting.parking-print-batch-card />


@include('vapp.setting.modal.parking_print_batch_modals')

<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
    var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
</script>
<script src="{{asset('assets/js/pages/vapp/print_batch.js')}}"></script>
@endsection

@push('script')


@endpush