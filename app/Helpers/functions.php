<?php

if (! function_exists('size_to_human')) {
	function size_to_human($size)
	{
		if ($size == 0) {
        	return "0.00 B";
		}

	    $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	    $e = floor(log($size, 1024));

	    return round($size/pow(1024, $e), 2).$s[$e];
	}
}