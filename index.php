<?php include_once("./inc_l.php"); if (!Commons::checkLogin()) { Commons::redirect("login.php"); } else {
 Commons::redirect("zakazlist.php"); }