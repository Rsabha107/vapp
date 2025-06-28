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
                    Inventory
                </li>
            </ol>
        </nav>
    </div>
    {{-- <div>
        <x-button_insert_js title='Add VAPP Inventory' selectionId="offcanvas-add-vapp-inventory" dataId="0"
            table="vapp_inventory_table" />
    </div> --}}
</div>
<x-setting.vapp-inventory-card />


@include('vapp.setting.modal.vapp_inventory_modals')

<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
    var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
</script>
<script src="{{asset('assets/js/pages/vapp/vapp_inventory.js')}}"></script>
@endsection

@push('script')


@endpush