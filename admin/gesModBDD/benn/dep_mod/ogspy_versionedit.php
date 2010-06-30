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
$ogspy_version_edit = new cogspy_version_edit();
$Page =& $ogspy_version_edit;

// Page init
$ogspy_version_edit->Page_Init();

// Page main
$ogspy_version_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ogspy_version_edit = new ew_Page("ogspy_version_edit");

// page properties
ogspy_version_edit.PageID = "edit"; // page ID
ogspy_version_edit.FormID = "fogspy_versionedit"; // form ID
var EW_PAGE_ID = ogspy_version_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
ogspy_version_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_version"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ogspy_version->version->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_version"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ogspy_version->version->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_major"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ogspy_version->major->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_major"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ogspy_version->major->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_minor"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($ogspy_version->minor->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_minor"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($ogspy_version->minor->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
ogspy_version_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ogspy_version_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ogspy_version_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ogspy_version_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ogspy_version->TableCaption() ?><br><br>
<a href="<?php echo $ogspy_version->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$ogspy_version_edit->ShowMessage();
?>
<form name="fogspy_versionedit" id="fogspy_versionedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ogspy_version_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="ogspy_version">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($ogspy_version->id_ogspy_version->Visible) { // id_ogspy_version ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->id_ogspy_version->FldCaption() ?></td>
		<td<?php echo $ogspy_version->id_ogspy_version->CellAttributes() ?>><span id="el_id_ogspy_version">
<div<?php echo $ogspy_version->id_ogspy_version->ViewAttributes() ?>><?php echo $ogspy_version->id_ogspy_version->EditValue ?></div><input type="hidden" name="x_id_ogspy_version" id="x_id_ogspy_version" value="<?php echo ew_HtmlEncode($ogspy_version->id_ogspy_version->CurrentValue) ?>">
</span><?php echo $ogspy_version->id_ogspy_version->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->version->Visible) { // version ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->version->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $ogspy_version->version->CellAttributes() ?>><span id="el_version">
<input type="text" name="x_version" id="x_version" title="<?php echo $ogspy_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $ogspy_version->version->EditValue ?>"<?php echo $ogspy_version->version->EditAttributes() ?>>
</span><?php echo $ogspy_version->version->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->major->Visible) { // major ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->major->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $ogspy_version->major->CellAttributes() ?>><span id="el_major">
<input type="text" name="x_major" id="x_major" title="<?php echo $ogspy_version->major->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->major->EditValue ?>"<?php echo $ogspy_version->major->EditAttributes() ?>>
</span><?php echo $ogspy_version->major->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->minor->Visible) { // minor ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->minor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $ogspy_version->minor->CellAttributes() ?>><span id="el_minor">
<input type="text" name="x_minor" id="x_minor" title="<?php echo $ogspy_version->minor->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->minor->EditValue ?>"<?php echo $ogspy_version->minor->EditAttributes() ?>>
</span><?php echo $ogspy_version->minor->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ogspy_version->status->Visible) { // status ?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $ogspy_version->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $ogspy_version->status->CellAttributes() ?>><span id="el_status">
<div id="tp_x_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_status" id="x_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="{value}"<?php echo $ogspy_version->status->EditAttributes() ?>></label></div>
<div id="dsl_x_status" repeatcolumn="5">
<?php
$arwrk = $ogspy_version->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ogspy_version->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_status" id="x_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ogspy_version->status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $ogspy_version->status->CustomMsg ?></td>
	</tr>
<?php } ?>
<input type="hidden" name="x_v" id="x_v" value="<?php echo ew_HtmlEncode($ogspy_version->v->CurrentValue) ?>">
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$ogspy_version_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cogspy_version_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'ogspy_version';

	// Page object name
	var $PageObjName = 'ogspy_version_edit';

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
	function cogspy_version_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (ogspy_version)
		$GLOBALS["ogspy_version"] = new cogspy_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
	var $sDbMasterFilter;
	var $sDbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $ogspy_version;

		// Load key from QueryString
		if (@$_GET["id_ogspy_version"] <> "")
			$ogspy_version->id_ogspy_version->setQueryStringValue($_GET["id_ogspy_version"]);
		if (@$_POST["a_edit"] <> "") {
			$ogspy_version->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$ogspy_version->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$ogspy_version->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$ogspy_version->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($ogspy_version->id_ogspy_version->CurrentValue == "")
			$this->Page_Terminate("ogspy_versionlist.php"); // Invalid key, return to list
		switch ($ogspy_version->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ogspy_versionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$ogspy_version->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $ogspy_version->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$ogspy_version->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$ogspy_version->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $ogspy_version;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $ogspy_version;
		$ogspy_version->id_ogspy_version->setFormValue($objForm->GetValue("x_id_ogspy_version"));
		$ogspy_version->version->setFormValue($objForm->GetValue("x_version"));
		$ogspy_version->major->setFormValue($objForm->GetValue("x_major"));
		$ogspy_version->minor->setFormValue($objForm->GetValue("x_minor"));
		$ogspy_version->status->setFormValue($objForm->GetValue("x_status"));
		$ogspy_version->v->setFormValue($objForm->GetValue("x_v"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $ogspy_version;
		$this->LoadRow();
		$ogspy_version->id_ogspy_version->CurrentValue = $ogspy_version->id_ogspy_version->FormValue;
		$ogspy_version->version->CurrentValue = $ogspy_version->version->FormValue;
		$ogspy_version->major->CurrentValue = $ogspy_version->major->FormValue;
		$ogspy_version->minor->CurrentValue = $ogspy_version->minor->FormValue;
		$ogspy_version->status->CurrentValue = $ogspy_version->status->FormValue;
		$ogspy_version->v->CurrentValue = $ogspy_version->v->FormValue;
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
		$ogspy_version->major->setDbValue($rs->fields('major'));
		$ogspy_version->minor->setDbValue($rs->fields('minor'));
		$ogspy_version->status->setDbValue($rs->fields('status'));
		$ogspy_version->v->setDbValue($rs->fields('v'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $ogspy_version;

		// Initialize URLs
		// Call Row_Rendering event

		$ogspy_version->Row_Rendering();

		// Common render codes for all row types
		// id_ogspy_version

		$ogspy_version->id_ogspy_version->CellCssStyle = ""; $ogspy_version->id_ogspy_version->CellCssClass = "";
		$ogspy_version->id_ogspy_version->CellAttrs = array(); $ogspy_version->id_ogspy_version->ViewAttrs = array(); $ogspy_version->id_ogspy_version->EditAttrs = array();

		// version
		$ogspy_version->version->CellCssStyle = ""; $ogspy_version->version->CellCssClass = "";
		$ogspy_version->version->CellAttrs = array(); $ogspy_version->version->ViewAttrs = array(); $ogspy_version->version->EditAttrs = array();

		// major
		$ogspy_version->major->CellCssStyle = ""; $ogspy_version->major->CellCssClass = "";
		$ogspy_version->major->CellAttrs = array(); $ogspy_version->major->ViewAttrs = array(); $ogspy_version->major->EditAttrs = array();

		// minor
		$ogspy_version->minor->CellCssStyle = ""; $ogspy_version->minor->CellCssClass = "";
		$ogspy_version->minor->CellAttrs = array(); $ogspy_version->minor->ViewAttrs = array(); $ogspy_version->minor->EditAttrs = array();

		// status
		$ogspy_version->status->CellCssStyle = ""; $ogspy_version->status->CellCssClass = "";
		$ogspy_version->status->CellAttrs = array(); $ogspy_version->status->ViewAttrs = array(); $ogspy_version->status->EditAttrs = array();

		// v
		$ogspy_version->v->CellCssStyle = ""; $ogspy_version->v->CellCssClass = "";
		$ogspy_version->v->CellAttrs = array(); $ogspy_version->v->ViewAttrs = array(); $ogspy_version->v->EditAttrs = array();
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

			// major
			$ogspy_version->major->ViewValue = $ogspy_version->major->CurrentValue;
			$ogspy_version->major->CssStyle = "";
			$ogspy_version->major->CssClass = "";
			$ogspy_version->major->ViewCustomAttributes = "";

			// minor
			$ogspy_version->minor->ViewValue = $ogspy_version->minor->CurrentValue;
			$ogspy_version->minor->CssStyle = "";
			$ogspy_version->minor->CssClass = "";
			$ogspy_version->minor->ViewCustomAttributes = "";

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

			// v
			$ogspy_version->v->ViewValue = $ogspy_version->v->CurrentValue;
			$ogspy_version->v->CssStyle = "";
			$ogspy_version->v->CssClass = "";
			$ogspy_version->v->ViewCustomAttributes = "";

			// id_ogspy_version
			$ogspy_version->id_ogspy_version->HrefValue = "";
			$ogspy_version->id_ogspy_version->TooltipValue = "";

			// version
			$ogspy_version->version->HrefValue = "";
			$ogspy_version->version->TooltipValue = "";

			// major
			$ogspy_version->major->HrefValue = "";
			$ogspy_version->major->TooltipValue = "";

			// minor
			$ogspy_version->minor->HrefValue = "";
			$ogspy_version->minor->TooltipValue = "";

			// status
			$ogspy_version->status->HrefValue = "";
			$ogspy_version->status->TooltipValue = "";

			// v
			$ogspy_version->v->HrefValue = "";
			$ogspy_version->v->TooltipValue = "";
		} elseif ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_ogspy_version
			$ogspy_version->id_ogspy_version->EditCustomAttributes = "";
			$ogspy_version->id_ogspy_version->EditValue = $ogspy_version->id_ogspy_version->CurrentValue;
			$ogspy_version->id_ogspy_version->CssStyle = "";
			$ogspy_version->id_ogspy_version->CssClass = "";
			$ogspy_version->id_ogspy_version->ViewCustomAttributes = "";

			// version
			$ogspy_version->version->EditCustomAttributes = "";
			$ogspy_version->version->EditValue = ew_HtmlEncode($ogspy_version->version->CurrentValue);

			// major
			$ogspy_version->major->EditCustomAttributes = "";
			$ogspy_version->major->EditValue = ew_HtmlEncode($ogspy_version->major->CurrentValue);

			// minor
			$ogspy_version->minor->EditCustomAttributes = "";
			$ogspy_version->minor->EditValue = ew_HtmlEncode($ogspy_version->minor->CurrentValue);

			// status
			$ogspy_version->status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("build", "build");
			$arwrk[] = array("alpha", "alpha");
			$arwrk[] = array("beta", "beta");
			$arwrk[] = array("RC", "RC");
			$arwrk[] = array("final", "final");
			$ogspy_version->status->EditValue = $arwrk;

			// v
			$ogspy_version->v->EditCustomAttributes = "";

			// Edit refer script
			// id_ogspy_version

			$ogspy_version->id_ogspy_version->HrefValue = "";

			// version
			$ogspy_version->version->HrefValue = "";

			// major
			$ogspy_version->major->HrefValue = "";

			// minor
			$ogspy_version->minor->HrefValue = "";

			// status
			$ogspy_version->status->HrefValue = "";

			// v
			$ogspy_version->v->HrefValue = "";
		}

		// Call Row Rendered event
		if ($ogspy_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ogspy_version->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $ogspy_version;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($ogspy_version->version->FormValue) && $ogspy_version->version->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $ogspy_version->version->FldCaption();
		}
		if (!ew_CheckInteger($ogspy_version->version->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $ogspy_version->version->FldErrMsg();
		}
		if (!is_null($ogspy_version->major->FormValue) && $ogspy_version->major->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $ogspy_version->major->FldCaption();
		}
		if (!ew_CheckInteger($ogspy_version->major->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $ogspy_version->major->FldErrMsg();
		}
		if (!is_null($ogspy_version->minor->FormValue) && $ogspy_version->minor->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $ogspy_version->minor->FldCaption();
		}
		if (!ew_CheckInteger($ogspy_version->minor->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $ogspy_version->minor->FldErrMsg();
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $ogspy_version;
		$sFilter = $ogspy_version->KeyFilter();
		$ogspy_version->CurrentFilter = $sFilter;
		$sSql = $ogspy_version->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// version
			$ogspy_version->version->SetDbValueDef($rsnew, $ogspy_version->version->CurrentValue, 0, FALSE);

			// major
			$ogspy_version->major->SetDbValueDef($rsnew, $ogspy_version->major->CurrentValue, 0, FALSE);

			// minor
			$ogspy_version->minor->SetDbValueDef($rsnew, $ogspy_version->minor->CurrentValue, 0, FALSE);

			// status
			$ogspy_version->status->SetDbValueDef($rsnew, $ogspy_version->status->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $ogspy_version->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($ogspy_version->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($ogspy_version->CancelMessage <> "") {
					$this->setMessage($ogspy_version->CancelMessage);
					$ogspy_version->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$ogspy_version->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
