(function ($) {
    "use strict"; // Start of use strict
    $("#contactForm")
        .validator()
        .on("submit", function (event) {
            if (event.isDefaultPrevented()) {
                // handle the invalid form...
                formError();
                submitMSG(false, "Por favor, preencha todos os campos.");
            } else {
                // everything looks good!
                event.preventDefault();
                submitForm();
            }
        });

    function submitForm() {
        var name = $("#name").val();
        var email = $("#email").val();
        var msg_subject = $("#msg_subject").val();
        var phone_number = $("#phone_number").val();
        var message = $("#message").val();

        $.post({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:  $("#contactForm").attr('action'),
            data:
                "name=" +
                name +
                "&email=" +
                email +
                "&msg_subject=" +
                msg_subject +
                "&phone_number=" +
                phone_number +
                "&message=" +
                message,
            success: function (text) {
                if (text == "success") {
                    formSuccess();
                } else {
                    formError();
                    submitMSG(false, text);
                }
            },
        });
    }

    function formSuccess() {
        $("#contactForm")[0].reset();
        submitMSG(true, "Messagem Enviada! Retornaremos seu contato em breve.");
    }

    function formError() {
        $("#contactForm")
            .removeClass()
            .addClass("shake animated")
            .one(
                "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
                function () {
                    $(this).removeClass();
                }
            );
    }

    function submitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h4 tada animated text-success";
        } else {
            var msgClasses = "h4 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
})(jQuery); // End of use strict
