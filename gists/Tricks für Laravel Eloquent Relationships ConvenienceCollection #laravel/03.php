<?php
Person::find(42)->phones;
Person::find(42)->phones(); // auch möglich (nutzt die ungecachte Version)