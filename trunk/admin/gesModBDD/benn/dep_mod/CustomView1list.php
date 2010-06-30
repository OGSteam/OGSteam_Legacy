<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "CustomView1info.php" ?>
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
$CustomView1_list = new cCustomView1_list();
$Page =& $CustomView1_list;

// Page init
$CustomView1_list->Page_Init();

// Page main
$CustomView1_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($CustomView1->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var CustomView1_list = new ew_Page("CustomView1_list");

// page properties
CustomView1_list.PageID = "list"; // page ID
CustomView1_list.FormID = "fCustomView1list"; // form ID
var EW_PAGE_ID = CustomView1_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
CustomView1_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
CustomView1_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
CustomView1_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
CustomView1_list.ValidateRequired = false; // no JavaScript validation
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
<?php } ?>
<?php if ($CustomView1->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$CustomView1_list->lTotalRecs = $CustomView1->SelectRecordCount();
	} else {
		if ($rs = $CustomView1_list->LoadRecordset())
			$CustomView1_list->lTotalRecs = $rs->RecordCount();
	}
	$CustomView1_list->lStartRec = 1;
	if ($CustomView1_list->lDisplayRecs <= 0 || ($CustomView1->Export <> "" && $CustomView1->ExportAll)) // Display all records
		$CustomView1_list->lDisplayRecs = $CustomView1_list->lTotalRecs;
	if (!($CustomView1->Export <> "" && $CustomView1->ExportAll))
		$CustomView1_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $CustomView1_list->LoadRecordset($CustomView1_list->lStartRec-1, $CustomView1_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeCUSTOMVIEW") ?><?php echo $CustomView1->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($CustomView1->Export == "" && $CustomView1->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(CustomView1_list);" style="text-decoration: none;"><img id="CustomView1_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="CustomView1_list_SearchPanel">
<form name="fCustomView1listsrch" id="fCustomView1listsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="CustomView1">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($CustomView1->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $CustomView1_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($CustomView1->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($CustomView1->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($CustomView1->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$CustomView1_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fCustomView1list" id="fCustomView1list" class="ewForm" action="" method="post">
<div id="gmp_CustomView1" class="ewGridMiddlePanel">
<?php if ($CustomView1_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $CustomView1->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$CustomView1_list->RenderListOptions();

// Render list options (header, left)
$CustomView1_list->ListOptions->Render("header", "left");
?>
<?php if ($CustomView1->id_module->Visible) { // id_module ?>
	<?php if ($CustomView1->SortUrl($CustomView1->id_module) == "") { ?>
		<td><?php echo $CustomView1->id_module->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->id_module) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $CustomView1->id_module->FldCaption() ?></td><td style="width: 10px;"><?php if ($CustomView1->id_module->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->id_module->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->id_lang->Visible) { // id_lang ?>
	<?php if ($CustomView1->SortUrl($CustomView1->id_lang) == "") { ?>
		<td><?php echo $CustomView1->id_lang->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->id_lang) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $CustomView1->id_lang->FldCaption() ?></td><td style="width: 10px;"><?php if ($CustomView1->id_lang->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->id_lang->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->mod_name->Visible) { // mod_name ?>
	<?php if ($CustomView1->SortUrl($CustomView1->mod_name) == "") { ?>
		<td><?php echo $CustomView1->mod_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->mod_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $CustomView1->mod_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($CustomView1->mod_name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->mod_name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->mod_description->Visible) { // mod_description ?>
	<?php if ($CustomView1->SortUrl($CustomView1->mod_description) == "") { ?>
		<td><?php echo $CustomView1->mod_description->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->mod_description) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $CustomView1->mod_description->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($CustomView1->mod_description->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->mod_description->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($CustomView1->country->Visible) { // country ?>
	<?php if ($CustomView1->SortUrl($CustomView1->country) == "") { ?>
		<td><?php echo $CustomView1->country->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $CustomView1->SortUrl($CustomView1->country) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $CustomView1->country->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($CustomView1->country->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($CustomView1->country->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$CustomView1_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($CustomView1->ExportAll && $CustomView1->Export <> "") {
	$CustomView1_list->lStopRec = $CustomView1_list->lTotalRecs;
} else {
	$CustomView1_list->lStopRec = $CustomView1_list->lStartRec + $CustomView1_list->lDisplayRecs - 1; // Set the last record to display
}
$CustomView1_list->lRecCount = $CustomView1_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $CustomView1_list->lStartRec > 1)
		$rs->Move($CustomView1_list->lStartRec - 1);
}

// Initialize aggregate
$CustomView1->RowType = EW_ROWTYPE_AGGREGATEINIT;
$CustomView1_list->RenderRow();
$CustomView1_list->lRowCnt = 0;
while (($CustomView1->CurrentAction == "gridadd" || !$rs->EOF) &&
	$CustomView1_list->lRecCount < $CustomView1_list->lStopRec) {
	$CustomView1_list->lRecCount++;
	if (intval($CustomView1_list->lRecCount) >= intval($CustomView1_list->lStartRec)) {
		$CustomView1_list->lRowCnt++;

	// Init row class and style
	$CustomView1->CssClass = "";
	$CustomView1->CssStyle = "";
	$CustomView1->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($CustomView1->CurrentAction == "gridadd") {
		$CustomView1_list->LoadDefaultValues(); // Load default values
	} else {
		$CustomView1_list->LoadRowValues($rs); // Load row values
	}
	$CustomView1->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$CustomView1_list->RenderRow();

	// Render list options
	$CustomView1_list->RenderListOptions();
?>
	<tr<?php echo $CustomView1->RowAttributes() ?>>
<?php

// Render list options (body, left)
$CustomView1_list->ListOptions->Render("body", "left");
?>
	<?php if ($CustomView1->id_module->Visible) { // id_module ?>
		<td<?php echo $CustomView1->id_module->CellAttributes() ?>>
<div<?php echo $CustomView1->id_module->ViewAttributes() ?>><?php echo $CustomView1->id_module->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->id_lang->Visible) { // id_lang ?>
		<td<?php echo $CustomView1->id_lang->CellAttributes() ?>>
<div<?php echo $CustomView1->id_lang->ViewAttributes() ?>><?php echo $CustomView1->id_lang->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->mod_name->Visible) { // mod_name ?>
		<td<?php echo $CustomView1->mod_name->CellAttributes() ?>>
<div<?php echo $CustomView1->mod_name->ViewAttributes() ?>><?php echo $CustomView1->mod_name->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->mod_description->Visible) { // mod_description ?>
		<td<?php echo $CustomView1->mod_description->CellAttributes() ?>>
<div<?php echo $CustomView1->mod_description->ViewAttributes() ?>><?php echo $CustomView1->mod_description->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($CustomView1->country->Visible) { // country ?>
		<td<?php echo $CustomView1->country->CellAttributes() ?>>
<div<?php echo $CustomView1->country->ViewAttributes() ?>><?php echo $CustomView1->country->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$CustomView1_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($CustomView1->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($CustomView1->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($CustomView1->CurrentAction <> "gridadd" && $CustomView1->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($CustomView1_list->Pager)) $CustomView1_list->Pager = new cPrevNextPager($CustomView1_list->lStartRec, $CustomView1_list->lDisplayRecs, $CustomView1_list->lTotalRecs) ?>
<?php if ($CustomView1_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($CustomView1_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($CustomView1_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $CustomView1_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($CustomView1_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($CustomView1_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $CustomView1_list->PageUrl() ?>start=<?php echo $CustomView1_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $CustomView1_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $CustomView1_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $CustomView1_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $CustomView1_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($CustomView1_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($CustomView1_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($CustomView1->Export == "" && $CustomView1->CurrentAction == "") { ?>
<?php } ?>
<?php if ($CustomView1->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$CustomView1_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cCustomView1_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'CustomView1';

	// Page object name
	var $PageObjName = 'CustomView1_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $CustomView1;
		if ($CustomView1->UseTokenInUrl) $PageUrl .= "t=" . $CustomView1->TableVar . "&"; // Add page token
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
		global $objForm, $CustomView1;
		if ($CustomView1->UseTokenInUrl) {
			if ($objForm)
				return ($CustomView1->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($CustomView1->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cCustomView1_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (CustomView1)
		$GLOBALS["CustomView1"] = new cCustomView1();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["CustomView1"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "CustomView1delete.php";
		$this->MultiUpdateUrl = "CustomView1update.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'CustomView1', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $CustomView1;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$CustomView1->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$CustomView1->Export = $_POST["exporttype"];
		} else {
			$CustomView1->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $CustomView1->Export; // Get export parameter, used in header
		$gsExportFile = $CustomView1->TableVar; // Get export file, used in header

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

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $CustomView1;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$CustomView1->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($CustomView1->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $CustomView1->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$CustomView1->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$CustomView1->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$CustomView1->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $CustomView1->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$CustomView1->setSessionWhere($sFilter);
		$CustomView1->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $CustomView1;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $CustomView1->mod_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $CustomView1->mod_description, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $CustomView1->country, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $CustomView1;
		$sSearchStr = "";
		$sSearchKeyword = $CustomView1->BasicSearchKeyword;
		$sSearchType = $CustomView1->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$CustomView1->setSessionBasicSearchKeyword($sSearchKeyword);
			$CustomView1->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $CustomView1;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$CustomView1->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $CustomView1;
		$CustomView1->setSessionBasicSearchKeyword("");
		$CustomView1->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $CustomView1;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$CustomView1->BasicSearchKeyword = $CustomView1->getSessionBasicSearchKeyword();
			$CustomView1->BasicSearchType = $CustomView1->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $CustomView1;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$CustomView1->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$CustomView1->CurrentOrderType = @$_GET["ordertype"];
			$CustomView1->UpdateSort($CustomView1->id_module); // id_module
			$CustomView1->UpdateSort($CustomView1->id_lang); // id_lang
			$CustomView1->UpdateSort($CustomView1->mod_name); // mod_name
			$CustomView1->UpdateSort($CustomView1->mod_description); // mod_description
			$CustomView1->UpdateSort($CustomView1->country); // country
			$CustomView1->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $CustomView1;
		$sOrderBy = $CustomView1->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($CustomView1->SqlOrderBy() <> "") {
				$sOrderBy = $CustomView1->SqlOrderBy();
				$CustomView1->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $CustomView1;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$CustomView1->setSessionOrderBy($sOrderBy);
				$CustomView1->id_module->setSort("");
				$CustomView1->id_lang->setSort("");
				$CustomView1->mod_name->setSort("");
				$CustomView1->mod_description->setSort("");
				$CustomView1->country->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$CustomView1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $CustomView1;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($CustomView1->Export <> "" ||
			$CustomView1->CurrentAction == "gridadd" ||
			$CustomView1->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $CustomView1;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $CustomView1;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $CustomView1;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$CustomView1->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$CustomView1->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $CustomView1->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$CustomView1->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$CustomView1->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $CustomView1;
		$CustomView1->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$CustomView1->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $CustomView1;

		// Call Recordset Selecting event
		$CustomView1->Recordset_Selecting($CustomView1->CurrentFilter);

		// Load List page SQL
		$sSql = $CustomView1->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$CustomView1->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $CustomView1;
		$sFilter = $CustomView1->KeyFilter();

		// Call Row Selecting event
		$CustomView1->Row_Selecting($sFilter);

		// Load SQL based on filter
		$CustomView1->CurrentFilter = $sFilter;
		$sSql = $CustomView1->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$CustomView1->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $CustomView1;
		$CustomView1->id_module->setDbValue($rs->fields('id_module'));
		$CustomView1->id_lang->setDbValue($rs->fields('id_lang'));
		$CustomView1->mod_name->setDbValue($rs->fields('mod_name'));
		$CustomView1->mod_description->setDbValue($rs->fields('mod_description'));
		$CustomView1->country->setDbValue($rs->fields('country'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $CustomView1;

		// Initialize URLs
		$this->ViewUrl = $CustomView1->ViewUrl();
		$this->EditUrl = $CustomView1->EditUrl();
		$this->InlineEditUrl = $CustomView1->InlineEditUrl();
		$this->CopyUrl = $CustomView1->CopyUrl();
		$this->InlineCopyUrl = $CustomView1->InlineCopyUrl();
		$this->DeleteUrl = $CustomView1->DeleteUrl();

		// Call Row_Rendering event
		$CustomView1->Row_Rendering();

		// Common render codes for all row types
		// id_module

		$CustomView1->id_module->CellCssStyle = ""; $CustomView1->id_module->CellCssClass = "";
		$CustomView1->id_module->CellAttrs = array(); $CustomView1->id_module->ViewAttrs = array(); $CustomView1->id_module->EditAttrs = array();

		// id_lang
		$CustomView1->id_lang->CellCssStyle = ""; $CustomView1->id_lang->CellCssClass = "";
		$CustomView1->id_lang->CellAttrs = array(); $CustomView1->id_lang->ViewAttrs = array(); $CustomView1->id_lang->EditAttrs = array();

		// mod_name
		$CustomView1->mod_name->CellCssStyle = ""; $CustomView1->mod_name->CellCssClass = "";
		$CustomView1->mod_name->CellAttrs = array(); $CustomView1->mod_name->ViewAttrs = array(); $CustomView1->mod_name->EditAttrs = array();

		// mod_description
		$CustomView1->mod_description->CellCssStyle = ""; $CustomView1->mod_description->CellCssClass = "";
		$CustomView1->mod_description->CellAttrs = array(); $CustomView1->mod_description->ViewAttrs = array(); $CustomView1->mod_description->EditAttrs = array();

		// country
		$CustomView1->country->CellCssStyle = ""; $CustomView1->country->CellCssClass = "";
		$CustomView1->country->CellAttrs = array(); $CustomView1->country->ViewAttrs = array(); $CustomView1->country->EditAttrs = array();
		if ($CustomView1->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_module
			if (strval($CustomView1->id_module->CurrentValue) <> "") {
				$sFilterWrk = "`id_module` = " . ew_AdjustSql($CustomView1->id_module->CurrentValue) . "";
			$sSqlWrk = "SELECT DISTINCT `root_module` FROM `module`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$CustomView1->id_module->ViewValue = $rswrk->fields('root_module');
					$rswrk->Close();
				} else {
					$CustomView1->id_module->ViewValue = $CustomView1->id_module->CurrentValue;
				}
			} else {
				$CustomView1->id_module->ViewValue = NULL;
			}
			$CustomView1->id_module->CssStyle = "";
			$CustomView1->id_module->CssClass = "";
			$CustomView1->id_module->ViewCustomAttributes = "";

			// id_lang
			if (strval($CustomView1->id_lang->CurrentValue) <> "") {
				$sFilterWrk = "`id_lang` = " . ew_AdjustSql($CustomView1->id_lang->CurrentValue) . "";
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
					$CustomView1->id_lang->ViewValue = $rswrk->fields('country');
					$rswrk->Close();
				} else {
					$CustomView1->id_lang->ViewValue = $CustomView1->id_lang->CurrentValue;
				}
			} else {
				$CustomView1->id_lang->ViewValue = NULL;
			}
			$CustomView1->id_lang->CssStyle = "";
			$CustomView1->id_lang->CssClass = "";
			$CustomView1->id_lang->ViewCustomAttributes = "";

			// mod_name
			$CustomView1->mod_name->ViewValue = $CustomView1->mod_name->CurrentValue;
			$CustomView1->mod_name->CssStyle = "";
			$CustomView1->mod_name->CssClass = "";
			$CustomView1->mod_name->ViewCustomAttributes = "";

			// mod_description
			$CustomView1->mod_description->ViewValue = $CustomView1->mod_description->CurrentValue;
			$CustomView1->mod_description->CssStyle = "";
			$CustomView1->mod_description->CssClass = "";
			$CustomView1->mod_description->ViewCustomAttributes = "";

			// country
			$CustomView1->country->ViewValue = $CustomView1->country->CurrentValue;
			$CustomView1->country->CssStyle = "";
			$CustomView1->country->CssClass = "";
			$CustomView1->country->ViewCustomAttributes = "";

			// id_module
			$CustomView1->id_module->HrefValue = "";
			$CustomView1->id_module->TooltipValue = "";

			// id_lang
			$CustomView1->id_lang->HrefValue = "";
			$CustomView1->id_lang->TooltipValue = "";

			// mod_name
			$CustomView1->mod_name->HrefValue = "";
			$CustomView1->mod_name->TooltipValue = "";

			// mod_description
			$CustomView1->mod_description->HrefValue = "";
			$CustomView1->mod_description->TooltipValue = "";

			// country
			$CustomView1->country->HrefValue = "";
			$CustomView1->country->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($CustomView1->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$CustomView1->Row_Rendered();
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
