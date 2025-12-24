// without prepared statements
$sql->query("SELECT ID FROM table WHERE condition1 = 'foo' AND condition2 = 2")->fetch_object()->ID;

// with prepared statements
$query = $sql->prepare("SELECT ID FROM table WHERE condition1 = ? AND condition2 = ?");
$query->bind_param("si", $a='foo', $b=2);
$query->execute();
$query->get_result()->fetch_object()->count;