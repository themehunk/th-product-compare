(function ($) {
  let thCompare = {
    init: function () {
      thCompare.bind();
    },
    // getPrevId: function (cookieNAme) {
    //   const getCookie = document.cookie;
    //   const splitted = getCookie.split(";");
    //   const getThCompare = splitted.find((getStr) =>
    //     getStr.includes(cookieNAme)
    //   );
    //   if (getThCompare) {
    //     const getPRoductId = getThCompare.split("=");
    //     if (getPRoductId.length > 1 && getPRoductId[1]) {
    //       return getPRoductId[1].split(",");
    //     }
    //   }
    // },
    // setId: function (id, openPopup = false) {
    //   const date = new Date();
    //   date.setDate(date.getDate() + 1);
    //   const expires = date.toUTCString();
    //   const cookieNAme = "th_compare_product";
    //   let previousCookie = thCompare.getPrevId(cookieNAme);
    //   let cookieValue = id;
    //   let updateCookie = true;
    //   if (previousCookie) {
    //     let getExist = previousCookie.find((id_) => id_ == id);
    //     if (getExist) {
    //       cookieValue = previousCookie.join(",");
    //       updateCookie = false;
    //     } else {
    //       cookieValue = previousCookie.join(",") + "," + id;
    //     }
    //   }
    //   //   update cookies
    //   if (updateCookie) {
    //     document.cookie =
    //       cookieNAme + "=" + cookieValue + "; expires=" + expires + ";";
    //   }
    //   //   open popup
    //   thCompare.openAndaddPopup(cookieValue);
    // },
    addProduct: function (e) {
      e.preventDefault();
      let thisBtn = $(this);
      let getProductId = thisBtn.attr("data-th-product-id");
      if (parseInt(getProductId)) {
        thCompare.openAndaddPopup(getProductId);
      }
    },
    openAndaddPopup: function (ids = "") {
      let html =
        '<div class="th-compare-output-wrap" id="th-compare-output-wrap">';
      html += '<div class="th-compare-output-wrap-inner">';
      html +=
        "<div class='th-compare-output-close'><span class='dashicons dashicons-no-alt'></span></div>";
      html += '<div class="th-compare-output-product">';

      html += "</div>"; //th-compare-output-product
      html += "</div>"; //th-compare-output-wrap-inner
      html += "</div>"; //th-compare-output-wrap
      if ($(".th-compare-output-wrap").length) {
        $(".th-compare-output-wrap").remove();
      }
      $("body").append(html);
      thCompare.getOrUpdatePRoducts(ids);
    },
    // updateProduct
    getOrUpdatePRoducts: function (ids) {
      // th-compare-output-product
      console.log("ids->", ids);
      console.log("url->", th_product.th_product_ajax_url);
      $.ajax({
        method: "post",
        url: th_product.th_product_ajax_url,
        data: { action: "th_get_compare_product", product_id: ids },
        success: function (response) {
          console.log("response->", response);
        },
      });
    },
    removeCompare: function (e) {
      let closebtn = $(this);
      let getWrap = closebtn.closest(".th-compare-output-wrap");
      getWrap.addClass("th-compare-output-wrap-close");
      setTimeout(() => {
        getWrap.remove();
      }, 500);
    },
    bind: function () {
      $(document).on("click", ".th-product-compare-btn", thCompare.addProduct);
      $(document).on(
        "click",
        ".th-compare-output-wrap .th-compare-output-close",
        thCompare.removeCompare
      );
    },
  };
  thCompare.init();
})(jQuery);

{
  /* <div class="th-compare-output-wrap" id="th-compare-output-wrap"><div class="th-compare-output-wrap-inner"><div class="th-compare-output-close"><span class="dashicons dashicons-no-alt"></span></div><div class="th-compare-output-product"></div></div></div> */
}

// console.log("current cookiew", document.cookie);

// var delete_cookie = function (name) {
//   document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
// };
// delete_cookie("th_compare_product");
