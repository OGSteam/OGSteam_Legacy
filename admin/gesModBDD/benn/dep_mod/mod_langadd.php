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
$mod_lang_add = new cmod_lang_add();
$Page =& $mod_lang_add;

// Page init
$mod_lang_add->Page_Init();

// Page main
$mod_lang_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mod_lang_add = new ew_Page("mod_lang_add");

// page properties
mod_lang_add.PageID = "add"; // page ID
mod_lang_add.FormID = "fmod_langadd"; // form ID
var EW_PAGE_ID = mod_lang_add.PageID; // for backward compatibility

// extend page with ValidateForm function
mod_lang_add.ValidateForm = function(fobj) {
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
mod_lang_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_lang_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_lang_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_lang_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_lang->TableCaption() ?><br><br>
<a href="<?php echo $mod_lang->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_lang_add->ShowMessage();
?>
<form name="fmod_langadd" id="fmod_langadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return mod_lang_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="mod_lang">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mod_lang->id_module->Visible) { // id_module ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_module->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->id_module->CellAttributes() ?>><span id="el_id_module">
<select id="x_id_module" name="x_id_module" title="<?php echo $mod_lang->id_module->FldTitle() ?>"<?php echo $mod_lang->id_module->EditAttributes() ?>>
<?php
if (is_array($mod_lang->id_module->EditValue)) {
	$arwrk = $mod_lang->id_module->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mod_lang->id_module->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_id_module" id="s_x_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_id_module" id="lft_x_id_module" value="">
</span><?php echo $mod_lang->id_module->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_lang->id_lang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_lang->id_lang->CellAttributes() ?>><span id="el_id_lang">
<select id="x_id_lang" name="x_id_lang" title="<?php echo $mod_lang->id_lang->FldTitle() ?>"<?php echo $mod_lang->id_lang->EditAttributes() ?>>
<?php
if (is_array($mod_lang->id_lang->EditValue)) {
	$arwrk = $mod_lang->id_lang->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mod_lang->id_lang->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `id_lang`, `country`, '' AS Disp2Fld FROM `lang`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `id_lang`";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_id_lang" id="s_x_id_lang" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_id_lang" id="lft_x_id_lang" value="">
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
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x_id_module','x_id_module',false],
['x_id_lang','x_id_lang',false]]);

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$mod_lang_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_lang_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'mod_lang';

	// Page object name
	var $PageObjName = 'mod_lang_add';

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
	function cmod_lang_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_lang)
		$GLOBALS["mod_lang"] = new cmod_lang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $sDbMasterFilter = "";
	var $sDbDetailFilter = "";
	var $lPriv = 0;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $mod_lang;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id_module"] != "") {
		  $mod_lang->id_module->setQueryStringValue($_GET["id_module"]);
		} else {
		  $bCopy = FALSE;
		}
		if (@$_GET["id_lang"] != "") {
		  $mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $mod_lang->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$mod_lang->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $mod_lang->CurrentAction = "C"; // Copy record
		  } else {
		    $mod_lang->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($mod_lang->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("mod_langlist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$mod_lang->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $mod_lang->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$mod_lang->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $mod_lang;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $mod_lang;
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
		} elseif ($mod_lang->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_module
			$mod_lang->id_module->EditCustomAttributes = "";
			if (trim(strval($mod_lang->id_module->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_module` = " . ew_AdjustSql($mod_lang->id_module->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `module`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$mod_lang->id_module->EditValue = $arwrk;

			// id_lang
			$mod_lang->id_lang->EditCustomAttributes = "";
			if (trim(strval($mod_lang->id_lang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_lang` = " . ew_AdjustSql($mod_lang->id_lang->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `id_lang`, `country`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `lang`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `id_lang`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$mod_lang->id_lang->EditValue = $arwrk;

			// mod_name
			$mod_lang->mod_name->EditCustomAttributes = "";
			$mod_lang->mod_name->EditValue = ew_HtmlEncode($mod_lang->mod_name->CurrentValue);

			// mod_description
			$mod_lang->mod_description->EditCustomAttributes = "";
			$mod_lang->mod_description->EditValue = ew_HtmlEncode($mod_lang->mod_description->CurrentValue);
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

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $mod_lang;

		// Check if key value entered
		if ($mod_lang->id_module->CurrentValue == "") {
			$this->setMessage($Language->Phrase("InvalidKeyValue"));
			return FALSE;
		}

		// Check if key value entered
		if ($mod_lang->id_lang->CurrentValue == "") {
			$this->setMessage($Language->Phrase("InvalidKeyValue"));
			return FALSE;
		}

		// Check for duplicate key
		$bCheckKey = TRUE;
		$sFilter = $mod_lang->KeyFilter();
		if ($bCheckKey) {
			$rsChk = $mod_lang->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setMessage($sKeyErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// id_module
		$mod_lang->id_module->SetDbValueDef($rsnew, $mod_lang->id_module->CurrentValue, 0, FALSE);

		// id_lang
		$mod_lang->id_lang->SetDbValueDef($rsnew, $mod_lang->id_lang->CurrentValue, 0, FALSE);

		// mod_name
		$mod_lang->mod_name->SetDbValueDef($rsnew, $mod_lang->mod_name->CurrentValue, "", FALSE);

		// mod_description
		$mod_lang->mod_description->SetDbValueDef($rsnew, $mod_lang->mod_description->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$bInsertRow = $mod_lang->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($mod_lang->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($mod_lang->CancelMessage <> "") {
				$this->setMessage($mod_lang->CancelMessage);
				$mod_lang->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$mod_lang->Row_Inserted($rsnew);
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
