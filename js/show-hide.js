// Find all links
var links = document.getElementsByClassName('accordionItem__link');

// Find all text blocks
var texts = document.getElementsByClassName('accordionItem__text')

// Add event on click to links. Event toggle text block
for (var i = 0; i < links.length; i++) {
	var link = links[i];
    link.addEventListener('click', toggleItem.bind(null, i));
}

//Hide siblings
function hideSiblings(el){
    console.log(texts);
    for (var i = 0; i < texts.length; i++) {
        var textBlock = texts[i];
        if (textBlock.className.search('js-hide') < 0 && textBlock != el) {
            textBlock.className = textBlock.className + ' js-hide';
        }
    }
};

function toggleCurrent(el){
    el.className = el.className.search('js-hide') > 0 ? el.className.replace('js-hide','').trim() : el.className + ' js-hide';
}

function toggleItem(i){
    hideSiblings(texts[i]);
    toggleCurrent(texts[i]);
}
