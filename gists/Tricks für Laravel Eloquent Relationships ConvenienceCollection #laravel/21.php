<?php
echo Person::getItem(42)->getAddresses()->getFirst()->getCountry()->getName();