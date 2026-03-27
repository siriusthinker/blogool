(function($){
	// instantiate the User Namespace
	$.fn.User = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare User methods
	var methods = {
		// handles the login event
		login: function(options){
			// set the url for ajax request
			var url = location.origin + '/login';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				id_token: options[0].id_token
			});

			// Set content request type
			transport.set_request_method('POST');

			// set the content type
			transport.set_content_type('application/x-www-form-urlencoded; charset=UTF-8');

			// perform the ajax request
			transport.request(url);

			// handle the response
			transport.on('success', function(response, status, xhr){
				if(response.status === 200) {
					window.location = "/";
				}
			});
		}
	};
})(jQuery);

/**
* Called on successful signin
* @param {Object} googleUser
* @return void
*/
function onSignIn(googleUser) {

	// get the id token for the current session
	var id_token = googleUser.getAuthResponse().id_token;

	if($("#editor-page").length === 0) {
		// call login method for server side authentication
		$(document).User('login', {id_token: id_token});
	}
}
