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
$mod_version_delete = new cmod_version_delete();
$Page =& $mod_version_delete;

// Page init
$mod_version_delete->Page_Init();

// Page main
$mod_version_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var mod_version_delete = new ew_Page("mod_version_delete");

// page properties
mod_version_delete.PageID = "delete"; // page ID
mod_version_delete.FormID = "fmod_versiondelete"; // form ID
var EW_PAGE_ID = mod_version_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
mod_version_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_version_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_version_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_version_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $mod_version_delete->LoadRecordset())
	$mod_version_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($mod_version_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$mod_version_delete->Page_Terminate("mod_versionlist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_version->TableCaption() ?><br><br>
<a href="<?php echo $mod_version->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_version_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="mod_version">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($mod_version_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $mod_version->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $mod_version->id_module->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_version->id_version_min->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_version->id_version_max->FldCaption() ?></td>
		<td valign="top"><?php echo $mod_version->version->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$mod_version_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$mod_version_delete->lRecCnt++;

	// Set row properties
	$mod_version->CssClass = "";
	$mod_version->CssStyle = "";
	$mod_version->RowAttrs = array();
	$mod_version->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$mod_version_delete->LoadRowValues($rs);

	// Render row
	$mod_version_delete->RenderRow();
?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
		<td<?php echo $mod_version->id_module->CellAttributes() ?>>
<div<?php echo $mod_version->id_module->ViewAttributes() ?>><?php echo $mod_version->id_module->ListViewValue() ?></div></td>
		<td<?php echo $mod_version->id_version_min->CellAttributes() ?>>
<div<?php echo $mod_version->id_version_min->ViewAttributes() ?>><?php echo $mod_version->id_version_min->ListViewValue() ?></div></td>
		<td<?php echo $mod_version->id_version_max->CellAttributes() ?>>
<div<?php echo $mod_version->id_version_max->ViewAttributes() ?>><?php echo $mod_version->id_version_max->ListViewValue() ?></div></td>
		<td<?php echo $mod_version->version->CellAttributes() ?>>
<div<?php echo $mod_version->version->ViewAttributes() ?>><?php echo $mod_version->version->ListViewValue() ?></div></td>
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
$mod_version_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_version_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'mod_version';

	// Page object name
	var $PageObjName = 'mod_version_delete';

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
	function cmod_version_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_version)
		$GLOBALS["mod_version"] = new cmod_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		global $Language, $mod_version;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id_mod_version"] <> "") {
			$mod_version->id_mod_version->setQueryStringValue($_GET["id_mod_version"]);
			if (!is_numeric($mod_version->id_mod_version->QueryStringValue))
				$this->Page_Terminate("mod_versionlist.php"); // Prevent SQL injection, exit
			$sKey .= $mod_version->id_mod_version->QueryStringValue;
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
			$this->Page_Terminate("mod_versionlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("mod_versionlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id_mod_version`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in mod_version class, mod_versioninfo.php

		$mod_version->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$mod_version->CurrentAction = $_POST["a_delete"];
		} else {
			$mod_version->CurrentAction = "I"; // Display record
		}
		switch ($mod_version->CurrentAction) {
			case "D": // Delete
				$mod_version->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($mod_version->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $mod_version;
		$DeleteRows = TRUE;
		$sWrkFilter = $mod_version->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in mod_version class, mod_versioninfo.php

		$mod_version->CurrentFilter = $sWrkFilter;
		$sSql = $mod_version->SQL();
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
				$DeleteRows = $mod_version->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id_mod_version'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($mod_version->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($mod_version->CancelMessage <> "") {
				$this->setMessage($mod_version->CancelMessage);
				$mod_version->CancelMessage = "";
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
				$mod_version->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $mod_version;

		// Call Recordset Selecting event
		$mod_version->Recordset_Selecting($mod_version->CurrentFilter);

		// Load List page SQL
		$sSql = $mod_version->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$mod_version->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($mod_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$mod_version->Row_Rendered();
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
