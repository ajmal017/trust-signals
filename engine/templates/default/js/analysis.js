$(document).ready(function() {
    setInterval(updatePairs, 30000);
    function updatePairs() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=pairs",
            data: {
                action: "show"
            },
            success: function(data) {
                $(".pairs-box").html(data);
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }
});