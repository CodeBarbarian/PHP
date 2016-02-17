<?php
/*
 *	@name:			Noobies Error Handler
 *	@author:		CodeBarbarian
 *	@version:		0.0.1
 *
 *	@description: 	A friendly Error handler for every aspiring PHP Developer
 *	@licence: 		CC
 *	
 *	A little joke I saw on stackoverflow, and I had to improve a little bit on it.
 */

/*
 *	Error Handler
 */
function ErrorHandler($errno, $errstr, $errfile, $errline)
{
	$SearchSite = "http://stackoverflow.com/search?q=[PHP]";

    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
		case E_USER_ERROR:
			echo "<b>ERROR</b> [$errno] $errstr<br />\n";
			echo "  Fatal error on line $errline in file $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			exit(1);
			break;
	
		case E_USER_WARNING:
			echo "<b>WARNING</b> [$errno] $errstr<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			break;
	
		case E_USER_NOTICE:
			echo "<b>NOTICE</b> [$errno] $errstr<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			break;
		
		case E_ERROR:
			echo "<b>ERROR</b> [$errno] $errstr<br />\n";
			echo "  Fatal error on line $errline in file $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			exit(1);
			break;
		
		case E_WARNING:
			echo "<b>WARNING</b> [$errno] $errstr<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			break;
			
		case E_NOTICE:
			echo "<b>NOTICE</b> [$errno] $errstr<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			break;
		
		default:
			echo "Unknown error type: [$errno] $errstr<br />\n";
			echo "Take a look at <a href=\"{$SearchSite}{$errstr}\">{$errstr}</a>\n";
			break;
    }
    return true;
}

/*
 *	Set errorhandler to my errorhandler. 
 */
set_error_handler('ErrorHandler');

/*
 *	Testing to see if the errorhandler works.
 *
 *	Passing a non existent variable and as string, when expecting an array...
 *
 */
foreach($String as $Value) {
	// Never going to run
}

