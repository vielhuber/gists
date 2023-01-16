SET @IS_SHOPKUNDE := '
    (u.customergroup IS NULL OR u.customergroup = \'EK\')
';
SET @WARENWERT_GT_1000 := '
    SUM(
            CASE WHEN EXISTS(
                SELECT * FROM s_articles WHERE s_articles.id = b.articleID AND s_articles.supplierID = (SELECT id FROM s_articles_supplier WHERE name = \'Markenname\')
            ) THEN 0
            ELSE b.quantity * b.price
            END
    ) > 1000
';
SET @IS_SPECIAL_BRAND_CATEGORY := '
    EXISTS(SELECT * FROM s_articles_categories WHERE articleID = a.id AND categoryID = (SELECT id FROM s_categories WHERE description = \'Markenname\'))
';
SET @IS_SPECIAL_BRAND_SUPPLIER := '
    (a.supplierID = (SELECT id FROM s_articles_supplier WHERE name = \'Markenname\'))
';
SET @PRICES_NET := '
    IF(b.shippingfree = 1, 0,
    IF(d.weight IS NULL OR d.weight * b.quantity <= 10, 2,
    IF(d.weight * b.quantity <= 20, 4,
    IF(d.weight * b.quantity <= 30, 6,
    IF(d.weight * b.quantity <= 40, 8,
    IF(d.weight * b.quantity <= 50, 10,
    12))))))
';
SET @PRICES := '
    IF(b.shippingfree = 1, 0,
    IF(d.weight IS NULL OR d.weight * b.quantity <= 10, ROUND(2*1.19,2),
    IF(d.weight * b.quantity <= 20, ROUND(4*1.19,2),
    IF(d.weight * b.quantity <= 30, ROUND(6*1.19,2),
    IF(d.weight * b.quantity <= 40, ROUND(8*1.19,2),
    IF(d.weight * b.quantity <= 50, ROUND(10*1.19,2),
    ROUND(12*1.19,2)))))))
';
SET @PRICES_SPECIAL_BRAND_NET := '
    IF(b.shippingfree = 1, 0,
    IF(d.weight IS NULL OR d.weight * b.quantity <= 10, 20,
    IF(d.weight * b.quantity <= 20, 40,
    IF(d.weight * b.quantity <= 30, 60,
    IF(d.weight * b.quantity <= 40, 80,
    100)))))
';
SET @PRICES_SPECIAL_BRAND := '
    IF(b.shippingfree = 1, 0,
    IF(d.weight IS NULL OR d.weight * b.quantity <= 10, ROUND(20*1.19,2),
    IF(d.weight * b.quantity <= 20, ROUND(40*1.19,2),
    IF(d.weight * b.quantity <= 30, ROUND(60*1.19,2),
    IF(d.weight * b.quantity <= 40, ROUND(80*1.19,2),
    ROUND(100*1.19,2))))))
';

UPDATE s_premium_dispatch SET calculation_sql = CONCAT('
IF(
    ',@WARENWERT_GT_1000,',
    0,
    IF(
        ',@IS_SHOPKUNDE,',
        SUM(
            IF(
                    ',@IS_SPECIAL_BRAND_SUPPLIER,',
                    ',@PRICES_SPECIAL_BRAND_NET,',
                    0
             )
        ),
        SUM(
            IF(
                    ',@IS_SPECIAL_BRAND_SUPPLIER,',
                    ',@PRICES_SPECIAL_BRAND,',
                    ',@PRICES,'
             )
        )
    )
)
') WHERE name = 'CUSTOM';

SELECT calculation_sql FROM s_premium_dispatch WHERE name = 'CUSTOM';