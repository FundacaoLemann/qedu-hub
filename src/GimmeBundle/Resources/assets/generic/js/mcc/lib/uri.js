/**
 * @requires js/mcc/core/install.js
 *
 * Convert a string URI into a maleable object.
 *
 *   var uri = new mcc.URI('http://www.example.com/asdf.php?a=b&c=d#anchor123');
 *   uri.get_protocol();    // http
 *   uri.get_domain();      // www.example.com
 *   uri.get_path();        // /asdf.php
 *   uri.get_query_params(); // {a: 'b', c: 'd'}
 *   uri.get_fragment();    // anchor123
 *
 * ...and back into a string:
 *
 *   uri.set_fragment('clowntown');
 *   uri.toString() // http://www.example.com/asdf.php?a=b&c=d#clowntown
 */
mcc.install('URI', {
	__static:{
    _uriPattern : /(?:([^:\/?#]+):)?(?:\/\/([^:\/?#]*)(?::(\d*))?)?([^?#]*)(?:\?([^#]*))?(?:#(.*))?/,
    _queryPattern : /(?:^|&)([^&=]*)=?([^&]*)/g,

		/**
		 *  Convert a Javascript object into an HTTP query string.
		 *
		 *  @param  Object  Map of query keys to values.
		 *  @return String  HTTP query string, like 'cow=quack&duck=moo'.
		 */
    objectToQueryString:function (obj) {
			var kv_pairs = [];
      if (obj) {
        for (var key in obj) {
          if (obj[key] != null) {
            var value = encodeURIComponent(obj[key]);
            kv_pairs.push(encodeURIComponent(key) + (value ? '=' + value : ''));
          }
        }
      }

			return kv_pairs.join('&');
		},

    /**
     *  Convert a Javascript object into an HTTP query string.
     *
     *  @param  string  query string, like 'cow=quack&duck=moo'.
     *  @return String  Map of query keys to values.
     */
    queryStringToObject:function (query) {
      var queryData = {};

      if (query) {
        var data;
        while ((data = mcc.URI._queryPattern.exec(query)) != null) {
          queryData[decodeURIComponent(data[1].replace(/\+/g, ' '))] =
            decodeURIComponent(data[2].replace(/\+/g, ' '));
        }
      }

      return queryData;
    }
	},

	/**
	 * Construct a URI
	 *
	 * Accepts either absolute or relative URIs. Relative URIs may have protocol
	 * and domain properties set to undefined
	 *
	 * @param string    absolute or relative URI
	 */
	__construct:function (uri) {
    this.query_params = {};

		if (uri) {
			// parse the url
			var result = mcc.URI._uriPattern.exec(uri);

			// fallback to undefined because IE has weird behavior otherwise
			this.protocol = result[1] || undefined;
			this.domain = result[2] || undefined;
			this.port = result[3] || undefined;
			var path = result[4];
			var query = result[5];
			this.fragment = result[6] || undefined;

			// parse the path
			this.path = path.charAt(0) == '/' ? path : '/' + path;

			// parse the query data
		  this.query_params = mcc.URI.queryStringToObject(query);
		}
	},

	protocol:undefined,
	port:undefined,
	path:undefined,
	query_params:undefined,
	fragment:undefined,
	query_serializer:undefined,
	domain:undefined,

	/**
	 * Append and override query data values
	 * Remove a query key by setting it undefined
	 *
	 * @param map
	 * @return @{mcc.URI} self
	 */
	add_query_params:function (map) {
		this.copy(this.query_params, map);
		return this;
	},

	copy:function (copy_dst, copy_src) {
		for (var k in copy_src) {
			copy_dst[k] = copy_src[k];
		}

		return copy_dst;
	},

	/**
	 * Set a specific query parameter
	 * Remove a query key by setting it undefined
	 *
	 * @param string
	 * @param wild
	 * @return @{mcc.URI} self
	 */
	set_query_param:function (key, value) {
		var map = {};
		map[key] = value;
		return this.add_query_params(map);
	},

	/**
	 * Set the domain
	 *
	 * This function checks the domain name to ensure that it is safe for
	 * browser consumption.
	 */
	set_domain:function (domain) {
		var re = new RegExp(
		// For the bottom 128 code points, we use a strict whitelist of
		// characters that are allowed by all browsers: -.0-9:A-Z[]_a-z
				'[\\x00-\\x2c\\x2f\\x3b-\\x40\\x5c\\x5e\\x60\\x7b-\\x7f' +
		// In IE, these chararacters cause problems when entity-encoded.
						'\\uFDD0-\\uFDEF\\uFFF0-\\uFFFF' +
		// In Safari, these characters terminate the hostname.
						'\\u2047\\u2048\\uFE56\\uFE5F\\uFF03\\uFF0F\\uFF1F]');
		if (re.test(domain)) {
			mcc.exception('mcc.URI.set_domain(...): invalid domain specified.');
		}
		this.domain = domain;
		return this;
	},

	toString:function () {
		if (__DEV__) {
			if (this.path && this.path.charAt(0) != '/') {
				mcc.exception(
						'mcc.URI.toString(): ' +
								'Path does not begin with a "/" which means this URI will likely' +
								'be malformed. Ensure any string passed to .setPath() leads "/"');
			}
		}
		var str = '';

		if (this.protocol) {
			str += this.protocol + '://';
		}

    if (this.domain) {
		  str += this.domain;
    }

    if (this.port) {
      str += ':'+this.port;
    }

		// If there is a domain or a protocol, we need to provide '/' for the
		// path. If we don't have either and also don't have a path, we can omit
		// it to produce a partial URI without path information which begins
		// with "?", "#", or is empty.
		str += this.path || (str ? '/' : '');

		str += this._getQueryString();

		if (this.fragment) {
			str += '#' + this.fragment;
		}
		return str;
	},

	_getQueryString:function () {
		var str = (
				this.query_serializer || mcc.URI.objectToQueryString
				)(this.query_params);
		return str ? '?' + str : '';
	}
});

/**
 * Handy convenience function that returns a @{class:mcc.URI} instance. This
 * allows you to write things like:
 *
 *   mcc.$U('http://zombo.com/').get_domain();
 *
 * @param string Unparsed URI.
 * @return mcc.URI instance.
 */
mcc.$U = function (uri) {
	return new mcc.URI(uri);
};