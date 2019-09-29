<a {!! Helper::setActive('getPage','page1') !!} href="{{ URL::route('getPage','page1') }}">Page 1</a>
<a {!! Helper::setActive('getPage','page2') !!} href="{{ URL::route('getPage','page1') }}">Page 2</a>
<a {!! Helper::setActive('getPage','page3') !!} href="{{ URL::route('getPage','page1') }}">Page 3</a>


Helper::setActiveHtml('<div class="menu"><a href="#" class="foo">this gets automatically injected</a></div>');