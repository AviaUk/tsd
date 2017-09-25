<?php $ST_NEW = "New";
$ST_PROV = "Proveden";
$ST_CR_WEB = "SozdanWeb";
$ST_CR_1C = "Sozdan1C";

class cUser
{
    public $UserName;
}

class cgetNewZakaz
{
    public $GUID;

}

class cZakaz
{
    public $nd;
}

class cClient
{
    public $edrpo;
}

class cZakazTovar
{
    public $GUID;
}

class cScode
{
    public $sk;
}

class cInsProd
{
    public $GUIDzakaz;
    public $refProd;
    public $amount;
    public $char;
}

class WSFacade
{
    public static function connect($login, $pass)
    {
        global $backendURL;
        try {
            $client = new SoapClient($backendURL, array("login" => mb_convert_encoding($login, 'windows-1251', 'utf-8'),
                "password" => $pass, "trace" => 1, "exceptions" => 1, "classmap" => array('User' => "cUser")));
        } catch (SOAPFault $e) {
            try {
                $check = new SoapClient($backendURL, array("login" => SOAP_DEFUSER_NAME,
                    "password" => SOAP_DEFUSER_PSWD, "trace" => 1, "exceptions" => 1, "classmap" => array('User' => "cUser")));
            } catch (SOAPFault $e) {
                Commons::printHeaders();
                print '<div style="color:red">Сервис временно недоступен. Повторите попытку позже.</div>';
                exit;
            }
        }
        return $client;
    }

    public static function getUsers()
    {
        $cl = WSFacade::connect(SOAP_DEFUSER_NAME, SOAP_DEFUSER_PSWD);
        $res = $cl->GetUserList();
        $users = array();
        foreach ($res->return->List as $user) {
            $users[] = clone $user;
        }
        return $users;
    }

    public static function authorize($username, $password)
    {
        $cl = WSFacade::connect($username, $password);
        if ($cl) {
            try {
                $cl->getUserList();
            } catch (SOAPFault $e) {
                return '';
            }
            return $username;
        } else {
            return '';
        }
    }

    public static function reconnect()
    {
        $u = $_SESSION["token"];
        $p = $_SESSION["pass"];
        try {
            $cl = WSFacade::connect($u, $p);
        } catch (SOAPFault $e) {
            Commons::redirect("login.php?err=1");
        }
        return $cl;
    }

    public static function searchZakazByNumder($NumDoc)
    {
        $cl = WSFacade::reconnect();
        $zk = new cZakaz();
        $zk->nd = $NumDoc;
        try {
            $r = $cl->PoiskZakaza($zk);
        } catch (SOAPFault $e) {
            print $e;
        };
        return clone $r->return;
    }

    public static function getTabTovar($Guid)
    {
        $cl = WSFacade::reconnect();
        $cTab = new cZakazTovar();
        $cTab->GUID = $Guid;

        try {
            $r = $cl->PoluchitSpisokTov($cTab);
        } catch (SOAPFault $e) {
            print $e;
        };

        return $r->return;
    }

    public static function uploadTab($ar)
    {
        $cl = WSFacade::reconnect();
        try {
            $r = $cl->CorTab(array("TovArray" => $ar));
        } catch (SOAPFault $e) {
            print $e;
        };
        if (!empty($r)) {
            return $r;
        }
    }

    public static function PoiskKontr($kod)
    {
        $cl = WSFacade::reconnect();
        $up = new cClient();
        $up->edrpo = $kod;
        try {
            $r = $cl->PoiskKontragenta($up);
        } catch (SOAPFault $e) {
            print $e;
        };
        if (!empty($r)) {
            return clone $r->return;
        }
    }


    public static function getNewZakaz($ref)
    {
        $cl = WSFacade::reconnect();
        $up = new cgetNewZakaz();
        $up->GUID = $ref;
        try {
            $r = $cl->getNewZakaz($up);
        } catch (SOAPFault $e) {
            print $e;
        };
        return clone $r->return;
    }

    public static function getProduct($scode)
    {
        $cl = WSFacade::reconnect();
        $up = new cScode();
        $up->sk = $scode;
        try {
            $r = $cl->getProduct($up);
        } catch (SOAPFault $e) {
            print $e;
        };
        return clone $r->return;
    }



    public static function insProduct($guid, $ref, $am, $char)
    {
        $cl = WSFacade::reconnect();
        $up = new cInsProd();
        $up->GUIDzakaz = $guid;
        $up->refProd = $ref;
        $up->amount = $am;
        $up->char = $char;
        try {
            $r = $cl->insProd($up);
        } catch (SOAPFault $e) {
            print $e;
        };
        return $r->return;
    }
}