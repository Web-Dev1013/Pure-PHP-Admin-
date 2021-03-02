$(function () {
  //  Init define
  var params = new URL(window.location).searchParams;
  var url_entry_code = params.get('un');
  var url_password = params.get('pw');
  var url_access_code = params.get('ac');
  // if(username == null && password == null && code == null)
  // {
  //     username = "user";
  //     password = "user$%_!^12345";
  //     code = "user_12345";
  // }
  $("#entry_code").val(url_entry_code);
  $("#password").val(url_password);
  $("#access_code").val(url_access_code);

  $("#login").on("click", function () {
    if ($("#entry_code").val() != "") {
      if ($("#password").val() != "") {
        if ($("#access_code").val() != "") {
          var entry_code = $("#entry_code").val();
          var password = $("#password").val();
          var access_code = $("#access_code").val();
          $.ajax({
            url: "model/auth_model.php",
            type: "POST",
            data: {
              type: "login",
              entry_code: entry_code,
              password: password,
              access_code: access_code
            },
            success: function (res) {
              console.log(res)
              if (res == "failed_user") {
                $(".alert-danger .notification").html("Incorrect user code.");
                $(".alert-danger").addClass("alert-active");
                setTimeout(function () {
                  $(".alert-danger").removeClass("alert-active");
                }, 1500);
              } else if (res == "failed_access_code") {
                $(".alert-danger .notification").html("Incorrect access info.");
                $(".alert-danger").addClass("alert-active");
                setTimeout(function () {
                  $(".alert-danger").removeClass("alert-active");
                }, 1500);
              }else{
                $(".alert-success .notification").html("Successfully logged in.");
                $(".alert-success").addClass("alert-active");
                setTimeout(function () {
                  $(".alert-success").removeClass("alert-active");
                  // window.location.href = "index.php";
                }, 1500);
              }
            }
          });
        } else {
          $(".alert-danger .notification").html("Please input access code.");
          $(".alert-danger").addClass("alert-active");
          setTimeout(function () {
            $(".alert-danger").removeClass("alert-active");
          }, 1500);
        }
      } else {
        $(".alert-danger .notification").html("Please input password");
        $(".alert-danger").addClass("alert-active");
        setTimeout(function () {
          $(".alert-danger").removeClass("alert-active");
        }, 1500);
      }
    }else{      
      $(".alert-danger .notification").html("Please input entry code.");
      $(".alert-danger").addClass("alert-active");
      setTimeout(function () {
        $(".alert-danger").removeClass("alert-active");
      }, 1500);
    }
  });
});