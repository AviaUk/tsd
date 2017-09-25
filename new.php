<?php

include("./inc.php");
if ($_POST["action"] == "Найти контрагента" && !empty($_POST['edrpo'])) {
    $client = WSFacade::PoiskKontr($_POST['edrpo']);
}
if ($_POST["action"] == "Новый заказ" && !empty($_SESSION['clientRef'])) {
    $_SESSION['zakaz'] = WSFacade::getNewZakaz($_SESSION['clientRef']);
    Commons::redirect("zakazlist.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php print $appTitle; ?></title>
</head>

<link rel="stylesheet" type="text/css" href="./main.css">
<body onload="document.getElementById('search').focus();">
<div class="appframe">

    <div class="action">
        <a href="zakazlist.php"><<назад</a>
        <table width="300" border="0">
            <tr>
                <td>
                    <form name="new" method="post" action="new.php"
                    ">
                    <input type="submit" name="action" value="Найти контрагента" class="actionmain"/>
                    <input id="search" type="text" name="edrpo" id="edrpo" placeholder="ЕДРПОУ контрагента" size='20'>
                   </form>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                   if (!empty($client)) {
                       print $client->Name;
                        $_SESSION['clientRef'] = $client->Ref;
                    } else {
                       print "<div class='block-errormsg'> Не установлен контрагент!</div>";
                    }
if(is_object($client)){$a=get_object_vars($client);
                   if(count($a)==0){print "<div class='block-errormsg'> Не найден контрагент!</div>";}
                   }


                    ?>
                </td>
            </tr>
        </table>
        <form method="post" action="new.php"
        ">
        <input type="submit" name="action" value="Новый заказ" class="actionmain"/>

    </div>
</div>
</body>
</html>