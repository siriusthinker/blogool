/**
 * Transport Ajax wrapper.
 *
 * Depends:
 * 	- jQuery
 */
var Transport = (function() {
	"use strict";

	/**
	 * Default content type of ajax request
	 *
	 * @type string
	 */
	var __content_type = 'application/json'

	/**
	 * Ajax request headers
	 *
	 * @type object
	 */
	,__request_headers = {}

	/**
	 * Default data type of ajax request
	 *
	 * @type string
	 */
	,__data_type = 'json'

	/**
	 * Ajax request method
	 *
	 * @type string
	 */
	,__request_method = 'GET'

	/**
	 * Ajax request url
	 *
	 * @type string
	 */
	,__request_url = null

	/**
	 * Holds the ajax processes
	 *
	 * @type object
	 */
	,__xhrs = []

	/**
	 * Data variable that will be sent to ajax request
	 *
	 * @type object
	 */
	,__data = {}

	/**
	 * Data variable that will be sent to ajax request
	 *
	 * @type object
	 */
	,__process_data = true

	/**
	 * Event listener class
	 *
	 * @type object
	 */
	,Event = {
		/**
		 * Holds event listeners
		 *
		 * @type object
		 */
		listeners: {}

		/**
		 * Attach single event
		 *
		 * @param string eventName
		 * @param function callback
		 * @return void
		 */
		,attach: function(eventName, callback) {
			if ( ! this.listeners.hasOwnProperty(eventName)) {
				this.listeners[eventName] = [];
			}

			// Add event name to listeners array
			this.listeners[eventName].push(callback);
		}

		/**
		 * Fire events
		 *
		 * @param string eventName
		 * @return mixed
		 */
		,fire: function(eventName) {

			// Check if there's an eventName
			if (this.listeners.hasOwnProperty(eventName)) {
				// Execute event listeners
				for (var i in this.listeners[eventName]) {
					this.listeners[eventName][i].apply(this, Array.prototype.splice.call(arguments, 1));
				}
			}
		}
	}

	/**
	 * Method used to set something like header and data
	 *
	 * @param json vars Existing variable data
	 * @param mixed key Data key
	 * @param mixed value Data value
	 * @return json
	 */
	,__setter = function(vars, key, value) {
		// Check if key is plain object
		// and merge it to evar
		if ((key instanceof FormData) === true) {
			vars = key;
		}

		else if (jQuery.isPlainObject(key)) {
			// Merge key to vars
			vars = jQuery.extend({}, vars, key);
		}

		// Otherwise this is just a plain key value pair
		else {
			vars[key] = value;
		}

		// Return vars
		return vars;
	}

	/**
	 * Aborts all ajax process
	 *
	 * @return void
	 */
	,__abort_xhrs = function() {
		jQuery.each(__xhrs, function(id, jqXHR) {
				jqXHR.abort();
			}
		);
	}

	/**
	 * Removes ajax process
	 *
	 * @param object jqXHR
	 * @return void
	 */
	,__remove_xhr = function(jqXHR) {
		__xhrs = jQuery.grep(__xhrs, function(x) {
				return x != jqXHR;
			}
		);
	};

	return {

		/**
		 * Set ajax url
		 *
		 * @param string url
		 */
		set_url: function(url) {
			__request_url = url;
		}

		/**
		 * Set data type method
		 *
		 * @param string type
		 */
		,set_request_data_type: function(type) {
			__data_type = type;
		}

		/**
		 * Set ajax method. "POST", "GET", "PUT"
		 *
		 * @param string method
		 */
		,set_request_method: function(method) {
			// Convert to uppercase
			method = method.toUpperCase();

			// Check if method is valid
			if (jQuery.inArray(method, ['POST', 'GET', 'PUT']) === -1) {
				throw new Error('Parameter method must be one of the following: POST, GET, PUT.');
			}

			// Set request method
			__request_method = method;
		}

		/**
		 * Set content type method
		 *
		 * @param string type
		 */
		,set_content_type: function(type) {
			__content_type = type;
		}

		/**
		 * Registering event listener
		 *
		 * @param string key
		 * @param function callback
		 * @return void
		 */
		,on: function(key, callback) {
			Event.attach(key, callback);
		}

		/**
		 * Set ajax header
		 *
		 * @param mixed k Header key
		 * @param string v Header value
		 */
		,set_request_header: function(k, v) {
			__request_headers = __setter(__request_headers, k, v);
		}

		/**
		 * Set post data
		 *
		 * @param mixed k Data key
		 * @param string v Data value
		 */
		,set_request_data: function(k, v) {
			__data = __setter(__data, k, v);
		}

		/**
		 * Set processData flag
		 *
		 * @param string process_flag
		 */
		,set_process_data: function(process_flag) {
			__process_data = process_flag;
		}

		/**
		 * This will trigger ajax request
		 *
		 * @param string url
		 * @return void
		 */
		,request: function(url) {

			// Set request url if there is
			__request_url = url || __request_url;

			// Check if there is a valid request url
			if ( ! __request_url) {
				throw new Error('The __request_url is required.');
			}

			// Send ajax request
			jQuery.ajax({
				// Set content type
				contentType: __content_type ,dataType: __data_type

				// Set url, type, data
				,url: __request_url ,type: __request_method ,data: __data, processData: __process_data

				// On ajax before send
				,beforeSend: function(jqXHR) {

					// Abort any previous ajax request before executing another
					__abort_xhrs();

					// Add xhr request to xhrs
					__xhrs.push(jqXHR);

					// Set request headers if there is/are
					if (Object.keys(__request_headers).length) {
						// Loop through each request headers
						jQuery.each(__request_headers, function(k, v) {
								jqXHR.setRequestHeader(k, v);
							}
						);
					}

					// Fire beforeSend event listener
					Event.fire('beforeSend', jqXHR);
				}

				// On ajax success
				,success: function(data, textStatus, jqXHR) {
					// Remove and reset xhrs on success
					__remove_xhr(jqXHR);

					// Fire error event listeners
					Event.fire('success', data, textStatus, jqXHR);
				}

				// On ajax error
				,error: function(jqXHR, textStatus, errorThrown) {
					// // Remove xhr on error
					__remove_xhr(jqXHR);

					// Fire error event listeners
					Event.fire('error', jqXHR, textStatus, errorThrown);
				}
			});
		}
	}
});