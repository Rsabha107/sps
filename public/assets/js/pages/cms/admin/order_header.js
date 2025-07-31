// import Choices from 'phoenix.js'

function checkModelOpen(e) {
    if (Element.data("bs.modal").isShown) {
        return true;
    }

    return false;
}

function openModalWithData(data) {
    let tbody = $("#modalTable tbody");
    tbody.empty();

    data.forEach((item, index) => {
        tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${item.product}</td>
                <td>${item.quantity}</td>
                <td>${item.price}</td>
            </tr>
        `);
    });

    // Show the modal
    $("#dataModal").modal("show");
}

$(document).ready(function () {
    console.log("inside order_header.js");
    $(".js-select-project-assign-multiple").select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    $(".js-select-project-tags-multiple").select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    $(".js-select-project-member-assign-multiple").select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    // load data for order lines modal
    $("body").on("click", "#editOrderStatus", function (event) {
        console.log("inside sec click edit: order_header.js");
        // event.preventDefault();
        var id = $(this).data("id");
        var table = $(this).data("table");
        // var route = $(this).data("route");
        // console.log("id: " + id);
        // console.log("table: " + table);

        $.get("/cms/admin/orders/status/edit/" + id, function (data) {
            //  console.log('event name: ' + data);
            $.each(data, function (index, value) {
                console.log(value[0]);
                $("#editOrderId").val(value[0].id);
                $("#editOrderStatusSelection").val(value[0].status_id);
                $("#orderStatusTable").val(table);
                $("#orderStatusModal").modal("show");
            });

            // $('#staticBackdropLabel').html("Edit category");
            // $('#submit').val("Edit category");
        });
    });

    $("body").on("click", "#show_order_lines", function () {
        console.log("inside #show_order_lines admin");
        let orderId = $(this).data("id");
        let url = `/cms/admin/orders/${orderId}/modal`;

        console.log("url", url);

        $.get(url, function (response) {
            console.log("response", response);
            g_response = response.view;
            $("#order_lines_modal_body").empty("").append(g_response);
            $("#order_lines_modal").modal("show");
        });
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        // $("#cover-spin").show();
        // $("#order_lines_modal").modal("show");
        // $("#cover-spin").hide();
    });

    $(document).on("show.bs.modal", ".modal", function (event) {
        // alert('on show.bs.modal')
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function () {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });

    // $("#change_client").on("change", function (){
    //     alert(this.value);
    // })
    // $("#add_project_assigned_to").select2();
    // $(".js-select-tags-multiple").select2();

    // $("#projectCards").html("project cards projectCards");

    $("#offcanvas-add-order-modal").on("hidden.bs.offcanvas", function (e) {
        $(this)
            .find("input,textarea,select")
            .val("")
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();

        $(".js-select-project-assign-multiple").val(null).trigger("change");
        $(".js-select-project-tags-multiple").val(null).trigger("change");
    });

    $("body").on("click", "#offcanvas-add-order", function () {
        console.log("inside #offcanvas-add-order");
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#cover-spin").show();
        $("#offcanvas-add-order-modal").offcanvas("show");
        $("#cover-spin").hide();
    });

    $("body").on("click", "#edit_purchase_offcanv", function () {
        console.log("inside #edit_purchase_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        console.log("id", id);
        $.ajax({
            url: "/cms/admin/orders/mv/edit/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                g_response = response.view;
                $("#global-edit-purchase-content").empty("").append(g_response);

                $("#offcanvas-edit-purchase-modal").offcanvas("show");
                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#cover-spin").hide();
            },
        });
    });

    // delete purchase
    $("body").on("click", "#delete_purchase", function (e) {
        var id = $(this).data("id");
        var tableID = $(this).data("table");
        e.preventDefault();
        // alert("tableID: "+tableID);
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
                    url: "/cms/admin/orders/delete/" + id,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (result) {
                        if (!result["error"]) {
                            toastr.success(result["message"]);
                            // divToRemove.remove();
                            // $("#fileCount").html("File ("+result["count"]+")");
                            // console.log('before table refrest for #'+tableID);
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
                        // $("#cover-spin").hide();
                        toastr.error(thrownError);
                    },
                });
            }
        });
    });

    // show attachment list from order list (clip icon)
    $("body").on("click", "#attachment_list", function () {
        $("#cover-spin").show();
        id = $(this).data("model_id");
        console.log("attachment_list clicked for id: " + id);

        $.ajax({
            url: "/cms/admin/orders/attachments/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                g_response = response.view;
                console.log("g_response", g_response);
                $("#AttachmentView").empty("").append(g_response);
                $("#attachment_list_modal").modal("show");
                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#cover-spin").hide();
            },
        });
    });
});

("use strict");

$("#add_project_tag").on("select2:close", function (e) {
    e.preventDefault();
    console.log("projects.js on change of add_project_tag");
    console.log($("#add_project_tag").val());
});
