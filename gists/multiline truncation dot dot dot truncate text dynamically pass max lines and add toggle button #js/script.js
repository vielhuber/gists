	truncateCommentText() {
        let maxLines = 3,
            selector = '.text-content',
            speed = 250;
        if (document.querySelector(selector) !== null) {
            document.querySelectorAll(selector).forEach(el => {
                let html = el.innerHTML;
                el.innerHTML = '...';
                let lineHeight = el.offsetHeight;
                el.innerHTML = html;
                let lines = Math.round(el.offsetHeight / lineHeight);
                if (lines > maxLines) {
                    el.style.transition =
                        'height ' + Math.round((speed / 1000) * 10) / 10 + 's ease-in-out';
                    el.style.overflow = 'hidden';

                    el.insertAdjacentHTML(
                        'afterend',
                        '<a href="#" class="text-toggle text-toggle--inactive">X</a>'
                    );

                    this.truncateCommentTextDo(el, html, maxLines, lineHeight);

                    el.nextElementSibling.addEventListener('click', e => {
                        if (e.target.classList.contains('text-toggle--inactive')) {
                            e.target.classList.remove('text-toggle--inactive');
                            e.target.classList.add('text-toggle--active');
                            el.style.height = el.offsetHeight + 'px';
                            el.innerHTML = html;
                            requestAnimationFrame(() => {
                                el.style.height = el.scrollHeight + 'px';
                                setTimeout(() => {
                                    el.style.height = 'auto';
                                }, speed);
                            });
                        } else {
                            e.target.classList.remove('text-toggle--active');
                            e.target.classList.add('text-toggle--inactive');
                            el.style.height = el.offsetHeight + 'px';
                            requestAnimationFrame(() => {
                                el.style.height = maxLines * lineHeight + 'px';
                                setTimeout(() => {
                                    this.truncateCommentTextDo(el, html, maxLines, lineHeight);
                                    setTimeout(() => {
                                        el.style.height = 'auto';
                                    }, 100);
                                }, speed);
                            });
                        }
                        e.preventDefault();
                    });
                }
            });
        }
    }
    truncateCommentTextDo(el, html, maxLines, lineHeight) {
        let wordArray = html.split(' ');
        while (wordArray.length > 0 && Math.round(el.scrollHeight / lineHeight) > maxLines) {
            wordArray.pop();
            el.innerHTML = wordArray.join(' ') + '...';
        }
    }