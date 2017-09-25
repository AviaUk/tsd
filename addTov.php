<?php
session_start();
include("./inc.php");
if ($_POST["action"] == "Найти товар" && !empty($_POST['scode'])) {


    if(empty($_SESSION['prodRef'])){
        $pr = WSFacade::getProduct($_POST['scode']);
        if (!empty($pr)) {
            $_SESSION['prod'] = $pr->Name;
            $_SESSION['prodRef'] = $pr->ref;
            $_SESSION['prodAmount'] = $pr->amount;
            $_SESSION['char'] = $pr->char;

        }

    }else{


        if (!empty($_POST['scode']) && !empty($_SESSION['prodRef'])) {
            $err = WSFacade::insProduct($_SESSION['zakaz']->GUID, $_SESSION['prodRef'], $_POST['scode'], $_SESSION['char']);
            if (!empty($err)) {
                print $err;

            }
            unset($_SESSION['prod']);
            unset($_SESSION['prodRef']);
            unset($_SESSION['prodAmount']);
            unset($_SESSION['char']);
        }
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
<body onload="document.getElementById('scode').focus();">
<script language="javascript">

    function erase_label() {
        document.getElementById('prodName').innerHTML = '';
        document.getElementById('prodAmount').innerHTML = '';
        document.getElementById('result').innerHTML = '';

    }

</script>
<div class="appframe">
    <div class="action">
        <div class="addHeader"><?php if (!empty($_SESSION['zakaz']->Number)) {
                $z = $_SESSION['zakaz'];
                print $z->ClientName;
                print "<br />";
                print $z->Number;

            } elseif (empty($_SESSION['zakaz']->Number)) {
                echo "<label id=\"order\">Не установлен заказ покупателя!</label>";
            } ?> </div>
        <a href="zakazlist.php"><
            <назад
        </a>
        <table width="300" border="0">
            <tr>
                <td>
                    <form name="new" method="post" action="addTov.php"
                    ">


                    <div>Штрихкод</div>
                    <input type="text" onclick="erase_label()" name="scode" id="scode" placeholder="Штрихкод товара"
                           size='18'><input type="submit" name="action"
                                            value="Найти товар"
                                            class="actionmain"/>


                </td>
            </tr>
            <tr>
                <td>
                    <label id="prodName" class="addAm"><?php if (!empty($_SESSION['prod'])) {
                            print $_SESSION['prod'];

                        } else {
                            print "<div class='block-errormsg'> Не выбран товар в базе</div>";
                        }

                        ?></label>
                    <br/>
                    <label id="prodAmount" class="addAm2"><?php if (!empty($_SESSION['prodAmount'])) {
                            print "Остаток 1С: ";
                            print $_SESSION['prodAmount'];

                        }

                        ?></label>
                </td>
            </tr>
        </table>
        <div>Количество</div>
        <form method="post" action="addTov.php">
            <input type="text" name="amount" id="amount" placeholder="Количество товара" size='18'>

            <input type="submit" name="action" value="Добавить в заказ" class="actionmain" onclick="var str=document.getElementById('order');
            if (str.innerHTML=='Не установлен заказ покупателя!') {
                document.getElementById('result').innerHTML='Не установлен заказ покупателя!'
                 return false;}">
        </form>
        <br/>
        <input type="hidden" id="result" value=" <?php if (!$_SESSION['prod'] == "" && $_POST["action"] == "Добавить в заказ") {
                print "Товар добавлен в заказ!";
                unset($_SESSION['prod']);
                unset($_SESSION['prodAmount']);
        } ?>" />
        <script type="application/javascript">

            if (document.getElementById('result').value ==" Товар добавлен в заказ!") {

                    document.getElementById('prodName').innerHTML = document.getElementById('result').value;
                    document.getElementById('prodAmount').innerHTML = '';
                }


        
        </script>

    </div>
</div>
</body>
</html>