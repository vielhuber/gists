(function() {

	tinymce.PluginManager.add('mce_buttons', function( editor, url ) {

		// single button
		editor.addButton('mce_button_1', {
			text: 'Button #1',
			icon: false,
			onclick: function() {
				editor.insertContent('<p><a href="#" class="button">Mehr erfahren</a></p>');
			}
		});
		
		// dropdown and buttons
		editor.addButton( 'mce_button_2', {
			text: 'Dropdown',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: 'Button #1',
					menu: [
						{
							text: 'Button #1.1',
							onclick: function() {
								editor.insertContent('...');
							}
						},
						{
							text: 'Button #1.2',
							onclick: function() {
								editor.insertContent('...');
							}
						}
					]
				},
				{
					text: 'Button #2',
					menu: [
						{
							text: 'Button #2.1',
							onclick: function() {
								editor.insertContent('...');
							}
						},
						{
							text: 'Button #2.2',
							onclick: function() {
								editor.insertContent('...');
							}
						}
					]
				}
			]
		});
	});

})();