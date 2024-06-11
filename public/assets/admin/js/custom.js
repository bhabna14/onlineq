/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

/* ***************************************************************
  ==========disabling default behave of form submits start==========
  *****************************************************************/

  $("#ajaxForm").attr("onsubmit", "return false");

  /* *************************************************************
  ==========disabling default behave of form submits end==========
  ***************************************************************/

  /* ***************************************************
    ==========Form Submit with AJAX Request Start==========
    ******************************************************/

  $(document).on("click", "#submitBtn", function (e) {
      $(e.target).attr("disabled", true);
      $(".request-loader").addClass("show");

      let ajaxForm = document.getElementById("ajaxForm");
      let fd = new FormData(ajaxForm);
      let url = $("#ajaxForm").attr("action");
      let method = $("#ajaxForm").attr("method");

      $.ajax({
          url: url,
          method: method,
          data: fd,
          contentType: false,
          processData: false,
          success: function (data) {
              $(e.target).attr("disabled", false);
              $(".request-loader").removeClass("show");

              $(".em").each(function () {
                  $(this).html("");
              });

              if (data.status === "success") {
                  location.href = data.url;
              }

              else if (data == "success") {
                  location.reload();
              }

              // if error occurs
              else if (typeof data.error != "undefined") {
                  for (let x in data) {
                      if (x == "error") {
                          continue;
                      }
                      if (x.includes(".")) {
                          document
                              .getElementById(x.replace(/\./g, ""))
                              .insertAdjacentHTML(
                                  "afterend",
                                  `<p class="mb-0 text-danger em">${data[x][0]}</p`
                              );
                      } else {
                          document.getElementById("err" + x).innerHTML =
                              data[x][0];
                      }
                  }
              }
          },
          error: function (error) {
              $(".request-loader").removeClass("show");
              $(e.target).attr("disabled", false);

              $(".em").each(function () {
                  $(this).html("");
              });

              for (let x in error.responseJSON.errors) {
                  if (x.includes(".")) {
                      document
                          .getElementById(x.replace(/\./g, ""))
                          .insertAdjacentHTML(
                              "afterend",
                              `<p class="mb-0 text-danger em">${error.responseJSON.errors[x][0]}</p`
                          );
                  } else {
                      document.getElementById("err" + x).innerHTML =
                          error.responseJSON.errors[x][0];
                  }
              }
          },
      });
  });

  /* ***************************************************
  ==========Form Submit with AJAX Request End==========
  ******************************************************/

  /* ***************************************************
    ==========Form Update with AJAX Request Start==========
    ******************************************************/

  function ajaxEditForm(button_id) {
      $("#" + button_id).attr("disabled", false);
      $(".request-loader").addClass("show");

      let btnarr = button_id.split("_");
      let idNo = btnarr[1];
      let ajaxEditForm = document.getElementById("ajaxEditForm_" + idNo);
      let fd = new FormData(ajaxEditForm);
      let url = $("#ajaxEditForm_" + idNo).attr("action");
      let method = $("#ajaxEditForm_" + idNo).attr("method");

      $.ajax({
          url: url,
          method: method,
          data: fd,
          contentType: false,
          processData: false,
          success: function (data) {
              $("#" + button_id).attr("disabled", false);
              $(".request-loader").removeClass("show");

              $(".em").each(function () {
                  $(this).html("");
              });

              if (data == "success") {
                  location.reload();
              }

              // if error occurs
              else if (typeof data.error != "undefined") {
                  for (let x in data) {
                      if (x == "error") {
                          continue;
                      }
                      document.getElementById("eerr" + x + "_" + idNo).innerHTML =
                          data[x][0];
                  }
              }
          },
          error: function (error) {
              $(".request-loader").removeClass("show");
              $("#" + button_id).attr("disabled", false);

              $(".em").each(function () {
                  $(this).html("");
              });

              for (let x in error.responseJSON.errors) {
                  document.getElementById("eerr" + x + "_" + idNo).innerHTML =
                      error.responseJSON.errors[x][0];
              }
          },
      });
  }

  /****************************************************
  ==========Form Update with AJAX Request End==========
  ****************************************************/

  /* ***************************************************************
    ==========Form Prepopulate After Clicking Button Start==========
    ***************************************************************/

  $(document).on("click", ".editBtn", function () {
      let datas = $(this).data();
      delete datas["toggle"];

      $(".em").each(function () {
          $(this).html("");
      });

      for (let x in datas) {
          $("#in" + x).val(datas[x]);
      }
  });

  /* *************************************************************
  ==========Form Prepopulate After Clicking Button End============
  ***************************************************************/

  /*  Input box for numbers only start  */

  function isNumber(evt) {
      var iKeyCode = evt.which ? evt.which : evt.keyCode;
      if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
          toastr.info("Please enter only numeric value.");
          return false;
      } else {
          return true;
      }
  }

  /*  Input box for numbers only end  */

  /* ***************************************************************
    ==========disabling default behave of form submits start==========
    *****************************************************************/
  $(document.getElementsByClassName("ajaxForm")).attr("onsubmit", "return false");
  /* *************************************************************
      ==========disabling default behave of form submits end==========
      ***************************************************************/

  /* ***************************************************
        ==========Form Submit with AJAX Request Start==========
        ******************************************************/
  $(document).on("click", ".submitBtn", function (e) {
      $(e.target).attr("disabled", true);

      $(".request-loader").addClass("show");

      let ajaxForm = $(e.target).parent().closest("form");
      let fd = new FormData(ajaxForm[0]);
      let url = ajaxForm.attr("action");
      let method = ajaxForm.attr("method");

      $.ajax({
          url: url,
          method: method,
          data: fd,
          contentType: false,
          processData: false,
          success: function (data) {
              $(e.target).attr("disabled", false);
              $(".request-loader").removeClass("show");

              $(".em").each(function () {
                  $(this).html("");
              });

              if (data == "success") {
                  location.reload();
              }

              // if error occurs
              else if (typeof data.error != "undefined") {
                  for (let x in data) {
                      if (x == "error") {
                          continue;
                      }
                      // ajaxForm.find("[name='" + x + "']").next('.em').html(data[x][0]);
                      ajaxForm
                          .find("[name='" + x + "']")
                          .after(
                              `<p class="mb-0 text-danger em">${data[x][0]}</p`
                          );
                  }
              }
          },
          error: function (error) {
              $(".request-loader").removeClass("show");
              $(e.target).attr("disabled", false);

              $(".em").each(function () {
                  $(this).html("");
              });
              for (let x in error.responseJSON.errors) {
                  // ajaxForm.find("[name='" + x + "']").next('.em').html(error.responseJSON.errors[x][0]);
                  ajaxForm
                      .find("[name='" + x + "']")
                      .after(
                          `<p class="mt-0 mb-0 text-danger em">${error.responseJSON.errors[x][0]}</p`
                      );
              }
          },
      });
  });

  /* ***************************************************
      ==========Form Submit with AJAX Request End==========
      ******************************************************/
