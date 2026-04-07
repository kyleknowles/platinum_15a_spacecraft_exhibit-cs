function download() {
    date = new Date()

    $.ajax({
        async: false,
        type: "POST",
        url: "download.php",
        success: function(msg) {
            alert("Download data successfully")
                // alert(msg)

        },
        error: function(msg) {
            alert("error");
        },


    });
}