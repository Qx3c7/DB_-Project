<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta charset="utf-8" />
    <title>Dodawanie Biegacza</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
    <h1>Runners APP - Dodaj Biegacza</h1>
    
    <form action="index.php">
        <input type="submit" value="Powrót do strony głównej"/>
    </form>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <br>Imię:<br>
        <input type="text" name="first_name" placeholder="Wpisz imię" required><br>
        <br>Nazwisko:<br>
        <input type="text" name="last_name" placeholder="Wpisz nazwisko" required><br>
        <br><input type="submit" value="Dodaj">
    </form>
    
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            require_once('db_settings.php');

            $conn = pg_connect("$db password=$spass");
            if (!$conn) {
                echo "<hr>Wystąpił błąd z połączeniem!<br/>\$db: ($db)\n";
                echo pg_last_error($conn);
                exit;
            }

            $query = "INSERT INTO runners (first_name, last_name) VALUES ('$first_name', '$last_name')";
            $result = pg_query($conn, $query);
            if (!$result) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            } else {
                echo "<hr>Biegacz $first_name $last_name został dodany pomyślnie!<br>";
            }

            pg_close($conn);
        }
    ?>
</center>
</body>
</html>
