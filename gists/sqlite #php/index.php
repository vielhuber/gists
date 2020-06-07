<?php
$filename = 'data.db';
$db = new \PDO('sqlite:' . $filename);

$query = $db->prepare('SELECT * FROM foo WHERE bar = ?');
$query->execute(['baz']);
$result = $query->fetchAll(\PDO::FETCH_ASSOC);

$query = $db->prepare('UPDATE foo SET bar = ? WHERE id = ?');
$query->execute(['test',42]);

$db = null; // destroy