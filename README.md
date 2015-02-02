=== WP Emo-ello ===

Contributors: viphat
Donate link: https://github.com/viphat/wp-emo-ello
Tags: smileys, emoticons, Fontello
Requires at least: 3.9.0
Tested up to: 4.1.0
Stable tag: 0.3
License: GPLv2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Fontello Emoticons can be inserted using either HTML, shortcode or a built-in TinyMCE plugin. This plugin also replaces Wordpress' smileys.

== Description ==

- Insert via TinyMCE Plugins (See Screenshots)

![image](http://blog.viphat.name/wp-content/uploads/2015/01/2.png)

- Use HTML Code

`<i class='icon-emo-beer'></i>`
`<i class='icon-emo-coffee'></i>`

- Use Short Code

`[icon name="emo-beer"]`
`[icon name="emo-coffee"]`

- Full list of Emoticons's Name (Remember Add Prefix 'icon-' when using HTML Code)

"emo-sunglasses", "emo-devil", "emo-wink2", "emo-beer", "emo-cry", "emo-coffee", "emo-thumbsup", "emo-wink", "emo-grin","emo-shoot","emo-tongue","emo-sleep","emo-happy","emo-angry","emo-squint","emo-surprised","emo-unhappy","emo-displeased","emo-saint","emo-laugh"

![image](http://blog.viphat.name/wp-content/uploads/2015/01/wp-emo-tello.png)

- Replace WordPress's Smileys

The following emoticons are supported:

* `:)` `:-)` `:smile:`
* `:(` `:-(` `:sad:`
* `;)` `;-)` `:wink:`
* `:P` `:-P` `:razz:`
* `-.-` `-_-` `:sleep:`
* `:thumbs:` `:thumbsup:`
* `:devil:` `:twisted:`
* `:o` `:-o` `:eek:`
* `8O` `8o` `8-O` `8-o` `:shock:`
* `:coffee:`
* `8)` `8-)` `B)` `B-)` `:cool:`
* `:/` `:-/`
* `:beer:`
* `:D` `:-D` `:grin:`
* `x(` `x-(` `X(` `X-(` `:angry:`
* `:x` `:-x` `:mad:`
* `O:)` `0:)` `o:)` `O:-)` `0:-)` `o:-)` `:saint:`
* `:'(` `:'-(` `:cry:`
* `:shoot:`
* `^^` `^_^` `:lol:`

Notes (When Convert WordPress's Smileys):
* Emoticons must be surrounded with spaces (or other white space characters); e.g. the emoticon in `that:)smile` won't be replaced
* Emoticons won't be replaced in HTML tags nor in `<pre>` or `<code>` blocks.


**Github Repository** - https://github.com/viphat/wp-emo-ello

== Installation ==

1. Upload the `wp-emo-ello` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use one of the three usage methods (HTML, Shortcode, or TinyMCE plugin) within the content of your posts or pages.
4. Use either the HTML or Shortcode methods inside your text widgets.

== Screenshots ==

1. available emoticons
2. tinymce plugins

== Changelog ==

= 0.3 =
* First release.

== Upgrade Notice ==

NONE

== Frequently Asked Questions ==

NONE


== Font License ==
The emoticons used in this plugin are based on the "Fontelico" font.

License:

    Copyright (C) 2012 by Fontello project
    Author:    Crowdsourced, for Fontello project
    License:   SIL (http://scripts.sil.org/OFL)
    Homepage:  http://fontello.com

== Credits ==

Many thanks to the following plugins and their authors:

* Based on Font Awesome Plugins v4.2 - https://wordpress.org/plugins/font-awesome/ for Tiny MCE Plugins / HTML / Short Code
* Based on Font Emoticons Plugins v1.2 - https://wordpress.org/plugins/font-emoticons/ for Replaces WP-Smilies with Fontello Emoticons
* Based on Better Font Awesome Plugins v1.0.6 - https://wordpress.org/plugins/better-font-awesome for Display Icon in TinyMCE Listbox
