<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <input type="hidden" id="data_type" value="tags">
            <table id="order_table" data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                data-toggle="table" data-loading-template="loadingTemplate"
                data-url="{{route('cms.contractor.orders.list')}}"
                data-icons-prefix="bx"
                data-icons="icons"
                data-show-export="true"
                data-export-types="['csv', 'txt', 'doc', 'excel', 'xlsx', 'pdf']"
                data-show-refresh="true" data-total-field="total"
                data-trim-on-search="false" data-data-field="rows"
                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                data-side-pagination="server" data-show-columns="true"
                data-pagination="true" data-sort-name="id" data-sort-order="desc"
                data-mobile-responsive="true" data-query-params="purchaseQueryParams">
                <thead>
                    <tr>
                        <th data-checkbox="true" data-halign="left" data-align="center" data-visible="false"></th>
                        <th data-sortable="true" data-field="icon" data-align="center"></th>
                        <!-- <th data-sortable="true" data-field="id1"><?= get_label('id', 'ID') ?></th> -->
                        <!-- <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th> -->
                        <th data-sortable="true" data-field="order_number"><?= get_label('order_number', 'Order#') ?></th>
                        <th data-sortable="true" data-field="customer_id"><?= get_label('Customer', 'Customer') ?></th>
                        <th data-sortable="true" data-field="event_id"><?= get_label('Event', 'Event') ?></th>
                        <th data-sortable="true" data-field="venue_id"><?= get_label('venue', 'Venue') ?></th>
                        <th data-sortable="true" data-field="order_date"><?= get_label('po_date', 'Order Date') ?></th>
                        <th data-sortable="true" data-field="total_quantity"><?= get_label('total_quantity', 'Total Quantity') ?></th>
                        <th data-sortable="true" data-field="total_amount"><?= get_label('total_amount', 'Total Amount') ?></th>
                        <th data-sortable="true" data-field="status"><?= get_label('status', 'Status') ?></th>
                        <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                        <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                        <th data-field="actions"><?= get_label('actions', 'Actions') ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

function purchaseQueryParams(p) {
    return {
        task_status_id: $("#purchase_status_filter").val(),
        person_id: $("#purchases_employee_filter").val(),
        project_id: $("#purchases_project_filter").val(),
        show_page: $("#purchases_show_page_hidden").val(),
        show_page_id: $("#purchases_show_page_id_hidden").val(),
        purchase_start_date_from: $("#purchase_start_date_from").val(),
        purchase_start_date_to: $("#purchase_start_date_to").val(),
        purchase_end_date_from: $("#purchase_end_date_from").val(),
        purchase_end_date_to: $("#purchase_end_date_to").val(),
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
    paginationSwitch: "bx-list-ul",
};

function loadingTemplate(message) {
    return '<i class="bx bx-loader-circle bx-spin bx-flip-vertical" ></i>';
}

    $(
        "#purchase_status_filter,#purchases_employee_filter,#purchases_project_filter"
    ).on("change", function(e) {
        e.preventDefault();
        // console.log("purchases.js on change");
        $("#purchase_table").bootstrapTable("refresh");
    });
</script>
