(
   IF(SUM(d.weight*b.quantity) < 3, (4.99+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 5, (6.90+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 10, (9.50+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 15, (10.90+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 20, (12.90+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 31, (17.90+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   IF(SUM(d.weight*b.quantity) < 40, (49.90+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity)),
   (49.90+(0.59*(SUM(d.weight*b.quantity)-40))+SUM(IF(ISNULL(at.attr5),0,(at.attr5))*b.quantity))
   )))))))
)