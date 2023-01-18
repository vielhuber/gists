<?php
echo Person::find(42)->getAddress()->getCountry()->getName();