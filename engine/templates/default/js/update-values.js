$(document).ready(function() {
    setInterval(updateMails, 2000);
    setInterval(updateNotification, 2000);
});

function updateMails() {
    $.ajax({
        "method": "POST",
        "url": "../index.php?page=ajax&ajax-handle=mails",
        data: {
            "action": "update-mails"
        },
        success: function(data) {
           $(".amount-mails").text(data);
        }
    });
}
function updateNotification() {
    $.ajax({
        "method": "POST",
        "url": "../index.php?page=ajax&ajax-handle=notification",
        data: {
            "action": "update-notification"
        },
        success: function(data) {
            $(".amount-notification").text(data);
        }
    });
}