<?php
dd(Person::find(42)->getParents()->getAddresses()->sortByMulti([['zip','asc'],['location','desc']]);