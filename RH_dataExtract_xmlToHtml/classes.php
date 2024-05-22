<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RH Classes</title>
</head>

<body>
    <?php
    // 7d2d root folder (absolute path of where the 7DaysToDie.exe is located)
    $folder7d2d = 'C:\Games\7d2d exp 21.2b30 for RH b16\7 Days To Die';
    $folder7d2d = str_replace('\\', '/', $folder7d2d);

    // recipes for names + ingredients
    $xmlRHClasses = simplexml_load_file($folder7d2d . '/Mods/Classes-JT/Config/quests.xml');

    for ($i = 0; $i < count($xmlRHClasses->append->quest); $i++) {
        $class = (string)$xmlRHClasses->append->quest[$i]['id'];
        $items = [];
        for ($j = 0; $j < count($xmlRHClasses->append->quest[$i]->reward); $j++) {
            if ($xmlRHClasses->append->quest[$i]->reward[$j]['type'] == "Item") {
                $items[] = 'Item: ' . (string)$xmlRHClasses->append->quest[$i]->reward[$j]['id'] . '(' . (string)$xmlRHClasses->append->quest[$i]->reward[$j]['value'] . ')';
            } elseif ($xmlRHClasses->append->quest[$i]->reward[$j]['type'] == "Exp") {
                $items[] = 'Exp: ' . (string)$xmlRHClasses->append->quest[$i]->reward[$j]['value'];
            } elseif ($xmlRHClasses->append->quest[$i]->reward[$j]['type'] == "Quest") {
                $items[] = 'Quest: ' . (string)$xmlRHClasses->append->quest[$i]->reward[$j]['id'];
            }
        }
        $classes[] = ['class' => $class, 'items' => $items];
    }
    ////////////////


    $table = '<table border ="1">';

    foreach ($classes as $rows) {
        $table .= '<tr>';

        $table .= '<td>';
        $table .= $rows['class'];
        $table .= '</td>';

        $table .= '<td>';
        $table .= '<ul type="none">';
        foreach ($rows['items'] as $li) {
            $table .= '<li>' . $li . '</li>';
        }
        $table .= '</ul>';
        $table .= '</td>';

        $table .= '</tr>';
    }

    $table .= '</table>';

    echo $table;

    ?>

</body>

</html>