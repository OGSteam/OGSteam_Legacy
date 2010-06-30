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
$ogspy_version_delete = new cogspy_version_delete();
$Page =& $ogspy_version_delete;

// Page init
$ogspy_version_delete->Page_Init();

// Page main
$ogspy_version_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var ogspy_version_delete = new ew_Page("ogspy_version_delete");

// page properties
ogspy_version_delete.PageID = "delete"; // page ID
ogspy_version_delete.FormID = "fogspy_versiondelete"; // form ID
var EW_PAGE_ID = ogspy_version_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
ogspy_version_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ogspy_version_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ogspy_version_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ogspy_version_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $ogspy_version_delete->LoadRecordset())
	$ogspy_version_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($ogspy_version_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$ogspy_version_delete->Page_Terminate("ogspy_versionlist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ogspy_version->TableCaption() ?><br><br>
<a href="<?php echo $ogspy_version->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$ogspy_version_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="ogspy_version">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ogspy_version_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $ogspy_version->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $ogspy_version->version->FldCaption() ?></td>
		<td valign="top"><?php echo $ogspy_version->major->FldCaption() ?></td>
		<td valign="top"><?php echo $ogspy_version->minor->FldCaption() ?></td>
		<td valign="top"><?php echo $ogspy_version->status->FldCaption() ?></td>
		<td valign="top"><?php echo $ogspy_version->v->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$ogspy_version_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$ogspy_version_delete->lRecCnt++;

	// Set row properties
	$ogspy_version->CssClass = "";
	$ogspy_version->CssStyle = "";
	$ogspy_version->RowAttrs = array();
	$ogspy_version->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ogspy_version_delete->LoadRowValues($rs);

	// Render row
	$ogspy_version_delete->RenderRow();
?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
		<td<?php echo $ogspy_version->version->CellAttributes() ?>>
<div<?php echo $ogspy_version->version->ViewAttributes() ?>><?php echo $ogspy_version->version->ListViewValue() ?></div></td>
		<td<?php echo $ogspy_version->major->CellAttributes() ?>>
<div<?php echo $ogspy_version->major->ViewAttributes() ?>><?php echo $ogspy_version->major->ListViewValue() ?></div></td>
		<td<?php echo $ogspy_version->minor->CellAttributes() ?>>
<div<?php echo $ogspy_version->minor->ViewAttributes() ?>><?php echo $ogspy_version->minor->ListViewValue() ?></div></td>
		<td<?php echo $ogspy_version->status->CellAttributes() ?>>
<div<?php echo $ogspy_version->status->ViewAttributes() ?>><?php echo $ogspy_version->status->ListViewValue() ?></div></td>
		<td<?php echo $ogspy_version->v->CellAttributes() ?>>
<div<?php echo $ogspy_version->v->ViewAttributes() ?>><?php echo $ogspy_version->v->ListViewValue() ?></div></td>
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
$ogspy_version_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cogspy_version_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'ogspy_version';

	// Page object name
	var $PageObjName = 'ogspy_version_delete';

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
	function cogspy_version_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (ogspy_version)
		$GLOBALS["ogspy_version"] = new cogspy_version();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		global $Language, $ogspy_version;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id_ogspy_version"] <> "") {
			$ogspy_version->id_ogspy_version->setQueryStringValue($_GET["id_ogspy_version"]);
			if (!is_numeric($ogspy_version->id_ogspy_version->QueryStringValue))
				$this->Page_Terminate("ogspy_versionlist.php"); // Prevent SQL injection, exit
			$sKey .= $ogspy_version->id_ogspy_version->QueryStringValue;
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
			$this->Page_Terminate("ogspy_versionlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("ogspy_versionlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id_ogspy_version`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ogspy_version class, ogspy_versioninfo.php

		$ogspy_version->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$ogspy_version->CurrentAction = $_POST["a_delete"];
		} else {
			$ogspy_version->CurrentAction = "I"; // Display record
		}
		switch ($ogspy_version->CurrentAction) {
			case "D": // Delete
				$ogspy_version->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($ogspy_version->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $ogspy_version;
		$DeleteRows = TRUE;
		$sWrkFilter = $ogspy_version->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in ogspy_version class, ogspy_versioninfo.php

		$ogspy_version->CurrentFilter = $sWrkFilter;
		$sSql = $ogspy_version->SQL();
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
				$DeleteRows = $ogspy_version->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id_ogspy_version'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($ogspy_version->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($ogspy_version->CancelMessage <> "") {
				$this->setMessage($ogspy_version->CancelMessage);
				$ogspy_version->CancelMessage = "";
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
				$ogspy_version->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $ogspy_version;

		// Call Recordset Selecting event
		$ogspy_version->Recordset_Selecting($ogspy_version->CurrentFilter);

		// Load List page SQL
		$sSql = $ogspy_version->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$ogspy_version->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($ogspy_version->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$ogspy_version->Row_Rendered();
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
