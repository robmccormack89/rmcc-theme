jQuery(function($) {
  
  // shop stuff
  function WooShop() {
    $("#ProductButtons .button").addClass("uk-button-small uk-button-primary");
    $(".onsale").addClass("uk-card-badge uk-label");
  };
  // on load
  $("#MainContent").load(WooShop());
  // on dom modified
  $("body").on('DOMSubtreeModified', "main", WooShop);
  
});

jQuery(function(){
  
  // banner swiper
  var slider_swiper = new Swiper('#slideshow_banner', {
    centeredSlides: true,
    // autoplay: {
    //   delay: 4000,
    //   disableOnInteraction: true,
    // },
    pagination: {
      el: '.swiper-pagination',
      type: 'progressbar',
      clickable: true,
    },
    // navigation: {
    //   nextEl: '.swiper-button-next',
    //   prevEl: '.swiper-button-prev',
    // },
  });
  
});