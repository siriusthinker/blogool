(function($){
	// instantiate the Dashboard Namespace
	$.fn.Dashboard = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare Dashboard methods
	var methods = {
		// fetch posts of a user
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
					load_dashboard(response);
				}
			});
		},

		// handles the delete event
		delete: function(options){
			// set the url for ajax request
			var url = location.origin + '/posts/delete';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				post_id: options[0].post_id
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
					load_dashboard(response);

					// enable body scrolling
					$('body').removeClass('no-scroll');
					// close the modal
					$('.confirmation-modal-container').fadeOut();
				}
			});
		},

		// handles the update event
		update: function(options){
			// set the url for ajax request
			var url = location.origin + '/posts/update';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				post_id: options[0].post_id,
				status: options[0].status
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
					load_dashboard(response);
				}
			});
		},

		// handles the update event
		create: function(options){
			// set the url for ajax request
			var url = location.origin + '/posts/create';

			// instantiate the transport wrapper for ajax call
			var transport = new Transport();

			// set the request data
			transport.set_request_data({
				content: options[0].content
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
					load_dashboard(response);
				}
			});
		}
	};

	// on click listener for the dashboard
	$(document).on('click','a.dashboard-list', function(){
		$(document).Dashboard('post', {page: 1});
	});

	// on click listener for the delete button
	$(document).on('click','button.post-delete', function(){
		// get the post id from the data attribute
		var post_id = $(this).attr('data-post-id');

		// set any custom modal settings
		var settings = {
			size: "small",
			title: "Delete Confirmation",
			content: "Are you sure you want to delete this post?",
			post_id: post_id,
			confirm: true,
			save: true,
			new_template: true
		};

		$(document).modal(settings, '');
	});

	/**
	 * cancel confirmation modal
	 */
	$(document).on("click", ".confirm-modal-close", function() {
		// enable body scrolling
		$('body').removeClass('no-scroll');
		// close the modal
		$('.confirmation-modal-container').fadeOut();
	});

	/**
	 * save confirmation modal
	 */
	$(document).on("click", ".modal-save-confirmation", function() {
		// get the post id from the data attribute
		var post_id = $(this).attr('data-post-id');

		$(document).Dashboard('delete', {post_id: post_id});
	});

	// on click listener for the publish button
	$(document).on('click','button.post-publish', function(){
		// get the post id from the data attribute
		var post_id = $(this).attr('data-post-id');

		// get the status
		var status = $(this).attr('data-status-update');

		$(document).Dashboard('update', {post_id: post_id, status: status});
	});

	// on click listener for the unpublish button
	$(document).on('click','button.post-unpublish', function(){
		// get the post id from the data attribute
		var post_id = $(this).attr('data-post-id');

		// get the status
		var status = $(this).attr('data-status-update');

		$(document).Dashboard('update', {post_id: post_id, status: status});
	});

	// on click listener for the create new button
	$(document).on('click','button.create-new-post', function(){
		// set the template
		var template = $('#editor-template').html();

		// render the template options
		var content = Mustache.render(template, {});

		// insert the rendered content
		$('div.account-content').html(content);
	});

	// on click listener for the save button
	$(document).on('click','button.markdown-save', function(){
		// set the template
		var preview_element = $('#preview');

		// get the content of the preview page
		var content = preview_element[0].innerHTML;

		$(document).Dashboard('create', {content: content});
	});
})(jQuery);

/**
 * Loads the dashboard content
 * @param object response Response from AJAX call
 * @return void
 */
function load_dashboard(response) {
	// set the template
	var template = $('#dashboard-template').html();

	// render the modal template options
	var content = Mustache.render(template, response);

	$('div.account-content').html(content);
}
