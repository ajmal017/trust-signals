$(document).ready(function() {
    /* REMOVE */
    $("body").on("click", ".remove-order", function() {
        if(confirm("Удалить данный платеж?")) {
            var id = $(this).attr("data-id"),
                packId = $(this).attr("data-package"),
                me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=orders",
                type: "POST",
                data: {
                    "action" : "remove-order",
                    "id": id
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".order-" + id).addClass("supp-danger");
                        me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                        me.removeClass("label-danger").addClass("label-default").removeClass("remove-order");
                        $(".confirm-order[data-id=" + id + "]").remove();
                        showMessage("Платеж был успешно удален");
                    }
                    else {
                        showMessage("Произошла ошибка при удалении платежа");
                    }
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                }
            });
        }
    });
    /* CONFIRM */
    $("body").on("click", ".confirm-order", function() {
        if(confirm("Подтвердить данный платеж?")) {
            var id = $(this).attr("data-id"),
                packId = $(this).attr("data-package"),
                me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=orders",
                type: "POST",
                data: {
                    "action" : "confirm-order",
                    "id": id,
                    "package": packId
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".order-" + id).addClass("supp-success");
                        $(".status-order-" + id).html("<span class='label label-success'>Оплачен <span class='glyphicon glyphicon-ok'></span></span>");
                        me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                        me.removeClass("label-success").addClass("label-default").removeClass("confirm-order");
                        showMessage("Платеж был успешно подтвержден");
                    }
                    else {
                        showMessage("Произошла ошибка при подтверждении платежа");
                    }
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                }
            });
        }
    });
});