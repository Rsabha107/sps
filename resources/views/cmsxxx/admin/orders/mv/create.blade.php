<script src="{{ asset ('fnx/assets/js/phoenix.js') }}"></script>

<input type="hidden" name="table" value="project_table" />
<div>

    <div class="card">
        <div class="card-header d-flex align-items-center border-bottom">
            <div class="ms-3">
                <h5 class="mb-0 fs-sm">Add Project</h5>
            </div>
        </div>
        <div class="card-body">

            <!-- <div class="row mb-3"> -->
            <div class="col-sm-6 col-md-12 mb-3">
                <div class="form-floating">
                    <input class="form-control @error('name') is-invalid @enderror" name="name"
                        id="floatingInputGrid" type="text" placeholder="Project title" required />
                    <div class="invalid-feedback">
                        Please enter project title.
                    </div>
                    <label for="floatingInputGrid">Project title</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="form-floating">
                        <select name="functional_area_id" class="form-select">
                            <option selected="selected" value="">Select...</option>
                            @foreach ($functional_areas as $key => $item)
                            @if (Request::old('id') == $item->id)
                            <option value="{{ $item->id }}" selected>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectTask">Functional Area</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="form-floating form-floating-advance-select">
                        <label>Add Tags</label>
                        <select name="tag_id[]" class="form-select" id="organizerMultiple" data-choices="data-choices"
                            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                            @foreach ($tags as $key => $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="form-floating">
                        <select name="project_type_id" class="form-select  @error('project_type_id') is-invalid @enderror"
                            id="add_project_project_type" required>
                            <option selected="selected" value="">Select...</option>
                            @foreach ($project_type as $key => $item)
                            @if (Request::old('id') == $item->id)
                            <option value="{{ $item->id }}" selected>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select project type.
                        </div>
                        <label for="floatingSelectPrivacy">Project type</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="form-floating">
                        <select name="use_project_template" class="form-select">
                            <option selected="selected" value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <label for="floatingSelectTask">Use Project Template</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-12  mb-3">
                <div class="form-floating">
                    <select name="category_id" class="form-select" id="add_project_category">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($event_category as $key => $item)
                        @if (Request::old('id') == $item->id)
                        <option value="{{ $item->id }}" selected>
                            {{ $item->name }}
                        </option>
                        @else
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    <label for="floatingSelectTeam">Category </label>
                </div>
            </div>
            <div class="col-sm-6 col-md-12  mb-3">
                <div class="form-floating">
                    <select name="client_id" class="form-select" id="add_project_client">
                        <option selected="selected" value="">Select...</option>
                        @foreach ($clients as $key => $item)
                        <option value="{{ $item->id }}">
                            {{ $item->first_name . ' ' . $item->last_name }}
                        </option>
                        @endforeach
                    </select>
                    <label for="floatingSelectAdmin">Cleint</label>
                </div>
            </div>
            <!-- </div> -->
            <div class="row mb-3">
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="flatpickr-input-container">
                        <div class="form-floating">
                            <input class="form-control datetimepicker" id="floatingInputStartDate" type="date"
                                placeholder="dd/mm/yyyy" placeholder="start date" name="start_date"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' required />
                            <div class="invalid-feedback">
                                Please enter start date.
                            </div>
                            <label class="ps-6" for="floatingInputStartDate">Start date</label><span
                                class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6  mb-3">
                    <div class="flatpickr-input-container">
                        <div class="form-floating">
                            <input class="form-control datetimepicker" id="floatingInputDeadline" type="date"
                                placeholder="dd/mm/yyyy" placeholder="deadline" name="end_date"
                                data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                            <label class="ps-6" for="floatingInputDeadline">Deadline</label><span
                                class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 gy-3">
                <div class="form-floating">
                    <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="floatingProjectOverview" placeholder="Leave a comment here"
                        style="height: 100px" required></textarea>
                    <div class="invalid-feedback">
                        Please enter project overview.
                    </div>
                    <label for="floatingProjectOverview">project overview</label>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-4 gy-3">
                    <div class="form-floating">
                        <input name="budget_allocation" class="form-control" id="edit_project_budget_allocation"
                            type="number" step="0.01" placeholder="Budget" value="0" />
                        <label for="floatingInputBudget">Cost</label>
                    </div>
                </div>
                <div class="col-md-4 gy-3">
                    <div class="form-floating">
                        <input name="total_sales" class="form-control" id="floatingInputBudget" type="number"
                            step="0.01" placeholder="Budget" value="0" />
                        <label for="floatingInputBudget">Sales</label>
                    </div>
                </div>
                <div class="col-md-4 gy-3">
                    <div class="form-floating">
                        <input name="sales_margin" class="form-control" id="floatingInputBudget" type="number"
                            step="0.01" placeholder="Budget" value="0" />
                        <label for="floatingInputBudget">Sales Margin</label>
                    </div>
                </div>
            </div>
            <div class="col-12 gy-3 mb-3">
                <div class="form-floating form-floating-advance-select">
                    <label>Add Resources</label>
                    <select name="assignment_to_id[]" class="form-select" id="organizerMultiple"
                        data-choices="data-choices" multiple="multiple"
                        data-options='{"removeItemButton":true,"placeholder":true}'>
                        @foreach ($employees as $key => $item)
                        <option value="{{ $item->id }}">
                            {{ $item->full_name }}
                        </option>
                        @endforeach
                    </select>
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
                        <button class="btn btn-primary px-5 px-sm-15" id="submit_btn">Create Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>