<?php include("./config.php"); include("./core/core.php"); include("./core/ws.php"); if(!Commons::checkLogin()) { Commons::redirect("login.php?err=1");} 
$is_oedit = strpos($_SERVER['REQUEST_URI'], "order_edit.php"); if($is_oedit === false) { $_SESSION['scodeNum']="";
} else { } ?>