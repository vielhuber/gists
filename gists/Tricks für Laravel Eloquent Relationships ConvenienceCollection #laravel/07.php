<?php
if( Person::find(42) !== null && Person::find(42)->getAddress() !== null && Person::find(42)->getAddress()->getCountry() !== null && Person::find(1)->getAddress()->getCountry()->getName() !== null )
{
    echo Person::find(42)->getAddress()->getCountry()->getName();
}