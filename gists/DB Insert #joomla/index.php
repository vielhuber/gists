$db->setQuery($db->getQuery(true)->insert($db->quoteName('#__js_table'))
->columns($db->quoteName(array('created','name','subtitle','pos','content','parent_id')))
->values(implode(',', array(
	$db->quote(date('Y-m-d H:i:s',strtotime('now'))),
	$db->quote($name),
	"NULL",
	$pos,
	"NULL",
	(($parent_id != "")?($parent_id):("NULL"))
))))->execute();