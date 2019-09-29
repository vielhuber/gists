### naming convention in migrations folder
- ___table1.php
- ___table2.php
- ___table3.php
- ...
- ___zzz_foreign_keys.php

### use case
- the migrations folder does not replicate schema changes over time, but always the current schema
- if we are on production, we make schema changes on the fly and not via the migrations interface
