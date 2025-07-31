<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" name="table" value="vendor_table" />
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add Vendor</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="name"
                                        id="floatingInputGrid" type="text" placeholder="Vendor Name (Company)" required />
                                    <div class="invalid-feedback">
                                        Please enter Vendor Name (Company).
                                    </div>
                                    <label for="floatingInputGrid">Vendor Name (Company)</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="contact_name"
                                        id="floatingInputGrid" type="text" placeholder="Contact Name" required />
                                    <div class="invalid-feedback">
                                        Please enter Contact Name.
                                    </div>
                                    <label for="floatingInputGrid">Contact Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="email"
                                        id="floatingInputGrid" type="text" placeholder="Email Address" required />
                                    <div class="invalid-feedback">
                                        Please enter Email Address.
                                    </div>
                                    <label for="floatingInputGrid">Email Address</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="phone_number"
                                        id="floatingInputGrid" type="text" placeholder="Phone Number" />
                                    <div class="invalid-feedback">
                                        Please enter Phone Number.
                                    </div>
                                    <label for="floatingInputGrid">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="website"
                                        id="floatingInputGrid" type="text" placeholder="Website" />
                                    <div class="invalid-feedback">
                                        Please enter Website.
                                    </div>
                                    <label for="floatingInputGrid">Website</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 gy-3 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control  @error('shipping_address') is-invalid @enderror" name="billing_address" id="floatingProjectOverview" placeholder="eg:"
                                    style="height: 100px"></textarea>
                                <div class="invalid-feedback">
                                    Please enter Billing Address.
                                </div>
                                <label for="floatingProjectOverview">Billing Address</label>
                            </div>
                        </div>
                        <div class="col-12 gy-3 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control  @error('shipping_address') is-invalid @enderror" name="shipping_address" id="floatingProjectOverview" placeholder="eg:"
                                    style="height: 100px"></textarea>
                                <div class="invalid-feedback">
                                    Please enter Shipping Address.
                                </div>
                                <label for="floatingProjectOverview">Shipping Address</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="opening_balance"
                                        id="floatingInputGrid" type="text" placeholder="Opening Balance" />
                                    <div class="invalid-feedback">
                                        Please enter Opening Balance.
                                    </div>
                                    <label for="floatingInputGrid">Opening Balance</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="currency"
                                        id="floatingInputGrid" type="text" placeholder="Currency" />
                                    <div class="invalid-feedback">
                                        Please enter Currency.
                                    </div>
                                    <label for="floatingInputGrid">Currency</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 gy-3">
                            <div class="row g-3 justify-content-end">
                                <a href="javascript:void(0)" class="col-auto">
                                    <button type="button" class="btn btn-phoenix-danger px-5" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </a>
                                <div class="col-auto">
                                    <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Create Vendor</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>