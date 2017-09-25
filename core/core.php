<?php class Commons
{
    static function checkLogin()
    {
        return (@$_SESSION['token'] != '') ? true : false;
    }

    static function getHostName()
    {
        return $_SERVER['HTTP_HOST'];
    }

    static function redirect($url)
    {
        global $contextPath;
        header('Location: http://' . Commons::getHostName() . $contextPath . '/' . $url);
    }

    static function printUsersCombo()
    {
        $users = WSFacade::getUsers();
        print('<select name="username" class="formfield formfield-rubber" onchange="document.getElementById(\'pswd\').focus();">');
        foreach ($users as $user) {
            print('<option value="' . $user->UserName . '">' . $user->UserName . '</option>');
        }
        print('</select>');
    }

    static function login($username, $password)
    {
        $tok = WSFacade::authorize($username, $password);
        if ($tok != '') {
            $_SESSION['token'] = $username;
            $_SESSION['pass'] = $password;
            return true;
        }
        return false;
    }

    static function logout()
    {
        $_SESSION['token'] = "";
        $_SESSION['pass'] = "";
    }

    static function close_session()
    {
        Commons::logout();
        Commons::redirect("login.php");
    }

    static function printHeaders()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header('Content-Type: text/html; charset=UTF-8');
    }

    static function formatDate($date)
    {
        if ($date != '0001-01-01') {
            return date('d.m.Y', strtotime($date));
        } else {
            return '&nbsp;';
        }
    }

    static function formatDateTime($date)
    {
        if (strpos($date, '0001-01-01') !== 0) {
            return date('d.m.Y H:i:s', strtotime($date));
        } else {
            return '&nbsp;';
        }
    }
}