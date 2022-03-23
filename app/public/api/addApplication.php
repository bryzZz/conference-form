<?php
    // get request data
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    $required_fields = ['name', 'lastName', 'email', 'phone', 'topic', 'paymentMethod', 'newsletter'];

    $response = array('status' => NULL);

    try {
        $pdo = new PDO('mysql:dbname=main;host=mysql', 'user', 'pass', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $createTableSql = '
            CREATE TABLE IF NOT EXISTS `applications` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(45) DEFAULT NULL,
                `lastname` varchar(45) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
                `phone` char(12) DEFAULT NULL,
                `topic` varchar(100) DEFAULT NULL,
                `paymentMethod` varchar(100) DEFAULT NULL,
                `newsletter` enum(\'yes\',\'no\') DEFAULT \'no\',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            );
        ';
        $pdo->exec($createTableSql);

        $sql = 'INSERT INTO applications(name, lastName, email, phone, topic, paymentMethod, newsletter)
            VALUES(:name, :lastName, :email, :phone, :topic, :paymentMethod, :newsletter)';
        $statement = $pdo->prepare($sql);
        $statement->execute($data);

        $response['status'] = 'success';
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();

        http_response_code(400);
    }

    // response to client
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
?>