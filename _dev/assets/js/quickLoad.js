// listen for click event in the main, & if target of click has data-link attr, do the shop filtering
document.querySelector('main').addEventListener('click', function(event) {
  if (event.target.hasAttribute('data-link'))
    quickLoad();
});

// quickload some content. this is useful for ajax-style pagination, filtering etc...
function quickLoad() {

  // on clicking filter, scroll to top. uses UiKit functions, if not using uikit, use something else for smooth scrolling to top, if u want...
  UIkit.scroll('', {
    offset: 90
  }).scrollTo('#Top');

  // add the preloader class to some container. this container should be within the content to be replaced, otherwise remove the class aftrer successfull call
  document.querySelector('.content-container').classList.add('preloader');

  // the data-link url for fetching
  var data_link = event.target.getAttribute("data-link");

  // then a fetch request with the clicked data-llnk
  fetch(data_link).then(function(response) {
    // The API call was successful, on to what we do with the resuts
    return response.text();
  }).then(function(html) {

    // define our variables first
    var parser = new DOMParser();

    // the main container & it's child to be replaed
    var main_container = document.getElementById("ContentSection");
    var current_content = document.querySelector('.index-archive');

    // do stuff with the data/results
    var doc_obj = parser.parseFromString(html, 'text/html');
    var new_content = doc_obj.querySelector('.index-archive');
    main_container.replaceChild(new_content, current_content);

    // add new url to the browser address bar
    window.history.pushState({}, '', data_link);

    // redo some functions here as js from the new page wont be processed. needed for woo customizations
    window.parent.ShopStyles();

  }).catch(function(error) {
    // There was an error
    console.warn('Something went wrong.', error);
  });
}