<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta charset="utf-8" />
    <title>Usuwanie Biegu</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
    <h1>Runners APP - Usuń Bieg</h1>
    
    <form action="index.php">
        <input type="submit" value="Powrót do strony głównej"/>
    </form>
    
    <?php
		require_once('db_settings.php');

        $conn = pg_connect($db);
        if (!$conn) {
            echo "<hr>Wystąpił błąd z połączeniem!<br/>\$db: ($db)\n";
            echo pg_last_error($conn);
            exit;
        }

        $query = "SELECT rr.run_id, r.first_name || ' ' || r.last_name || ' - ' || rr.time || ' - ' || rr.distance || ' km' AS opis_biegu
                  FROM running_results rr
                  JOIN runners r ON rr.runner_id = r.runner_id;";
        $result = pg_query($conn, $query);
        if (!$result) {
            echo "An error occurred.\n";
            echo pg_last_error($conn);
            exit;
        }

        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<br>Wybierz bieg do usunięcia:<br>';
        echo '<select name="run_id">';
        
        while ($row = pg_fetch_assoc($result)) {
            echo '<option value="' . $row['run_id'] . '">' . $row['opis_biegu'] . '</option>';
        }
        
        echo '</select><br>';
        echo '<br><input type="submit" value="Usuń">';
        echo '</form>';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $run_id = $_POST['run_id'];

            // Delete from run_detail
            $query1 = "DELETE FROM run_detail WHERE run_id = $run_id;";
            $result1 = pg_query($conn, $query1);
            if (!$result1) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            }

            // Delete from running_results
            $query2 = "DELETE FROM running_results WHERE run_id = $run_id;";
            $result2 = pg_query($conn, $query2);
            if (!$result2) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            } else {
                echo "<hr>Bieg został usunięty pomyślnie!<br>";
            }

            pg_close($conn);
        }
    ?>
</center>
</body>
</html>
