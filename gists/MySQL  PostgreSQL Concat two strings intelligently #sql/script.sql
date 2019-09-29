SELECT CONCAT_WS(
    ' ',
    NULLIF(contract.company_name,''),
    NULLIF(contract.last_name,''),
    NULLIF(contract.first_name,'')
) FROM members;

SELECT CONCAT_WS(
	' ',
	(CASE WHEN COALESCE(company_name,'')='' THEN NULL ELSE company_name END),
    (CASE WHEN COALESCE(first_name,'')='' THEN NULL ELSE first_name END),
	(CASE WHEN COALESCE(last_name,'')='' THEN NULL ELSE last_name END)
) FROM members;