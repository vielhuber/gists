(function() {

	tinymce.PluginManager.add('mce_buttons', function( editor, url ) {

		// single button
		editor.addButton('mce_button', {
			text: 'Button #1',
			icon: false,
			onclick: function() {
				editor.insertContent('<p><a href="#" class="button">Mehr erfahren</a></p>');
			}
		});
		
		// dropdown and buttons
		editor.addButton( 'mce_dropdown', {
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
      
		editor.addButton('mce_latex', {
			text: 'Formeleditor',
			icon: 'preview',
			onclick: function() {
                    let popup = null,
					    url = 'https://latex.codecogs.com/editor_json3.php?type=url&editor=TinyMCE';
                    popup=window.open('','Formeleditor','width=700,height=450,status=1,scrollbars=yes,resizable=1');
					if (!popup.opener) { popup.opener = self; }
					popup.document.open();
					popup.document.write('<!DOCTYPE html><head><script src="'+url+'" type="text/javascript"></script></head><body></body></html>');
					popup.document.close();
			}
		});
	});

})();

/* for latex support */
TinyMCE_Add = function(name) {
	let sName = name.match( /(gif|svg)\.latex\?(.*)/ ),
	    latex = unescape(sName[2]);
	latex = latex.replace(/@plus;/g,'+');
	latex = latex.replace(/&plus;/g,'+');
	latex = latex.replace(/&space;/g,' ');	
	tinymce.activeEditor.execCommand('mceInsertContent', false, '$$'+latex+'$$');
	tinymce.execCommand('mceFocus', false, tinymce.activeEditor.editorId);
}