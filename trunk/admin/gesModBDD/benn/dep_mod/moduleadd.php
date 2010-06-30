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
$module_add = new cmodule_add();
$Page =& $module_add;

// Page init
$module_add->Page_Init();

// Page main
$module_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var module_add = new ew_Page("module_add");

// page properties
module_add.PageID = "add"; // page ID
module_add.FormID = "fmoduleadd"; // form ID
var EW_PAGE_ID = module_add.PageID; // for backward compatibility

// extend page with ValidateForm function
module_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_root_module"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($module->root_module->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
module_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
module_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
module_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
module_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $module->TableCaption() ?><br><br>
<a href="<?php echo $module->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$module_add->ShowMessage();
?>
<form name="fmoduleadd" id="fmoduleadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return module_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="module">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($module->root_module->Visible) { // root_module ?>
	<tr<?php echo $module->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $module->root_module->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $module->root_module->CellAttributes() ?>><span id="el_root_module">
<input type="text" name="x_root_module" id="x_root_module" title="<?php echo $module->root_module->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $module->root_module->EditValue ?>"<?php echo $module->root_module->EditAttributes() ?>>
</span><?php echo $module->root_module->CustomMsg ?></td>
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
$module_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cmodule_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'module';

	// Page object name
	var $PageObjName = 'module_add';

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
	function cmodule_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (module)
		$GLOBALS["module"] = new cmodule();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		global $objForm, $Language, $gsFormError, $module;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id_module"] != "") {
		  $module->id_module->setQueryStringValue($_GET["id_module"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $module->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$module->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $module->CurrentAction = "C"; // Copy record
		  } else {
		    $module->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($module->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("modulelist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$module->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $module->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$module->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $module;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $module;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $module;
		$module->root_module->setFormValue($objForm->GetValue("x_root_module"));
		$module->id_module->setFormValue($objForm->GetValue("x_id_module"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $module;
		$module->id_module->CurrentValue = $module->id_module->FormValue;
		$module->root_module->CurrentValue = $module->root_module->FormValue;
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
		// Call Row_Rendering event

		$module->Row_Rendering();

		// Common render codes for all row types
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

			// root_module
			$module->root_module->HrefValue = "";
			$module->root_module->TooltipValue = "";
		} elseif ($module->RowType == EW_ROWTYPE_ADD) { // Add row

			// root_module
			$module->root_module->EditCustomAttributes = "";
			$module->root_module->EditValue = ew_HtmlEncode($module->root_module->CurrentValue);
		}

		// Call Row Rendered event
		if ($module->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$module->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $module;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($module->root_module->FormValue) && $module->root_module->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $module->root_module->FldCaption();
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
		global $conn, $Language, $Security, $module;
		$rsnew = array();

		// root_module
		$module->root_module->SetDbValueDef($rsnew, $module->root_module->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$bInsertRow = $module->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($module->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($module->CancelMessage <> "") {
				$this->setMessage($module->CancelMessage);
				$module->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$module->id_module->setDbValue($conn->Insert_ID());
			$rsnew['id_module'] = $module->id_module->DbValue;

			// Call Row Inserted event
			$module->Row_Inserted($rsnew);
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
