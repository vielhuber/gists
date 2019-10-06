<?php
dd(Person::find(42)->getParents()->getAddresses()->sortByMany([['zip','asc'],['location','desc']]);