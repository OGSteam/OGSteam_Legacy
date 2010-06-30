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
$ogspy_version_list = new cogspy_version_list();
$Page =& $ogspy_version_list;

// Page init
$ogspy_version_list->Page_Init();

// Page main
$ogspy_version_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($ogspy_version->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var ogspy_version_list = new ew_Page("ogspy_version_list");

// page properties
ogspy_version_list.PageID = "list"; // page ID
ogspy_version_list.FormID = "fogspy_versionlist"; // form ID
var EW_PAGE_ID = ogspy_version_list.PageID; // for backward compatibility

// extend page with ValidateForm function
ogspy_version_list.ValidateForm = function(fobj) {
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
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Extend page with empty row check
ogspy_version_list.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "version", false)) return false;
	if (ew_ValueChanged(fobj, infix, "major", false)) return false;
	if (ew_ValueChanged(fobj, infix, "minor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "v", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
ogspy_version_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
ogspy_version_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
ogspy_version_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
ogspy_version_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($ogspy_version->Export == "") { ?>
<?php } ?>
<?php
if ($ogspy_version->CurrentAction == "gridadd") {
	$ogspy_version->CurrentFilter = "0=1";
	$ogspy_version_list->lStartRec = 1;
	if ($ogspy_version_list->lDisplayRecs <= 0)
		$ogspy_version_list->lDisplayRecs = 20;
	$ogspy_version_list->lTotalRecs = $ogspy_version_list->lDisplayRecs;
	$ogspy_version_list->lStopRec = $ogspy_version_list->lDisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$ogspy_version_list->lTotalRecs = $ogspy_version->SelectRecordCount();
	} else {
		if ($rs = $ogspy_version_list->LoadRecordset())
			$ogspy_version_list->lTotalRecs = $rs->RecordCount();
	}
	$ogspy_version_list->lStartRec = 1;
	if ($ogspy_version_list->lDisplayRecs <= 0 || ($ogspy_version->Export <> "" && $ogspy_version->ExportAll)) // Display all records
		$ogspy_version_list->lDisplayRecs = $ogspy_version_list->lTotalRecs;
	if (!($ogspy_version->Export <> "" && $ogspy_version->ExportAll))
		$ogspy_version_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $ogspy_version_list->LoadRecordset($ogspy_version_list->lStartRec-1, $ogspy_version_list->lDisplayRecs);
}
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ogspy_version->TableCaption() ?>
</span></p>
<?php if ($ogspy_version->Export == "" && $ogspy_version->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(ogspy_version_list);" style="text-decoration: none;"><img id="ogspy_version_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="ogspy_version_list_SearchPanel">
<form name="fogspy_versionlistsrch" id="fogspy_versionlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="ogspy_version">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($ogspy_version->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $ogspy_version_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($ogspy_version->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($ogspy_version->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($ogspy_version->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$ogspy_version_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fogspy_versionlist" id="fogspy_versionlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="ogspy_version">
<div id="gmp_ogspy_version" class="ewGridMiddlePanel">
<?php if ($ogspy_version_list->lTotalRecs > 0 || $ogspy_version->CurrentAction == "add" || $ogspy_version->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $ogspy_version->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$ogspy_version_list->RenderListOptions();

// Render list options (header, left)
$ogspy_version_list->ListOptions->Render("header", "left");
?>
<?php if ($ogspy_version->version->Visible) { // version ?>
	<?php if ($ogspy_version->SortUrl($ogspy_version->version) == "") { ?>
		<td><?php echo $ogspy_version->version->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ogspy_version->SortUrl($ogspy_version->version) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ogspy_version->version->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($ogspy_version->version->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ogspy_version->version->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ogspy_version->major->Visible) { // major ?>
	<?php if ($ogspy_version->SortUrl($ogspy_version->major) == "") { ?>
		<td><?php echo $ogspy_version->major->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ogspy_version->SortUrl($ogspy_version->major) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ogspy_version->major->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($ogspy_version->major->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ogspy_version->major->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ogspy_version->minor->Visible) { // minor ?>
	<?php if ($ogspy_version->SortUrl($ogspy_version->minor) == "") { ?>
		<td><?php echo $ogspy_version->minor->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ogspy_version->SortUrl($ogspy_version->minor) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ogspy_version->minor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($ogspy_version->minor->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ogspy_version->minor->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ogspy_version->status->Visible) { // status ?>
	<?php if ($ogspy_version->SortUrl($ogspy_version->status) == "") { ?>
		<td><?php echo $ogspy_version->status->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ogspy_version->SortUrl($ogspy_version->status) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ogspy_version->status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($ogspy_version->status->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ogspy_version->status->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($ogspy_version->v->Visible) { // v ?>
	<?php if ($ogspy_version->SortUrl($ogspy_version->v) == "") { ?>
		<td><?php echo $ogspy_version->v->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $ogspy_version->SortUrl($ogspy_version->v) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $ogspy_version->v->FldCaption() ?></td><td style="width: 10px;"><?php if ($ogspy_version->v->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($ogspy_version->v->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$ogspy_version_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
	if ($ogspy_version->CurrentAction == "add" || $ogspy_version->CurrentAction == "copy") {
		$ogspy_version_list->lRowIndex = 1;
		if ($ogspy_version->CurrentAction == "copy" && !$ogspy_version_list->LoadRow())
				$ogspy_version->CurrentAction = "add";
		if ($ogspy_version->CurrentAction == "add")
			$ogspy_version_list->LoadDefaultValues();
		if ($ogspy_version->EventCancelled) // Insert failed
			$ogspy_version_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$ogspy_version->CssClass = "ewTableEditRow";
		$ogspy_version->CssStyle = "";
		$ogspy_version->RowAttrs = array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
		$ogspy_version->RowType = EW_ROWTYPE_ADD;

		// Render row
		$ogspy_version_list->RenderRow();

		// Render list options
		$ogspy_version_list->RenderListOptions();
?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ogspy_version_list->ListOptions->Render("body", "left");
?>
	<?php if ($ogspy_version->version->Visible) { // version ?>
		<td>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_version" id="x<?php echo $ogspy_version_list->lRowIndex ?>_version" title="<?php echo $ogspy_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $ogspy_version->version->EditValue ?>"<?php echo $ogspy_version->version->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($ogspy_version->major->Visible) { // major ?>
		<td>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_major" id="x<?php echo $ogspy_version_list->lRowIndex ?>_major" title="<?php echo $ogspy_version->major->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->major->EditValue ?>"<?php echo $ogspy_version->major->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($ogspy_version->minor->Visible) { // minor ?>
		<td>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" id="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" title="<?php echo $ogspy_version->minor->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->minor->EditValue ?>"<?php echo $ogspy_version->minor->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($ogspy_version->status->Visible) { // status ?>
		<td>
<div id="tp_x<?php echo $ogspy_version_list->lRowIndex ?>_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="{value}"<?php echo $ogspy_version->status->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $ogspy_version_list->lRowIndex ?>_status" repeatcolumn="5">
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
<label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ogspy_version->status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $ogspy_version->status->OldValue = "";
?>
</div>
</td>
	<?php } ?>
	<?php if ($ogspy_version->v->Visible) { // v ?>
		<td>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_v" id="x<?php echo $ogspy_version_list->lRowIndex ?>_v" title="<?php echo $ogspy_version->v->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $ogspy_version->v->EditValue ?>"<?php echo $ogspy_version->v->EditAttributes() ?>>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ogspy_version_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
}
?>
<?php
if ($ogspy_version->ExportAll && $ogspy_version->Export <> "") {
	$ogspy_version_list->lStopRec = $ogspy_version_list->lTotalRecs;
} else {
	$ogspy_version_list->lStopRec = $ogspy_version_list->lStartRec + $ogspy_version_list->lDisplayRecs - 1; // Set the last record to display
}
$ogspy_version_list->lRecCount = $ogspy_version_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $ogspy_version_list->lStartRec > 1)
		$rs->Move($ogspy_version_list->lStartRec - 1);
}

// Initialize aggregate
$ogspy_version->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ogspy_version_list->RenderRow();
$ogspy_version_list->lRowCnt = 0;
$ogspy_version_list->lEditRowCnt = 0;
if ($ogspy_version->CurrentAction == "edit")
	$ogspy_version_list->lRowIndex = 1;
if ($ogspy_version->CurrentAction == "gridadd")
	$ogspy_version_list->lRowIndex = 0;
if ($ogspy_version->CurrentAction == "gridedit")
	$ogspy_version_list->lRowIndex = 0;
while (($ogspy_version->CurrentAction == "gridadd" || !$rs->EOF) &&
	$ogspy_version_list->lRecCount < $ogspy_version_list->lStopRec) {
	$ogspy_version_list->lRecCount++;
	if (intval($ogspy_version_list->lRecCount) >= intval($ogspy_version_list->lStartRec)) {
		$ogspy_version_list->lRowCnt++;
		if ($ogspy_version->CurrentAction == "gridadd" || $ogspy_version->CurrentAction == "gridedit")
			$ogspy_version_list->lRowIndex++;

	// Init row class and style
	$ogspy_version->CssClass = "";
	$ogspy_version->CssStyle = "";
	$ogspy_version->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($ogspy_version->CurrentAction == "gridadd") {
		$ogspy_version_list->LoadDefaultValues(); // Load default values
	} else {
		$ogspy_version_list->LoadRowValues($rs); // Load row values
	}
	$ogspy_version->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($ogspy_version->CurrentAction == "gridadd") // Grid add
		$ogspy_version->RowType = EW_ROWTYPE_ADD; // Render add
	if ($ogspy_version->CurrentAction == "gridadd" && $ogspy_version->EventCancelled) // Insert failed
		$ogspy_version_list->RestoreCurrentRowFormValues($ogspy_version_list->lRowIndex); // Restore form values
	if ($ogspy_version->CurrentAction == "edit") {
		if ($ogspy_version_list->CheckInlineEditKey() && $ogspy_version_list->lEditRowCnt == 0) { // Inline edit
			$ogspy_version->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($ogspy_version->CurrentAction == "gridedit") { // Grid edit
		$ogspy_version->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($ogspy_version->RowType == EW_ROWTYPE_EDIT && $ogspy_version->EventCancelled) { // Update failed
		if ($ogspy_version->CurrentAction == "edit")
			$ogspy_version_list->RestoreFormValues(); // Restore form values
		if ($ogspy_version->CurrentAction == "gridedit")
			$ogspy_version_list->RestoreCurrentRowFormValues($ogspy_version_list->lRowIndex); // Restore form values
	}
	if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) // Edit row
		$ogspy_version_list->lEditRowCnt++;
	if ($ogspy_version->RowType == EW_ROWTYPE_ADD || $ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$ogspy_version->RowAttrs = array_merge($ogspy_version->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$ogspy_version->CssClass = "ewTableEditRow";
	}

	// Render row
	$ogspy_version_list->RenderRow();

	// Render list options
	$ogspy_version_list->RenderListOptions();
?>
	<tr<?php echo $ogspy_version->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ogspy_version_list->ListOptions->Render("body", "left");
?>
	<?php if ($ogspy_version->version->Visible) { // version ?>
		<td<?php echo $ogspy_version->version->CellAttributes() ?>>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_version" id="x<?php echo $ogspy_version_list->lRowIndex ?>_version" title="<?php echo $ogspy_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $ogspy_version->version->EditValue ?>"<?php echo $ogspy_version->version->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_version" id="o<?php echo $ogspy_version_list->lRowIndex ?>_version" value="<?php echo ew_HtmlEncode($ogspy_version->version->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_version" id="x<?php echo $ogspy_version_list->lRowIndex ?>_version" title="<?php echo $ogspy_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $ogspy_version->version->EditValue ?>"<?php echo $ogspy_version->version->EditAttributes() ?>>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $ogspy_version->version->ViewAttributes() ?>><?php echo $ogspy_version->version->ListViewValue() ?></div>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_id_ogspy_version" id="o<?php echo $ogspy_version_list->lRowIndex ?>_id_ogspy_version" value="<?php echo ew_HtmlEncode($ogspy_version->id_ogspy_version->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { ?>
<input type="hidden" name="x<?php echo $ogspy_version_list->lRowIndex ?>_id_ogspy_version" id="x<?php echo $ogspy_version_list->lRowIndex ?>_id_ogspy_version" value="<?php echo ew_HtmlEncode($ogspy_version->id_ogspy_version->CurrentValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($ogspy_version->major->Visible) { // major ?>
		<td<?php echo $ogspy_version->major->CellAttributes() ?>>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_major" id="x<?php echo $ogspy_version_list->lRowIndex ?>_major" title="<?php echo $ogspy_version->major->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->major->EditValue ?>"<?php echo $ogspy_version->major->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_major" id="o<?php echo $ogspy_version_list->lRowIndex ?>_major" value="<?php echo ew_HtmlEncode($ogspy_version->major->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_major" id="x<?php echo $ogspy_version_list->lRowIndex ?>_major" title="<?php echo $ogspy_version->major->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->major->EditValue ?>"<?php echo $ogspy_version->major->EditAttributes() ?>>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $ogspy_version->major->ViewAttributes() ?>><?php echo $ogspy_version->major->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($ogspy_version->minor->Visible) { // minor ?>
		<td<?php echo $ogspy_version->minor->CellAttributes() ?>>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" id="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" title="<?php echo $ogspy_version->minor->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->minor->EditValue ?>"<?php echo $ogspy_version->minor->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_minor" id="o<?php echo $ogspy_version_list->lRowIndex ?>_minor" value="<?php echo ew_HtmlEncode($ogspy_version->minor->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" id="x<?php echo $ogspy_version_list->lRowIndex ?>_minor" title="<?php echo $ogspy_version->minor->FldTitle() ?>" size="30" value="<?php echo $ogspy_version->minor->EditValue ?>"<?php echo $ogspy_version->minor->EditAttributes() ?>>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $ogspy_version->minor->ViewAttributes() ?>><?php echo $ogspy_version->minor->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($ogspy_version->status->Visible) { // status ?>
		<td<?php echo $ogspy_version->status->CellAttributes() ?>>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<div id="tp_x<?php echo $ogspy_version_list->lRowIndex ?>_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="{value}"<?php echo $ogspy_version->status->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $ogspy_version_list->lRowIndex ?>_status" repeatcolumn="5">
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
<label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ogspy_version->status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $ogspy_version->status->OldValue = "";
?>
</div>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_status" id="o<?php echo $ogspy_version_list->lRowIndex ?>_status" value="<?php echo ew_HtmlEncode($ogspy_version->status->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $ogspy_version_list->lRowIndex ?>_status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="{value}"<?php echo $ogspy_version->status->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $ogspy_version_list->lRowIndex ?>_status" repeatcolumn="5">
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
<label><input type="radio" name="x<?php echo $ogspy_version_list->lRowIndex ?>_status" id="x<?php echo $ogspy_version_list->lRowIndex ?>_status" title="<?php echo $ogspy_version->status->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ogspy_version->status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $ogspy_version->status->OldValue = "";
?>
</div>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $ogspy_version->status->ViewAttributes() ?>><?php echo $ogspy_version->status->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($ogspy_version->v->Visible) { // v ?>
		<td<?php echo $ogspy_version->v->CellAttributes() ?>>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $ogspy_version_list->lRowIndex ?>_v" id="x<?php echo $ogspy_version_list->lRowIndex ?>_v" title="<?php echo $ogspy_version->v->FldTitle() ?>" size="30" maxlength="20" value="<?php echo $ogspy_version->v->EditValue ?>"<?php echo $ogspy_version->v->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $ogspy_version_list->lRowIndex ?>_v" id="o<?php echo $ogspy_version_list->lRowIndex ?>_v" value="<?php echo ew_HtmlEncode($ogspy_version->v->OldValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="hidden" name="x<?php echo $ogspy_version_list->lRowIndex ?>_v" id="x<?php echo $ogspy_version_list->lRowIndex ?>_v" value="<?php echo ew_HtmlEncode($ogspy_version->v->CurrentValue) ?>">
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $ogspy_version->v->ViewAttributes() ?>><?php echo $ogspy_version->v->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ogspy_version_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_ADD) { ?>
<?php } ?>
<?php if ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($ogspy_version->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ogspy_version->CurrentAction == "add" || $ogspy_version->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ogspy_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($ogspy_version->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ogspy_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($ogspy_version->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ogspy_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($ogspy_version->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $ogspy_version_list->lRowIndex ?>">
<?php echo $ogspy_version_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($ogspy_version->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($ogspy_version->CurrentAction <> "gridadd" && $ogspy_version->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($ogspy_version_list->Pager)) $ogspy_version_list->Pager = new cPrevNextPager($ogspy_version_list->lStartRec, $ogspy_version_list->lDisplayRecs, $ogspy_version_list->lTotalRecs) ?>
<?php if ($ogspy_version_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($ogspy_version_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $ogspy_version_list->PageUrl() ?>start=<?php echo $ogspy_version_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($ogspy_version_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $ogspy_version_list->PageUrl() ?>start=<?php echo $ogspy_version_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ogspy_version_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($ogspy_version_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $ogspy_version_list->PageUrl() ?>start=<?php echo $ogspy_version_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($ogspy_version_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $ogspy_version_list->PageUrl() ?>start=<?php echo $ogspy_version_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ogspy_version_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ogspy_version_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ogspy_version_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ogspy_version_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($ogspy_version_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($ogspy_version_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($ogspy_version->CurrentAction <> "gridadd" && $ogspy_version->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<a href="<?php echo $ogspy_version_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $ogspy_version_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $ogspy_version_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php if ($ogspy_version_list->lTotalRecs > 0) { ?>
<a href="<?php echo $ogspy_version_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($ogspy_version_list->lTotalRecs > 0) { ?>
<a href="" onclick="ew_SubmitSelected(document.fogspy_versionlist, '<?php echo $ogspy_version_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($ogspy_version->CurrentAction == "gridadd") { ?>
<a href="" onclick="f=document.fogspy_versionlist;if(ogspy_version_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridInsertLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $ogspy_version_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($ogspy_version->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.fogspy_versionlist;if(ogspy_version_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $ogspy_version_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($ogspy_version->Export == "" && $ogspy_version->CurrentAction == "") { ?>
<?php } ?>
<?php if ($ogspy_version->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$ogspy_version_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cogspy_version_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'ogspy_version';

	// Page object name
	var $PageObjName = 'ogspy_version_list';

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
	function cogspy_version_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (ogspy_version)
		$GLOBALS["ogspy_version"] = new cogspy_version();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["ogspy_version"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ogspy_versiondelete.php";
		$this->MultiUpdateUrl = "ogspy_versionupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ogspy_version', TRUE);

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
		global $ogspy_version;

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$ogspy_version->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$ogspy_version->Export = $_POST["exporttype"];
		} else {
			$ogspy_version->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $ogspy_version->Export; // Get export parameter, used in header
		$gsExportFile = $ogspy_version->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $ogspy_version;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$ogspy_version->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($ogspy_version->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($ogspy_version->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($ogspy_version->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($ogspy_version->CurrentAction == "add" || $ogspy_version->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($ogspy_version->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$ogspy_version->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($ogspy_version->CurrentAction == "gridupdate" || $ogspy_version->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($ogspy_version->CurrentAction == "update" || $ogspy_version->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($ogspy_version->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($ogspy_version->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd")
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
			$ogspy_version->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($ogspy_version->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $ogspy_version->getRecordsPerPage(); // Restore from Session
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
		$ogspy_version->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$ogspy_version->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$ogspy_version->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $ogspy_version->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$ogspy_version->setSessionWhere($sFilter);
		$ogspy_version->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $ogspy_version;
		$ogspy_version->setKey("id_ogspy_version", ""); // Clear inline edit key
		$ogspy_version->CurrentAction = ""; // Clear action
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
		global $Security, $ogspy_version;
		$bInlineEdit = TRUE;
		if (@$_GET["id_ogspy_version"] <> "") {
			$ogspy_version->id_ogspy_version->setQueryStringValue($_GET["id_ogspy_version"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$ogspy_version->setKey("id_ogspy_version", $ogspy_version->id_ogspy_version->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $ogspy_version;
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
				$ogspy_version->SendEmail = TRUE; // Send email on update success
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
			$ogspy_version->EventCancelled = TRUE; // Cancel event
			$ogspy_version->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $ogspy_version;

		//CheckInlineEditKey = True
		if (strval($ogspy_version->getKey("id_ogspy_version")) <> strval($ogspy_version->id_ogspy_version->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $ogspy_version;
		if ($ogspy_version->CurrentAction == "copy") {
			if (@$_GET["id_ogspy_version"] <> "") {
				$ogspy_version->id_ogspy_version->setQueryStringValue($_GET["id_ogspy_version"]);
			} else {
				$ogspy_version->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError, $ogspy_version;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$ogspy_version->EventCancelled = TRUE; // Set event cancelled
			$ogspy_version->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$ogspy_version->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage($Language->Phrase("AddSuccess")); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$ogspy_version->EventCancelled = TRUE; // Set event cancelled
			$ogspy_version->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $ogspy_version;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$ogspy_version->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $ogspy_version->SQL();
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
					$ogspy_version->SendEmail = FALSE; // Do not send email on update success
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
			$ogspy_version->EventCancelled = TRUE; // Set event cancelled
			$ogspy_version->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $ogspy_version;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $ogspy_version->KeyFilter();
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
		global $ogspy_version;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$ogspy_version->id_ogspy_version->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($ogspy_version->id_ogspy_version->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $ogspy_version;
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
				$ogspy_version->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $ogspy_version->id_ogspy_version->CurrentValue;

					// Add filter for this record
					$sFilter = $ogspy_version->KeyFilter();
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
			$ogspy_version->CurrentFilter = $sWrkFilter;
			$sSql = $ogspy_version->SQL();
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
			$ogspy_version->EventCancelled = TRUE; // Set event cancelled
			$ogspy_version->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
	}

	// Check if empty row
	function EmptyRow() {
		global $ogspy_version;
		if ($ogspy_version->version->CurrentValue <> $ogspy_version->version->OldValue)
			return FALSE;
		if ($ogspy_version->major->CurrentValue <> $ogspy_version->major->OldValue)
			return FALSE;
		if ($ogspy_version->minor->CurrentValue <> $ogspy_version->minor->OldValue)
			return FALSE;
		if ($ogspy_version->status->CurrentValue <> $ogspy_version->status->OldValue)
			return FALSE;
		if ($ogspy_version->v->CurrentValue <> $ogspy_version->v->OldValue)
			return FALSE;
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $ogspy_version;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($ogspy_version->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($ogspy_version->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($ogspy_version->id_ogspy_version->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $ogspy_version;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $ogspy_version->version, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $ogspy_version->major, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $ogspy_version->minor, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $ogspy_version->status, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $ogspy_version->v, $Keyword);
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
		global $Security, $ogspy_version;
		$sSearchStr = "";
		$sSearchKeyword = $ogspy_version->BasicSearchKeyword;
		$sSearchType = $ogspy_version->BasicSearchType;
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
			$ogspy_version->setSessionBasicSearchKeyword($sSearchKeyword);
			$ogspy_version->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $ogspy_version;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$ogspy_version->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $ogspy_version;
		$ogspy_version->setSessionBasicSearchKeyword("");
		$ogspy_version->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $ogspy_version;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$ogspy_version->BasicSearchKeyword = $ogspy_version->getSessionBasicSearchKeyword();
			$ogspy_version->BasicSearchType = $ogspy_version->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $ogspy_version;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$ogspy_version->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$ogspy_version->CurrentOrderType = @$_GET["ordertype"];
			$ogspy_version->UpdateSort($ogspy_version->version); // version
			$ogspy_version->UpdateSort($ogspy_version->major); // major
			$ogspy_version->UpdateSort($ogspy_version->minor); // minor
			$ogspy_version->UpdateSort($ogspy_version->status); // status
			$ogspy_version->UpdateSort($ogspy_version->v); // v
			$ogspy_version->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $ogspy_version;
		$sOrderBy = $ogspy_version->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($ogspy_version->SqlOrderBy() <> "") {
				$sOrderBy = $ogspy_version->SqlOrderBy();
				$ogspy_version->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $ogspy_version;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$ogspy_version->setSessionOrderBy($sOrderBy);
				$ogspy_version->version->setSort("");
				$ogspy_version->major->setSort("");
				$ogspy_version->minor->setSort("");
				$ogspy_version->status->setSort("");
				$ogspy_version->v->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $ogspy_version;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"ogspy_version_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($ogspy_version->Export <> "" ||
			$ogspy_version->CurrentAction == "gridadd" ||
			$ogspy_version->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $ogspy_version;
		$this->ListOptions->LoadDefault();

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if (($ogspy_version->CurrentAction == "add" || $ogspy_version->CurrentAction == "copy") &&
			$ogspy_version->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a href=\"\" onclick=\"f=document.fogspy_versionlist;if(ogspy_version_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($ogspy_version->CurrentAction == "edit" && $ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.fogspy_versionlist;if(ogspy_version_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($ogspy_version->id_ogspy_version->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		if ($ogspy_version->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $ogspy_version->id_ogspy_version->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $ogspy_version;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $ogspy_version;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$ogspy_version->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$ogspy_version->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $ogspy_version->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$ogspy_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $ogspy_version;
		$ogspy_version->status->CurrentValue = "build";
		$ogspy_version->status->OldValue = $ogspy_version->status->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $ogspy_version;
		$ogspy_version->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$ogspy_version->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $ogspy_version;
		$ogspy_version->version->setFormValue($objForm->GetValue("x_version"));
		$ogspy_version->version->setOldValue($objForm->GetValue("o_version"));
		$ogspy_version->major->setFormValue($objForm->GetValue("x_major"));
		$ogspy_version->major->setOldValue($objForm->GetValue("o_major"));
		$ogspy_version->minor->setFormValue($objForm->GetValue("x_minor"));
		$ogspy_version->minor->setOldValue($objForm->GetValue("o_minor"));
		$ogspy_version->status->setFormValue($objForm->GetValue("x_status"));
		$ogspy_version->status->setOldValue($objForm->GetValue("o_status"));
		$ogspy_version->v->setFormValue($objForm->GetValue("x_v"));
		$ogspy_version->v->setOldValue($objForm->GetValue("o_v"));
		$ogspy_version->id_ogspy_version->setFormValue($objForm->GetValue("x_id_ogspy_version"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $ogspy_version;
		$ogspy_version->id_ogspy_version->CurrentValue = $ogspy_version->id_ogspy_version->FormValue;
		$ogspy_version->version->CurrentValue = $ogspy_version->version->FormValue;
		$ogspy_version->major->CurrentValue = $ogspy_version->major->FormValue;
		$ogspy_version->minor->CurrentValue = $ogspy_version->minor->FormValue;
		$ogspy_version->status->CurrentValue = $ogspy_version->status->FormValue;
		$ogspy_version->v->CurrentValue = $ogspy_version->v->FormValue;
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
		$this->ViewUrl = $ogspy_version->ViewUrl();
		$this->EditUrl = $ogspy_version->EditUrl();
		$this->InlineEditUrl = $ogspy_version->InlineEditUrl();
		$this->CopyUrl = $ogspy_version->CopyUrl();
		$this->InlineCopyUrl = $ogspy_version->InlineCopyUrl();
		$this->DeleteUrl = $ogspy_version->DeleteUrl();

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
		} elseif ($ogspy_version->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$ogspy_version->v->EditValue = ew_HtmlEncode($ogspy_version->v->CurrentValue);
		} elseif ($ogspy_version->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $ogspy_version;
		$rsnew = array();

		// version
		$ogspy_version->version->SetDbValueDef($rsnew, $ogspy_version->version->CurrentValue, 0, FALSE);

		// major
		$ogspy_version->major->SetDbValueDef($rsnew, $ogspy_version->major->CurrentValue, 0, FALSE);

		// minor
		$ogspy_version->minor->SetDbValueDef($rsnew, $ogspy_version->minor->CurrentValue, 0, FALSE);

		// status
		$ogspy_version->status->SetDbValueDef($rsnew, $ogspy_version->status->CurrentValue, "", TRUE);

		// v
		$ogspy_version->v->SetDbValueDef($rsnew, $ogspy_version->v->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$bInsertRow = $ogspy_version->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($ogspy_version->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($ogspy_version->CancelMessage <> "") {
				$this->setMessage($ogspy_version->CancelMessage);
				$ogspy_version->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$ogspy_version->id_ogspy_version->setDbValue($conn->Insert_ID());
			$rsnew['id_ogspy_version'] = $ogspy_version->id_ogspy_version->DbValue;

			// Call Row Inserted event
			$ogspy_version->Row_Inserted($rsnew);
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
