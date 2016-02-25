<?php
/*
 *	@name:		Hash Comparison
 *	@version:	0.5
 *	@status:	Beta
 *	@author:	Morten Haugstad
 *	
 *	@desc:		A CLI tool for comparing a hashes against each other. 
 *				This tool uses a dictionary attack, to match. So if the hash has been salted,
 *				this will not work. But lets be hones, people are stupid sometimes.
 *
 *	@licence: 	CC
 *
 *	@use:		index.php -a [HASH_ALGO] -h [HASH] --dict="[DICT]" --file="[FILE]" 
 * 	
 *
 *------------------------------------------------------------------------+
 * This script is used solely for informative, educational        		  |
 * purposes only. Author cannot be held responsible for any               |
 * damage and (or) (ab)use of this script.                                |
 *------------------------------------------------------------------------+
 */
/*
 *	Error Reporting
 */
error_reporting(0);

/*
 *	CLI Check, need to be run trough PHP Shell.
 */
if (php_sapi_name() != 'cli') {
	exit("\r\nPHP shell only! Exiting...\r\n");
}

/*
 *	Script Includes
 */
require_once 'functions.php';

/*
 *	Some constants to help keep track of things
 */
define ("DICTIONARIES_DIR", "dictionaries/");
define ("REPORTS_DIR", "reports/");


/*
 *	Functions
 */

/*
 *	@name:	Greeting
 *	@param:	none
 *
 *	@return string
 */
function Greeting() {
	$Greeting = "
-----------------------------------------------------------------------------
	Welcome to Hash Comparison, your friendly password hash comparison.
				(Dictionary Password Attack)
	
	Developed by CodeBarbarian for educational purposes only.
		twitter @codebarbarian
		github @codebarbarian

				Good luck, and happy hunting! 
-----------------------------------------------------------------------------\r\n";
	
	return $Greeting;
}

/*
 *	This function needs to be created...
 */
function LogToFile($Data, $File) {
	
}

function GetDictionaries($DictionaryDir) {
	$FileInfo = array();

	foreach(glob($DictionaryDir.'*.txt') as $Filename) {
		$FileInfo[$Filename] = filesize($Filename);
	}
	
	asort($FileInfo);
	
	return $FileInfo;
} 

/*
 *	@name:	CountLines
 *	@param:	string
 *	@return: integer
 */
function CountLines($File) {
    $File  = fopen($File, 'rb');
    $Lines = 0;

    while (!feof($File)) {
        $Lines += substr_count(fread($File, 8192), "\n");
    }

    fclose($File);

    return $Lines;
}

/*
 *	Display function (Helpers) for logging.
 */
function Log_Start($Data) {
	$Date = date("H:i:s d-m-Y"); // Date & Time
	$Log  = "
-----------------------------------------------------------------------------
Logging Starts @ {$Date}, trying to find a match for {$Data}  
-----------------------------------------------------------------------------
\r\n";

	return $Log;
}

function Log_End($Data) {
	$Date = date("H:i:s d-m-Y"); // Date & Time
	$Log  = "
-----------------------------------------------------------------------------
Logging Ended @ {$Date}, {$Data} 
-----------------------------------------------------------------------------
\r\n";
	
	return $Log;
}

function Log_Dictionary($Data) {
	$Date = date("H:i:s d-m-Y"); // Date & Time
	$Log  = "
-----------------------------------------------------------------------------
			Trying dictionary: {$Data}
-----------------------------------------------------------------------------
\r\n";

	return $Log;
}
/*
 *	@name:		CheckHash
 *	
 *	@param:		array (Dictionary)
 *	@param:		string
 *	@param:		string
 *
 *	@return:	on true  : array
 *	@return:	on false : bool 
 */
function CheckHash ($Dictionary = array(), $HashAlgo, $Hash, $LogFile = false) {
	if ($LogFile) {
		LogToFile(Log_Start($Hash), $LogFile);
	}
		
	foreach($Dictionary as $Value) {
		
		if ($LogFile) {
			LogToFile(Log_Dictionary($Value), $LogFile);
		}
		
		$Count 		 = 0;
		$NrPasswords = 0;
		
		print_r("
-----------------------------------------------------------------------------
		Using {$Value} as dictionary
-----------------------------------------------------------------------------\r\n");

		
		$NrPasswords = CountLines($Value);
		$Count		 = 1;
		
		$Dict = fopen($Value, "rb");
		
		while(!feof($Dict)){
			
			$Password = fgets($Dict);
			
			$Password = str_replace(array("\r", "\n"), '', $Password);
			
			if (($Result = hash($HashAlgo, $Password)) == $Hash) { 
				show_status($NrPasswords, $NrPasswords); // Finish the progressbar
				if ($LogFile) {
					LogToFile(Log_End("MATCH FOUND! [+] " . $Password), $LogFile);
				}
				return array($Result, $Password);
			}
			
			show_status($Count, $NrPasswords); // Show a progress bar for each password -> dictionary is empty.
			$Count++;
		}
		fclose($Dict);	
	}
	return false;
}

$UseDictionary 	= false;
$UseFileStorage = false;


$ShortOps  = "";
$ShortOps .= "a:";
$ShortOps .= "h:";

$LongOps = array(
	"dict::",
	"file::"
);

/*
 *	Get the arguments passed to the script
 */
$Options = getopt($ShortOps, $LongOps);

/*
 *	Check to see if the required fields are set
 */
if (empty($Options['a']) || empty($Options['h'])) {
	exit("\r\nPlease provide a Hashing Algorithm and a Hash! Exiting...\r\n");
}

/*
 *	Check to see if the optional fields are set
 */
if (array_key_exists("dict", $Options)) {
	$UseDictionary = true;
}

if (array_key_exists("file", $Options)) {
	$UseFileStorage = true;
}

/*
 *	Let us check to see if we should use a custom dictionary
 *	If not let us use the script specific dictionary
 *		The script specific dictionaries, are created and maintained
 *		by the https://github.com/danielmiessler/SecLists
 */
if ($UseDictionary) {
	$Dictionary = explode(' ', $Options['dict']);
} else {
	$Dictionaries = GetDictionaries(DICTIONARIES_DIR);
	foreach($Dictionaries as $Key => $Value) {
		$Dictionary[] = $Key;
	}
}

if ($UseFileStorage) {
	$Filename = $Options['file'];
} else {
	$Filename = false;
}

/*
 *	Display the greeting message
 */
echo Greeting();

/*
 *	Store the CheckHash return value in $Result, 
 *	if true, return the hashed value of the password
 *	along with the password in clear text
 *
 *	if false, return bool
 * 	if true, return array. array[0] = hash, array[1] = word/password (CLEARTEXT)
 */

if ($Result = CheckHash($Dictionary, $Options['a'], $Options['h'], $Filename)) {
	print_r("
-----------------------------------------------------------------------------
[SUCCESS] Found a matching hash: {$Result[0]} 
[MATCHES] Matched the word: {$Result[1]}
-----------------------------------------------------------------------------\r\n");
} else {
	print_r("
-----------------------------------------------------------------------------
[FAILURE] No hash matching {$Options['h']} in dictionary!
-----------------------------------------------------------------------------\r\n");
}

