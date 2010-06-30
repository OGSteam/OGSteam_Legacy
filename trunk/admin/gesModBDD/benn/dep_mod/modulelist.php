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
$module_list = new cmodule_list();
$Page =& $module_list;

// Page init
$module_list->Page_Init();

// Page main
$module_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($module->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var module_list = new ew_Page("module_list");

// page properties
module_list.PageID = "list"; // page ID
module_list.FormID = "fmodulelist"; // form ID
var EW_PAGE_ID = module_list.PageID; // for backward compatibility

// extend page with ValidateForm function
module_list.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var addcnt = 0;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		var chkthisrow = true;
		if (fobj.a_list && fobj.a_list.value == "gridinsert")
			chkthisrow = !(this.EmptyRow(fobj, infix));
		else
			chkthisrow = true;
		if (chkthisrow) {
			addcnt += 1;
		elm = fobj.elements["x" + infix + "_root_module"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($module->root_module->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Extend page with empty row check
module_list.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "root_module", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
module_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
module_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
module_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
module_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($module->Export == "") { ?>
<?php } ?>
<?php
if ($module->CurrentAction == "gridadd") {
	$module->CurrentFilter = "0=1";
	$module_list->lStartRec = 1;
	if ($module_list->lDisplayRecs <= 0)
		$module_list->lDisplayRecs = 20;
	$module_list->lTotalRecs = $module_list->lDisplayRecs;
	$module_list->lStopRec = $module_list->lDisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$module_list->lTotalRecs = $module->SelectRecordCount();
	} else {
		if ($rs = $module_list->LoadRecordset())
			$module_list->lTotalRecs = $rs->RecordCount();
	}
	$module_list->lStartRec = 1;
	if ($module_list->lDisplayRecs <= 0 || ($module->Export <> "" && $module->ExportAll)) // Display all records
		$module_list->lDisplayRecs = $module_list->lTotalRecs;
	if (!($module->Export <> "" && $module->ExportAll))
		$module_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $module_list->LoadRecordset($module_list->lStartRec-1, $module_list->lDisplayRecs);
}
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $module->TableCaption() ?>
</span></p>
<?php if ($module->Export == "" && $module->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(module_list);" style="text-decoration: none;"><img id="module_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="module_list_SearchPanel">
<form name="fmodulelistsrch" id="fmodulelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="module">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($module->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $module_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($module->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($module->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($module->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$module_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fmodulelist" id="fmodulelist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="module">
<div id="gmp_module" class="ewGridMiddlePanel">
<?php if ($module_list->lTotalRecs > 0 || $module->CurrentAction == "add" || $module->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $module->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$module_list->RenderListOptions();

// Render list options (header, left)
$module_list->ListOptions->Render("header", "left");
?>
<?php if ($module->root_module->Visible) { // root_module ?>
	<?php if ($module->SortUrl($module->root_module) == "") { ?>
		<td><?php echo $module->root_module->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $module->SortUrl($module->root_module) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $module->root_module->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($module->root_module->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($module->root_module->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$module_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
	if ($module->CurrentAction == "add" || $module->CurrentAction == "copy") {
		$module_list->lRowIndex = 1;
		if ($module->CurrentAction == "copy" && !$module_list->LoadRow())
				$module->CurrentAction = "add";
		if ($module->CurrentAction == "add")
			$module_list->LoadDefaultValues();
		if ($module->EventCancelled) // Insert failed
			$module_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$module->CssClass = "ewTableEditRow";
		$module->CssStyle = "";
		$module->RowAttrs = array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
		$module->RowType = EW_ROWTYPE_ADD;

		// Render row
		$module_list->RenderRow();

		// Render list options
		$module_list->RenderListOptions();
?>
	<tr<?php echo $module->RowAttributes() ?>>
<?php

// Render list options (body, left)
$module_list->ListOptions->Render("body", "left");
?>
	<?php if ($module->root_module->Visible) { // root_module ?>
		<td>
<input type="text" name="x<?php echo $module_list->lRowIndex ?>_root_module" id="x<?php echo $module_list->lRowIndex ?>_root_module" title="<?php echo $module->root_module->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $module->root_module->EditValue ?>"<?php echo $module->root_module->EditAttributes() ?>>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$module_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
<?php
if ($module->ExportAll && $module->Export <> "") {
	$module_list->lStopRec = $module_list->lTotalRecs;
} else {
	$module_list->lStopRec = $module_list->lStartRec + $module_list->lDisplayRecs - 1; // Set the last record to display
}
$module_list->lRecCount = $module_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $module_list->lStartRec > 1)
		$rs->Move($module_list->lStartRec - 1);
}

// Initialize aggregate
$module->RowType = EW_ROWTYPE_AGGREGATEINIT;
$module_list->RenderRow();
$module_list->lRowCnt = 0;
$module_list->lEditRowCnt = 0;
if ($module->CurrentAction == "edit")
	$module_list->lRowIndex = 1;
if ($module->CurrentAction == "gridadd")
	$module_list->lRowIndex = 0;
if ($module->CurrentAction == "gridedit")
	$module_list->lRowIndex = 0;
while (($module->CurrentAction == "gridadd" || !$rs->EOF) &&
	$module_list->lRecCount < $module_list->lStopRec) {
	$module_list->lRecCount++;
	if (intval($module_list->lRecCount) >= intval($module_list->lStartRec)) {
		$module_list->lRowCnt++;
		if ($module->CurrentAction == "gridadd" || $module->CurrentAction == "gridedit")
			$module_list->lRowIndex++;

	// Init row class and style
	$module->CssClass = "";
	$module->CssStyle = "";
	$module->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($module->CurrentAction == "gridadd") {
		$module_list->LoadDefaultValues(); // Load default values
	} else {
		$module_list->LoadRowValues($rs); // Load row values
	}
	$module->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($module->CurrentAction == "gridadd") // Grid add
		$module->RowType = EW_ROWTYPE_ADD; // Render add
	if ($module->CurrentAction == "gridadd" && $module->EventCancelled) // Insert failed
		$module_list->RestoreCurrentRowFormValues($module_list->lRowIndex); // Restore form values
	if ($module->CurrentAction == "edit") {
		if ($module_list->CheckInlineEditKey() && $module_list->lEditRowCnt == 0) { // Inline edit
			$module->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($module->CurrentAction == "gridedit") { // Grid edit
		$module->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($module->RowType == EW_ROWTYPE_EDIT && $module->EventCancelled) { // Update failed
		if ($module->CurrentAction == "edit")
			$module_list->RestoreFormValues(); // Restore form values
		if ($module->CurrentAction == "gridedit")
			$module_list->RestoreCurrentRowFormValues($module_list->lRowIndex); // Restore form values
	}
	if ($module->RowType == EW_ROWTYPE_EDIT) // Edit row
		$module_list->lEditRowCnt++;
	if ($module->RowType == EW_ROWTYPE_ADD || $module->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$module->RowAttrs = array_merge($module->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$module->CssClass = "ewTableEditRow";
	}

	// Render row
	$module_list->RenderRow();

	// Render list options
	$module_list->RenderListOptions();
?>
	<tr<?php echo $module->RowAttributes() ?>>
<?php

// Render list options (body, left)
$module_list->ListOptions->Render("body", "left");
?>
	<?php if ($module->root_module->Visible) { // root_module ?>
		<td<?php echo $module->root_module->CellAttributes() ?>>
<?php if ($module->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $module_list->lRowIndex ?>_root_module" id="x<?php echo $module_list->lRowIndex ?>_root_module" title="<?php echo $module->root_module->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $module->root_module->EditValue ?>"<?php echo $module->root_module->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $module_list->lRowIndex ?>_root_module" id="o<?php echo $module_list->lRowIndex ?>_root_module" value="<?php echo ew_HtmlEncode($module->root_module->OldValue) ?>">
<?php } ?>
<?php if ($module->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $module_list->lRowIndex ?>_root_module" id="x<?php echo $module_list->lRowIndex ?>_root_module" title="<?php echo $module->root_module->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $module->root_module->EditValue ?>"<?php echo $module->root_module->EditAttributes() ?>>
<?php } ?>
<?php if ($module->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $module->root_module->ViewAttributes() ?>><?php echo $module->root_module->ListViewValue() ?></div>
<?php } ?>
<?php if ($module->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $module_list->lRowIndex ?>_id_module" id="o<?php echo $module_list->lRowIndex ?>_id_module" value="<?php echo ew_HtmlEncode($module->id_module->OldValue) ?>">
<?php } ?>
<?php if ($module->RowType == EW_ROWTYPE_EDIT) { ?>
<input type="hidden" name="x<?php echo $module_list->lRowIndex ?>_id_module" id="x<?php echo $module_list->lRowIndex ?>_id_module" value="<?php echo ew_HtmlEncode($module->id_module->CurrentValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$module_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($module->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($module->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($module->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($module->CurrentAction == "add" || $module->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $module_list->lRowIndex ?>">
<?php } ?>
<?php if ($module->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $module_list->lRowIndex ?>">
<?php } ?>
<?php if ($module->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $module_list->lRowIndex ?>">
<?php } ?>
<?php if ($module->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $module_list->lRowIndex ?>">
<?php echo $module_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($module->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($module->CurrentAction <> "gridadd" && $module->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($module_list->Pager)) $module_list->Pager = new cPrevNextPager($module_list->lStartRec, $module_list->lDisplayRecs, $module_list->lTotalRecs) ?>
<?php if ($module_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($module_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $module_list->PageUrl() ?>start=<?php echo $module_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($module_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $module_list->PageUrl() ?>start=<?php echo $module_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $module_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($module_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $module_list->PageUrl() ?>start=<?php echo $module_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($module_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $module_list->PageUrl() ?>start=<?php echo $module_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $module_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $module_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $module_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $module_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($module_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($module_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($module->CurrentAction <> "gridadd" && $module->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<a href="<?php echo $module_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $module_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $module_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php if ($module_list->lTotalRecs > 0) { ?>
<a href="<?php echo $module_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($module_list->lTotalRecs > 0) { ?>
<a href="" onclick="ew_SubmitSelected(document.fmodulelist, '<?php echo $module_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($module->CurrentAction == "gridadd") { ?>
<a href="" onclick="f=document.fmodulelist;if(module_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridInsertLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $module_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($module->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.fmodulelist;if(module_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $module_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($module->Export == "" && $module->CurrentAction == "") { ?>
<?php } ?>
<?php if ($module->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$module_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cmodule_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'module';

	// Page object name
	var $PageObjName = 'module_list';

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
	function cmodule_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (module)
		$GLOBALS["module"] = new cmodule();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["module"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "moduledelete.php";
		$this->MultiUpdateUrl = "moduleupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'module', TRUE);

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
		global $module;

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$module->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$module->Export = $_POST["exporttype"];
		} else {
			$module->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $module->Export; // Get export parameter, used in header
		$gsExportFile = $module->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $module;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$module->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($module->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($module->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($module->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($module->CurrentAction == "add" || $module->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($module->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$module->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($module->CurrentAction == "gridupdate" || $module->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($module->CurrentAction == "update" || $module->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($module->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($module->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd")
						$this->GridInsert();
				}
			}

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$module->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($module->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $module->getRecordsPerPage(); // Restore from Session
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
		$module->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$module->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$module->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $module->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$module->setSessionWhere($sFilter);
		$module->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $module;
		$module->setKey("id_module", ""); // Clear inline edit key
		$module->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $module;
		$bInlineEdit = TRUE;
		if (@$_GET["id_module"] <> "") {
			$module->id_module->setQueryStringValue($_GET["id_module"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$module->setKey("id_module", $module->id_module->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $module;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;	
			if ($this->CheckInlineEditKey()) { // Check key
				$module->SendEmail = TRUE; // Send email on update success
				$bInlineUpdate = $this->EditRow(); // Update record
			} else {
				$bInlineUpdate = FALSE;
			}
		}
		if ($bInlineUpdate) { // Update success
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$module->EventCancelled = TRUE; // Cancel event
			$module->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $module;

		//CheckInlineEditKey = True
		if (strval($module->getKey("id_module")) <> strval($module->id_module->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $module;
		if ($module->CurrentAction == "copy") {
			if (@$_GET["id_module"] <> "") {
				$module->id_module->setQueryStringValue($_GET["id_module"]);
			} else {
				$module->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError, $module;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$module->EventCancelled = TRUE; // Set event cancelled
			$module->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$module->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage($Language->Phrase("AddSuccess")); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$module->EventCancelled = TRUE; // Set event cancelled
			$module->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $module;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$module->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $module->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));

		// Update all rows based on key
		while ($sThisKey <> "") {

			// Load all values and keys
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$bGridUpdate = FALSE; // Form error, reset action
				$this->setMessage($gsFormError);
			} else {
				if ($this->SetupKeyValues($sThisKey)) { // Set up key values
					$module->SendEmail = FALSE; // Do not send email on update success
					$bGridUpdate = $this->EditRow(); // Update this row
				} else {
					$bGridUpdate = FALSE; // update failed
				}
			}
			if ($bGridUpdate) {
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			} else {
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$module->EventCancelled = TRUE; // Set event cancelled
			$module->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $module;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $module->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		global $module;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$module->id_module->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($module->id_module->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $module;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = 0;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$module->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $module->id_module->CurrentValue;

					// Add filter for this record
					$sFilter = $module->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$module->CurrentFilter = $sWrkFilter;
			$sSql = $module->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->setMessage($Language->Phrase("InsertSuccess")); // Set insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($addcnt == 0) { // No record inserted
				$this->setMessage($Language->Phrase("NoAddRecord"));
			} elseif ($this->getMessage() == "") {
				$this->setMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$module->EventCancelled = TRUE; // Set event cancelled
			$module->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
	}

	// Check if empty row
	function EmptyRow() {
		global $module;
		if ($module->root_module->CurrentValue <> $module->root_module->OldValue)
			return FALSE;
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $module;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($module->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($module->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($module->id_module->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $module;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $module->root_module, $Keyword);
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
		global $Security, $module;
		$sSearchStr = "";
		$sSearchKeyword = $module->BasicSearchKeyword;
		$sSearchType = $module->BasicSearchType;
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
			$module->setSessionBasicSearchKeyword($sSearchKeyword);
			$module->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $module;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$module->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $module;
		$module->setSessionBasicSearchKeyword("");
		$module->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $module;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$module->BasicSearchKeyword = $module->getSessionBasicSearchKeyword();
			$module->BasicSearchType = $module->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $module;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$module->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$module->CurrentOrderType = @$_GET["ordertype"];
			$module->UpdateSort($module->root_module); // root_module
			$module->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $module;
		$sOrderBy = $module->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($module->SqlOrderBy() <> "") {
				$sOrderBy = $module->SqlOrderBy();
				$module->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $module;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$module->setSessionOrderBy($sOrderBy);
				$module->root_module->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$module->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $module;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "checkbox"
		$this->ListOptions->Add("checkbox");
		$item =& $this->ListOptions->Items["checkbox"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = True;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"module_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($module->Export <> "" ||
			$module->CurrentAction == "gridadd" ||
			$module->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $module;
		$this->ListOptions->LoadDefault();

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if (($module->CurrentAction == "add" || $module->CurrentAction == "copy") &&
			$module->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a href=\"\" onclick=\"f=document.fmodulelist;if(module_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($module->CurrentAction == "edit" && $module->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.fmodulelist;if(module_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewInlineLink\" href=\"" . $this->InlineEditUrl . "#" . $this->PageObjName . "_row_" . $this->lRowCnt . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a href=\"" . $this->InlineCopyUrl . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($module->id_module->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		if ($module->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $module->id_module->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $module;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $module;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$module->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$module->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $module->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$module->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$module->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$module->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $module;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $module;
		$module->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$module->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $module;
		$module->root_module->setFormValue($objForm->GetValue("x_root_module"));
		$module->root_module->setOldValue($objForm->GetValue("o_root_module"));
		$module->id_module->setFormValue($objForm->GetValue("x_id_module"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $module;
		$module->id_module->CurrentValue = $module->id_module->FormValue;
		$module->root_module->CurrentValue = $module->root_module->FormValue;
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
		$this->ViewUrl = $module->ViewUrl();
		$this->EditUrl = $module->EditUrl();
		$this->InlineEditUrl = $module->InlineEditUrl();
		$this->CopyUrl = $module->CopyUrl();
		$this->InlineCopyUrl = $module->InlineCopyUrl();
		$this->DeleteUrl = $module->DeleteUrl();

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
		} elseif ($module->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// root_module
			$module->root_module->EditCustomAttributes = "";
			$module->root_module->EditValue = ew_HtmlEncode($module->root_module->CurrentValue);

			// Edit refer script
			// root_module

			$module->root_module->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $module;
		$sFilter = $module->KeyFilter();
		$module->CurrentFilter = $sFilter;
		$sSql = $module->SQL();
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

			// root_module
			$module->root_module->SetDbValueDef($rsnew, $module->root_module->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $module->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($module->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($module->CancelMessage <> "") {
					$this->setMessage($module->CancelMessage);
					$module->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$module->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
