<div class="modal fade" id="add_procurement_subcategory_modal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Add Item Sub Category</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                        class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" id="add_procurement_subcategory_form" novalidate="" action="{{ route('procurement.admin.setting.subcategory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" name="table" id="edit_procurement_subcategory_table" value="procurement_subcategory_table">
                                <div class="mb-3">
                                    <label class="text-1000 fw-bold mb-2">Name</label>
                                    <input class="form-control" type="text" placeholder="Enter name" name="name" id="editName" required />
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="inputAddress">Category</label>
                                    <select name="category_id" class="form-select" id="floatingSelectRating"
                                        required>
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($categories as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="text-1000 fw-bold mb-2">Status</label>
                                    <select class="form-select" name="active_flag" id="editActiveFlag" required>
                                        <option value="">Select</option>
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_procurement_subcategory_modal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Edit Item Sub Category</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                        class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" id="edit_procurement_subcategory_form" novalidate="" action="{{ route('procurement.admin.setting.subcategory.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" id="edit_procurement_subcategory_id" name="id" value="">
                                <input type="hidden" name="table" id="edit_procurement_subcategory_table" value="procurement_subcategory_table">
                                <div class="mb-3">
                                    <label class="text-1000 fw-bold mb-2">Name</label>
                                    <input class="form-control" type="text" placeholder="Enter name" name="name" id="edit_procurement_subcategory_name" required />
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="inputAddress">Category</label>
                                    <select name="category_id" class="form-select" id="floatingSelectRating"
                                        required>
                                        <option selected="selected" value="">Select...</option>
                                        @foreach ($categories as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="text-1000 fw-bold mb-2">Status</label>
                                    <select class="form-select" name="active_flag" id="edit_procurement_subcategory_active_flag" required>
                                        <option value="">Select</option>
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>