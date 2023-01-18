<?php
$filename = 'data.db';
$db = new \PDO('sqlite:' . $filename);

$query = $db->prepare('SELECT * FROM foo WHERE bar = ?');
$query->execute(['baz']);
$result = $query->fetchAll(\PDO::FETCH_ASSOC);

$query = $db->prepare('UPDATE foo SET bar = ? WHERE id = ?');
$query->execute(['test',42]);

$db->exec('CREATE TABLE IF NOT EXISTS gnarr(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    url VARCHAR(255),
    url_orig VARCHAR(255) NOT NULL,
    string TEXT,
    context VARCHAR(10),
    lng VARCHAR(10),
    time FLOAT
)');

$db = null; // destroy