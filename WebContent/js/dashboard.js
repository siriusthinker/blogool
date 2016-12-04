(function($){
	// instantiate the Dashboard Namespace
	$.fn.Dashboard = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare Dashboard methods
	var methods = {
		// handles the login event
		post: function(options){
			// set the url for ajax request
			var url = location.origin + '/posts/index';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				page: options[0].page
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

					// set the template
					var template = $('#dashboard-template').html();

					// render the modal template options
					var content = Mustache.render(template, response);

					$('div.account-content').html(content);
				}
			});
		}
	};

	// on click listener for the dashboard
	$(document).on('click','a.dashboard-list', function(){
		$(document).Dashboard('post', {page: 1});
	});
})(jQuery);
