<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "langinfo.php" ?>
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
$lang_view = new clang_view();
$Page =& $lang_view;

// Page init
$lang_view->Page_Init();

// Page main
$lang_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lang->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lang_view = new ew_Page("lang_view");

// page properties
lang_view.PageID = "view"; // page ID
lang_view.FormID = "flangview"; // form ID
var EW_PAGE_ID = lang_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lang_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
lang_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
lang_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lang_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $lang->TableCaption() ?>
<br><br>
<?php if ($lang->Export == "") { ?>
<a href="<?php echo $lang_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lang_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lang_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lang_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lang_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$lang_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lang->id_lang->Visible) { // id_lang ?>
	<tr<?php echo $lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $lang->id_lang->FldCaption() ?></td>
		<td<?php echo $lang->id_lang->CellAttributes() ?>>
<div<?php echo $lang->id_lang->ViewAttributes() ?>><?php echo $lang->id_lang->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lang->country->Visible) { // country ?>
	<tr<?php echo $lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $lang->country->FldCaption() ?></td>
		<td<?php echo $lang->country->CellAttributes() ?>>
<div<?php echo $lang->country->ViewAttributes() ?>><?php echo $lang->country->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lang->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lang_view->Page_Terminate();
?>
<?php

//
// Page class
//
class clang_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'lang';

	// Page object name
	var $PageObjName = 'lang_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lang;
		if ($lang->UseTokenInUrl) $PageUrl .= "t=" . $lang->TableVar . "&"; // Add page token
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
		global $objForm, $lang;
		if ($lang->UseTokenInUrl) {
			if ($objForm)
				return ($lang->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lang->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clang_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (lang)
		$GLOBALS["lang"] = new clang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lang', TRUE);

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
		global $lang;

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
		global $Language, $lang;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_lang"] <> "") {
				$lang->id_lang->setQueryStringValue($_GET["id_lang"]);
				$this->arRecKey["id_lang"] = $lang->id_lang->QueryStringValue;
			} else {
				$sReturnUrl = "langlist.php"; // Return to list
			}

			// Get action
			$lang->CurrentAction = "I"; // Display form
			switch ($lang->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "langlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "langlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lang->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $lang;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lang->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lang->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lang->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lang->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lang->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lang->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lang;
		$sFilter = $lang->KeyFilter();

		// Call Row Selecting event
		$lang->Row_Selecting($sFilter);

		// Load SQL based on filter
		$lang->CurrentFilter = $sFilter;
		$sSql = $lang->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$lang->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $lang;
		$lang->id_lang->setDbValue($rs->fields('id_lang'));
		$lang->country->setDbValue($rs->fields('country'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $lang;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id_lang=" . urlencode($lang->id_lang->CurrentValue);
		$this->AddUrl = $lang->AddUrl();
		$this->EditUrl = $lang->EditUrl();
		$this->CopyUrl = $lang->CopyUrl();
		$this->DeleteUrl = $lang->DeleteUrl();
		$this->ListUrl = $lang->ListUrl();

		// Call Row_Rendering event
		$lang->Row_Rendering();

		// Common render codes for all row types
		// id_lang

		$lang->id_lang->CellCssStyle = ""; $lang->id_lang->CellCssClass = "";
		$lang->id_lang->CellAttrs = array(); $lang->id_lang->ViewAttrs = array(); $lang->id_lang->EditAttrs = array();

		// country
		$lang->country->CellCssStyle = ""; $lang->country->CellCssClass = "";
		$lang->country->CellAttrs = array(); $lang->country->ViewAttrs = array(); $lang->country->EditAttrs = array();
		if ($lang->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_lang
			$lang->id_lang->ViewValue = $lang->id_lang->CurrentValue;
			$lang->id_lang->CssStyle = "";
			$lang->id_lang->CssClass = "";
			$lang->id_lang->ViewCustomAttributes = "";

			// country
			$lang->country->ViewValue = $lang->country->CurrentValue;
			$lang->country->CssStyle = "";
			$lang->country->CssClass = "";
			$lang->country->ViewCustomAttributes = "";

			// id_lang
			$lang->id_lang->HrefValue = "";
			$lang->id_lang->TooltipValue = "";

			// country
			$lang->country->HrefValue = "";
			$lang->country->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($lang->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$lang->Row_Rendered();
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
