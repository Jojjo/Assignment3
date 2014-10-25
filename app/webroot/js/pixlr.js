//--------------------------------------------------------------------------
// Public static class
//--------------------------------------------------------------------------

/**
 *	Document class for the application.
 *
 *	@version	1.0
 *	@copyright	Copyright (c) 2012-2014.
 *	@license	Creative Commons (BY-NC-SA)
 *	@since		Sep 25, 2014
 *	@author		Henrik Andersen <henrik.andersen@lnu.se>
 */
var Pixlr = (function() {

	//----------------------------------------------------------------------
	// Private properties
	//----------------------------------------------------------------------
	
	/**
	 *	Reference to the object's public scope. This structure is the 
	 *	result of the class self invoking nature.
	 *
	 *	@type {Object}
	 */
	var _this = {};

	/**
	 *	Reference to the image displayed on the HTML page (Mona-Lisa).
	 *
	 *	@type {undefined}
	 */
	var _elmImage;

	//----------------------------------------------------------------------
	// Private constants
	//----------------------------------------------------------------------
	
	/**
	 *	The path to the php script which saves the image.
	 *
	 *	@type {String}
	 */
	var URL_SAVE_IMAGE = "http://schmidtj.spica.uberspace.de/102-A3/app/Lib/pixlr/save.php";

	//----------------------------------------------------------------------
	// Private methods
	//----------------------------------------------------------------------

	/**
	 *	Acts as a constructor for the object.
	 *
	 *	@param	{Event}	The event that triggered this method
	 *
	 *	@return {undefined}
	 */
	_this.init = function(event) {
		initEvent();
	};
	
	/**
	 *	Retrieves and applies the event listener to the image displayed 
	 *	on the HTML page.
	 *
	 *	@return {undefined}
	 */
	function initEvent() {
		//@TODO: NOT COMPATIBLE WITH IE
		_elmImage = document.getElementById("image");
		_elmImage.addEventListener("click", onImageClick);
	}

	/**
	 *	Activated when the user clicks on the Mona Lisa. The method uses 
	 *	Pixlr's API to activate the image editor. For more information, 
	 *	see Pixlr documentation.
	 *
	 *	@param	{Event}	The event that triggered this method
	 *
	 *	@return {undefined}
	 */
	function onImageClick(event) {
		pixlr.overlay.show({
			image: _elmImage.src,
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

/**
 *	BOOTSTRAP
 */
window.addEventListener("load", Pixlr.init);