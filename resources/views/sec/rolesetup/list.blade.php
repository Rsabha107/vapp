@extends('vapp.admin.layout.admin_template')
@section('main')

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

    <div class="mt-4">
        <div class="row g-4">
            <!-- this controls the size of the table  -->
            <div class="col-12 col-sm-10 order-1 order-xl-0">
                <div class="mb-9">

                    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor">All Roles in Permission List</h4>
                                </div>
                                <div class="col col-md-auto">
                                    <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                                        <!-- <button class="btn btn-primary me-4" type="button" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" aria-haspopup="true" aria-expanded="false"
                                            data-bs-reference="parent"><span class="fas fa-plus me-2"></span>Add
                                            Deal</button> -->
                                        <a class="btn btn-sm btn-phoenix-primary preview-btn ms-2" href="{{ route('sec.rolesetup.add')}}"><span class="fa-solid fa-add"></span>Add</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="collapse code-collapse" id="ajax-table-code">
                                <pre class="scrollbar" style="max-height:420px"><code class="language-html"></code></pre>
                            </div>
                            <div class="p-4 code-to-copy">
                                <div class="table-list">
                                    <div class="table-responsive scrollbar mb-3">
                                        <table class="table table-sm table-responsive fs--1 mb-0 overflow-hidden" id="dataList">
                                            <thead class="text-900 thead">
                                                <tr>
                                                    <th class="sort ps-3 pe-1 align-middle white-space-nowrap" data-sort="orderId" style="min-width: 4.5rem;">SL</th>
                                                    <th class="sort ps-3 pe-1 align-middle white-space-nowrap" data-sort="orderId" style="min-width: 4.5rem;">Role Name</th>
                                                    <th class="sort ps-3 pe-1 align-middle white-space-nowrap" data-sort="orderId" style="min-width: 4.5rem;">Permissions</th>
                                                    <th class="no-sort" style="text-align:right"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list">
                                                @foreach ($roles as $key => $item )

                                                <tr>
                                                    <td class="ps-3">{{ $item->id }}</td>
                                                    <td class="ps-3">{{ $item->name }}</td>


                                                    <td class="ps-3">
                                                        @foreach ($item->permissions as $perm )
                                                         <span class="badge bg-danger">{{ $perm->name }}</span>
                                                        @endforeach
                                                        </td>

                                                    <td class="text-end">
                                                        <div class="actions">
                                                            <a href="{{route('sec.rolesetup.edit', $item->id)}}" class="btn btn-sm" data-toggle="modal" data-target='#editModal' data-route="perm" data-id="{{ $item->id }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a href="{{ route('sec.rolesetup.delete',$item->id)}} " class="btn btn-sm delete" id="delete">
                                                                <i class="fa-solid fa-trash" style="color: #f33061;"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- add event modal 1-->
    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">Launch demo modal 2</button> -->


    <!-- add event modal offcanvas left side  -->
    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header align-items-start border-bottom flex-column">
            <div class="pt-1 w-100 mb-6 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-2 me-2 lh-sm"><span class="fas fa-palette me-2 fs-0"></span>Theme Customizer</h5>
                    <p class="mb-0 fs--1">Explore different styles according to your preferences</p>
                </div>
                <button class="btn p-1 fw-bolder" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span class="fas fa-times fs-0"> </span></button>
            </div>
            <button class="btn btn-phoenix-secondary w-100" data-theme-control="reset"><span class="fas fa-arrows-rotate me-2 fs--2"></span>Reset to default</button>
        </div>
    </div>
    <!-- <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center px-2 py-1">
            <div class="position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover"><span class="ripple"><span
                            class="fa-spin position-absolute all-0 d-flex flex-center"><span
                                class="icon-spin position-absolute all-0 d-flex flex-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="#ffffff"
                                    xmlns="http://www.w3.org/2000/svg">
                                </svg></span></span></span></div>
            </div><small class="text-uppercase text-700 fw-bold py-2 pe-2 ps-1 rounded-end">customize</small>
        </div>
    </a> -->


    @endsection

    @push('script')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#dataList').DataTable({
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdf',
                //     // 'colvis'
                // ]
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 5]
                            }
                        },
                        'colvis'
                    ],
                }]
            });
        });
    </script>

    @include('vapp.partials.event-js')

    @endpush
