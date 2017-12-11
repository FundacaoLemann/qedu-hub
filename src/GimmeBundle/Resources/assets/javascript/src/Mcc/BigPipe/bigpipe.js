/**
 * @requires js/mcc/core/install.js
 *           js/underscore.js
 *
 * BigPipe is responsible for controlling the async load of the page using pieces that contains HTML code, dependency
 * information and callback function.
 *
 * Here we are also capable of loading resources alone, async or not.
 *
 * This class is all static and should be called using:
 *
 * mcc.BigPipe.start();
 * mcc.BigPipe.append_piece({piece_1});
 * mcc.BigPipe.append_piece({piece_2});
 * mcc.BigPipe.append_piece({piece_3});
 *
 * @note The async load and wait of the pieces is not a very nice implementation, but it works. Some time we could rewrite it...
 *
 * @todo document this better
 *       allow the use of a resource mapper
 *
 */

mcc.install('BigPipe', {
	__static: {
		_loading: {},
		_loaded: {},
		_links: [],
		_callbacks: [],

		_ie: NaN, // Internet Explorer Version

		_started: false,

		_stage_buffer: [],
		_loading_pieces_by_stage: [],

		_last_appended_stage: 0, // The last piece that we were asked to load
		_can_render_stage: 0,  // Until witch stage we can render?

		start: function() {
			if (mcc.BigPipe._started) {
				if (__DEV__) {
					console.log('BigPipe: You should not call BigPipe.start() more then once, check your server-side code!');
				}

				return;
			}

			mcc.BigPipe._started = true;

			// Checks if it is IE and its version, if its not IE then this variable will be NaN
			mcc.BigPipe._ie = document.documentMode || +(/MSIE.(\d+)/.exec(navigator.userAgent) || [])[1];

			if (__DEV__) {
				if (mcc.BigPipe._ie) {
					console.log('BigPipe: You are using IE version: '+mcc.BigPipe._ie);
				}
			}

			mcc.BigPipe._check_head_loads();
		},

		/**
		 *
		 * We expect server to send pieces in order.
		 *
		 * @param piece
		 * @param callback
		 */
		append_piece: function(piece, callback) {
			// Call start if we haven't done
			if ( ! mcc.BigPipe._started) {
				mcc.BigPipe.start();
			}

			// If the piece has no name
			if (_.isUndefined(piece.name)) {
				piece.name = 'piece_'+piece.stage+'_'+piece.position;
			}

			// If the piece has no stage, then we define it to the last appended stage
			if (_.isUndefined(piece.stage)) {
				piece.stage = mcc.BigPipe._last_appended_stage;
			}

			// If the piece stage is bigger then then last appended then we can try to update the last completed stage
			if (piece.stage > mcc.BigPipe._last_appended_stage) {
				var can_update_stage = true;

				for (var stage = 0; stage <= mcc.BigPipe._last_appended_stage; stage++) {
					// If we have loading pieces on stages before this then we can not mark this stage as completed
					if (mcc.BigPipe._loading_pieces_by_stage[stage] && mcc.BigPipe._loading_pieces_by_stage[stage] > 0)
						can_update_stage = false;

					// If we have not yet rendered pieces on stages before this then we can not mark this stage as completed
					if (mcc.BigPipe._stage_buffer[piece.stage] && mcc.BigPipe._stage_buffer[piece.stage].length > 0)
						can_update_stage = false;
				}

				if (can_update_stage) {
					mcc.BigPipe._can_render_stage = piece.stage;
				}

				// Increments the last appended stage
				mcc.BigPipe._last_appended_stage = piece.stage;
			}

			// Setup the final callback that will inject the piece contents on the document after all dependencies are loaded.
			var final_callback = _.bind(function(piece, callback) {
				// Decrement loading pieces
				mcc.BigPipe._loading_pieces_by_stage[piece.stage]--;

				// Puts this piece into the buffer to be rendered
				if (_.isUndefined(mcc.BigPipe._stage_buffer[piece.stage]))
					mcc.BigPipe._stage_buffer[piece.stage] = [];

				mcc.BigPipe._stage_buffer[piece.stage].push([piece, callback]);

				mcc.BigPipe._resolve_buffered_stages();
			}, this, piece, callback);

			// Increment loading pieces of this stage
			if (_.isUndefined(mcc.BigPipe._loading_pieces_by_stage[piece.stage]))
				mcc.BigPipe._loading_pieces_by_stage[piece.stage] = 0;

			mcc.BigPipe._loading_pieces_by_stage[piece.stage]++;

			// If resources is a string, pass it to array
			if (_.isString(piece.resources))
				piece.resources = [piece.resources];

			// Loads all the needed resources asynchronously and calls the final callback when finished
			if (_.isArray(piece.resources) && piece.resources.length > 0) {
				mcc.BigPipe.load_resources(piece.resources, final_callback, true);
			} else {
				// If there is no resource, just calls the final callback
				final_callback();
			}
		},

		_resolve_buffered_stages: function() {
			for(var stage = 0; stage <= mcc.BigPipe._stage_buffer.length; stage++) {
				var pieces = mcc.BigPipe._stage_buffer[stage];

				// If we do not have stuff to be rendered on this stage or we can not render this stage then we do not advance
				if ( ! pieces || pieces.length === 0 || stage > mcc.BigPipe._can_render_stage)
					continue;

				// Render pieces of this stage
				for(var i = 0; i < pieces.length; i++) {
					if ( ! pieces[i])
						continue;

					var piece = pieces[i][0],
						callback = pieces[i][1];

					mcc.BigPipe._render_piece(piece, callback);
				}

				// Removes this pieces from the buffer
				mcc.BigPipe._stage_buffer[stage] = undefined;

				/*
				 * If we do not have more pending pieces on this stage and have appended more pieces to next stages then
				 * we can mark the next stage possible as ready to render. Note that we might have stages 1..2..5..6, so
				 * we need to jump from 2 to 5
				 */
				if (stage < mcc.BigPipe._last_appended_stage && mcc.BigPipe._loading_pieces_by_stage[stage] === 0) {
					for(var next_ready_stage = mcc.BigPipe._can_render_stage + 1; next_ready_stage <= mcc.BigPipe._last_appended_stage; next_ready_stage++) {
						mcc.BigPipe._can_render_stage = next_ready_stage;

						// If we have loading or buffered pieces, then we have reached the next state to be ready to render
						if (mcc.BigPipe._loading_pieces_by_stage[next_ready_stage] || (mcc.BigPipe._stage_buffer[next_ready_stage] && mcc.BigPipe._stage_buffer[next_ready_stage].length > 0))
							break;
					}
				}
			}
		},

		_render_piece: function(piece, callback) {
			var $content_source,
				$content_target;

			if (piece.content_source)
				$content_source = document.getElementById(piece.content_source);

			// If the content source is an valid element and has valid HTML then we write the HTML to the target or document
			if ($content_source) {
				var html = mcc.BigPipe._extract_html($content_source);

				if (html) {
					if (piece.content_target) {
						$content_target = document.getElementById(piece.content_target);

						if ($content_target) {
							mcc.BigPipe._inject_html($content_target, html, piece.content_replace);
						}

						if (__DEV__) {
							if ( ! $content_target) {
								mcc.exception('BigPipe: The content target of id "'+piece.content_target+'" was not found on the document!');
							}
						}
					} else {
						// Tries to include the content right before the source
						// We can not use document.write cause this will be called latter in the execution plan...
						var $wrapper = document.createElement('div');
						mcc.BigPipe._inject_html($wrapper, html);

						while ($wrapper.firstChild) {
							//target.removeChild(target.firstChild);
							$content_source.parentNode.insertBefore($wrapper.firstChild, $content_source);
						}
					}

				}

				// Removes the content source element
				$content_source.parentNode.removeChild($content_source);
			}

			// Calls the callback
			if (callback && _.isFunction(callback)) {
				try {
					callback();
				} catch(e) {
					if (__DEV__) {
						mcc.log('There was na exception on the callback of the piece '+piece.name+': '+e);
                        throw e;
					}
				}
			}
		},

		/**
		 * Extracts HTML code from the container. The HTML code should be inside HTML comments <!-- -->
		 *
		 * @param $container
		 */
		_extract_html: function($container) {
			if (!$container.firstChild) {
				return null;
			}

			// Checks if the nodeType is a COMMENT_NODE, see [http://www.w3schools.com/dom/dom_nodetype.asp]
			if ($container.firstChild.nodeType !== 8)
				return null;

			var comment = $container.firstChild.nodeValue;
			comment = comment.substring(1, comment.length - 1);

      return comment
        .replace(/\\([\s\S]|$)/g, '$1')
        .replace('&lt;!--', '<!--')
        .replace('--&gt;', '-->');
		},

		/**
		 * Injects HTML into the container. Note that this method will NOT execute any javascript inside the html markup.
		 * If you want to run javascript you MUST use Behaviors.
		 *
		 * @param $container
		 * @param html
		 */
		_inject_html: function($container, html, replace) {
			// If we have to replace content and are not using IE we will just set innerHTML, otherwise remove child-by-child and append
			if (replace) {
				if (mcc.BigPipe._ie < 8) {
					while ($container.firstChild) {
						$container.removeChild($container.firstChild);
					}
				} else {
					$container.innerHTML = html;

					return;
				}
			}

		    var nn = document.createElement('div');
		    var ie_6_and_7_sux = mcc.BigPipe._ie < 7;
		    if (ie_6_and_7_sux) $container.appendChild(nn);
		    nn.innerHTML = html;
		    var frag = document.createDocumentFragment();
		    while (nn.firstChild) frag.appendChild(nn.firstChild);
		    $container.appendChild(frag);
		    if (ie_6_and_7_sux) $container.removeChild(nn);
		},

		/**
		 * This part is independent of the bigpipe piece dealing and can became a separate part later
		 */

		/**
		 * Loads a list of resources and call the callback when its done loading.
		 *
		 * @todo in the future we should be able to set timeouts and handle errors, maybe using promises...
		 *       in the future we should be able to load images and other resources and pass it in the callback
		 *
		 * @param list
		 * @param callback
		 * @param async
		 */
		load_resources: function(list, callback, async) {
			// Async load is the default
			async = async || true;

			// Call start if we haven't done
			if ( ! mcc.BigPipe._started) {
				mcc.BigPipe.start();
			}

			var resources = {},
					uri, resource, path, type;

			list = _.isArray(list) ? list : [list];
			for (var ii = 0; ii < list.length; ii++) {
//				uri = new JX.URI(list[ii]);
//				resource = uri.toString();
//				path = uri.getPath();
				uri = list[ii];
				resource = uri;
				path = uri;
				resources[resource] = true;

				if (mcc.BigPipe._loaded[resource]) {
					_.defer(mcc.BigPipe._complete, resource);
				} else if (!mcc.BigPipe._loading[resource]) {
					mcc.BigPipe._loading[resource] = true;
					if (path.indexOf('.css') == path.length - 4) {
						mcc.BigPipe._loadCSS(resource);
					} else {
						mcc.BigPipe._loadJS(resource, async);
					}
				}
			}

			mcc.BigPipe._callbacks.push({
				resources:resources,
				callback:callback
			});
		},

		unload_resources: function(list, callback) {
			// @todo implement the unload of resources (limited to CSS!)
		},

		_loadJS:function (uri, async) {
			// Async load is the default
			async = async || true;

			var script = document.createElement('script');
			var callback = function () {
				this.onload = this.onerror = this.onreadystatechange = null;
				mcc.BigPipe._complete(uri);
			};

			_.extend(script, {
				type:'text/javascript',
				src:uri
			});

			if (async)
				script.async = true;

			script.onload = script.onerror = callback;
			script.onreadystatechange = function () {
				var state = this.readyState;
				if (state == 'complete' || state == 'loaded') {
					callback();
				}
			};
			document.getElementsByTagName('head')[0].appendChild(script);
		},

		_loadCSS:function (uri) {
			var link = _.extend(document.createElement('link'), {
				type:'text/css',
				rel:'stylesheet',
				href:uri,
				'data-href':uri // don't trust href
			});
			document.getElementsByTagName('head')[0].appendChild(link);

			mcc.BigPipe._links.push(link);
			if (!mcc.BigPipe._timer) {
				mcc.BigPipe._timer = setInterval(mcc.BigPipe._poll_for_css, 20);
			}
		},

		_poll_for_css:function () {
			var sheets = document.styleSheets,
					ii = sheets.length,
					links = mcc.BigPipe._links;

			// Cross Origin CSS loading
			// http://yearofmoo.com/2011/03/cross-browser-stylesheet-preloading/
			while (ii--) {
				var link = sheets[ii],
						owner = link.ownerNode || link.owningElement,
						jj = links.length;
				if (owner) {
					while (jj--) {
						if (owner == links[jj]) {
							mcc.BigPipe._complete(links[jj]['data-href']);
							links.splice(jj, 1);
						}
					}
				}
			}

			if (!links.length) {
				clearInterval(mcc.BigPipe._timer);
				mcc.BigPipe._timer = null;
			}
		},

		_complete:function (uri) {
			var list = mcc.BigPipe._callbacks,
					current, ii;

			delete mcc.BigPipe._loading[uri];
			mcc.BigPipe._loaded[uri] = true;

			for (ii = 0; ii < list.length; ii++) {
				current = list[ii];
				delete current.resources[uri];
				if (!mcc.BigPipe._hasResources(current.resources)) {
          if (_.isFunction(current.callback)){
					  current.callback();
          }
					list.splice(ii--, 1);
				}
			}
		},

		_hasResources:function (resources) {
			for (var hasResources in resources) {
				return true;
			}
			return false;
		},

		_check_head_loads: function() {
			// checks for loaded resources
			var list = _.toArray(document.getElementsByTagName('link')),
				ii = list.length,
				node;

			while ((node = list[--ii])) {
				if (node.type === 'text/css' && node.href) {
					// @todo (new mcc.URI(node.href)).toString()
					mcc.BigPipe._loaded[node.href] = true;
				}
			}

			list = _.toArray(document.getElementsByTagName('script'));
			ii = list.length;

			while ((node = list[--ii])) {
				if (node.type === 'text/javascript' && node.src) {
					// @todo (new mcc.URI(node.src)).toString()
					mcc.BigPipe._loaded[node.src] = true;
				}
			}
		}
	}
});