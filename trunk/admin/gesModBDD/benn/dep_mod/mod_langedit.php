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
$mod_lang_edit = new cmod_lang_edit();
$Page =& $mod_lang_edit;

// Page init
$mod_lang_edit->Page_Init();

// Page main
$mod_lang_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mod_lang_edit = new ew_Page("mod_lang_edit");

// page properties
mod_lang_edit.PageID = "edit"; // page ID
mod_lang_edit.FormID = "fmod_langedit"; // form ID
var EW_PAGE_ID = mod_lang_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
mod_lang_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_id_module"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_lang->id_module->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_id_lang"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_lang->id_lang->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_mod_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_lang->mod_name->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_mod_description"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_lang->mod_description->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
mod_lang_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_lang_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_lang_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_lang_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_lang->TableCaption() ?><br><br>
<a href="<?php echo $mod_lang->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_lang_edit->ShowMessage();
?>
<form name="fmod_langedit" id="fmod_langedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return mod_lang_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="mod_lang">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mod_lang->id_module->Visible) { // id_module ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_module->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->id_module->CellAttributes() ?>><span id="el_id_module">
<div<?php echo $mod_lang->id_module->ViewAttributes() ?>><?php echo $mod_lang->id_module->EditValue ?></div><input type="hidden" name="x_id_module" id="x_id_module" value="<?php echo ew_HtmlEncode($mod_lang->id_module->CurrentValue) ?>">
</span><?php echo $mod_lang->id_module->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_lang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->id_lang->CellAttributes() ?>><span id="el_id_lang">
<div<?php echo $mod_lang->id_lang->ViewAttributes() ?>><?php echo $mod_lang->id_lang->EditValue ?></div><input type="hidden" name="x_id_lang" id="x_id_lang" value="<?php echo ew_HtmlEncode($mod_lang->id_lang->CurrentValue) ?>">
</span><?php echo $mod_lang->id_lang->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->mod_name->Visible) { // mod_name ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->mod_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->mod_name->CellAttributes() ?>><span id="el_mod_name">
<input type="text" name="x_mod_name" id="x_mod_name" title="<?php echo $mod_lang->mod_name->FldTitle() ?>" size="30" maxlength="45" value="<?php echo $mod_lang->mod_name->EditValue ?>"<?php echo $mod_lang->mod_name->EditAttributes() ?>>
</span><?php echo $mod_lang->mod_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->mod_description->Visible) { // mod_description ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->mod_description->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->mod_description->CellAttributes() ?>><span id="el_mod_description">
<input type="text" name="x_mod_description" id="x_mod_description" title="<?php echo $mod_lang->mod_description->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $mod_lang->mod_description->EditValue ?>"<?php echo $mod_lang->mod_description->EditAttributes() ?>>
</span><?php echo $mod_lang->mod_description->CustomMsg ?></td>
	</tr>
<?php } ?>
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
$mod_lang_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_lang_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'mod_lang';

	// Page object name
	var $PageObjName = 'mod_lang_edit';

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
	function cmod_lang_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_lang)
		$GLOBALS["mod_lang"] = new cmod_lang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		global $objForm, $Language, $gsFormError, $mod_lang;

		// Load key from QueryString
		if (@$_GET["id_module"] <> "")
			$mod_lang->id_module->setQueryStringValue($_GET["id_module"]);
		if (@$_GET["id_lang"] <> "")
			$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
		if (@$_POST["a_edit"] <> "") {
			$mod_lang->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$mod_lang->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$mod_lang->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$mod_lang->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($mod_lang->id_module->CurrentValue == "")
			$this->Page_Terminate("mod_langlist.php"); // Invalid key, return to list
		if ($mod_lang->id_lang->CurrentValue == "")
			$this->Page_Terminate("mod_langlist.php"); // Invalid key, return to list
		switch ($mod_lang->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("mod_langlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$mod_lang->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $mod_lang->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$mod_lang->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$mod_lang->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $mod_lang;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $mod_lang;
		$mod_lang->id_module->setFormValue($objForm->GetValue("x_id_module"));
		$mod_lang->id_lang->setFormValue($objForm->GetValue("x_id_lang"));
		$mod_lang->mod_name->setFormValue($objForm->GetValue("x_mod_name"));
		$mod_lang->mod_description->setFormValue($objForm->GetValue("x_mod_description"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $mod_lang;
		$this->LoadRow();
		$mod_lang->id_module->CurrentValue = $mod_lang->id_module->FormValue;
		$mod_lang->id_lang->CurrentValue = $mod_lang->id_lang->FormValue;
		$mod_lang->mod_name->CurrentValue = $mod_lang->mod_name->FormValue;
		$mod_lang->mod_description->CurrentValue = $mod_lang->mod_description->FormValue;
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
		if (array_key_exists('EV__id_module', $rs->fields)) {
			$mod_lang->id_module->VirtualValue = $rs->fields('EV__id_module'); // Set up virtual field value
		} else {
			$mod_lang->id_module->VirtualValue = ""; // Clear value
		}
		$mod_lang->id_lang->setDbValue($rs->fields('id_lang'));
		if (array_key_exists('EV__id_lang', $rs->fields)) {
			$mod_lang->id_lang->VirtualValue = $rs->fields('EV__id_lang'); // Set up virtual field value
		} else {
			$mod_lang->id_lang->VirtualValue = ""; // Clear value
		}
		$mod_lang->mod_name->setDbValue($rs->fields('mod_name'));
		$mod_lang->mod_description->setDbValue($rs->fields('mod_description'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $mod_lang;

		// Initialize URLs
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
			if ($mod_lang->id_module->VirtualValue <> "") {
				$mod_lang->id_module->ViewValue = $mod_lang->id_module->VirtualValue;
			} else {
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
			}
			$mod_lang->id_module->CssStyle = "";
			$mod_lang->id_module->CssClass = "";
			$mod_lang->id_module->ViewCustomAttributes = "";

			// id_lang
			if ($mod_lang->id_lang->VirtualValue <> "") {
				$mod_lang->id_lang->ViewValue = $mod_lang->id_lang->VirtualValue;
			} else {
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
		} elseif ($mod_lang->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_module
			$mod_lang->id_module->EditCustomAttributes = "";
			if ($mod_lang->id_module->VirtualValue <> "") {
				$mod_lang->id_module->ViewValue = $mod_lang->id_module->VirtualValue;
			} else {
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
					$mod_lang->id_module->EditValue = $rswrk->fields('root_module');
					$rswrk->Close();
				} else {
					$mod_lang->id_module->EditValue = $mod_lang->id_module->CurrentValue;
				}
			} else {
				$mod_lang->id_module->EditValue = NULL;
			}
			}
			$mod_lang->id_module->CssStyle = "";
			$mod_lang->id_module->CssClass = "";
			$mod_lang->id_module->ViewCustomAttributes = "";

			// id_lang
			$mod_lang->id_lang->EditCustomAttributes = "";
			if ($mod_lang->id_lang->VirtualValue <> "") {
				$mod_lang->id_lang->ViewValue = $mod_lang->id_lang->VirtualValue;
			} else {
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
					$mod_lang->id_lang->EditValue = $rswrk->fields('country');
					$rswrk->Close();
				} else {
					$mod_lang->id_lang->EditValue = $mod_lang->id_lang->CurrentValue;
				}
			} else {
				$mod_lang->id_lang->EditValue = NULL;
			}
			}
			$mod_lang->id_lang->CssStyle = "";
			$mod_lang->id_lang->CssClass = "";
			$mod_lang->id_lang->ViewCustomAttributes = "";

			// mod_name
			$mod_lang->mod_name->EditCustomAttributes = "";
			$mod_lang->mod_name->EditValue = ew_HtmlEncode($mod_lang->mod_name->CurrentValue);

			// mod_description
			$mod_lang->mod_description->EditCustomAttributes = "";
			$mod_lang->mod_description->EditValue = ew_HtmlEncode($mod_lang->mod_description->CurrentValue);

			// Edit refer script
			// id_module

			$mod_lang->id_module->HrefValue = "";

			// id_lang
			$mod_lang->id_lang->HrefValue = "";

			// mod_name
			$mod_lang->mod_name->HrefValue = "";

			// mod_description
			$mod_lang->mod_description->HrefValue = "";
		}

		// Call Row Rendered event
		if ($mod_lang->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$mod_lang->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $mod_lang;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($mod_lang->id_module->FormValue) && $mod_lang->id_module->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_lang->id_module->FldCaption();
		}
		if (!is_null($mod_lang->id_lang->FormValue) && $mod_lang->id_lang->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_lang->id_lang->FldCaption();
		}
		if (!is_null($mod_lang->mod_name->FormValue) && $mod_lang->mod_name->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_lang->mod_name->FldCaption();
		}
		if (!is_null($mod_lang->mod_description->FormValue) && $mod_lang->mod_description->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_lang->mod_description->FldCaption();
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
		global $conn, $Security, $Language, $mod_lang;
		$sFilter = $mod_lang->KeyFilter();
		$mod_lang->CurrentFilter = $sFilter;
		$sSql = $mod_lang->SQL();
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

			// id_module
			// id_lang
			// mod_name

			$mod_lang->mod_name->SetDbValueDef($rsnew, $mod_lang->mod_name->CurrentValue, "", FALSE);

			// mod_description
			$mod_lang->mod_description->SetDbValueDef($rsnew, $mod_lang->mod_description->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $mod_lang->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($mod_lang->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($mod_lang->CancelMessage <> "") {
					$this->setMessage($mod_lang->CancelMessage);
					$mod_lang->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$mod_lang->Row_Updated($rsold, $rsnew);
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
