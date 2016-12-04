(function($){
	// instantiate the Post Namespace
	$.fn.Post = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare Post methods
	var methods = {
		// handles the login event
		recent: function(options){
			// set the url for ajax request
			var url = location.origin + '/index/post';

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
					var template = $('#homepage-template').html();

					// render the modal template options
					var content = Mustache.render(template, response);

					$('div.account-content').html(content);
				}
			});
		}
	};

	// on click listener for the homepage
	$(document).on('click','a.homepage-list', function(){
		$(document).Post('recent', {page: 1});
	});
})(jQuery);
