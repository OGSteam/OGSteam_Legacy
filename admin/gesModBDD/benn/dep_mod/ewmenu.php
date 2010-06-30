<?php

// Menu
define("EW_MENUBAR_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EW_MENUBAR_SUBMENU_CLASSNAME", "", TRUE);
?>
<?php

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<!-- Begin Main Menu -->
<div class="phpmaker">
<?php

// Generate all menu items
$RootMenu = new cMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, $Language->MenuPhrase("1", "MenuText"), "langlist.php", -1, "", TRUE);
$RootMenu->AddMenuItem(2, $Language->MenuPhrase("2", "MenuText"), "mod_langlist.php", -1, "", TRUE);
$RootMenu->AddMenuItem(3, $Language->MenuPhrase("3", "MenuText"), "mod_versionlist.php", -1, "", TRUE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "modulelist.php", -1, "", TRUE);
$RootMenu->AddMenuItem(5, $Language->MenuPhrase("5", "MenuText"), "ogspy_versionlist.php", -1, "", TRUE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
