<div class="modal fade" id="create_service_period_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">Add service_period
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form novalidate="" class="modal-content form-submit-event needs-validation" id="form_submit_event"
                action="{{ route('cms.setting.service.period.store') }}" method="POST">
                @csrf
                <input type="hidden" name="table" value="service_period_table">
                <div class="modal-body">
                    <div class="row">
                        <div class="text-center mb-3">
                            <div class="mb-3 text-start">
                                <input type="file" name="file_name" class="dropify" data-height="200"
                                    data-default-file="{{ !empty($user->photo) ? url('storage/upload/profile_images/' . $user->photo) : url('storage/upload/default.png') }}" />
                            </div>
                        </div>
                        <x-formy.form_select class="col-sm-6 col-md-12 mb-3" floating="1" selectedValue=""
                            name="event_id" elementId="add_event_id" label="Event" required="required"
                            :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style=""
                            addDynamicButton="0" />
                        <!-- Venues Dropdown (dynamically loaded) -->
                        <div class="col-sm-6 col-md-12 mb-3">
                            <label for="add_venue_id" class="form-label">Venue (Dependent)</label>
                            <select id="add_venue_id" class="form-select select2">
                                <option value="">Select a Venue</option>
                            </select>
                        </div>
                        {{-- <x-formy.form_select class="col-sm-6 col-md-12 mb-3" floating="1" selectedValue=""
                            name="venue_id" elementId="add_venue_id" label="Venue" required="required"
                            :forLoopCollection="$venues" itemIdForeach="id" itemTitleForeach="title" style=""
                            addDynamicButton="0" /> --}}
                        <x-formy.form_date_input class="col-sm-6 col-md-12 mb-3" floating="1" inputType="text"
                            name="service_date" elementId="add_service_date" label="Service Date" required="required"
                            inputValue="" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <?= get_label('close', 'Close') ?></label>
                    </button>
                    <button type="submit" class="btn btn-primary"
                        id="submit_btn"><?= get_label('save', 'Save') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_service_period_modal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">Edit service_period
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @php use App\Enums\CompanyType; @endphp
            <form novalidate="" class="modal-content form-submit-event needs-validation"
                id="edit_form_submit_service_period" action="{{ route('cms.setting.service.period.update') }}"
                method="POST">
                @csrf
                <input type="hidden" id="edit_service_period_id" name="id" value="">
                <input type="hidden" id="edit_service_period_table" name="table" value='service_period_table'>
                <div class="modal-body">
                    <div class="row">

                        <x-formy.form_input class="col-sm-6 col-md-12 mb-3" floating="1" inputAttributes=""
                            inputValue="" name="name" elementId="edit_name" inputType="text" label="Name"
                            required="required" disabled="0" />
                        <x-formy.form_select class="col-sm-6 col-md-12 mb-3" floating="1" selectedValue=""
                            name="event_id" elementId="edit_event_id" label="Event" required="required"
                            :forLoopCollection="$events" itemIdForeach="id" itemTitleForeach="name" style=""
                            addDynamicButton="0" />
                        <x-formy.form_select class="col-sm-6 col-md-12 mb-3" floating="1" selectedValue=""
                            name="venue_id" elementId="edit_venue_id" label="Venue" required="required"
                            :forLoopCollection="$venues" itemIdForeach="id" itemTitleForeach="title" style=""
                            addDynamicButton="0" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="text-1000 fw-bold mb-2">Status</label>
                    <select class="form-select" name="active_flag" id="editActiveFlag" required>
                        <option value="">Select</option>
                        <option value="1" selected>Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
                <div class="text-center mb-3">
                    <div class="mb-3 text-start">
                        <input type="file" name="file_name" class="dropify" data-height="200"
                            id="edit_file_name"
                            data-default-file="{{ !empty($user->photo) ? url('storage/upload/profile_images/' . $user->photo) : url('storage/upload/default.png') }}" />
                    </div>
                </div>
        </div>
        {{-- <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('name', 'name') ?> <span
                                    class="asterisk">*</span></label>
                            <input type="text" id="edit_service_period_name" class="form-control" name="name"
                                placeholder="<?= get_label('please_enter_name', 'Please enter name') ?>" />
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <x-formy.select_multiple class="col-md-12 mb-3" name="venue_id[]" elementId="edit_venue_id"
                            label="Venue assignment (multiple)" :forLoopCollection="$venues" itemIdForeach="id"
                            itemTitleForeach="title" required="" style="width: 100%" edit="0" />
                    </div>
                    <div class="mb-4">
                        <label class="text-1000 fw-bold mb-2">Status</label>
                        <select class="form-select" name="active_flag" id="editActiveFlag" required>
                            <option value="">Select</option>
                            <option value="1" selected>Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                    <div class="text-center mb-3">
                        <div class="mb-3 text-start">
                            <input type="file" name="file_name" id="edit_file_name" data-height="200"
                                data-default-file="" />
                        </div>
                    </div>
                </div> --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <?= get_label('close', 'Close') ?></label>
            </button>
            <button type="submit" class="btn btn-primary"
                id="submit_btn"><?= get_label('save', 'Save') ?></label></button>
        </div>
        </form>
    </div>
</div>
</div>
