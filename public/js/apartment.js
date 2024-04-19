$(document).ready(function () {
    $.mask.definitions['~'] = '([0-9])?';
    $("#fraction").inputmask("~99,999%");
});
