<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "mod_versioninfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$mod_version_view = new cmod_version_view();
$Page =& $mod_version_view;

// Page init
$mod_version_view->Page_Init();

// Page main
$mod_version_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mod_version->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mod_version_view = new ew_Page("mod_version_view");

// page properties
mod_version_view.PageID = "view"; // page ID
mod_version_view.FormID = "fmod_versionview"; // form ID
var EW_PAGE_ID = mod_version_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mod_version_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_version_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_version_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_version_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_version->TableCaption() ?>
<br><br>
<?php if ($mod_version->Export == "") { ?>
<a href="<?php echo $mod_version_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_version_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_version_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_version_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_version_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_version_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mod_version->id_mod_version->Visible) { // id_mod_version ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_mod_version->FldCaption() ?></td>
		<td<?php echo $mod_version->id_mod_version->CellAttributes() ?>>
<div<?php echo $mod_version->id_mod_version->ViewAttributes() ?>><?php echo $mod_version->id_mod_version->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_version->id_module->Visible) { // id_module ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_module->FldCaption() ?></td>
		<td<?php echo $mod_version->id_module->CellAttributes() ?>>
<div<?php echo $mod_version->id_module->ViewAttributes() ?>><?php echo $mod_version->id_module->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_version->id_version_min->Visible) { // id_version_min ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_version_min->FldCaption() ?></td>
		<td<?php echo $mod_version->id_version_min->CellAttributes() ?>>
<div<?php echo $mod_version->id_version_min->ViewAttributes() ?>><?php echo $mod_version->id_version_min->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_version->id_version_max->Visible) { // id_version_max ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_version_max->FldCaption() ?></td>
		<td<?php echo $mod_version->id_version_max->CellAttributes() ?>>
<div<?php echo $mod_version->id_version_max->ViewAttributes() ?>><?php echo $mod_version->id_version_max->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_version->version->Visible) { // version ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->version->FldCaption() ?></td>
		<td<?php echo $mod_version->version->CellAttributes() ?>>
<div<?php echo $mod_version->version->ViewAttributes() ?>><?php echo $mod_version->version->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($mod_version->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$mod_version_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_version_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'mod_version';

	// Page object name
	var $PageObjName = 'mod_version_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mod_version;
		if ($mod_version->UseTokenInUrl) $PageUrl .= "t=" . $mod_version->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $mod_version;
		if ($mod_version->UseTokenInUrl) {
			if ($objForm)
				return ($mod_version->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mod_version->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cmod_version_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_version)
		$GLOBALS["mod_version"] = new cmod_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mod_version', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $mod_version;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $mod_version;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_mod_version"] <> "") {
				$mod_version->id_mod_version->setQueryStringValue($_GET["id_mod_version"]);
				$this->arRecKey["id_mod_version"] = $mod_version->id_mod_version->QueryStringValue;
			} else {
				$sReturnUrl = "mod_versionlist.php"; // Return to list
			}

			// Get action
			$mod_version->CurrentAction = "I"; // Display form
			switch ($mod_version->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "mod_versionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "mod_versionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$mod_version->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $mod_version;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mod_version->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mod_version->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mod_version->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mod_version->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mod_version->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mod_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mod_version;
		$sFilter = $mod_version->KeyFilter();

		// Call Row Selecting event
		$mod_version->Row_Selecting($sFilter);

		// Load SQL based on filter
		$mod_version->CurrentFilter = $sFilter;
		$sSql = $mod_version->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$mod_version->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $mod_version;
		$mod_version->id_mod_version->setDbValue($rs->fields('id_mod_version'));
		$mod_version->id_module->setDbValue($rs->fields('id_module'));
		$mod_version->id_version_min->setDbValue($rs->fields('id_version_min'));
		$mod_version->id_version_max->setDbValue($rs->fields('id_version_max'));
		$mod_version->version->setDbValue($rs->fields('version'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $mod_version;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id_mod_version=" . urlencode($mod_version->id_mod_version->CurrentValue);
		$this->AddUrl = $mod_version->AddUrl();
		$this->EditUrl = $mod_version->EditUrl();
		$this->CopyUrl = $mod_version->CopyUrl();
		$this->DeleteUrl = $mod_version->DeleteUrl();
		$this->ListUrl = $mod_version->ListUrl();

		// Call Row_Rendering event
		$mod_version->Row_Rendering();

		// Common render codes for all row types
		// id_mod_version

		$mod_version->id_mod_version->CellCssStyle = ""; $mod_version->id_mod_version->CellCssClass = "";
		$mod_version->id_mod_version->CellAttrs = array(); $mod_version->id_mod_version->ViewAttrs = array(); $mod_version->id_mod_version->EditAttrs = array();

		// id_module
		$mod_version->id_module->CellCssStyle = ""; $mod_version->id_module->CellCssClass = "";
		$mod_version->id_module->CellAttrs = array(); $mod_version->id_module->ViewAttrs = array(); $mod_version->id_module->EditAttrs = array();

		// id_version_min
		$mod_version->id_version_min->CellCssStyle = ""; $mod_version->id_version_min->CellCssClass = "";
		$mod_version->id_version_min->CellAttrs = array(); $mod_version->id_version_min->ViewAttrs = array(); $mod_version->id_version_min->EditAttrs = array();

		// id_version_max
		$mod_version->id_version_max->CellCssStyle = ""; $mod_version->id_version_max->CellCssClass = "";
		$mod_version->id_version_max->CellAttrs = array(); $mod_version->id_version_max->ViewAttrs = array(); $mod_version->id_version_max->EditAttrs = array();

		// version
		$mod_version->version->CellCssStyle = ""; $mod_version->version->CellCssClass = "";
		$mod_version->version->CellAttrs = array(); $mod_version->version->ViewAttrs = array(); $mod_version->version->EditAttrs = array();
		if ($mod_version->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_mod_version
			$mod_version->id_mod_version->ViewValue = $mod_version->id_mod_version->CurrentValue;
			$mod_version->id_mod_version->CssStyle = "";
			$mod_version->id_mod_version->CssClass = "";
			$mod_version->id_mod_version->ViewCustomAttributes = "";

			// id_module
			if (strval($mod_version->id_module->CurrentValue) <> "") {
				$sFilterWrk = "`id_module` = " . ew_AdjustSql($mod_version->id_module->CurrentValue) . "";
			$sSqlWrk = "SELECT DISTINCT `root_module` FROM `module`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `root_module` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_version->id_module->ViewValue = $rswrk->fields('root_module');
					$rswrk->Close();
				} else {
					$mod_version->id_module->ViewValue = $mod_version->id_module->CurrentValue;
				}
			} else {
				$mod_version->id_module->ViewValue = NULL;
			}
			$mod_version->id_module->CssStyle = "";
			$mod_version->id_module->CssClass = "";
			$mod_version->id_module->ViewCustomAttributes = "";

			// id_version_min
			if (strval($mod_version->id_version_min->CurrentValue) <> "") {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_min->CurrentValue) . "";
			$sSqlWrk = "SELECT `version`, `status` FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `version` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_version->id_version_min->ViewValue = $rswrk->fields('version');
					$mod_version->id_version_min->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('status');
					$rswrk->Close();
				} else {
					$mod_version->id_version_min->ViewValue = $mod_version->id_version_min->CurrentValue;
				}
			} else {
				$mod_version->id_version_min->ViewValue = NULL;
			}
			$mod_version->id_version_min->CssStyle = "";
			$mod_version->id_version_min->CssClass = "";
			$mod_version->id_version_min->ViewCustomAttributes = "";

			// id_version_max
			if (strval($mod_version->id_version_max->CurrentValue) <> "") {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_max->CurrentValue) . "";
			$sSqlWrk = "SELECT `version`, `status` FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `version` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_version->id_version_max->ViewValue = $rswrk->fields('version');
					$mod_version->id_version_max->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('status');
					$rswrk->Close();
				} else {
					$mod_version->id_version_max->ViewValue = $mod_version->id_version_max->CurrentValue;
				}
			} else {
				$mod_version->id_version_max->ViewValue = NULL;
			}
			$mod_version->id_version_max->CssStyle = "";
			$mod_version->id_version_max->CssClass = "";
			$mod_version->id_version_max->ViewCustomAttributes = "";

			// version
			$mod_version->version->ViewValue = $mod_version->version->CurrentValue;
			$mod_version->version->CssStyle = "";
			$mod_version->version->CssClass = "";
			$mod_version->version->ViewCustomAttributes = "";

			// id_mod_version
			$mod_version->id_mod_version->HrefValue = "";
			$mod_version->id_mod_version->TooltipValue = "";

			// id_module
			$mod_version->id_module->HrefValue = "";
			$mod_version->id_module->TooltipValue = "";

			// id_version_min
			$mod_version->id_version_min->HrefValue = "";
			$mod_version->id_version_min->TooltipValue = "";

			// id_version_max
			$mod_version->id_version_max->HrefValue = "";
			$mod_version->id_version_max->TooltipValue = "";

			// version
			$mod_version->version->HrefValue = "";
			$mod_version->version->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($mod_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$mod_version->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}
}
?>
