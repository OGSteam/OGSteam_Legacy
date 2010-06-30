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
$module_delete = new cmodule_delete();
$Page =& $module_delete;

// Page init
$module_delete->Page_Init();

// Page main
$module_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var module_delete = new ew_Page("module_delete");

// page properties
module_delete.PageID = "delete"; // page ID
module_delete.FormID = "fmoduledelete"; // form ID
var EW_PAGE_ID = module_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
module_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
module_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
module_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
module_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $module_delete->LoadRecordset())
	$module_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($module_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$module_delete->Page_Terminate("modulelist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $module->TableCaption() ?><br><br>
<a href="<?php echo $module->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$module_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="module">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($module_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $module->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $module->root_module->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$module_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$module_delete->lRecCnt++;

	// Set row properties
	$module->CssClass = "";
	$module->CssStyle = "";
	$module->RowAttrs = array();
	$module->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$module_delete->LoadRowValues($rs);

	// Render row
	$module_delete->RenderRow();
?>
	<tr<?php echo $module->RowAttributes() ?>>
		<td<?php echo $module->root_module->CellAttributes() ?>>
<div<?php echo $module->root_module->ViewAttributes() ?>><?php echo $module->root_module->ListViewValue() ?></div></td>
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
$module_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cmodule_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'module';

	// Page object name
	var $PageObjName = 'module_delete';

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
	function cmodule_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (module)
		$GLOBALS["module"] = new cmodule();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		global $Language, $module;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id_module"] <> "") {
			$module->id_module->setQueryStringValue($_GET["id_module"]);
			if (!is_numeric($module->id_module->QueryStringValue))
				$this->Page_Terminate("modulelist.php"); // Prevent SQL injection, exit
			$sKey .= $module->id_module->QueryStringValue;
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
			$this->Page_Terminate("modulelist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("modulelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id_module`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in module class, moduleinfo.php

		$module->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$module->CurrentAction = $_POST["a_delete"];
		} else {
			$module->CurrentAction = "I"; // Display record
		}
		switch ($module->CurrentAction) {
			case "D": // Delete
				$module->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($module->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $module;
		$DeleteRows = TRUE;
		$sWrkFilter = $module->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in module class, moduleinfo.php

		$module->CurrentFilter = $sWrkFilter;
		$sSql = $module->SQL();
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
				$DeleteRows = $module->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id_module'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($module->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($module->CancelMessage <> "") {
				$this->setMessage($module->CancelMessage);
				$module->CancelMessage = "";
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
				$module->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $module;

		// Call Recordset Selecting event
		$module->Recordset_Selecting($module->CurrentFilter);

		// Load List page SQL
		$sSql = $module->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$module->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($module->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$module->Row_Rendered();
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
