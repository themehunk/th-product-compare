(function ($) {
  let thCompare = {
    init: function () {
      // console.log(
      //   "th_compare_style_local ->",
      //   th_product.th_compare_style_local
      // );

      thCompare.bind();
    },
    addStyle: function () {
      let style_ = th_product.th_compare_style_local;
      if (style_) {
        let styleAdd = "";
        for (let getKey in style_) {
          // console.log("getKey->", getKey);
          // console.log("getKey style_ ->", style_[getKey]);

          if (getKey == "compare-heading-text") {
            $(
              ".th-compare-output-wrap .th-compare-heading > span.heading_"
            ).html(style_[getKey]);
          }
          // set style
          else if (getKey == "fore-ground-bgth-idbackground-color") {
            styleAdd +=
              ".th-compare-output-wrap{background-color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "dummy-border-colorth-idborder-color") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-output-wrap-inner{border-color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "heading-styleth-idbackground-color") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-heading{background-color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "heading-styleth-idcolor") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-heading > span{color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "row-odd-bgth-idbackground-color") {
            styleAdd +=
              ".th-compare-output-product .product-table-configure tr:nth-child(odd) td,.th-compare-output-product .product-table-configure tr:nth-child(odd) td.left-title{background-color:" +
              style_[getKey] +
              ";}";
            styleAdd +=
              ".th-compare-output-product .product-table-configure tr:nth-child(odd) td.left-title{opacity:.7;}";
          } else if (getKey == "row-even-bgth-idbackground-color") {
            styleAdd +=
              ".th-compare-output-product .product-table-configure tr:nth-child(even) td,.th-compare-output-product .product-table-configure tr:nth-child(even) td.left-title{background-color:" +
              style_[getKey] +
              ";}";
            styleAdd +=
              ".th-compare-output-product .product-table-configure tr:nth-child(even) td.left-title{opacity:.7;}";
          } else if (getKey == "rating-colorth-idcolor") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-rating{color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "remove-btn-colorth-idcolor") {
            styleAdd +=
              ".th-compare-output-product .product-table-configure .th-compare-product-remove{color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "close-btn-styleth-idbackground-color") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-output-close i{background-color:" +
              style_[getKey] +
              ";}";
          } else if (getKey == "close-btn-styleth-idcolor") {
            styleAdd +=
              ".th-compare-output-wrap .th-compare-output-close i{color:" +
              style_[getKey] +
              ";}";
          }
        }

        // add css //
        if (styleAdd && !$("style#th-compare-style-head").length) {
          let style_Append =
            '<style id="th-compare-style-head">' + styleAdd + "</style>";
          $("head").append(style_Append);
        }
        // add css //
      }
    },
    addProduct: function (e) {
      e.preventDefault();
      let thisBtn = $(this);
      let getProductId = thisBtn.attr("data-th-product-id");
      if (parseInt(getProductId)) {
        thCompare.openAndaddPopup(getProductId);
      }
    },
    removeProduct: function (e) {
      e.preventDefault();
      let thisBtn = $(this);
      let getProductId = thisBtn.attr("data-th-product-id");
      if (parseInt(getProductId)) {
        thisBtn
          .closest(".th-compare-output-wrap-inner")
          .stop()
          .animate({ scrollTop: 0 }, 500, "swing", function () {
            // console.log("Finished animating");
          });
        // $(".th-compare-output-wrap-inner")
        //   .stop()
        //   .animate({ scrollTop: 0 }, 500, "swing", function () {
        //     alert("Finished animating");
        //   });
        thisBtn.closest(".th-compare-output-wrap").addClass("th-loading");
        thCompare.getOrUpdatePRoducts(getProductId, "remove");
      }
    },
    loaderIcon: function () {
      return '<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 32 32" height="32" viewBox="0 0 32 32" width="32"><path d="m16 6.001v2.999c0 .369.203.708.527.883.147.078.311.118.473.118.193 0 .387-.057.555-.168l6-4.001c.278-.186.445-.497.445-.831 0-.335-.167-.646-.445-.832l-6-4c-.307-.206-.703-.225-1.025-.05-.327.174-.53.513-.53.882v3c-6.617 0-12 5.383-12 12 0 .552.448 1 1 1s1-.448 1-1c0-5.515 4.486-10 10-10zm2-3.132 3.197 2.132-3.197 2.131zm9 12.132c-.552 0-1 .447-1 1 0 5.516-4.486 10-10 10v-3.001c0-.369-.203-.707-.528-.882s-.72-.155-1.026.05l-6 4c-.279.186-.446.498-.446.832s.167.646.445.832l6 4c.168.111.361.168.555.168.162 0 .324-.039.472-.118.325-.174.528-.513.528-.882v-3c6.617 0 12-5.383 12-11.999 0-.553-.448-1-1-1zm-13 14.13-3.197-2.131 3.197-2.131z" fill="#222"/></svg>';
    },
    openAndaddPopup: function (ids = "") {
      let html =
        '<div class="th-compare-output-wrap th-loading" id="th-compare-output-wrap">';
      html += '<div class="th-compare-output-wrap-inner">';
      html += '<div class="th-compare-heading">';
      html += "<span class='heading_'>COMPARE PRODUCTS</span>";
      html += "<span class='error_'></span>";
      html +=
        "<div class='th-compare-output-close'><i class='dashicons dashicons-no-alt'></i></div>";
      html += "</div>";
      html +=
        '<div class="th-compare-loader">' + thCompare.loaderIcon() + "</div>";
      html += '<div class="th-compare-output-product">';

      html += "</div>"; //th-compare-output-product
      html += "</div>"; //th-compare-output-wrap-inner
      html += "</div>"; //th-compare-output-wrap
      if ($(".th-compare-output-wrap").length) {
        $(".th-compare-output-wrap").remove();
      }
      $("body").append(html);
      $("body").addClass("th_product_Compare_body_Class");
      thCompare.getOrUpdatePRoducts(ids, "add");
      thCompare.addStyle();
    },
    // updateProduct
    getOrUpdatePRoducts: function (ids, action_) {
      // th-compare-output-product
      // console.log("ids->", ids);
      // console.log("url->", th_product.th_product_ajax_url);
      $.ajax({
        method: "post",
        url: th_product.th_product_ajax_url,
        data: {
          action: "th_get_compare_product",
          product_id: ids,
          add_remove: action_,
        },
        dataType: "json",
        success: function (response) {
          console.log("response->", response);

          if (response.no_product == "1") {
            let getWrap = $(".th-compare-output-wrap");
            getWrap.addClass("th-compare-output-wrap-close");
            setTimeout(() => {
              getWrap.remove();
            }, 500);
            $("body").removeClass("th_product_Compare_body_Class");
          } else {
            $(".th-compare-output-product").html(response.html);
            // error show
            if (response.product_limit) {
              $(".th-compare-heading .error_").html(response.product_limit);
            }
            thCompare.containerScroll();
            $(".th-compare-output-wrap").removeClass("th-loading");
          }
        },
      });
    },
    containerScroll: function () {
      // scrollll
      // $(".th-compare-output-wrap-inner").scroll(function (ev) {
      //   let container = $(this);
      //   let getTop = container.scrollTop();
      //   container.find(".top-title td").css("top", getTop + "px");
      // });
      $(".th-compare-output-product").scroll(function (event) {
        let container = $(this);
        let getLeft = container.scrollLeft();
        container.find("td.left-title").css("left", getLeft + "px");
      });
      // scrollll
    },
    removeCompare: function () {
      let closebtn = $(this);
      let getWrap = closebtn.closest(".th-compare-output-wrap");
      getWrap.addClass("th-compare-output-wrap-close");
      setTimeout(() => {
        getWrap.remove();
      }, 500);
      $("body").removeClass("th_product_Compare_body_Class");
    },
    bind: function () {
      $(document).on("click", ".th-product-compare-btn", thCompare.addProduct);
      $(document).on(
        "click",
        ".th-compare-product-remove",
        thCompare.removeProduct
      );
      $(document).on(
        "click",
        ".th-compare-output-wrap .th-compare-output-close",
        thCompare.removeCompare
      );
    },
  };
  thCompare.init();
})(jQuery);
