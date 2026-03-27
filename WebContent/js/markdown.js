(function($){
	// instantiate the Markdown Namespace
	$.fn.Markdown = function (action){
		var args = Array.prototype.slice.call(arguments, 1);
		return methods[ action ].call(this, args);
	};

	// declare Markdown methods here
	var methods = {
	};

	$(document).on('keyup','#editor', function(){
		var text = document.getElementById('editor').value,
		target = document.getElementById('preview'),
		converter = new showdown.Converter(),
		html = converter.makeHtml(text);

		target.innerHTML = html;
	});

	// on click listener for the dashboard
	$(document).on('click','a.markdown-list', function(){
		// set the template
		var template = $('#editor-template').html();

		// render the template options
		var content = Mustache.render(template, {});

		// insert the rendered content
		$('div.account-content').html(content);
	});
})(jQuery);
