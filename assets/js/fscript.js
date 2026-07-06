(function ($) {
  "use strict";
  function tpcpParseCountText(template, count) {
  if (!template) return count;

  return template.replace(/\{([^}]+)\}/g, function (match, text) {
    if (text.toLowerCase().trim() === 'count') {
      return count;
    }
    return text;
  });
}
let TPCP_COMPARE_LIMIT = null;
  var tpcpSearchTimer = null;
  let thCompare = {
    updateCompareLimitUI: function () {
  if (!TPCP_COMPARE_LIMIT) return;

  let count = $(".product_image > div.img_").not(".empty-slot").length;
  let limitReached = count >= TPCP_COMPARE_LIMIT;
  let customTooltip = (th_product.th_compare_style_local && th_product.th_compare_style_local['compare-limit-tooltip']) ? th_product.th_compare_style_local['compare-limit-tooltip'] : '';
  let tooltipText = customTooltip ? customTooltip.replace(/\{limit\}/gi, TPCP_COMPARE_LIMIT) : "You can add up to " + TPCP_COMPARE_LIMIT + " products to compare.";

  // Update count display
  $(".th-compare-limit-count .th-current-count").text(count);
  if (TPCP_COMPARE_LIMIT) {
    $(".th-compare-limit-count .th-max-count").text(TPCP_COMPARE_LIMIT);
  }
  $(".th-compare-limit-count").toggleClass("limit-reached", limitReached);

  // Tooltip on count
  let countTooltip = limitReached
    ? tooltipText
    : count + " of " + TPCP_COMPARE_LIMIT + " products added";
  $(".th-compare-limit-count").attr("data-th-tooltip", countTooltip);

  // Footer add button
  $(".th-add-product-bar").toggleClass("disabled", limitReached);

  // Product compare buttons
  $(".th-product-compare-btn")
    .not(".th-added-compare")
    .not(".checkbox_type")
    .toggleClass("disabled", limitReached)
    .each(function () {
      if (limitReached) {
        $(this).attr("data-th-tooltip", tooltipText);
        $(this).addClass("th-tooltip-active");
      } else {
        $(this).removeAttr("data-th-tooltip");
        $(this).removeClass("th-tooltip-active");
      }
    });

  // Checkboxes
  $(".th-compare-checkbox")
    .not(":checked")
    .prop("disabled", limitReached)
    .each(function () {
      let wrapper = $(this).closest(".th-product-compare-btn");
      if (limitReached && !$(this).is(":checked")) {
        wrapper.attr("data-th-tooltip", tooltipText);
        wrapper.addClass("th-tooltip-active disabled");
      } else {
        wrapper.removeAttr("data-th-tooltip");
        wrapper.removeClass("th-tooltip-active disabled");
      }
    });
},

    init: function () {
      thCompare.bind();
      if ($(".th-compare-filter-shortcode").length) {
        thCompare.addStyle();
      }
      thCompare.containerScroll();
      thCompare.toolTip();
       if (!$(".th-compare-output-wrap-inner").length) {                                                                                                              
      thCompare.openAndaddPopup("refresh", false);                                                                                                                 
      }    
      thCompare.popupOpener();
    },
    updateCompareEnableState: function () {
  let count = $(".product_image > div.img_").not(".empty-slot").length;
  let compareBtn = $(".th-compare-enable");

  if (count > 1) {
    compareBtn.addClass("active").removeClass("disabled");
  } else {
    compareBtn.removeClass("active").addClass("disabled");
  }
},

    customAttrKeepSame: function () {
      let getCustomAttrs = $(".th-compare-output-product .product-table-configure tr.th-custom-attr");
      if (!getCustomAttrs.length > 1) return;
      for (let i = 0; i < getCustomAttrs.length; i++) {
        const attrRow = $(getCustomAttrs[i]);
        const rowTitle = $.trim(attrRow.find(".left-title > span").text());
        const attrTds = attrRow.find("td");
        const table = attrRow.closest(".product-table-configure");
        const compareRow = table.find("tr.th-custom-attr");
        for (let i2 = 0; i2 < compareRow.length; i2++) {
          if (i2 > i) {
            const row2 = $(compareRow[i2]);
            const compareRowTitle = $.trim(row2.find(".left-title > span").text());
            if (compareRowTitle == rowTitle) {
              let findTd = row2.find("td");
              $.each(findTd, function (index) {
                let td = $(this);
                if (td.find(".attr-avail").length) {
                  let find1rowTd = $(attrTds[index]);
                  find1rowTd.html(td.html());
                }
              });
              row2.remove();
            }
          }
        }
      }
    },
    popupOpener: function () {
  $(document).on("click", ".th-footer-up-down", function () {
    let button = $(this);
    button.closest(".th-compare-footer-wrap").toggleClass("active");
  });

  $(document).on("click", ".th-compare-footer-product-opner", function (e) {
    e.preventDefault();

    let button = $(this);
    button.toggleClass("active");

    let popupWrap = $(".th-compare-output-wrap");
    if (popupWrap.hasClass("active")) {
      popupWrap.addClass("th-compare-output-wrap-close").removeClass("active");
      $("body").removeClass("th_product_Compare_body_Class");
    } else {
      popupWrap.removeClass("th-compare-output-wrap-close").addClass("active");
      $("body").addClass("th_product_Compare_body_Class");
    }

    $('.product-table-configure tr').each(function () {
      if (!$(this).hasClass('_image_')) {
        var shouldRemove = true;
        $(this).find('td').not('.left-title').each(function () {
          var spanText = $(this).find('span, div, p').text().trim();
          if (spanText !== '' && spanText !== '-') {
            shouldRemove = false;
            return false;
          }
        });
        if (shouldRemove) {
          var hasAddToCartButton = $(this).find('.th-compare-add-to-cart-btn').length > 0;
          if (!hasAddToCartButton) $(this).remove();
        }
      }
    });

    /* =====================================================
       SAFE ADDITION – WRAP FIRST 4 TR INTO ONE TBODY
       (Does NOT affect existing logic)
    ====================================================== */

    // let table = $('.product-table-configure');
    // let tbodies = table.find('tbody');

    // // Only wrap once (prevents duplication on multiple clicks)
    // if (tbodies.length === 1) {
    //   let originalTbody = tbodies.first();
    //   let firstFourRows = originalTbody.find('tr:lt(5)');

    //   if (firstFourRows.length === 5) {
    //     let newTbody = $('<tbody class="th-first-wrap"></tbody>');
    //     firstFourRows.appendTo(newTbody);
    //     originalTbody.before(newTbody);
    //   }
    // }

    /* ================= END SAFE ADDITION ================= */
  });
},

    addProduct: function (e) {
      e.preventDefault();
      let thisBtn = $(this);
      let getProductId = thisBtn.attr("data-th-product-id");
      if (parseInt(getProductId)) {
        if (thisBtn.hasClass("th-added-compare")) {
          if ($(".product-table-configure").length && $(".th-compare-footer-wrap").length && $("[data-product-id='" + getProductId + "']").length) {
            $(".th-compare-footer-wrap").addClass("active");
            return;
          } else if ($(".without-footer-bar").length) {
            $(".th-compare-output-wrap-close").removeClass("th-compare-output-wrap-close");
            $(".thcompare-open-by-popup .th-compare-output-wrap").addClass("active");
            return;
          }
        }
        thisBtn.addClass("loading");
        if (thisBtn.hasClass("th-single-page")) {
          thCompare.getOrUpdatePRoducts(getProductId, "single_page", thisBtn);
        } else {
          thCompare.openAndaddPopup(getProductId, thisBtn);
        }
      }
    },
toggleCheckbox: function (e) {
  let checkbox = $(this);
  let productId = checkbox.data('th-product-id');
  if (!productId || isNaN(parseInt(productId))) {
    return;
  }
  productId = parseInt(productId);
  let action = checkbox.is(':checked') ? 'add' : 'remove';
  let wrapper = checkbox.closest('.th-product-compare-btn-wrap');
  wrapper.find('.th-product-compare-btn').toggleClass('th-added-compare', checkbox.is(':checked'));
  checkbox.addClass('loading'); // Add loading class to label
  checkbox.prop('disabled', true); // Disable checkbox during AJAX
  thCompare.getOrUpdatePRoducts(productId, action, checkbox);
},
    removeAllProduct: function (e) {
      e.preventDefault();
      thCompare.getOrUpdatePRoducts('refresh', "removeall");
    },
    removeProduct: function (e) {
      e.preventDefault();
      let thisBtn = $(this);
      let getProductId = thisBtn.attr("data-th-product-id");
      if (parseInt(getProductId)) {
        thisBtn.closest(".th-compare-output-wrap-inner").stop().animate({ scrollTop: 0 }, 500, "swing");
        thisBtn.closest(".th-compare-output-wrap").addClass("th-loading");
        thCompare.getOrUpdatePRoducts(getProductId, "remove", thisBtn);
      }
    },
 openAndaddPopup: function (ids = "", thisBtn) {
  let ExistCompare = $("#th-compare-output-wrap");
  if (ExistCompare.length) ExistCompare.remove();
  let html = '<div class="thcompare-open-by-popup">';
  html += '<div class="th-compare-output-wrap th-loading" id="th-compare-output-wrap">';
  html += '<div class="th-compare-output-wrap-inner">';
  html += '<div class="th-compare-heading">';
  html += "<div class='headingwrap'><span class='heading_'>" + th_product.headingtext + "</span></div>";
  html += "<span class='error_'></span>";
  html += "<div class='th-compare-output-close'><i class='dashicons dashicons-no-alt'></i></div>";
  html += "</div>";
  html += thCompare.loaderIcon();
  html += '<div class="th-compare-output-product">';
  html += "</div>";
  html += "</div>";
  html += "</div>";
  html += "</div>";
  if ($(".thcompare-open-by-popup").length) $(".thcompare-open-by-popup").remove();
  $("body").append(html);
  thCompare.getOrUpdatePRoducts(ids, "add", thisBtn);
  thCompare.addStyle();
},

updateMenuTabBadge: function () {
  let badge = $("#th-compare-menu-tab .th-menu-tab-badge");
  if (!badge.length) return;
  let count = $(".product_image > div.img_").not(".empty-slot").length;
  badge.text(count);
  badge.toggleClass("active", count > 0);
},

menuIconClick: function (e) {
  e.preventDefault();
  e.stopPropagation();
  let compareWrap = $(".thcompare-open-by-popup .th-compare-output-wrap");
  if (compareWrap.length) {
    if (compareWrap.hasClass("active")) {
      compareWrap.addClass("th-compare-output-wrap-close").removeClass("active");
      $("body").removeClass("th_product_Compare_body_Class");
    } else {
      compareWrap.removeClass("th-compare-output-wrap-close").addClass("active");
      $("body").addClass("th_product_Compare_body_Class");
    }
  }
},

updateMenuIcon: function () {
  let count = $(".product_image > div.img_").not(".empty-slot").length;
  let widgets = $(".th-compare-icon-widget");
  if (widgets.length) {
    let badge = widgets.find(".th-compare-icon-widget-count");
    if (count > 0) {
      badge.text(count).show();
    } else {
      badge.hide();
    }
  }
},

updateCompareCount: function () {

  let count = $(".product_image > div.img_").not(".empty-slot").length;

  // 🔹 user saved text from admin
  let template = '';
  if (
    typeof th_product !== "undefined" &&
    th_product.th_compare_style_local &&
    th_product.th_compare_style_local["compare-count-text"]
  ) {
    template = th_product.th_compare_style_local["compare-count-text"];
  }

  // fallback
  if (!template) {
    template = "{count} items shown";
  }

  let finalText = tpcpParseCountText(template, count);

  let countSpan = $(".th-compare-heading .th-compare-count");

  if (!countSpan.length) {
    $(".th-compare-heading .headingwrap")
      .append('<span class="th-compare-count">' + finalText + '</span>');
  } else {
    countSpan.html(finalText);
  }
},

getOrUpdatePRoducts: function (ids, action_, thisBtn = false) {
  $(".thcompare-open-by-popup .th-compare-output-wrap").addClass("th-loading");
  $(".th-compare-footer-wrap").addClass("loading");
  $.ajax({
    method: "post",
    url: th_product.tpcp_product_ajax_url,
    data: {
      action: "tpcp_get_compare_product",
      product_id: ids,
      add_remove: action_,
    },
    dataType: "json",
    success: function (res) {


      let response = res.data;
            if (response.compare_limit && !TPCP_COMPARE_LIMIT) {
  TPCP_COMPARE_LIMIT = parseInt(response.compare_limit);
}
      if (thisBtn) {
        thisBtn.prop('disabled', false); // Re-enable checkbox or button
        thisBtn.removeClass("loading");
      }
      if (response == "all_removed") {
        $(".thcompare-open-by-popup,.th-compare-footer-wrap,#th-compare-menu-tab,#th-compare-icon-wrap").remove();
        $('.th-compare-checkbox').prop('checked', false).closest('.th-product-compare-btn').removeClass('th-added-compare');
        return;
      }
      if (response.refresh == "single_page") {
        $("thcompare-open-by-popup").remove();
        return;
      }
      if (action_ == "remove") {
        // Update all checkboxes and labels with matching product ID
        let allCheckboxes = $('.th-compare-checkbox[data-th-product-id="' + ids + '"]');
        let allLabels = $('.th-product-compare-btn[data-th-product-id="' + ids + '"]');
        allCheckboxes.prop('checked', false);
        allLabels.removeClass('th-added-compare');
        let remainingItems = $(".product_image > div:not(.empty-slot)").length;
        if (remainingItems <= 1) {
          thCompare.getOrUpdatePRoducts('refresh', "removeall");
          return;
        }
      }
      if (thisBtn && action_ == "add" && !thisBtn.hasClass("th-added-compare") && !thisBtn.is('.th-compare-checkbox')) {
        thisBtn.addClass("th-added-compare");
        let checkbox = thisBtn.find('.th-compare-checkbox[data-th-product-id="' + ids + '"]');
        if (checkbox.length) {
          checkbox.prop('checked', true);
        }
      }
      if ((action_ == "single_page" || response.single_page == "1") && parseInt(ids)) {
        if (response.url) {
          window.open(response.url, "_blank");
        }
        return;
      }
      if (response.no_product == "1") {
        let getWrap = $(".thcompare-open-by-popup");
        getWrap.find(">div").addClass("th-compare-output-wrap-close");
        setTimeout(() => {
          getWrap.remove();
          $(".th-compare-footer-wrap").remove();
          $(".th-add-more-product-container").remove();
        }, 500);
        $("body").removeClass("th_product_Compare_body_Class");
        $('.th-compare-checkbox').prop('checked', false).closest('.th-product-compare-btn').removeClass('th-added-compare');
      } else {
        let addHighlight = response.add_highlights ? response.add_highlights : "";
        // $(".thcompare-open-by-popup .th-compare-output-product").html(addHighlight + response.html);
         $(".thcompare-open-by-popup .th-compare-output-product").html(response.html);

        // Add scroll class when 4+ products for slide indicator
        var $mobileTable = $(".product-table-configure.mobile-flex");
        if ($mobileTable.length) {
          var productCount = $mobileTable.find("tr:first td:not(.left-title)").length;
          if (productCount > 3) {
            $mobileTable.addClass("_has-scroll");
          } else {
            $mobileTable.removeClass("_has-scroll");
          }
          if (productCount === 2) {
            $mobileTable.addClass("_two-products");
          } else {
            $mobileTable.removeClass("_two-products");
          }

          // Sync horizontal scroll across all rows on mobile
          var syncScrollRAF = null;
          var isSyncing = false;
          var allRows = $mobileTable.find("tr").toArray();
          allRows.forEach(function (row) {
            row.addEventListener("scroll", function () {
              if (isSyncing) return;
              var source = this;
              var sl = source.scrollLeft;
              if (syncScrollRAF) cancelAnimationFrame(syncScrollRAF);
              syncScrollRAF = requestAnimationFrame(function () {
                isSyncing = true;
                for (var i = 0; i < allRows.length; i++) {
                  if (allRows[i] !== source) {
                    allRows[i].scrollLeft = sl;
                  }
                }
                isSyncing = false;
                syncScrollRAF = null;
              });
            }, { passive: true });
          });
        }

        thCompare.customAttrKeepSame();
        let availFooter = false;
        if (response.footer_bar && response.footer_bar != "") {
          let footer_bar = $(".th-compare-footer-wrap");
          if (footer_bar.length) footer_bar.remove();
          $("body").append(response.footer_bar);
          $(".th-compare-footer-wrap > div").append(thCompare.loaderIcon());
          if (parseInt(ids)) {
            setTimeout(() => {
              $(".th-compare-footer-wrap").addClass("active");
            }, 500);
          }
          availFooter = true;
        }
        if (response.menu_tab && response.menu_tab !== "") {
          let existing_menu_tab = $("#th-compare-menu-tab");
          if (existing_menu_tab.length) existing_menu_tab.remove();
          $("body").append(response.menu_tab);
          setTimeout(() => {
            $("#th-compare-menu-tab").addClass("active");
          }, 500);
        }
        if (response.compare_icon && response.compare_icon !== "") {
          let floatingWrap = $("#th-compare-icon-wrap");
          if (floatingWrap.length) {
            floatingWrap.find(".th-compare-icon-widget").replaceWith(response.compare_icon);
          }
        }
        thCompare.updateMenuTabBadge();
        thCompare.updateMenuIcon();
        if (response.product_limit) {
          $(".th-compare-heading .error_").html(response.product_limit);
        }
        if (response.category) {
          let existCateg = $(".th-compare-heading .wrap-category_");
          if (existCateg.length) existCateg.remove();
          $(".th-compare-heading").append(response.category);
        }

        /* ✅ ADD THIS BLOCK */
if (response.add_highlights) {
  let existHighlight = $(".th-compare-heading .th-heighlights-products");
  if (existHighlight.length) existHighlight.remove();
  $(".th-compare-heading").append(response.add_highlights);
}

thCompare.updateCompareCount();

thCompare.updateCompareEnableState();

thCompare.updateCompareLimitUI();



        let openOutputContainer = $(".thcompare-open-by-popup .th-compare-output-wrap");
        openOutputContainer.removeClass("th-loading");
        $(".th-compare-footer-wrap").removeClass("loading");
        if (parseInt(ids) && !availFooter && !openOutputContainer.hasClass("active")) {
          setTimeout(() => {
            openOutputContainer.addClass("active");
          }, 200);
        }
        setTimeout(() => {
          thCompare.containerScroll();
          thCompare.toolTip();
        }, 500);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX error:", textStatus, errorThrown);
      if (thisBtn) {
        thisBtn.prop('disabled', false);
        thisBtn.removeClass("loading");
      }
      $(".thcompare-open-by-popup .th-compare-output-wrap").removeClass("th-loading");
      $(".th-compare-footer-wrap").removeClass("loading");
      $(".th-compare-heading .error_").html("Error adding/removing product. Please try again.");
    }
  });
},
    showByCategory: function (e) {
      e.preventDefault();
      let this_btn = $(this);
      let categoryBtn = this_btn.attr("data-compare-category");
      this_btn.siblings("a").removeClass("active");
      this_btn.addClass("active");
      if (categoryBtn) {
        let all_ = $(".thcpr-by-all");
        if (all_.length) all_.hide();
        let show_ = $(".thcpr-by-" + categoryBtn);
        if (show_.length) show_.show();
      }
    },
    removeCompare: function () {
      let closebtn = $(this);
      let getWrap = closebtn.closest(".thcompare-open-by-popup");
      getWrap.find(".th-compare-output-wrap").addClass("th-compare-output-wrap-close").removeClass("active");
      $(".th-compare-footer-product-opner").removeClass("active");
      $("body").removeClass("th_product_Compare_body_Class");
    },
    addMorePopup: function (e) {
      e.preventDefault();
      let existContainer = $(".th-add-more-product-container");
      if (!existContainer.length) {
        let popupAddMore = '<div class="th-add-more-product-container active">';
        popupAddMore += '<div class="th-add-more-product-inner">';
        popupAddMore += '<div class="th-search-product">';
        popupAddMore += '<span class="remove_search_popup dashicons dashicons-no"></span>';
        popupAddMore += '<div class="th-search-product-input">';
        popupAddMore += '<input type="text" placeholder="Product Title...">';
        popupAddMore += "</div>";
        popupAddMore += '<div class="th-search-product-input-result">';
        popupAddMore += "</div>";
        popupAddMore += "</div>";
        popupAddMore += "</div>";
        popupAddMore += "</div>";
        $("body").append(popupAddMore);
        thCompare.footerSEarch();
        thCompare.removeAddmorePopup();
      } else {
        existContainer.addClass("active");
      }
    },
    removeAddmorePopup: function () {
      $(document).mouseup(function (e) {
        let searchWrap = $(".th-add-more-product-container");
        let inner = searchWrap.find(".th-add-more-product-inner");
        if (!inner.is(e.target) && inner.has(e.target).length === 0) {
          searchWrap.removeClass("active");
        }
      });
      $(document).on("click", ".remove_search_popup", function () {
        let button_ = $(this);
        let searchWrap = button_.closest(".th-add-more-product-container");
        searchWrap.removeClass("active");
      });
    },
    footerSEarch: function () {
      let container_ = $(".th-add-more-product-container");
      if (container_.length) {
        container_.find(".th-search-product-input >input").keyup(function () {
          let this_input = $(this);
          if (tpcpSearchTimer) clearTimeout(tpcpSearchTimer);
          tpcpSearchTimer = setTimeout(function () {
            thCompare.addPRoduct(this_input);
          }, 500);
        });
      }
    },
    addPRoduct: function (thisInput) {
      let addProductWrap = thisInput.closest(".th-add-more-product-inner");
      let putResult = addProductWrap.find(".th-search-product-input-result");
      let added_product_id = $(".th-compare-footer-wrap .product_image");
      addProductWrap.addClass("loading");
      let value_ = thisInput.val();
      value_ = value_.length > 1 ? value_ : "";
      $.ajax({
        method: "post",
        url: th_product.tpcp_product_ajax_url,
        data: {
          action: "tpcp_filter_product",
          inputs: value_,
        },
        dataType: "json",
        success: function (response) {
          if (response.success && response.data && response.data.length > 0) {
            let list_ = "";
            response.data.map((key_) => {
              let existId = added_product_id.find('[data-product-id="' + key_.id + '"]');
              let list_class = existId.length ? "th-compare-external-popup-open checked" : "th-compare-external-popup-open";
              let Wrapper_ = '<span class="' + list_class + '" data-id="' + key_.id + '">';
              if (key_.image_url != 0) {
                Wrapper_ += "<div class='img_'><img src='" + key_.image_url + "'></div>";
              }
              Wrapper_ += "<span>" + key_.label + "</span>";
              Wrapper_ += "</span>";
              list_ += Wrapper_;
            });
            putResult.html(list_);
            addProductWrap.removeClass("loading");
          }
        },
      });
    },
    addMorePopupClick: function (e) {
      let thisBtn_ = $(this);
      let productId = thisBtn_.attr("data-id");
      if (productId) {
        thCompare.getOrUpdatePRoducts(productId, "add", thisBtn_);
        thisBtn_.addClass("checked");
      }
    },
    highlightDifference: function () {
      let thisBtn = $(this);
      let getInner = thisBtn.closest(".th-compare-output-wrap-inner");
      if (thisBtn.hasClass("active")) {
        getInner.find("tr.th-difference-row").removeClass("th-difference-row");
        thisBtn.removeClass("active");
        return;
      }
      thisBtn.addClass("active");
      let getRow = getInner.find(".product-table-configure").find("tr").not("._image_,._add-to-cart_,.th-add-to-cart,.th-delete");
      if (getRow.length) {
        $.each(getRow, function () {
          let row_ = $(this);
          let getTd = row_.find("td").not(".left-title");
          if (getTd.length) {
            let firstTd = $(getTd[0]).html();
            $.each(getTd, function () {
              let currentTd = $(this).html();
              if (firstTd !== currentTd) {
                row_.addClass("th-difference-row");
                return false;
              }
            });
          }
        });
      }
    },
    hideDifference: function () {
      let thisBtn = $(this);
      let getInner = thisBtn.closest(".th-compare-output-wrap-inner");
      if (thisBtn.hasClass("active")) {
        getInner.find("tr.th-hide-difference-row").removeClass("th-hide-difference-row");
        thisBtn.removeClass("active");
        return;
      }
      thisBtn.addClass("active");
      let getRow = getInner.find(".product-table-configure").find("tr").not("._image_,._add-to-cart_,.th-add-to-cart,.th-delete");
      if (getRow.length) {
        $.each(getRow, function () {
          let row_ = $(this);
          let getTd = row_.find("td").not(".left-title");
          if (getTd.length) {
            let firstTd = $(getTd[0]).html();
            let addHideInSimilar = true;
            $.each(getTd, function () {
              let currentTd = $(this).html();
              if (firstTd !== currentTd) {
                addHideInSimilar = false;
                return false;
              }
            });
            if (addHideInSimilar) {
              row_.addClass("th-hide-difference-row");
            }
          }
        });
      }
    },
    bind: function () {
      $(document).on(
  "click",
  ".th-product-compare-btn:not(.checkbox_type)",
  function (e) {
    if ($(this).hasClass("disabled")) {
      e.preventDefault();
      $(".th-compare-heading .error_")
        .text("Maximum compare limit reached")
        .fadeIn();
      setTimeout(() => $(".th-compare-heading .error_").fadeOut(), 2500);
      return false;
    }
    thCompare.addProduct.call(this, e);
  }
);

      $(document).on("change", ".th-compare-checkbox", thCompare.toggleCheckbox);
      $(document).on("click", ".th-compare-product-remove[data-th-product-id]", thCompare.removeProduct);
      $(document).on("click", "#thpc-removeall", thCompare.removeAllProduct);
      $(document).on("click", ".thcompare-open-by-popup .th-compare-output-close", thCompare.removeCompare);
      $(document).on("click", "[data-compare-category]", thCompare.showByCategory);
     $(document).on("click", ".th-add-product-bar", function (e) {
  if ($(this).hasClass("disabled")) {
    e.preventDefault();
    $(".th-compare-heading .error_")
      .text("Maximum compare limit reached")
      .fadeIn();
    setTimeout(() => $(".th-compare-heading .error_").fadeOut(), 2500);
    return false;
  }
  thCompare.addMorePopup.call(this, e);
});

      $(document).on("click", ".th-compare-external-popup-open", thCompare.addMorePopupClick);
      $(document).on("click", ".th-highlight-difference", thCompare.highlightDifference);
      $(document).on("click", ".th-hide-similarities", thCompare.hideDifference);
      $(document).on("click", ".th-compare-icon-widget", thCompare.menuIconClick);
      $(document).on("keydown", ".th-compare-icon-widget", function (e) {
        if (e.key === "Enter" || e.key === " ") thCompare.menuIconClick(e);
      });

      // Prevent WooCommerce auto-redirect after add-to-cart inside compare table
      $(document).on("click", ".th-compare-add-to-cart-btn.ajax_add_to_cart", function () {
        if (typeof wc_add_to_cart_params === "undefined") return;
        if (wc_add_to_cart_params.cart_redirect_after_add !== "yes") return;
        var stored = wc_add_to_cart_params.cart_redirect_after_add;
        wc_add_to_cart_params.cart_redirect_after_add = "no";
        $(document.body).one("added_to_cart", function () {
          wc_add_to_cart_params.cart_redirect_after_add = stored;
        });
      });

      // After successful add-to-cart, update the compare button to a "View Cart" state
      // so a second click does not trigger WooCommerce AJAX and redirect to the product page
      $(document.body).on("added_to_cart", function (e, fragments, cart_hash, $button) {
        if (!$button || !$button.hasClass("th-compare-add-to-cart-btn")) return;
        var cartUrl = (typeof wc_add_to_cart_params !== "undefined") ? wc_add_to_cart_params.cart_url : "";
        var viewCartText = (typeof th_product !== "undefined" && th_product.view_cart_text) ? th_product.view_cart_text : "View Cart";
        $button
          .removeClass("ajax_add_to_cart add_to_cart_button loading")
          .addClass("added th-in-cart wc-forward")
          .attr("href", cartUrl || "#")
          .find(".add-to-cart-text").text(viewCartText);

        // Close popup if the setting is enabled
        var closeOnCart = (typeof th_product !== "undefined" && th_product.th_compare_style_local && th_product.th_compare_style_local["close-popup-on-addtocart"] == "1");
        if (closeOnCart) {
          $(".thcompare-open-by-popup .th-compare-output-wrap").addClass("th-compare-output-wrap-close").removeClass("active");
          $(".th-compare-footer-product-opner").removeClass("active");
          $("body").removeClass("th_product_Compare_body_Class");
        }
      });
    },
    containerScroll: function () {
      let heading_ = $(".th-compare-output-wrap .th-compare-heading");
      let isMobile = $(".th-mobile-type-displey").length;
      if (isMobile) {
        $('tr.th-custom-attr').each(function () {
          let var1 = $(this).find('.left-title span').text();
          if ($(this).hasClass(var1)) {
            $(this).find('td .mobile-title').append(var1);
          }
        });
      }
      if (heading_.length) {
        let height_ = heading_.outerHeight();
        let heighlightBtn = $(".th-heighlights-products");
        if (isMobile && heighlightBtn.length) {
          let heightLightProduct = heighlightBtn.outerHeight();
          heighlightBtn.css("top", height_);
          heightLightProduct = heightLightProduct + 16;
          height_ = height_ + heightLightProduct;
        }
        $(".th-compare-output-wrap .th-compare-output-wrap-inner").css("padding-top", height_ + "px");
      }
      const win_ = $(window);
      let getWindowWidth = win_.innerWidth();
      if (isMobile) {
        $(".th-compare-output-wrap .th-compare-output-wrap-inner,.th-compare-footer-wrap").addClass("th-mobile-view");
      }
      let container_ = $(".th-compare-output-product");
      let containerTable = $(".th-compare-output-product > table").innerWidth();
      if (containerTable > getWindowWidth) {
        container_.css("cursor", "grab");
      }
      if (isMobile) {
        container_.scroll(function (event) {
          let container = $(this);
          let getLeft = container.scrollLeft();
          getLeft = getLeft > 1 ? getLeft - 1 : getLeft;
          container.find("td.left-title").css("left", getLeft + "px");
        });
      }
      const slider2 = document.querySelectorAll(".th-compare-output-product");
      if (slider2.length) {
        for (let i = 0; i < slider2.length; i++) {
          let slider = slider2[i];
          let isDown = false;
          let startX;
          let scrollLeft;
          slider.addEventListener("mousedown", (e) => {
            isDown = true;
            slider.classList.add("active");
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
          });
          slider.addEventListener("mouseleave", () => {
            isDown = false;
            slider.classList.remove("active");
          });
          slider.addEventListener("mouseup", () => {
            isDown = false;
            slider.classList.remove("active");
          });
          slider.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 3;
            slider.scrollLeft = scrollLeft - walk;
          });
        }
      }
    },
    addStyle: function () {
      let style_ = th_product.th_compare_style_local;
      if (style_) {
        let styleAdd = "";
        for (let getKey in style_) {
          if (getKey == "compare-heading-text") {
            $(".th-compare-heading > span.heading_").html(style_[getKey]);
          } else if (getKey == "compare-popup-animation") {
            let addClass_ = "th-animation-" + style_[getKey];
            $(".th-compare-output-wrap").addClass(addClass_);
          } else if (getKey == "global-backgroundth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap .th-compare-output-wrap-inner{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "heading-styleth-idcolor") {
            styleAdd += ".th-compare-output-wrap-inner .th-compare-heading .heading_,.th-compare-heading .th-compare-count,.th-heighlights-products > div{color:" + style_[getKey] + "!important;}";
          }else if (getKey == "table-content-colorth-idcolor") {
            styleAdd += ".th-compare-output-product .product-table-configure tbody{color:" + style_[getKey] + "!important;}";
          }else if (getKey == "heading-style-bgth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap-inner .th-compare-heading{background-color:" + style_[getKey] + "!important;}";
          }else if (getKey == "dummy-border-colorth-idborder-color") {
            styleAdd += ".th-compare-output-wrap-inner{border-color:" + style_[getKey] + ";}";
          } else if (getKey == "product-img-bg-colorth-idbackground-color") {
            styleAdd += ".th-compare-output-product .product-table-configure{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "add-to-cartth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap-inner .th-add-to-cart_{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "add-to-cartth-idcolor") {
            styleAdd += ".th-compare-output-wrap-inner .th-add-to-cart_{color:" + style_[getKey] + "!important;}";
          } else if (getKey == "product-img-bg-colorth-idcolor") {
            styleAdd += ".th-compare-output-product .product-table-configure td.left-title,.product-title_ a,._SKU_,.th-compare-output-product .product-table-configure .price_{color:" + style_[getKey] + "!important;}";
          } else if (getKey == "row-odd-bgth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap-inner .product-table-configure tr:nth-child(odd) td,.th-compare-output-wrap-inner .product-table-configure tr:nth-child(odd) td.left-title{background-color:" + style_[getKey] + ";}";
            styleAdd += ".th-compare-output-wrap-inner .product-table-configure tr:nth-child(odd) td.left-title{opacity:.7;}";
          } else if (getKey == "row-even-bgth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap-inner .product-table-configure tr:nth-child(even) td,.th-compare-output-wrap-inner .product-table-configure tr:nth-child(even) td.left-title{background-color:" + style_[getKey] + ";}";
            styleAdd += ".th-compare-output-wrap-inner .product-table-configure tr:nth-child(even) td.left-title{opacity:.7;}";
          } else if (getKey == "rating-colorth-idcolor") {
            styleAdd += ".th-compare-output-wrap-inner .th-compare-rating{color:" + style_[getKey] + ";}";
          } else if (getKey == "remove-btn-colorth-idcolor") {
            styleAdd += ".th-compare-output-wrap-inner .product-table-configure .th-compare-product-remove{color:" + style_[getKey] + ";}";
          } else if (getKey == "img-remove-icon-colorth-idcolor") {
            styleAdd += ".pc-product-details ._image_ .img_ .th-img-remove-btn i{color:" + style_[getKey] + "!important;}";
          } else if (getKey == "img-remove-icon-colorth-idbackground-color") {
            styleAdd += ".pc-product-details ._image_ .img_ .th-img-remove-btn{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "img-remove-btn-size") {
            var s_ = parseInt(style_[getKey]);
            if (s_ > 0) {
              styleAdd += ".pc-product-details ._image_ .img_ .th-img-remove-btn{width:" + s_ + "px;height:" + s_ + "px;min-width:" + s_ + "px;}";
              styleAdd += ".pc-product-details ._image_ .img_ .th-img-remove-btn i{font-size:" + Math.round(s_ * 0.58) + "px;}";
            }
          } else if (getKey == "close-btn-styleth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap-inner .th-compare-output-close i{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "close-btn-styleth-idcolor") {
            styleAdd += ".th-compare-output-wrap-inner .th-compare-output-close i{color:" + style_[getKey] + ";}";
          } else if (getKey == "similarities-btn-styleth-idbackground-color") {
            styleAdd += ".th-heighlights-products > div{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "similarities-btn-styleth-idcolor") {
            styleAdd += ".th-heighlights-products > div{color:" + style_[getKey] + ";}";
          } else if (getKey == "similarities-btn-style-checkedth-idbackground-color") {
            styleAdd += ".th-heighlights-products > div.active:before{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "product-image-width") {
            styleAdd += ".th-compare-output-product .product-table-configure ._image_ .image-and-addcart .img_{width:" + style_[getKey] + "px;}";
          } else if (getKey == "product-image-height") {
            styleAdd += ".th-compare-output-product .product-table-configure ._image_ .image-and-addcart .img_{height:" + style_[getKey] + "px;}";
          } 
          
            else if (getKey == "footer-bar-bg-colorth-idbackground-color") {
            styleAdd += ".th-compare-footer-wrap .th-compare-footer-level2{background-color:" + style_[getKey] + ";}";
          }  else if (getKey == "footer-content-colorth-idcolor") {
            styleAdd += ".th-compare-footer-wrap .th-compare-footer-level2{color:" + style_[getKey] + ";}";
          }else if (getKey == "footer-bar-btn-colorth-idcolor") {
            styleAdd += ".th-compare-footer-wrap > div .th-add-product-bar,.th-compare-footer-wrap > div .th-compare-enable .th-compare-footer-product-opner{color:" + style_[getKey] + ";}";
          } else if (getKey == "footer-bar-btn-colorth-idbackground-color") {
            styleAdd += ".th-compare-footer-wrap > div .th-add-product-bar,.th-compare-footer-wrap > div .th-compare-enable .th-compare-footer-product-opner{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "footer-bar-btn-icon-colorth-idcolor") {
            styleAdd += ".th-compare-footer-wrap > div .th-add-product-bar i,.th-compare-footer-wrap > div .th-compare-enable .th-compare-footer-product-opner .icon_{color:" + style_[getKey] + ";}";
          } else if (getKey == "footer-bar-btn-icon-colorth-idbackground-color") {
            styleAdd += ".th-compare-footer-wrap > div .th-add-product-bar i,.th-compare-footer-wrap > div .th-compare-enable .th-compare-footer-product-opner .icon_{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "footer-bar-open-btn-colorth-idcolor") {
            styleAdd += ".th-compare-footer-wrap .th-footer-up-down{color:" + style_[getKey] + ";}";
          } else if (getKey == "footer-bar-open-btn-colorth-idbackground-color") {
            styleAdd += ".th-compare-footer-wrap .th-footer-up-down{background-color:" + style_[getKey] + ";}";
          } else if (getKey == "footer-bar-img-bg-colorth-idbackground-color") {
            styleAdd += ".th-compare-footer-wrap > div .product_image .img_{background-color:" + style_[getKey] + "!important;}";
          }
          else if (getKey == "floating-ci-colorth-idcolor") {
            styleAdd += ".th-compare-icon-widget{color:" + style_[getKey] + ";}";
          }
          else if (getKey == "floating-ci-colorth-idbackground-color") {
            styleAdd += ".th-compare-icon-widget{background-color:" + style_[getKey] + ";}";
          }
          else if (getKey == "floating-ci-badge-colorth-idcolor") {
            styleAdd += ".th-compare-icon-widget-count{color:" + style_[getKey] + ";}";
          }
           else if (getKey == "floating-ci-badge-colorth-idbackground-color") {
            styleAdd += ".th-compare-icon-widget-count{background-color:" + style_[getKey] + ";}";
          }
          // Mobile colors
          else if (getKey == "mobile-table-bg-colorth-idbackground-color") {
            styleAdd += ".product-table-configure.mobile-flex{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-content-colorth-idcolor") {
            styleAdd += ".product-table-configure.mobile-flex tbody{color:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-heading-colorth-idcolor") {
            styleAdd += ".product-table-configure.mobile-flex td.left-title span{color:" + style_[getKey] + "!important;}";
            styleAdd += ".product-table-configure.mobile-flex .mobile-title{color:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-border-colorth-idborder-color") {
            styleAdd += ".product-table-configure.mobile-flex td:not(.left-title){border-color:" + style_[getKey] + "!important;}";
            styleAdd += ".product-table-configure.mobile-flex td.left-title span{border-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-accent-colorth-idbackground-color") {
            styleAdd += ".th-compare-output-wrap .th-compare-output-wrap-inner{border-left:6px solid " + style_[getKey] + ";}";
          } else if (getKey == "mobile-add-to-cartth-idbackground-color") {
            styleAdd += ".product-table-configure.mobile-flex .th-add-to-cart_{background-color:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-add-to-cartth-idcolor") {
            styleAdd += ".product-table-configure.mobile-flex .th-add-to-cart_{color:" + style_[getKey] + "!important;}";
            styleAdd += ".product-table-configure.mobile-flex .th-add-to-cart_ > svg{stroke:" + style_[getKey] + "!important;}";
          } else if (getKey == "mobile-rating-colorth-idcolor") {
            styleAdd += ".product-table-configure.mobile-flex .th-compare-rating{color:" + style_[getKey] + "!important;}";
          }
        }
        if (!$("style#th-compare-style-head").length) {
          let style_Append = '<style id="th-compare-style-head">' + styleAdd + "</style>";
          $("head").append(style_Append);
        }
      }
    },
    loaderIcon: function () {
      return '<div class="th-compare-loader"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 32 32" height="32" viewBox="0 0 32 32" width="32"><path d="m16 6.001v2.999c0 .369.203.708.527.883.147.078.311.118.473.118.193 0 .387-.057.555-.168l6-4.001c.278-.186.445-.497.445-.831 0-.335-.167-.646-.445-.832l-6-4c-.307-.206-.703-.225-1.025-.05-.327.174-.53.513-.53.882v3c-6.617 0-12 5.383-12 12 0 .552.448 1 1 1s1-.448 1-1c0-5.515 4.486-10 10-10zm2-3.132 3.197 2.132-3.197 2.131zm9 12.132c-.552 0-1 .447-1 1 0 5.516-4.486 10-10 10v-3.001c0-.369-.203-.708-.527-.883-.147-.078-.311-.117-.473-.117-.193 0-.387.057-.555.168l-6 4.001c-.278.186-.445.497-.445.831 0 .335.167.646.445.832l6 4c.307.206.703.225 1.025.05.327-.175.53-.514.53-.883v-3c6.617 0 12-5.383 12-12 0-.553-.448-1-1-1zm-2 12.999-3.197-2.132 3.197-2.131z"/></svg></div>';
    },
    toolTip: function () {
      let tooltip = $(".th-compare-footer-wrap .product_image .img_ a");
      tooltip.each(function () {
        let $this = $(this);
        let title = $this.find("img").attr("alt");
        // if (title) {
        //   $this.append('<span class="th-tooltip">' + title + '</span>');
        // }
      });
    }
  };
  $(document).ready(function () {
    thCompare.init();
  });

  $(document).on("click", ".th-read-more", function (e) {
  e.preventDefault();

  let btn = $(this);
  let wrap = btn.closest(".description-text");
  let more = wrap.find(".desc-more");

  if (btn.attr("data-state") === "collapsed") {
    more.slideDown(150);
    btn.text("Read less");
    btn.attr("data-state", "expanded");
  } else {
    more.slideUp(150);
    btn.text("Read more");
    btn.attr("data-state", "collapsed");
  }
});

})(jQuery);





