<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="purchase_table" />
<input type="hidden" id="edit_vendor_id" name="id" value="{{$purchase->id}}">
<div>


<input type="hidden" name="table" value="purchase_table" />

<div class="card">
    <div class="card-header d-flex align-items-center border-bottom">
        <div class="ms-3">
            <h5 class="mb-0 fs-sm">Create Purchase</h5>
        </div>
    </div>
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-sm-6 col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">PO</span>
                    <div class="form-floating">
                        <input  class="form-control" 
                                name="po_number" 
                                type="text"
                                value="{{$purchase->po_number}}"
                                placeholder="Purchase Order Number (Auto Generated)" 
                                disabled />
                        <div class="invalid-feedback">
                            Please enter Purchase Order Number.
                        </div>
                        <label for="floatingInputGrid">Order Number</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="form-floating">
                    <select name="vendor_id" class="form-select" id="add_vendor_id">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($vendors as $key => $item)
                            <option value="{{ $item->id }}" {{ $item->id == $purchase->vendor_id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select Vendor name.
                    </div>
                    <label for="floatingSelectTeam">Vendor name </label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="form-floating">
                    <select name="currency_id" class="form-select" id="add_currencyid">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($currency as $key => $item)
                            <option value="{{ $item->id }}" {{ $item->id == $purchase->currency_id ? 'selected' : '' }}>
                                {{ $item->code }} ({{ $item->symbol }})
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select Currency.
                    </div>
                    <label for="floatingSelectTeam">Currency</label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="flatpickr-input-container">
                    <div class="form-floating">
                        <input  class="form-control datetimepicker" 
                                id="floatingInputStartDate"
                                type="date" 
                                placeholder="dd/mm/yyyy" 
                                placeholder="order date"
                                name="order_date"
                                value="{{$purchase->order_date}}"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}'
                            required />
                        <div class="invalid-feedback">
                            Please enter order date.
                        </div>
                        <label class="ps-6" for="floatingInputStartDate">order date</label><span
                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="flatpickr-input-container">
                    <div class="form-floating">
                        <input  class="form-control datetimepicker" id="floatingInputStartDate"
                                type="date" 
                                placeholder="dd/mm/yyyy" 
                                placeholder="expected delivery date"
                                name="expected_delivery_date"
                                value="{{$purchase->expected_delivery_date}}"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                        <div class="invalid-feedback">
                            Please enter expected delivery date.
                        </div>
                        <label class="ps-6" for="floatingInputStartDate">expected
                            delivery</label><span
                            class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="form-floating">
                    <select name="delivery_address_id" class="form-select" id="add_vendor_id">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($addresses as $key => $item)
                            <option value="{{ $item->id }} {{ $item->id == $purchase->delivery_address_id ? 'selected' : '' }}">
                                {{ $item->location_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select Delivery Address.
                    </div>
                    <label for="floatingSelectTeam">Delivery Address </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6 col-md-4">
                <div class="form-floating">
                    <input  class="form-control" 
                            name="requester_id" 
                            id="floatingInputGrid"
                            type="text" 
                            value="{{$purchase->requester_id}}"
                            placeholder="Requester Name" />
                    <div class="invalid-feedback">
                        Please enter Requester Name.
                    </div>
                    <label for="floatingInputGrid">Requester Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4  mb-3">
                <div class="form-floating">
                    <select name="project_id" class="form-select" id="add_project_id">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($projects as $key => $item)
                            <option value="{{ $item->id }}" {{ $item->id == $purchase->project_id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select Project name.
                    </div>
                    <label for="floatingSelectTeam">Project name </label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm description" name="h_description" type="text"
                        placeholder="note to vendor">{{ $purchase->description }}</textarea>
                    <div class="invalid-feedback">
                        Please enter description.
                    </div>
                    <label for="floatingInputGrid">Description</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
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
                        <th scope="col" style="width:25%">Item</th>
                        <th scope="col" style="width:25%">Description</th>
                        <th scope="col" style="width:10%">Quantity</th>
                        <th scope="col" style="width:10%">Unite Price</th>
                        <th scope="col" class="po-subtotal" style="width:5%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $lines_total = $lines->sum('quantity') * $lines->sum('unit_price');
                    @endphp
                    @foreach ($lines as $line_key => $line)
                    <tr id="row_1">
                        <th id="delete_1" scope="row" class="delete_row">

                        </th>
                        <td>
                            <div class="col-sm-6 col-md-12">
                                <div class="input-group">
                                    <select name="item_id[]"
                                        class="form-select form-select-sm item_selected"
                                        id="item_id_1" required>
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($items as $key => $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $line->item_id ? 'selected' : '' }}>
                                                {{ $item->item_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-phoenix-primary px-3"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please select Item.
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-6 col-md-12">
                                {{-- <div class="form-floating"> --}}
                                <input class="form-control form-control-sm description"
                                    name="line_description[]" id="description_1" type="text"
                                    placeholder="description" value="{{ $line->line_description }}" required />
                                <div class="invalid-feedback">
                                    Please enter description.
                                </div>
                                {{-- <label for="floatingInputGrid">description</label> --}}
                                {{-- </div> --}}
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-6 col-md-12">
                                {{-- <div class="form-floating"> --}}
                                <input class="form-control form-control-sm quantity text-right"
                                    name="quantity[]" id="quantity_1" type="number"
                                    placeholder="quantity" value="{{ $line->quantity }}" required />
                                <div class="invalid-feedback">
                                    Please enter quantity.
                                </div>
                                {{-- <label for="floatingInputGrid">quantity</label> --}}
                                {{-- </div> --}}
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-6 col-md-12">
                                {{-- <div class="form-floating"> --}}
                                <input class="form-control form-control-sm unit_price text-right"
                                    name="unit_price[]" id="unit_price_1" type="number"
                                    placeholder="Unit Price" value="{{ $line->unit_price }}" required />
                                <div class="invalid-feedback">
                                    Please enter Unit Price.
                                </div>
                                {{-- <label for="floatingInputGrid">Unit Price</label> --}}
                                {{-- </div> --}}
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-6 col-md-12">
                                {{-- <div class="form-floating"> --}}
                                <input class="form-control form-control-sm line_total text-right"
                                    name="total" id="total_1" disabled type="number"
                                    placeholder="Total" value="{{ $line->quantity*$line->unit_price}}" required />
                                <div class="invalid-feedback">
                                    Please enter Total.
                                </div>
                                {{-- <label for="floatingInputGrid">Total</label> --}}
                                {{-- </div> --}}
                            </div>
                        </td>
                    </tr>
                    @endforeach
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
                                <div id="subtotal">{{ $lines_total }}</div>
                                <input type="hidden" name="total_mn" value="0.00">
                            </td>
                        </tr>
                        <tr>
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
                                <div id="shippingtotal">{{ $purchase->shipping_cost }}</div>
                            </td>
                        </tr>

                        <tr id="totalmoney">
                            <td><span class="bold">Grand total :</span>

                                <input type="hidden" name="grand_total" value="">
                            </td>
                            <td class="po-subtotal">
                                <div id="grandtotal">{{ $lines_total+$purchase->shipping_cost }}</div>
                            </td>
                        </tr>
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

<div class="card mb-3 py-3 px-3">
    <div class="mb-3">

        <input class="form-control form-control-sm" id="customFileSm" type="file" />
    </div>
    <div class="col-sm-6 col-md-12 mb-3">
        <div class="form-floating">
            <textarea class="form-control form-control-sm description" name="note_to_vendor" type="text"
                placeholder="note to vendor" style="height: 100px">{{$purchase->note_to_vendor}}</textarea>
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

</div>