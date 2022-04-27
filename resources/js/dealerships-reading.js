$(document).ready(function () {
    $(".acquax-date").inputmask("dd/mm/yyyy");
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
});
