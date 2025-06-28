$(document).ready(function () {
    // console.log("all tasksJS file");

    $("#parkingModal").on("hidden.bs.modal", function () {
        // Reset the form (clears inputs, checkboxes, etc.)
        $("#parkingForm")[0].reset();

        // Reset select2 dropdowns
        $("#parkingTypeSelect").val(null).trigger("change.select2");

        // Clear dynamically loaded content
        $("#functionalAreaList").html("");
        $("#functionalAreaContainer").hide();
    });

    $(
        ".js-select-event-assign-multiple-add_venue_id, .js-select-event-assign-multiple-add_vapp_size_id, .js-select-event-assign-multiple-add_fa_id, .js-select-event-assign-multiple-add_match_id"
    ).select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    $(
        ".js-select-event-assign-multiple-edit_venue_id, .js-select-event-assign-multiple-edit_vapp_size_id, .js-select-event-assign-multiple-edit_fa_id, .js-select-event-assign-multiple-edit_match_id"
    ).select2({
        closeOnSelect: false,
        placeholder: "Select ...",
    });

    // $(".js-select-event-assign-multiple-add_vapp_size_id").select2({
    //     closeOnSelect: false,
    //     placeholder: "Select ...",
    // });

    // $(".js-select-event-assign-multiple-add_fa_id").select2({
    //     closeOnSelect: false,
    //     placeholder: "Select ...",
    // });
    // ************************************************** task venues

    $("#offcanvas-add-print-batch-modal").on(
        "hidden.bs.offcanvas",
        function (e) {
            let session_event_id = $("#add_event_id").val();
            $(this)
                .find("input,textarea,select")
                .val("")
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();

            $(
                ".js-select-event-assign-multiple-add_vapp_size_id, .js-select-event-assign-multiple-add_venue_id, .js-select-event-assign-multiple-add_fa_id"
            )
                .val(null)
                .trigger("change");
            $(
                ".js-select-event-assign-multiple-edit_vapp_size_id, .js-select-event-assign-multiple-edit_venue_id, .js-select-event-assign-multiple-edit_fa_id"
            )
                .val(null)
                .trigger("change");
            // $(".js-select-event-assign-multiple-add_venue_id")
            //     .val(null)
            //     .trigger("change");
            // $(".js-select-event-assign-multiple-add_fa_id")
            //     .val(null)
            //     .empty()
            //     .trigger("change");
            $("#add_event_id").val(session_event_id);
        }
    );

    $("#add_parking_id, #edit_parking_id").on("change", function () {
        const parkingMasterId = $(this).val();
        if (parkingMasterId) {
            console.log("Selected Parking Type ID:", parkingMasterId);
            $.ajax({
                url:
                    "/vapp/setting/print/batch/vapp_sizes/" +
                    parkingMasterId,
                method: "GET",
                async: true,
                success: function (response) {
                    $("#cover-spin").show();
                    g_response = response.vapp_sizes;
                    console.log("g_response", g_response);
                    let options = g_response.map(function (size) {
                        return new Option(size.title, size.id, false, false);
                    });

                    $("#add_vapp_size_id, #edit_vapp_size_id")
                        .empty("")
                        .append(options)
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
            $("#add_vapp_size_id, #edit_vapp_size_id").empty();
            $("#add_vapp_size_id, #edit_vapp_size_id").val(null).trigger("change");
            $("#cover-spin").hide();
        }
    });

    // Show ADD offcanvas
    $("body").on("click", "#offcanvas-add-print-batch", function () {
        console.log("inside #offcanvas-add-project");
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#cover-spin").show();
        $("#offcanvas-add-print-batch-modal").offcanvas("show");
        $("#cover-spin").hide();
    });

    // Show EDIT offcanvas
    $("body").on("click", "#edit_print_batch_offcanv", function () {
        console.log("inside #edit_print_batch_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        // var table = $(this).data("table");
        // console.log("id", id);
        // console.log("table", table);
        $.ajax({
            url: "/vapp/setting/print/batch/get/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                // console.log("response", response);
                $("#cover-spin").show();

                let options = response.parkingMasterFa.map(function (fa) {
                    return new Option(fa.title, fa.id, false, false);
                });

                $("#edit_fa_id").empty("").append(options).trigger("change");

                $("#edit_variation_id").val(response.variation.id);
                $("#edit_parking_id").val(response.variation.parking_id);
                $("#edit_match_id").val(response.variation.match_id);
                $("#edit_event_id").val(response.variation.event_id);

                // select2 for Functional Areas
                var functionalAreas = response.functional_areas.map(
                    (fa) => fa.id
                );
                // console.log("functionalAreas", functionalAreas);
                $("#edit_fa_id").val(functionalAreas);
                $("#edit_fa_id").trigger("change");

                // select2 for venues
                var venueSelect2 = response.venues.map((venue) => venue.id);
                $("#edit_venue_id").val(venueSelect2);
                $("#edit_venue_id").trigger("change");

                // select2 for VAPP Sizes
                var vappSizeSelect2 = response.vapp_sizes.map(
                    (vappSize) => vappSize.id
                );
                $("#edit_vapp_size_id").val(vappSizeSelect2);
                $("#edit_vapp_size_id").trigger("change");

                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#cover-spin").hide();
            },
        }).done(function () {
            $("#offcanvas-edit-print-batch-modal").offcanvas("show");
        });
    });

    // delete project
    $("body").on("click", "#delete_print_batch", function (e) {
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
                    url: "/vapp/setting/print/batch/delete/" + id,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ), // Replace with your method of getting the CSRF token
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

    // $("body").on("click", "#edit_print_batch_offcanv", function () {
    //     console.log("inside #edit_print_batch_offcanv");
    //     $("#cover-spin").show();
    //     var id = $(this).data("id");
    //     var table = $(this).data("table");
    //     console.log("id", id);
    //     console.log("table", table);
    //     $.ajax({
    //         url: "/vapp/setting/parking/mv/get/" + id,
    //         method: "GET",
    //         async: true,
    //         success: function (response) {
    //             g_response = response.view;
    //             $("#global-edit-print-batch-content")
    //                 .empty("")
    //                 .append(g_response);
    //             $("#edit_schedule_table").val(table);
    //             $("#offcanvas-edit-print-batch-modal").offcanvas("show");
    //             $("#cover-spin").hide();
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //             $("#cover-spin").hide();
    //         },
    //     });
    // });
});

$("body").on("click", "#deleteParkingvariation", function (e) {
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

// function actions2Formatter(value, row, index) {
//     return [
//         '<a href="javascript:void(0);" class="edit-schedules" id="editParkingvariation" data-id=' +
//             row.id +
//             " title=" +
//             label_intervals +
//             ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
//             '<a href="javascript:void(0);" class="edit-schedules" id="editParkingvariation" data-id=' +
//             row.id +
//             " title=" +
//             label_update +
//             ' data-table="schedules_table" class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
//             "<button title=" +
//             label_delete +
//             ' type="button" data-table="schedules_table" class="btn delete" id="deleteParkingvariation" data-id=' +
//             row.id +
//             ' data-type="status">' +
//             '<i class="bx bx-trash text-danger mx-1"></i>' +
//             "</button>",
//     ];
// }

// function actionsFormatter(value, row, index) {
//     console.log("tasks.js inside actions2Formatter");
//     html = "";
//     // html =
//     //     html +
//     //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
//     //     '<a href="/vapp/setting/interval/manage/'+ row.id + '" class="btn btn-sm" id="schedule_intervals" data-id="' +
//     //     row.id +
//     //     '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
//     //     label_intervals +
//     //     '">' +
//     //     '<i class="fa-solid fas fa-network-wired text-warning"></i></a>';

//     // html =
//     //     '<div class="font-sans-serif btn-reveal-trigger position-static">' +
//     //     '<a href="/tracki/task/' +
//     //     row.id +
//     //     '/edit" class="btn btn-sm" id="editX" data-route="category" data-id="">' +
//     //     '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
//     html =
//         html +
//         // '<div class="font-sans-serif btn-reveal-trigger position-static">' +
//         '<a href="javascript:void(0)" class="btn btn-sm" id="editParkingvariation" data-id="' +
//         row.id +
//         '" data-table="schedules_table" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
//         label_update +
//         '">' +
//         '<i class="fa-solid fa-pen-to-square text-primary"></i></a>';
//     // html ='<a href="javascript:voice(0)" id="edit_task" data-id ="'+ row.id +'"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="'+ label_update +'"><i class="bx bx-plus"></i></button></a>'

//     html =
//         html +
//         '<a href="javascript:void(0)" class="btn btn-sm delete" data-table="schedules_table" data-id="' +
//         row.id +
//         '" id="deleteParkingvariation" data-bs-toggle="tooltip" data-bs-placement="right" title="' +
//         label_delete +
//         '">' +
//         '<i class="bx bx-trash text-danger"></i></a>';

//     html = html + "</div></div>";

//     return [html];
// }
