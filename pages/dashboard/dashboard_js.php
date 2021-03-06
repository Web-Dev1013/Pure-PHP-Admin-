<script>
  $(function() {

    // When load, get user survey page data
    var value_arr = [];
    var base_url = "https://localhost/admin/";
    $.ajax({
      url: base_url + "model/dashboard_model.php",
      type: "POST",
      data: {
        type: "get_survey_page_data"
      },
      async: false,
      success: function(res) {
        window.localStorage.setItem("sp_data", res);
        res = JSON.parse(res);
        var sp_data_package = "";
        for (x in res) {
          var sp_data = '<div id="page_' + res[x][0]["page_id"] + '" class="page d-none"><p class="h1 text-gold font-weight-bold">' + res[x][0]["page_name"] + '</p><p class="h5 pb-3 text-gold font-weight-bold">' + res[x][0]["tagline"] + '</p>';
          var thead_data = "";
          var tbody_data = "";
          var tfoot_data = "";
          var value_sum = 0;
          var total_value = Number(res[x][0]["value_load"]);

          for (y in res[x]) {
            value_arr.push(res[x][y]["value"]);
            if (res[x][y]["flag_id"] == 1) {
              thead_data = "<div class='page-table'><table id='table_" + x + "' class='table table-hover'><thead><tr id='" + res[x][y]["id"] + "'><td><img src='" + base_url + "admin/assets/image/page1/" + res[x][y]["icon_url"] + "' width='30px' height='30px'></td><td>" + res[x][y]["name"] + "<p class='sup t mb-0 text-gold'>" + res[x][y]["category_code"] + "</p></td><td><span class='sp_current'> " + (res[x][y]["currency"] == undefined ? " " : res[x][y]["currency"]) + " </span></td><td><input type='text' class='value w-50 form-control' value='" + res[x][y]["value_load"] + "'></td><td><span class='page_unit sup'>" + res[x][y]["unit"] + "</span></td></tr></thead><tbody class='row_position'>";
            }
            if (res[x][y]["flag_id"] == 0) {
              value_sum += Number(res[x][y]["value_load"]);
              tbody_data += "<tr id='" + res[x][y]["id"] + "'><td><img src='" + base_url + "admin/assets/image/page1/" + res[x][y]["icon_url"] + "' width='30px' height='30px'></td><td>" + res[x][y]["name"] + "<p class='sup mb-0 text-gold'>" + res[x][y]["category_code"] + "</p></td><td><span class='sp_current'> " + (res[x][y]["currency"] == undefined ? " " : res[x][y]["currency"]) + " </span></td><td class='value'>" + res[x][y]["value_load"] + "</td><td><span class='page_unit sup'>" + res[x][y]["unit"] + "</span></td></tr>";
            }
            if (res[x][y]["flag_id"] == 2) {
              tfoot_data = "</tbody><tfoot><tr id='" + res[x][y]["id"] + "'><td><i class='fas fa-question-circle fa-2x text-gold'></i></td><td>" + res[x][y]["name"] + "<p class='sup mb-0 text-gold'>" + res[x][y]["category_code"] + "</p></td><td><span class='sp_current'> " + (res[x][y]["currency"] == undefined ? " " : res[x][y]["currency"]) + " </span></td><td class='value'>" + (total_value - value_sum) + "</td><td><span class='page_unit sup'>" + res[x][y]["unit"] + "</span></td></tr></tfoot></table>";
            }
          }

          sp_data += thead_data + tbody_data + tfoot_data;
          sp_data += '</div><div class="py-3"><p class="h5 text-gold"><i>Recommend a category not covered above?</i></p><div class="d-flex"><input type="text" class="form-control w-50 text-center recommend border-gold" id="page' + x + '_category" name="page' + x + '_category" placeholder="Type category and press plus to recommend" autocomplete="off"><span class="px-2 py-1 text-gold add_category" id="page' + x + '_add_category"><i class="fa fa-plus-circle fa-2x"></i></span></div></div><div class="py-3"><p class="h5 text-gold"><i>Feedback you would like to share?</i></p><textarea rows="4" class="w-75 border-gold p-2 text-dark page-feedback" id="page' + x + '_feedback" placeholder="We value and appreciate your feedback."></textarea></div><div class="pt-4"><button class="btn btn-warning prev"><i class="fa fa-arrow-left"></i><span class="px-2"> Back </span></button><button class="btn btn-warning next px-4 float-right"><span class="font-weight-bold"> Next </span><i class="fa fa-arrow-right"></i></button></div></div>';
          sp_data_package += sp_data;
        }
        $(".content").html(sp_data_package);
        $(".page").eq(0).removeClass("d-none");
        $(".page:eq(0) .prev").hide();
        new AutoNumeric.multiple('.value', {
          currencySymbol: "",
          caretPositionOnFocus: "start",
          modifyValueOnWheel: false,
          decimalCharacter: ".",
          digitGroupSeparator: ",",
          decimalPlaces: 2
        });
      }
    });

    // Input value in input box of first row
    $(".table thead input[type=text]").on("change", function(e) {
      if ($(this).val() != "") {
        var value_sum = 0;
        for (var x = 0; x < $(e.target).parents("table").find("tbody").find("tr").length; x++) {
          value_sum += Number($(e.target).parents("table").find("tbody").find("tr:eq(" + x + ")").find(".value").html());
        }
        var sub_value = Number($(this).val()) - value_sum;
        $(e.target).parents("table").find("tfoot").find(".value").html(sub_value);
        new AutoNumeric.multiple('.value', {
          currencySymbol: "",
          caretPositionOnFocus: "start",
          modifyValueOnWheel: false,
          decimalCharacter: ".",
          digitGroupSeparator: ",",
          decimalPlaces: 2
        });
        $.ajax({
          url: base_url + "model/dashboard_model.php",
          type: "POST",
          data: {
            type: "change_value",
            category_id: $(e.target).parents("tr").attr("id"),
            value: $(this).val()
          }
        })
      } else {
        $(".alert-danger .notification").html("The total value can't be empty. Please fill input field.");
        $(".alert-danger").addClass("alert-active");
        setTimeout(function() {
          $(".alert-danger").removeClass("alert-active");
        }, 1500);
      }
    });

    var page_num = 0;
    $(".content").on("click", function(e) {
      if ($(e.target).hasClass("next") == true || $(e.target).parent().hasClass("next") == true || $(e.target).parents("button").hasClass("next") == true) {
        if (page_num >= $(".page").length - 1) {
          var flag = false;
          for (var i = 0; i < $(".page-feedback").length; i++) {
            if ($(".page-feedback:eq(" + i + ")").val() != "") {
              flag = true;
              $.ajax({
                url: base_url + "model/dashboard_model.php",
                type: "POST",
                data: {
                  type: "feedback-submit",
                  feedback: $(".page-feedback:eq(" + i + ")").val(),
                  page_id: $(e.target).parents(".page").attr("id").split("_")[1]
                },
                async: false
              });
            }
          }
          if (flag == true) {
            $(".alert-success").html("Thank You. Thank you for your responses.");
            $(".alert-success").addClass("alert-active");
            setTimeout(function() {
              $(".alert-success").removeClass("alert-active");
            }, 1500);
          } else {
            $(".alert-danger .notification").html("Please leave any feedback.");
            $(".alert-danger").addClass("alert-active");
            setTimeout(function() {
              $(".alert-danger").removeClass("alert-active");
            }, 1500);
          }
        } else {
          page_num++;
          $(".page").addClass("d-none");
          $(".page:eq(" + page_num + ")").removeClass("d-none");
          if (page_num == $(".page").length - 1) {
            $(".next").children("span").html("Submit ");
            $(".next").attr("id", "submit");
          }
        }
      }
      if ($(e.target).hasClass("prev") == true || $(e.target).parent().hasClass("prev") == true || $(e.target).parents("button").hasClass("prev") == true) {
        if (page_num <= 0) {
          $(".page:eq(" + page_num + ") .prev").hide();
        } else {
          page_num--;
          $(".next").children("span").html("Next ")
          $(".page").addClass("d-none");
          $(".page:eq(" + page_num + ")").removeClass("d-none");
        }
      }
    });

    //category add event
    $(".content").on("click", function(e) {
      if ($(e.target).parent().hasClass("add_category") == true || $(e.target).parents("span").hasClass("add_category") == true) {
        if ($(".recommend:eq(" + page_num + ")").val() != "") {
          $.ajax({
            url: base_url + "model/dashboard_model.php",
            type: "POST",
            data: {
              type: "add_category",
              page_id: $(e.target).parents(".page").attr("id").split("_")[1],
              recommend: $(e.target).parents(".page").find(".recommend").val()
            },
            success: function(res) {
              if (res == "success") {
                $(".alert-success .notification").html("Successfully saved.");
                $(".alert-success").addClass("alert-active");
                setTimeout(function() {
                  $(".recommend").val("");
                  $(".alert-success").removeClass("alert-active");
                }, 1500);
              }
            }
          });
        } else {
          $(".alert-danger .notification").html("Please fill recommend field.");
          $(".alert-danger").addClass("alert-active");
          setTimeout(function() {
            $(".recommend").val("");
            $(".alert-danger").removeClass("alert-active");
          }, 1500);
        }
      }
    });

    //logout event
    // $("#logout").on("click", function(e) {
    //   e.preventDefault();
    //   $.ajax({
    //     url: "model/auth_model.php",
    //     type: "post",
    //     data: {
    //       type: "logout"
    //     },
    //     success: function(res) {
    //       if (res == "success") {
    //         window.location.href = "/php/index.php";
    //       }
    //     }
    //   });
    // });

    $(window).on("mouseenter", function(e) {
      if ($(e.target).parents("table").hasClass("table-hover") == true) {
        $(e.target).parents("tbody tr").find(".text-gold").css("color", "white");
      }
    });
    $(window).on("mouseleave", function(e) {
      if ($(e.target).parents("table").hasClass("table-hover") == true) {
        $(e.target).parents("tbody tr").find(".text-gold").css("color", "#d0aa3c");
      }
    });


  });
</script>