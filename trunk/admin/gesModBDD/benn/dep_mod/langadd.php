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
$lang_add = new clang_add();
$Page =& $lang_add;

// Page init
$lang_add->Page_Init();

// Page main
$lang_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var lang_add = new ew_Page("lang_add");

// page properties
lang_add.PageID = "add"; // page ID
lang_add.FormID = "flangadd"; // form ID
var EW_PAGE_ID = lang_add.PageID; // for backward compatibility

// extend page with ValidateForm function
lang_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_country"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lang->country->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
lang_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
lang_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
lang_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lang_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $lang->TableCaption() ?><br><br>
<a href="<?php echo $lang->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$lang_add->ShowMessage();
?>
<form name="flangadd" id="flangadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return lang_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="lang">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lang->country->Visible) { // country ?>
	<tr<?php echo $lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $lang->country->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $lang->country->CellAttributes() ?>><span id="el_country">
<input type="text" name="x_country" id="x_country" title="<?php echo $lang->country->FldTitle() ?>" size="30" maxlength="5" value="<?php echo $lang->country->EditValue ?>"<?php echo $lang->country->EditAttributes() ?>>
</span><?php echo $lang->country->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$lang_add->Page_Terminate();
?>
<?php

//
// Page class
//
class clang_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'lang';

	// Page object name
	var $PageObjName = 'lang_add';

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
	function clang_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (lang)
		$GLOBALS["lang"] = new clang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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
	var $sDbMasterFilter = "";
	var $sDbDetailFilter = "";
	var $lPriv = 0;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $lang;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id_lang"] != "") {
		  $lang->id_lang->setQueryStringValue($_GET["id_lang"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $lang->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$lang->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $lang->CurrentAction = "C"; // Copy record
		  } else {
		    $lang->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($lang->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("langlist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$lang->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $lang->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$lang->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $lang;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $lang;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $lang;
		$lang->country->setFormValue($objForm->GetValue("x_country"));
		$lang->id_lang->setFormValue($objForm->GetValue("x_id_lang"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $lang;
		$lang->id_lang->CurrentValue = $lang->id_lang->FormValue;
		$lang->country->CurrentValue = $lang->country->FormValue;
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
		// Call Row_Rendering event

		$lang->Row_Rendering();

		// Common render codes for all row types
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

			// country
			$lang->country->HrefValue = "";
			$lang->country->TooltipValue = "";
		} elseif ($lang->RowType == EW_ROWTYPE_ADD) { // Add row

			// country
			$lang->country->EditCustomAttributes = "";
			$lang->country->EditValue = ew_HtmlEncode($lang->country->CurrentValue);
		}

		// Call Row Rendered event
		if ($lang->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$lang->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $lang;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($lang->country->FormValue) && $lang->country->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $lang->country->FldCaption();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $lang;
		$rsnew = array();

		// country
		$lang->country->SetDbValueDef($rsnew, $lang->country->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$bInsertRow = $lang->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($lang->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($lang->CancelMessage <> "") {
				$this->setMessage($lang->CancelMessage);
				$lang->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$lang->id_lang->setDbValue($conn->Insert_ID());
			$rsnew['id_lang'] = $lang->id_lang->DbValue;

			// Call Row Inserted event
			$lang->Row_Inserted($rsnew);
		}
		return $AddRow;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
