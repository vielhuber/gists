<?php
// php
strftime('%A', strtotime('+ 3 days')).', den '.date('d.m.Y', strtotime('+ 3 days'));

// wordpress
date_i18n('l', strtotime('+ 3 days')).', den '.date('d.m.Y', strtotime('+ 3 days'));