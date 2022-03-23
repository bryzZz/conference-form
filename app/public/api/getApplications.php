<?php
    try {
        $pdo = new PDO('mysql:dbname=main;host=mysql', 'user', 'pass', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $sql = 'SELECT * FROM applications';

        $q = $pdo->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not connect to the database main: " . $e->getMessage());
    }
?>