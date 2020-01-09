<?php
dd(Person::find(42)->getParents()->getAddresses()->sortBy('zip')->sortBy('location'))