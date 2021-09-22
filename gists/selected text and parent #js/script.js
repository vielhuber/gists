if (window.getSelection().anchorNode !== undefined && window.getSelection().anchorNode !== null && window.getSelection().anchorNode !== '' && window.getSelection().type !== 'Range') {
	let parent = window.getSelection().anchorNode.parentElement,
    	text = window.getSelection().toString();
}