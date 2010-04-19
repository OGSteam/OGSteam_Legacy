<?php
/***************************************************************************
*	filename	: install.php en
*	generated	: on 01/14/2009 at 20:55:34
*	created by	: capi
***************************************************************************/
/* index.php */
$lang['welcome'] = "Welcome to the OGSpy's project.";
$lang['description-0'] = 'OGSpy is a CMS base on a database of OGame stuff.';
$lang['description-1'] = 'Having such a tool give lots of advantage to an ally or a group';
$lang['description-2'] = 'Census coordinates all free, according to several criteria (galaxy, solar system and rank).';
$lang['description-3'] = 'Extensions possibilities are almost unlimited with the mods.';
$lang['description-4'] = 'Etc. ';
$lang['moreinfo'] = 'If you\'d like further informations, please visit us on our forum:';
$lang['chooseaction'] = 'Choose the action you want to perform:';
$lang['fullinstall'] = 'New installation';
$lang['update'] = 'Upgrade';

/* install.php */
$lang['writable'] = 'Writable';
$lang['unwritable'] = 'Unable to write';
$lang['installimpossible'] = 'Unable to install :';
$lang['allowwrite'] = 'You need to autorise this folders to continue the installation :';

$lang['sqlerror'] = 'An error has comming during the installation of OGSpy';
$lang['installfail'] = 'Installation failed. Creation of the file \'parameters/id.php\' failed.';
$lang['installsuccess'] = 'The installation of your OGSpy Server %s was successfully completed.';
$lang['deleteinstall'] = 'Think to delete the folder \'install\'';

$lang['badcharacterstableprefix'] = 'The used caracters for the database prefix are incorrect.';
$lang['badcharacterslogin'] = 'The used caracters for the username or the password are incorrect.';
$lang['baduniconfig'] = 'You doesn\'t have enter correct values for the galaxy number and/or the solar system.';
$lang['badsqlconfig'] = 'Enter fields correctly connection to the database.';

$lang['installwelcome'] = 'Installation of OGSpy version %s - Welcome!';
$lang['updatewelcome'] = 'Update OGSpy to version %s - Welcome!';
$lang['dbconfigtitle'] = 'Database configuration';
$lang['dbhostname'] = 'Hostname of your database';
$lang['dbname'] = 'Name of your database';
$lang['dbusername'] = 'Username';
$lang['dbpassword'] = 'Password';
$lang['dbtableprefix'] = 'Table prefix';
$lang['uniconfigtitle'] = 'Universe configuration';
$lang['numgalaxies'] = 'Galaxy count';
$lang['numsystems'] = 'System count per galaxy';
$lang['adminconfigtitle'] = 'Configuration of the administrator\'s account';
$lang['adminloginname'] = 'Username';
$lang['adminpassword'] = 'Password';
$lang['adminpasswordconfirm'] = 'Password [Confirmation]';
$lang['serverlanguage'] = 'Server language';
$lang['parsinglanguage'] = 'Game language';
$lang['needhelp'] = 'Do you need assistance?';
$lang['cantconnect'] = 'Connection to database failed.';
$lang['noinstallscript'] = 'The SQL installscript could not be found.';

/* upgrade_to_latest.php */
$lang['updatetitle'] = 'Update OGSpy';
$lang['noupdateavailable'] = 'Your OGSpy is up to date.';
$lang['updatesuccess'] = 'Updating your OGSpy server to version %s was completed successfully.';
$lang['sqlupdated'] = 'The script has only modified your database. Please remember to also update your files.';
$lang['notuptodate'] = 'This version is not up to date. Please run the script again.';
$lang['newupdate'] = 'Resume operation';

// Added
$lang['controltitle'] = 'Control of pre-requisites';
$lang['SQLConnect_Success'] = 'Connecting to the database successfully. ';
$lang['Passwords_NotMatch'] = 'Passwords do not match ';
$lang['Version_Php_Error'] = 'The version of PHP (%1$s) is not compatible (minimum version required %1$s) ';
$lang['Param_chmod_Error'] = 'Folder /parameters/ is not writable ';
$lang['Log_chmod_Error'] = 'Folder /journal/ is not writable ';
$lang['Mod_chmod_Error'] = 'Folder /mod/ is not writable ';
$lang['ConfigControl_Success'] = 'Everything is in order to install OGSpy ';
$lang['ConfigControl_Fail'] = '<span style="color: #ff0000; font-size:14px;">You can&apos;t continue installing OGSpy until you have corrected errors</span>';
$lang['Parameter_Access'] = 'Access to the folder /parameters/';
$lang['Journal_Access'] = 'Access to the folder /journal/';
$lang['Mod_Access'] = 'Access to the folder /mod/';
$lang['Enter_SQL_Access'] = 'Enter the parameters of the SQL Server ';
$lang['Enter_Admin_Access'] = 'Enter the account information Admin ';
$lang['OGSpy_1st_Config'] = 'configuration OGSpy ';
$lang['servername'] = 'Name Server ';
$lang['Cartography'] = 'Mapping ';
$lang['speeduni'] = 'Speed of the Universe ';
$lang['ddr'] = 'Depot of Supplies ';
$lang['Unable_Open_Mod'] = 'Unable to open the folder mods ';
$lang['Mod_Name'] = 'Module Installation ';
$lang['Install_Button'] = 'Installing';
$lang['Thanks_For_Having_Installed_OGSpy'] = 'Thanks for installing OGSpy! ';

$lang['end_install_notes'] = 'Now that your OGSpy is configured for its basic configuration, its modules or admin account, you can now complete the installation of the server to begin to benefit immediately.<br /><br />However, if you are unsure about your settings, it is still time to use the back button to return to the stage in question.<br /><br />Once the installation is validated, it will not be possible to revert the edit facility.';
$lang['end_install_notes2'] = 'Your OGSpy is now operational !<br /><br />You must delete the /install/ folder of your OGSpy to be able to login';
$lang['end_install_button'] = 'Finish your installation';

$lang['Install_Modules_Inclued'] = 'Installation of modules provided ';
$lang['Return_to_OGSpy'] = 'Connect to OGSpy ';
$lang['PHP_Version'] = 'PHP version:% s ';
$lang['Already_Installed'] = 'Installation OK';
$lang['Installed_OutDate'] = 'Install&eacute; mais version d&eacute;pass&eacute;e';
$lang['SQL_Version_Error'] = 'The version of your SQL server (%1$s) is too old: version required (%2$s)';
$lang['Admin_Create_Success'] = 'The admin has been created successfully ';
$lang['SQL_Installation_Success'] = 'The database has been successfully configured ';
$lang['Wrong_DB_Name'] = 'The name of the database is not valid';

$lang['select_all'] = 'All';
$lang['unselect_all'] = 'None';
$lang['reverse_all'] = 'Reverse';
?>
