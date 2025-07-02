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

    $(".js-select-event-assign-multiple-add_fa_id").on("change", function (e) {
        let selected = $(this).val();

        console.log("Selected Functional Areas:", selected);

        if (selected.includes("0")) {
            // Select all options
            console.log("Selecting 'All' option");
            $(".js-select-event-assign-multiple-add_fa_id > option").prop(
                "selected",
                true
            );
            $(".js-select-event-assign-multiple-add_fa_id").trigger(
                "change.select2"
            );
        } else if (
            !selected.includes("0") &&
            selected.length <
                $(".js-select-event-assign-multiple-add_fa_id option").length -
                    1
        ) {
            // If "All" was previously selected and now deselected

            console.log("Deselecting 'All' option");
            $(
                '.js-select-event-assign-multiple-add_fa_id > option[value="0"]'
            ).prop("selected", false);
            $(".js-select-event-assign-multiple-add_fa_id").trigger(
                "change.select2"
            );
        } else {
            console.log("Deselecting all options except '0'");
            const newSelection = selected.filter((val) => val !== "0");
            $("#mySelect").val(newSelection).trigger("change.select2");
        }
    });

    $(".js-select-event-assign-multiple-edit_fa_id").on("change", function (e) {
        let selected = $(this).val();

        console.log("Selected Functional Areas:", selected);

        if (selected.includes("0")) {
            // Select all options
            console.log("Selecting 'All' option");
            $(".js-select-event-assign-multiple-edit_fa_id > option").prop(
                "selected",
                true
            );
            $(".js-select-event-assign-multiple-edit_fa_id").trigger(
                "change.select2"
            );
        } else if (
            !selected.includes("0") &&
            selected.length <
                $(".js-select-event-assign-multiple-edit_fa_id option").length -
                    1
        ) {
            // If "All" was previously selected and now deselected

            console.log("Deselecting 'All' option");
            $(
                '.js-select-event-assign-multiple-edit_fa_id > option[value="0"]'
            ).prop("selected", false);
            $(".js-select-event-assign-multiple-edit_fa_id").trigger(
                "change.select2"
            );
        } else {
            console.log("Deselecting all options except '0'");
            const newSelection = selected.filter((val) => val !== "0");
            $("#mySelect").val(newSelection).trigger("change.select2");
        }
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

    $(".js-select-event-assign-multiple-add_venue_id").on(
        "change",
        function () {
            const selectedVenueIds = $(this).val();
            console.log("Selected Venue IDs:", selectedVenueIds);
        }
    );

    $("#offcanvas-add-parking-variation-modal").on(
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
            // $("#add_event_id").val(session_event_id);
        }
    );

    const vappParkingSelect = document.getElementById("add_parking_id");
    const vappParkingChoices = new Choices(vappParkingSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        allowHTML: true,
        // placeholderValue: "Select VAPP Codes",
    });

    $("#add_event_id, #edit_event_id").on("change", function () {
        console.log("Event ID changed");
        vappParkingChoices.clearStore();

        const eventId = $(this).val();
        if (eventId) {
            console.log("Selected Event ID:", eventId);
            $.ajax({
                url: "/vapp_get_parking_code_from_event/" + eventId,
                method: "GET",
                async: true,
                success: function (response) {
                    console.log("response", response);
                    $("#loadingOverlay").removeClass("d-none");
                    // dynamically populate the venues
                    let vappParkingOptions = response.parkings.map(function (
                        parking
                    ) {
                        return new Option(
                            parking.parking_code,
                            parking.id,
                            false,
                            false
                        );
                    });
                    // $("#add_parking_id, #edit_parking_id")
                    //     .empty("")
                    //     .append(parking_options)
                    //     .trigger("change");

                    vappParkingChoices.clearStore();
                    vappParkingChoices.setChoices(
                        vappParkingOptions,
                        "value",
                        "label",
                        true
                    );

                    $("#add_vapp_size_id, #edit_vapp_size_id")
                        .empty()
                        .trigger("change");

                    // dynamically populate the vapp sizes
                    // let vapp_size_options = response.vapp_sizes.map(function (vappSize) {
                    //     return new Option(
                    //         vappSize.title,
                    //         vappSize.id,
                    //         false,
                    //         false
                    //     );
                    // });
                    // $("#add_vapp_size_id, #edit_vapp_size_id")
                    //     .empty("")
                    //     .append(vapp_size_options)
                    //     .trigger("change");

                    $("#loadingOverlay").addClass("d-none");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    $("#loadingOverlay").addClass("d-none");
                },
            });
        } else {
            console.log("No Event ID selected");
            $("#add_parking_id, #add_vapp_size_id").empty();
            $("#add_parking_id, #add_vapp_size_id").val(null).trigger("change");
            $("#loadingOverlay").addClass("d-none");
        }
    });

    $("#add_parking_id, #edit_parking_id").on("change", function () {
        const parkingMasterId = $(this).val();
        if (parkingMasterId) {
            console.log("Selected Parking Type ID:", parkingMasterId);
            $.ajax({
                url:
                    "/vapp/setting/parking/code/functional_areas/" +
                    parkingMasterId,
                method: "GET",
                async: true,
                success: function (response) {
                    $("#cover-spin").show();

                    // functionalAreas = response.functional_areas;
                    vappSizes = response.vapp_sizes;
                    // matchs = response.matchs;

                    console.log("response", response);

                    // dynamically populate the functional areas
                    // let fa_options = functionalAreas.map(function (fa) {
                    //     return new Option(fa.title, fa.id, false, false);
                    // });
                    // $("#add_fa_id, #edit_fa_id")
                    //     .empty("")
                    //     .append(fa_options)
                    //     .trigger("change");

                    // dynamically populate the vapp sizes
                    let vapp_size_options = vappSizes.map(function (vappSize) {
                        return new Option(
                            vappSize.title,
                            vappSize.id,
                            false,
                            false
                        );
                    });
                    $("#add_vapp_size_id, #edit_vapp_size_id")
                        .empty("")
                        .append(vapp_size_options)
                        .trigger("change");

                    // dynamically populate the matches
                    // let match_options = matchs.map(function (match) {
                    //     return new Option(
                    //         match.match_code,
                    //         match.id,
                    //         false,
                    //         false
                    //     );
                    // });
                    // $("#edit_match_id")
                    //     .empty("")
                    //     .append(match_options)
                    //     .trigger("change");
                    // $("#cover-spin").hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    $("#cover-spin").hide();
                },
            });
        } else {
            console.log("No Parking Type ID selected");
            // $("#add_fa_id, #add_vapp_size_id").empty();
            $("#add_fa_id, #add_vapp_size_id").val(null).trigger("change");
            $("#cover-spin").hide();
        }
    });

    // Show ADD offcanvas
    $("body").on("click", "#offcanvas-add-parking-variation", function () {
        console.log("inside #offcanvas-add-project");
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#cover-spin").show();
        $("#offcanvas-add-parking-variation-modal").offcanvas("show");
        $("#cover-spin").hide();
    });

    // Show EDIT offcanvas
    $("body").on("click", "#edit_parking_variation_offcanv", function () {
        console.log("inside #edit_parking_variation_offcanv");
        $("#cover-spin").show();
        var id = $(this).data("id");
        // var table = $(this).data("table");
        // console.log("id", id);
        // console.log("table", table);
        $.ajax({
            url: "/vapp/setting/parking/variation/get/" + id,
            method: "GET",
            async: true,
            success: function (response) {
                // console.log("response", response);
                $("#cover-spin").show();

                let fa_options = response.parkingMasterFa.map(function (fa) {
                    return new Option(fa.title, fa.id, false, false);
                });

                let size_options = response.parkingMasterSize.map(function (
                    fa
                ) {
                    return new Option(fa.title, fa.id, false, false);
                });

                // $("#edit_fa_id").empty("").append(fa_options).trigger("change");
                $("#edit_vapp_size_id")
                    .empty("")
                    .append(size_options)
                    .trigger("change");

                $("#edit_variation_id").val(response.variation.id);
                $("#edit_parking_id").val(response.variation.parking_id);
                // $("#edit_match_id").val(response.variation.match_category_id);
                $("#edit_event_id").val(response.variation.event_id);
                $("#edit_match_category_id").val(
                    response.variation.match_category_id
                );

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

                // select2 for Matches
                // var matchSelect2 = response.matchs.map((match) => match.id);
                // $("#edit_match_id").val(matchSelect2);
                // $("#edit_match_id").trigger("change");

                $("#cover-spin").hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#cover-spin").hide();
            },
        }).done(function () {
            $("#offcanvas-edit-parking-variation-modal").offcanvas("show");
        });
    });

    // delete project
    $("body").on("click", "#delete_parking_variation", function (e) {
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
                    url: "/vapp/setting/parking/variation/delete/" + id,
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

    const vappSizeSelect = document.getElementById("add_inv_vapp_size_id");
    const vappVenueSelect = document.getElementById("add_inv_venue_id");
    const vappSizeChoices = new Choices(vappSizeSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        // placeholderValue: "Select VAPP Sizes",
    });
    const vappVenueChoices = new Choices(vappVenueSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        // placeholderValue: "Select VAPP Sizes",
    });

    // Show ADD Inventroy Variation offcanvas
    $("body").on("click", "#add_inventory_to_variation", function () {
        console.log("inside #add_inventory_to_variation ....");

        var variationId = $(this).data("id");
        var eventId = $(this).data("event-id");
        var parkingId = $(this).data("parking-id");
        console.log("variationId", variationId);
        console.log("eventId", eventId);
        console.log("parkingId", parkingId);
        // vappSizeChoices.clearChoices();
        // vappSizeChoices.setChoices(
        //     [
        //         {
        //             value: "",
        //             label: "Loading...",
        //             selected: true,
        //             disabled: true,
        //         },
        //     ],
        //     "value",
        //     "label",
        //     false
        // );

        if (variationId) {
            $.ajax({
                url: "/vapp/setting/inventory/variation/get/" + variationId,
                type: "GET",
                success: function (data) {
                    console.log("data", data);
                    const vappSizeOptions = data.vapp_sizes.map((item) => ({
                        value: item.id,
                        label: item.title,
                    }));
                    const vappVenueOptions = data.venues.map((item) => ({
                        value: item.id,
                        label: item.title,
                    }));

                    vappSizeChoices.clearStore();
                    vappVenueChoices.clearStore();

                    vappSizeChoices.setChoices(
                        vappSizeOptions,
                        "value",
                        "label",
                        true
                    );
                    vappVenueChoices.setChoices(
                        vappVenueOptions,
                        "value",
                        "label",
                        true
                    );
                },
                error: function () {
                    vappSizeChoices.clearStore();
                    vappVenueChoices.clearStore();

                    vappSizeChoices.setChoices(
                        [
                            {
                                value: "",
                                label: "Failed to load VAPP Sizes",
                                disabled: true,
                            },
                        ],
                        "value",
                        "label",
                        true
                    );
                    vappVenueChoices.setChoices(
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
            vappSizeChoices.clearStore();
            vappVenueChoices.clearStore();

            vappSizeChoices.setChoices(
                [{ value: "", label: "Select a VAPP Sizes", disabled: false }],
                "value",
                "label",
                true
            );
            vappVenueChoices.setChoices(
                [{ value: "", label: "Select a VAPP Sizes", disabled: false }],
                "value",
                "label",
                true
            );
        }
        // $("#add_edit_form").get(0).reset()
        // console.log(window.choices.removeActiveItems())
        $("#add_inv_variation_id").val(variationId);
        $("#add_inv_event_id").val(eventId);
        $("#add_inv_parking_id").val(parkingId);
        $("#cover-spin").show();
        $("#offcanvas-add-inventory-variation-modal").offcanvas("show");
        $("#cover-spin").hide();
    });
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
