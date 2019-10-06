$(document).ready(function()
                  {
  if( $('.article .article-inner-border table').length > 0 )
  {
    $('.article .article-inner-border table').each(function()
                                                   {
      $(this).wrap('<div class="responsive-table-container"></div>');
    });
  }
});