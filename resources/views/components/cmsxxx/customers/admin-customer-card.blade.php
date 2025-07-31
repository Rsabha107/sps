<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            {{$slot}}
            <input type="hidden" id="data_type" value="tags">
            <table id="vendor_table" data-classes="table table-hover  fs-9 mb-0 border-top border-translucent"
                data-toggle="table" data-loading-template="loadingTemplate"
                data-url="{{route('procurement.admin.vendor.list')}}"
                data-icons-prefix="bx"
                data-icons="icons"
                data-show-export="true"
                data-export-types="['csv', 'txt', 'doc', 'excel', 'xlsx', 'pdf']"
                data-show-refresh="true" data-total-field="total"
                data-trim-on-search="false" data-data-field="rows"
                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                data-side-pagination="server" data-show-columns="true"
                data-pagination="true" data-sort-name="id" data-sort-order="desc"
                data-mobile-responsive="true" data-query-params="vendorQueryParams">
                <thead>
                    <tr>
                        <th data-checkbox="true" data-halign="left" data-align="center" data-visible="false"></th>
                        <!-- <th data-sortable="true" data-field="id1"><?= get_label('id', 'ID') ?></th> -->
                        <!-- <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th> -->
                        <th data-sortable="true" data-field="name"><?= get_label('name', 'Name') ?></th>
                        <th data-sortable="true" data-field="contact_name"><?= get_label('contact_name', 'Contact Name') ?></th>
                        <th data-sortable="true" data-field="email"><?= get_label('email', 'email') ?></th>
                        <th data-sortable="true" data-field="phone_number"><?= get_label('phone_number', 'Phone Number') ?></th>
                        <th data-sortable="true" data-field="website"><?= get_label('website', 'website') ?></th>
                        <th data-sortable="true" data-field="currency"><?= get_label('currency', 'Currency') ?></th>
                        <th data-sortable="true" data-field="billing_address"><?= get_label('billing_address', 'billing address') ?></th>
                        <th data-sortable="true" data-field="shipping_address"><?= get_label('shipping_address', 'shipping address') ?></th>
                        <th data-sortable="true" data-field="opening_balance"><?= get_label('opening_balance', 'opening balance') ?></th>
                        <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                        <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                        <!-- <th data-formatter="actions2Formatter"><?= get_label('actions', 'Actions') ?></th> -->
                        @if(Auth::user()->hasRole('SuperAdmin|HRMSADMIN'))
                        <th data-field="actions"><?= get_label('actions', 'Actions') ?></th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    function vendorQueryParams(p) {
        return {
            task_status_id: $("#vendor_status_filter").val(),
            person_id: $("#vendors_employee_filter").val(),
            project_id: $("#vendors_project_filter").val(),
            show_page: $("#vendors_show_page_hidden").val(),
            show_page_id: $("#vendors_show_page_id_hidden").val(),
            vendor_start_date_from: $("#vendor_start_date_from").val(),
            vendor_start_date_to: $("#vendor_start_date_to").val(),
            vendor_end_date_from: $("#vendor_end_date_from").val(),
            vendor_end_date_to: $("#vendor_end_date_to").val(),
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
        "#vendor_status_filter,#vendors_employee_filter,#vendors_project_filter"
    ).on("change", function(e) {
        e.preventDefault();
        // console.log("vendors.js on change");
        $("#vendor_table").bootstrapTable("refresh");
    });
</script>