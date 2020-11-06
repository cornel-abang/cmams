"use strict";
(function ($) {
  $(document).ready(function () {
    if (page_data.client_reg_valid_fail) {
      $("#add-client-form").modal("show");
    }
    if (page_data.case_manager_reg_valid_fail) {
      $("#add-case-manager-form").modal("show");
    }

    if (page_data.report_valid_fail) {
      $("#add-report-form").modal("show");
    }

    $("#entry-table").DataTable({
      ordering: true,
    });

    $(".dataTables_filter input[type='search']").attr("placeholder","Find here...");
    $(".dataTables_filter input[type='search']").addClass("form-control");

    //Select or search
    $(document).ready(function () {
        $('.select-or-search').selectize({
            sortField: 'text'
        });
    });

    //Set call indicator areas and set pointer - rise or drop
    // Viral Load
    setPointer($("#viral-ld-area"), $("#viral-ld-pointer"));
    //Refill
    setPointer($("#refill-area"), $("#refill-pointer"));
    //ICT
    setPointer($("#ict-area"), $("#ict-pointer"));
    //TPT
    setPointer($("#tpt-area"), $("#tpt-pointer"));
    //Tracking
    setPointer($("#tracking-area"), $("#tracking-pointer"));
    //Attendance
    setPointer($("#att-area"), $("#att-pointer"));

    //set leaderbaord toggle menu
    $("#top-4-nav").parent().addClass("shut");
    $("#set").addClass("up");
    //Set indicator pointer - rise or drop
    function setPointer(area, ptr) {
      // convert pointer to string
      let pointer = String($(ptr).data("val"));
      if (pointer.startsWith("-")) {
        $(area).addClass("drop");
        $(area).find("i").addClass("la-caret-down");
      } else if (pointer.startsWith("0")) {
        $(area).addClass("same");
        $(area).find("i").addClass("la-equals");
      } else {
        $(area).addClass("rise");
        $(area).find("i").addClass("la-caret-up");
      }
    }
  });

  // Ajax Call loading screen
  var loading_area = $(".pcoded-main-container");
  $(document).on({
    ajaxStart: function () {
      $(loading_area).addClass("loading");
    },
    ajaxStop: function () {
      $(loading_area).removeClass("loading");
    },
  });

  $(document).on("click", "#close-msg", function (e) {
    e.preventDefault();
    $(this).parent("div").fadeOut(500);
  });

  // toggle to bottom 4 performers
  $(document).on("click", "#btm-4-nav", function (e) {
    e.preventDefault();
    let that = $(this);
    let loader = $("#load");
    let set = $("#set");
    //mimic a sever request
    $(loader).addClass("busy");
    setTimeout(function () {
      $(loader).removeClass("busy");
      $(set).text("(Bottom 4)");
      $(set).removeClass("up");
      $(set).addClass("down");
      $("#top4").fadeOut(400, function () {
        $("#top-4-nav").parent().removeClass("shut");
        $(that).parent().addClass("shut");
        $("#bottom4").fadeIn(400, function () {
          $(this).removeClass("shut");
        });
      });
    }, 3000);
  });
  // toggle to top4 performers
  $(document).on("click", "#top-4-nav", function (e) {
    e.preventDefault();
    let that = $(this);
    let loader = $("#load");
    let set = $("#set");
    //mimic a sever request
    $("#load").addClass("busy");
    setTimeout(function () {
      $(loader).removeClass("busy");
      $(set).text("(Top 4)");
      $(set).removeClass("down");
      $(set).addClass("up");
      $("#bottom4").fadeOut(400, function () {
        $("#btm-4-nav").parent().removeClass("shut");
        $(that).parent().addClass("shut");
        $("#top4").fadeIn(400);
      });
    }, 3000);
  });

  // Delete facility
  $(document).on("click", ".delete-btn-facility", function (e) {
    var handler = $(this);
    var id = handler.attr("id");
    swal({
      title: "Are you sure?",
      text: "This is an irriversible action",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
      if (willDelete.value === true) {
        $.ajax({
          type: "GET",
          url: page_data.routes.destroy_facility,
          data: { id, _token: page_data.csrf_token },
          success: function (data) {
            $(handler)
              .closest("tr")
              .fadeOut(500, function () {
                Swal.fire("Done!", "Client info deleted", "success");
              });
          },
        });
      }
    });
  });

  // Delete case manager
  $(document).on("click", ".delete-btn-cm", function (e) {
    var handler = $(this);
    var manager_id = handler.attr("id");
    var route = handler.attr("aria-data");
    swal({
      title: "Are you sure?",
      text: "This is an irriversible action",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
      if (willDelete.value === true) {
        $.ajax({
          type: "GET",
          url: page_data.routes.destroy_manager,
          data: { id: manager_id, _token: page_data.csrf_token },
          success: function (data) {
            $(handler)
              .closest("tr")
              .fadeOut(500, function () {
                Swal.fire("Done!", "Case Manager info deleted", "success");
              });
          },
        });
      }
    });
  });

  // Delete client
  $(document).on("click", ".delete-btn-client", function (e) {
    var handler = $(this);
    var client_id = handler.attr("id");
    swal({
      title: "Are you sure?",
      text: "This is an irriversible action",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
      if (willDelete.value === true) {
        $.ajax({
          type: "POST",
          url: page_data.routes.destroy_client,
          data: { id: client_id, _token: page_data.csrf_token },
          success: function (data) {
            $(handler)
              .closest("tr")
              .fadeOut(500, function () {
                Swal.fire("Done!", "Client info deleted!", "success");
              });
          },
        });
      }
    });
  });

  // Delete report
  $(document).on("click", ".delete-btn-report", function (e) {
    var handler = $(this);
    var report_id = handler.attr("id");
    swal({
      title: "Are you sure?",
      text: "This is an irriversible action",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
      if (willDelete.value === true) {
        $.ajax({
          type: "POST",
          url: page_data.routes.destroy_report,
          data: { id: report_id, _token: page_data.csrf_token },
          success: function (data) {
            $(handler)
              .closest("tr")
              .fadeOut(500, function () {
                Swal.fire("Done!", "Report info deleted!", "success");
              });
          },
        });
      }
    });
  });

  // Delete tracking report
  $(document).on("click", ".delete-btn-tracking", function (e) {
    var handler = $(this);
    var tracking_id = handler.attr("id");
    swal({
      title: "Are you sure?",
      text: "This is an irriversible action",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
      if (willDelete.value === true) {
        $.ajax({
          type: "POST",
          url: page_data.routes.destroy_tracking,
          data: { id: tracking_id, _token: page_data.csrf_token },
          success: function (data) {
            $(handler)
              .closest("tr")
              .fadeOut(500, function () {
                Swal.fire("Done!", "Tracking info deleted!", "success");
              });
          },
        });
      }
    });
  });

  // select case managers based on facility choosen
  $(document).on("change", ".sel_facility", function () {
    var handler = $(".case_managers_select");
    var route = $(handler).attr("title");
    var facility_id = $(this).val();
    $(handler).empty();
    $(handler).attr("disabled", true);
    $(".loading-img").css("display", "inline");
    $.ajax({
      type: "GET",
      url: page_data.routes.find_case_managers,
      data: { id: facility_id, _token: page_data.csrf_token },
      success: function (data) {
        console.log(data);
        if (data.status) {
          $(handler).attr("disabled", false);
          $(".loading-img").css("display", "none");
          $(handler).append('<option value="">Select case manager</option>');
          data.managers.forEach(function (mg) {
            $(handler).append(
              '<option value="' + mg.id + '">' + mg.name + "</option>"
            );
          });
        }
      },
      global: false,
    });
  });

  // Assign client to case manager frm modal
  $(document).on("change", "#clientIDSearch", function () {
    $(".loading-img").css("display", "inline");
    $(".client-info").fadeOut(500);
    $(".no-match").fadeOut(500);
    $("#assgnBtnArea").fadeOut(500);
    var clientID = $(this).val();
    var facility_id = $("#mg_facility").val();
    $.ajax({
      type: "POST",
      url: page_data.routes.search_client,
      data: { clientID, facility_id, _token: page_data.csrf_token },
      success: function (data) {
        console.log(data);
        if (data.status) {
          $(".loading-img").css("display", "none");
          $(".client-info").css("display", "inline-block");
          $("#assgnBtnArea").fadeIn(500);
          $("#assgnBtnArea").css("display", "inline-block");
          $("#clientName").text(data.client.name);
          $("#clientPhone").text(data.client.phone);
          $("#clientOpc").text(data.client.opc_phone);
          $("#clientAddress").text(data.client.address);
          $("#clientCm").text(data.case_manager);
        } else {
          $(".loading-img").css("display", "none");
          $(".no-match").fadeIn(500);
        }
      },
      global: false,
    });
  });

  $(document).on("keyup", "#case_manager_name", function () {
    var suggestions_area = $("#suggestions");
    $(suggestions_area).empty();
    $("#appts-area").empty();
    var case_mg_name = $(this).val();
    if (case_mg_name !== "") {
      $.ajax({
        type: "GET",
        url: page_data.routes.get_case_manager,
        data: { name: case_mg_name, _token: page_data.csrf_token },
        success: function (res) {
          if (res.status) {
            res.data.forEach(function (sug) {
              $(suggestions_area).append(
                '<tr class="picked" id="' +
                  sug.id +
                  '"><td>' +
                  sug.name +
                  "</td></tr>"
              );
            });
          }
        },
      });
    }
  });

  $(document).on("click", ".picked", function () {
    var case_manager_id = $(this).attr("id");
    var case_manager_name = $(this).text();
    $("#suggestions").empty();
    $("#case_manager_name").val(case_manager_name);
    $("#case_manager_id").val(case_manager_id);
    $.ajax({
      type: "GET",
      url: page_data.routes.verify_appt,
      data: { id: case_manager_id, _token: page_data.csrf_token },
      global: false,
      success: function (res) {
        if (res.length > 0) {
          res.forEach(function (data) {
            $("#appts-area").append(
              "<td>* This case manager had a <b>" +
                data.type +
                "</b> appointment today with <b>" +
                data.client +
                "</b></td>"
            );
          });
        }
      },
    });
  });

  // Sort reports by day
  $(document).on("change", "#report_date", function () {
    var theDay = $(this).val();
    $.ajax({
      type: "GET",
      url: page_data.routes.reports_by_date,
      data: { theDay, _token: page_data.csrf_token },
      success: function (data) {
        if (data.status) {
          Swal.fire(
            Object.keys(data.reports).length +
              " report(s) found on <br>" +
              new Date(theDay).toDateString() +
              "</b>",
            "Loading content now...",
            "success"
          );
          $("#date_sort_form").submit();
        } else {
          Swal.fire(
            "Oops...",
            "Could not find any report on <b>" +
              new Date(theDay).toDateString() +
              "</b>",
            "error"
          );
        }
      },
    });
  });

  //Sort reports by week(s)
  $(document).on("blur", "#report_week", function () {
    var week = $(this).val();
    if (week !== "") {
      $.ajax({
        type: "GET",
        url: page_data.routes.reports_by_week,
        data: { week, _token: page_data.csrf_token },
        success: function (data) {
          if (data.status) {
            Swal.fire(
              Object.keys(data.reports).length +
                " report(s) found <b>" +
                week +
                " week(s) back",
              "Loading content now...",
              "success"
            );
            $("#week_sort_form").submit();
          } else {
            Swal.fire(
              "Oops...",
              "Could not find any report <b>" + week + " week(s) back</b>",
              "error"
            );
          }
        },
      });
    }
  });

  // Sort reports by month
  $(document).on("change", "#report_month", function () {
    var month = $(this).val();
    if (month !== "") {
      $.ajax({
        type: "GET",
        url: page_data.routes.reports_by_month,
        data: { month, _token: page_data.csrf_token },
        success: function (data) {
          if (data.status) {
            Swal.fire(
              Object.keys(data.reports).length +
                " report(s) found for <b>" +
                data.month +
                "</b>",
              "Loading content now...",
              "success"
            );
            $("#month_sort_form").submit();
          } else {
            Swal.fire(
              "Oops...",
              "Could not find any report for <b>" + data.month + "</b>",
              "error"
            );
          }
        },
      });
    }
  });

  // Sort reports by year
  $(document).on("change", "#report_year", function () {
    var year = $(this).val();
    if (year !== "") {
      $.ajax({
        type: "GET",
        url: page_data.routes.reports_by_year,
        data: { year, _token: page_data.csrf_token },
        success: function (data) {
          if (data.status) {
            Swal.fire(
              Object.keys(data.reports).length +
                " report(s) found for year <b>" +
                year +
                "</b>",
              "Loading content now...",
              "success"
            );
            $("#year_sort_form").submit();
          } else {
            Swal.fire(
              "Oops...",
              "Could not find any report for year <b>" + year + "</b>",
              "error"
            );
          }
        },
      });
    }
  });

  $(document).on("change", "#clientID_tracking", function () {
    var userInfo = $("#client_info");
    resetClientInfo(userInfo);
    var clientID = $(this).val();
    if (clientID !== "") {
      $(".loading-img").css("display", "inline");
      $.ajax({
        type: "GET",
        url: page_data.routes.find_client_for_tracking,
        data: { clientID, _token: page_data.csrf_token },
        success: function (data) {
          if (data.status) {
            $(".loading-img").css("display", "none");
            $(userInfo).addClass("la-user");
            $(userInfo).text(data.client.name);
            $("#client_id").val(data.client.id);
          } else {
            $(".loading-img").css("display", "none");
            $(userInfo).removeClass("client-info-on-tracking");
            $(userInfo).removeClass("la-user");
            $(userInfo).addClass("la-user-alt-slash");
            $(userInfo).css("color", "red");
            $(userInfo).text("ID does not match any client");
          }
        },
        global: false,
      });
    }
  });

  function resetClientInfo(userInfo) {
    $(userInfo).removeClass("la-user-alt-slash");
    $(userInfo).text("");
    $("#client_id").val("");
    $(userInfo).removeClass("la-user");
    $(userInfo).css("color", "#4680ff");
    $(userInfo).removeClass("client-info-on-tracking");
  }

  $(document).on("submit", "#tracking_report_form", function (e) {
    e.preventDefault();
    let regBtn = $(".reg-btn");
    let loadBtn = $(".load-btn");
    $(regBtn).css("display", "none");
    $(loadBtn).css("display", "inline");
    $.ajax({
      type: "POST",
      url: page_data.routes.store_tracking_report,
      processData: false,
      contentType: false,
      data: new FormData(this),
      global: false,
      success: function (data) {
        if (data.success === false) {
          $(loadBtn).css("display", "none");
          $(regBtn).css("display", "inline");
          let errors = new Map();
          data.errors.forEach(function (key, val) {
            //set the map like this bcs the order of
            //recieving the vals from the data obj seems to be inverted
            errors.set(val, key);
          });
          if (errors.has(0) && errors.get(0).startsWith("The method field")) {
            $("#val-method").fadeIn(400);
          }
          if (errors.has(1) && errors.get(1).startsWith("The evidence field")) {
            $("#val-evidence").fadeIn(400);
          }
        } else {
          $(loadBtn).css("display", "none");
          $(regBtn).css("display", "inline");
          $(regBtn).text("Done!");
          swal({
            title: "Tracking report saved!",
            text: "Do you want to add another?",
            type: "success",
            showCancelButton: true,
            confirmButtonColor: "#008000",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
          }).then((res) => {
            if (res.value === true) {
              resetSuccess();
            } else {
              window.location.href = page_data.routes.tracking_reports;
            }
          });
        }
      },
    });
  });

  function resetSuccess() {
    let form = document.getElementById("tracking_report_form");
    let formInputs = form.getElementsByClassName("inFld");
    for (const i of formInputs) {
      i.value = "";
    }
    let userInfo = form.getElementsByTagName("small")[0];
    userInfo.innerText = "";
    userInfo.classList.remove("la-user");
    $(".reg-btn").text("Save");
    $("#val-method").css("display", "none");
    $("#val-evidence").css("display", "none");
  }

  //hide play button, display player n autoplay
  $(document).on("click", "#play-evid", function () {
    let wrapper_id = $(this).data("id");
    let wrapper = $("#play-wrapper_" + wrapper_id);
    // reset DOM values for continous use
    resetPlayer(wrapper);
    $(this).fadeOut(400, function () {
      $(wrapper).removeClass("trigger");
      $(".evidence-player").get(0).play();
    });
  });

  //close evidence player
  $(document).on("click", ".cls-player", function () {
    $(this)
      .parent()
      .fadeOut(500, function () {
        $(this).siblings("button").fadeIn(400);
      });
  });

  function resetPlayer(wrapper) {
    $(wrapper).fadeIn();
    $(wrapper).addClass("trigger");
  }

  //view tracking photo evidence modal
  $(document).on("click", "#view-evid-img", function () {
    let img = $(this).data("img");
    let case_manager_name = $(this).data("cm-name");
    let displayModal = $("#evidence-view");
    let displayArea = $("#evidence-img-display");
    $("#cm_name").text(case_manager_name);
    $(displayArea).attr("src", img);
    $(displayModal).modal("show");
  });

  //toggle between single and multple facility file upload
  $(document).on("click", ".single-tab", function(){
    $(this).parent().fadeOut(400, function(){
      $(".single-upload").fadeIn(400);
    });
  });

  //go back to options
  $(document).on("click", ".back-arrow", function(){
    $(this).parent().fadeOut(400, function(){
      $(".options").fadeIn(400);
    });
  });

  $(document).on("click", ".bulk-tab", function(){
    $(this).parent().fadeOut(400, function(){
      $(".bulk-upload").fadeIn(400);
    });
  });

  //check for error while registering facility
  if (page_data.facility_reg_valid_fail.failed) {
      $("#add-facility-form").modal("show");
      if (page_data.facility_reg_valid_fail.msg === 'csv failed') {
        openBulkFrm();
      }else if(page_data.facility_reg_valid_fail.msg === 'single failed'){
        openSingleFrm();
      }
  }

   //check for error while registering client
  if (page_data.client_reg_valid_fail.failed) {
      $("#add-client-form").modal("show");
      if (page_data.client_reg_valid_fail.msg === 'csv failed') {
        openBulkFrm();
      }else if(page_data.client_reg_valid_fail.msg === 'single failed'){
        openSingleFrm();
      }
  }

  function openBulkFrm()
  {
    $(".options").fadeOut(500, function(){
      $(".bulk-upload").fadeIn(500);
    });
  }

  function  openSingleFrm()
  {
    $(".options").fadeOut(1000, function(){
      $(".single-upload").fadeIn(500);
    });
  }
})(jQuery);
