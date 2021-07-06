// mailchimp checkboxes: add uikit classes 
jQuery(function($) {
  $( document ).ready(function() {
   $( ".mc4wp-checkbox input" ).addClass( "uk-checkbox uk-margin-small-right" );
   $( ".mc4wp-checkbox label" ).addClass( "uk-margin-small-top uk-width-large" );
  });
});
// woo globals
jQuery(function($) {
  // global
  function DoAllWoo(){
    // form login
    $(".woocommerce-form-login .woocommerce-form-login__submit").addClass("uk-button-primary uk-margin-top");
    // buttons
    $(".button").addClass("uk-button");
    $("input.submit").addClass("uk-button uk-button-primary");
    $(".woocommerce-message .button").addClass("uk-button-primary uk-button-small");
    $(".tease-buttons .button").addClass("uk-button-small uk-button-default");
    // forms
    $(".woocommerce-form__input-checkbox").addClass("uk-checkbox");
    $("input#wp-comment-cookies-consent").addClass("uk-checkbox");
    $(".input-radio").addClass("uk-radio");
    $(".input-text").addClass("uk-input");
    $(".input-checkbox").addClass("uk-checkbox");
    $(".comment-form input").addClass("uk-input");
    $("input#wp-comment-cookies-consent").removeClass("uk-input");
    $("input.qty").addClass("uk-input");
    $("form label").addClass("uk-form-label");
    $(".woocommerce-form").addClass("uk-form-stacked");
    $(".comment-form").addClass("uk-form-stacked");
    $("form").addClass("uk-form-stacked");
    $("em").addClass("uk-text-danger");
    $("select").addClass("uk-select");
    $("textarea").addClass("uk-textarea");
    // $("label").addClass("uk-form-label");
    // tables
    $("table").addClass("uk-table");
    // onsale badge
    $(".onsale").addClass("uk-card-badge uk-label");
    $("ul.woocommerce-error").addClass("uk-list");
    $("ul.woocommerce-error .uk-button").addClass("uk-button-primary");
    // login/register
    $(".col2-set").attr("uk-grid", "");
    $(".col2-set").addClass("uk-child-width-1-2@m");
  }
  // on load
  $(".woocommerce").load(DoAllWoo());
});
// custom smooth scroller
jQuery(function($) {
  // Select all links with hashes
  $('a.scroll[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
      // On-page links
      if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
        && 
        location.hostname == this.hostname
      ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
          // Only prevent default if animation is actually gonna happen
          event.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 500, function() {
            // Callback after animation
            // Must change focus!
            var $target = $(target);
            $target.focus();
            if ($target.is(":focus")) { // Checking if the target was focused
              return false;
            } else {
              $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
              $target.focus(); // Set focus again
            };
          });
        }
      }
    });
});