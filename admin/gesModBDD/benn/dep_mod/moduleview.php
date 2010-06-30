<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "moduleinfo.php" ?>
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
$module_view = new cmodule_view();
$Page =& $module_view;

// Page init
$module_view->Page_Init();

// Page main
$module_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($module->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var module_view = new ew_Page("module_view");

// page properties
module_view.PageID = "view"; // page ID
module_view.FormID = "fmoduleview"; // form ID
var EW_PAGE_ID = module_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
module_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
module_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
module_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
module_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $module->TableCaption() ?>
<br><br>
<?php if ($module->Export == "") { ?>
<a href="<?php echo $module_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $module_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $module_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $module_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $module_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$module_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($module->id_module->Visible) { // id_module ?>
	<tr<?php echo $module->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $module->id_module->FldCaption() ?></td>
		<td<?php echo $module->id_module->CellAttributes() ?>>
<div<?php echo $module->id_module->ViewAttributes() ?>><?php echo $module->id_module->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($module->root_module->Visible) { // root_module ?>
	<tr<?php echo $module->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $module->root_module->FldCaption() ?></td>
		<td<?php echo $module->root_module->CellAttributes() ?>>
<div<?php echo $module->root_module->ViewAttributes() ?>><?php echo $module->root_module->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($module->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$module_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cmodule_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'module';

	// Page object name
	var $PageObjName = 'module_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $module;
		if ($module->UseTokenInUrl) $PageUrl .= "t=" . $module->TableVar . "&"; // Add page token
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
		global $objForm, $module;
		if ($module->UseTokenInUrl) {
			if ($objForm)
				return ($module->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($module->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cmodule_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (module)
		$GLOBALS["module"] = new cmodule();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'module', TRUE);

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
		global $module;

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
		global $Language, $module;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_module"] <> "") {
				$module->id_module->setQueryStringValue($_GET["id_module"]);
				$this->arRecKey["id_module"] = $module->id_module->QueryStringValue;
			} else {
				$sReturnUrl = "modulelist.php"; // Return to list
			}

			// Get action
			$module->CurrentAction = "I"; // Display form
			switch ($module->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "modulelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "modulelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$module->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $module;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$module->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$module->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $module->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$module->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$module->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$module->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $module;
		$sFilter = $module->KeyFilter();

		// Call Row Selecting event
		$module->Row_Selecting($sFilter);

		// Load SQL based on filter
		$module->CurrentFilter = $sFilter;
		$sSql = $module->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$module->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $module;
		$module->id_module->setDbValue($rs->fields('id_module'));
		$module->root_module->setDbValue($rs->fields('root_module'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $module;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id_module=" . urlencode($module->id_module->CurrentValue);
		$this->AddUrl = $module->AddUrl();
		$this->EditUrl = $module->EditUrl();
		$this->CopyUrl = $module->CopyUrl();
		$this->DeleteUrl = $module->DeleteUrl();
		$this->ListUrl = $module->ListUrl();

		// Call Row_Rendering event
		$module->Row_Rendering();

		// Common render codes for all row types
		// id_module

		$module->id_module->CellCssStyle = ""; $module->id_module->CellCssClass = "";
		$module->id_module->CellAttrs = array(); $module->id_module->ViewAttrs = array(); $module->id_module->EditAttrs = array();

		// root_module
		$module->root_module->CellCssStyle = ""; $module->root_module->CellCssClass = "";
		$module->root_module->CellAttrs = array(); $module->root_module->ViewAttrs = array(); $module->root_module->EditAttrs = array();
		if ($module->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_module
			$module->id_module->ViewValue = $module->id_module->CurrentValue;
			$module->id_module->CssStyle = "";
			$module->id_module->CssClass = "";
			$module->id_module->ViewCustomAttributes = "";

			// root_module
			$module->root_module->ViewValue = $module->root_module->CurrentValue;
			$module->root_module->CssStyle = "";
			$module->root_module->CssClass = "";
			$module->root_module->ViewCustomAttributes = "";

			// id_module
			$module->id_module->HrefValue = "";
			$module->id_module->TooltipValue = "";

			// root_module
			$module->root_module->HrefValue = "";
			$module->root_module->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($module->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$module->Row_Rendered();
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
