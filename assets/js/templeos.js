/**
 * Temple front-end behavior. No dependencies.
 *
 * - Status bar: live clock, wandering memory counter and CPU meters.
 * - Oracle widget: draws new random words on click or F7.
 * - Menu bar: toggle on small screens.
 */
( function () {
	'use strict';

	var settings = window.templeOS || {};
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var rainbow = [ 'red', 'brown', 'green', 'cyan', 'blue', 'purple' ];

	function pad( n ) {
		return ( n < 10 ? '0' : '' ) + n;
	}

	function randomInt( max ) {
		return Math.floor( Math.random() * max );
	}

	/* Status bar ------------------------------------------------------- */

	function startStatusBar() {
		var clock = document.querySelector( '[data-tos-clock]' );
		var mem = document.querySelector( '[data-tos-mem]' );
		var cpus = document.querySelectorAll( '[data-tos-cpu]' );
		var days = [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ];
		var months = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
		var memValue = 0x1f3a000;

		if ( ! clock ) {
			return;
		}

		function tickClock() {
			var d = new Date();
			clock.textContent = days[ d.getDay() ] + ' ' + months[ d.getMonth() ] + ' ' + pad( d.getDate() ) + ' ' +
				pad( d.getHours() ) + ':' + pad( d.getMinutes() ) + ':' + pad( d.getSeconds() );
		}

		function tickLoad() {
			memValue += ( randomInt( 9 ) - 4 ) * 0x1000;
			if ( mem ) {
				mem.textContent = '0x' + ( '0000000000' + memValue.toString( 16 ).toUpperCase() ).slice( -10 );
			}

			Array.prototype.forEach.call( cpus, function ( cpu, i ) {
				// Core 0 runs the window manager, so it stays busiest.
				var load = i === 0 ? 55 + randomInt( 45 ) : randomInt( 70 );
				cpu.querySelector( '.tos-cpu__fill' ).style.width = load + '%';
				cpu.classList.toggle( 'is-hot', load > 85 );
			} );
		}

		tickClock();
		window.setInterval( tickClock, 1000 );

		if ( ! reduceMotion ) {
			tickLoad();
			window.setInterval( tickLoad, 800 );
		}
	}

	/* Oracle ----------------------------------------------------------- */

	function colorWords( target, words ) {
		target.textContent = '';
		words.forEach( function ( word, i ) {
			var span = document.createElement( 'span' );
			span.className = 'tos-fg-' + rainbow[ randomInt( rainbow.length ) ];
			span.textContent = word;
			target.appendChild( span );
			if ( i < words.length - 1 ) {
				target.appendChild( document.createTextNode( ' ' ) );
			}
		} );
	}

	function drawWords( oracle ) {
		var list = settings.oracleWords || [];
		var count = parseInt( oracle.getAttribute( 'data-count' ), 10 ) || 8;
		var picked = [];
		var i;

		if ( ! list.length ) {
			return;
		}

		for ( i = 0; i < count; i++ ) {
			picked.push( list[ randomInt( list.length ) ] );
		}

		colorWords( oracle.querySelector( '[data-tos-oracle-words]' ), picked );
	}

	function startOracles() {
		var oracles = document.querySelectorAll( '[data-tos-oracle]' );

		Array.prototype.forEach.call( oracles, function ( oracle ) {
			var target = oracle.querySelector( '[data-tos-oracle-words]' );
			var button = oracle.querySelector( '[data-tos-oracle-button]' );

			// Color the words the server picked.
			colorWords( target, target.textContent.trim().split( /\s+/ ).filter( Boolean ) );

			if ( button ) {
				button.addEventListener( 'click', function () {
					drawWords( oracle );
				} );
			}
		} );

		if ( oracles.length ) {
			document.addEventListener( 'keydown', function ( event ) {
				if ( event.key === 'F7' ) {
					event.preventDefault();
					Array.prototype.forEach.call( oracles, drawWords );
				}
			} );
		}
	}

	/* Menu bar --------------------------------------------------------- */

	function startMenu() {
		var nav = document.getElementById( 'site-navigation' );
		var button = nav ? nav.querySelector( '.menu-toggle' ) : null;

		if ( ! button ) {
			return;
		}

		button.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'toggled' );
			button.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && nav.classList.contains( 'toggled' ) ) {
				nav.classList.remove( 'toggled' );
				button.setAttribute( 'aria-expanded', 'false' );
				button.focus();
			}
		} );
	}

	function start() {
		startStatusBar();
		startOracles();
		startMenu();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', start );
	} else {
		start();
	}
}() );
