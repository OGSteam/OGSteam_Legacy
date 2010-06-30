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
$mod_lang_delete = new cmod_lang_delete();
$Page =& $mod_lang_delete;

// Page init
$mod_lang_delete->Page_Init();

// Page main
$mod_lang_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mod_lang_delete = new ew_Page("mod_lang_delete");

// page properties
mod_lang_delete.PageID = "delete"; // page ID
mod_lang_delete.FormID = "fmod_langdelete"; // form ID
var EW_PAGE_ID = mod_lang_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mod_lang_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_lang_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_lang_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_lang_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
if ($rs = $mod_lang_delete->LoadRecordset())
	$mod_lang_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($mod_lang_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$mod_lang_delete->Page_Terminate("mod_langlist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_lang->TableCaption() ?><br><br>
<a href="<?php echo $mod_lang->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_lang_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="mod_lang">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($mod_lang_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $mod_lang->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $mod_lang->id_module->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_lang->id_lang->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_lang->mod_name->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_lang->mod_description->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$mod_lang_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$mod_lang_delete->lRecCnt++;

	// Set row properties
	$mod_lang->CssClass = "";
	$mod_lang->CssStyle = "";
	$mod_lang->RowAttrs = array();
	$mod_lang->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$mod_lang_delete->LoadRowValues($rs);

	// Render row
	$mod_lang_delete->RenderRow();
?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
		<td<?php echo $mod_lang->id_module->CellAttributes() ?>>
<div<?php echo $mod_lang->id_module->ViewAttributes() ?>><?php echo $mod_lang->id_module->ListViewValue() ?></div></td>
		<td<?php echo $mod_lang->id_lang->CellAttributes() ?>>
<div<?php echo $mod_lang->id_lang->ViewAttributes() ?>><?php echo $mod_lang->id_lang->ListViewValue() ?></div></td>
		<td<?php echo $mod_lang->mod_name->CellAttributes() ?>>
<div<?php echo $mod_lang->mod_name->ViewAttributes() ?>><?php echo $mod_lang->mod_name->ListViewValue() ?></div></td>
		<td<?php echo $mod_lang->mod_description->CellAttributes() ?>>
<div<?php echo $mod_lang->mod_description->ViewAttributes() ?>><?php echo $mod_lang->mod_description->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$mod_lang_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_lang_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'mod_lang';

	// Page object name
	var $PageObjName = 'mod_lang_delete';

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
	function cmod_lang_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_lang)
		$GLOBALS["mod_lang"] = new cmod_lang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $mod_lang;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id_module"] <> "") {
			$mod_lang->id_module->setQueryStringValue($_GET["id_module"]);
			if (!is_numeric($mod_lang->id_module->QueryStringValue))
				$this->Page_Terminate("mod_langlist.php"); // Prevent SQL injection, exit
			$sKey .= $mod_lang->id_module->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if (@$_GET["id_lang"] <> "") {
			$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
			if (!is_numeric($mod_lang->id_lang->QueryStringValue))
				$this->Page_Terminate("mod_langlist.php"); // Prevent SQL injection, exit
			if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sKey .= $mod_lang->id_lang->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("mod_langlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";
			$arKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, trim($sKey)); // Split key by separator
			if (count($arKeyFlds) <> 2)
				$this->Page_Terminate($mod_lang->getReturnUrl()); // Invalid key, exit

			// Set up key field
			$sKeyFld = $arKeyFlds[0];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("mod_langlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id_module`=" . ew_AdjustSql($sKeyFld) . " AND ";

			// Set up key field
			$sKeyFld = $arKeyFlds[1];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("mod_langlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id_lang`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in mod_lang class, mod_langinfo.php

		$mod_lang->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$mod_lang->CurrentAction = $_POST["a_delete"];
		} else {
			$mod_lang->CurrentAction = "I"; // Display record
		}
		switch ($mod_lang->CurrentAction) {
			case "D": // Delete
				$mod_lang->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($mod_lang->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $mod_lang;
		$DeleteRows = TRUE;
		$sWrkFilter = $mod_lang->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in mod_lang class, mod_langinfo.php

		$mod_lang->CurrentFilter = $sWrkFilter;
		$sSql = $mod_lang->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $mod_lang->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id_module'];
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id_lang'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($mod_lang->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($mod_lang->CancelMessage <> "") {
				$this->setMessage($mod_lang->CancelMessage);
				$mod_lang->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$mod_lang->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $mod_lang;

		// Call Recordset Selecting event
		$mod_lang->Recordset_Selecting($mod_lang->CurrentFilter);

		// Load List page SQL
		$sSql = $mod_lang->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$mod_lang->Recordset_Selected($rs);
		return $rs;
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
