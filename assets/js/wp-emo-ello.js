/*global tinymce:true */

( function() {
	'use strict';

	var ICONS,
	icon,
	iconShortcode;

	icon = function( id ) {
		return '<i class="icon-' + id + '"></i>';
	};

	iconShortcode = function( id ) {
		return '[icon name="' + id + '"]';
	};

	tinymce.PluginManager.add( 'emo_ello', function( editor, url ) {
		editor.addButton( 'emo_ello', function() {
			var i,
			_id,
			values = [];

			for (i = 0; i < ICONS.length; i++ ) {
				_id = ICONS[i];

				values.push( {
					text: ' ' +  _id,
					icon: 'icon-' + _id,
					value: _id
				} );
			}

			return {
				type: 'listbox',
				text: 'Fontello',
				icon: 'icon-emo-devil',
				tooltip: 'Fontello Emoticons',
				label: 'Select :',
				fixedWidth: true,
				values: values,
				onselect: function( e ) {
					if ( e ) {
						editor.insertContent( iconShortcode( e.control.settings.value ) );
					}
					return false;
				},
			};

		});
	} );

	ICONS = [ "emo-sunglasses", "emo-devil", "emo-wink2", "emo-beer", "emo-cry", "emo-coffee", "emo-thumbsup", "emo-wink", "emo-grin","emo-shoot","emo-tongue","emo-sleep","emo-happy","emo-angry","emo-squint","emo-surprised","emo-unhappy","emo-displeased","emo-saint","emo-laugh" ];
})();
