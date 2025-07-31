<script src="{{ asset('fnx/assets/js/phoenix.js') }}"></script>

<script>
    // $('.badge-cell').on('click', function() {
    //     const cell = $(this);
    //     cell.find('.badge-display').addClass('d-none');
    //     cell.find('.badge-select').removeClass('d-none').focus();
    // });

    $('.editable').on('focus', function() {
        $(this).data('initialText', $(this).text().trim());
    });

    $('.editable').on('blur', function() {
        let td = $(this);
        let value = td.text().trim();
        let id = td.data('id');
        let field = td.data('field');
        let originalValue = td.data('initialText');
        if (value === originalValue) {
            return; // No change, do nothing
        }
        // console.log('Updating field:', field, 'with value:', value, 'for item ID:', id);
        td.css('background-color', '#fff3cd'); // yellow loading background
        td.append(
            '<span class="spinner-border spinner-border-sm float-end" role="status" aria-hidden="true"></span>'
        );
        // td.prop('contenteditable', false); // Disable editing while saving
        // td.off('blur'); // Remove the blur event handler to prevent multiple submissions
        $.ajax({
            url: '/sps/admin/item/update-field/' + id,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                value: value
            },
            success: function(response) {
                td.css('background-color', '#d4edda'); // light green
                setTimeout(() => td.css('background-color', ''), 5000);
                toastr.success(response["message"]);
            },
            error: function() {
                td.css('background-color', '#f8d7da'); // red error
                td.text(originalValue); // revert on error
                toastr.error(response["message"]);
            },
            complete: function() {
                td.find('.spinner-border').remove(); // remove spinner
                setTimeout(() => td.css('background-color', ''), 1000);
            }
        });
    });
</script>

