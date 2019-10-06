var sticky_pos = ($(window).height()/2);
$(window).scroll(stickyElem);
$(window).load(stickyElem);
function stickyElem() {
  if($(window).scrollTop() >= sticky_pos && !$('#sticky').hasClass('fixed')) {
      $('#sticky').addClass('fixed');
  }
  if($(window).scrollTop() < sticky_pos && $('#sticky').hasClass('fixed')) {
      $('#sticky').removeClass('fixed')
  }
}