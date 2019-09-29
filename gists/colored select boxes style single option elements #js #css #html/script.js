$(document).ready(function() {
    $('select').each(function() {
      coloredSelectInit(this);
      coloredSelectUpdate(this);
      $(this).change(function() {
        coloredSelectUpdate(this);
      });	  
    }); 
});
function coloredSelectInit(self) {
  for(var property of ['color','font-weight','background-color']) {
    $(self).find('option').each(function() {
      if( $(this).css(property) !== undefined ) {
        var prop = $(this).css(property);
        if( property == 'background-color' && prop == 'rgba(0, 0, 0, 0)' ) { prop = '#fff'; }
        $(this).attr('data-style-'+property,prop);
        }
    });
  }
}
function coloredSelectUpdate(self) {
  for(var property of ['color','font-weight','background-color']) {
      if( $(self).find('option:selected').length > 0 && $(self).find('option:selected').css(property) !== undefined ) {
        var prop = $(self).find('option:selected').css(property);
        if( property == 'background-color' && prop == 'rgba(0, 0, 0, 0)' ) { prop = '#fff'; }
        $(self).css(property,prop);
        $(self).find('option').not(':selected').each(function() {
          if( $(this).is('[data-style-'+property+']') ) { $(this).css(property,$(this).attr('data-style-'+property)); }
        });
      }
  }
}