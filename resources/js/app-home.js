$("#advertisementModalButton").click();
$(".notification").on("click", function (e) {
    e.preventDefault();
    $.post({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: $(this).attr("href"),
        success: function (res) {
            if (res == true) {
                e.target.text = "Marcar como não lido";
            } else {
                e.target.text = "Marcar como lido";
            }
        },
    });
});
