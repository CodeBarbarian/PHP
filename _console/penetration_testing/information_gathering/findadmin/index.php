<?php
/*
 * 	@name:		Find Admin
 *	@version:	0.1
 * 	@author:	Morten Haugstad (CodeBarbarian)
 *
 *	@status:	Working (Prototype)
 *	@desc:		Searches on a specific site for typical login portals
 *
 *	@licence:	CC
 *	@use:		php index.php [TARGET_FULL_URL]
 *------------------------------------------------------------------------+
 * This script is used solely for informative, educational        		  |
 * purposes only. Author cannot be held responsible for any               |
 * damage and (or) (ab)use of this script.                                |
 *------------------------------------------------------------------------+
 */

// CLI Check
if (php_sapi_name() != 'cli') {
	exit("Must be run trough Command Line Interface! Exiting...");
}
 
// Error Reporting
error_reporting(0);

// Time limit
set_time_limit(0);

// The List
$Queries = array(
	"admin1.php",
	"admin1.html",
	"admin2.php",
	"admin2.html",
	"administrator/",
	"administrator/index.html",
	"administrator/index.php",
	"administrator/login.html",
	"administrator/login.php",
	"administrator/account.html",
	"administrator/account.php",
	"administrator.php",
	"administrator.html",
	"admin/",
	"admin/account.php",
	"admin/account.html",
	"admin/index.php",
	"admin/index.html",
	"admin/login.php",
	"admin/login.html",
	"admin/home.php",
	"admin/controlpanel.html",
	"admin/controlpanel.php",
	"admin.php",
	"admin.html",
	"admin/cp.php",
	"admin/cp.html",
	"adm/",
	"account.php",
	"account.html",
	"admincontrol.php",
	"admincontrol.html",
	"adminpanel.php",
	"adminpanel.html",
	"admin1.asp",
	"admin2.asp",
	"admin/account.asp",
	"admin/index.asp",
	"admin/login.asp",
	"admin/home.asp",
	"admin/controlpanel.asp",
	"admin.asp",
	"admin/cp.asp",
	"administr8.php",
	"administr8.html",
	"administr8/",
	"administr8.asp",
	"yonetim.php",
	"yonetim.html",
	"yonetici.php",
	"yonetici.html",
	"maintenance/",
	"webmaster/",
	"configuration/",
	"configure/",
	"cp.php",
	"cp.html",
	"controlpanel/",
	"controlpanel.php",
	"controlpanel.html",
	"ccms/",
	"ccms/login.php",
	"ccms/index.php",
	"login.php",
	"login.html",
	"modelsearch/login.php",
	"moderator.php",
	"moderator.html",
	"moderator/login.php",
	"moderator/login.html",
	"moderator/admin.php",
	"moderator/admin.html",
	"moderator/",
	"yonetim.asp",
	"yonetici.asp",
	"cp.asp",
	"administrator/index.asp",
	"administrator/login.asp",
	"administrator/account.asp",
	"administrator.asp",
	"login.asp",
	"modelsearch/login.asp",
	"moderator.asp",
	"moderator/login.asp",
	"moderator/admin.asp",
	"account.asp",
	"controlpanel.asp",
	"admincontrol.asp",
	"adminpanel.asp",
	"fileadmin/",
	"fileadmin.php",
	"fileadmin.asp",
	"fileadmin.html",
	"administration/",
	"administration.php",
	"administration.html",
	"sysadmin.php",
	"sysadmin.html",
	"phpmyadmin/",
	"myadmin/",
	"sysadmin.asp",
	"sysadmin/",
	"ur-admin.asp",
	"ur-admin.php",
	"ur-admin.html",
	"ur-admin/",
	"Server.php",
	"Server.html",
	"Server.asp",
	"Server/",
	"webadmin/",
	"webadmin.php",
	"webadmin.asp",
	"webadmin.html",
	"administratie/",
	"admins/",
	"admins.php",
	"admins.asp",
	"admins.html",
	"administrivia/",
	"Database_Administration/",
	"WebAdmin/",
	"useradmin/",
	"sysadmins/",
	"admin1/",
	"system-administration/",
	"administrators/",
	"pgadmin/",
	"directadmin/",
	"staradmin/",
	"ServerAdministrator/",
	"SysAdmin/",
	"administer/",
	"LiveUser_Admin/",
	"sys-admin/",
	"typo3/",
	"panel/",
	"cpanel/",
	"cPanel/",
	"cpanel_file/",
	"platz_login/",
	"rcLogin/",
	"blogindex/",
	"formslogin/",
	"autologin/",
	"support_login/",
	"meta_login/",
	"manuallogin/",
	"simpleLogin/",
	"loginflat/",
	"utility_login/",
	"showlogin/",
	"memlogin/",
	"members/",
	"login-redirect/",
	"sub-login/",
	"wp-login/",
	"wp-admin/",
	"blog/wp-admin/",
	"blog/wp-login/",
	"forum/admin/",
	"login1/",
	"dir-login/",
	"login_db/",
	"xlogin/",
	"smblogin/",
	"customer_login/",
	"UserLogin/",
	"login-us/",
	"acct_login/",
	"admin_area/",
	"bigadmin/",
	"project-admins/",
	"phppgadmin/",
	"pureadmin/",
	"sql-admin/",
	"radmind/",
	"openvpnadmin/",
	"wizmysqladmin/",
	"vadmind/",
	"ezsqliteadmin/",
	"hpwebjetadmin/",
	"newsadmin/",
	"adminpro/",
	"Lotus_Domino_Admin/",
	"bbadmin/",
	"vmailadmin/",
	"Indy_admin/",
	"ccp14admin/",
	"irc-macadmin/",
	"banneradmin/",
	"sshadmin/",
	"phpldapadmin/",
	"macadmin/",
	"administratoraccounts/",
	"admin4_account/",
	"admin4_colon/",
	"radmind-1/",
	"Super-Admin/",
	"AdminTools/",
	"cmsadmin/",
	"SysAdmin2/",
	"globes_admin/",
	"cadmins/",
	"phpSQLiteAdmin/",
	"navSiteAdmin/",
	"server_admin_small/",
	"logo_sysadmin/",
	"server/",
	"database_administration/",
	"power_user/",
	"system_administration/",
	"ss_vms_admin_sm/",
	"websvn/"
);

