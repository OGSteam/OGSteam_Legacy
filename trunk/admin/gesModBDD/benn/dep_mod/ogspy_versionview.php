<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "ogspy_versioninfo.php" ?>
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
$ogspy_version_view = new cogspy_version_view();
$Page =& $ogspy_version_view;

// Page init
$ogspy_version_view->Page_Init();

// Page main
$ogspy_version_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ogspy_version->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ogspy_version_view = new ew_Page("ogspy_version_view");

// page properties
ogspy_version_view.PageID = "view"; // page ID
ogspy_version_view.FormID = "fogspy_versionview"; // form ID
var EW_PAGE_ID = ogspy_version_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ogspy_version_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ogspy_version_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ogspy_version_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ogspy_version_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ogspy_version->TableCaption() ?>
<br><br>
<?php if ($ogspy_version->Export == "") { ?>
<a href="<?php echo $ogspy_version_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ogspy_version_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ogspy_version_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ogspy_version_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $ogspy_version_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$ogspy_version_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ogspy_version->id_ogspy_version->Visible) { // id_ogspy_version ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->id_ogspy_version->FldCaption() ?></td>
		<td<?php echo $ogspy_version->id_ogspy_version->CellAttributes() ?>>
<div<?php echo $ogspy_version->id_ogspy_version->ViewAttributes() ?>><?php echo $ogspy_version->id_ogspy_version->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->version->Visible) { // version ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->version->FldCaption() ?></td>
		<td<?php echo $ogspy_version->version->CellAttributes() ?>>
<div<?php echo $ogspy_version->version->ViewAttributes() ?>><?php echo $ogspy_version->version->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->status->Visible) { // status ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->status->FldCaption() ?></td>
		<td<?php echo $ogspy_version->status->CellAttributes() ?>>
<div<?php echo $ogspy_version->status->ViewAttributes() ?>><?php echo $ogspy_version->status->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($ogspy_version->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ogspy_version_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cogspy_version_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'ogspy_version';

	// Page object name
	var $PageObjName = 'ogspy_version_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $ogspy_version;
		if ($ogspy_version->UseTokenInUrl) $PageUrl .= "t=" . $ogspy_version->TableVar . "&"; // Add page token
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
		global $objForm, $ogspy_version;
		if ($ogspy_version->UseTokenInUrl) {
			if ($objForm)
				return ($ogspy_version->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($ogspy_version->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cogspy_version_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (ogspy_version)
		$GLOBALS["ogspy_version"] = new cogspy_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ogspy_version', TRUE);

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
		global $ogspy_version;

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
		global $Language, $ogspy_version;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_ogspy_version"] <> "") {
				$ogspy_version->id_ogspy_version->setQueryStringValue($_GET["id_ogspy_version"]);
				$this->arRecKey["id_ogspy_version"] = $ogspy_version->id_ogspy_version->QueryStringValue;
			} else {
				$sReturnUrl = "ogspy_versionlist.php"; // Return to list
			}

			// Get action
			$ogspy_version->CurrentAction = "I"; // Display form
			switch ($ogspy_version->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ogspy_versionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ogspy_versionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$ogspy_version->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $ogspy_version;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ogspy_version->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ogspy_version->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ogspy_version->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $ogspy_version;
		$sFilter = $ogspy_version->KeyFilter();

		// Call Row Selecting event
		$ogspy_version->Row_Selecting($sFilter);

		// Load SQL based on filter
		$ogspy_version->CurrentFilter = $sFilter;
		$sSql = $ogspy_version->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$ogspy_version->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $ogspy_version;
		$ogspy_version->id_ogspy_version->setDbValue($rs->fields('id_ogspy_version'));
		$ogspy_version->version->setDbValue($rs->fields('version'));
		$ogspy_version->status->setDbValue($rs->fields('status'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $ogspy_version;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id_ogspy_version=" . urlencode($ogspy_version->id_ogspy_version->CurrentValue);
		$this->AddUrl = $ogspy_version->AddUrl();
		$this->EditUrl = $ogspy_version->EditUrl();
		$this->CopyUrl = $ogspy_version->CopyUrl();
		$this->DeleteUrl = $ogspy_version->DeleteUrl();
		$this->ListUrl = $ogspy_version->ListUrl();

		// Call Row_Rendering event
		$ogspy_version->Row_Rendering();

		// Common render codes for all row types
		// id_ogspy_version

		$ogspy_version->id_ogspy_version->CellCssStyle = ""; $ogspy_version->id_ogspy_version->CellCssClass = "";
		$ogspy_version->id_ogspy_version->CellAttrs = array(); $ogspy_version->id_ogspy_version->ViewAttrs = array(); $ogspy_version->id_ogspy_version->EditAttrs = array();

		// version
		$ogspy_version->version->CellCssStyle = ""; $ogspy_version->version->CellCssClass = "";
		$ogspy_version->version->CellAttrs = array(); $ogspy_version->version->ViewAttrs = array(); $ogspy_version->version->EditAttrs = array();

		// status
		$ogspy_version->status->CellCssStyle = ""; $ogspy_version->status->CellCssClass = "";
		$ogspy_version->status->CellAttrs = array(); $ogspy_version->status->ViewAttrs = array(); $ogspy_version->status->EditAttrs = array();
		if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_ogspy_version
			$ogspy_version->id_ogspy_version->ViewValue = $ogspy_version->id_ogspy_version->CurrentValue;
			$ogspy_version->id_ogspy_version->CssStyle = "";
			$ogspy_version->id_ogspy_version->CssClass = "";
			$ogspy_version->id_ogspy_version->ViewCustomAttributes = "";

			// version
			$ogspy_version->version->ViewValue = $ogspy_version->version->CurrentValue;
			$ogspy_version->version->CssStyle = "";
			$ogspy_version->version->CssClass = "";
			$ogspy_version->version->ViewCustomAttributes = "";

			// status
			if (strval($ogspy_version->status->CurrentValue) <> "") {
				switch ($ogspy_version->status->CurrentValue) {
					case "build":
						$ogspy_version->status->ViewValue = "build";
						break;
					case "alpha":
						$ogspy_version->status->ViewValue = "alpha";
						break;
					case "beta":
						$ogspy_version->status->ViewValue = "beta";
						break;
					case "RC":
						$ogspy_version->status->ViewValue = "RC";
						break;
					case "final":
						$ogspy_version->status->ViewValue = "final";
						break;
					default:
						$ogspy_version->status->ViewValue = $ogspy_version->status->CurrentValue;
				}
			} else {
				$ogspy_version->status->ViewValue = NULL;
			}
			$ogspy_version->status->CssStyle = "";
			$ogspy_version->status->CssClass = "";
			$ogspy_version->status->ViewCustomAttributes = "";

			// id_ogspy_version
			$ogspy_version->id_ogspy_version->HrefValue = "";
			$ogspy_version->id_ogspy_version->TooltipValue = "";

			// version
			$ogspy_version->version->HrefValue = "";
			$ogspy_version->version->TooltipValue = "";

			// status
			$ogspy_version->status->HrefValue = "";
			$ogspy_version->status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($ogspy_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ogspy_version->Row_Rendered();
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
