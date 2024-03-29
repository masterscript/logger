<?php

class logger {
	private $file;
	private $error = false;

	function __construct($file) {
	    if(file_exists($file) && ((filesize($file) / 1024) > 1024)) {
		$dirname = dirname($file);
		$filename = basename($file);
		$newname = $dirname.'/'.date('d.m.Y').'_'.$filename;
		if(!rename($file, $newname)) {
		    $this->error = 'Can\'t rename the old log file';
		}
		foreach (glob($dirname.'/*.log') as $logfile) {
		    //ако има стари логове на повече от 1 месец
		    if(filemtime($logfile) < (time() - (30 * 24 * 3600))) {
			unlink($logfile);
		    }
		}
		file_put_contents($file, '');
	    }
	    elseif(!file_exists($file)) {
		file_put_contents($file, '');
	    }
	    $this->file = $file;
	}

	function log_start() {
	    $msg_start = 'Start time: '.date('d.m.Y h:i:s').PHP_EOL;
	    if(!file_put_contents($this->file, $msg_start, FILE_APPEND)) {
		$this->error = 'Can\'t write to log';
	    }
	}

	function log_message($message) {
	    $message = $message.PHP_EOL;
	    if(!file_put_contents($this->file, $message, FILE_APPEND)) {
		$this->error = 'Can\'t write to log';
	    }
	}

	function log_end() {
	    $msg_end  = 'End time: '.date('d.m.Y h:i:s').PHP_EOL;
	    $msg_end .= '-------------------------------'.PHP_EOL;
	    if(!file_put_contents($this->file, $msg_end, FILE_APPEND)) {
		$this->error = 'Can\'t write to log';
	    }
	}

	function is_error() {
	    if($this->error != false) {
		return true;
	    }
	    return false;
	}

    function get_error() {
	    return $this->error;
    }
}

/* 
    example usage 
     
    $log = new logger('/path/to/log.txt'); //if file doesnt exiists, will be created
    $log->log_start(); //this will insert timestap to mark the beginning
    if($sallary < $work) {
	$log->log_message('Not acceptable sallary/work ratio');
    }
    $log->log_end(); //this will insert timestap to mark the end of current log
     
    */
?>