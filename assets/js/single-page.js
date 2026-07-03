(function ($) {
  "use strict";
  let init = {
    createOwnShortcode: function () {
      // show and hide container
      // wrap-input-product
      jQuery(document).mouseup(function (e) {
        let searchWrap = $(".wrap-input-product");
        if (!searchWrap.is(e.target) && searchWrap.has(e.target).length === 0) {
          searchWrap.removeClass("active");
          $(".th-compare-panel-overflow-auto").removeClass(
            "th-compare-panel-overflow-auto"
          );
        }
      });
      // show if have product
      $(document).on(
        "focus",
        'input[name="th-compare-add-id-shortcode"]',
        function () {
          let this_ = $(this);
          this_
            .closest(".panel-wrap.product_data")
            .addClass("th-compare-panel-overflow-auto");
          let getContainer = this_.closest(".th-compare-add-shortcode");

          let getProduct = getContainer.find(".product-result [data-id]");
          if (getProduct.length && this_.val() != "") {
            getContainer.find(".wrap-input-product").addClass("active");
          } else {
            addPRoduct(this_, "focus");
          }
        }
      );
      // text change
      $(document).on(
        "keyup",
        'input[name="th-compare-add-id-shortcode"]',
        function () {
          let thisInput = $(this);
          addPRoduct(thisInput, "keyup");
        }
      );
      // keep 20 product
      function addPRoduct(thisInput, type = "keyup") {
        let addProductWrap = thisInput.closest(".add-product-wrap");
        let addProductSearchWrap = thisInput.closest(".wrap-input-product");
        let added_product_id = addProductWrap.find(".added-product-id");
        let value_ = thisInput.val();
        value_ = value_.length > 1 ? value_ : "";
        addProductSearchWrap.addClass("loading");
        let timeOutTimer = type == "keyup" ? 100 : 0;
        setTimeout(() => {
          $.ajax({
            method: "post",
            url: th_product.tpcp_product_ajax_url,
            data: {
              action: "tpcp_filter_product",
              inputs: value_,
            },
            dataType: "json",
            success: function (response) {
              if (
                response.success &&
                response.data &&
                response.data.length > 0
              ) {
                let list_ = "";
                response.data.map((key_) => {
                  let existId = added_product_id.find(
                    '[data-id="' + key_.id + '"]'
                  );
                  let list_class = "";
                  if (existId.length) {
                    list_class = "checked";
                  }

                  let Wrapper_ =
                    '<span class="' +
                    list_class +
                    '" data-id="' +
                    key_.id +
                    '">';
                  if (key_.image_url != 0) {
                    Wrapper_ +=
                      "<div class='img_'><img src='" +
                      key_.image_url +
                      "'></div>";
                  }
                  Wrapper_ += "<span>" + key_.label + "</span>";
                  Wrapper_ += "</span>";
                  list_ += Wrapper_;
                });

                addProductSearchWrap.addClass("active");
                addProductSearchWrap.find(".product-result").html(list_);
                addProductSearchWrap.removeClass("loading");
              } else if (response.data.no_product) {
                addProductSearchWrap.removeClass("loading");
                let list_ =
                  '<span class="th-no-product-found">' +
                  response.data.no_product +
                  "</span>";
                addProductSearchWrap.find(".product-result").html(list_);
              }
            },
          });
        }, timeOutTimer);
      }
      // add and remove
      $(document).on("click", ".product-result [data-id]", addAndREmove);
      function addAndREmove() {
        let btn = $(this);
        let getContainer = btn.closest(".th-compare-add-shortcode");
        let getID = btn.attr("data-id");
        if (getID) {
          if (btn.hasClass("checked")) {
            btn.removeClass("checked");
            getContainer
              .find(".added-product-id")
              .find("[data-id='" + getID + "']")
              .remove();
          } else {
            btn.addClass("checked");
            let btnTxt = btn.text();
            if (btnTxt.length >= 15) {
              btnTxt = btnTxt.substr(0, 14);
            }
            let html_ =
              '<span class="added_id" data-id="' +
              getID +
              '"><span class="dashicons dashicons-dismiss rm_"></span><span class="p_title">' +
              btnTxt +
              "</span></span>";
            getContainer.find(".added-product-id").append(html_);
          }
          addidIninput();
        }
      }
      // only remove
      $(document).on("click", ".added-product-id [data-id] .rm_", onlyREmove);
      function onlyREmove() {
        let btn = $(this);
        let getID = btn.closest("[data-id]");
        if (getID.attr("data-id")) {
          let id_ = getID.attr("data-id");
          btn
            .closest(".th-compare-add-shortcode")
            .find('.product-result [data-id="' + id_ + '"]')
            .removeClass("checked");
          getID.remove();
          addidIninput();
        }
      }
      // change_input
      addidIninput();
      function addidIninput() {
        let container = $(".th-compare-add-shortcode");
        $.each(container, function () {
          let container = $(this);
          let getIds = container.find(".added-product-id").find("[data-id]");
          let saveText = "";
          $.each(getIds, (key_, val_) => {
            let span_ = $(val_);
            let put_id = span_.attr("data-id");
            let put_id_text = put_id + "-" + span_.text();
            if (saveText == "") {
              saveText += put_id_text;
            } else {
              saveText += "|" + put_id_text;
            }
          });
          // get if shortcode

          // in hidden input
          container.find(".put-in-input-hidden").val(saveText);
        });
      }
      //   chenge auto manual
      $(document).on(
        "change",
        "select.tpcp_choose_product_auto_manual",
        function () {
          let getvalue = $(this);
          let getvalue_val = getvalue.val();
          let wrap_ = $(".th_custom_tab_product_option .hide_show_wrap");
          if (getvalue_val == "manual") {
            wrap_.addClass("active");
          } else {
            wrap_.removeClass("active");
          }
        }
      );
      //   chenge auto manual
      // createOwnShortcode
    },
  };
  init.createOwnShortcode();
})(jQuery);
