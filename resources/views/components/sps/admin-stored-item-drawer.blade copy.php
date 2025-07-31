<div class="offcanvas-body">
    <div class="row">
        <div class="col-sm-12">
            <form class="row g-3 needs-validation form-submit-event" id="{{ $formId }}" novalidate=""
                action="{{ $formAction }}" method="POST">
                @csrf
                <input type="hidden" id="add_table" name="table" value="storage_table" />
                <input type="hidden" name="venue" value="LUS">
                <div class="card">
                    <div class="card-header d-flex align-items-center border-bottom">
                        <div class="ms-3">
                            <h5 class="mb-0 fs-sm">Add Item Description</h5>
                        </div>
                    </div>
                    <div class="card-body">

                            <x-formy.form_input class="col-sm-6 col-md-12 mb-3" floating="1" inputValue=""
                                name="first_name" elementId="add_first_name" inputType="text" inputAttributes=""
                                label="First Name" required="required" disabled="0" />

                            <x-formy.form_input class="col-sm-6 col-md-12 mb-3" floating="1" inputValue=""
                                name="last_name" elementId="add_last_name" inputType="text" inputAttributes=""
                                label="Last Name" required="" disabled="0" />

                            <x-formy.form_input class="col-sm-6 col-md-12 mb-3" floating="1" inputValue=""
                                name="email_address" elementId="add_email_address" inputType="email" inputAttributes=""
                                label="Email Address" required="required" disabled="0" />
                            <x-formy.form_input class="col-sm-6 col-md-12 mb-3" floating="1" inputValue=""
                                name="phone" elementId="add_phone" inputType="phone" inputAttributes=""
                                label="Phone Number" required="required" disabled="0" />

                        <div class="col-12 gy-3">
                            <div class="row g-3 ">
                                <a href="javascript:void(0)" class="col-auto">
                                    <button type="button" class="btn btn-phoenix-danger px-5"
                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </a>
                                <div class="col-auto">
                                    <button class="btn btn-primary px-5 px-sm-5" id="submit_btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
