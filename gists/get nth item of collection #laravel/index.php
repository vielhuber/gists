<?php
$collection->get(4); // wrong! collection keys can be unordered
$collection->values()[4]; // better (fails if index is not set)
$collection->values()->get(4); // best
