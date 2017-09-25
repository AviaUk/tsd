<?php if (!file_exists('./zakaz.ini')) { echo 'Файл конфигурации приложения не найден. Пожалуйста, сообщиет администратору системы.';
} elseif (!is_readable('./zakaz.ini')) { echo 'Невозможно прочитать файл конфигурации. Пожалуйста, сообщиет администратору системы.';
} else { $expected = array( 'contextPath', 'title', 'WSDL', 'defUserName', 'defUserPassword',
 ); $ini = parse_ini_file('./zakaz.ini', false); if (count(array_diff($expected, $ini)) === 0) {
 echo 'Файл конфигурации не содержит необходимой информации. Пожалуйста, сообщиет администратору системы.';
} else { $contextPath = $ini['contextPath']; $appTitle = $ini['title']; $backendURL = $ini['WSDL'];
define('SOAP_DEFUSER_NAME', $ini['defUserName']); define('SOAP_DEFUSER_PSWD', $ini['defUserPassword']);
} } error_reporting(0); session_start();