<?php

$header = "Content-Type: application/json";

$stkCallBackRes = file_get_contents("php://input");
$logfile = "Mpesastkresponse.json";
$log = fopen($logfile, "a");
fwrite($log, $stkCallBackRes);
fclose($log);
?>