<div class="row g-3 mb-6">
    <div class="col-12 col-lg-4">
        <div class="card bg-primary-subtle h-100">
            <div class="card-body">
                <div class="border-bottom border-dashed">
                    <h4 class="mb-3">Person Information
                        <button class="btn btn-link p-0" type="button"> <span
                                class="fas fa-edit fs-9 ms-3 text-body-quaternary"></span></button>
                    </h4>
                </div>
                @foreach ($op as $spectator)
                    <div class="pt-4 mb-7 mb-lg-4 mb-xl-7">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Status</h5>
                            </div>
                            <div class="col-auto mb-5 badge-cell">
                                {{-- <span
                                    class="badge badge-phoenix fs--2 align-middle white-space-wrap ms-1 badge-phoenix-{{ $spectator->status?->color }}"
                                    style="cursor: pointer;" id="editStatus" data-id="{{ $spectator->id }}"
                                    data-table="storage_table"><span class="badge-label">
                                        {{ $spectator->status?->title }} </span></span> --}}

                                <span
                                    class="badge-display badge-phoenix fs--2 align-middle white-space-wrap ms-1 badge-phoenix-{{ $spectator->status?->color }}"
                                    style="cursor: pointer;" id="editStatus" data-id="{{ $spectator->id }}"
                                    data-table="storage_table"><span class="badge-label">
                                        {{ ucfirst($spectator->status?->title) }}
                                    </span>
                                </span>

                                {{-- <select class="form-select form-select-sm w-50 badge-select d-none" style="width: 160px;">
                                    <option value="active" data-class="bg-success">Active</option>
                                    <option value="inactive" data-class="bg-secondary">Inactive</option>
                                    <option value="pending" data-class="bg-warning text-dark">Pending</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Event</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">{{ $spectator->event->name }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Venue</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">{{ $spectator->venue->title }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Item Locaiton</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">{{ $spectator->location->title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-top border-dashed pt-4">
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">First Name</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">{{ $spectator->first_name }}</p>
                            </div>
                        </div>
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Last Name</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">{{ $spectator->last_name }}</p>
                            </div>
                        </div>
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5 class="text-body-highlight mb-0">Email</h5>
                            </div>
                            <div class="col-auto"><a class="lh-1" href="#">{{ $spectator->email_address }}</a>
                            </div>
                        </div>
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                <h5 class="text-body-highlight mb-0">Phone</h5>
                            </div>
                            <div class="col-auto"><a href="#">{{ $spectator->phone }}</a></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card bg-secondary-subtle h-100">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-orders" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="border-top border-bottom border-translucent" id="profileOrdersTable"
                            data-list='{"valueNames":["order","status","delivery","date","total"],"page":6,"pagination":true}'>
                            <div class="table-responsive scrollbar">
                                <table class="table fs-9 mb-0">
                                    <thead>
                                        <tr>
                                            <th class=" white-space-nowrap align-middle pe-3 ps-0" scope="col"
                                                data-sort="order" style="width:10%"></th>
                                            {{-- <th class=" align-middle pe-3" scope="col" data-sort="status"
                                                style="width:15%; min-width:180px">STATUS</th> --}}
                                            <th class=" white-space-nowrap align-middle pe-3 ps-0" scope="col"
                                                data-sort="order" style="width:10%">LOC<i
                                                    class="fas fa-pencil-alt edit-hover-icon text-muted ms-2"></i></th>
                                            <th class=" white-space-nowrap align-middle pe-3 ps-0" scope="col"
                                                data-sort="order" style="width:10%">TAG<i
                                                    class="fas fa-pencil-alt edit-hover-icon text-muted ms-2"></i></th>
                                            <th class=" align-middle text-start" scope="col" data-sort="delivery"
                                                style="width:20%; min-width:160px">ITEM DESCRIPTION</th>
                                            <th class=" align-middle pe-0 text-end" scope="col" data-sort="date"
                                                style="width:15%; min-width:160px">TIME</th>
                                            <th class=" align-middle pe-0 text-end" scope="col" data-sort="date"
                                                style="width:15%; min-width:160px">DATE</th>
                                            <th class="align-middle pe-0 text-end" scope="col" style="width:15%;">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="profile-order-table-body">
                                        @foreach ($spectator->items as $item)
                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                <td class="align-middle product white-space-nowrap">
                                                    <div class="avatar avatar-l">
                                                        <a class="d-block rounded-2 border border-translucent"
                                                            href="{{ asset('storage/items/img/' . $item->item_image) }}"
                                                            class="glightbox" data-gallery="gallery1">
                                                            <img src="{{ asset('storage/items/img/' . $item->item_image) }}"
                                                                class="rounded-circle pull-up" alt=""
                                                                width="53" />
                                                        </a>
                                                    </div>
                                                </td>
                                                {{-- <td
                                                    class="status align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                                            class="badge-label">Stored</span><span class="ms-1"
                                                            data-feather="check"
                                                            style="height:12.8px;width:12.8px;"></span></span>
                                                </td> --}}
                                                <td contenteditable="true" data-id="{{ $item->id }}"
                                                    data-field="storage_location"
                                                    class="delivery align-middle white-space-nowrap text-body py-2 editable">
                                                    {{ $item->storage_location }}
                                                    <i
                                                        class="fas fa-pencil-alt edit-hover-icon text-muted d-none ms-2"></i>
                                                </td>
                                                <td contenteditable="true" data-id="{{ $item->id }}"
                                                    data-field="storage_tag_number"
                                                    class="delivery align-middle white-space-nowrap text-body py-2 editable">
                                                    {{ $item->storage_tag_number }}
                                                    <i
                                                        class="fas fa-pencil-alt edit-hover-icon text-muted d-none ms-2"></i>
                                                </td>
                                                <td class="delivery align-middle white-space-nowrap text-body py-2">
                                                    {{ $item->item_description }}
                                                </td>
                                                <td class="total align-middle text-body-tertiary text-end py-2">
                                                    {{ $item->created_at->format('h:i A') }}
                                                </td>
                                                <td class="total align-middle text-body-tertiary text-end py-2">
                                                    {{ $item->created_at->format('d M Y') }}
                                                </td>
                                                <td class="align-middle text-end white-space-nowrap pe-0 action py-2">
                                                    <div class="btn-reveal-trigger position-static">
                                                        <button
                                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal"
                                                            type="button" data-bs-toggle="dropdown"
                                                            data-boundary="window" aria-haspopup="true"
                                                            aria-expanded="false" data-bs-reference="parent"><span
                                                                class="fas fa-ellipsis-h fs-10"></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                                class="dropdown-item" href="#!">View</a><a
                                                                class="dropdown-item" href="#!">Export</a>
                                                            <div class="dropdown-divider"></div><a
                                                                class="dropdown-item text-danger"
                                                                href="#!">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
