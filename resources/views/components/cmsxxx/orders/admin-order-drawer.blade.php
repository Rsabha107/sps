<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" name="table" value="order_table" />

                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Create Order</h5>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">ORD</span>
                                    <div class="form-floating">
                                        <input class="form-control" name="po_number" type="text"
                                            placeholder="Purchase Order Number (Auto Generated)" disabled />
                                        <div class="invalid-feedback">
                                            Please enter Order Number.
                                        </div>
                                        <label for="floatingInputGrid">Order Number generated Automatically</label>
                                    </div>
                                </div>
                            </div>
                            <x-formy.form_date_input class="col-sm-6 col-md-3 mb-3" floating="1" inputType="date"
                                inputValue="" name="order_date" elementId="add_order_date" label="Order Date"
                                required="required" />

                            <x-formy.form_select class="col-sm-6 col-md-3 mb-3" floating="1" selectedValue=""
                                name="customer_id" elementId="add_customer_id" label="Customer" required="required"
                                :forLoopCollection="$customers" itemIdForeach="id" itemTitleForeach="name" style=""
                                addDynamicButton="0" />

                            <x-formy.form_select class="col-sm-6 col-md-3 mb-3" floating="1" selectedValue=""
                                name="currency_id" elementId="add_currency_id" label="Currency" required="required"
                                :forLoopCollection="$currency" itemIdForeach="id" itemTitleForeach="currency_symbol" style=""
                                addDynamicButton="0" />

                            {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating">
                                    <select name="vendor_id" class="form-select" id="add_vendor_id">
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($customers as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select Vendor name.
                                    </div>
                                    <label for="floatingSelectTeam">Vendor name </label>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating">
                                    <select name="currency_id" class="form-select" id="add_currencyid">
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($currency as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code }} ({{ $item->symbol }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select Currency.
                                    </div>
                                    <label for="floatingSelectTeam">Currency</label>
                                </div>
                            </div> --}}
                        </div>
                        {{-- <div class="row mb-3"> --}}
                        {{-- <x-formy.form_date_input class="col-sm-6 col-md-4 mb-3" floating="1" inputType="date"
                                inputValue="" name="order_date" elementId="add_order_date" label="Order Date"
                                required="required" /> --}}

                        {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating">
                                        <input class="form-control datetimepicker" id="floatingInputStartDate"
                                            type="date" placeholder="dd/mm/yyyy" placeholder="order date"
                                            name="order_date" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}'
                                            required />
                                        <div class="invalid-feedback">
                                            Please enter order date.
                                        </div>
                                        <label class="ps-6" for="floatingInputStartDate">order date</label><span
                                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating">
                                        <input class="form-control datetimepicker" id="floatingInputStartDate"
                                            type="date" placeholder="dd/mm/yyyy" placeholder="expected delivery date"
                                            name="expected_delivery_date"
                                            data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                        <div class="invalid-feedback">
                                            Please enter expected delivery date.
                                        </div>
                                        <label class="ps-6" for="floatingInputStartDate">expected
                                            delivery</label><span
                                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating">
                                    <select name="delivery_address_id" class="form-select" id="add_vendor_id">
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($addresses as $key => $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select Delivery Address.
                                    </div>
                                    <label for="floatingSelectTeam">Delivery Address </label>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                        {{-- <div class="row mb-3">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="requester_id" id="floatingInputGrid"
                                        type="text" placeholder="Requester Name" />
                                    <div class="invalid-feedback">
                                        Please enter Requester Name.
                                    </div>
                                    <label for="floatingInputGrid">Requester Name</label>
                                </div>
                            </div> --}}
                        {{-- <div class="col-sm-6 col-md-4  mb-3">
                                <div class="form-floating">
                                    <select name="project_id" class="form-select" id="add_project_id">
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($projects as $key => $item)
                                            <option value="{{ $item->id }}">
                            {{ $item->name }}
                            </option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select Project name.
                            </div>
                            <label for="floatingSelectTeam">Project name </label>
                            </div>
                            </div> --}}
                        {{-- <div class="col-sm-6 col-md-4">
                                <div class="form-floating">
                                    <textarea class="form-control form-control-sm description" name="h_description" type="text"
                                        placeholder="note to vendor"></textarea>
                                    <div class="invalid-feedback">
                                        Please enter description.
                                    </div>
                                    <label for="floatingInputGrid">Description</label>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="btn-container mb-2">
                            <a id="addNew" class="btn btn-sm">
                                <i class="fas fa-plus-circle text-success me-2"></i>Add new line
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="add_item">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width:2%"></th>
                                        <th scope="col" style="width:10%">Service Date</th>
                                        <th scope="col" style="width:15%">Product</th>
                                        <th scope="col" style="width:10%">Service Time</th>
                                        <th scope="col" style="width:15%">Venue</th>
                                        <th scope="col" style="width:25%">Location</th>
                                        <th scope="col" style="width:8%">Quantity</th>
                                        <th scope="col" style="width:8%">Unite Price</th>
                                        <th scope="col" class="po-subtotal" style="width:10%">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="row_1">
                                        <th id="delete_1" scope="row" class="delete_row">
                                            <i class="fas fa-minus-circle text-danger"></i>
                                        </th>
                                        <td>
                                            <input class="form-control datetimepicker flatpickr-input" type="date"
                                                name="service_date[]" id="service_date_1" placeholder="dd/mm/yyyy"
                                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required
                                                readonly="readonly">
                                        </td>
                                        <td>
                                            <div class="col-sm-6 col-md-12">
                                                {{-- <div class="input-group"> --}}
                                                <select name="product_id[]"
                                                    class="form-select form-select-sm item_selected" id="product_id_1"
                                                    required>
                                                    <option selected="selected" value="">Select...</option>
                                                    @foreach ($products as $key => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->product_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-phoenix-primary px-3"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="fas fa-plus-circle text-success"></i>
                                                    </button> --}}
                                                <div class="invalid-feedback">
                                                    Please select Item.
                                                </div>
                                                {{-- </div> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-6 col-md-12">
                                                <select name="service_time_id[]" class="form-select form-select-sm"
                                                    id="service_time_id_1" required>
                                                    <option selected="selected" value="">Select...</option>
                                                    @foreach ($serviceTimes as $key => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->service_time_range }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select product.
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-6 col-md-12">
                                                {{-- <div class="input-group"> --}}
                                                <select name="venue_id[]" class="form-select form-select-sm"
                                                    id="venue_id_1" required>
                                                    <option selected="selected" value="">Select...</option>
                                                    @foreach ($venues as $key => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-phoenix-primary px-3"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="fas fa-plus-circle text-success"></i>
                                                    </button> --}}
                                                <div class="invalid-feedback">
                                                    Please select venue.
                                                </div>
                                                {{-- </div> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-6 col-md-12">
                                                {{-- <div class="input-group"> --}}
                                                <select name="service_location_id[]"
                                                    class="form-select form-select-sm" id="service_location_id_1"
                                                    required>
                                                    <option selected="selected" value="">Select...</option>
                                                    @foreach ($serviceLocations as $key => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-phoenix-primary px-3"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="fas fa-plus-circle text-success"></i>
                                                    </button> --}}
                                                <div class="invalid-feedback">
                                                    Please select location.
                                                </div>
                                                {{-- </div> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm flex-nowrap"
                                                data-quantity="data-quantity">
                                                <a class="btn btn-sm px-2" data-type="minus" id="minus_1">-</a>
                                                <input
                                                    class="form-control text-center input-spin-none quantity bg-transparent border-0 px-0"
                                                    type="number" min="1" value="1" name="quantity[]"
                                                    id="quantity_1" required
                                                    aria-label="Amount (to the nearest dollar)">
                                                <a class="btn btn-sm px-2" data-type="plus" id="plus_1">+</a>
                                            </div>
                                            {{-- <div class="col-sm-6 col-md-12">
                                                <input class="form-control form-control-sm quantity text-right"
                                                    name="quantity[]" id="quantity_1" min=0 type="number"
                                                    placeholder="quantity" required />
                                                <div class="invalid-feedback">
                                                    Please enter quantity.
                                                </div>
                                            </div> --}}
                                        </td>
                                        {{-- <td>
                                            <div class="col-sm-6 col-md-12">
                                                <input class="form-control form-control-sm unit_price text-right"
                                                    name="unit_price[]" id="unit_price_1" type="number"
                                                    placeholder="Unit Price" disabled />
                                                <div class="invalid-feedback">
                                                    Please enter Unit Price.
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="col-sm-6 col-md-12 text-center">
                                                <div id="unit_price_1">0.00</div>
                                                <input type="hidden" name="unit_price[]" id="unit_price_h_1"/>
                                                {{-- <input class="form-control form-control-sm line_total text-right"
                                                    name="total" id="total_1" disabled type="number"
                                                    placeholder="Total" required />
                                                <div class="invalid-feedback">
                                                    Please enter Total.
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td class="pe-2">
                                            <div class="col-sm-6 col-md-12 po-subtotal">
                                                <div id="total_1">0.00</div>
                                                <input type="hidden" name="total[]" id="total_h_1"
                                                    class="form-control form-control-sm line_total text-right"/>
                                                {{-- <input class="form-control form-control-sm line_total text-right"
                                                    name="total" id="total_1" disabled type="number"
                                                    placeholder="Total" required />
                                                <div class="invalid-feedback">
                                                    Please enter Total.
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <table class="table text-right">
                                    <tbody>
                                        <tr>
                                            <td><span class="bold">Subtotal :</span>

                                                <input type="hidden" name="total_mn" value="">
                                            </td>
                                            <td class="po-subtotal" id="subtotal">
                                                <div id="subtotal">0.00</div>
                                                <input type="hidden" name="total_mn" value="0.00">
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <span class="bold">Shipping Fee</span>
                                                    </div>
                                                    <div class="col-md-3 po-subtotal" id="shipping_fee_input">
                                                        <input type="number" data-toggle="tooltip" value="0"
                                                            class="form-control form-control-sm pull-left text-right shipping_fee"
                                                            name="shipping_fee">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shiping_fee po-subtotal">
                                                <div id="shippingtotal">0.00</div>
                                            </td>
                                        </tr>
                                        <tr id="totalmoney">
                                            <td><span class="bold">Grand total :</span>

                                                <input type="hidden" name="grand_total" value="">
                                            </td>
                                            <td class="po-subtotal">
                                                <div id="grandtotal">0.00</div>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="btn-container">
                            <a id="addNew">
                                <i class="fas fa-plus-circle text-success"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>

                <div class="card mb-3 py-3">
                    {{-- <div class="mb-3">

                        <input class="form-control form-control-sm" id="customFileSm" type="file" />
                    </div> --}}
                    <div class="col-sm-6 col-md-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control form-control-sm description" name="note_to_vendor" type="text"
                                placeholder="note to vendor" style="height: 100px"></textarea>
                            <div class="invalid-feedback">
                                Please enter note to vendor.
                            </div>
                            <label for="floatingInputGrid">Note to Vendor</label>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 gy-3 mb-3">
                        <div class="row g-3 justify-content-end">
                            <a href="javascript:void(0)" class="col-auto">
                                <button type="button" class="btn btn-phoenix-danger px-5" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-dismiss="offcanvas">
                                    Cancel
                                </button>
                            </a>
                            <div class="col-auto">
                                <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Save
                                    PO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- FORM END -->
        </div>
    </div>
</div>

<!--========== Start of add multiple class with ajax ==============-->

<script type="text/javascript">
    // $(document).ready(function() {
    function initializeFlatpickr(line) {
        console.log("Initializing flatpickr for line: " + line);
        flatpickr(".datetimepicker_"+line, {
            dateFormat: "d/m/Y",
            disableMobile: true,
            monthSelectorType: 'static',
            allowInput: true,

        });
    }

    var SmartAuto = (function() {
        var addBtn, html, rowCount, tableBody;

        addBtn = $("#addNew")
        rowCount = $("#add_item tbody tr").length + 1;
        tableBody = $("#add_item tbody");

        function formHtml() {
            html = '    <tr id="row_' + rowCount + '">'
            html += '        <th id="delete_' + rowCount + '" scope="row" class="delete_row">'
            html += '             <i class="fas fa-minus-circle text-danger"></i>'
            html += '        </th>'

            html += '<td>'
            html += '<input class="form-control datetimepicker_' + rowCount + ' flatpickr-input"'
            html += 'type="date" name="service_date[]" id="service_date_' + rowCount + '"'
            html += 'placeholder="dd/mm/yyyy"'
            html += `data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required`
            html += 'readonly="readonly">'
            html += '</td>'



            html += '<td>'
            html += '    <div class="col-sm-6 col-md-12">'
            html += '        <select name="product_id[]"'
            html += '           class="form-select form-select-sm item_selected" id="product_id_' + rowCount +
                '"'
            html += '        required>'
            html += '        <option selected="selected" value="">Select...</option>'
            html += '        @foreach ($products as $key => $item)'
            html += '            <option value="{{ $item->id }}">'
            html += '                {{ $item->product_name }}'
            html += '            </option>'
            html += '        @endforeach'
            html += '    </select>'
            html += '    <div class="invalid-feedback">'
            html += '        Please select product.'
            html += '    </div>'
            html += '    </div>'
            html += '</td>'
            html += '<td>'
            html += '    <div class="col-sm-6 col-md-12">'
            html += '        <select name="service_time_id[]"'
            html += '            class="form-select form-select-sm"'
            html += '            id="service_time_id_' + rowCount + '" required>'
            html += '            <option selected="selected" value="">Select...</option>'
            html += '            @foreach ($serviceTimes as $key => $item)'
            html += '                <option value="{{ $item->id }}">'
            html += '                    {{ $item->service_time_range }}'
            html += '                </option>'
            html += '            @endforeach'
            html += '        </select>'
            html += '        <div class="invalid-feedback">'
            html += '            Please select service time.'
            html += '        </div>'
            html += '    </div>'
            html += '</td>'
            html += '<td>'
            html += '    <div class="col-sm-6 col-md-12">'
            html += '        <select name="venue_id[]"'
            html += '            class="form-select form-select-sm " id="venue_id_' + rowCount +
                '"'
            html += '            required>'
            html += '            <option selected="selected" value="">Select...</option>'
            html += '            @foreach ($venues as $key => $item)'
            html += '                <option value="{{ $item->id }}">'
            html += '                    {{ $item->title }}'
            html += '                </option>'
            html += '            @endforeach'
            html += '        </select>'
            html += '        <div class="invalid-feedback">'
            html += '            Please select venue.'
            html += '        </div>'
            html += '    </div>'
            html += '</td>'
            html += '<td>'
            html += '    <div class="col-sm-6 col-md-12">'
            html += '        <select name="service_location_id[]"'
            html += '            class="form-select form-select-sm "'
            html += '            id="service_location_id_' + rowCount + '" required>'
            html += '            <option selected="selected" value="">Select...</option>'
            html += '            @foreach ($serviceLocations as $key => $item)'
            html += '                <option value="{{ $item->id }}">'
            html += '                    {{ $item->title }}'
            html += '                </option>'
            html += '            @endforeach'
            html += '        </select>'
            html += '        <div class="invalid-feedback">'
            html += '            Please select location.'
            html += '        </div>'
            html += '    </div>'
            html += '</td>'

            html += '<td>'
            html += '   <div class="input-group input-group-sm flex-nowrap"'
            html += '       data-quantity="data-quantity">'
            html += '       <a class="btn btn-sm px-2" data-type="minus" id="minus_' + rowCount + '">-</a>'
            html += '       <input'
            html +=
                '           class="form-control text-center input-spin-none quantity bg-transparent border-0 px-0"'
            html += '           type="number" min="1" value="1" name="quantity[]" id="quantity_' + rowCount +
                '" required'
            html += '           aria-label="Amount (to the nearest dollar)">'
            html += '       <a class="btn btn-sm px-2" data-type="plus" id="plus_' + rowCount + '">+</a>'
            html += '   </div>'
            html += '</td>'

            // html += '<td>'
            // html += '   <div class="col-sm-6 col-md-12">'
            // html += '       <input class="form-control form-control-sm quantity text-right" name="quantity[]"';
            // html += '           id="quantity_' + rowCount + '" type="number"'
            // html += '               placeholder="quantity" min=0 required />'
            // html += '       <div class="invalid-feedback">'
            // html += '                   Please enter quantity.'
            // html += '       </div>'
            // html += '   </div>'
            // html += '</td>'


            // html += '<td>'
            // html += '    <div class="col-sm-6 col-md-12">'
            // html += '       <input class="form-control form-control-sm unit_price '
            // html += '           text-right" name="unit_price[]" '
            // html += '                   id="unit_price_' + rowCount + '"'
            // html += '                 type="number"'
            // html += '                placeholder="Unit Price" disabled />'
            // html += '        <div class="invalid-feedback">'
            // html += '                Please enter Unit Price.'
            // html += '        </div>'
            // html += '    </div>'
            // html += '</td>'

            html += '<td class="pe-2">'
            html += '    <div class="col-sm-6 col-md-12 text-center">'
            html += '        <div id="unit_price_' + rowCount + '">0.00</div>'
            html += '        <input type="hidden" name="unit_price[]" id="unit_price_h_' + rowCount + '"'
            html += '            class="text-center"'
            html += '             />'
            html += '    </div>'
            html += '</td>'

            html += '<td class="pe-2">'
            html += '    <div class="col-sm-6 col-md-12 po-subtotal">'
            html += '        <div id="total_' + rowCount + '">0.00</div>'
            html += '        <input type="hidden" name="total[]" id="total_h_' + rowCount + '"'
            html += '            class="line_total text-right"'
            html += '             />'
            html += '    </div>'
            html += '</td>'

            rowCount++;
            return html;
        }

        function getId(element) {
            var id, idArr;
            id = element.attr('id');
            idArr = id.split("_");
            return idArr[idArr.length - 1]
        }

        function addNewRow() {
            tableBody.append(formHtml());
            initializeFlatpickr(rowCount-1);
        }

        function deleteRow() {
            var currentEle, rowNo;
            currentEle = $(this);
            rowNo = getId(currentEle);
            $("#row_" + rowNo).remove();
            $("#subtotal").html(sumTotalLines);
            $("#grandtotal").html(sumTotalLines);

        }

        function autoFillItem() {
            // console.log('autoFillItem')
            var currentEle, rowNo, itemId, shippingFee;
            currentEle = $(this);
            itemId = currentEle.val();
            rowNo = getId(currentEle);
            // console.log(currentEle)
            // console.log(currentEle.val())
            // console.log(rowNo)
            $.ajax({
                url: "/cms/admin/item/get/" + itemId,
                method: "GET",
                async: false,
                success: function(response) {
                    // console.log(response)
                    $("#quantity_" + rowNo).val('1');
                    // console.log(response.itemData.item_price)
                    // $("#description_" + rowNo).val(response.itemData.description);
                    $("#unit_price_" + rowNo).html(response.itemData.product_price);
                    $("#unit_price_h_" + rowNo).val(response.itemData.product_price);
                    $("#total_h_" + rowNo).val(response.itemData.product_price * 1);
                    $("#total_" + rowNo).html(response.itemData.product_price * 1);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // console.log(xhr.status);
                    // console.log(thrownError);
                    $("#cover-spin").hide();
                },
            });
            // $("#quantity_"+rowNo).val('1');
            shippingFee = $(".shipping_fee").val();
            // console.log('shippingFee', shippingFee)
            grandTotal = (parseFloat(sumTotalLines()) + parseFloat(shippingFee));
            // console.log('grandTotal', grandTotal);

            $("#subtotal").html(sumTotalLines);
            $("#grandtotal").html(grandTotal);

        }

        function sumTotalLines() {
            // console.log('inside sumTtoalLines')
            var sum = 0;
            $(".line_total").each(function() {

                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseFloat(this.value);
                }
            });

            return sum.toFixed(2);
        }


        function shippingFeeChange() {
            var currentEle, shippingFeeValue;
            // console.log('inside shippingFeeChange');
            currentEle = $(this);
            // console.log(currentEle)
            shippingFeeValue = currentEle.val();
            $("#shippingtotal").html(shippingFeeValue);

            // console.log('shippingFeeValue', shippingFeeValue)
            grandTotal = (parseFloat(sumTotalLines()) + parseFloat(shippingFeeValue));
            // console.log('grandTotal', grandTotal);
            $("#grandtotal").html(grandTotal.toFixed(2));
        }

        function quantityPriceTotals() {
            console.log('inside quantityPriceTotals')
            var currentEle, rowNo, itemId, sum = 0;

            const $row = $(this).closest('tr');
            const type = $(this).data('type');
            let qty = parseInt($row.attr('data-quantity')) || 0;

            if (type === 'plus') {
                qty++;
            } else if (type === 'minus' && qty > 0) {
                qty--;
            }

            $row.attr('data-quantity', qty);
            $row.find('.quantity').val(qty);


            currentEle = $(this);
            // console.log(currentEle)
            rowNo = getId(currentEle);
            // console.log(rowNo)
            qunatityValue = $("#quantity_" + rowNo).val()
            unitPriceValue = $("#unit_price_h_" + rowNo).val();
            shippingFeeValue = $(".shipping_fee").val();

            // console.log('qunatityValue', qunatityValue)
            // console.log('unitPriceValue', unitPriceValue)
            lineTotal = qunatityValue * unitPriceValue;

            $("#total_h_" + rowNo).val(lineTotal);
            $("#total_" + rowNo).html(lineTotal.toFixed(2));

            // $("#subtotal").html(qunatityValue * unitPriceValue);

            subTotal = sumTotalLines();
            // $("#subtotal").html(sumTotalLines());
            $("#subtotal").html(subTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            grandTotal = (parseFloat(sumTotalLines()) + parseFloat(shippingFeeValue));
            // console.log('grandTotal', grandTotal);
            // $("#grandtotal").html(grandTotal.toFixed(2));
            $("#grandtotal").html(grandTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

        }

        function registerEvents() {
            // console.log('inside registerEvents')
            addBtn.on("click", addNewRow);

            $(document).on("click", ".delete_row", deleteRow);
            $(document).on("change", ".item_selected", autoFillItem);
            $(document).on("keyup change", ".quantity", quantityPriceTotals);
            $(document).on("click", '[data-type="minus"]', quantityPriceTotals);
            $(document).on("click", '[data-type="plus"]', quantityPriceTotals);
            $(document).on("keyup change", ".unit_price", quantityPriceTotals);
            $(document).on("change keyup", ".shipping_fee", shippingFeeChange);
        }

        function init() {
            registerEvents();
        }

        return {
            init: init
        }
    })();

    $(document).ready(function() {
        SmartAuto.init();
    });
</script>
