<?php

class Log
{
    public $filename;
    public $date;
    public $prefix;
    public $handle;

    public function __construct($prefix = 'log')
    {
        $this->date = date("Y-m-d");
        $this->filename = "{$prefix}-{$this->date}.log";
        $this->handle = fopen($this->filename, 'a');
    }


    public function logMessage($logLevel, $message)
    {
        $logDayTime = date("Y-m-d h:i:s a e");
        $stringToWrite = "{$logDayTime} [{$logLevel}] {$message}" . PHP_EOL;
        if (file_exists($this->filename)){
            file_put_contents($this->filename, $stringToWrite, FILE_APPEND);
        }
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function info($message)
    {
        return $this->logMessage('INFO', $message);
    }

    public function error($message)
    {
        return $this->logMessage('ERROR', $message);
    }
}
?>