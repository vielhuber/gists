<?php
// this is only possible with mysqlnd (native driver)
$result = $sql->query("SELECT * FROM table WHERE condition = 1;")->fetch_all(MYSQLI_ASSOC);

// this is always possible
$result = array(); $result_db = $sql->query("SELECT * FROM table WHERE condition = 1;"); while($row = $result_db->fetch_assoc()) { $result[] = $row; }
?>