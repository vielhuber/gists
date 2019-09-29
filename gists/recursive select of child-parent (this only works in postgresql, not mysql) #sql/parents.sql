WITH RECURSIVE rec AS (
  SELECT id, item_id, parent_id, 1 AS level FROM _test
  WHERE item_id = 2 -- START
  UNION ALL SELECT c.id, c.item_id, c.parent_id, (p.level+1) FROM _test c JOIN rec p ON c.item_id = p.parent_id
) SELECT DISTINCT parent_id, level FROM rec WHERE parent_id IS NOT NULL ORDER BY level ASC;