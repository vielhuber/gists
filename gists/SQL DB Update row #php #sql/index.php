<?php
$sql->query("UPDATE table SET `row1` = 1 WHERE ID = 2");
$sql->query("INSERT INTO table(`row1`,`row2`) VALUES (1,2) ON DUPLICATE KEY UPDATE `row1` = 1, `row2` = 2");
?>