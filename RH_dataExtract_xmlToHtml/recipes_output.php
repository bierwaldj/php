<!-- WANT:
name / food / water / station / stamina / ingredients-->

<?php
// tableheaders for echo // ['name','craft_area','foodAmountAdd','waterAmountAdd','.foodStaminaBonusAdd','foodHealthAmount','dWellness']
$tableheader = ['name', 'craft_area', 'foodAmountAdd', 'waterAmountAdd', 'staminaAmountAdd', 'foodHealthAmount','dWellness'];

// 7d2d root folder (absolute path of where the 7DaysToDie.exe is located)
$folder7d2d = 'C:\Games\7d2d exp 21.2b30 for RH b16\7 Days To Die';
$folder7d2d = str_replace('\\', '/', $folder7d2d);

// recipes for names + ingredients
$xmlRHExpFoodRecipes = simplexml_load_file($folder7d2d . '/Mods/ExpandedFood-JT/Config/recipes.xml');
$xmlRecipesVanilla = simplexml_load_file($folder7d2d . '/Data/Config/recipes.xml');

// items for food/water/stamina/health/wellness values
$xmlRHExpFoodItems   = simplexml_load_file($folder7d2d . '/Mods/ExpandedFood-JT/Config/items.xml');
$xmlVNFoodItems = simplexml_load_file($folder7d2d . '/Data/Config/items.xml');
$xmlRHWellnessItems = simplexml_load_file($folder7d2d . '/Mods/Wellness-YKV/Config/items.xml');


// VN+RH recipes
$AllRecipes = array_values(array_unique(array_merge(RHFoodRecipes($xmlRHExpFoodRecipes), VNAllRecipes($xmlRecipesVanilla)), SORT_REGULAR));

// RH Wellness Items
$RHWellnessItems = extractSubstringsFromString(extractWellnessNamesAsString($xmlRHWellnessItems));
// create Wellness array
$RHWellnessItems = dWellness($RHWellnessItems, $xmlRHWellnessItems);

// lookup food values only if prefix =
$foodCheckup = ['food', 'drink'];

// add keys to all recipes // checkups first
$AllRecipes = foodAmountAdd($AllRecipes);
$AllRecipes = waterAmountAdd($AllRecipes);
$AllRecipes = staminaAmountAdd($AllRecipes);
$AllRecipes = foodHealthAmount($AllRecipes);
$AllRecipes = addWellnesstoAllRecipes($AllRecipes, $RHWellnessItems);





