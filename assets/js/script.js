(function ($) {
  const TH = {
    init: function () {
      TH.bind();
      TH.tab();
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
        if (inputName) {
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
