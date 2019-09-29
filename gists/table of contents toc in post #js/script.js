var TOC = function(selectorTableOfContents, selectorHeadings, selectorHeader, tolerance) {
    this.selectorTableOfContents = selectorTableOfContents;
    this.selectorHeadings = selectorHeadings;
    this.selectorHeader = selectorHeader;
    this.tolerance = tolerance;

    this.init = function() {
        var _this = this;

        if (document.querySelector(_this.selectorTableOfContents) !== null) {
            if (document.querySelector(_this.selectorHeadings) !== null) {
                var initialJump = false,
                    slugs = [];
                if (window.location.hash != '') {
                    initialJump = window.location.hash.replace('#', '');
                }
                document
                    .querySelector(_this.selectorTableOfContents)
                    .insertAdjacentHTML(
                        'beforeend',
                        '<h3 class="table-of-contents__title">Inhaltsverzeichnis</h3>'
                    );
                document
                    .querySelector(_this.selectorTableOfContents)
                    .insertAdjacentHTML('beforeend', '<ul class="table-of-contents__list"></ul>');
                [].forEach.call(document.querySelectorAll(_this.selectorHeadings), function(el) {
                    if (el.textContent.trim() == '') {
                      return;
                    }
                    var slug = el.textContent
                        .toString()
                        .toLowerCase()
                        .replace(/(<([^>]+)>)/gi, '')
                        .split('ä')
                        .join('ae')
                        .split('ö')
                        .join('oe')
                        .split('ü')
                        .join('ue')
                        .split('ß')
                        .join('ss')
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');
                    var slug_suffix = 1;
                    while (slugs.indexOf(slug + (slug_suffix > 1 ? '-' + slug_suffix : '')) > -1) {
                        slug_suffix++;
                    }
                    if (slug_suffix > 1) {
                        slug += '-' + slug_suffix;
                    }
                    slugs.push(slug);
                    el.setAttribute('data-anchor', slug); // use data attributes instead of ids to prevent native browser jumps
                    document
                        .querySelector('.table-of-contents__list')
                        .insertAdjacentHTML(
                            'beforeend',
                            '<li class="table-of-contents__listitem"><a class="table-of-contents__link" href="#' +
                                slug +
                                '">' +
                                el.innerHTML.replace(/(<([^>]+)>)/gi, '') +
                                '</a></li>'
                        );
                });
                [].forEach.call(document.querySelectorAll('.table-of-contents__link'), function(
                    el
                ) {
                    el.addEventListener('click', function(e) {
                        var href = el.getAttribute('href').replace('#', ''),
                            offset =
                                document
                                    .querySelector('[data-anchor="' + href + '"]')
                                    .getBoundingClientRect().top +
                                window.pageYOffset -
                                document.documentElement.clientTop,
                            header = document.querySelector(_this.selectorHeader).offsetHeight;
                        jQuery('html, body').animate(
                            { scrollTop: offset - header - _this.tolerance },
                            1000
                        );
                        //hlp.scrollTo( offset - header - _this.tolerance, 1000 );
                        //window.scrollTo({ behavior: 'smooth', left: 0, top: offset - header - _this.tolerance });
                        e.preventDefault();
                    });
                });
                if (initialJump !== false) {
                    requestAnimationFrame(function() {
                        let documentHeight = Math.max(
                            document.body.offsetHeight,
                            document.body.scrollHeight,
                            document.documentElement.clientHeight,
                            document.documentElement.offsetHeight,
                            document.documentElement.scrollHeight
                        );
                        document.documentElement.scrollTop = document.body.scrollTop =
                            documentHeight - window.innerHeight;
                        requestAnimationFrame(function() {
                            var offset =
                                    document
                                        .querySelector('[data-anchor="' + initialJump + '"]')
                                        .getBoundingClientRect().top +
                                    window.pageYOffset -
                                    document.documentElement.clientTop,
                                header = document.querySelector(_this.selectorHeader).offsetHeight;
                            document.documentElement.scrollTop = document.body.scrollTop =
                                offset - header - _this.tolerance;
                        });
                    });
                }
            } else {
                document.querySelector(_this.selectorTableOfContents).remove();
            }
        }
    };

    this.init();
};

window.addEventListener('load', function(e) {
    new TOC('.table-of-contents', '.content h2, .content h3', '.header', 0);
});
