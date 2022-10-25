<?php
	$log_time = date('Y-m-d h:i:sa');
	$log_msg = "Sample log -----------";
	$LOG_LOCATION = "";
	$LOG_FILE = $LOG_FILE + 
	  
	wh_log("************** Start Log For Day : '" . $log_time . "'**********");
	wh_log($log_msg);
	wh_log("************** END Log For Day : '" . $log_time . "'**********");
	
	function wh_log($log_msg)
	{
		if (!file_exists($log_folder)) mkdir($LOG_LOCATION, true);
		$log_file_data = $log_folder.'/shurjopay-plugin'.'.log';
		file_put_contents($LOG_FILE, $log_msg . "\n", FILE_APPEND);
	}

?>