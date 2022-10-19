$(document).ready(function () {
    $(".acquax-date").inputmask("dd/mm/yyyy");
    $("#year_ref").inputmask("9999");

    const player = document.getElementById("player");
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    const captureButton = document.getElementById("capture");
    const hidden = document.getElementById("cover_base64");
    const constraints = {
        video: {
           facingMode: 'environment',
        },
    };
    captureButton.addEventListener("click", (e) => {
        e.preventDefault();
        context.drawImage(player, 0, 0, canvas.width, canvas.height);
        hidden.value = canvas.toDataURL("image/jpeg", 0.5);
    });
    navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
        player.srcObject = stream;
    });
});
