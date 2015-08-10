<?php
function logMessage($logLevel, $message)
{
    date_default_timezone_set('America/Chicago');
    $date = date("Y-m-d");
    $logDayTime = date("Y-m-d h:i:s a e");
    $filename = "log-{$date}.log";
    $handle = fopen($filename, "a");
    $log = "{$logDayTime} [{$logLevel}] {$message}" . PHP_EOL;
    if (file_exists($filename)){
        file_put_contents($filename, $log, FILE_APPEND);
    } else {
        file_put_contents($filename, $log);
    }
    fclose($handle);
}
// logMessage("INFO", "This is an info message.");
// logMessage("ERROR", "This is an error message.");

function logInfo($message)
{
    return logMessage("INFO", $message);
}

function logError($message)
{
    return logMessage("ERROR", $message);
}

logInfo("Don't Forget To Be Awesome");
logError("404");
?>