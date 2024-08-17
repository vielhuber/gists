<?php
dd(Person::find(42)->getParents()->getAddresses()->getCountry()->getName());