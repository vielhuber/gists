var TopButton = function()
{
  this.init = function()
  {
    var _this = this;
    if (document.querySelector('.top-button') !== null) {
      _this.show();
      document.querySelector('.top-button').style.display = 'block';
      window.addEventListener('scroll', function() {
        _this.show();
      });
      document.querySelector('.top-button').addEventListener(
        'click',
        function(e) {
          _this.scrollTo(0, 1000);
          e.preventDefault();
        },
        false
      );
    }
  }
  this.show = function()
  {
    if (this.scrollTop() >= window.innerHeight / 2 && !document.querySelector('.top-button').classList.contains('top-button--visible')) {
      document.querySelector('.top-button').classList.add('top-button--visible');
    }
    if (this.scrollTop() < window.innerHeight / 2 && document.querySelector('.top-button').classList.contains('top-button--visible')) {
      document.querySelector('.top-button').classList.remove('top-button--visible');
    }
  }
  this.scrollTop = function()
  {
    var doc = document.documentElement;
    return (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
  }
  this.scrollTo = function(to, duration)
  {
    var element = document.scrollingElement || document.documentElement,
        start = element.scrollTop,
        change = to - start,
        startDate = +new Date(),
        // t = current time
        // b = start value
        // c = change in value
        // d = duration
        easeInOutQuad = function(t, b, c, d) {
          t /= d / 2;
          if (t < 1) return (c / 2) * t * t + b;
          t--;
          return (-c / 2) * (t * (t - 2) - 1) + b;
        },
        easeInOutCirc = function(t, b, c, d) {
          t /= d / 2;
          if (t < 1) return (-c / 2) * (Math.sqrt(1 - t * t) - 1) + b;
          t -= 2;
          return (c / 2) * (Math.sqrt(1 - t * t) + 1) + b;
        },
        animateScroll = function() {
          var currentDate = +new Date();
          var currentTime = currentDate - startDate;
          element.scrollTop = parseInt(easeInOutCirc(currentTime, start, change, duration));
          if (currentTime < duration) {
            requestAnimationFrame(animateScroll);
          } else {
            element.scrollTop = to;
          }
        };
    animateScroll();
  }
};
var top_button = new TopButton();
top_button.init();