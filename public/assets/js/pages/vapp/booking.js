function refreshNotes(val) {
    var g_response;
    // alert('booking.js refreshNotes')
    $.ajax({
        url: "/vapp/admin/booking/mv/notes/" + val,
        method: "GET",
        async: false,
        success: function (response) {
            g_response = response.view;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });

    // console.log('return: '+g_response);
    return g_response;
}

let calendar;

$(document).ready(function () {
    // console.log("all booking file");

    // **************************************************
    function getDateWithoutTime(dt) {
        dt.setHours(0, 0, 0, 0);
        return dt;
    }

    $("body").on("click", "#editStatus", function (event) {
        console.log("inside sec click edit: _header.js");
        // event.preventDefault();
        var id = $(this).data("id");
        var table = $(this).data("table");
        // var route = $(this).data("route");
        // console.log("id: " + id);
        // console.log("table: " + table);

        $.get("/vapp/admin/booking/status/edit/" + id, function (data) {
            //  console.log('event name: ' + data);
            $.each(data, function (index, value) {
                console.log(value[0]);
                $("#editId").val(value[0].id);
                $("#editStatusSelection").val(value[0].status_id);
                $("#statusTable").val(table);
                $("#statusModal").modal("show");
            });

            // $('#staticBackdropLabel').html("Edit category");
            // $('#submit').val("Edit category");
        });
    });

    $("#booking_calendar_modal").on("hidden.bs.modal", function () {
        $("select#add_schedule_times_cal").val("");
        $("#cover-spin").hide();
        calendar.destroy();
    });

    $("#booking_calendar_modal").on("shown.bs.modal", function (e) {
        $("#cover-spin").show();
        if (calendar) {
            console.log("calendar exists");
            calendar.destroy();
        }
        var venue_id = $("#add_delivery_area").val();
        var calendarEl = document.getElementById("calendar");
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            themeSystem: "bootstrap5",
            events: function (info, successCallback, failureCallback) {
                $.ajax({
                    url: "/vapp/admin/booking/schedule",
                    method: "post", // Change to GET if you want
                    data: {
                        // Our data
                        venue_id: venue_id, // Team ID
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        successCallback(data);
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            },
            // events: "/vapp/admin/booking/schedule/" + venue_id,
            // eventBackgroundColor: "green",
            eventDisplay: "block",
            selectable: true,
            // showNonCurrentDates: false,
            // longPressDelay: 1,
            // contentHeight: "auto",
            // handleWindowResize: true,
            loading: function (bool) {
                if (bool) {
                    // loading starts
                    console.log("loading starts show");
                    $("#loading").show();
                } else {
                    // loading ends
                    console.log("loading ends hide");
                    $("#loading").hide();
                }
            },
            selectAllow: function (info) {
                console.log("selectAllow", info);

                $("#available-time").html(
                    "<h5>Available time slots for " + info.startStr + "</h5>"
                );

                $("#add_schedule_times_cal")
                    .empty("")
                    .html('<option value="">-- Select time --</option>');
                console.log("new Date: ", getDateWithoutTime(new Date()));
                console.log("info.dateStr: ", info.startStr);
                return info.start > getDateWithoutTime(new Date());
            },
            // dateClick: function (info) {
            //     console.log("dateClick", info);
            //     alert('clicked on '+info.dateStr);
            //     // $("#add_booking_date").val(info.dateStr);
            //     // $("#booking_calendar_modal").modal("hide");
            // },
            // select: function (info) {
            //     console.log("select", info);
            //     $("#cover-spin").show();
            //     $("#available-time").html(
            //         "<h5>Available time slots for " + info.startStr +"</h5>"
            //     );
            // },
            // dateClick: function (info) {
            // eventClick: function (info) {

            // select: function (info) {
            //     console.log("dateClick", info);
            //     $("#cover-spin").show();
            //     $("#available-time").html(
            //         "<h5>Available time slots for " + info.startStr + "</h5>"
            //     );

            //     $("#add_schedule_times_cal")
            //     .empty("")
            //     .html(
            //         '<option value="">-- Select time --</option>'
            //     );

            //     var eventObj = info.event;
            //     console.log("venue_id id", venue_id);
            //     console.log("info.startStr: ", info.startStr);
            //     $.ajax({
            //         url:
            //             "/vapp/admin/booking/times/cal/" +
            //             info.startStr +
            //             "/" +
            //             venue_id,
            //         type: "get",
            //         headers: {
            //             "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
            //         },
            //         dataType: "json",
            //         success: function (response) {
            //             console.log(response);
            //             console.log(
            //                 "response length: " + response.venue.length
            //             );
            //             // var len = response.length;

            //             $("#add_schedule_times_cal")
            //                 .empty("")
            //                 .html(
            //                     '<option value="">-- Select time --</option>'
            //                 );
            //             $.each(response.venue, function (key, value) {
            //                 var grey = null;
            //                 if (value.available_slots == 0) {
            //                     grey = "disabled";
            //                 } else {
            //                     grey = null;
            //                 }

            //                 $("#add_booking_date").val(info.startStr);

            //                 $("#add_schedule_times_cal").append(
            //                     '<option value="' +
            //                         value.id +
            //                         '" ' +
            //                         grey +
            //                         ">" +
            //                         value.rsp_booking_slot +
            //                         " (" +
            //                         value.available_slots +
            //                         ")</option>"
            //                 );
            //             });
            //             // console.log('before available-time');

            //             $("#cover-spin").hide();
            //         },
            //         error: function (xhr, ajaxOptions, thrownError) {
            //             $("#cover-spin").hide();
            //             console.log(xhr.status);
            //             console.log(thrownError);
            //         },
            //     }).done(function () {
            //         // $("#delivery_schedule_times_modal").modal("show");
            //     });

            //     // $("#delivery_schedule_times_modal").modal("show");
            // },
            dateClick: function (info) {
                console.log("dateClick", info);
                if (info.date < new Date()) {
                    message = "You cannot select a past date";
                    toastr.error(message);
                    return;
                }
                $("#cover-spin").show();

                $("#add_schedule_times_cal")
                    .empty("")
                    .html('<option value="">-- Select time --</option>');

                $("#available-time").html(
                    "<h5>Available time slots for " + info.dateStr + "</h5>"
                );

                $("#available-time").html(
                    "<h5>Available time slots for " + info.dateStr + "</h5>"
                );
                var eventObj = info.event;
                console.log("venue_id id", venue_id);
                console.log("info.startStr: ", info.dateStr);
                $.ajax({
                    url: "/vapp/admin/booking/times/cal",
                    method: "post",
                    data: {
                        venue_id: venue_id,
                        date: info.dateStr,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        console.log(
                            "response length: " + response.venue.length
                        );
                        // var len = response.length;

                        $("#add_schedule_times_cal")
                            .empty("")
                            .html(
                                '<option value="">-- Select time --</option>'
                            );
                        $.each(response.venue, function (key, value) {
                            var grey = null;
                            if (value.available_slots == 0) {
                                grey = "disabled";
                            } else {
                                grey = null;
                            }

                            $("#add_booking_date").val(info.dateStr);

                            $("#add_schedule_times_cal").append(
                                '<option value="' +
                                    value.id +
                                    '" ' +
                                    grey +
                                    ">" +
                                    value.rsp_booking_slot +
                                    " (" +
                                    value.available_slots +
                                    ")</option>"
                            );
                        });
                        console.log("before available-time");

                        $("#cover-spin").hide();
                    },
                }).done(function () {
                    // $("#delivery_schedule_times_modal").modal("show");
                });

                // $("#delivery_schedule_times_modal").modal("show");
            },
            eventClick: function (info) {
                console.log("eventClick", info);
                if (info.date < new Date()) {
                    message = "You cannot select a past date";
                    toastr.error(message);
                    return;
                }
                $("#cover-spin").show();

                var eventObj = info.event;
                console.log("eventObj start", eventObj.start);
                console.log("venue_id id", venue_id);
                var convertedDate = moment(eventObj.start).format("YYYY-MM-DD");
                var convertedDateDMY = moment(eventObj.start).format(
                    "DD/MM/YYYY"
                );

                $("#add_schedule_times_cal")
                    .empty("")
                    .html('<option value="">-- Select time --</option>');

                $("#available-time").html(
                    "<h5>Available time slots for " + convertedDate + "</h5>"
                );

                console.log("convertedDate", convertedDate);
                console.log("eventObj id", eventObj.id);
                $.ajax({
                    url: "/vapp/admin/booking/times/cal",
                    method: "post",
                    data: {
                        venue_id: venue_id,
                        date: info.dateStr,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        console.log(
                            "response length: " + response.venue.length
                        );
                        // var len = response.length;

                        $("#add_schedule_times_cal")
                            .empty("")
                            .html(
                                '<option value="">-- Select time --</option>'
                            );
                        $.each(response.venue, function (key, value) {
                            var grey = null;
                            if (value.available_slots == 0) {
                                grey = "disabled";
                            } else {
                                grey = null;
                            }

                            $("#add_booking_date").val(info.dateStr);

                            $("#add_schedule_times_cal").append(
                                '<option value="' +
                                    value.id +
                                    '" ' +
                                    grey +
                                    ">" +
                                    value.rsp_booking_slot +
                                    " (" +
                                    value.available_slots +
                                    ")</option>"
                            );
                        });
                        console.log("before available-time");

                        $("#cover-spin").hide();
                    },
                }).done(function () {
                    // $("#delivery_schedule_times_modal").modal("show");
                });

                // $("#delivery_schedule_times_modal").modal("show");
            },
        });
        calendar.setOption("locale", "en");
        calendar.render();

        const myModal = document.querySelector("#booking_calendar_modal");
        myModal.addEventListener("shown.bs.modal", () => {
            calendar.render();
        });
        $("#cover-spin").hide();
    });

    $("body").on("click", "#bookingDetails", function () {
        console.log("click get bookingDetails");

        var id = $(this).data("id");
        var table = $(this).data("table");

        console.log("id", id);
        console.log("table", table);

        $("#cover-spin").show();

        $.ajax({
            url: "/vapp/admin/booking/mv/detail/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                // console.log(response);
                g_response = response.view;
                $("#booking_details_modal_control")
                    .empty("")
                    .append(g_response);

                $("#booking_details_modal").modal("show");
                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    });


});

$("body").on("click", "#deleteBooking", function (e) {
    var id = $(this).data("id");
    var tableID = $(this).data("table");
    e.preventDefault();
    // console.log('in deleteBooking '+id);
    // console.log('in deleteBooking '+tableID);
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
            // console.log('inside confirmed')
            $.ajax({
                url: "/vapp/admin/booking/delete/" + id,
                type: "DELETE",
                headers: {
                    // "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                dataType: "json",
                success: function (result) {
                    // alert(result)
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

