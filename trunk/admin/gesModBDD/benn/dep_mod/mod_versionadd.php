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
$mod_version_add = new cmod_version_add();
$Page =& $mod_version_add;

// Page init
$mod_version_add->Page_Init();

// Page main
$mod_version_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mod_version_add = new ew_Page("mod_version_add");

// page properties
mod_version_add.PageID = "add"; // page ID
mod_version_add.FormID = "fmod_versionadd"; // form ID
var EW_PAGE_ID = mod_version_add.PageID; // for backward compatibility

// extend page with ValidateForm function
mod_version_add.ValidateForm = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_version->id_module->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_id_version_min"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_version->id_version_min->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_id_version_max"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_version->id_version_max->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_version"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($mod_version->version->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
mod_version_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_version_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_version_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_version_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_version->TableCaption() ?><br><br>
<a href="<?php echo $mod_version->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_version_add->ShowMessage();
?>
<form name="fmod_versionadd" id="fmod_versionadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return mod_version_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="mod_version">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($mod_version->id_module->Visible) { // id_module ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_module->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_version->id_module->CellAttributes() ?>><span id="el_id_module">
<select id="x_id_module" name="x_id_module" title="<?php echo $mod_version->id_module->FldTitle() ?>"<?php echo $mod_version->id_module->EditAttributes() ?>>
<?php
if (is_array($mod_version->id_module->EditValue)) {
	$arwrk = $mod_version->id_module->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mod_version->id_module->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk .= " ORDER BY `root_module` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_id_module" id="s_x_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_id_module" id="lft_x_id_module" value="">
</span><?php echo $mod_version->id_module->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_version->id_version_min->Visible) { // id_version_min ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_version_min->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_version->id_version_min->CellAttributes() ?>><span id="el_id_version_min">
<select id="x_id_version_min" name="x_id_version_min" title="<?php echo $mod_version->id_version_min->FldTitle() ?>"<?php echo $mod_version->id_version_min->EditAttributes() ?>>
<?php
if (is_array($mod_version->id_version_min->EditValue)) {
	$arwrk = $mod_version->id_version_min->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mod_version->id_version_min->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_id_version_min" id="s_x_id_version_min" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_id_version_min" id="lft_x_id_version_min" value="">
</span><?php echo $mod_version->id_version_min->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_version->id_version_max->Visible) { // id_version_max ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->id_version_max->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_version->id_version_max->CellAttributes() ?>><span id="el_id_version_max">
<select id="x_id_version_max" name="x_id_version_max" title="<?php echo $mod_version->id_version_max->FldTitle() ?>"<?php echo $mod_version->id_version_max->EditAttributes() ?>>
<?php
if (is_array($mod_version->id_version_max->EditValue)) {
	$arwrk = $mod_version->id_version_max->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($mod_version->id_version_max->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x_id_version_max" id="s_x_id_version_max" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x_id_version_max" id="lft_x_id_version_max" value="">
</span><?php echo $mod_version->id_version_max->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($mod_version->version->Visible) { // version ?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $mod_version->version->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $mod_version->version->CellAttributes() ?>><span id="el_version">
<input type="text" name="x_version" id="x_version" title="<?php echo $mod_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $mod_version->version->EditValue ?>"<?php echo $mod_version->version->EditAttributes() ?>>
</span><?php echo $mod_version->version->CustomMsg ?></td>
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
['x_id_version_min','x_id_version_min',false],
['x_id_version_max','x_id_version_max',false]]);

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
$mod_version_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_version_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'mod_version';

	// Page object name
	var $PageObjName = 'mod_version_add';

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
	function cmod_version_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_version)
		$GLOBALS["mod_version"] = new cmod_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		global $objForm, $Language, $gsFormError, $mod_version;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id_mod_version"] != "") {
		  $mod_version->id_mod_version->setQueryStringValue($_GET["id_mod_version"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $mod_version->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$mod_version->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $mod_version->CurrentAction = "C"; // Copy record
		  } else {
		    $mod_version->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($mod_version->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("mod_versionlist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$mod_version->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $mod_version->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$mod_version->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $mod_version;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $mod_version;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $mod_version;
		$mod_version->id_module->setFormValue($objForm->GetValue("x_id_module"));
		$mod_version->id_version_min->setFormValue($objForm->GetValue("x_id_version_min"));
		$mod_version->id_version_max->setFormValue($objForm->GetValue("x_id_version_max"));
		$mod_version->version->setFormValue($objForm->GetValue("x_version"));
		$mod_version->id_mod_version->setFormValue($objForm->GetValue("x_id_mod_version"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $mod_version;
		$mod_version->id_mod_version->CurrentValue = $mod_version->id_mod_version->FormValue;
		$mod_version->id_module->CurrentValue = $mod_version->id_module->FormValue;
		$mod_version->id_version_min->CurrentValue = $mod_version->id_version_min->FormValue;
		$mod_version->id_version_max->CurrentValue = $mod_version->id_version_max->FormValue;
		$mod_version->version->CurrentValue = $mod_version->version->FormValue;
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
		if (array_key_exists('EV__id_module', $rs->fields)) {
			$mod_version->id_module->VirtualValue = $rs->fields('EV__id_module'); // Set up virtual field value
		} else {
			$mod_version->id_module->VirtualValue = ""; // Clear value
		}
		$mod_version->id_version_min->setDbValue($rs->fields('id_version_min'));
		if (array_key_exists('EV__id_version_min', $rs->fields)) {
			$mod_version->id_version_min->VirtualValue = $rs->fields('EV__id_version_min'); // Set up virtual field value
		} else {
			$mod_version->id_version_min->VirtualValue = ""; // Clear value
		}
		$mod_version->id_version_max->setDbValue($rs->fields('id_version_max'));
		if (array_key_exists('EV__id_version_max', $rs->fields)) {
			$mod_version->id_version_max->VirtualValue = $rs->fields('EV__id_version_max'); // Set up virtual field value
		} else {
			$mod_version->id_version_max->VirtualValue = ""; // Clear value
		}
		$mod_version->version->setDbValue($rs->fields('version'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $mod_version;

		// Initialize URLs
		// Call Row_Rendering event

		$mod_version->Row_Rendering();

		// Common render codes for all row types
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
			if ($mod_version->id_module->VirtualValue <> "") {
				$mod_version->id_module->ViewValue = $mod_version->id_module->VirtualValue;
			} else {
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
			}
			$mod_version->id_module->CssStyle = "";
			$mod_version->id_module->CssClass = "";
			$mod_version->id_module->ViewCustomAttributes = "";

			// id_version_min
			if ($mod_version->id_version_min->VirtualValue <> "") {
				$mod_version->id_version_min->ViewValue = $mod_version->id_version_min->VirtualValue;
			} else {
			if (strval($mod_version->id_version_min->CurrentValue) <> "") {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_min->CurrentValue) . "";
			$sSqlWrk = "SELECT `v`, `status` FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_version->id_version_min->ViewValue = $rswrk->fields('v');
					$mod_version->id_version_min->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('status');
					$rswrk->Close();
				} else {
					$mod_version->id_version_min->ViewValue = $mod_version->id_version_min->CurrentValue;
				}
			} else {
				$mod_version->id_version_min->ViewValue = NULL;
			}
			}
			$mod_version->id_version_min->CssStyle = "";
			$mod_version->id_version_min->CssClass = "";
			$mod_version->id_version_min->ViewCustomAttributes = "";

			// id_version_max
			if ($mod_version->id_version_max->VirtualValue <> "") {
				$mod_version->id_version_max->ViewValue = $mod_version->id_version_max->VirtualValue;
			} else {
			if (strval($mod_version->id_version_max->CurrentValue) <> "") {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_max->CurrentValue) . "";
			$sSqlWrk = "SELECT `v`, `status` FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$mod_version->id_version_max->ViewValue = $rswrk->fields('v');
					$mod_version->id_version_max->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('status');
					$rswrk->Close();
				} else {
					$mod_version->id_version_max->ViewValue = $mod_version->id_version_max->CurrentValue;
				}
			} else {
				$mod_version->id_version_max->ViewValue = NULL;
			}
			}
			$mod_version->id_version_max->CssStyle = "";
			$mod_version->id_version_max->CssClass = "";
			$mod_version->id_version_max->ViewCustomAttributes = "";

			// version
			$mod_version->version->ViewValue = $mod_version->version->CurrentValue;
			$mod_version->version->CssStyle = "";
			$mod_version->version->CssClass = "";
			$mod_version->version->ViewCustomAttributes = "";

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
		} elseif ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_module
			$mod_version->id_module->EditCustomAttributes = "";
			if (trim(strval($mod_version->id_module->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_module` = " . ew_AdjustSql($mod_version->id_module->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `module`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `root_module` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$mod_version->id_module->EditValue = $arwrk;

			// id_version_min
			$mod_version->id_version_min->EditCustomAttributes = "";
			if (trim(strval($mod_version->id_version_min->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_min->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status`, '' AS SelectFilterFld FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$mod_version->id_version_min->EditValue = $arwrk;

			// id_version_max
			$mod_version->id_version_max->EditCustomAttributes = "";
			if (trim(strval($mod_version->id_version_max->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_ogspy_version` = " . ew_AdjustSql($mod_version->id_version_max->CurrentValue) . "";
			}
			$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status`, '' AS SelectFilterFld FROM `ogspy_version`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$mod_version->id_version_max->EditValue = $arwrk;

			// version
			$mod_version->version->EditCustomAttributes = "";
			$mod_version->version->EditValue = ew_HtmlEncode($mod_version->version->CurrentValue);
		}

		// Call Row Rendered event
		if ($mod_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$mod_version->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $mod_version;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($mod_version->id_module->FormValue) && $mod_version->id_module->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_version->id_module->FldCaption();
		}
		if (!is_null($mod_version->id_version_min->FormValue) && $mod_version->id_version_min->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_version->id_version_min->FldCaption();
		}
		if (!is_null($mod_version->id_version_max->FormValue) && $mod_version->id_version_max->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_version->id_version_max->FldCaption();
		}
		if (!is_null($mod_version->version->FormValue) && $mod_version->version->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $mod_version->version->FldCaption();
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
		global $conn, $Language, $Security, $mod_version;
		$rsnew = array();

		// id_module
		$mod_version->id_module->SetDbValueDef($rsnew, $mod_version->id_module->CurrentValue, 0, FALSE);

		// id_version_min
		$mod_version->id_version_min->SetDbValueDef($rsnew, $mod_version->id_version_min->CurrentValue, 0, FALSE);

		// id_version_max
		$mod_version->id_version_max->SetDbValueDef($rsnew, $mod_version->id_version_max->CurrentValue, 0, FALSE);

		// version
		$mod_version->version->SetDbValueDef($rsnew, $mod_version->version->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$bInsertRow = $mod_version->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($mod_version->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($mod_version->CancelMessage <> "") {
				$this->setMessage($mod_version->CancelMessage);
				$mod_version->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$mod_version->id_mod_version->setDbValue($conn->Insert_ID());
			$rsnew['id_mod_version'] = $mod_version->id_mod_version->DbValue;

			// Call Row Inserted event
			$mod_version->Row_Inserted($rsnew);
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
