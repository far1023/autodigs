const renderPage = (url, containerID) => {
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function () {
            $("#" + containerID).html(
                "<span class='spinner-border spinner-border-sm'></span> Memuat..."
            );
        },
        success: function (res) {
            $("#" + containerID).html(res);
        },
        error: function (err) {
            $("#" + containerID).html("Terjadi kesalahan");
            console.error(err);
        },
    });
};
