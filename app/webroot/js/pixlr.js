var Pixlr = (function(){
	var _this = {};
	var images;
	var save_url = "http://schmidtj.spica.uberspace.de/102-A3/app/Lib/pixlr/save.php";

	_this.init = function(event) {
		alert("init");
		initEvent();
	};

	function initEvent() {
		//@TODO: NOT COMPATIBLE WITH IE
		alert("initEvent");
		
		for (var i = 0; i <= 4; i++) {
			document.getElementById("image"+i).onclick = function(){
				alert("image");
				// pixlr.overlay.show({
				// 	image: document.getElementById("image"+i).src,
				// 	title: "Mona-Lisa",
				// 	method: "GET",
				// 	target: URL_SAVE_IMAGE,
				// 	exit: URL_SAVE_IMAGE,
				// 	redirect: "true",
				// 	locktarget: "true",
				// });
			}
		}
	};

	// function initEvent() {
	// 	images = document.getElementByTagName("img");
	// 	alert("initEvent");
	// 	for (var i = 0; i <= images.length - 1; i++) {
	// 		images[i].addEventListener("click", onImageClick);
	// 		alert("image");
	// 	}
	// }

	function onImageClick(source) {
		aler("cookie");
		pixlr.overlay.show({
			image: source,
			// title: "Mona-Lisa",	//needs to be changed!
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

	// function onImageClick(event) {
		// pixlr.overlay.show({
		// 	image: _elmImage.src,
		// 	title: "Mona-Lisa",
		// 	method: "GET",
		// 	target: URL_SAVE_IMAGE,
		// 	exit: URL_SAVE_IMAGE,
		// 	redirect: "true",
		// 	locktarget: "true",
		// });
	// }

return _this;

})();

window.addEventListener("load", Pixlr.init);