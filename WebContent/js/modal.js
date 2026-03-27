var Base64 = {
	_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r);}if(a!=64){t=t+String.fromCharCode(i);}}t=Base64._utf8_decode(t);return t;},
	_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++;}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2;}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3;}}return t;}
};

(function($){
	/**
	 * $.fn.modal
	 * the custom modal wrapper for create/update form
	 *
	 * usage:
	 * $(document).modal(options, template)
	 *
	 * @param options JSON  contains the options for the modal
	 * @param template string  the rendered html content for the modal
	 * @param custom_template string  custom modal-template container
	 *
	 */
	$.fn.modal = function(options, content, custom_template) {
		/**
		 * @var _settings
		 * set the modal settings
		 *
		 * @param bool submit  determines if submit button is displayed
		 * @param bool update  determines if update button is displayed
		 * @param bool multipage  determines if multipage navigation buttons is shown
		 * @param bool cancel  determines if close button is shown
		 * @param bool parent  determines if modal is parent or not
		 * @param string size  determines the size of the modal
		 * @param string title  sets the title of the modal
		 * @param string content is the rendered html content for the modal
		 */
		var _settings= $.extend({
			submit: true,
			update: false,
			multipage: false,
			duplicate: false,
			delete: false,
			cancel: true,
			parent: true,
			search: false,
			size: 'medium',
			title: 'Create',
			content: content,
			comment: false,
			module: ''
		}, options);

		// get the template
		var template, modal_container;

		if (custom_template == null) {
			if (typeof options.new_template !== 'undefined') {
				template = $('#modal-template-confirmation').html();

				// set the modal container
				modal_container = ".confirmation-modal-container";

				if (typeof options.tertiary !== 'undefined') {
					modal_container = ".tertiary-modal-container";
				}

				if (typeof options.quaternary !== 'undefined') {
					modal_container = ".quaternary-modal-container";
				}

				if (typeof options.quinary !== 'undefined') {
					modal_container = ".quinary-modal-container";
				}
			} else {
				template = $('#modal-template').html();

				// set the modal container
				modal_container = ".create-update-modal-container";
			}
		} else {
			template = $('#'+custom_template).html();

			// set the modal container
			modal_container = ".create-update-modal-container";

			if (typeof options.confirm !== 'undefined') {
				modal_container = ".confirmation-modal-container";
			}

			if (typeof options.tertiary !== 'undefined') {
				modal_container = ".tertiary-modal-container";
			}

			if (typeof options.quaternary !== 'undefined') {
				modal_container = ".quaternary-modal-container";
			}

			if (typeof options.quinary !== 'undefined') {
				modal_container = ".quinary-modal-container";
			}
		}

		if (typeof options.notifications !== 'undefined') {
			modal_container = ".notifications-modal-container";
		}

		// add no scroll to body
		$('body').addClass('no-scroll');

		// parse the template
		var rendered = Mustache.render(template, _settings);

		// render the content
		$(modal_container).html(rendered);

		// show the modal
		$(modal_container).fadeIn();

		// verify the modal is visible
		// this will disable body scrolling
		if ($(modal_container).is(":visible")) {
			// disable body scrolling
			$('body').addClass('no-scroll');
		}
	};
})(jQuery);