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
    },
  };
  TH.init();
})(jQuery);
