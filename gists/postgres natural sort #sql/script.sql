/* see https://stackoverflow.com/a/48809832/2068362 */
create or replace function naturalsort(text)
    returns bytea language sql immutable strict as $f$
			select string_agg(convert_to(coalesce(r[2], length(length(r[1])::text) || length(r[1])::text || r[1]), 'SQL_ASCII'),'\x00')
			from regexp_matches(
				REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
					(SELECT CASE WHEN $1 IS NULL THEN 'zzz' ELSE $1 END),
				'ä', 'ae'),
				'Ä', 'Ae'),
				'ö', 'oe'),
				'Ö', 'Oe'),
				'ü', 'ue'),
				'Ü', 'Ue'),
				'ß', 'ss')
			, '0*([0-9]+)|([^0-9]+)', 'g') r;
$f$;

SELECT * FROM (SELECT '110' as col UNION ALL SELECT '12' UNION ALL SELECT 'F13' UNION ALL SELECT NULL UNION ALL SELECT '' UNION ALL SELECT 'T' UNION ALL SELECT 'O' UNION ALL SELECT 'Oe' UNION ALL SELECT 'Ö' UNION ALL SELECT 'P') as t ORDER BY naturalsort(col) DESC NULLS LAST