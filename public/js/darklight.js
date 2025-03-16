//
// functions for setting & getting cookies
//

setCookie = function(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};
unsetCookie = function(name) {
  document.cookie =  name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
};
getCookie = function(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
  else return null;
};

//
// functions for setting the darklight style & fixing up the darklight buttons
//

// shows/hides the provided (ele ID) buttons
function darklightBtn(show, hide) {
  document.getElementById(show).removeAttribute('hidden');
  document.getElementById(hide).setAttribute('hidden', '');
};
// adds the dark style, by adding the provided classes from the body
setDarkStyle = function(cls, show, hide) {
  document.body.classList.add(cls); // add class to body
  darklightBtn(show, hide); // show/hide the correct buttons
};
// removes the dark style, which reverts back to the light style, by removing the provided classes from the body
unsetDarkStyle = function(cls, show, hide) {
  document.body.classList.remove(cls); // remove class to body
  darklightBtn(show, hide); // show/hide the correct buttons
};

//
// set the init styles depending on the 'darklight' cookie
//

var darklightCookie = getCookie("darklight");
if(darklightCookie) setDarkStyle('rmcc-light', 'lightBtn', 'darkBtn');
else unsetDarkStyle('rmcc-light', 'darkBtn', 'lightBtn');

//
// watch the darklight btns for mouseover events, so we can set a new style & cookie when it happens
//

document.querySelectorAll('.darklight-btn').forEach(item => {
  item.addEventListener('mousedown', event => {

    event.preventDefault(); // prevent default events from propagating

    var darklightCookie = getCookie("darklight"); // get cookie value at point of mouseover

    // if darklightCookie not set, UNSET any dark style
    if(darklightCookie != "" && darklightCookie != null) {
      unsetCookie('darklight');
      unsetDarkStyle('rmcc-light', 'darkBtn', 'lightBtn');
    }
    
    // else we SET the dark style
    else {
      setCookie('darklight', 'dark', 7);
      setDarkStyle('rmcc-light', 'lightBtn', 'darkBtn');
    }

  })
})