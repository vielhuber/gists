WITH RECURSIVE rec AS (
  SELECT id, item_id, parent_id, 1 AS level FROM _test
  WHERE parent_id = 1 -- START
  UNION ALL SELECT c.id, c.item_id, c.parent_id, (p.level+1) FROM _test c JOIN rec p ON c.parent_id = p.item_id
) SELECT DISTINCT item_id, level FROM rec ORDER BY level ASC;