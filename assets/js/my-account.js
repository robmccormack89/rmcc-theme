jQuery(function($) {
  // my-account
  $("main .button").addClass("uk-button-primary");
  // navigation
  $(".woocommerce-MyAccount-navigation ul").addClass("uk-subnav uk-subnav-pill");
  // orders
  $(".woocommerce-orders-table").addClass("uk-table-striped uk-table-middle uk-table-justify");
  $(".woocommerce-orders-table").wrap("<div class='uk-overflow-auto'>", "</div>");
  $(".woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button").addClass("uk-button-small");
  
  function MyAccountRestyleAfterAjax() {
    $("select").addClass("uk-select");
    $(".input-text").addClass("uk-input");
    $("label").addClass("uk-form-label");
  };
  $("body").on('DOMSubtreeModified', ".woocommerce-address-fields", MyAccountRestyleAfterAjax);
  
});