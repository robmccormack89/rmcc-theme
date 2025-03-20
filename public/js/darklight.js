//
// functions for setting & getting cookies
//

window.setCookie = function(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};
window.unsetCookie = function(name) {
  document.cookie =  name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
};
window.getCookie = function(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
  else return null;
};

//
// functions for setting the darklight style & fixing up the darklight buttons
//

// shows/hides the provided (ele ID) buttons
window.showDarkBtn =  function() {
  document.getElementById('darkBtn').removeAttribute('hidden');
  document.getElementById('lightBtn').setAttribute('hidden', '');
};
window.showLightBtn =  function() {
  document.getElementById('lightBtn').removeAttribute('hidden');
  document.getElementById('darkBtn').setAttribute('hidden', '');
};
// adds the dark style, by adding the provided classes from the body
window.darkMode = function() {
  setCookie('darklight', 'dark', 7);
  document.body.classList.add('rmcc-light'); // add class to body
};
// removes the dark style, which reverts back to the light style, by removing the provided classes from the body
window.lightMode = function() {
  unsetCookie('darklight');
  document.body.classList.remove('rmcc-light'); // remove class to body
};