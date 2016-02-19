# ErrorHandler
I saw a picture a couple of days ago, with a try/catch/throw statement, which gave me the idea for this script. 
I created a errorhandler based on the same logic, that if an error occurs it will give you a link to stackoverflow with 
the error string already included. 

How to use
--
	1. Create a file, name it something like errorhandler.php
	2. Copy the 'ErrorHandler' function from index.php
	3. In your script, include the error handler
	4. set_error_handler('ErrorHandler');
	5. Enjoy.
	

	
