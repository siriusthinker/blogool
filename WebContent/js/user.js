(function($){
	// instantiate the User Namespace
	$.fn.User = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare Login methods
	var methods = {
		// handles the login event
		login: function(options){
			// set the url for ajax request
			var url = location.origin + '/login';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				user_data: options[0].user_data,
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
				// display result as datatable
				$(document).User('table', response.results);
			});
		}
	};
})(jQuery);


/**
* Called upon clicking the Google signin button
* @param {Object} googleUser
* @return void
*/
function onSignIn(googleUser) {
	// get the user's basic profile data
	var user_profile = googleUser.getBasicProfile();

	// set user_data
	var user_data = {
		id: user_profile.getId(),
		name: user_profile.getName(),
		given_name: user_profile.getGivenName(),
		family_name: user_profile.getFamilyName(),
		image_url: user_profile.getImageUrl(),
		email: user_profile.getEmail()
	};

	// get the id token for the current session
	var id_token = googleUser.getAuthResponse().id_token;

	// call login method for server side authentication
	$(document).User('login', {user_data: user_data, id_token: id_token});
}
