<div class="offcanvas offcanvas-end offcanvas-global-modal in" id="offcanvas-edit-purchase-modal" tabindex="-1"
    aria-labelledby="offcanvasWithBackdropLabel">
    <a class="close-task-detail in" id="close-task-detail" style="display: block;" data-bs-dismiss="offcanvas">
        <span><svg class="svg-inline--fa fa-times fa-w-11" aria-hidden="true" focusable="false" data-prefix="fa"
                data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"
                data-fa-i2svg="">
                <path fill="currentColor"
                    d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                </path>
            </svg><!-- <i class="fa fa-times"></i> Font Awesome fontawesome.com --></span>
    </a>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="row g-3 needs-validation form-submit-event" id="edit_purchase_form" novalidate=""
                    action="{{ route('cms.orders.update') }}" method="POST">
                    @csrf
                    <div id="global-edit-purchase-content"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-global-modal in95" id="offcanvas-add-order-modal" tabindex="-1"
    aria-labelledby="offcanvasWithBackdropLabel">
    <a class="close-task-detail in" id="close-task-detail" style="display: block;" data-bs-dismiss="offcanvas">
        <span><svg class="svg-inline--fa fa-times fa-w-11" aria-hidden="true" focusable="false" data-prefix="fa"
                data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"
                data-fa-i2svg="">
                <path fill="currentColor"
                    d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                </path>
            </svg><!-- <i class="fa fa-times"></i> Font Awesome fontawesome.com --></span>
    </a>
    <x-cms.orders.admin-order-drawer id="" formAction="{{ route('cms.orders.admin.store') }}" currency="anything"
        formId="add_purchase_form" :customers="$customers" :products="$products" :currency="$currency" :addresses="$addresses"
        :serviceTimes="$service_times" :venues="$venues" :serviceLocations="$service_locations">

    </x-cms.orders.admin-order-drawer>

</div>

<div class="modal fade" id="orderStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Status</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" novalidate="" action="{{route('cms.agency.orders.status.update')}}" method="POST" id="order_status">
                <!-- <form class="needs-validation" novalidate="" action="{{url('/tracki/task/status/update')}}" method="POST" id="task_status"> -->
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" id="editOrderId" name="id">
                                <input type="hidden" id="orderStatusTable" name="table" value="order_table">
                                <div class="mb-4">
                                    <label class="text-1000 fw-bold mb-2">Status</label>
                                    <select name="status_id" class="form-select" id="editOrderStatusSelection" required>
                                        <option selected="selected" value="">Select</option>
                                        @foreach ($order_statuses as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <input class="form-control" type="number" max="100" min="0" name="prorgress_number" id="editPoregessNumber" required /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="submit_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="order_lines_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addDealModal" aria-hidden="true">
    <div class="modal-dialog modal-xl custom-modal-width modal-dialog-scrollable modal-dialog-top">
        <div class="modal-content bg-body-highlight">
            <div class="modal-header justify-content-between border-0 px-6 bg-modal-header">
                <h4 class="mb-0">Order Details</h4>
                <button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span
                        class="fas fa-times text-danger"></span></button>
            </div>
            <div class="modal-content px-6">
                <div id="order_lines_modal_body"></div>
            </div>
            <div class="modal-footer border-0pt-4 px-6">
                <button class="btn btn-link text-danger px-3 my-0" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
                {{-- <button class="btn btn-primary my-0">Create Deal</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-filter-modal in" id="orderFilterOffcanvas" tabindex="-1"
    aria-labelledby="offcanvasWithBackdropLabel">
    <x-cms.admin.admin-order-filter-drawer id="" formAction="" formId="filter_order_form"
        :events="$events" :venues="$venues" />
</div>

<div class="modal fade" id="attachment_list_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-0" id="add_employee_modal_label"><?= get_label('attachment_list', 'Attachments') ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div class="px-5">
            {{-- <form class="row g-3  px-3 needs-validation form-submit-event" id="edit_employee_bank_form" novalidate="" action="" method="POST">
                @csrf --}}
                <div id="AttachmentView"></div>
            {{-- </form> --}}
        </div>
    </div>
</div>
<!-- </div> -->
