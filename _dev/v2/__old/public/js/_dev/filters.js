//
// blog filters: main functions
//

// submit the filters form by interuppting normal submit & doing our own
function filtersFormSubmitCustom(form, formFields){

	var demoPostsGrid = document.getElementById('DemoPostsGrid');
	var postsGrid = document.getElementById('PostsGrid');
	var loopContainer = document.getElementById('TheLoopContainer');
	var oldLoopSel = '#TheLoop';
	var oldLoop = document.querySelector(oldLoopSel);

	// event.preventDefault(); // prevent default submit event. this is done when calling this function instead

	// process form data into URLSearchParams
	const formData = new FormData(form);
	const formParams = new URLSearchParams(formData);

	// instead, we use set on formsParams data for comma separated values. see URLSearchParams.set()
	// we check they exist first.. dont want to add a param to the url when it has no selections
	// do this for every defined field grouping
	for (i in formFields) {
		if(formParams.has(formFields[i])) formParams.set(formFields[i], formParams.getAll(formFields[i]));
	}

	// the encoded/decoded uri & query strings
	const encodedParams = formParams.toString();
	const decodedParams = decodeURIComponent(encodedParams);
	const queryString = form.action + '?' + decodedParams;

	// start the spinners. unhide the demo posts grid
	demoPostsGrid.classList.remove('rmcc-hidden');
	postsGrid.textContent = ''; // proper posts grid becomes empty, only for now

	// the fetch request.
	// we need to grab only a certain HTML element from the returned request...
	// and then replace the equivalent HTML element on the current page with that...
	// whilst adding in the loading animation effect in between the transitions...
	// we will also want to replace the url in the browser when we're done...

	// the fetching
	fetch(queryString)

	// fetching response
	.then(function(response) {
		return response.text();
	})

	// do stuff with returned html 
	.then(function(html) {

		// setup the data
		var parser = new DOMParser();
		var newDocObj = parser.parseFromString(html, 'text/html');

		// replace the old content with the new (whilst hiding the demo posts grid)
		var newLoop = newDocObj.querySelector(oldLoopSel);
		demoPostsGrid.classList.add('rmcc-hidden');
		loopContainer.replaceChild(newLoop, oldLoop);

		// dispatch a new event
		const filtersFormSubmissionSuccess = new Event('filtersFormSubmissionSuccess');
		form.dispatchEvent(filtersFormSubmissionSuccess);

		// console.log('the content has been replaced');

	})

	.catch(error => {

		// console.error('Somethings gone wrong...', error);

	});

}

//
// blog filters: helpers
//

// used in filtersFormSubmitCustom()
function disableParentWhenParentAndChildSelected(parent_group, child_group, parent_attr = 'data-parent'){

	var _parent_group = document.getElementById(parent_group);
	var chks_parent_group = _parent_group.getElementsByTagName('INPUT');

	var _child_group = document.getElementById(child_group);
	var chks_child_group = _child_group.getElementsByTagName('INPUT');

	var arr = [];
	for (var i = 0; i < chks_child_group.length; i++) {
		if(chks_child_group[i].checked){
			arr.push(chks_child_group[i].getAttribute(parent_attr));
		}
	}

	// need to now get second array of checked boxes's values in parent group
	// and look thru that, for any matches to the first array...
	// if any items in second arr match any of the items in first arr, those items in second arr should be disabled
	// loop thru for the second array (the parent group)

	var arrTwo = [];
	for (var i = 0; i < chks_parent_group.length; i++) {
		if(arr.includes(chks_parent_group[i].value) &&  chks_parent_group[i].checked){
			chks_parent_group[i].disabled = true;
		}
	}

}
// used in archive.twig
function addClassToElements(ele, cls){
	var elementsToTarget = document.querySelectorAll(ele);
	for (var i = 0; i < elementsToTarget.length; i++) {
		if(!(elementsToTarget[i].classList.contains(cls))){
			elementsToTarget[i].classList.add(cls)
		}
	}
}
// used in archive.twig
function ifArrayContainsCheckedItem(theNodes){
	for (var i = 0; i < theNodes.length; i++) {
		if(theNodes[i].checked){
			return true;
		}
	}
	return false;
}