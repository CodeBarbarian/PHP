# Hash Comparison

A simple hash comparison with password dictionaries

USE
--
	* php index.php -a [HASH_ALGO] -h [HASH] 
		* OPTIONAL --dict="[PASSWORD_DICTIONARY]" -- Will use default, if this is not set
		* OPTIONAL --file="[FILE_TO_STORE_REPORTS]" -- NOT IMPLEMENTED YET.
		
TODO
--

	* Add function to be able to store reports.
	* Add support for salted password, if the salt is known.
	* Use the entire SecList password dictionaries.

Check Out
--
Please check out these awesome people over at https://github.com/danielmiessler/SecLists