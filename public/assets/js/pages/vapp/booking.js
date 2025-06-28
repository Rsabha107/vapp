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

$("body").on("click", "#clear_filter_btn", function () {
    console.log("inside #clear_filter_btn");
    $("#filter_order_form")[0].reset();
    $("#date_range_filter").val("");
    $("#bookings_table").bootstrapTable("refresh");
});

$(
    "#vapp_size_filter, #fa_filter, #parking_filter, #event_filter, #venue_filter, #status_filter, #variation_filter, #date_range_filter"
).on("change", function (e) {
    // e.preventDefault();
    console.log("somthing on change");
    $("#bookings_table").bootstrapTable("refresh");
});

