$(document).ready(function() {
	$('.filestyle').each(function() {
		var self = this;
		var original_val = $(self).find('label').html();
		$(self).children('input').on('change',function(e) {
			var file_name = '';
			if( this.files && this.files.length > 1 ) {
				file_name = this.files.length + " Dateien ausgewählt";
			}
			else if( e.target.value ) {
				file_name = e.target.value.split( '\\' ).pop();
			}
			if( file_name ) {
				$(self).children('label').html( file_name );
			}
			else {
				$(self).children('label').html( original_val );
			}
		});
	});
});