<?php
/*
 *	@name:		CSGO Subreddit Parser
 *	@version:	0.0.1
 *	@author:	CodeBarbarian (Morten Haugstad)
 *
 *	@description: A simple script to get spesific URL's from subreddits
 *
 *  @includes; htmlparser
 */


/*
 *	Including the html dom parser
 */
require_once 'htmlparser.php';

/*
 *	Script Configuration
 */
$Site = "https://www.reddit.com/r/globaloffensive";

/*
 *	What kind of markup tag are you looking for?
 */
$SearchTag = "a";

/*
 *	What word are you looking for?
 */
$SearchString = "operation";


/*
 *	Retrieve Content from site
 */
$HTML = file_get_html($Site);

/*
 *	Array as storage
 */
$Data_OuterText = array();


/* 
 *	Append information to array
 */
foreach($HTML->find($SearchTag) as $e)
{
	$Data_OuterText[] 	= $e->outertext; 
}


/*
 *	Search trough each array as string, try to identify {$SearchString}
 */
foreach($Data_OuterText as $Key => $Value) {
	
	if (stristr($Value, $SearchString)) {
		echo $Value . "<br />";
	}
}