/*
 *	FUNCTIONS
 */
function Greetings() {
	$Greeting = '
"."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."
Welcome to Find Admin, a simple yet useful tool for finding 
login portals on a given site. 

Developed by CodeBarbarian for educational purposes only.
twitter @codebarbarian
github @codebarbarian

Good luck, and happy hunting! 
"."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."."
';
	return $Greeting;
}

function CheckHeaders($URL) {
	$Check = get_headers($URL, 1);
	if (empty($Check)) {
	print_r('
	No response on Target URL.
    Exiting...
-----------------------------------------------------------------------------'); 
	exit;
	} 
	return $Check;
}

/*
 *	Greeting and check for arguments
 */
echo Greetings();

if (empty($argv[1])) {
	exit("No URL is specified. Exiting...");
}

// Grab the URL from the input parameter
$URL = $argv[1];

echo "\r\nChecking " . $URL . "...\r\n";

// Check the server headers
if ($Check = CheckHeaders($URL)) {
	$ServerInfo = $Check['Server'];
	
	if (preg_match('/301/', $Check[0]) || preg_match('/302/', $Check[0]) ) {
		$URL 		= $Check['Location'];
		$ServerInfo = $Check['Server'][0];
	}

}

$Info = '
-----------------------------------------------------------------------------
    Target : ' . $URL . '
    Status : ' . $Check[0] . '
    Server : ' . $ServerInfo . '
    Start Scan : ' . date("Y-m-d H:i:s") . '
-----------------------------------------------------------------------------
';
print_r($Info);

$Result = array();

foreach ($Queries as $Query){
	$Headers = get_headers($URL . $Query, 1);
	
	if (preg_match('/200/', $Headers[0])) {
		$Result[] = "[+] " . $URL . $Query . " Found!\r\n";
		echo end($Result);
	}
	elseif (preg_match('/301/', $Headers[0]) || preg_match('/302/', $Headers[0]) ) {
		$Result[] = "[+] " . $URL . $Query . " Found! Redirects to -> " . $Headers['Location'] . "\r\n";
		echo end($Result);
	}
	else {
		echo "[-] " . $URL . $Query . " NOT Found!\r\n";
	}
}

echo "====================================================================================\r\n";
echo "====================================REPORT BEGIN====================================\r\n"; 
echo "====================================================================================\r\n";
print_r($Info);

if (!empty($Result)) {
	echo "Found the following login locations: " . "\r\n";
	foreach($Result as $Value) {
		echo $Value;
	} 
}

echo "\r\n";
echo "====================================================================================\r\n";
echo "=====================================REPORT END=====================================\r\n"; 
echo "====================================================================================\r\n";
