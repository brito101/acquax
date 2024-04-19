$(document).ready(function () {
    $(".acquax-date").inputmask("dd/mm/yyyy");
    $("#year_ref").inputmask("9999");
    $("#total_days").inputmask("integer", {
        min: 1,
        max: 31,
        rightAlign: false,
    });
    $(".money_format_2").inputmask("currency", {
        autoUnmask: true,
        radixPoint: ",",
        groupSeparator: ".",
        allowMinus: false,
        prefix: "R$ ",
        digits: 2,
        digitsOptional: false,
        rightAlign: true,
        unmaskAsNumber: true,
    });
    $(".money_format_3").inputmask("currency", {
        autoUnmask: true,
        radixPoint: ",",
        groupSeparator: ".",
        allowMinus: false,
        prefix: "R$ ",
        digits: 3,
        digitsOptional: false,
        rightAlign: true,
        unmaskAsNumber: true,
    });

    let kiteCarGroup = $(".kite_car");
    let kitCarContainer = $("#kitCarContainer").data("value");
    if (kitCarContainer == "Sim") {
        kiteCarGroup.show();
    } else {
        kiteCarGroup.hide();
    }

    $("#kite_car").on("change", function () {
        if (this.value == "Sim") {
            kiteCarGroup.show();
        } else {
            kiteCarGroup.hide();
        }
    });

    /** Tax */
    $("[data-consumption_ranges]").hide();
    let consumption_ranges = $("#consumption_ranges");
    if (consumption_ranges.val() == 2) {
        $("[data-consumption_ranges=2]").show();
    }
    if (consumption_ranges.val() == 3) {
        $("[data-consumption_ranges=2]").show();
        $("[data-consumption_ranges=3]").show();
    }
    if (consumption_ranges.val() == 4) {
        $("[data-consumption_ranges=2]").show();
        $("[data-consumption_ranges=3]").show();
        $("[data-consumption_ranges=4]").show();
    }
    if (consumption_ranges.val() == 5) {
        $("[data-consumption_ranges=2]").show();
        $("[data-consumption_ranges=3]").show();
        $("[data-consumption_ranges=4]").show();
        $("[data-consumption_ranges=5]").show();
    }
    if (consumption_ranges.val() == 6) {
        $("[data-consumption_ranges=2]").show();
        $("[data-consumption_ranges=3]").show();
        $("[data-consumption_ranges=4]").show();
        $("[data-consumption_ranges=5]").show();
        $("[data-consumption_ranges=6]").show();
    }
    consumption_ranges.on("change", function () {
        $("[data-consumption_ranges]").hide();
        if (consumption_ranges.val() == 2) {
            $("[data-consumption_ranges=2]").show();
        }
        if (consumption_ranges.val() == 3) {
            $("[data-consumption_ranges=2]").show();
            $("[data-consumption_ranges=3]").show();
        }
        if (consumption_ranges.val() == 4) {
            $("[data-consumption_ranges=2]").show();
            $("[data-consumption_ranges=3]").show();
            $("[data-consumption_ranges=4]").show();
        }
        if (consumption_ranges.val() == 5) {
            $("[data-consumption_ranges=2]").show();
            $("[data-consumption_ranges=3]").show();
            $("[data-consumption_ranges=4]").show();
            $("[data-consumption_ranges=5]").show();
        }
        if (consumption_ranges.val() == 6) {
            $("[data-consumption_ranges=2]").show();
            $("[data-consumption_ranges=3]").show();
            $("[data-consumption_ranges=4]").show();
            $("[data-consumption_ranges=5]").show();
            $("[data-consumption_ranges=6]").show();
        }
    });
});
