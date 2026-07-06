(function ($) {
  "use strict";
  function tpcpParseCountText(template, count) {
  if (!template) return '';

  return template.replace(/\{([^}]+)\}/g, function (match, text) {
    if (text.toLowerCase().trim() === 'count') {
      return count;
    }
    return text;
  });
}

function tpcpSplitAtleastText(text) {
  let result = {
    first: "",
    second: ""
  };

  if (!text) return result;

  let matches = text.match(/\{([^}]+)\}/g);

  if (matches && matches.length) {
    result.first = matches[0]
      ? matches[0].replace(/[{}]/g, "")
      : "";

    result.second = matches[1]
      ? matches[1].replace(/[{}]/g, "")
      : "";
  }

  return result;
}


  const TH = {
    init: function () {
      TH.addStyleSaved();
      TH.bind();
      TH.dataColorInit();
      TH.tab();
      TH.createOwnShortcode();
      TH.attributesShortable();
      TH.changeInputHideShow();
      TH.mainTabheader();
      TH.copyToClip();
      TH.previewToggle();
    },

    previewToggle: function () {

    },
      mainTabheader: function () {
      jQuery(document).ready(function($) {
    // When the page loads or a new tab is clicked
    $('.th-nav_ a').on('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        
        // Get the content of the active link
        var activeContent = $('.th-nav_ a.active').text(); // You can also use .html() if you need the HTML content

        // Replace the content inside .tabheading with the active link content
        $('.tabheading').text(activeContent);
    });
});

    },

    copyToClip: function () {

            $('.th-copy-btn').on('click', function () {

                  var button = $(this);
                  var targetId = button.data('copy-target');
                  var textToCopy = $('#' + targetId).text();

                  // Create temporary input
                  var tempInput = $('<input>');
                  $('body').append(tempInput);
                  tempInput.val(textToCopy).select();

                  document.execCommand('copy');
                  tempInput.remove();

                  // UI Feedback
                  button.text('Copied!');
                  button.addClass('copied');

                  setTimeout(function () {
                      button.text('Copy');
                      button.removeClass('copied');
                  }, 1500);

              });

    },

    attributesShortable: function () {
      $(".woocommerce-th-attributes").sortable();
    },
    changeInputHideShow: function () {
      $(document).on("change", "[data-change-showhide]", function () {
        let input_ = $(this);
        let inputVAl = input_.val();
        let getTAbGRoup = input_.attr("data-change-showhide");
        let inputHideShowContainer =
          '[data-change-showhide-tab="' + getTAbGRoup + '"]';
        $(inputHideShowContainer + "[data-show]").addClass("show_none");
        let container_ = $(
          inputHideShowContainer + '[data-show="' + inputVAl + '"]'
        );
        container_.removeClass("show_none");
      });
    },
    addStyleSaved: function () {
      let style_ = th_product.th_compare_style;
      if (style_) {
        for (let getKey in style_) {
          if (getKey.indexOf("th-id")) {
            let have_Style = getKey.split("th-id");
            let value_ = style_[getKey];
            let Apply_ = $('[data-th-output="' + have_Style[0] + '"]');
            if (have_Style[0] && have_Style[1] && Apply_.length) {
              Apply_.css(have_Style[1], value_);
            }
          }
        }
      }
    },
    tab: function () {
      $("[data-group-tabs][data-tab]").click(function (e) {
        e.preventDefault();
        let BTN = $(this);
        let getTAbGRoup = BTN.attr("data-group-tabs");
        let getTAbSingle = BTN.attr("data-tab");
        let TABgorup = '[data-group-tabs="' + getTAbGRoup + '"]';
        $(TABgorup).removeClass("active");
        $(TABgorup + '[data-tab="' + getTAbSingle + '"]').addClass("active");
        $(TABgorup + '[data-tab-container="' + getTAbSingle + '"]').addClass(
          "active"
        );

         // Show/Hide the preview boxes based on the active tab
        if (getTAbSingle === "style") {
            // Show Footer Box preview, hide Popup preview
            $(".th-footerbox-preview").show();
            $(".th-popup-preview").hide();
        } else if (getTAbSingle === "setting") {
            // Show Popup preview, hide Footer Box preview
            $(".th-popup-preview").show();
            $(".th-footerbox-preview").hide();
        }
        
      });
    },
    saveFN: function (inputs) {
      let returnSave = { attributes: {} };
      $.each(inputs, (ind_, val_) => {
        let Input_ = $(val_);
        let inputName = Input_.attr("data-th-save");
        if (inputName == "style") {
          let checkSaveStyle = Input_.attr("data-th");
          let checkStyle = Input_.attr("style");
          let elemtntTarget = Input_.attr("data-th-output");
          // check style and split and save with element id like this is id {heading-} and this is style {color} final save heading-style
          if (checkStyle && checkSaveStyle && checkSaveStyle != "") {
            let saparateStyle = TH._inlineCssSeparate(checkStyle);
            if (checkSaveStyle.indexOf("|") > 1) {
              let splitted = checkSaveStyle.split("|");
              splitted.map((ind_) => {
                let saveWithElement = elemtntTarget + "th-id" + ind_;
                if (saparateStyle[ind_]) {
                  returnSave[saveWithElement] = saparateStyle[ind_];
                }
              });
            } else {
              if (saparateStyle[checkSaveStyle]) {
                let saveWithElement = elemtntTarget + "th-id" + checkSaveStyle;
                returnSave[saveWithElement] = saparateStyle[checkSaveStyle];
              }
            }
          }
        } else if (inputName == "compare-attributes") {
          let inputVal = Input_.val();
          returnSave["attributes"][inputVal] = {};
          if (Input_.prop("checked") == true) {
            returnSave["attributes"][inputVal]["active"] = 1;
          } else {
            returnSave["attributes"][inputVal]["active"] = 0;
          }
          if (Input_.attr("data-custom-attr") == 1) {
            returnSave["attributes"][inputVal]["custom"] = 1;
            returnSave["attributes"][inputVal]["label"] =
              Input_.siblings("label").html();
          }
        } else if (inputName == "compare-field") {
          let inputVal = Input_.val();
          let save_ = "field-" + inputVal;
          if (Input_.prop("checked") == true) {
            returnSave[save_] = 1;
          } else {
            returnSave[save_] = "hide";
          }
        } else if (val_.tagName == "SELECT" || val_.tagName == "INPUT") {
          let inputVal = Input_.val();
          returnSave[inputName] = inputVal;
        }
      });
      return returnSave;
    },
    enableSaveButton: function () {
    $(".th-option-save-btn")
        .prop("disabled", false)
        .removeAttr("disabled");
    },
    saveData: function () {
      let thisBTN = $(this);
      let thContainer = thisBTN.closest(".th-product-compare-wrap");
      let inputs = thContainer.find(".container-tabs").find("[data-th-save]");
      thisBTN.addClass("loading");
      let sendData = TH.saveFN(inputs);
      $.ajax({
        method: "post",
        url: th_product.tpcp_product_ajax_url,
        data: {
          action: "tpcp_compare_save_data",
          inputs: sendData,
          tpcp_nonce_created: th_product.tpcp_nonce,
        },
        success: function (response) {
          if (response.data) {
            thisBTN.prop("disabled", true).attr("disabled", "disabled").removeClass("loading");
          }
          setTimeout(() => {
            thisBTN.removeClass("loading").prop("disabled", true).attr("disabled", "disabled");
          }, 500);
        },
      });
    },
    changeHeadingText: function () {
      let getText = $(this);
      let txt_ = getText.val();
      let getSaveTxt = getText.attr("data-th-save");
      if (getSaveTxt == "compare-heading-text") {
        let heading_ = $(".th-compare-popup-dummy .headingwrap .heading_");
        if (txt_) {
          heading_.html(txt_);
        } else {
          heading_.html(th_product.headingtext);
        }
      } /* ✅ NEW BLOCK START */
      else if (getSaveTxt == "compare-count-text") {

        let previewCount = 3; // dummy number for admin preview

        let finalText = tpcpParseCountText(txt_, previewCount);

        let target = $(".th-compare-popup-dummy .th-compare-count");

        if (!target.length) {
          $(".th-compare-popup-dummy .headingwrap .heading_")
            .after('<span class="th-compare-count">' + finalText + '</span>');
        } else {
          target.html(finalText);
        }

      }
  /* ✅ NEW BLOCK END */
  else if (getSaveTxt === "compare-atleast-text") {

  let splitText = tpcpSplitAtleastText(txt_);

  // 🔥 detect active preview automatically
  let previewWrap = $(".th-footerbox-preview:visible");
  if (!previewWrap.length) {
    previewWrap = $(".th-popup-preview:visible");
  }

  let selectedSpan = previewWrap.find(".th-atleast .th-selected");
  let productsSpan = previewWrap.find(".th-atleast .th-select-count");

  if (selectedSpan.length && splitText.first) {
    selectedSpan.text(splitText.first);
  }

  if (productsSpan.length && splitText.second) {
    productsSpan.text(splitText.second);
  }
}

   else if (getSaveTxt == "compare-opener-btn-text") {
        let openerTxt = $(".th-compare-popup-dummy .opner_ .title_");
        if (txt_) {
          openerTxt.html(txt_);
        } else {
          openerTxt.html("Th Compare");
        }
      } else if (getSaveTxt == "compare-popup-position") {
        let div_ = $(".th-compare-popup-dummy .th-footer-bar");
        div_.removeClass(
          "position-left position-right position-bottom position-top"
        );
        div_.addClass("position-" + txt_);
      } else if (getSaveTxt == "compare-popup-animation") {
        let div_ = $(".th-compare-popup-dummy .inner-wrap_");
        div_.removeClass(
          "th-animation-1 th-animation-2 th-animation-3 th-animation-4"
        );
        div_.addClass("th-animation-" + txt_);
        setTimeout(() => {
          div_.removeClass(
            "th-animation-1 th-animation-2 th-animation-3 th-animation-4"
          );
        }, 500);
      }
      // compare-popup-position
    },
    resetStyle: function () {
      let btn = $(this);
      btn.addClass("loading");
      $.ajax({
        method: "post",
        url: th_product.tpcp_product_ajax_url,
        data: {
          action: "tpcp_compare_reset_data",
          inputs: "reset",
        },
        success: function (response) {
          if (response.data) {
            setTimeout(() => {
              location.reload();
            }, 500);
          } else {
            location.reload();
          }
        },
      });
    },
    rgbToHex: function(color){

    if(!color) return '';

    if(color.indexOf('#') === 0){
        return color.toUpperCase();
    }

    let rgb = color.match(/\d+/g);

    if(!rgb) return color;

    return "#" +
        ((1 << 24) +
        (parseInt(rgb[0]) << 16) +
        (parseInt(rgb[1]) << 8) +
        parseInt(rgb[2]))
        .toString(16)
        .slice(1)
        .toUpperCase();
},
    bind: function () {
      $(document).on("click", ".th-option-save-btn", TH.saveData);
      $(document).on("click", "[data-th-color][output-type]", TH.pkr);
      $(document).on(
        "keyup change",
        "[data-innerdynamic]",
        TH.changeHeadingText
      );
      $(document).on("click", ".th-compare-reset-style-btn", TH.resetStyle);
      TH.singlePageShow();
      $(document).on("click", ".th-color-reset", TH.resetSingleColor);

      $(document).on( "input change", "[data-th-save]", TH.enableSaveButton);
    },
    singlePageShow: function () {
      $('input[value="auto-single-page"]').change(function () {
        let button = $(this);
        if (button.prop("checked") == true) {
          $(".automatically-add-compare").addClass("active");
        } else {
          $(".automatically-add-compare").removeClass("active");
        }
      });
    },
    dataColorInit: function () {
      let getColorInput = $("[data-th-color]");
      if (getColorInput.length > 0) {
        $.each(getColorInput, function () {
          let inputS = $(this);
          let colorID = inputS.attr("data-th-color");
          let colorProperty = inputS.attr("output-type");
          TH._colorPickr(colorID, colorProperty);
        });
      }
    },
    _colorPickr: function (th_color_id, getColorProperty, getColor = false) {
      let outoutOBj = $('[data-th-output="' + th_color_id + '"]');
      let inputOBj = $(
        $(
          '[data-th-color="' +
            th_color_id +
            '"][output-type="' +
            getColorProperty +
            '"]'
        )[0]
      );
      if (outoutOBj.length) {
        let getColorValue = outoutOBj.css(getColorProperty);

        inputOBj.css("background-color", getColorValue).attr("data-default-color", getColorValue);

        inputOBj.siblings(".th-color-value").val(TH.rgbToHex(getColorValue));

      }
    },
    pkr: function (e) {
      let select_element = $(this);
      let colorID = select_element.attr("data-th-color");
      let getColorProperty = select_element.attr("output-type");
      let outputColor = $('[data-th-output="' + colorID + '"]');
      let getColor_default = select_element.css("background-color");

      const inputElement = select_element[0];
      const pickr = new Pickr({
        el: inputElement,
        useAsButton: true,
        default: getColor_default,
        theme: "nano",
        swatches: [
          "rgba(244, 67, 54, 1)",
          "rgba(233, 30, 99, 0.95)",
          "rgba(156, 39, 176, 0.9)",
          "rgba(103, 58, 183, 0.85)",
          "rgba(63, 81, 181, 0.8)",
          "rgba(33, 150, 243, 0.75)",
          "rgba(255, 193, 7, 1)",
        ],
        components: {
          preview: true,
          opacity: true,
          hue: true,
          interaction: {
            input: true,
          },
        },
      })
        .on("init", (instance) => {
          $(instance._root.app).addClass("visible");
        })
        .on("change", (color, instance) => {
          let color_ = color.toHEXA().toString(0);
          // preview css on input editor item
          select_element.css("background-color", color_);
          select_element.siblings(".th-color-value").val(color_);
          TH._setStyleColor(outputColor, color_, getColorProperty);

          TH.enableSaveButton();
        })
        .on("hide", (instance) => {
          instance._root.app.remove();
        });
    },
    resetSingleColor: function (e) {

    e.preventDefault();

    let btn = $(this);

    let picker = btn.siblings(".color-output");

    let defaultColor = picker.attr("data-default-color");

    if (!defaultColor) {
        return;
    }

    let property = picker.attr("output-type");

    let colorID = picker.attr("data-th-color");

    let output = $('[data-th-output="' + colorID + '"]');

    picker.css("background-color", defaultColor);

    btn
        .siblings(".th-color-value")
        .val(TH.rgbToHex(defaultColor));

    TH._setStyleColor(output, defaultColor, property);

    TH.enableSaveButton();

},
    _setStyleColor: function (element, element_value, styleProperty = false) {
      if (element.length > 1) {
        $.each(element, (i, element__) => {
          TH.setStyle($(element__), element_value, styleProperty);
        });
      } else {
        TH.setStyle(element, element_value, styleProperty);
      }
    },
    setStyle: function (element, element_value, styleProperty) {
      let getElemStyle = element.attr("style");
      // return;
      if (getElemStyle) {
        let saparateStyle = TH._inlineCssSeparate(getElemStyle);
        if (styleProperty in saparateStyle) delete saparateStyle[styleProperty];
        saparateStyle[styleProperty] = element_value;
        let newStyle = "";
        for (let key in saparateStyle) {
          newStyle += key + ":" + saparateStyle[key] + ";";
        }
        element.attr("style", newStyle);
      } else {
        element.attr("style", styleProperty + ":" + element_value + ";");
      }
    },
    _inlineCssSeparate: function (inline_css) {
      let saparateStyle = {};
      if (inline_css != "" && inline_css.search(";") > -1) {
        inline_css.split(";").forEach((value_, index_) => {
          let check = value_.match(/:/g);
          if (value_ && Array.isArray(check)) {
            if (check.length > 1) {
              value_ = value_.replace(":", "r___r");
              let getCss = value_.split("r___r");
              saparateStyle[getCss[0].trim()] = getCss[1].trim();
            } else {
              let getCss = value_.split(":");
              saparateStyle[getCss[0].trim()] = getCss[1].trim();
            }
          }
        });
      }
      return saparateStyle;
    },
    toolTip: function () {
      // fn start
      let initTooltip = $("[th-tooltip]");
      if (initTooltip.length) {
        // keep tool tip in document
        let tooltipHtml = '<div class="tooltip-show-with-title">';
        tooltipHtml += '<span class="th-ttt"></span>';
        tooltipHtml +=
          '<svg class="pointer_" viewBox="0 0 1280 70" preserveAspectRatio="none">';
        tooltipHtml += '<polygon points="1280,70 0,70 640,0 "></polygon>';
        tooltipHtml += "</svg>";
        tooltipHtml += "</div>";
        setTimeout(() => {
          let keepToolTip = $(".tooltip-show-with-title");
          if (keepToolTip.length == 0) {
            $("body").append(tooltipHtml);
          }
        }, 1000);
        $(document).on(
          {
            mouseenter: function () {
              let element = $(this);
              let element_ = element[0].getBoundingClientRect();
              let tooltip_ = $(".tooltip-show-with-title");
              //text and content
              let title_ = element.attr("th-tooltip");
              tooltip_.find(".th-ttt").text(title_);
              // style and dimensions
              // calculate top
              let getScrollTop = $(window).scrollTop();
              let tooltip = tooltip_[0].getBoundingClientRect();
              let TopMargin = element_.top - (tooltip.height + 12);
              TopMargin = getScrollTop + TopMargin;
              // calculate left
              let getTTwidth = tooltip.width / 2;
              let elementWidth = element_.width / 2;
              let leftMargin = element_.left - (getTTwidth - elementWidth);
              tooltip_.addClass("active");
              tooltip_.css({ top: TopMargin, left: leftMargin });
            },
            mouseleave: function () {
              let element_ = $(this);
              let tooltip = $(".tooltip-show-with-title");
              tooltip.removeClass("active");
            },
          },
          "[th-tooltip]"
        );
      }
      // fn end
    },
    // color fn end
    createOwnShortcode: function () {
      // show and hide container
      // wrap-input-product
      jQuery(document).mouseup(function (e) {
        let searchWrap = $(".wrap-input-product");
        if (!searchWrap.is(e.target) && searchWrap.has(e.target).length === 0) {
          searchWrap.removeClass("active");
          $("#wpfooter").removeClass("th_hide_footerwp");
        }
      });
      // show if have product
      $(document).on(
        "focus",
        'input[name="th-compare-add-id-shortcode"]',
        function () {
          let this_ = $(this);
          let getContainer = this_.closest(".th-compare-add-shortcode");

          let getProduct = getContainer.find(".product-result [data-id]");

          if (getProduct.length && this_.val() != "") {
            getContainer.find(".wrap-input-product").addClass("active");
          } else {
            if (!getProduct.length) {
              addPRoduct(this_, "focus");
            } else {
              getContainer.find(".wrap-input-product").addClass("active");
            }
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
                  // -------------------
                  let Wrapper_ =
                    '<span class="' +
                    list_class +
                    '" data-id="' +
                    key_.id +
                    '">';
                    Wrapper_ +=
    '<input type="checkbox" class="product-check" ' +
    (list_class ? "checked" : "") +
    ">";
                  if (key_.image_url != 0) {
                    Wrapper_ +=
                      "<div class='img_'><img src='" +
                      key_.image_url +
                      "'></div>";
                  }
                  Wrapper_ += "<span>" + key_.label + "</span>";
                  Wrapper_ += "</span>";
                  list_ += Wrapper_;
                  // -------------------
                });
                addProductSearchWrap.addClass("active");
                addProductSearchWrap.find(".product-result").html(list_);
                addProductSearchWrap.removeClass("loading");
                $("#wpfooter").addClass("th_hide_footerwp");
              } else if (response.data.no_product) {
                addProductSearchWrap.removeClass("loading");
                let list_ =
                  '<span class="th-no-product-found">' +
                  response.data.no_product +
                  "</span>";
                addProductSearchWrap.find(".product-result").html(list_);
                $("#wpfooter").removeClass("th_hide_footerwp");
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
          let textId_ = "";
          let saveText = "";
          $.each(getIds, (key_, val_) => {
            let span_ = $(val_);
            let put_id = span_.attr("data-id");
            let put_id_text = put_id + "-" + span_.text();
            if (textId_ == "") {
              textId_ += put_id;
              saveText += put_id_text;
            } else {
              textId_ += "," + put_id;
              saveText += "|" + put_id_text;
            }
          });
          // get if shortcode
          let keepContainer = container.find(".add-product-wrap-keep");
          if (keepContainer.length) {
            if (getIds.length) {
              keepContainer.show();
            } else {
              keepContainer.hide();
            }
          }

          container
            .find(".th_product_compare_id")
            .html("[tpcp_product_list pid='" + textId_ + "']");
          // in hidden input
          container.find(".put-in-input-hidden").val(saveText);
        });
      }
      // createOwnShortcode
    },
  };
  TH.init();
})(jQuery);