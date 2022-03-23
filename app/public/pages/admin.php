<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <header class="header">
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="./form/index.html" class="nav__link">Form</a></li>
                </ul>
            </nav>
        </header>
    
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

    <div class="container">
        <h1>Applications</h1>
        <form action="" method="post">
            <table class="table table-striped table-bordered table-condensed">
                <caption>List of users</caption>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>lastname</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>topic</th>
                        <th>paymentMethod</th>
                        <th>newsletter</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']) ?></td>
                            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['topic']); ?></td>
                            <td><?php echo htmlspecialchars($row['paymentMethod']); ?></td>
                            <td><?php echo htmlspecialchars($row['newsletter']); ?></td>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="<?php echo $row['id']; ?>" />
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <button class="btn btn-primary" type="submit">Delete selected applications</button>
        </form>
    </div>

    <?php
        if ($_POST){
            $ids = array_keys($_POST);
            $s = implode(",",$ids);
        
            try {
                $sql2 = "DELETE FROM applications WHERE id IN ($s) LIMIT " . count($ids) . ";";
                
                $pdo->exec($sql2);

                header("Refresh:1");
            } catch(PDOException $e) {
                die("Could not connect to the database main: " . $e->getMessage());
            }
        }
    ?>
</body>
</html>