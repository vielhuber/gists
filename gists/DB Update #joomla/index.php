$fields = array(
	$db->quoteName('name').' = '.($db->quote($_POST["name"])),
	$db->quoteName('content').' = '.($db->quote($_POST["content"])),
	$db->quoteName('subtitle').' = '.(($_POST["subtitle"] != "")?($db->quote($_POST["subtitle"])):("NULL")),
	$db->quoteName('content').' = '.(($_POST["content"] != "")?($db->quote($_POST["content"])):("NULL"))
);
$db->setQuery($db->getQuery(true)->update($db->quoteName('#__js_table'))->set($fields)->where($db->quoteName('ID').' = '.$db->quote($_GET["ID"])))->execute();