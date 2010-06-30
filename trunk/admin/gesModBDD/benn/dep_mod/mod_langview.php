<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "mod_langinfo.php" ?>
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
$mod_lang_view = new cmod_lang_view();
$Page =& $mod_lang_view;

// Page init
$mod_lang_view->Page_Init();

// Page main
$mod_lang_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mod_lang->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mod_lang_view = new ew_Page("mod_lang_view");

// page properties
mod_lang_view.PageID = "view"; // page ID
mod_lang_view.FormID = "fmod_langview"; // form ID
var EW_PAGE_ID = mod_lang_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mod_lang_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_lang_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_lang_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_lang_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_lang->TableCaption() ?>
<br><br>
<?php if ($mod_lang->Export == "") { ?>
<a href="<?php echo $mod_lang_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_lang_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_lang_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_lang_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_lang_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_lang_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mod_lang->id_module->Visible) { // id_module ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_module->FldCaption() ?></td>
		<td<?php echo $mod_lang->id_module->CellAttributes() ?>>
<div<?php echo $mod_lang->id_module->ViewAttributes() ?>><?php echo $mod_lang->id_module->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_lang->FldCaption() ?></td>
		<td<?php echo $mod_lang->id_lang->CellAttributes() ?>>
<div<?php echo $mod_lang->id_lang->ViewAttributes() ?>><?php echo $mod_lang->id_lang->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->mod_name->Visible) { // mod_name ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->mod_name->FldCaption() ?></td>
		<td<?php echo $mod_lang->mod_name->CellAttributes() ?>>
<div<?php echo $mod_lang->mod_name->ViewAttributes() ?>><?php echo $mod_lang->mod_name->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->mod_description->Visible) { // mod_description ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->mod_description->FldCaption() ?></td>
		<td<?php echo $mod_lang->mod_description->CellAttributes() ?>>
<div<?php echo $mod_lang->mod_description->ViewAttributes() ?>><?php echo $mod_lang->mod_description->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($mod_lang->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$mod_lang_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_lang_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'mod_lang';

	// Page object name
	var $PageObjName = 'mod_lang_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $mod_lang;
		if ($mod_lang->UseTokenInUrl) $PageUrl .= "t=" . $mod_lang->TableVar . "&"; // Add page token
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
		global $objForm, $mod_lang;
		if ($mod_lang->UseTokenInUrl) {
			if ($objForm)
				return ($mod_lang->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($mod_lang->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cmod_lang_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_lang)
		$GLOBALS["mod_lang"] = new cmod_lang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mod_lang', TRUE);

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
		global $mod_lang;

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
		global $Language, $mod_lang;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_module"] <> "") {
				$mod_lang->id_module->setQueryStringValue($_GET["id_module"]);
				$this->arRecKey["id_module"] = $mod_lang->id_module->QueryStringValue;
			} else {
				$sReturnUrl = "mod_langlist.php"; // Return to list
			}
			if (@$_GET["id_lang"] <> "") {
				$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
				$this->arRecKey["id_lang"] = $mod_lang->id_lang->QueryStringValue;
			} else {
				$sReturnUrl = "mod_langlist.php"; // Return to list
			}

			// Get action
			$mod_lang->CurrentAction = "I"; // Display form
			switch ($mod_lang->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "mod_langlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "mod_langlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$mod_lang->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $mod_lang;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mod_lang->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mod_lang->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mod_lang->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mod_lang->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mod_lang->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mod_lang->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $mod_lang;
		$sFilter = $mod_lang->KeyFilter();

		// Call Row Selecting event
		$mod_lang->Row_Selecting($sFilter);

		// Load SQL based on filter
		$mod_lang->CurrentFilter = $sFilter;
		$sSql = $mod_lang->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$mod_lang->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $mod_lang;
		$mod_lang->id_module->setDbValue($rs->fields('id_module'));
		$mod_lang->id_lang->setDbValue($rs->fields('id_lang'));
		$mod_lang->mod_name->setDbValue($rs->fields('mod_name'));
		$mod_lang->mod_description->setDbValue($rs->fields('mod_description'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $mod_lang;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id_module=" . urlencode($mod_lang->id_module->CurrentValue) . "&id_lang=" . urlencode($mod_lang->id_lang->CurrentValue);
		$this->AddUrl = $mod_lang->AddUrl();
		$this->EditUrl = $mod_lang->EditUrl();
		$this->CopyUrl = $mod_lang->CopyUrl();
		$this->DeleteUrl = $mod_lang->DeleteUrl();
		$this->ListUrl = $mod_lang->ListUrl();

		// Call Row_Rendering event
		$mod_lang->Row_Rendering();

		// Common render codes for all row types
		// id_module

		$mod_lang->id_module->CellCssStyle = ""; $mod_lang->id_module->CellCssClass = "";
		$mod_lang->id_module->CellAttrs = array(); $mod_lang->id_module->ViewAttrs = array(); $mod_lang->id_module->EditAttrs = array();

		// id_lang
		$mod_lang->id_lang->CellCssStyle = ""; $mod_lang->id_lang->CellCssClass = "";
		$mod_lang->id_lang->CellAttrs = array(); $mod_lang->id_lang->ViewAttrs = array(); $mod_lang->id_lang->EditAttrs = array();

		// mod_name
		$mod_lang->mod_name->CellCssStyle = ""; $mod_lang->mod_name->CellCssClass = "";
		$mod_lang->mod_name->CellAttrs = array(); $mod_lang->mod_name->ViewAttrs = array(); $mod_lang->mod_name->EditAttrs = array();

		// mod_description
		$mod_lang->mod_description->CellCssStyle = ""; $mod_lang->mod_description->CellCssClass = "";
		$mod_lang->mod_description->CellAttrs = array(); $mod_lang->mod_description->ViewAttrs = array(); $mod_lang->mod_description->EditAttrs = array();
		if ($mod_lang->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_module
			if (strval($mod_lang->id_module->CurrentValue) <> "") {
				$sFilterWrk = "`id_module` = " . ew_AdjustSql($mod_lang->id_module->CurrentValue) . "";
			$sSqlWrk = "SELECT DISTINCT `root_module` FROM `module`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_lang->id_module->ViewValue = $rswrk->fields('root_module');
					$rswrk->Close();
				} else {
					$mod_lang->id_module->ViewValue = $mod_lang->id_module->CurrentValue;
				}
			} else {
				$mod_lang->id_module->ViewValue = NULL;
			}
			$mod_lang->id_module->CssStyle = "";
			$mod_lang->id_module->CssClass = "";
			$mod_lang->id_module->ViewCustomAttributes = "";

			// id_lang
			if (strval($mod_lang->id_lang->CurrentValue) <> "") {
				$sFilterWrk = "`id_lang` = " . ew_AdjustSql($mod_lang->id_lang->CurrentValue) . "";
			$sSqlWrk = "SELECT `country` FROM `lang`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id_lang`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_lang->id_lang->ViewValue = $rswrk->fields('country');
					$rswrk->Close();
				} else {
					$mod_lang->id_lang->ViewValue = $mod_lang->id_lang->CurrentValue;
				}
			} else {
				$mod_lang->id_lang->ViewValue = NULL;
			}
			$mod_lang->id_lang->CssStyle = "";
			$mod_lang->id_lang->CssClass = "";
			$mod_lang->id_lang->ViewCustomAttributes = "";

			// mod_name
			$mod_lang->mod_name->ViewValue = $mod_lang->mod_name->CurrentValue;
			$mod_lang->mod_name->CssStyle = "";
			$mod_lang->mod_name->CssClass = "";
			$mod_lang->mod_name->ViewCustomAttributes = "";

			// mod_description
			$mod_lang->mod_description->ViewValue = $mod_lang->mod_description->CurrentValue;
			$mod_lang->mod_description->CssStyle = "";
			$mod_lang->mod_description->CssClass = "";
			$mod_lang->mod_description->ViewCustomAttributes = "";

			// id_module
			$mod_lang->id_module->HrefValue = "";
			$mod_lang->id_module->TooltipValue = "";

			// id_lang
			$mod_lang->id_lang->HrefValue = "";
			$mod_lang->id_lang->TooltipValue = "";

			// mod_name
			$mod_lang->mod_name->HrefValue = "";
			$mod_lang->mod_name->TooltipValue = "";

			// mod_description
			$mod_lang->mod_description->HrefValue = "";
			$mod_lang->mod_description->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($mod_lang->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$mod_lang->Row_Rendered();
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