function cutBeforeFirstUppercase($string)
{
    if (preg_match('/[A-Z]/', $string, $matches)) {
        $firstUppercase = $matches[0];
        $position = strpos($string, $firstUppercase);
        return substr($string, $position);
    }
    return $string;
}
function cutAfterFirstUppercase($string2)
{
    return preg_replace('/([A-Z].*)/', '', $string2, 1);
}
function RHFoodRecipes($xml)
{
    $i = 0;
    $RHFoodRecipes = [];
    foreach ($xml->append as $RHrecipes) {

        foreach ($RHrecipes->recipe as $recipename) {
            $RHFoodRecipes[$i]['name']  = (string)$recipename['name'];
            $RHFoodRecipes[$i]['craft_area'] = (string)$recipename['craft_area'];
            $i++;
        }
    }
    return $RHFoodRecipes;
}
function VNAllRecipes($xml)
{
    $i = 0;
    $VNAllRecipes = [];
    foreach ($xml as $VNRecipes) {
        $VNAllRecipes[$i]['name']  = (string)$VNRecipes['name'];
        $VNAllRecipes[$i]['craft_area'] = (string)$VNRecipes['craft_area'];
        $i++;
    }
    return $VNAllRecipes;
}
function foodAmountAdd($AllRecipes)
{
    global $foodCheckup;
    global $xmlRHExpFoodItems;
    global $xmlVNFoodItems;
    for ($i = 0; $i < count($AllRecipes); $i++) {
        if (in_array(cutAfterFirstUppercase($AllRecipes[$i]['name']), $foodCheckup)) {
            if (!empty($foodResult = $xmlRHExpFoodItems->xpath('//append/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$foodAmountAdd"]'))) {
                $AllRecipes[$i]['foodAmountAdd'] = $foodResult[0]['value'];
            } elseif (!empty($foodResult = $xmlRHExpFoodItems->xpath('//insertAfter/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$foodAmountAdd"]'))) {
                $AllRecipes[$i]['foodAmountAdd'] = $foodResult[0]['value'];
            } elseif (!empty($foodResult = $xmlVNFoodItems->xpath('//item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$foodAmountAdd"]'))) {
                $AllRecipes[$i]['foodAmountAdd'] = $foodResult[0]['value'];
            } else {
                $AllRecipes[$i]['foodAmountAdd'] = 0;
            }
        } else $AllRecipes[$i]['foodAmountAdd'] = 0;
    }
    return $AllRecipes;
}
function waterAmountAdd($AllRecipes)
{
    global $foodCheckup;
    global $xmlRHExpFoodItems;
    global $xmlVNFoodItems;
    for ($i = 0; $i < count($AllRecipes); $i++) {
        if (in_array(cutAfterFirstUppercase($AllRecipes[$i]['name']), $foodCheckup)) {
            if (!empty($waterResult = $xmlRHExpFoodItems->xpath('//append/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$waterAmountAdd"]'))) {
                $AllRecipes[$i]['waterAmountAdd'] = $waterResult[0]['value'];
            } elseif (!empty($waterResult = $xmlRHExpFoodItems->xpath('//insertAfter/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$waterAmountAdd"]'))) {
                $AllRecipes[$i]['waterAmountAdd'] = $waterResult[0]['value'];
            } elseif (!empty($waterResult = $xmlVNFoodItems->xpath('//item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="$waterAmountAdd"]'))) {
                $AllRecipes[$i]['waterAmountAdd'] = $waterResult[0]['value'];
            } else {
                $AllRecipes[$i]['waterAmountAdd'] = 0;
            }
        } else $AllRecipes[$i]['waterAmountAdd'] = 0;
    }
    return $AllRecipes;
}
function staminaAmountAdd($AllRecipes)
{
    global $foodCheckup;
    global $xmlRHExpFoodItems;
    global $xmlVNFoodItems;
    for ($i = 0; $i < count($AllRecipes); $i++) {
        if (in_array(cutAfterFirstUppercase($AllRecipes[$i]['name']), $foodCheckup)) {
            if (!empty($staminaResult = $xmlRHExpFoodItems->xpath('//append/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar=".foodStaminaBonusAdd"]'))) {
                $AllRecipes[$i]['staminaAmountAdd'] = $staminaResult[0]['value'];
            } elseif (!empty($staminaResult = $xmlRHExpFoodItems->xpath('//insertAfter/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar=".foodStaminaBonusAdd"]'))) {
                $AllRecipes[$i]['staminaAmountAdd'] = $staminaResult[0]['value'];
            } elseif (!empty($staminaResult = $xmlVNFoodItems->xpath('//item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar=".foodStaminaBonusAdd"]'))) {
                $AllRecipes[$i]['staminaAmountAdd'] = $staminaResult[0]['value'];
            } else {
                $AllRecipes[$i]['staminaAmountAdd'] = 0;
            }
        } else $AllRecipes[$i]['staminaAmountAdd'] = 0;
    }
    return $AllRecipes;
}
function foodHealthAmount($AllRecipes)
{
    global $foodCheckup;
    global $xmlRHExpFoodItems;
    global $xmlVNFoodItems;
    for ($i = 0; $i < count($AllRecipes); $i++) {
        if (in_array(cutAfterFirstUppercase($AllRecipes[$i]['name']), $foodCheckup)) {
            if (!empty($healthResult = $xmlRHExpFoodItems->xpath('//append/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="foodHealthAmount"]'))) {
                $AllRecipes[$i]['foodHealthAmount'] = $healthResult[0]['value'];
            } elseif (!empty($healthResult = $xmlRHExpFoodItems->xpath('//insertAfter/item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="foodHealthAmount"]'))) {
                $AllRecipes[$i]['foodHealthAmount'] = $healthResult[0]['value'];
            } elseif (!empty($healthResult = $xmlVNFoodItems->xpath('//item[@name="' . $AllRecipes[$i]['name'] . '"]/effect_group/triggered_effect[@cvar="foodHealthAmount"]'))) {
                $AllRecipes[$i]['foodHealthAmount'] = $healthResult[0]['value'];
            } else {
                $AllRecipes[$i]['foodHealthAmount'] = 0;
            }
        } else $AllRecipes[$i]['foodHealthAmount'] = 0;
    }
    return $AllRecipes;
}
function addWellnesstoAllRecipes($firstArray, $secondArray)
{
    global $foodCheckup;
    for ($i = 0; $i < count($firstArray); $i++) {
        if (in_array(cutAfterFirstUppercase($firstArray[$i]['name']), $foodCheckup)) {
            for ($j = 0; $j < count($secondArray); $j++) {
                if($firstArray[$i]['name']==$secondArray[$j]['name']){
                    $wellness = $secondArray[$j]['dWellness'];
                    $j=count($secondArray);
                } else {$wellness = 0;}
            }
        } else {$wellness = 0;}
        $firstArray[$i]['dWellness'] = $wellness;
    }
    return $firstArray;
}
function mergeAndAddKey($array1, $array2, $keyName)
{
    // Merge the arrays
    $mergedArray = array_merge($array1, $array2);

    // Remove duplicate values
    $uniqueArray = array_unique($mergedArray, SORT_REGULAR);

    // Add the key from the new array
    $finalArray = array_combine(array_column($uniqueArray, $keyName), $uniqueArray);

    return $finalArray;
}

function extractWellnessNamesAsString($xml)
{
    $string = '';
    foreach ($xml as $append)
        $string .= $append['xpath'];
    return $string;
}
function extractSubstringsFromString($string)
{

    preg_match_all("/@name='(.*?)'/", $string, $matches);
    $result = array();
    foreach ($matches[1] as $match) {
        $result[]['name'] = $match;
    }
    return $result;
}

function dWellness($array, $xml)
{
    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($xml->append); $j++) {
            if (str_contains($xml->append[$j]['xpath'], $array[$i]['name'])) {
                $converthis = (int)$xml->append[$j]->effect_group->display_value['value'];
                $j = count($xml->append);
            } else {
                $converthis = 0;
            }
        }
        $array[$i]['dWellness'] = $converthis;
    }
    return $array;
}

function htmlTable($AllRecipes)
{
    global $tableheader;

    $tabletest = '<table border ="1">';
    $tabletest .= '<tr>';
    foreach ($tableheader as $value) {
        $tabletest .= '<td>' . $value . '</td>';
    }
    $tabletest .= '</tr>';
    for ($i = 0; $i < count($AllRecipes); $i++) {

        $tabletest .= '<tr>';
        for ($j = 0; $j < count($tableheader); $j++) {
            $tabletest .= '<td>' . $AllRecipes[$i][$tableheader[$j]] . '</td>';
        }
        $tabletest .= '</tr>';
    }
    $tabletest .= '</table>';
    return $tabletest;
}
?>
<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

    <?php echo htmlTable($AllRecipes); ?>

</body>

</html>