$(function () {
    $.magnificPopup.open({
        items: {
            src: "#new-phones-modal",
            type: "inline",
        },
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: "auto",
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: "mpf-new-phones-popup",
    });
});
