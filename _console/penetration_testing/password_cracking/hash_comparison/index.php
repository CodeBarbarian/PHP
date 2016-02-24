<?php
/*
 *	@name:		Hash Comparison
 *	@version:	0.1
 *	@status:	In Development
 *	@author:	Morten Haugstad
 *	
 *	@desc:		A CLI tool for comparing a hashes against each other. 
 *				This tool uses a dictionary attack, to match. So if the hash has been salted,
 *				this will not work. But lets be hones, people are stupid sometimes.
 *
 *	@licence: 	CC
 *
 *	@use:		index.php -a [HASH_ALGO] -h [HASH] --dict="[DICT]" --file="[FIILE]" 
 * 	
 *
 *------------------------------------------------------------------------+
 * This script is used solely for informative, educational        		  |
 * purposes only. Author cannot be held responsible for any               |
 * damage and (or) (ab)use of this script.                                |
 *------------------------------------------------------------------------+
 */
error_reporting(0);

// CLI Check
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
define ("DICTIONARIES_DIR", "dict/");
define ("REPORTS_DIR", "");


/*
 *	Functions
 */

/*
 *	@name:	Greeting
 *
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
 *	THE IDEA HERE IS TO CHECK TO SEE IF THE DICTIONARIES ARE IN THE RIGHT FOLDER
 *	THIS FUNCTIONS NEEDS TO BE IN PLACE BEFORE WE DO ANYTHING MORE.
 *
 *
 */
function CheckDictionaries($Dictionaries = array()) {
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
function CheckHash ($Dictionary = array(), $HashAlgo, $Hash) {
	foreach($Dictionary as $Value) {
		$Count 		 = 0;
		$NrPasswords = 0;
		
		print_r("
-----------------------------------------------------------------------------
		Using {$Value} as dictionary
-----------------------------------------------------------------------------\r\n");
		
		$NrPasswords = count(file(DICTIONARIES_DIR.$Value));
		$Count		 = 1;
		
		$Dict = fopen(DICTIONARIES_DIR.$Value, "rb");
		
		while(!feof($Dict)){
			
			$Password = fgets($Dict);
			
			// Getting rid of those nasty win/*nix EOF problems
			$Password = str_replace(array("\r", "\n"), '', $Password);
			
			if (($Result = hash($HashAlgo, $Password)) == $Hash) { 
				show_status($NrPasswords, $NrPasswords); // Finish the progressbar
				return array($Result, $Password);
			}
			
			show_status($Count, $NrPasswords); // Show a progress bar for each password -> dictionary is empty.
			$Count++;
		}
		fclose($Dict);	
	}
	return false;
}

$UseSalt 		= false;
$UseDictionary 	= false;
$UseFileStorage	= false;

$ShortOps  = "";
$ShortOps .= "a:";
$ShortOps .= "h:";

$LongOps = array(
	"salt::",
	"dict::",
	"file::",
);

/*
 *	Get the arguments passed to the script
 */
$Options = getopt($ShortOps, $LongOps);

/*
 *	These are the default dictionaries provided with the script.
 *	The CheckDictionaries() function will do a check to see,
 * 	if all the dictionaries are present, if not. Use only those
 *	that are available. If none are present, the script will halt.
 *	
 *	This script uses the SecList password dictionaries created
 * 	and maintained by the https://github.com/danielmiessler/SecLists
 */
$Dictionaries = array(
	"rockyou-45.txt",
	"rockyou-40.txt",
	"porn-unknown.txt",
	"passwords_youporn2012_raw.txt",
	"passwords_john.txt",
	"john.txt",
	"hak5.txt",
	"carders.cc.txt",
	"best1050.txt",
);

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
	$Dictionary = $Dictionaries;
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
if ($Result = CheckHash($Dictionary, $Options['a'], $Options['h'])) {
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

/*
 *	Check to see if we should store the result after finishing?
 *
 */
if ($UseFileStorage) {

}


