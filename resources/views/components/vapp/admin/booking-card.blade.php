<!-- meetings -->

<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <input type="hidden" id="data_type" value="booking">
            <div class="mx-2 mb-2">
                <table id="bookings_table"
                    data-toggle="table"
                    data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                    data-loading-template="loadingTemplate"
                    data-url="{{ route('vapp.admin.booking.list')}}"
                    data-icons-prefix="bx"
                    data-icons="icons"
                    data-show-export="true"
                    data-export-types="['csv', 'txt', 'doc', 'excel', 'xlsx', 'pdf']"
                    data-show-columns-toggle-all="true"
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-total-field="total"
                    data-trim-on-search="false"
                    data-data-field="rows"
                    data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true"
                    data-searchable="true"
                    data-strict-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-pagination="true"
                    data-sort-name="id"
                    data-sort-order="desc"
                    data-mobile-responsive="true"
                    data-buttons-class="secondary"
                    data-query-params="bookingQueryParams">
                    <thead>
                        <tr>
                            <!-- <th data-checkbox="true"></th> -->
                            <!-- <th data-sortable="true" data-field="id" class="align-middle white-space-wrap fw-bold fs-9"><?= get_label('id', 'ID') ?></th> -->
                            <th data-sortable="false" data-field="request_number">#</th>
                            <th data-sortable="false" data-field="event_id">Event</th>
                            <th data-sortable="false" data-field="venue_id">Venue</th>
                            <th data-sortable="false" data-field="variation_id">Variation</th>
                            <th data-sortable="false" data-field="parking_id">Parking</th>
                            <th data-sortable="false" data-field="match_id">Match</th>
                            <th data-sortable="false" data-field="functional_area_id">FA</th>
                            <th data-sortable="false" data-field="request_date">Request Date</th>
                            <th data-sortable="false" data-field="vapp_size_id">VAPP Size</th>
                            <th data-sortable="false" data-field="requested_vapps">Requested</th>
                            <th data-sortable="false" data-field="approved_vapps">Approved</th>
                            <th data-sortable="false" data-field="status">Status</th>
                            <!-- <th data-sortable="false" data-field="requested_vapp_a5">A5</th>
                            <th data-sortable="false" data-field="approved_vapp_a5" class="text-success">A5</th>
                            <th data-sortable="false" data-field="requested_vapp_a4">A4</th>
                            <th data-sortable="false" data-field="approved_vapp_a4" class="text-success">A4</th>
                            <th data-sortable="false" data-field="requested_vapp_20">20x20</th>
                            <th data-sortable="false" data-field="approved_vapp_20" class="text-success">20x20</th>
                            <th data-sortable="false" data-field="requested_vapp_hanger">Hanger</th>
                            <th data-sortable="false" data-field="approved_vapp_hanger" class="text-success">Hanger</th> -->

                            <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                            <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                            <th data-field="action" class="text-end"><?= get_label('actions', 'Actions') ?></th>
                            <!-- <th data-formatter="actionsFormatter" class="text-end"><?= get_label('actions', 'Actions') ?></th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    ("use strict");

    function bookingQueryParams(p) {
        return {

            event_filter: $("#event_filter").val(),
            venue_filter: $("#venue_filter").val(),
            vapp_size_filter: $("#vapp_size_filter").val(),
            fa_filter: $("#fa_filter").val(),
            parking_filter: $("#parking_filter").val(),
            variation_filter: $("#variation_filter").val(),
            date_range_filter: $("#date_range_filter").val(),
            status_filter: $("#status_filter").val(),
            page: p.offset / p.limit + 1,
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search,
        };
    }

    window.icons = {
        refresh: "bx-refresh",
        toggleOn: "bx-toggle-right",
        toggleOff: "bx-toggle-left",
        fullscreen: "bx-fullscreen",
        columns: "bx-list-ul",
        export_data: "bx-list-ul",
    };

    function loadingTemplate(message) {
        return '<i class="bx bx-loader-circle bx-spin bx-flip-vertical" ></i>';
    }

    $("#mds_schedule_event_filter,#mds_schedule_venue_filter,#mds_schedule_rsp_filter,#mds_date_range_filter").on("change", function(e) {
        e.preventDefault();
        console.log("tasks.js on change");
        $("#bookings_table").bootstrapTable("refresh");
    });
</script>