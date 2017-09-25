<?php include("./inc_l.php");
Commons::printHeaders();

?> <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head><title><?php print $appTitle; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="./main.css">
</head>
<body onload="document.getElementById('pswd').focus();">
<div class="appframe"><b>Авторизация пользователя<br/><br/></b> <?php if (isset($_GET['err'])) { ?>
        <div class="block-errormsg"><p>Пользователь не авторизован!</p>
            <p>Подключение к базе данных невозможно.</p>
        </div> <?php } ?>
    <form method="POST" action="login_msg.php">
        <div class="block-dlg">
            <div class="formlabel">Пользователь</div>
            <div>
                <?php Commons::printUsersCombo(); ?>
            </div>
            <div class="formlabel">Пароль</div>
            <div><input id="pswd" class="formfield formfield-rubber" type="password" name="password"
                        style="background-color:white;"/></div>
            <div class="formlabel"><input type="Submit" name="Login" value="ОК" style="width:100px;"/></div>
        </div>
    </form>
</div>
</body>
</html>