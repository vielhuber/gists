$db->setQuery($db->getQuery(true)->delete($db->quoteName('#__js_table'))->where($db->quoteName('ID').' = '.$id))->execute();