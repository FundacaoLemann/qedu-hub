/* Modernizr 2.6.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-fontface-backgroundsize-boxshadow-hsla-multiplebgs-opacity-rgba-textshadow-cssanimations-generatedcontent-cssgradients-csstransforms-csstransforms3d-csstransitions-canvas-canvastext-draganddrop-hashchange-history-video-localstorage-postmessage-websockets-webworkers-geolocation-inlinesvg-svg-touch-cssclasses-teststyles-testprop-testallprops-hasevent-prefixes-domprefixes
 */
;



window.Modernizr = (function( window, document, undefined ) {

  var version = '2.6.1',

    Modernizr = {},

    enableClasses = true,

    docElement = document.documentElement,

    mod = 'modernizr',
    modElem = document.createElement(mod),
    mStyle = modElem.style,

    inputElem  ,

    smile = ':)',

    toString = {}.toString,

    prefixes = ' -webkit- -moz- -o- -ms- '.split(' '),



    omPrefixes = 'Webkit Moz O ms',

    cssomPrefixes = omPrefixes.split(' '),

    domPrefixes = omPrefixes.toLowerCase().split(' '),

    ns = {'svg': 'http://www.w3.org/2000/svg'},

    tests = {},
    inputs = {},
    attrs = {},

    classes = [],

    slice = classes.slice,

    featureName,


    injectElementWithStyles = function( rule, callback, nodes, testnames ) {

      var style, ret, node,
        div = document.createElement('div'),
        body = document.body,
        fakeBody = body ? body : document.createElement('body');

      if ( parseInt(nodes, 10) ) {
        while ( nodes-- ) {
          node = document.createElement('div');
          node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
          div.appendChild(node);
        }
      }

      style = ['&#173;','<style id="s', mod, '">', rule, '</style>'].join('');
      div.id = mod;
      (body ? div : fakeBody).innerHTML += style;
      fakeBody.appendChild(div);
      if ( !body ) {
        fakeBody.style.background = "";
        docElement.appendChild(fakeBody);
      }

      ret = callback(div, rule);
      !body ? fakeBody.parentNode.removeChild(fakeBody) : div.parentNode.removeChild(div);

      return !!ret;

    },



    isEventSupported = (function() {

      var TAGNAMES = {
        'select': 'input', 'change': 'input',
        'submit': 'form', 'reset': 'form',
        'error': 'img', 'load': 'img', 'abort': 'img'
      };

      function isEventSupported( eventName, element ) {

        element = element || document.createElement(TAGNAMES[eventName] || 'div');
        eventName = 'on' + eventName;

        var isSupported = eventName in element;

        if ( !isSupported ) {
          if ( !element.setAttribute ) {
            element = document.createElement('div');
          }
          if ( element.setAttribute && element.removeAttribute ) {
            element.setAttribute(eventName, '');
            isSupported = is(element[eventName], 'function');

            if ( !is(element[eventName], 'undefined') ) {
              element[eventName] = undefined;
            }
            element.removeAttribute(eventName);
          }
        }

        element = null;
        return isSupported;
      }
      return isEventSupported;
    })(),


    _hasOwnProperty = ({}).hasOwnProperty, hasOwnProp;

  if ( !is(_hasOwnProperty, 'undefined') && !is(_hasOwnProperty.call, 'undefined') ) {
    hasOwnProp = function (object, property) {
      return _hasOwnProperty.call(object, property);
    };
  }
  else {
    hasOwnProp = function (object, property) {
      return ((property in object) && is(object.constructor.prototype[property], 'undefined'));
    };
  }


  if (!Function.prototype.bind) {
    Function.prototype.bind = function bind(that) {

      var target = this;

      if (typeof target != "function") {
        throw new TypeError();
      }

      var args = slice.call(arguments, 1),
        bound = function () {

          if (this instanceof bound) {

            var F = function(){};
            F.prototype = target.prototype;
            var self = new F();

            var result = target.apply(
              self,
              args.concat(slice.call(arguments))
            );
            if (Object(result) === result) {
              return result;
            }
            return self;

          } else {

            return target.apply(
              that,
              args.concat(slice.call(arguments))
            );

          }

        };

      return bound;
    };
  }

  function setCss( str ) {
    mStyle.cssText = str;
  }

  function setCssAll( str1, str2 ) {
    return setCss(prefixes.join(str1 + ';') + ( str2 || '' ));
  }

  function is( obj, type ) {
    return typeof obj === type;
  }

  function contains( str, substr ) {
    return !!~('' + str).indexOf(substr);
  }

  function testProps( props, prefixed ) {
    for ( var i in props ) {
      var prop = props[i];
      if ( !contains(prop, "-") && mStyle[prop] !== undefined ) {
        return prefixed == 'pfx' ? prop : true;
      }
    }
    return false;
  }

  function testDOMProps( props, obj, elem ) {
    for ( var i in props ) {
      var item = obj[props[i]];
      if ( item !== undefined) {

        if (elem === false) return props[i];

        if (is(item, 'function')){
          return item.bind(elem || obj);
        }

        return item;
      }
    }
    return false;
  }

  function testPropsAll( prop, prefixed, elem ) {

    var ucProp  = prop.charAt(0).toUpperCase() + prop.slice(1),
      props   = (prop + ' ' + cssomPrefixes.join(ucProp + ' ') + ucProp).split(' ');

    if(is(prefixed, "string") || is(prefixed, "undefined")) {
      return testProps(props, prefixed);

    } else {
      props = (prop + ' ' + (domPrefixes).join(ucProp + ' ') + ucProp).split(' ');
      return testDOMProps(props, prefixed, elem);
    }
  }



  tests['canvas'] = function() {
    var elem = document.createElement('canvas');
    return !!(elem.getContext && elem.getContext('2d'));
  };

  tests['canvastext'] = function() {
    return !!(Modernizr['canvas'] && is(document.createElement('canvas').getContext('2d').fillText, 'function'));
  };
  tests['touch'] = function() {
    var bool;

    if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
      bool = true;
    } else {
      injectElementWithStyles(['@media (',prefixes.join('touch-enabled),('),mod,')','{#modernizr{top:9px;position:absolute}}'].join(''), function( node ) {
        bool = node.offsetTop === 9;
      });
    }

    return bool;
  };



  tests['geolocation'] = function() {
    return 'geolocation' in navigator;
  };


  tests['postmessage'] = function() {
    return !!window.postMessage;
  };    tests['hashchange'] = function() {
    return isEventSupported('hashchange', window) && (document.documentMode === undefined || document.documentMode > 7);
  };

  tests['history'] = function() {
    return !!(window.history && history.pushState);
  };

  tests['draganddrop'] = function() {
    var div = document.createElement('div');
    return ('draggable' in div) || ('ondragstart' in div && 'ondrop' in div);
  };

  tests['websockets'] = function() {
    return 'WebSocket' in window || 'MozWebSocket' in window;
  };


  tests['rgba'] = function() {
    setCss('background-color:rgba(150,255,150,.5)');

    return contains(mStyle.backgroundColor, 'rgba');
  };

  tests['hsla'] = function() {
    setCss('background-color:hsla(120,40%,100%,.5)');

    return contains(mStyle.backgroundColor, 'rgba') || contains(mStyle.backgroundColor, 'hsla');
  };

  tests['multiplebgs'] = function() {
    setCss('background:url(https://),url(https://),red url(https://)');

    return (/(url\s*\(.*?){3}/).test(mStyle.background);
  };    tests['backgroundsize'] = function() {
    return testPropsAll('backgroundSize');
  };
  tests['boxshadow'] = function() {
    return testPropsAll('boxShadow');
  };

  tests['textshadow'] = function() {
    return document.createElement('div').style.textShadow === '';
  };


  tests['opacity'] = function() {
    setCssAll('opacity:.55');

    return (/^0.55$/).test(mStyle.opacity);
  };


  tests['cssanimations'] = function() {
    return testPropsAll('animationName');
  };    tests['cssgradients'] = function() {
    var str1 = 'background-image:',
      str2 = 'gradient(linear,left top,right bottom,from(#9f9),to(white));',
      str3 = 'linear-gradient(left top,#9f9, white);';

    setCss(
      (str1 + '-webkit- '.split(' ').join(str2 + str1) +
        prefixes.join(str3 + str1)).slice(0, -str1.length)
    );

    return contains(mStyle.backgroundImage, 'gradient');
  };    tests['csstransforms'] = function() {
    return !!testPropsAll('transform');
  };


  tests['csstransforms3d'] = function() {

    var ret = !!testPropsAll('perspective');

    if ( ret && 'webkitPerspective' in docElement.style ) {

      injectElementWithStyles('@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}', function( node, rule ) {
        ret = node.offsetLeft === 9 && node.offsetHeight === 3;
      });
    }
    return ret;
  };


  tests['csstransitions'] = function() {
    return testPropsAll('transition');
  };



  tests['fontface'] = function() {
    var bool;

    injectElementWithStyles('@font-face {font-family:"font";src:url("https://")}', function( node, rule ) {
      var style = document.getElementById('smodernizr'),
        sheet = style.sheet || style.styleSheet,
        cssText = sheet ? (sheet.cssRules && sheet.cssRules[0] ? sheet.cssRules[0].cssText : sheet.cssText || '') : '';

      bool = /src/i.test(cssText) && cssText.indexOf(rule.split(' ')[0]) === 0;
    });

    return bool;
  };

  tests['generatedcontent'] = function() {
    var bool;

    injectElementWithStyles(['#modernizr:after{content:"',smile,'";visibility:hidden}'].join(''), function( node ) {
      bool = node.offsetHeight >= 1;
    });

    return bool;
  };
  tests['video'] = function() {
    var elem = document.createElement('video'),
      bool = false;

    try {
      if ( bool = !!elem.canPlayType ) {
        bool      = new Boolean(bool);
        bool.ogg  = elem.canPlayType('video/ogg; codecs="theora"')      .replace(/^no$/,'');

        bool.h264 = elem.canPlayType('video/mp4; codecs="avc1.42E01E"') .replace(/^no$/,'');

        bool.webm = elem.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,'');
      }

    } catch(e) { }

    return bool;
  };



  tests['localstorage'] = function() {
    try {
      localStorage.setItem(mod, mod);
      localStorage.removeItem(mod);
      return true;
    } catch(e) {
      return false;
    }
  };



  tests['webworkers'] = function() {
    return !!window.Worker;
  };    tests['svg'] = function() {
    return !!document.createElementNS && !!document.createElementNS(ns.svg, 'svg').createSVGRect;
  };

  tests['inlinesvg'] = function() {
    var div = document.createElement('div');
    div.innerHTML = '<svg/>';
    return (div.firstChild && div.firstChild.namespaceURI) == ns.svg;
  };    for ( var feature in tests ) {
    if ( hasOwnProp(tests, feature) ) {
      featureName  = feature.toLowerCase();
      Modernizr[featureName] = tests[feature]();

      classes.push((Modernizr[featureName] ? '' : 'no-') + featureName);
    }
  }



  Modernizr.addTest = function ( feature, test ) {
    if ( typeof feature == 'object' ) {
      for ( var key in feature ) {
        if ( hasOwnProp( feature, key ) ) {
          Modernizr.addTest( key, feature[ key ] );
        }
      }
    } else {

      feature = feature.toLowerCase();

      if ( Modernizr[feature] !== undefined ) {
        return Modernizr;
      }

      test = typeof test == 'function' ? test() : test;

      if (enableClasses) {
        docElement.className += ' ' + (test ? '' : 'no-') + feature;
      }
      Modernizr[feature] = test;

    }

    return Modernizr;
  };


  setCss('');
  modElem = inputElem = null;


  Modernizr._version      = version;

  Modernizr._prefixes     = prefixes;
  Modernizr._domPrefixes  = domPrefixes;
  Modernizr._cssomPrefixes  = cssomPrefixes;


  Modernizr.hasEvent      = isEventSupported;

  Modernizr.testProp      = function(prop){
    return testProps([prop]);
  };

  Modernizr.testAllProps  = testPropsAll;


  Modernizr.testStyles    = injectElementWithStyles;    docElement.className = docElement.className.replace(/(^|\s)no-js(\s|$)/, '$1$2') +

    (enableClasses ? ' js ' + classes.join(' ') : '');

  return Modernizr;

})(this, this.document);
;