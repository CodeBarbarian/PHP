<?php
/*
 *	@name:		Pixie SMS - API Wrapper
 *	@author: 	Morten Haugstad(CodeBarbarian)
 *	@version:	0.1
 *	
 *	@desc:		A simple API Wrapper for Pixie SMS
 *	
 *	@licence:	CC
 *	
 *
 */

class PixieSMS {
	
	/*
	 *	@name:	Class Construct
	 *	@type:	Object Construct
	 *
	 *	@param:	string (account)
	 * 	@param: string (password)
	 *	@param:	string (sender)
	 *
	 */
	public function __construct($Account, $Passsword, $Sender) {
		$this->Account 	= $Account;
		$this->Password = $Password;
		$this->Sender	= $Sender;
	}
	
	/*
	 *	@name:	Is_MD5
	 *	@type:	Class Method
	 *
	 *	@param:	string (md5)
	 *	
	 *	@return: boolean
	 */
	private function Is_MD5($MD5 = '')
	{
		return preg_match('/^[a-f0-9]{32}$/', $MD5);
	}
	
	/*
	 *	@name:	Send Data
	 *	@type:	Class Method
	 *
	 *	@param:	string (url)
	 *
	 *	@return: string 
	 */
	private function Send_Data($URL) { 

		$Defaults = array( 
			CURLOPT_URL => http_build_query($URL), 
			CURLOPT_HEADER => 0, 
			CURLOPT_RETURNTRANSFER => TRUE, 
			CURLOPT_TIMEOUT => 4 
		); 
    
		$ch = curl_init(); 
		curl_setopt_array($ch, ($Defaults)); 
		if(!$Result = curl_exec($ch)) 
		{ 
			trigger_error(curl_error($ch)); 
		} 
		curl_close($ch); 
		return $Result; 	
	}
	
	/*
	 *	@name:	Build URL
	 *	@type:	Class Method
	 *
	 *	@param:	string (receivers)
	 * 	@param: string (message)
	 *
	 *	@return: string
	 */
	private function Build_URL($Receivers, $Message) {
		if ($this->Is_MD5($this->Password)) {
			$URL = "http://smsserver.pixie.se/sendsms?account={$this->Account}&signature=
			{$this->Password}&receivers={$Receivers}&sender={$this->Sender}&message={$Message}";
		} else {
			$URL = "http://smsserver.pixie.se/sendsms?account={$this->Account}&pwd=
			{$this->Password}&receivers={$Receivers}&sender={$this->Sender}&message={$Message}";
		}
		
		return trim($URL);
	}
	
	/*
	 *	@name:	Send SMS
	 *	@type:	Class Method
	 *
	 *	@param:	string (sender) OPTIONAL
	 * 	@param: array (receivers)
	 *	@param:	string (message)
	 *
	 * 	@return: string
	 */
	public function Send_SMS($Sender = null, $Receivers = array(), $Message) {
		$Data = "";
		foreach($Receivers as $Value) {
			$Data .= $value . ',';
		}
		
		$URL 	= $this->Build_URL($Data, $Message);
		$Result = $this->Send_Data($URL);

		return $Result;
	}
	
	
	/*
	 *	@name:	Retrieve SMS
	 *	@type:	Class Method
	 *
	 * 	@return: Data (Response)
	 */
	public function Retrieve_SMS() {
		if ($this->Is_MD5($this->Password)) {
			$URL = "http://smsserver.pixie.se/getmessages?account={$this->Account}&signature={$this->Password}";
		} else {
			$URL = "http://smsserver.pixie.se/getmessages?account={$this->Account}&pwd={$this->Password}";
		}
		
		$Data = $this->Send_Data($URL);
		return $Data;
	}
}

/*
 *	EXAMPLE
 */
$Pixie = new PixieSMS("ACCOUNT_ID", "PASSWORD_OR_SIGNATURE", "SENDER"); 

