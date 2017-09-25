<?php include("./inc_l.php"); $res = false; if (isset($_POST['username']) && isset($_POST['password'])) {
 $res = Commons::login($_POST['username'], $_POST['password']); } if ($res === false) { Commons::redirect("login.php?err=1");
} else { Commons::redirect("zakazlist.php"); }