$(document).ready(function () {
    // console.log("all tasksJS file");

    // ************************************************** task venues
    $(
        ".js-select-event-assign-multiple-add_venue_id, .js-select-event-assign-multiple-edit_venue_id"
    ).select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    $(
        ".js-select-event-assign-multiple-add_event_id, .js-select-event-assign-multiple-edit_event_id"
    ).select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    // $('#venue-select').select2();
    const venueSelect = document.getElementById("add_venue_id");
    const venueChoices = new Choices(venueSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholderValue: "Select a Venue",
    });

    $("#add_event_id").on("change", function () {
        console.log("add_event_id changed");
        console.log("venueSelect", venueSelect);

        console.log("venueChoices", venueChoices);

        venueChoices.clearChoices();
        venueChoices.setChoices(
            [
                {
                    value: "",
                    label: "Loading...",
                    selected: true,
                    disabled: true,
                },
            ],
            "value",
            "label",
            false
        );

        let eventId = $(this).val();

        $("#add_venue_id")
            .empty()
            .append('<option value="">Loading...</option>');

        if (eventId) {
            $.ajax({
                url: "/cms/setting/service/period/" + eventId + "/venues",
                type: "GET",
                success: function (data) {
                    const venueOptions = data.map((venue) => ({
                        value: venue.id,
                        label: venue.title,
                    }));

                    venueChoices.clearStore();
                    venueChoices.setChoices(
                        venueOptions,
                        "value",
                        "label",
                        true
                    );
                },
                error: function () {
                    venueChoices.clearStore();
                    venueChoices.setChoices(
                        [
                            {
                                value: "",
                                label: "Failed to load venues",
                                disabled: true,
                            },
                        ],
                        "value",
                        "label",
                        true
                    );
                },
            });
        } else {
            venueChoices.clearStore();
            venueChoices.setChoices(
                [{ value: "", label: "Select a Venue", disabled: false }],
                "value",
                "label",
                true
            );
        }
    });



    // get the venues assiated with an Event.. this is not used but here for reference
    $("#add_event_idx, #edit_event_idx").on("change", function () {
        const eventId = $(this).val();
        if (eventId) {
            console.log("Selected Parking Type ID:", eventId);
            $.ajax({
                url: "/cms/setting/service/period/get/venues/" + eventId,
                method: "GET",
                async: true,
                success: function (response) {
                    $("#cover-spin").show();
                    venues = response.venues;
                    console.log("response", response);

                    // dynamically populate the functional areas
                    let venue_options = venues.map(function (venue) {
                        return new Option(venue.title, venue.id, false, false);
                    });
                    $("#add_venue_id, #edit_venue_id")
                        .empty("")
                        .append(venue_options)
                        .trigger("change");

                    $("#cover-spin").hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    $("#cover-spin").hide();
                },
            });
        } else {
            console.log("No Parking Type ID selected");
            $("#add_edit_id").empty();
            $("#add_edit_id").val(null).trigger("change");
            $("#cover-spin").hide();
        }
    });

    $("body").on("click", "#editServicePeriods", function () {
        console.log("inside edit_contractors");

        var id = $(this).data("id");
        var table = $(this).data("table");
        // console.log('edit venues in venues.js');
        // console.log('id: '+id);
        // console.log('table: '+table);
        // var target = document.getElementById("edit_venues_modal");
        // var spinner = new Spinner().spin(target);
        // $("#edit_contractor_table").modal("show");
        $.ajax({
            url: "/cms/setting/service/period/get/" + id,
            type: "get",
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                let imageUrl = "";
                // Get the Dropify instance
                let drEvent = $("#edit_file_name").dropify();

                // Reset and destroy the previous instance
                drEvent = drEvent.data("dropify");
                drEvent.resetPreview();
                drEvent.clearElement();
                imageUrl = response.op.image ?? "default.png";
                drEvent.settings.defaultFile = `/storage/service/period/logo/${imageUrl}`;
                drEvent.destroy();
                drEvent.init();

                var contractorVenues = response.venues.map((venue) => venue.id);
                // console.log(contractorVenues);

                var contractorEvents = response.events.map((event) => event.id);
                // console.log(contractorVenues);

                $("#edit_contractor_id").val(response.op.id);
                $("#edit_name").val(response.op.name);
                $("#edit_email").val(response.op.email);
                $("#edit_phone").val(response.op.phone);
                $("#edit_address").val(response.op.address);
                $("#edit_company_name").val(response.op.company_name);
                $("#edit_currency_id").val(response.op.currency_id);
                // $("#edit_event_id").val(response.op.event_id);
                $("#edit_company_type").val(response.op.company_type);

                $("#edit_venue_id").val(contractorVenues);
                $("#edit_venue_id").trigger("change");
                $("#edit_event_id").val(contractorEvents);
                $("#edit_event_id").trigger("change");

                $("#editActiveFlag").val(response.op.active_flag);
                $("#edit_contractor_table").val(table);
                // $("#edit_contractor_modal").modal("show");
            },
        }).done(function () {
            $("#edit_contractor_modal").modal("show");
        });
    });
});

$("body").on("click", "#deleteServicePeriod", function (e) {
    var id = $(this).data("id");
    var tableID = $(this).data("table");
    e.preventDefault();
    // alert('in deleteStatus '+tableID);
    var link = $(this).attr("href");
    Swal.fire({
        title: "Are you sure?",
        text: "Delete This Data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/cms/setting/service/period/delete/" + id,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                },
                dataType: "json",
                success: function (result) {
                    if (!result["error"]) {
                        toastr.success(result["message"]);
                        $("#" + tableID).bootstrapTable("refresh");
                        // Swal.fire(
                        //     'Deleted!',
                        //     'Your file has been deleted.',
                        //     'success'
                        //   )
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
    });
});

("use strict");
function queryParams(p) {
    return {
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
};

function loadingTemplate(message) {
    return '<i class="bx bx-loader-alt bx-spin bx-flip-vertical" ></i>';
}

function imageFormatter(value, row, index) {
    if (!value)
        return `<img src="/storage/service/period/logo/noimage.png" alt="product image" width="60" class="rounded-circle pull-up">`;
    return `<img src="/storage/service/period/logo/${value}" alt="product image" width="60" class="rounded-circle pull-up">`;
}
