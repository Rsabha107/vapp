$(document).ready(function () {
    // console.log("all tasksJS file");

    // ************************************************** task venues

    $("body").on("click", "#editVehicle", function () {
        console.log('inside editVehicle')
        var id = $(this).data("id");
        var table = $(this).data("table");
        // console.log('edit venues in venues.js');
        // console.log('id: '+id);
        // console.log('table: '+table);
        // var target = document.getElementById("edit_venues_modal");
        // var spinner = new Spinner().spin(target);
        // $("#edit_venues_modal").modal("show");
        $.ajax({
            url: "/vapp/setting/vehicle/get/" + id,
            type: "get",
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            },
            dataType: "json",
            success: function (response) {
                console.log(response)
                $("#edit_vehicles_id").val(response.venue.id);
                $("#edit_vehicles_type_id").val(response.venue.vehicle_type_id);
                $("#edit_vehicles_make").val(response.venue.make);
                $("#edit_vehicles_license_plate").val(response.venue.license_plate);
                $("#edit_vehicles_status_id").val(response.venue.status_id);
                $("#edit_vehicles_table").val(table);
                // $("#edit_vehicle_types_modal").modal("show");
            },
        }).done(function () {
            $("#edit_vehicles_modal").modal("show");
        });
    });
});

$("body").on("click", "#deleteVehicle", function (e) {
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
                url: "/vapp/setting/vehicle/delete/" + id,
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

$("body").on("click", "#editVehicleStatus", function (event) {
    // console.log("inside sec click edit");
    // event.preventDefault();
    var id = $(this).data("id");
    var table = $(this).data("table");
    // var route = $(this).data("route");
    console.log("id: " + id);
    console.log("table: " + table);

    $.get("/vapp/vehicle/status/edit/" + id , function (data) {
        //  console.log('event name: ' + data);
        $.each(data, function (index, value) {
            // console.log(value[0]);
            $("#editVehicleId").val(value[0].id);
            $("#editVehicleStatusSelection").val(value[0].status_id);
            $("#vehicleStatusTable").val(table);
            $("#vehicleStatusModal").modal("show");
        });

        // $('#staticBackdropLabel').html("Edit category");
        // $('#submit').val("Edit category");
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



function actionsFormatter(value, row, index) {
    return [
        '<a href="javascript:void(0);" class="edit-vehicles" id="editVehicle" data-id=' +
            row.id +
            " title=" +
            label_update +
            ' data-table="vehicles_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
            "<button title=" +
            label_delete +
            ' type="button" data-table="vehicles_table" class="btn delete" id="deleteVehicle" data-id=' +
            row.id +
            ' data-type="status">' +
            '<i class="bx bx-trash text-danger mx-1"></i>' +
            "</button>",
    ];
}
