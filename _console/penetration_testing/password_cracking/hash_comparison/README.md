# Hash Comparison

A simple hash comparison with password dictionaries

Information
--
Remember to set the "date_default_timezone_set" to your timezone, to get the date/time correct.


USE
--
	* php index.php -a [HASH_ALGO] -h [HASH] 
		* OPTIONAL --dict="[PASSWORD_DICTIONARY]"
		* OPTIONAL --file="[FILE_TO_STORE_REPORTS]"

If the --dict option is not set, it will load the dictionaries from the dictionaries/ folder 
and run trough them. Size does matter, and so it will begin with the smallest file size and move on from there. 
		
TODO
--
	* Be able to load password hashes from file(s)
	
Check Out
--
Please check out these awesome people over at https://github.com/danielmiessler/SecLists