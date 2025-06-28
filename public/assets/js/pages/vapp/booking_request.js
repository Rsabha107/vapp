$(document).ready(function () {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-center", // top-right, top-center, bottom-left, etc.
        timeOut: "3000",
    };
    // initialize Choices.js for the VAPP Venue select element
    const vappVenueSelect = document.getElementById("add_var_venue_id");
    const vappVenueChoices = new Choices(vappVenueSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        allowHTML: true,
        // placeholderValue: "Select VAPP Codes",
    });

    // initialize Choices.js for the VAPP Size select element
    const vappVappSizeSelect = document.getElementById("add_var_vapp_size_id");
    const vappVappSizeChoices = new Choices(vappVappSizeSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        allowHTML: true,

        // placeholderValue: "Select VAPP Codes",
    });

    // initialize Choices.js for the Match select element
    const vappMatchSelect = document.getElementById("add_var_match_id");
    const vappMatchChoices = new Choices(vappMatchSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        allowHTML: true,

        // placeholderValue: "Select VAPP Codes",
    });

    // initialize Choices.js for the FunctionalArea select element
    const vappFunctionalAreaSelect = document.getElementById(
        "add_var_functional_area_id"
    );
    const vappFunctionalAreaChoices = new Choices(vappFunctionalAreaSelect, {
        searchEnabled: false,
        shouldSort: false,
        placeholder: true,
        itemSelectText: "",
        allowHTML: true,
    });

    // you will initialize the category choices here
    $("body").on("change", "#add_var_parking_id", function () {
        // Get the selected VAPP Code
        var varParkingId = $(this).val();
        console.log("Selected VAPP Code:", varParkingId);
        // const selectedVappCode = vappVenueSelect.value;
        $(".main-card").css("background-color", "rgba(52, 152, 219, 0.6)");
        $("#add_requested_vapp_a5").prop("disabled", true);
        $("#add_requested_vapp_a4").prop("disabled", true);
        $("#add_requested_vapp_20").prop("disabled", true);
        $("#add_requested_vapp_hanger").prop("disabled", true);

        // if (varParkingId) {
        //     $.ajax({
        //         url: "/get-catergory",
        //         type: "GET",
        //         data: {
        //             parking_id: varParkingId,
        //         },
        //         success: function (data) {
        //             console.log("data", data.variationCategory);
        //             $("#cover-spin").show();
        //             const vappCategoryOptions = data.variationCategory.map(
        //                 (item) => ({
        //                     value: item.match_category.id,
        //                     label: item.match_category.title,
        //                 })
        //             );

        //             vappCategoryChoices.clearStore();
        //             vappCategoryChoices.setChoices(
        //                 vappCategoryOptions,
        //                 "value",
        //                 "label",
        //                 true
        //             );
        //             $("#cover-spin").hide();
        //         },
        //         error: function () {
        //             vappCategoryChoices.clearStore();
        //             vappCategoryChoices.setChoices(
        //                 [
        //                     {
        //                         value: "",
        //                         label: "Failed to load venues",
        //                         disabled: true,
        //                     },
        //                 ],
        //                 "value",
        //                 "label",
        //                 true
        //             );
        //         },
        //     });
        // } else {
        //     vappCategoryChoices.clearStore();
        //     vappCategoryChoices.setChoices(
        //         [{ value: "", label: "Select a Category", disabled: false }],
        //         "value",
        //         "label",
        //         true
        //     );
        // }
    });

    // Handle the change event for the VAPP Category select element
    $("body").on("change", "#add_var_category_id", function () {
        console.log("Category ID Changed");
        var varCategoryId = $(this).val();
        var varCategoryText = $(this).find("option:selected").text();
        console.log("Selected Category Text:", varCategoryText);
        // var varMatchId = $(this).val();
        // var  = $("#match_category_id").val();
        var varParkingId = $("#add_var_parking_id").val();

        console.log("Selected Category ID:", varCategoryId);
        console.log("Selected Parking ID:", varParkingId);
        $("#add_requested_vapp_a5").prop("disabled", true);
        $("#add_requested_vapp_a4").prop("disabled", true);
        $("#add_requested_vapp_20").prop("disabled", true);
        $("#add_requested_vapp_hanger").prop("disabled", true);

        if (varCategoryId) {
            $.ajax({
                url: "/get-matches",
                type: "GET",
                data: {
                    parking_id: varParkingId,
                    match_category_id: varCategoryId,
                    // match_id: varMatchId,
                },
                success: function (data) {
                    console.log("data", data);
                    const vappMatchOptions = data.matches.map((item) => ({
                        value: item.id,
                        label: item.match_code_date,
                        selected: item.match_code === "ALL" ? true : false,
                    }));

                    vappMatchChoices.clearStore();
                    vappMatchChoices.setChoices(
                        vappMatchOptions,
                        "value",
                        "label",
                        true
                    );

                    if (data.variation_venues.length > 0) {
                        const vappVenueOptions = data.variation_venues.map(
                            (item) => ({
                                value: item.id,
                                label: item.title,
                            })
                        );

                        vappVenueChoices.clearStore();
                        vappVenueChoices.setChoices(
                            vappVenueOptions,
                            "value",
                            "label",
                            true
                        );
                    }
                },
                error: function () {
                    vappMatchChoices.clearStore();
                    vappMatchChoices.setChoices(
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
            vappMatchChoices.clearStore();
            vappMatchChoices.setChoices(
                [{ value: "", label: "Select a VAPP Sizes", disabled: false }],
                "value",
                "label",
                true
            );
        }
    });

    // Handle the change event for the VAPP Match select element
    $("body").on("change", "#add_var_match_id", function () {
        var varMartchId = $(this).val();
        // var varMatchId = $(this).val();
        var varCategoryId = $("#add_var_category_id").val();
        var varParkingId = $("#add_var_parking_id").val();

        console.log("Selected Match ID:", varMartchId);

        $("#add_requested_vapp_a5").prop("disabled", true);
        $("#add_requested_vapp_a4").prop("disabled", true);
        $("#add_requested_vapp_20").prop("disabled", true);
        $("#add_requested_vapp_hanger").prop("disabled", true);

        if (varMartchId) {
            $.ajax({
                url: "/get-venues",
                type: "GET",
                data: {
                    parking_id: varParkingId,
                    match_id: varMartchId,
                    match_category_id: varCategoryId,
                    // match_id: varMatchId,
                },
                success: function (data) {
                    console.log("data", data);
                    const vappVenueOptions = data.matches.map((item) => ({
                        value: item.venue.id,
                        label: item.venue.title,
                    }));

                    vappVenueChoices.clearStore();
                    vappVenueChoices.setChoices(
                        vappVenueOptions,
                        "value",
                        "label",
                        true
                    );

                    const vappFuncitonalAreaOptions = data.functional_areas.map(
                        (item) => ({
                            value: item.id,
                            label: item.title,
                        })
                    );

                    vappFunctionalAreaChoices.clearStore();
                    vappFunctionalAreaChoices.setChoices(
                        vappFuncitonalAreaOptions,
                        "value",
                        "label",
                        true
                    );
                },
                error: function () {
                    vappVenueChoices.clearStore();
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
            vappVenueChoices.clearStore();
            vappVenueChoices.setChoices(
                [{ value: "", label: "Select a Match", disabled: false }],
                "value",
                "label",
                true
            );
        }
    });

    $("#add_var_functional_area_id").on("change", function () {
        var varMatchId = $("#add_var_category_id").val();
        var varVenueId = $("#add_var_venue_id").val();
        var varParkingId = $("#add_var_parking_id").val();
        console.log("Selected Venue ID:", varVenueId);
        console.log("Selected Parking ID:", varParkingId);
        console.log("Selected Match Category ID:", varMatchId);

        $.ajax({
            url: "/get-variation",
            method: "GET",
            data: {
                parking_id: varParkingId,
                venue_id: varVenueId,
                match_category_id: varMatchId,
            },
            success: function (data) {
                console.log("data", data);
                $("#add_variation_id").val(data.variation.id);
                const vappVappSizeOptions = data.variation.vapp_sizes.map(
                    (item) => ({
                        value: item.id,
                        label: item.title,
                        // selected: item.match_code === "ALL" ? true : false,
                    })
                );

                vappVappSizeChoices.clearStore();
                vappVappSizeChoices.setChoices(
                    vappVappSizeOptions,
                    "value",
                    "label",
                    true
                );
            },
            error: function () {
                vappVappSizeChoices.clearStore();
                vappVappSizeChoices.setChoices(
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

            // success: function (data) {
            //     console.log("Variation:", data);
            //     console.log("Variation:", data.variation);
            //     // use data (e.g., fill form, show data)
            //     if (data.variation === null) {
            //         // alert("Variation not found for the selected criteria.");
            //         toastr.error("Cannot find VAPP Variation, please contact Administrator!");
            //         $("#add_variation_id").val("");
            //         return;
            //     }
            //     console.log(
            //         "Vapp Functoinal Area:",
            //         data.variation.functional_areas
            //     );
            //     $("#add_variation_id").val(data.variation.id);
            //     // dynamically populate the functional area choices

            //     $.each(data.variation.vapp_sizes, function (key, value) {
            //         console.log("Vapp Size Key:", key, "Value:", value);
            //         console.log("Vapp Size Value:", value.title);
            //         if (value.title === "A5") {
            //             $("#add_requested_vapp_a5").prop("disabled", false);
            //         } else {
            //             $("#add_requested_vapp_a5").prop("disabled", true);
            //         }
            //         if (value.title === "A4") {
            //             $("#add_requested_vapp_a4").prop("disabled", false);
            //         } else {
            //             $("#add_requested_vapp_a4").prop("disabled", true);
            //         }
            //         if (value.title === "20x20") {
            //             $("#add_requested_vapp_20").prop("disabled", false);
            //         } else {
            //             $("#add_requested_vapp_20").prop("disabled", true);
            //         }
            //         if (value.title === "Hanger") {
            //             $("#add_requested_vapp_hanger").prop("disabled", false);
            //         } else {
            //             $("#add_requested_vapp_hanger").prop("disabled", true);
            //         }
            //     });
            // },
            // error: function () {
            //     alert("Variation not found");
            //     $("#add_variation_id").val("");
            //     // vappFunctionalAreaChoices.clearStore();
            // },
        });

        // if (varMatchId) {
        //     $.ajax({
        //         url: "/vapp/admin/booking/get/booking/" + varMatchId,
        //         type: "GET",
        //         success: function (data) {
        //             console.log("data", data);
        //             $("#add_var_booking_id").val(data.booking_id);
        //         },
        //         error: function () {
        //             $("#add_var_booking_id").val("");
        //         },
        //     });
        // } else {
        //     $("#add_var_booking_id").val("");
        // }
    });

    //             $.each(data.variation.vapp_sizes, function (key, value) {
    //                 console.log("Vapp Size Key:", key, "Value:", value);
    //                 console.log("Vapp Size Value:", value.title);
    //                 if (value.title === "A5") {
    //                     $("#add_requested_vapp_a5").prop("disabled", false);
    //                 } else {
    //                     $("#add_requested_vapp_a5").prop("disabled", true);
    //                 }
    //                 if (value.title === "A4") {
    //                     $("#add_requested_vapp_a4").prop("disabled", false);
    //                 } else {
    //                     $("#add_requested_vapp_a4").prop("disabled", true);
    //                 }
    //                 if (value.title === "20x20") {
    //                     $("#add_requested_vapp_20").prop("disabled", false);
    //                 } else {
    //                     $("#add_requested_vapp_20").prop("disabled", true);
    //                 }
    //                 if (value.title === "Hanger") {
    //                     $("#add_requested_vapp_hanger").prop("disabled", false);
    //                 } else {
    //                     $("#add_requested_vapp_hanger").prop("disabled", true);
    //                 }
    //             });
    //         },
    //         error: function () {
    //             alert("Variation not found");
    //             vappMatchChoices.clearStore();
    //             vappMatchChoices.setChoices(
    //                 [
    //                     {
    //                         value: "",
    //                         label: "Failed to load venues",
    //                         disabled: true,
    //                     },
    //                 ],
    //                 "value",
    //                 "label",
    //                 true
    //             );
    //         },
    //     });

    //     // if (varMatchId) {
    //     //     $.ajax({
    //     //         url: "/vapp/admin/booking/get/booking/" + varMatchId,
    //     //         type: "GET",
    //     //         success: function (data) {
    //     //             console.log("data", data);
    //     //             $("#add_var_booking_id").val(data.booking_id);
    //     //         },
    //     //         error: function () {
    //     //             $("#add_var_booking_id").val("");
    //     //         },
    //     //     });
    //     // } else {
    //     //     $("#add_var_booking_id").val("");
    //     // }
    // });
});
