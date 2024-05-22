const renderPage = (url, containerID) => {
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function () {
            $("#" + containerID).html(
                "<div class='text-center'><span class='spinner-border spinner-border-sm'></span> Memuat...</div>"
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
