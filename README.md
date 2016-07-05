/* 
    example usage 
     
    $log = new logger('/path/to/log.txt'); //if file doesnt exiists, will be created
    $log->log_start(); //this will insert timestap to mark the beginning
    if($sallary < $work) {
	$log->log_message('Not acceptable sallary/work ratio');
    }
    $log->log_end(); //this will insert timestap to mark the end of current log
     
    */
