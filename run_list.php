<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta charset="utf-8" />
    <title>Wyniki biegania</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
    <h1>Runners APP</h1>
    
    <form action="index.php">
        <input type="submit" value="Powrót do strony głownej"/>
    </form>
    
    <?php
        require_once('db_settings.php');

        $conn = pg_connect("$db password=$spass");
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
        echo '<br>wybierz numer:<br>';
        echo '<select name="numer">';
        
        while ($row = pg_fetch_assoc($result)) {
            echo '<option value="' . $row['runner_id'] . '">' . $row['imie_i_nazwisko'] . '</option>';
        }
        
        echo '</select><br>';
        echo '<input type="submit" value="Wybierz">';
        echo '</form>';
        
        if (isset($_POST['numer'])) {
            $numer = $_POST['numer'];
            $queryy = "SELECT
                        r.first_name || ' ' || r.last_name AS imie_i_nazwisko,
                        rr.distance AS odleglosc,
                        rr.time AS czas,
                        rd.max_hb AS maksymalne_tetno,
                        rd.avg_hb AS srednie_tetno,
                        rd.avg_cadence AS srednia_kadencja,
                        rd.step_length
                    FROM
                        running_results rr
                        INNER JOIN runners r ON rr.runner_id = r.runner_id
                        INNER JOIN run_detail rd ON rr.run_id = rd.run_id
                    WHERE
                        r.runner_id = $numer;";
            
            $result = pg_query($conn, $queryy);
            if (!$result) {
                echo "An error occurred.\n";
                echo pg_last_error($conn);
                exit;
            }

            echo '<p><table border="1" margin="10" cellpadding="10" cellspacing="2"><tbody>';
            echo '<tr><td><b>Rekord</b></td>';
            
            $fields = pg_num_fields($result);
            for ($i = 0; $i < $fields; $i++) {
                $fieldName = pg_field_name($result, $i);
                echo "<td><b>$fieldName</b></td>";
            }
            
            $num = pg_num_rows($result);
            for ($i = 0; $i < $num; $i++) {
                echo "<tr><td>$i</td>";
                $row = pg_fetch_row($result);
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table></p>";
        }

        pg_close($conn);
    ?>
</center>
</body>
</html>
