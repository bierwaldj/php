<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Din 5008 blank</title>
    <style>
        * {
            font-family: helvetica;
        }
    </style>
</head>

<body>
    <?php
    echo date('d.m.Y');
    ?>
    <form action="din5008creator.php" method="get">
        <table border="0">
            <tr>
                <td align="center" colspan=100%>
                <h2>PDF nach DIN 5008 erstellen</h2>
                </td>
            </tr>
    
            <tr>
                <td align="center" colspan=100%>
                    <h4>Absender</h4>
                </td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" id="aname" name="aname"></td>
            </tr>
            <tr>
                <td>Strasse</td>
                <td><input type="text" id="astr" name="astr"></td>
            </tr>
            <tr>
                <td>Hausnummer</td>
                <td><input type="text" id="ahsnr" name="ahsnr"></td>
            </tr>
            <tr>
                <td>Postleitzahl</td>
                <td><input type="number" id="aplz" name="aplz"></td>
            </tr>
            <tr>
                <td>Ort</td>
                <td><input type="text" id="aort" name="aort"></td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center" colspan=100%>
                    <h4>Empfänger</h4>
                </td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" id="ename" name="ename"></td>
            </tr>
            <tr>
                <td>Strasse</td>
                <td><input type="text" id="estr" name="estr"></td>
            </tr>
            <tr>
                <td>Hausnummer</td>
                <td><input type="text" id="ehsnr" name="ehsnr"></td>
            </tr>
            <tr>
                <td>Postleitzahl</td>
                <td><input type="number" id="eplz" name="eplz"></td>
            </tr>
            <tr>
                <td>Ort</td>
                <td><input type="text" id="eort" name="eort"></td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center" colspan=100%>
                    <h4>Info</h4>
                </td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Ihr Zeichen</td>
                <td><input type="text" id="usign" name="usign"></td>
            </tr>
            <tr>
                <td>Ihre Nachricht vom</td>
                <td><input type="date" id="udate" name="udate"></td>
            </tr>
            <tr>
                <td>Unser Zeichen</td>
                <td><input type="text" id="isign" name="isign"></td>
            </tr>
            <tr>
                <td>Unsere Nachricht vom</td>
                <td><input type="date" id="idate" name="idate"></td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" id="iname" name="iname"></td>
            </tr>
            <td>Telefon</td>
            <td><input type="number" id="iphone" name="iphone"></td>
            </tr>
            <td>Telefax</td>
            <td><input type="number" id="ifax" name="ifax"></td>
            </tr>
            <td>Email</td>
            <td><input type="email" id="imail" name="imail"></td>
            </tr>
            <td>Datum</td>
            <td><input type="date" id="today" name="today"></td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
            <td>Text</td>
            <td><textarea type="textarea" id="text" name="text"></textarea></td>
            </tr>
            <tr>
                <td colspan=100%>
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan=100% align="center"><input type="submit" id="submit" value="PDF erstellen"></td>
            </tr>
        </table>
    </form>
    <?php


    ?>

</body>

</html>