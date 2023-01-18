$('.container').find('input[type="checkbox"], input[type="radio"]').each(function()             
{
  /* its not a problem to have multiple labels associated to the same form control */
  /* we therefore create another label that acts as the displayed item and use the native html behaviour */
  $(this).wrap('<div class="styled-input styled-input--'+$(this).attr('type')+'"></div>');
  $(this).parent('.styled-input').append('<label for="'+$(this).attr('id')+'"></label>');
});