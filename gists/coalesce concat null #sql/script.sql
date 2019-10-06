// problem: is null, if col is null
CONCAT(col, 'foo')

// solution: is 'foo', if col is null
CONCAT_WS('', col, 'foo')
CONCAT(IFNULL(col, ''),'foo') 
CONCAT(COALESCE(col,''),'foo')