<?php

include("./inc.php");
Commons::printHeaders();
if ($_POST["action"] == "Выход") {
    unset($_SESSION['zakaz']);
    unset($_SESSION['clientRef']);
    unset($_SESSION['sum']);
    Commons::logout();
    Commons::redirect("login.php");
}
if ($_POST["action"] == "Создать заказ") {
    unset($_SESSION['zakaz']);
    unset($_SESSION['clientRef']);
    unset($_SESSION['sum']);
    Commons::redirect("new.php");
}
if ($_POST["action"] == "Добавить товар") {
    unset($_SESSION['prod']);
    unset($_SESSION['prodRef']);
    unset($_SESSION['prodAmount']);
    unset($_SESSION['char']);
    Commons::redirect("addTov.php");
}
function rf($zakaz)
{
    if (!empty($_SESSION['guid'])) {
        $tab = WSFacade::getTabTovar($_SESSION['guid']);
    }
    if (!empty($tab)) {
        if (gettype($tab->element->Name) == "string") {
            $e = $tab;
        } else {
            $e = $tab->element;
        }
        $sum = 0;
        $i = 0;
        foreach ($e as $value) {
            $i++;
            $all=$i."_".$value->RefTovar;
            echo "<tr ><td colspan='6' style='max-width: 292px; word-break: break-all'>$value->Name </td> </tr>";
            echo "<tr><td width=\"100\">  $value->Shtrihcode </td>";
            echo " <td width=\"50\"><input type=\"text\" onchange='check_field(this.value)' size='4' name=$all value= $value->Kolichestvo> </td>";
            echo "  <td width=\"50\">  $value->Cena  </td>";
            echo " <td width=\"50\"> $value->Skidka</td>";
            echo " <td width=\"50\">$value->Sum</td></tr> ";
            $sum = $sum + $value->Sum;
        };
        $_SESSION['sum'] = $sum;
    };

}

function head($zakaz)
{
    $err = $zakaz->Err;
    $d = Commons::formatDate($zakaz->Date);

    print $zakaz->ClientName;
    print " ";
    print $zakaz->Number;
    print " ";
    if (!empty($zakaz->Date)) {
        $d;
    }
    if (!empty($zakaz->Date)) {
        print " от ";
        print $d;
    }


    if (!empty($zakaz->Err) && $_POST["action"] == "Найти по номеру") {
        print "Заказ по данному номеру не найден!";
    }
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
<script type="application/javascript">
    function check_field(str) {
        document.getElementById('write').innerHTML = '*Не записан';
        if (isNaN(str)) {
            document.getElementById('write').innerHTML = 'Введено неверное значение';
            document.getElementById('sub_write').setAttribute("disabled", "disabled")
        }
        else {
            document.getElementById('sub_write').removeAttribute("disabled")
        }
    }


</script>
<div class="appframe">
    <div class="action">


        <form action="zakazlist.php" method="post">

            <input id="sub_search" type="submit" name="action" value="Найти по номеру" class="actionmain">
            <input id="search" type="text" name="scode" id="scode" placeholder="Номер документа 1С" size='18'></form>
        <form method="post" action="zakazlist.php"
        ">
        <input type="submit" name="action" value="Создать заказ" class="actionmain"/>
        <br/>
        <form method="post" action="zakazlist.php"
        ">
        <input type="submit" name="action" value="Выход" class="actionmain"/>


        <div class="addHeader"><label id="head">
                <?php
                if (isset($_POST["scode"]) && $_POST["action"] == "Найти по номеру") {
                    unset($_SESSION['sum']);
                    $zakaz = WSFacade::searchZakazByNumder($_POST["scode"]);
                    $_SESSION['zakaz'] = $zakaz;
                }
                head($_SESSION['zakaz']);
                ?> </label></div>
        <label id="write" class="block-errormsg"><br/></label>
        <hr align="center" width="300" color="black">
        <form action="zakazlist.php" method="post">
            <INPUT type="submit" id="sub_write" name="action" value="Записать документ" class="actionmain"
            >
            <form method="post" action="zakazlist.php"
            ">
            <input type="submit" name="action" value="Добавить товар" class="actionmain"/>
            <br/>
            <label id="sum" class="addAm2"></label>

            <table width="300" border="1">
                <tr>
                    <td width="100">Штрихкод</td>
                    <td width="50">К-во</td>
                    <td width="40">Цена</td>
                    <td width="40">Скидка</td>
                    <td width="50">Сумма</td>
                </tr>
            </table>
<div class="tab">
            <table id=\"dataTable\" width=300 border=1>
                <?php $_SESSION['guid'] = $_SESSION['zakaz']->GUID;

                ?>
                <?php if ($_POST["action"] == "Записать документ" && !empty($_SESSION['guid'])) {
                    $up = array();
                    $g = $_SESSION['guid'];
                    $up[0] = $g;
                    foreach ($_POST as $obj => $vol) {
                        $up[] = array($obj => $vol);
                    }
                    WSFacade::uploadTab($up);

                } elseif ($_POST["action"] == "Записать документ" && empty($_SESSION['guid'])) {
                    echo "Нет активного заказа для записи";
                }

                if (!empty($_SESSION['zakaz'])) {
                    rf($_SESSION['zakaz']);
                }
                ?>
            </table>
</div>
            <input type="hidden" id="hidden_sum" value="<?php if (!empty($_SESSION['sum'])) {
                echo "Сумма заказа: " . $_SESSION['sum'] . " грн.";
            } else {
                echo "<br/>";
            }
            ?>"
            />

            <script type="application/javascript">

                    document.getElementById('sum').innerHTML= document.getElementById('hidden_sum').value;

            </script>
        </form>
    </div>
</div>
</body>
</html>