function printPDF(url) {
  $('#iFramePdf').remove();
  $('body').append('<iframe id="iFramePdf" src="'+url+'" style="display:none;"></iframe>');
  var getMyFrame = document.getElementById('iFramePdf');
  getMyFrame.focus();
  getMyFrame.contentWindow.print();
}
$(document).ready(function() {
  $('.print').click(function() {
    printPDF($(this).attr('href'));
    return false;
  });
});