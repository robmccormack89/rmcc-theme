import UIkit from 'uikit'; // import uikit
import Icons from 'uikit/dist/js/uikit-icons'; // import uikit icons
UIkit.use(Icons); // use the Icon plugin
window.RMcC = UIkit; // Make uikit available in window for inline scripts

// load infinite scroll
window.InfiniteScroll = require('infinite-scroll');

// require debounce (for jquery live search) & make available in window
window.debounce = require('debounce');