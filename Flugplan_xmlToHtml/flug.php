<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flugplan</title>
</head>

<body>
    <h4>Flugplan</h4>

    <?php

    $xml = simplexml_load_file('flug.xml');

    $table = '';
    foreach ($xml as $tabelle) {
        $table .= '<h2>' . $tabelle['name'] . '</h2>';
        $table .= '<table border="1">';
        $table .= '<tr>';
        foreach ($tabelle->flug[0] as $header)
            $table .= '<td align="center"><b>' . $header['name'] . '</b></td>';
        $table .= '</tr>';
        foreach ($tabelle->flug as $flug) {
            $table .= '<tr>';
            foreach ($flug as $value) {
                $table .= '<td>' . $value . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
    }
    echo $table;
    ?>

</body>

</html>