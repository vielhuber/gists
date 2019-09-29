SUM(
   IF(at.attr5 IS NOT NULL AND at.attr5 <> '', at.attr5 * b.quantity,
   IF(d.weight * b.quantity < 3, 4.99,
   IF(d.weight * b.quantity < 5, 6.90,
   IF(d.weight * b.quantity < 10, 9.50,
   IF(d.weight * b.quantity < 15, 10.90,
   IF(d.weight * b.quantity < 20, 12.90,
   IF(d.weight * b.quantity < 31, 17.90,
   IF(d.weight * b.quantity < 40, 49.90,
   (49.90+(0.59*(d.weight * b.quantity - 40)))
   ))))))))
)