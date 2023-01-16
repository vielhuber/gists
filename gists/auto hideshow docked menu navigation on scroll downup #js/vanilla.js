let curPos = hlp.scrollTop(),
            lastPos = curPos,
            throttle = 100,
            isHidden = false,
            timeout = null;
        window.addEventListener('scroll', () =>
        {
            curPos = hlp.scrollTop();
            if(
                curPos < lastPos &&
                Math.abs(curPos-lastPos) > throttle &&
                isHidden === true
            )
            {
                isHidden = false;
                if( timeout ) { clearTimeout(timeout); }
                timeout = setTimeout(() =>
                {
                    isHidden = false;
                    document.querySelector('header').classList.remove('header--hidden');
                },500);             
            }
            else if(
                curPos > 0 &&
                curPos > lastPos &&
                Math.abs(curPos-lastPos) > throttle &&
                isHidden === false
            )
            {
                isHidden = true;
                if( timeout ) { clearTimeout(timeout); }
                timeout = setTimeout(() =>
                {
                    isHidden = true;
                    document.querySelector('header').classList.add('header--hidden');
                },500);       
            }
            if( Math.abs(curPos-lastPos) > throttle )
            {
                lastPos = curPos;
            }
        });