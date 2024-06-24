<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta charset="utf-8" />
    <title>Dodawanie Biegu</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
    <h1>Runners APP - Dodaj Bieg</h1>
    
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
        $query = "SELECT runner_id, first_name || ' ' || last_name AS imie_i_nazwisko FROM runners;";
        $result = pg_query($conn, $query);
        if (!$result) {
            echo "An error occurred.\n";
            echo pg_last_error($conn);
            exit;
        }

        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<br>Wybierz biegacza:<br>';
        echo '<select name="runner_id">';
        
        while ($row = pg_fetch_assoc($result)) {
            echo '<option value="' . $row['runner_id'] . '">' . $row['imie_i_nazwisko'] . '</option>';
        }
        
        echo '</select><br>';
        echo '<br>Czas (HH:MM:SS)*:<br>';
        echo '<input type="text" name="time" placeholder="Wpisz czas" required><br>';
        echo '<br>Dystans (km)*:<br>';
        echo '<input type="number" step="0.01" name="distance" placeholder="Wpisz dystans" required><br>';
        echo '<br>Maksymalne tętno:<br>';
        echo '<input type="number" name="max_hb" placeholder="Wpisz maksymalne tętno"><br>';
        echo '<br>Średnie tętno:<br>';
        echo '<input type="number" name="avg_hb" placeholder="Wpisz średnie tętno"><br>';
        echo '<br>Średnia kadencja:<br>';
        echo '<input type="number" name="avg_cadence" placeholder="Wpisz średnią kadencję"><br>';
        echo '<br>Długość kroku (cm):<br>';
        echo '<input type="number" name="step_length" placeholder="Wpisz długość kroku"><br>';
        echo '<br><input type="submit" value="Dodaj">';
        echo '</form>';
		echo "* - pola wymagane";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $runner_id = $_POST['runner_id'];
            $time = $_POST['time'];
            $distance = $_POST['distance'];
            $max_hb = !empty($_POST['max_hb']) ? $_POST['max_hb'] : 'NULL';
            $avg_hb = !empty($_POST['avg_hb']) ? $_POST['avg_hb'] : 'NULL';
            $avg_cadence = !empty($_POST['avg_cadence']) ? $_POST['avg_cadence'] : 'NULL';
            $step_length = !empty($_POST['step_length']) ? $_POST['step_length'] : 'NULL';

            // Insert into running_results
            $query1 = "INSERT INTO running_results (runner_id, time, distance) VALUES ($runner_id, '$time', $distance) RETURNING run_id;";
            $result1 = pg_query($conn, $query1);
            if (!$result1) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            }
            $run_id = pg_fetch_result($result1, 0, 'run_id');

            // Insert into run_detail
            $query2 = "INSERT INTO run_detail (run_id, max_hb, avg_hb, avg_cadence, step_length) VALUES ($run_id, $max_hb, $avg_hb, $avg_cadence, $step_length);";
            $result2 = pg_query($conn, $query2);
            if (!$result2) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            } else {
                echo "<hr>Bieg został dodany pomyślnie!<br>";
            }

            pg_close($conn);
        }
    ?>
</center>
</body>
</html>
