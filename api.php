<?php

$url = 'https://freetestapi.com/api/v1/movies';
$response = file_get_contents($url);

if ($response !== false) {
    $data = json_decode($response, true);
?>

<html>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>YEAR</th>
            <th>LANGUAGE</th>
            <th>RATING</th>
        <tr>
        <?php
        foreach ($data as $movie){
            echo "<tr>
                <td>{$movie['id']}</td>
                <td>{$movie['title']}</td>
                <td>{$movie['year']}</td>
                <td>{$movie['language']}</td>
                <td>{$movie['rating']}</td>
            </tr>";
        }
        ?>
    </table>
</html>

<?php
} else {
    echo "Error en cargar los datos";
}
?>