=== Temple ===
Contributors: johndeebdd
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A classic WordPress theme inspired by TempleOS: 16 VGA colors, pixel fonts, double-line windows and an Oracle.

== Description ==

Temple is a classic PHP theme inspired by TempleOS, the operating system Terry A. Davis built by himself. It uses the Classic Editor and Classic Widgets by default.

* 16-color VGA palette, blue text on a white screen
* Bundled pixel fonts (VT323 and Press Start 2P)
* Double-line DolDoc windows with titles in the border
* Status bar with a live clock and CPU meters
* Rainbow site title, blinking cursor and pixel mouse pointer
* Oracle widget (random words, press F7)
* A 404 page styled as a crash screen
* A Full Width (No Sidebar) page template

== Frequently Asked Questions ==

= How do I get the block editor back? =

Add `add_filter( 'temple_use_classic_editor', '__return_false' );` to a child theme or plugin. Use `temple_use_classic_widgets` to do the same for widgets.

= Can I turn off the blinking? =

Yes. Go to Appearance > Customize > TempleOS. Blinking also stops for visitors whose system asks for reduced motion.

== Changelog ==

= 1.0.0 =
* First release.

== Copyright ==

Temple WordPress Theme, (C) 2026 JohnDeeBDD.
Temple is distributed under the terms of the GNU GPL v2 or later.

This theme bundles the following third-party resources:

VT323, Copyright 2011 The VT323 Project Authors
License: SIL Open Font License 1.1, https://scripts.sil.org/OFL
Source: https://fonts.google.com/specimen/VT323

Press Start 2P, Copyright 2012 The Press Start 2P Project Authors
License: SIL Open Font License 1.1, https://scripts.sil.org/OFL
Source: https://fonts.google.com/specimen/Press+Start+2P

Screenshot: rendered from this theme with sample content written for it. GPLv2 or later.
