$(document).ready(function () {
    // console.log("all tasksJS file");

    // ************************************************** task venues

    $("#offcanvas-add-match-modal").on("hidden.bs.offcanvas", function (e) {
        $(this)
            .find("input,textarea,select")
            .val("")
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
            
        // $(".js-select-project-assign-multiple").val(null).trigger("change");
        // $(".js-select-project-tags-multiple").val(null).trigger("change");
    });

    $("body").on("click", "#offcanvas-add-vapp-inventory", function () {
        console.log("inside #offcanvas-add-vapp-inventory");
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#cover-spin").show();
        $("#offcanvas-add-vapp-inventory-modal").offcanvas("show");
        $("#cover-spin").hide();
    });

    $("body").on("click", "#edit_vapp_inventory_offcanv", function () {
        console.log("inside #edit_vapp_inventory_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        var table = $(this).data("table");
        console.log("id", id);
        console.log("table", table);
        $.ajax({
            url: "/vapp/setting/inventory/mv/get/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                g_response = response.view;
                $("#global-edit-vapp-inventory-content").empty("").append(g_response);
                $("#add_project_table").val(table);
                $("#offcanvas-edit-vapp-inventory-modal").offcanvas("show");
                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#cover-spin").hide();
            },
        });
    });

    // delete project
    $("body").on("click", "#delete_vapp_inventory", function (e) {
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
                    url: "/vapp/setting/inventory/delete/" + id,
                    type: "DELETE",
                    headers: {
                      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Replace with your method of getting the CSRF token
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

    $("body").on("click", "#edit_vapp_inventory_offcanv", function () {
        console.log("inside #edit_vapp_inventory_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        var table = $(this).data("table");
        console.log("id", id);
        console.log("table", table);
        $.ajax({
            url: "/vapp/setting/inventory/mv/get/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                g_response = response.view;
                $("#global-edit-match-content").empty("").append(g_response);
                $("#edit_schedule_table").val(table);
                $("#offcanvas-edit-match-modal").offcanvas("show");
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

$("body").on("click", "#deleteParkingCapacity", function (e) {
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
                url: "/vapp/setting/schedule/delete/" + id,
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

$("body").on("click", "#editParkingCapacityStatus", function (event) {
    // console.log("inside sec click edit");
    // event.preventDefault();
    var id = $(this).data("id");
    var table = $(this).data("table");
    // var route = $(this).data("route");
    // console.log("id: " + id);
    // console.log("table: " + table);

    $.get("/vapp/schedule/status/edit/" + id , function (data) {
        //  console.log('event name: ' + data);
        $.each(data, function (index, value) {
            // console.log(value[0]);
            $("#editParkingCapacityId").val(value[0].id);
            $("#editParkingCapacityStatusSelection").val(value[0].status_id);
            $("#scheduleStatusTable").val(table);
            $("#scheduleStatusModal").modal("show");
        });

        // $('#staticBackdropLabel').html("Edit category");
        // $('#submit').val("Edit category");
    });
});


function actions2Formatter(value, row, index) {
    return [
        '<a href="javascript:void(0);" class="edit-schedules" id="editParkingCapacity" data-id=' +
            row.id +
            " title=" +
            label_intervals +
            ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
            '<a href="javascript:void(0);" class="edit-schedules" id="editParkingCapacity" data-id=' +
            row.id +
            " title=" +
            label_update +
            ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
            "<button title=" +
            label_delete +
            ' type="button" data-table="schedules_table" class="btn delete" id="deleteParkingCapacity" data-id=' +
            row.id +
            ' data-type="status">' +
            '<i class="bx bx-trash text-danger mx-1"></i>' +
            "</button>",
    ];
}

function actionsFormatter(value, row, index) {
    console.log("tasks.js inside actions2Formatter");
    html = "";
    // html =
    //     html +
    //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
    //     '<a href="/vapp/setting/interval/manage/'+ row.id + '" class="btn btn-sm" id="schedule_intervals" data-id="' +
    //     row.id +
    //     '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
    //     label_intervals +
    //     '">' +
    //     '<i class="fa-solid fas fa-network-wired text-warning"></i></a>';


        // html =
        //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
        //     '<a href="/tracki/task/' +
        //     row.id +
        //     '/edit" class="btn btn-sm" id="editX" data-route="category" data-id="">' +
        //     '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
        html =
            html +
            // '<div class="font-sans-serif btn-reveal-trigger position-static">' +
            '<a href="javascript:void(0)" class="btn btn-sm" id="editParkingCapacity" data-id="' +
            row.id +
            '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
            label_update +
            '">' +
            '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
        // html ='<a href="javascript:voice(0)" id="edit_task" data-id ="'+ row.id +'"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="'+ label_update +'"><i class="bx bx-plus"></i></button></a>'

        html =
            html +
            '<a href="javascript:void(0)" class="btn btn-sm delete" data-table="schedules_table" data-id="' +
            row.id +
            '" id="deleteParkingCapacity" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
            label_delete +
            '">' +
            '<i class="bx bx-trash text-danger"></i></a>';

html = html + "</div></div>";

    return [html];
}
