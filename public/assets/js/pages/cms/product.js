$(document).ready(function () {
    // console.log("all tasksJS file");

    // ************************************************** task venues
    $("body").on("click", "#offcanvas-add-product", function () {
        console.log("inside #offcanvas-add-product");
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#cover-spin").show();
        $("#offcanvas-add-product-modal").offcanvas("show");
        $("#cover-spin").hide();
    });

    $("body").on("click", "#edit_product_offcanv", function () {
        console.log("inside edit_product_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        var table = $(this).data("table");
        // console.log('edit venues in venues.js');
        // console.log('id: '+id);
        // console.log('table: '+table);
        // var target = document.getElementById("edit_venues_modal");
        // var spinner = new Spinner().spin(target);
        // $("#edit_venues_modal").modal("show");
        $.ajax({
            url: "/cms/setting/product/get/" + id,
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
                imageUrl = response.product.image ?? "default.png";
                drEvent.settings.defaultFile = `/storage/products/${imageUrl}`;
                drEvent.destroy();
                drEvent.init();

                // console.log($("#edit_file_name").data("height"));
                // console.log("imageUrl: " + imageUrl);
                $("#edit_id").val(response.product.id);
                $("#edit_product_name").val(response.product.product_name);
                $("#edit_product_price").val(response.product.product_price);
                $("#edit_unit_type_id").val(response.product.unit_type_id);
                $("#edit_product_image").val(response.product.image);
                $("#edit_product_description").val(
                    response.product.product_description
                );
                $("#edit_venues_table").val(table);
                // $("#edit_venues_modal").modal("show");
                $("#cover-spin").hide();
            },
        }).done(function () {
            $("#offcanvas-edit-product-modal").offcanvas("show");
        });
    });
});

$("body").on("click", "#delete_product", function (e) {
    var id = $(this).data("id");
    var tableID = $(this).data("table");
    e.preventDefault();
    console.log("delete product id: " + id);
    console.log("delete product tableID: " + tableID);
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
                url: "/cms/setting/product/delete/" + id,
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

// function actionsFormatter(value, row, index) {
//     return [
//         '<a href="javascript:void(0);" class="edit-venues" id="editVenue" data-id=' +
//             row.id +
//             " title=" +
//             label_update +
//             ' data-table="venues_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
//             "<button title=" +
//             label_delete +
//             ' type="button" data-table="venues_table" class="btn delete" id="deleteVenue" data-id=' +
//             row.id +
//             ' data-type="status">' +
//             '<i class="bx bx-trash text-danger mx-1"></i>' +
//             "</button>",
//     ];
// }
