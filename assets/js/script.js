(function ($) {
  const TH = {
    init: function () {
      if (
        th_product.th_compare_style_local &&
        !$("style#th-compare-style-head").length
      ) {
        let style_ =
          '<style id="th-compare-style-head">' +
          th_product.th_compare_style_local +
          "</style>";
        $("head").append(style_);
      }

      TH.bind();
      TH.tab();
      TH.toolTip();
    },
    toolTip: function () {
      let initTooltip = $("[th-tooltip]");

      console.log("initTooltip->", initTooltip);

      if (initTooltip.length) {
        // keep tool tip in document
        let keepToolTip = $(".keep-th-tooltip-wrap");
        if (!keepToolTip.length) {
          let tooltipHtml = '<div class="tooltip-show-with-title">';
          tooltipHtml += '<span class="th-ttt"></span>';
          tooltipHtml +=
            '<svg class="pointer_" viewBox="0 0 1280 70" preserveAspectRatio="none">';
          tooltipHtml += '<polygon points="1280,70 0,70 640,0 "></polygon>';
          tooltipHtml += "</svg>";
          tooltipHtml += "</div>";

          $("body").append(tooltipHtml);
        }
        // keep tool tip in document
        initTooltip.hover(
          function () {
            let element = $(this);
            let element_ = element[0].getBoundingClientRect();
            let tooltip_ = $(".tooltip-show-with-title");
            //text and content
            let title_ = element.attr("th-tooltip");
            tooltip_.find(".th-ttt").text(title_);
            // style and dimensions
            // calculate top
            let tooltip = tooltip_[0].getBoundingClientRect();
            let TopMargin = element_.top - (tooltip.height + 12);
            // calculate left
            let getTTwidth = tooltip.width / 2;
            let elementWidth = element_.width / 2;
            let leftMargin = element_.left - (getTTwidth - elementWidth);
            tooltip_.addClass("active");
            tooltip_.css({ top: TopMargin, left: leftMargin });
            // setTimeout(() => {
            //   tooltip_.addClass("active");
            // }, 200);
          },
          function () {
            let element_ = $(this);
            let tooltip = $(".tooltip-show-with-title");
            tooltip.removeClass("active");
          }
        );
      }
    },
    toolTip_: function () {
      let initTooltip = $("[th-tooltip]");
      if (initTooltip.length) {
        // keep tool tip in document
        let keepToolTip = $(".keep-th-tooltip-wrap");
        if (!keepToolTip.length) {
          let tooltipHtml =
            '<div class="tooltip-show-with-title"><span class="th-ttt">My Tooltip but you can check </span><svg class="pointer_" viewBox="0 0 1280 70" preserveAspectRatio="none"><polygon points="1280,70 0,70 640,0 "></polygon></svg></div>';

          $("body").append(tooltipHtml);
        }
        // keep tool tip in document
        initTooltip.hover(
          function () {
            let element = $(this);
            let element_ = element[0].getBoundingClientRect();
            // console.log("element_ in ", element_);
            // console.log("offsetTop -> ", element_.top);
            // console.log("offsetLeft -> ", element_.left);
            let tooltip_ = $(".tooltip-show-with-title");
            //text and content
            let title_ = element.attr("th-tooltip");
            tooltip_.find(".th-ttt").text(title_);
            // style and dimensions
            // calculate top
            let tooltip = tooltip_[0].getBoundingClientRect();
            let TopMargin = element_.top - (tooltip.height + 12);
            // calculate left
            let getTTwidth = tooltip.width / 2;
            let elementWidth = element_.width / 2;
            let leftMargin = element_.left - (getTTwidth - elementWidth);

            tooltip_.css({ top: TopMargin, left: leftMargin });
            // tooltip_.css({ top: TopMargin, left: element_.left });
            tooltip_.addClass("active");

            // bottom: 230
            // height: 35
            // left: 181
            // right: 427.953125
            // top: 195
            // width: 246.953125
            // x: 181
            // y: 195
          },
          function () {
            let element_ = $(this);
            let tooltip = $(".tooltip-show-with-title");
            tooltip.removeClass("active");
          }
        );
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
      });
    },
    saveFN: function (inputs) {
      // console.log("inputs->", inputs);
      let returnSave = {};
      $.each(inputs, (ind_, val_) => {
        let Input_ = $(val_);
        let inputName = Input_.attr("data-th-save");
        if (inputName == "style") {
          let checkSaveStyle = Input_.attr("data-th");
          let checkStyle = Input_.attr("style");
          let elemtntTarget = Input_.attr("data-th-output");
          // check style and split and save with element id like this is id {heading-} and this is style {color} final save heading-style
          if (checkStyle && checkSaveStyle != "") {
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
        } else if (val_.tagName == "SELECT" || val_.tagName == "INPUT") {
          let inputVal = Input_.val();
          returnSave[inputName] = inputVal;
        }
      });
      return returnSave;
      // console.log("val_", val_);
    },
    saveData: function () {
      let thisBTN = $(this);
      let thContainer = thisBTN.closest(".th-product-compare-wrap");
      let inputs = thContainer.find(".container-tabs").find("[data-th-save]");

      let sendData = TH.saveFN(inputs);
      console.log("sendData", sendData);
      $.ajax({
        method: "post",
        url: th_product.th_product_ajax_url,
        data: {
          action: "th_compare_save_data",
          inputs: sendData,
        },
        success: function (response) {
          console.log("response->", response);

          if (response == "update") {
            console.log("updated ");
          }
        },
      });
    },
    bind: function () {
      $(document).on("click", ".th-option-save-btn", TH.saveData);
      $(document).on("click", "[data-th-color][output-type]", TH.pkr);
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
        inputOBj.css("background-color", getColorValue);
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
          TH._setStyleColor(outputColor, color_, getColorProperty);
        })
        .on("hide", (instance) => {
          instance._root.app.remove();
        });
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
    // color fn end
  };
  TH.init();
})(jQuery);
