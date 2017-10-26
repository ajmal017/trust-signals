$(document).ready(function() {
  var isOpenAjax = true;
  $(".save-package-includes").submit(function(e) {
    e.preventDefault();
    if(isOpenAjax) {
      isOpenAjax = false;
      var $that = $(this),
          formData = new FormData($that[0]),
          btn = $that.find("button"),
          btnVal = $(btn).html();
      $(btn).html("<span class='fa fa-spin fa-spinner'></span> " + btnVal);
      formData.append("action", "save");
      $.ajax({
        url : "/index.php?page=ajax&ajax-handle=includes",
        data : formData,
        method : "POST",
        processData: false,
        contentType: false,
        success : function(data) {
          console.log(data);
          $(btn).html(btnVal);
          isOpenAjax = true;
          showMessage("Данные сохранены");
        },
        fail : function() {
          $(btn).html(btnVal);
          isOpenAjax = true;
          showMessage("Проверьте соединение с интернетом");
        }
      });
    }
  });
});
