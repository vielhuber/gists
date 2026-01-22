$user = & JFactory::getUser();
$ldap = SHLdap::getInstance();
$ldap->connect();
$dn = $ldap->getUserDn($user->username);
$read = $ldap->read($dn);
$read = $read->getEntry(0);