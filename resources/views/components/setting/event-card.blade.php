<!-- meetings -->

<div class="card mt-4 mb-5">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <input type="hidden" id="data_type" value="status">
            <div class="mx-2 mb-2">
                <table  id="event_table"
                        data-toggle="table"
                        data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                        data-loading-template="loadingTemplate"
                        data-url="{{ route('vapp.setting.event.list') }}"
                        data-icons-prefix="bx"
                        data-icons="icons"
                        data-show-export="true"
                        data-show-columns-toggle-all="true"
                        data-show-toggle="true"
                        data-show-fullscreen="true"
                        data-show-refresh="true"
                        data-total-field="total"
                        data-trim-on-search="false"
                        data-data-field="rows"
                        data-page-size="10"
                        data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-pagination="true"
                        data-sort-name="id"
                        data-sort-order="asc"
                        data-mobile-responsive="true"
                        data-buttons-class="secondary"
                        data-query-params="queryParams">
                    <thead>
                        <tr>
                            <!-- <th data-checkbox="true"></th> -->
                            <th data-sortable="true" data-field="id" data-visible="false"><?= get_label('id', 'ID') ?></th>
                            <!-- <th data-sortable="false" data-field="image" data-align="center"></th> -->
                            <th data-sortable="false" data-field="image" data-formatter="imageFormatter" data-align="center"></th>
                            <th data-sortable="true" data-field="title"><?= get_label('title', 'Title') ?></th>
                            <th data-sortable="true" data-field="venues"><?= get_label('venues', 'Venues') ?></th>
                            <th data-sortable="true" data-field="status"><?= get_label('preview', 'Status') ?></th>
                            <th data-sortable="true" data-field="actions" class="text-end">Actions</th>
                            <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                            <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
