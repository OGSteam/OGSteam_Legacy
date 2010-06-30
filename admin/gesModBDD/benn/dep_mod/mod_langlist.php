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
$mod_lang_list = new cmod_lang_list();
$Page =& $mod_lang_list;

// Page init
$mod_lang_list->Page_Init();

// Page main
$mod_lang_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mod_lang->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mod_lang_list = new ew_Page("mod_lang_list");

// page properties
mod_lang_list.PageID = "list"; // page ID
mod_lang_list.FormID = "fmod_langlist"; // form ID
var EW_PAGE_ID = mod_lang_list.PageID; // for backward compatibility

// extend page with ValidateForm function
mod_lang_list.ValidateForm = function(fobj) {
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
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Extend page with empty row check
mod_lang_list.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "id_module", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_lang", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mod_description", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
mod_lang_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_lang_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_lang_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_lang_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($mod_lang->Export == "") { ?>
<?php } ?>
<?php
if ($mod_lang->CurrentAction == "gridadd") {
	$mod_lang->CurrentFilter = "0=1";
	$mod_lang_list->lStartRec = 1;
	if ($mod_lang_list->lDisplayRecs <= 0)
		$mod_lang_list->lDisplayRecs = 20;
	$mod_lang_list->lTotalRecs = $mod_lang_list->lDisplayRecs;
	$mod_lang_list->lStopRec = $mod_lang_list->lDisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$mod_lang_list->lTotalRecs = $mod_lang->SelectRecordCount();
	} else {
		if ($rs = $mod_lang_list->LoadRecordset())
			$mod_lang_list->lTotalRecs = $rs->RecordCount();
	}
	$mod_lang_list->lStartRec = 1;
	if ($mod_lang_list->lDisplayRecs <= 0 || ($mod_lang->Export <> "" && $mod_lang->ExportAll)) // Display all records
		$mod_lang_list->lDisplayRecs = $mod_lang_list->lTotalRecs;
	if (!($mod_lang->Export <> "" && $mod_lang->ExportAll))
		$mod_lang_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $mod_lang_list->LoadRecordset($mod_lang_list->lStartRec-1, $mod_lang_list->lDisplayRecs);
}
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_lang->TableCaption() ?>
</span></p>
<?php if ($mod_lang->Export == "" && $mod_lang->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(mod_lang_list);" style="text-decoration: none;"><img id="mod_lang_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="mod_lang_list_SearchPanel">
<form name="fmod_langlistsrch" id="fmod_langlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="mod_lang">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($mod_lang->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $mod_lang_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($mod_lang->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($mod_lang->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($mod_lang->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_lang_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fmod_langlist" id="fmod_langlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="mod_lang">
<div id="gmp_mod_lang" class="ewGridMiddlePanel">
<?php if ($mod_lang_list->lTotalRecs > 0 || $mod_lang->CurrentAction == "add" || $mod_lang->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $mod_lang->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$mod_lang_list->RenderListOptions();

// Render list options (header, left)
$mod_lang_list->ListOptions->Render("header", "left");
?>
<?php if ($mod_lang->id_module->Visible) { // id_module ?>
	<?php if ($mod_lang->SortUrl($mod_lang->id_module) == "") { ?>
		<td><?php echo $mod_lang->id_module->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_lang->SortUrl($mod_lang->id_module) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_lang->id_module->FldCaption() ?></td><td style="width: 10px;"><?php if ($mod_lang->id_module->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_lang->id_module->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
	<?php if ($mod_lang->SortUrl($mod_lang->id_lang) == "") { ?>
		<td><?php echo $mod_lang->id_lang->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_lang->SortUrl($mod_lang->id_lang) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_lang->id_lang->FldCaption() ?></td><td style="width: 10px;"><?php if ($mod_lang->id_lang->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_lang->id_lang->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_lang->mod_name->Visible) { // mod_name ?>
	<?php if ($mod_lang->SortUrl($mod_lang->mod_name) == "") { ?>
		<td><?php echo $mod_lang->mod_name->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_lang->SortUrl($mod_lang->mod_name) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_lang->mod_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($mod_lang->mod_name->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_lang->mod_name->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_lang->mod_description->Visible) { // mod_description ?>
	<?php if ($mod_lang->SortUrl($mod_lang->mod_description) == "") { ?>
		<td><?php echo $mod_lang->mod_description->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_lang->SortUrl($mod_lang->mod_description) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_lang->mod_description->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($mod_lang->mod_description->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_lang->mod_description->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$mod_lang_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
	if ($mod_lang->CurrentAction == "add" || $mod_lang->CurrentAction == "copy") {
		$mod_lang_list->lRowIndex = 1;
		if ($mod_lang->CurrentAction == "copy" && !$mod_lang_list->LoadRow())
				$mod_lang->CurrentAction = "add";
		if ($mod_lang->CurrentAction == "add")
			$mod_lang_list->LoadDefaultValues();
		if ($mod_lang->EventCancelled) // Insert failed
			$mod_lang_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$mod_lang->CssClass = "ewTableEditRow";
		$mod_lang->CssStyle = "";
		$mod_lang->RowAttrs = array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
		$mod_lang->RowType = EW_ROWTYPE_ADD;

		// Render row
		$mod_lang_list->RenderRow();

		// Render list options
		$mod_lang_list->RenderListOptions();
?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$mod_lang_list->ListOptions->Render("body", "left");
?>
	<?php if ($mod_lang->id_module->Visible) { // id_module ?>
		<td>
<select id="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" title="<?php echo $mod_lang->id_module->FldTitle() ?>"<?php echo $mod_lang->id_module->EditAttributes() ?>>
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
if (@$emptywrk) $mod_lang->id_module->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="">
</td>
	<?php } ?>
	<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
		<td>
<select id="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" title="<?php echo $mod_lang->id_lang->FldTitle() ?>"<?php echo $mod_lang->id_lang->EditAttributes() ?>>
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
if (@$emptywrk) $mod_lang->id_lang->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_lang`, `country`, '' AS Disp2Fld FROM `lang`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `id_lang`";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="">
</td>
	<?php } ?>
	<?php if ($mod_lang->mod_name->Visible) { // mod_name ?>
		<td>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" title="<?php echo $mod_lang->mod_name->FldTitle() ?>" size="30" maxlength="45" value="<?php echo $mod_lang->mod_name->EditValue ?>"<?php echo $mod_lang->mod_name->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($mod_lang->mod_description->Visible) { // mod_description ?>
		<td>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" title="<?php echo $mod_lang->mod_description->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $mod_lang->mod_description->EditValue ?>"<?php echo $mod_lang->mod_description->EditAttributes() ?>>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mod_lang_list->ListOptions->Render("body", "right");
?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x<?php echo $mod_lang_list->lRowIndex ?>_id_module','x<?php echo $mod_lang_list->lRowIndex ?>_id_module',false],
['x<?php echo $mod_lang_list->lRowIndex ?>_id_lang','x<?php echo $mod_lang_list->lRowIndex ?>_id_lang',false]]);

//-->
</script>
	</tr>
<?php
}
?>
<?php
if ($mod_lang->ExportAll && $mod_lang->Export <> "") {
	$mod_lang_list->lStopRec = $mod_lang_list->lTotalRecs;
} else {
	$mod_lang_list->lStopRec = $mod_lang_list->lStartRec + $mod_lang_list->lDisplayRecs - 1; // Set the last record to display
}
$mod_lang_list->lRecCount = $mod_lang_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $mod_lang_list->lStartRec > 1)
		$rs->Move($mod_lang_list->lStartRec - 1);
}

// Initialize aggregate
$mod_lang->RowType = EW_ROWTYPE_AGGREGATEINIT;
$mod_lang_list->RenderRow();
$mod_lang_list->lRowCnt = 0;
$mod_lang_list->lEditRowCnt = 0;
if ($mod_lang->CurrentAction == "edit")
	$mod_lang_list->lRowIndex = 1;
if ($mod_lang->CurrentAction == "gridadd")
	$mod_lang_list->lRowIndex = 0;
if ($mod_lang->CurrentAction == "gridedit")
	$mod_lang_list->lRowIndex = 0;
while (($mod_lang->CurrentAction == "gridadd" || !$rs->EOF) &&
	$mod_lang_list->lRecCount < $mod_lang_list->lStopRec) {
	$mod_lang_list->lRecCount++;
	if (intval($mod_lang_list->lRecCount) >= intval($mod_lang_list->lStartRec)) {
		$mod_lang_list->lRowCnt++;
		if ($mod_lang->CurrentAction == "gridadd" || $mod_lang->CurrentAction == "gridedit")
			$mod_lang_list->lRowIndex++;

	// Init row class and style
	$mod_lang->CssClass = "";
	$mod_lang->CssStyle = "";
	$mod_lang->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($mod_lang->CurrentAction == "gridadd") {
		$mod_lang_list->LoadDefaultValues(); // Load default values
	} else {
		$mod_lang_list->LoadRowValues($rs); // Load row values
	}
	$mod_lang->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($mod_lang->CurrentAction == "gridadd") // Grid add
		$mod_lang->RowType = EW_ROWTYPE_ADD; // Render add
	if ($mod_lang->CurrentAction == "gridadd" && $mod_lang->EventCancelled) // Insert failed
		$mod_lang_list->RestoreCurrentRowFormValues($mod_lang_list->lRowIndex); // Restore form values
	if ($mod_lang->CurrentAction == "edit") {
		if ($mod_lang_list->CheckInlineEditKey() && $mod_lang_list->lEditRowCnt == 0) { // Inline edit
			$mod_lang->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($mod_lang->CurrentAction == "gridedit") { // Grid edit
		$mod_lang->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($mod_lang->RowType == EW_ROWTYPE_EDIT && $mod_lang->EventCancelled) { // Update failed
		if ($mod_lang->CurrentAction == "edit")
			$mod_lang_list->RestoreFormValues(); // Restore form values
		if ($mod_lang->CurrentAction == "gridedit")
			$mod_lang_list->RestoreCurrentRowFormValues($mod_lang_list->lRowIndex); // Restore form values
	}
	if ($mod_lang->RowType == EW_ROWTYPE_EDIT) // Edit row
		$mod_lang_list->lEditRowCnt++;
	if ($mod_lang->RowType == EW_ROWTYPE_ADD || $mod_lang->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$mod_lang->RowAttrs = array_merge($mod_lang->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$mod_lang->CssClass = "ewTableEditRow";
	}

	// Render row
	$mod_lang_list->RenderRow();

	// Render list options
	$mod_lang_list->RenderListOptions();
?>
	<tr<?php echo $mod_lang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$mod_lang_list->ListOptions->Render("body", "left");
?>
	<?php if ($mod_lang->id_module->Visible) { // id_module ?>
		<td<?php echo $mod_lang->id_module->CellAttributes() ?>>
<?php if ($mod_lang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" title="<?php echo $mod_lang->id_module->FldTitle() ?>"<?php echo $mod_lang->id_module->EditAttributes() ?>>
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
if (@$emptywrk) $mod_lang->id_module->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="">
<input type="hidden" name="o<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="o<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="<?php echo ew_HtmlEncode($mod_lang->id_module->OldValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $mod_lang->id_module->ViewAttributes() ?>><?php echo $mod_lang->id_module->EditValue ?></div><input type="hidden" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" id="x<?php echo $mod_lang_list->lRowIndex ?>_id_module" value="<?php echo ew_HtmlEncode($mod_lang->id_module->CurrentValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_lang->id_module->ViewAttributes() ?>><?php echo $mod_lang->id_module->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_lang->id_lang->Visible) { // id_lang ?>
		<td<?php echo $mod_lang->id_lang->CellAttributes() ?>>
<?php if ($mod_lang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" title="<?php echo $mod_lang->id_lang->FldTitle() ?>"<?php echo $mod_lang->id_lang->EditAttributes() ?>>
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
if (@$emptywrk) $mod_lang->id_lang->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_lang`, `country`, '' AS Disp2Fld FROM `lang`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `id_lang`";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="s_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="lft_x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="">
<input type="hidden" name="o<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="o<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="<?php echo ew_HtmlEncode($mod_lang->id_lang->OldValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $mod_lang->id_lang->ViewAttributes() ?>><?php echo $mod_lang->id_lang->EditValue ?></div><input type="hidden" name="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" id="x<?php echo $mod_lang_list->lRowIndex ?>_id_lang" value="<?php echo ew_HtmlEncode($mod_lang->id_lang->CurrentValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_lang->id_lang->ViewAttributes() ?>><?php echo $mod_lang->id_lang->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_lang->mod_name->Visible) { // mod_name ?>
		<td<?php echo $mod_lang->mod_name->CellAttributes() ?>>
<?php if ($mod_lang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" title="<?php echo $mod_lang->mod_name->FldTitle() ?>" size="30" maxlength="45" value="<?php echo $mod_lang->mod_name->EditValue ?>"<?php echo $mod_lang->mod_name->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $mod_lang_list->lRowIndex ?>_mod_name" id="o<?php echo $mod_lang_list->lRowIndex ?>_mod_name" value="<?php echo ew_HtmlEncode($mod_lang->mod_name->OldValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_name" title="<?php echo $mod_lang->mod_name->FldTitle() ?>" size="30" maxlength="45" value="<?php echo $mod_lang->mod_name->EditValue ?>"<?php echo $mod_lang->mod_name->EditAttributes() ?>>
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_lang->mod_name->ViewAttributes() ?>><?php echo $mod_lang->mod_name->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_lang->mod_description->Visible) { // mod_description ?>
		<td<?php echo $mod_lang->mod_description->CellAttributes() ?>>
<?php if ($mod_lang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" title="<?php echo $mod_lang->mod_description->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $mod_lang->mod_description->EditValue ?>"<?php echo $mod_lang->mod_description->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $mod_lang_list->lRowIndex ?>_mod_description" id="o<?php echo $mod_lang_list->lRowIndex ?>_mod_description" value="<?php echo ew_HtmlEncode($mod_lang->mod_description->OldValue) ?>">
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" id="x<?php echo $mod_lang_list->lRowIndex ?>_mod_description" title="<?php echo $mod_lang->mod_description->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $mod_lang->mod_description->EditValue ?>"<?php echo $mod_lang->mod_description->EditAttributes() ?>>
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_lang->mod_description->ViewAttributes() ?>><?php echo $mod_lang->mod_description->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mod_lang_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($mod_lang->RowType == EW_ROWTYPE_ADD) { ?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x<?php echo $mod_lang_list->lRowIndex ?>_id_module','x<?php echo $mod_lang_list->lRowIndex ?>_id_module',false],
['x<?php echo $mod_lang_list->lRowIndex ?>_id_lang','x<?php echo $mod_lang_list->lRowIndex ?>_id_lang',false]]);

//-->
</script>
<?php } ?>
<?php if ($mod_lang->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($mod_lang->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($mod_lang->CurrentAction == "add" || $mod_lang->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_lang_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_lang->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_lang_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_lang->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_lang_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_lang->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_lang_list->lRowIndex ?>">
<?php echo $mod_lang_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($mod_lang->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($mod_lang->CurrentAction <> "gridadd" && $mod_lang->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($mod_lang_list->Pager)) $mod_lang_list->Pager = new cPrevNextPager($mod_lang_list->lStartRec, $mod_lang_list->lDisplayRecs, $mod_lang_list->lTotalRecs) ?>
<?php if ($mod_lang_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($mod_lang_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $mod_lang_list->PageUrl() ?>start=<?php echo $mod_lang_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($mod_lang_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $mod_lang_list->PageUrl() ?>start=<?php echo $mod_lang_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $mod_lang_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($mod_lang_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $mod_lang_list->PageUrl() ?>start=<?php echo $mod_lang_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($mod_lang_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $mod_lang_list->PageUrl() ?>start=<?php echo $mod_lang_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $mod_lang_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $mod_lang_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $mod_lang_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $mod_lang_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($mod_lang_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($mod_lang_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($mod_lang->CurrentAction <> "gridadd" && $mod_lang->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<a href="<?php echo $mod_lang_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_lang_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_lang_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php if ($mod_lang_list->lTotalRecs > 0) { ?>
<a href="<?php echo $mod_lang_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($mod_lang_list->lTotalRecs > 0) { ?>
<a href="" onclick="ew_SubmitSelected(document.fmod_langlist, '<?php echo $mod_lang_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($mod_lang->CurrentAction == "gridadd") { ?>
<a href="" onclick="f=document.fmod_langlist;if(mod_lang_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridInsertLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_lang_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($mod_lang->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.fmod_langlist;if(mod_lang_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_lang_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($mod_lang->Export == "" && $mod_lang->CurrentAction == "") { ?>
<?php } ?>
<?php if ($mod_lang->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$mod_lang_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_lang_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'mod_lang';

	// Page object name
	var $PageObjName = 'mod_lang_list';

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
	function cmod_lang_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_lang)
		$GLOBALS["mod_lang"] = new cmod_lang();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["mod_lang"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "mod_langdelete.php";
		$this->MultiUpdateUrl = "mod_langupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mod_lang', TRUE);

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
		global $mod_lang;

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$mod_lang->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$mod_lang->Export = $_POST["exporttype"];
		} else {
			$mod_lang->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $mod_lang->Export; // Get export parameter, used in header
		$gsExportFile = $mod_lang->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $mod_lang;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$mod_lang->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($mod_lang->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($mod_lang->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($mod_lang->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($mod_lang->CurrentAction == "add" || $mod_lang->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($mod_lang->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$mod_lang->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($mod_lang->CurrentAction == "gridupdate" || $mod_lang->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($mod_lang->CurrentAction == "update" || $mod_lang->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($mod_lang->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($mod_lang->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd")
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
			$mod_lang->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($mod_lang->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $mod_lang->getRecordsPerPage(); // Restore from Session
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
		$mod_lang->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$mod_lang->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$mod_lang->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $mod_lang->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$mod_lang->setSessionWhere($sFilter);
		$mod_lang->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $mod_lang;
		$mod_lang->setKey("id_module", ""); // Clear inline edit key
		$mod_lang->setKey("id_lang", ""); // Clear inline edit key
		$mod_lang->CurrentAction = ""; // Clear action
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
		global $Security, $mod_lang;
		$bInlineEdit = TRUE;
		if (@$_GET["id_module"] <> "") {
			$mod_lang->id_module->setQueryStringValue($_GET["id_module"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (@$_GET["id_lang"] <> "") {
			$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$mod_lang->setKey("id_module", $mod_lang->id_module->CurrentValue); // Set up inline edit key
				$mod_lang->setKey("id_lang", $mod_lang->id_lang->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $mod_lang;
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
				$mod_lang->SendEmail = TRUE; // Send email on update success
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
			$mod_lang->EventCancelled = TRUE; // Cancel event
			$mod_lang->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $mod_lang;

		//CheckInlineEditKey = True
		if (strval($mod_lang->getKey("id_module")) <> strval($mod_lang->id_module->CurrentValue))
			return FALSE;
		if (strval($mod_lang->getKey("id_lang")) <> strval($mod_lang->id_lang->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $mod_lang;
		if ($mod_lang->CurrentAction == "copy") {
			if (@$_GET["id_lang"] <> "") {
				$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
			} else {
				$mod_lang->CurrentAction = "add";
			}
			if (@$_GET["id_lang"] <> "") {
				$mod_lang->id_lang->setQueryStringValue($_GET["id_lang"]);
			} else {
				$mod_lang->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError, $mod_lang;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$mod_lang->EventCancelled = TRUE; // Set event cancelled
			$mod_lang->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$mod_lang->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage($Language->Phrase("AddSuccess")); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$mod_lang->EventCancelled = TRUE; // Set event cancelled
			$mod_lang->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $mod_lang;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$mod_lang->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $mod_lang->SQL();
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
					$mod_lang->SendEmail = FALSE; // Do not send email on update success
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
			$mod_lang->EventCancelled = TRUE; // Set event cancelled
			$mod_lang->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $mod_lang;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $mod_lang->KeyFilter();
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
		global $mod_lang;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 2) {
			$mod_lang->id_module->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($mod_lang->id_module->FormValue))
				return FALSE;
			$mod_lang->id_lang->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($mod_lang->id_lang->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $mod_lang;
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
				$mod_lang->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $mod_lang->id_module->CurrentValue;
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $mod_lang->id_lang->CurrentValue;

					// Add filter for this record
					$sFilter = $mod_lang->KeyFilter();
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
			$mod_lang->CurrentFilter = $sWrkFilter;
			$sSql = $mod_lang->SQL();
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
			$mod_lang->EventCancelled = TRUE; // Set event cancelled
			$mod_lang->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
	}

	// Check if empty row
	function EmptyRow() {
		global $mod_lang;
		if ($mod_lang->id_module->CurrentValue <> $mod_lang->id_module->OldValue)
			return FALSE;
		if ($mod_lang->id_lang->CurrentValue <> $mod_lang->id_lang->OldValue)
			return FALSE;
		if ($mod_lang->mod_name->CurrentValue <> $mod_lang->mod_name->OldValue)
			return FALSE;
		if ($mod_lang->mod_description->CurrentValue <> $mod_lang->mod_description->OldValue)
			return FALSE;
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $mod_lang;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($mod_lang->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($mod_lang->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 2) {
				if (strval($arrKeyFlds[0]) == strval($mod_lang->id_module->CurrentValue) && 
				strval($arrKeyFlds[1]) == strval($mod_lang->id_lang->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $mod_lang;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_lang->id_module, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_lang->id_lang, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $mod_lang->mod_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $mod_lang->mod_description, $Keyword);
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
		global $Security, $mod_lang;
		$sSearchStr = "";
		$sSearchKeyword = $mod_lang->BasicSearchKeyword;
		$sSearchType = $mod_lang->BasicSearchType;
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
			$mod_lang->setSessionBasicSearchKeyword($sSearchKeyword);
			$mod_lang->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $mod_lang;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$mod_lang->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $mod_lang;
		$mod_lang->setSessionBasicSearchKeyword("");
		$mod_lang->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $mod_lang;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$mod_lang->BasicSearchKeyword = $mod_lang->getSessionBasicSearchKeyword();
			$mod_lang->BasicSearchType = $mod_lang->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $mod_lang;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$mod_lang->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$mod_lang->CurrentOrderType = @$_GET["ordertype"];
			$mod_lang->UpdateSort($mod_lang->id_module); // id_module
			$mod_lang->UpdateSort($mod_lang->id_lang); // id_lang
			$mod_lang->UpdateSort($mod_lang->mod_name); // mod_name
			$mod_lang->UpdateSort($mod_lang->mod_description); // mod_description
			$mod_lang->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $mod_lang;
		$sOrderBy = $mod_lang->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($mod_lang->SqlOrderBy() <> "") {
				$sOrderBy = $mod_lang->SqlOrderBy();
				$mod_lang->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $mod_lang;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$mod_lang->setSessionOrderBy($sOrderBy);
				$mod_lang->setSessionOrderByList($sOrderBy);
				$mod_lang->id_module->setSort("");
				$mod_lang->id_lang->setSort("");
				$mod_lang->mod_name->setSort("");
				$mod_lang->mod_description->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$mod_lang->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $mod_lang;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"mod_lang_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($mod_lang->Export <> "" ||
			$mod_lang->CurrentAction == "gridadd" ||
			$mod_lang->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $mod_lang;
		$this->ListOptions->LoadDefault();

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if (($mod_lang->CurrentAction == "add" || $mod_lang->CurrentAction == "copy") &&
			$mod_lang->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a href=\"\" onclick=\"f=document.fmod_langlist;if(mod_lang_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($mod_lang->CurrentAction == "edit" && $mod_lang->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.fmod_langlist;if(mod_lang_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
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
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($mod_lang->id_module->CurrentValue . EW_COMPOSITE_KEY_SEPARATOR . $mod_lang->id_lang->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		if ($mod_lang->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $mod_lang->id_module->CurrentValue . EW_COMPOSITE_KEY_SEPARATOR . $mod_lang->id_lang->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $mod_lang;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $mod_lang;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mod_lang->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mod_lang->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mod_lang->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mod_lang->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mod_lang->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mod_lang->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $mod_lang;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $mod_lang;
		$mod_lang->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$mod_lang->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $mod_lang;
		$mod_lang->id_module->setFormValue($objForm->GetValue("x_id_module"));
		$mod_lang->id_module->setOldValue($objForm->GetValue("o_id_module"));
		$mod_lang->id_lang->setFormValue($objForm->GetValue("x_id_lang"));
		$mod_lang->id_lang->setOldValue($objForm->GetValue("o_id_lang"));
		$mod_lang->mod_name->setFormValue($objForm->GetValue("x_mod_name"));
		$mod_lang->mod_name->setOldValue($objForm->GetValue("o_mod_name"));
		$mod_lang->mod_description->setFormValue($objForm->GetValue("x_mod_description"));
		$mod_lang->mod_description->setOldValue($objForm->GetValue("o_mod_description"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $mod_lang;
		$mod_lang->id_module->CurrentValue = $mod_lang->id_module->FormValue;
		$mod_lang->id_lang->CurrentValue = $mod_lang->id_lang->FormValue;
		$mod_lang->mod_name->CurrentValue = $mod_lang->mod_name->FormValue;
		$mod_lang->mod_description->CurrentValue = $mod_lang->mod_description->FormValue;
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
		$this->ViewUrl = $mod_lang->ViewUrl();
		$this->EditUrl = $mod_lang->EditUrl();
		$this->InlineEditUrl = $mod_lang->InlineEditUrl();
		$this->CopyUrl = $mod_lang->CopyUrl();
		$this->InlineCopyUrl = $mod_lang->InlineCopyUrl();
		$this->DeleteUrl = $mod_lang->DeleteUrl();

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
