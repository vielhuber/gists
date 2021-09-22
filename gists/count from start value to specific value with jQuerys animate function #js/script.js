new_count = 500;
cur_count = $('.count').text();
$({count_num: cur_count}).animate({count_num: overall_count}, {
	duration: 1000,
	easing:'linear',
	step: function() {
		$('.count').text(Math.floor(this.count_num));
	},
	complete: function() {
		$('.count').text(this.count_num);
	}
});