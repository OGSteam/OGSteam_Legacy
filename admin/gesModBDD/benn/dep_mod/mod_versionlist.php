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
$mod_version_list = new cmod_version_list();
$Page =& $mod_version_list;

// Page init
$mod_version_list->Page_Init();

// Page main
$mod_version_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($mod_version->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var mod_version_list = new ew_Page("mod_version_list");

// page properties
mod_version_list.PageID = "list"; // page ID
mod_version_list.FormID = "fmod_versionlist"; // form ID
var EW_PAGE_ID = mod_version_list.PageID; // for backward compatibility

// extend page with ValidateForm function
mod_version_list.ValidateForm = function(fobj) {
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
		} // End Grid Add checking
	}
	if (fobj.a_list && fobj.a_list.value == "gridinsert" && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Extend page with empty row check
mod_version_list.EmptyRow = function(fobj, infix) {
	if (ew_ValueChanged(fobj, infix, "id_module", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_version_min", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_version_max", false)) return false;
	if (ew_ValueChanged(fobj, infix, "version", false)) return false;
	return true;
}

// extend page with Form_CustomValidate function
mod_version_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
mod_version_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
mod_version_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
mod_version_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($mod_version->Export == "") { ?>
<?php } ?>
<?php
if ($mod_version->CurrentAction == "gridadd") {
	$mod_version->CurrentFilter = "0=1";
	$mod_version_list->lStartRec = 1;
	if ($mod_version_list->lDisplayRecs <= 0)
		$mod_version_list->lDisplayRecs = 20;
	$mod_version_list->lTotalRecs = $mod_version_list->lDisplayRecs;
	$mod_version_list->lStopRec = $mod_version_list->lDisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$mod_version_list->lTotalRecs = $mod_version->SelectRecordCount();
	} else {
		if ($rs = $mod_version_list->LoadRecordset())
			$mod_version_list->lTotalRecs = $rs->RecordCount();
	}
	$mod_version_list->lStartRec = 1;
	if ($mod_version_list->lDisplayRecs <= 0 || ($mod_version->Export <> "" && $mod_version->ExportAll)) // Display all records
		$mod_version_list->lDisplayRecs = $mod_version_list->lTotalRecs;
	if (!($mod_version->Export <> "" && $mod_version->ExportAll))
		$mod_version_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $mod_version_list->LoadRecordset($mod_version_list->lStartRec-1, $mod_version_list->lDisplayRecs);
}
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $mod_version->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($mod_version->Export == "" && $mod_version->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(mod_version_list);" style="text-decoration: none;"><img id="mod_version_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="mod_version_list_SearchPanel">
<form name="fmod_versionlistsrch" id="fmod_versionlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="mod_version">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($mod_version->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $mod_version_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($mod_version->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($mod_version->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($mod_version->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$mod_version_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fmod_versionlist" id="fmod_versionlist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="mod_version">
<div id="gmp_mod_version" class="ewGridMiddlePanel">
<?php if ($mod_version_list->lTotalRecs > 0 || $mod_version->CurrentAction == "add" || $mod_version->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $mod_version->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$mod_version_list->RenderListOptions();

// Render list options (header, left)
$mod_version_list->ListOptions->Render("header", "left");
?>
<?php if ($mod_version->id_module->Visible) { // id_module ?>
	<?php if ($mod_version->SortUrl($mod_version->id_module) == "") { ?>
		<td><?php echo $mod_version->id_module->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_version->SortUrl($mod_version->id_module) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_version->id_module->FldCaption() ?></td><td style="width: 10px;"><?php if ($mod_version->id_module->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_version->id_module->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_version->id_version_min->Visible) { // id_version_min ?>
	<?php if ($mod_version->SortUrl($mod_version->id_version_min) == "") { ?>
		<td><?php echo $mod_version->id_version_min->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_version->SortUrl($mod_version->id_version_min) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_version->id_version_min->FldCaption() ?></td><td style="width: 10px;"><?php if ($mod_version->id_version_min->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_version->id_version_min->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_version->id_version_max->Visible) { // id_version_max ?>
	<?php if ($mod_version->SortUrl($mod_version->id_version_max) == "") { ?>
		<td><?php echo $mod_version->id_version_max->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_version->SortUrl($mod_version->id_version_max) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_version->id_version_max->FldCaption() ?></td><td style="width: 10px;"><?php if ($mod_version->id_version_max->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_version->id_version_max->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($mod_version->version->Visible) { // version ?>
	<?php if ($mod_version->SortUrl($mod_version->version) == "") { ?>
		<td><?php echo $mod_version->version->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $mod_version->SortUrl($mod_version->version) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $mod_version->version->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($mod_version->version->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($mod_version->version->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$mod_version_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
	if ($mod_version->CurrentAction == "add" || $mod_version->CurrentAction == "copy") {
		$mod_version_list->lRowIndex = 1;
		if ($mod_version->CurrentAction == "copy" && !$mod_version_list->LoadRow())
				$mod_version->CurrentAction = "add";
		if ($mod_version->CurrentAction == "add")
			$mod_version_list->LoadDefaultValues();
		if ($mod_version->EventCancelled) // Insert failed
			$mod_version_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$mod_version->CssClass = "ewTableEditRow";
		$mod_version->CssStyle = "";
		$mod_version->RowAttrs = array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
		$mod_version->RowType = EW_ROWTYPE_ADD;

		// Render row
		$mod_version_list->RenderRow();

		// Render list options
		$mod_version_list->RenderListOptions();
?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
<?php

// Render list options (body, left)
$mod_version_list->ListOptions->Render("body", "left");
?>
	<?php if ($mod_version->id_module->Visible) { // id_module ?>
		<td>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_module" name="x<?php echo $mod_version_list->lRowIndex ?>_id_module" title="<?php echo $mod_version->id_module->FldTitle() ?>"<?php echo $mod_version->id_module->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_module->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `root_module` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="">
</td>
	<?php } ?>
	<?php if ($mod_version->id_version_min->Visible) { // id_version_min ?>
		<td>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" title="<?php echo $mod_version->id_version_min->FldTitle() ?>"<?php echo $mod_version->id_version_min->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_min->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="">
</td>
	<?php } ?>
	<?php if ($mod_version->id_version_max->Visible) { // id_version_max ?>
		<td>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" title="<?php echo $mod_version->id_version_max->FldTitle() ?>"<?php echo $mod_version->id_version_max->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_max->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="">
</td>
	<?php } ?>
	<?php if ($mod_version->version->Visible) { // version ?>
		<td>
<input type="text" name="x<?php echo $mod_version_list->lRowIndex ?>_version" id="x<?php echo $mod_version_list->lRowIndex ?>_version" title="<?php echo $mod_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $mod_version->version->EditValue ?>"<?php echo $mod_version->version->EditAttributes() ?>>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mod_version_list->ListOptions->Render("body", "right");
?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x<?php echo $mod_version_list->lRowIndex ?>_id_module','x<?php echo $mod_version_list->lRowIndex ?>_id_module',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_min','x<?php echo $mod_version_list->lRowIndex ?>_id_version_min',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_max','x<?php echo $mod_version_list->lRowIndex ?>_id_version_max',false]]);

//-->
</script>
	</tr>
<?php
}
?>
<?php
if ($mod_version->ExportAll && $mod_version->Export <> "") {
	$mod_version_list->lStopRec = $mod_version_list->lTotalRecs;
} else {
	$mod_version_list->lStopRec = $mod_version_list->lStartRec + $mod_version_list->lDisplayRecs - 1; // Set the last record to display
}
$mod_version_list->lRecCount = $mod_version_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $mod_version_list->lStartRec > 1)
		$rs->Move($mod_version_list->lStartRec - 1);
}

// Initialize aggregate
$mod_version->RowType = EW_ROWTYPE_AGGREGATEINIT;
$mod_version_list->RenderRow();
$mod_version_list->lRowCnt = 0;
$mod_version_list->lEditRowCnt = 0;
if ($mod_version->CurrentAction == "edit")
	$mod_version_list->lRowIndex = 1;
if ($mod_version->CurrentAction == "gridadd")
	$mod_version_list->lRowIndex = 0;
if ($mod_version->CurrentAction == "gridedit")
	$mod_version_list->lRowIndex = 0;
while (($mod_version->CurrentAction == "gridadd" || !$rs->EOF) &&
	$mod_version_list->lRecCount < $mod_version_list->lStopRec) {
	$mod_version_list->lRecCount++;
	if (intval($mod_version_list->lRecCount) >= intval($mod_version_list->lStartRec)) {
		$mod_version_list->lRowCnt++;
		if ($mod_version->CurrentAction == "gridadd" || $mod_version->CurrentAction == "gridedit")
			$mod_version_list->lRowIndex++;

	// Init row class and style
	$mod_version->CssClass = "";
	$mod_version->CssStyle = "";
	$mod_version->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($mod_version->CurrentAction == "gridadd") {
		$mod_version_list->LoadDefaultValues(); // Load default values
	} else {
		$mod_version_list->LoadRowValues($rs); // Load row values
	}
	$mod_version->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($mod_version->CurrentAction == "gridadd") // Grid add
		$mod_version->RowType = EW_ROWTYPE_ADD; // Render add
	if ($mod_version->CurrentAction == "gridadd" && $mod_version->EventCancelled) // Insert failed
		$mod_version_list->RestoreCurrentRowFormValues($mod_version_list->lRowIndex); // Restore form values
	if ($mod_version->CurrentAction == "edit") {
		if ($mod_version_list->CheckInlineEditKey() && $mod_version_list->lEditRowCnt == 0) { // Inline edit
			$mod_version->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($mod_version->CurrentAction == "gridedit") { // Grid edit
		$mod_version->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($mod_version->RowType == EW_ROWTYPE_EDIT && $mod_version->EventCancelled) { // Update failed
		if ($mod_version->CurrentAction == "edit")
			$mod_version_list->RestoreFormValues(); // Restore form values
		if ($mod_version->CurrentAction == "gridedit")
			$mod_version_list->RestoreCurrentRowFormValues($mod_version_list->lRowIndex); // Restore form values
	}
	if ($mod_version->RowType == EW_ROWTYPE_EDIT) // Edit row
		$mod_version_list->lEditRowCnt++;
	if ($mod_version->RowType == EW_ROWTYPE_ADD || $mod_version->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$mod_version->RowAttrs = array_merge($mod_version->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$mod_version->CssClass = "ewTableEditRow";
	}

	// Render row
	$mod_version_list->RenderRow();

	// Render list options
	$mod_version_list->RenderListOptions();
?>
	<tr<?php echo $mod_version->RowAttributes() ?>>
<?php

// Render list options (body, left)
$mod_version_list->ListOptions->Render("body", "left");
?>
	<?php if ($mod_version->id_module->Visible) { // id_module ?>
		<td<?php echo $mod_version->id_module->CellAttributes() ?>>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_module" name="x<?php echo $mod_version_list->lRowIndex ?>_id_module" title="<?php echo $mod_version->id_module->FldTitle() ?>"<?php echo $mod_version->id_module->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_module->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `root_module` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="">
<input type="hidden" name="o<?php echo $mod_version_list->lRowIndex ?>_id_module" id="o<?php echo $mod_version_list->lRowIndex ?>_id_module" value="<?php echo ew_HtmlEncode($mod_version->id_module->OldValue) ?>">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_module" name="x<?php echo $mod_version_list->lRowIndex ?>_id_module" title="<?php echo $mod_version->id_module->FldTitle() ?>"<?php echo $mod_version->id_module->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_module->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT DISTINCT `id_module`, `root_module`, '' AS Disp2Fld FROM `module`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `root_module` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_module" value="">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_version->id_module->ViewAttributes() ?>><?php echo $mod_version->id_module->ListViewValue() ?></div>
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $mod_version_list->lRowIndex ?>_id_mod_version" id="o<?php echo $mod_version_list->lRowIndex ?>_id_mod_version" value="<?php echo ew_HtmlEncode($mod_version->id_mod_version->OldValue) ?>">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { ?>
<input type="hidden" name="x<?php echo $mod_version_list->lRowIndex ?>_id_mod_version" id="x<?php echo $mod_version_list->lRowIndex ?>_id_mod_version" value="<?php echo ew_HtmlEncode($mod_version->id_mod_version->CurrentValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_version->id_version_min->Visible) { // id_version_min ?>
		<td<?php echo $mod_version->id_version_min->CellAttributes() ?>>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" title="<?php echo $mod_version->id_version_min->FldTitle() ?>"<?php echo $mod_version->id_version_min->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_min->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="">
<input type="hidden" name="o<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="o<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="<?php echo ew_HtmlEncode($mod_version->id_version_min->OldValue) ?>">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" title="<?php echo $mod_version->id_version_min->FldTitle() ?>"<?php echo $mod_version->id_version_min->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_min->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_min" value="">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_version->id_version_min->ViewAttributes() ?>><?php echo $mod_version->id_version_min->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_version->id_version_max->Visible) { // id_version_max ?>
		<td<?php echo $mod_version->id_version_max->CellAttributes() ?>>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" title="<?php echo $mod_version->id_version_max->FldTitle() ?>"<?php echo $mod_version->id_version_max->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_max->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="">
<input type="hidden" name="o<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="o<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="<?php echo ew_HtmlEncode($mod_version->id_version_max->OldValue) ?>">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" name="x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" title="<?php echo $mod_version->id_version_max->FldTitle() ?>"<?php echo $mod_version->id_version_max->EditAttributes() ?>>
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
if (@$emptywrk) $mod_version->id_version_max->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `id_ogspy_version`, `v`, `status` FROM `ogspy_version`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="s_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="<?php echo $sSqlWrk; ?>">
<input type="hidden" name="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" id="lft_x<?php echo $mod_version_list->lRowIndex ?>_id_version_max" value="">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_version->id_version_max->ViewAttributes() ?>><?php echo $mod_version->id_version_max->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mod_version->version->Visible) { // version ?>
		<td<?php echo $mod_version->version->CellAttributes() ?>>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $mod_version_list->lRowIndex ?>_version" id="x<?php echo $mod_version_list->lRowIndex ?>_version" title="<?php echo $mod_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $mod_version->version->EditValue ?>"<?php echo $mod_version->version->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $mod_version_list->lRowIndex ?>_version" id="o<?php echo $mod_version_list->lRowIndex ?>_version" value="<?php echo ew_HtmlEncode($mod_version->version->OldValue) ?>">
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $mod_version_list->lRowIndex ?>_version" id="x<?php echo $mod_version_list->lRowIndex ?>_version" title="<?php echo $mod_version->version->FldTitle() ?>" size="30" maxlength="10" value="<?php echo $mod_version->version->EditValue ?>"<?php echo $mod_version->version->EditAttributes() ?>>
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $mod_version->version->ViewAttributes() ?>><?php echo $mod_version->version->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mod_version_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($mod_version->RowType == EW_ROWTYPE_ADD) { ?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x<?php echo $mod_version_list->lRowIndex ?>_id_module','x<?php echo $mod_version_list->lRowIndex ?>_id_module',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_min','x<?php echo $mod_version_list->lRowIndex ?>_id_version_min',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_max','x<?php echo $mod_version_list->lRowIndex ?>_id_version_max',false]]);

//-->
</script>
<?php } ?>
<?php if ($mod_version->RowType == EW_ROWTYPE_EDIT) { ?>
<script language="JavaScript" type="text/javascript">
<!--
ew_UpdateOpts([['x<?php echo $mod_version_list->lRowIndex ?>_id_module','x<?php echo $mod_version_list->lRowIndex ?>_id_module',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_min','x<?php echo $mod_version_list->lRowIndex ?>_id_version_min',false],
['x<?php echo $mod_version_list->lRowIndex ?>_id_version_max','x<?php echo $mod_version_list->lRowIndex ?>_id_version_max',false]]);

//-->
</script>
<?php } ?>
<?php
	}
	if ($mod_version->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($mod_version->CurrentAction == "add" || $mod_version->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_version->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_version->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_version_list->lRowIndex ?>">
<?php } ?>
<?php if ($mod_version->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $mod_version_list->lRowIndex ?>">
<?php echo $mod_version_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($mod_version->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($mod_version->CurrentAction <> "gridadd" && $mod_version->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($mod_version_list->Pager)) $mod_version_list->Pager = new cPrevNextPager($mod_version_list->lStartRec, $mod_version_list->lDisplayRecs, $mod_version_list->lTotalRecs) ?>
<?php if ($mod_version_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($mod_version_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $mod_version_list->PageUrl() ?>start=<?php echo $mod_version_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($mod_version_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $mod_version_list->PageUrl() ?>start=<?php echo $mod_version_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $mod_version_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($mod_version_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $mod_version_list->PageUrl() ?>start=<?php echo $mod_version_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($mod_version_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $mod_version_list->PageUrl() ?>start=<?php echo $mod_version_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $mod_version_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $mod_version_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $mod_version_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $mod_version_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($mod_version_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($mod_version_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($mod_version->CurrentAction <> "gridadd" && $mod_version->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $mod_version_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_version_list->InlineAddUrl ?>"><?php echo $Language->Phrase("InlineAddLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_version_list->GridAddUrl ?>"><?php echo $Language->Phrase("GridAddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($mod_version_list->lTotalRecs > 0) { ?>
<a href="<?php echo $mod_version_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php if ($mod_version_list->lTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fmod_versionlist, '<?php echo $mod_version_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($mod_version->CurrentAction == "gridadd") { ?>
<a href="" onclick="f=document.fmod_versionlist;if(mod_version_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridInsertLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_version_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($mod_version->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.fmod_versionlist;if(mod_version_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $mod_version_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($mod_version->Export == "" && $mod_version->CurrentAction == "") { ?>
<?php } ?>
<?php if ($mod_version->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$mod_version_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cmod_version_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'mod_version';

	// Page object name
	var $PageObjName = 'mod_version_list';

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
	function cmod_version_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (mod_version)
		$GLOBALS["mod_version"] = new cmod_version();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["mod_version"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "mod_versiondelete.php";
		$this->MultiUpdateUrl = "mod_versionupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'mod_version', TRUE);

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

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$mod_version->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$mod_version->Export = $_POST["exporttype"];
		} else {
			$mod_version->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $mod_version->Export; // Get export parameter, used in header
		$gsExportFile = $mod_version->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $mod_version;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$mod_version->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($mod_version->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($mod_version->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($mod_version->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($mod_version->CurrentAction == "add" || $mod_version->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($mod_version->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$mod_version->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($mod_version->CurrentAction == "gridupdate" || $mod_version->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($mod_version->CurrentAction == "update" || $mod_version->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($mod_version->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($mod_version->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd")
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
			$mod_version->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($mod_version->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $mod_version->getRecordsPerPage(); // Restore from Session
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
		$mod_version->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$mod_version->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$mod_version->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $mod_version->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$mod_version->setSessionWhere($sFilter);
		$mod_version->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $mod_version;
		$mod_version->setKey("id_mod_version", ""); // Clear inline edit key
		$mod_version->CurrentAction = ""; // Clear action
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
		global $Security, $mod_version;
		$bInlineEdit = TRUE;
		if (@$_GET["id_mod_version"] <> "") {
			$mod_version->id_mod_version->setQueryStringValue($_GET["id_mod_version"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$mod_version->setKey("id_mod_version", $mod_version->id_mod_version->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $mod_version;
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
				$mod_version->SendEmail = TRUE; // Send email on update success
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
			$mod_version->EventCancelled = TRUE; // Cancel event
			$mod_version->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $mod_version;

		//CheckInlineEditKey = True
		if (strval($mod_version->getKey("id_mod_version")) <> strval($mod_version->id_mod_version->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $mod_version;
		if ($mod_version->CurrentAction == "copy") {
			if (@$_GET["id_mod_version"] <> "") {
				$mod_version->id_mod_version->setQueryStringValue($_GET["id_mod_version"]);
			} else {
				$mod_version->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError, $mod_version;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$mod_version->EventCancelled = TRUE; // Set event cancelled
			$mod_version->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$mod_version->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage($Language->Phrase("AddSuccess")); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$mod_version->EventCancelled = TRUE; // Set event cancelled
			$mod_version->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $mod_version;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$mod_version->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $mod_version->SQL();
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
					$mod_version->SendEmail = FALSE; // Do not send email on update success
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
			$mod_version->EventCancelled = TRUE; // Set event cancelled
			$mod_version->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $mod_version;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $mod_version->KeyFilter();
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
		global $mod_version;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$mod_version->id_mod_version->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($mod_version->id_mod_version->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError, $mod_version;
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
				$mod_version->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow(); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
					$sKey .= $mod_version->id_mod_version->CurrentValue;

					// Add filter for this record
					$sFilter = $mod_version->KeyFilter();
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
			$mod_version->CurrentFilter = $sWrkFilter;
			$sSql = $mod_version->SQL();
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
			$mod_version->EventCancelled = TRUE; // Set event cancelled
			$mod_version->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
	}

	// Check if empty row
	function EmptyRow() {
		global $mod_version;
		if ($mod_version->id_module->CurrentValue <> $mod_version->id_module->OldValue)
			return FALSE;
		if ($mod_version->id_version_min->CurrentValue <> $mod_version->id_version_min->OldValue)
			return FALSE;
		if ($mod_version->id_version_max->CurrentValue <> $mod_version->id_version_max->OldValue)
			return FALSE;
		if ($mod_version->version->CurrentValue <> $mod_version->version->OldValue)
			return FALSE;
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $mod_version;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($mod_version->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($mod_version->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($mod_version->id_mod_version->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $mod_version;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_version->id_mod_version, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_version->id_module, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_version->id_version_min, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $mod_version->id_version_max, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $mod_version->version, $Keyword);
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
		global $Security, $mod_version;
		$sSearchStr = "";
		$sSearchKeyword = $mod_version->BasicSearchKeyword;
		$sSearchType = $mod_version->BasicSearchType;
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
			$mod_version->setSessionBasicSearchKeyword($sSearchKeyword);
			$mod_version->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $mod_version;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$mod_version->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $mod_version;
		$mod_version->setSessionBasicSearchKeyword("");
		$mod_version->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $mod_version;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$mod_version->BasicSearchKeyword = $mod_version->getSessionBasicSearchKeyword();
			$mod_version->BasicSearchType = $mod_version->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $mod_version;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$mod_version->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$mod_version->CurrentOrderType = @$_GET["ordertype"];
			$mod_version->UpdateSort($mod_version->id_module); // id_module
			$mod_version->UpdateSort($mod_version->id_version_min); // id_version_min
			$mod_version->UpdateSort($mod_version->id_version_max); // id_version_max
			$mod_version->UpdateSort($mod_version->version); // version
			$mod_version->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $mod_version;
		$sOrderBy = $mod_version->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($mod_version->SqlOrderBy() <> "") {
				$sOrderBy = $mod_version->SqlOrderBy();
				$mod_version->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $mod_version;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$mod_version->setSessionOrderBy($sOrderBy);
				$mod_version->setSessionOrderByList($sOrderBy);
				$mod_version->id_module->setSort("");
				$mod_version->id_version_min->setSort("");
				$mod_version->id_version_max->setSort("");
				$mod_version->version->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$mod_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $mod_version;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "checkbox"
		$this->ListOptions->Add("checkbox");
		$item =& $this->ListOptions->Items["checkbox"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"mod_version_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($mod_version->Export <> "" ||
			$mod_version->CurrentAction == "gridadd" ||
			$mod_version->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $mod_version;
		$this->ListOptions->LoadDefault();

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if (($mod_version->CurrentAction == "add" || $mod_version->CurrentAction == "copy") &&
			$mod_version->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a href=\"\" onclick=\"f=document.fmod_versionlist;if(mod_version_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($mod_version->CurrentAction == "edit" && $mod_version->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.fmod_versionlist;if(mod_version_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			return;
		}

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewInlineLink\" href=\"" . $this->InlineEditUrl . "#" . $this->PageObjName . "_row_" . $this->lRowCnt . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a href=\"" . $this->InlineCopyUrl . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($mod_version->id_mod_version->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		if ($mod_version->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $mod_version->id_mod_version->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $mod_version;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $mod_version;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$mod_version->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$mod_version->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $mod_version->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$mod_version->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$mod_version->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$mod_version->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $mod_version;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $mod_version;
		$mod_version->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$mod_version->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $mod_version;
		$mod_version->id_module->setFormValue($objForm->GetValue("x_id_module"));
		$mod_version->id_module->setOldValue($objForm->GetValue("o_id_module"));
		$mod_version->id_version_min->setFormValue($objForm->GetValue("x_id_version_min"));
		$mod_version->id_version_min->setOldValue($objForm->GetValue("o_id_version_min"));
		$mod_version->id_version_max->setFormValue($objForm->GetValue("x_id_version_max"));
		$mod_version->id_version_max->setOldValue($objForm->GetValue("o_id_version_max"));
		$mod_version->version->setFormValue($objForm->GetValue("x_version"));
		$mod_version->version->setOldValue($objForm->GetValue("o_version"));
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
		$this->ViewUrl = $mod_version->ViewUrl();
		$this->EditUrl = $mod_version->EditUrl();
		$this->InlineEditUrl = $mod_version->InlineEditUrl();
		$this->CopyUrl = $mod_version->CopyUrl();
		$this->InlineCopyUrl = $mod_version->InlineCopyUrl();
		$this->DeleteUrl = $mod_version->DeleteUrl();

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
		} elseif ($mod_version->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
			// id_module

			$mod_version->id_module->HrefValue = "";

			// id_version_min
			$mod_version->id_version_min->HrefValue = "";

			// id_version_max
			$mod_version->id_version_max->HrefValue = "";

			// version
			$mod_version->version->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $mod_version;
		$sFilter = $mod_version->KeyFilter();
		$mod_version->CurrentFilter = $sFilter;
		$sSql = $mod_version->SQL();
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
			$mod_version->id_module->SetDbValueDef($rsnew, $mod_version->id_module->CurrentValue, 0, FALSE);

			// id_version_min
			$mod_version->id_version_min->SetDbValueDef($rsnew, $mod_version->id_version_min->CurrentValue, 0, FALSE);

			// id_version_max
			$mod_version->id_version_max->SetDbValueDef($rsnew, $mod_version->id_version_max->CurrentValue, 0, FALSE);

			// version
			$mod_version->version->SetDbValueDef($rsnew, $mod_version->version->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $mod_version->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($mod_version->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($mod_version->CancelMessage <> "") {
					$this->setMessage($mod_version->CancelMessage);
					$mod_version->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$mod_version->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
