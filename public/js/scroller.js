// just the inf scroll pagination init
function archivePagination(
  itemsSel = '.archive-posts', // selector string
  itemSel = '.item', // selector string
  nextSel = '.next', // selector string
  loaderSel = '.page-load-status', // selector string
  hiderSel = '.pagination', // selector string
  buttonToLoad = false, // bool
  disableHistory = true, // bool
  disablescrollThreshold = false // bool
){
  var ele = document.querySelector(itemsSel);
  if(ele){
    var argsObj = {};
    if(itemSel) argsObj['append'] = itemSel;
    if(nextSel) argsObj['path'] = nextSel;
    if(loaderSel) argsObj['status'] = loaderSel;
    if(hiderSel) argsObj['hideNav'] = hiderSel;
    if(buttonToLoad) argsObj['button'] = buttonToLoad; // load pages on button click
    if(disableHistory) argsObj['history'] = false;
    if(disablescrollThreshold) argsObj['scrollThreshold'] = false; // disable loading on scroll
    var infScroll = new InfiniteScroll(ele, argsObj);
  }
}