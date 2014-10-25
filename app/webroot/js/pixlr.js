var Pixlr = (function(){
	var _this = {};
	// var images;
	var save_url = "http://schmidtj.spica.uberspace.de/102-A3/app/Lib/pixlr/save.php";

	_this.init = function(event) {
		initEvent();
	};

	function initEvent() {
		//@TODO: NOT COMPATIBLE WITH IE
		var images = new Array(document.getElementByTagName("img"));
		for (var i = images.length - 1; i >= 0; i--) {
			images[i].addEventListener("click", onImageClick);
		};
		document.write('<p>Cookie</p>');
	}

	function onImageClick(event) {
	pixlr.overlay.show({
		image: images.src,
		title: "Mona-Lisa",	//needs to be changed!
		referrer: "mLearn4web",
		method: "GET",
		target: URL_SAVE_IMAGE,
		exit: "http://schmidtj.spica.uberspace.de/102-A3/images/display_images",
		// copy: "true", 	//needs to be tested if working with locktarget
		redirect: "true",
		locktarget: "true",
		locktype: "source",
	});
}

return _this;

})();

window.addEventListener("load", Pixlr.init);