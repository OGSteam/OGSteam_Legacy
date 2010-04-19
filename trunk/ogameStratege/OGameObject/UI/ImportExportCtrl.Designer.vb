<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class ImportExportCtrl
    Inherits System.Windows.Forms.UserControl

    'UserControl remplace la méthode Dispose pour nettoyer la liste des composants.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Requise par le Concepteur Windows Form
    Private components As System.ComponentModel.IContainer

    'REMARQUE : la procédure suivante est requise par le Concepteur Windows Form
    'Elle peut être modifiée à l'aide du Concepteur Windows Form.  
    'Ne la modifiez pas à l'aide de l'éditeur de code.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Me.tcImportExport = New System.Windows.Forms.TabControl
        Me.tpBrowser = New System.Windows.Forms.TabPage
        Me.OgameBrowserCtrl1 = New OGameObject.OgameBrowserCtrl
        Me.tpImportExport = New System.Windows.Forms.TabPage
        Me.rtbLogExportImport = New System.Windows.Forms.RichTextBox
        Me.SplitContainerStat = New System.Windows.Forms.SplitContainer
        Me.btnExportStatsToOGSpy = New System.Windows.Forms.Button
        Me.btnRefreshStatsOGS = New System.Windows.Forms.Button
        Me.lbStatistiquesOGS = New System.Windows.Forms.ListBox
        Me.Label12 = New System.Windows.Forms.Label
        Me.btnImportOGSpyStat = New System.Windows.Forms.Button
        Me.btnLoadStatOGSpy = New System.Windows.Forms.Button
        Me.lbStatistiquesOGSpy = New System.Windows.Forms.ListBox
        Me.Label13 = New System.Windows.Forms.Label
        Me.Label11 = New System.Windows.Forms.Label
        Me.flpImport = New System.Windows.Forms.FlowLayoutPanel
        Me.chkImportAll = New System.Windows.Forms.CheckBox
        Me.Label10 = New System.Windows.Forms.Label
        Me.dtpLastImport2 = New System.Windows.Forms.DateTimePicker
        Me.chkImportPlanets = New System.Windows.Forms.CheckBox
        Me.chkImportSpyReport = New System.Windows.Forms.CheckBox
        Me.flpExport = New System.Windows.Forms.FlowLayoutPanel
        Me.chkExportAll = New System.Windows.Forms.CheckBox
        Me.Label9 = New System.Windows.Forms.Label
        Me.dtpLastExport2 = New System.Windows.Forms.DateTimePicker
        Me.chkExportPlanets = New System.Windows.Forms.CheckBox
        Me.chkExportSpyReport = New System.Windows.Forms.CheckBox
        Me.flpGalaxies = New System.Windows.Forms.FlowLayoutPanel
        Me.gbGalaxieSelect = New System.Windows.Forms.GroupBox
        Me.chkGal9 = New System.Windows.Forms.CheckBox
        Me.chkGal8 = New System.Windows.Forms.CheckBox
        Me.chkGal7 = New System.Windows.Forms.CheckBox
        Me.chkGal6 = New System.Windows.Forms.CheckBox
        Me.chkGal5 = New System.Windows.Forms.CheckBox
        Me.chkGal4 = New System.Windows.Forms.CheckBox
        Me.chkGal3 = New System.Windows.Forms.CheckBox
        Me.chkGal2 = New System.Windows.Forms.CheckBox
        Me.chkGal1 = New System.Windows.Forms.CheckBox
        Me.btnSelectAllGalaxy = New System.Windows.Forms.Button
        Me.btnUnselectAllGalaxy = New System.Windows.Forms.Button
        Me.tsImportExportBar = New System.Windows.Forms.ToolStrip
        Me.tsButImport = New System.Windows.Forms.ToolStripButton
        Me.tsButExport = New System.Windows.Forms.ToolStripButton
        Me.tsButExportImport = New System.Windows.Forms.ToolStripButton
        Me.tscbComptes = New System.Windows.Forms.ToolStripComboBox
        Me.tsButCancel = New System.Windows.Forms.ToolStripButton
        Me.tsButBrowserOgspy = New System.Windows.Forms.ToolStripButton
        Me.ToolStripDropDownButton1 = New System.Windows.Forms.ToolStripDropDownButton
        Me.ToolStripMenuItem1 = New System.Windows.Forms.ToolStripMenuItem
        Me.ToolStripSeparator3 = New System.Windows.Forms.ToolStripSeparator
        Me.tsmiSelectAllGalaxy = New System.Windows.Forms.ToolStripMenuItem
        Me.tsmiUnselectAllGalaxy = New System.Windows.Forms.ToolStripMenuItem
        Me.tpComptes = New System.Windows.Forms.TabPage
        Me.SplitContainerComptes = New System.Windows.Forms.SplitContainer
        Me.lbComptes = New System.Windows.Forms.ListBox
        Me.Label14 = New System.Windows.Forms.Label
        Me.dtpLastImport = New System.Windows.Forms.DateTimePicker
        Me.Label8 = New System.Windows.Forms.Label
        Me.dtpLastExport = New System.Windows.Forms.DateTimePicker
        Me.Label7 = New System.Windows.Forms.Label
        Me.tbChunkSize = New System.Windows.Forms.TextBox
        Me.Label6 = New System.Windows.Forms.Label
        Me.chkDefaultAccount = New System.Windows.Forms.CheckBox
        Me.Label5 = New System.Windows.Forms.Label
        Me.tbAccountPassword = New System.Windows.Forms.TextBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.tbAccountName = New System.Windows.Forms.TextBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.tbServerUrl = New System.Windows.Forms.TextBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.tbFriendlyName = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.tsComptesBar = New System.Windows.Forms.ToolStrip
        Me.tsButAddCompte = New System.Windows.Forms.ToolStripButton
        Me.tsButRemoveCompte = New System.Windows.Forms.ToolStripButton
        Me.tsbCopyCompte = New System.Windows.Forms.ToolStripButton
        Me.ToolStripSeparator1 = New System.Windows.Forms.ToolStripSeparator
        Me.tsbSaveComptes = New System.Windows.Forms.ToolStripButton
        Me.ToolStripSeparator2 = New System.Windows.Forms.ToolStripSeparator
        Me.tsButTestCompte = New System.Windows.Forms.ToolStripButton
        Me.btnLogin = New System.Windows.Forms.ToolStripButton
        Me.btnImport = New System.Windows.Forms.ToolStripButton
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.BackgroundWorker1 = New System.ComponentModel.BackgroundWorker
        Me.BackgroundWorker2 = New System.ComponentModel.BackgroundWorker
        Me.tcImportExport.SuspendLayout()
        Me.tpBrowser.SuspendLayout()
        Me.tpImportExport.SuspendLayout()
        Me.SplitContainerStat.Panel1.SuspendLayout()
        Me.SplitContainerStat.Panel2.SuspendLayout()
        Me.SplitContainerStat.SuspendLayout()
        Me.flpImport.SuspendLayout()
        Me.flpExport.SuspendLayout()
        Me.flpGalaxies.SuspendLayout()
        Me.gbGalaxieSelect.SuspendLayout()
        Me.tsImportExportBar.SuspendLayout()
        Me.tpComptes.SuspendLayout()
        Me.SplitContainerComptes.Panel1.SuspendLayout()
        Me.SplitContainerComptes.Panel2.SuspendLayout()
        Me.SplitContainerComptes.SuspendLayout()
        Me.tsComptesBar.SuspendLayout()
        Me.SuspendLayout()
        '
        'tcImportExport
        '
        Me.tcImportExport.Controls.Add(Me.tpBrowser)
        Me.tcImportExport.Controls.Add(Me.tpImportExport)
        Me.tcImportExport.Controls.Add(Me.tpComptes)
        Me.tcImportExport.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tcImportExport.Location = New System.Drawing.Point(0, 0)
        Me.tcImportExport.Multiline = True
        Me.tcImportExport.Name = "tcImportExport"
        Me.tcImportExport.SelectedIndex = 0
        Me.tcImportExport.Size = New System.Drawing.Size(578, 495)
        Me.tcImportExport.TabIndex = 0
        '
        'tpBrowser
        '
        Me.tpBrowser.Controls.Add(Me.OgameBrowserCtrl1)
        Me.tpBrowser.Location = New System.Drawing.Point(4, 22)
        Me.tpBrowser.Name = "tpBrowser"
        Me.tpBrowser.Size = New System.Drawing.Size(570, 469)
        Me.tpBrowser.TabIndex = 2
        Me.tpBrowser.Text = "IE Browser"
        Me.tpBrowser.UseVisualStyleBackColor = True
        '
        'OgameBrowserCtrl1
        '
        Me.OgameBrowserCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.OgameBrowserCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.OgameBrowserCtrl1.Name = "OgameBrowserCtrl1"
        Me.OgameBrowserCtrl1.Size = New System.Drawing.Size(570, 469)
        Me.OgameBrowserCtrl1.TabIndex = 0
        '
        'tpImportExport
        '
        Me.tpImportExport.Controls.Add(Me.rtbLogExportImport)
        Me.tpImportExport.Controls.Add(Me.SplitContainerStat)
        Me.tpImportExport.Controls.Add(Me.Label11)
        Me.tpImportExport.Controls.Add(Me.flpImport)
        Me.tpImportExport.Controls.Add(Me.flpExport)
        Me.tpImportExport.Controls.Add(Me.flpGalaxies)
        Me.tpImportExport.Controls.Add(Me.tsImportExportBar)
        Me.tpImportExport.Location = New System.Drawing.Point(4, 22)
        Me.tpImportExport.Name = "tpImportExport"
        Me.tpImportExport.Padding = New System.Windows.Forms.Padding(5)
        Me.tpImportExport.Size = New System.Drawing.Size(570, 469)
        Me.tpImportExport.TabIndex = 1
        Me.tpImportExport.Text = "Import/Export"
        Me.tpImportExport.UseVisualStyleBackColor = True
        '
        'rtbLogExportImport
        '
        Me.rtbLogExportImport.BackColor = System.Drawing.SystemColors.Info
        Me.rtbLogExportImport.Dock = System.Windows.Forms.DockStyle.Fill
        Me.rtbLogExportImport.ForeColor = System.Drawing.SystemColors.InfoText
        Me.rtbLogExportImport.Location = New System.Drawing.Point(5, 388)
        Me.rtbLogExportImport.Name = "rtbLogExportImport"
        Me.rtbLogExportImport.ReadOnly = True
        Me.rtbLogExportImport.Size = New System.Drawing.Size(560, 76)
        Me.rtbLogExportImport.TabIndex = 6
        Me.rtbLogExportImport.Text = "Importation/Exportation sur serveur OGSpy" & Global.Microsoft.VisualBasic.ChrW(10)
        '
        'SplitContainerStat
        '
        Me.SplitContainerStat.Dock = System.Windows.Forms.DockStyle.Top
        Me.SplitContainerStat.Location = New System.Drawing.Point(5, 242)
        Me.SplitContainerStat.Name = "SplitContainerStat"
        '
        'SplitContainerStat.Panel1
        '
        Me.SplitContainerStat.Panel1.Controls.Add(Me.btnExportStatsToOGSpy)
        Me.SplitContainerStat.Panel1.Controls.Add(Me.btnRefreshStatsOGS)
        Me.SplitContainerStat.Panel1.Controls.Add(Me.lbStatistiquesOGS)
        Me.SplitContainerStat.Panel1.Controls.Add(Me.Label12)
        '
        'SplitContainerStat.Panel2
        '
        Me.SplitContainerStat.Panel2.Controls.Add(Me.btnImportOGSpyStat)
        Me.SplitContainerStat.Panel2.Controls.Add(Me.btnLoadStatOGSpy)
        Me.SplitContainerStat.Panel2.Controls.Add(Me.lbStatistiquesOGSpy)
        Me.SplitContainerStat.Panel2.Controls.Add(Me.Label13)
        Me.SplitContainerStat.Size = New System.Drawing.Size(560, 146)
        Me.SplitContainerStat.SplitterDistance = 275
        Me.SplitContainerStat.TabIndex = 5
        '
        'btnExportStatsToOGSpy
        '
        Me.btnExportStatsToOGSpy.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.btnExportStatsToOGSpy.Enabled = False
        Me.btnExportStatsToOGSpy.Image = Global.OGameObject.My.Resources.Resources.redo_24
        Me.btnExportStatsToOGSpy.ImageAlign = System.Drawing.ContentAlignment.TopLeft
        Me.btnExportStatsToOGSpy.Location = New System.Drawing.Point(192, 80)
        Me.btnExportStatsToOGSpy.Name = "btnExportStatsToOGSpy"
        Me.btnExportStatsToOGSpy.Size = New System.Drawing.Size(75, 54)
        Me.btnExportStatsToOGSpy.TabIndex = 2
        Me.btnExportStatsToOGSpy.Text = "Exporter"
        Me.btnExportStatsToOGSpy.TextAlign = System.Drawing.ContentAlignment.BottomRight
        Me.btnExportStatsToOGSpy.UseVisualStyleBackColor = True
        '
        'btnRefreshStatsOGS
        '
        Me.btnRefreshStatsOGS.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.btnRefreshStatsOGS.Image = Global.OGameObject.My.Resources.Resources.run_right_32
        Me.btnRefreshStatsOGS.ImageAlign = System.Drawing.ContentAlignment.TopLeft
        Me.btnRefreshStatsOGS.Location = New System.Drawing.Point(192, 13)
        Me.btnRefreshStatsOGS.Name = "btnRefreshStatsOGS"
        Me.btnRefreshStatsOGS.Size = New System.Drawing.Size(75, 54)
        Me.btnRefreshStatsOGS.TabIndex = 2
        Me.btnRefreshStatsOGS.Text = "Rafraichir"
        Me.btnRefreshStatsOGS.TextAlign = System.Drawing.ContentAlignment.BottomRight
        Me.ToolTip1.SetToolTip(Me.btnRefreshStatsOGS, "Relire les statistiques OGS connues dans la base de données")
        Me.btnRefreshStatsOGS.UseVisualStyleBackColor = True
        '
        'lbStatistiquesOGS
        '
        Me.lbStatistiquesOGS.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbStatistiquesOGS.FormattingEnabled = True
        Me.lbStatistiquesOGS.Location = New System.Drawing.Point(0, 13)
        Me.lbStatistiquesOGS.Name = "lbStatistiquesOGS"
        Me.lbStatistiquesOGS.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        Me.lbStatistiquesOGS.Size = New System.Drawing.Size(178, 121)
        Me.lbStatistiquesOGS.TabIndex = 1
        '
        'Label12
        '
        Me.Label12.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label12.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Underline, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.Location = New System.Drawing.Point(0, 0)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(275, 13)
        Me.Label12.TabIndex = 0
        Me.Label12.Text = "Statistiques OGS"
        Me.Label12.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'btnImportOGSpyStat
        '
        Me.btnImportOGSpyStat.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.btnImportOGSpyStat.Enabled = False
        Me.btnImportOGSpyStat.Image = Global.OGameObject.My.Resources.Resources.undo_24
        Me.btnImportOGSpyStat.ImageAlign = System.Drawing.ContentAlignment.TopLeft
        Me.btnImportOGSpyStat.Location = New System.Drawing.Point(192, 80)
        Me.btnImportOGSpyStat.Name = "btnImportOGSpyStat"
        Me.btnImportOGSpyStat.Size = New System.Drawing.Size(75, 54)
        Me.btnImportOGSpyStat.TabIndex = 4
        Me.btnImportOGSpyStat.Text = "Importer"
        Me.btnImportOGSpyStat.TextAlign = System.Drawing.ContentAlignment.BottomRight
        Me.btnImportOGSpyStat.UseVisualStyleBackColor = True
        '
        'btnLoadStatOGSpy
        '
        Me.btnLoadStatOGSpy.Anchor = CType((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.btnLoadStatOGSpy.Image = Global.OGameObject.My.Resources.Resources.run_left_32
        Me.btnLoadStatOGSpy.ImageAlign = System.Drawing.ContentAlignment.TopLeft
        Me.btnLoadStatOGSpy.Location = New System.Drawing.Point(192, 13)
        Me.btnLoadStatOGSpy.Name = "btnLoadStatOGSpy"
        Me.btnLoadStatOGSpy.Size = New System.Drawing.Size(75, 54)
        Me.btnLoadStatOGSpy.TabIndex = 3
        Me.btnLoadStatOGSpy.Text = "Rafraichir"
        Me.btnLoadStatOGSpy.TextAlign = System.Drawing.ContentAlignment.BottomRight
        Me.btnLoadStatOGSpy.UseVisualStyleBackColor = True
        '
        'lbStatistiquesOGSpy
        '
        Me.lbStatistiquesOGSpy.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lbStatistiquesOGSpy.FormattingEnabled = True
        Me.lbStatistiquesOGSpy.Location = New System.Drawing.Point(0, 13)
        Me.lbStatistiquesOGSpy.Name = "lbStatistiquesOGSpy"
        Me.lbStatistiquesOGSpy.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        Me.lbStatistiquesOGSpy.Size = New System.Drawing.Size(178, 121)
        Me.lbStatistiquesOGSpy.TabIndex = 2
        '
        'Label13
        '
        Me.Label13.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label13.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Underline, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.Location = New System.Drawing.Point(0, 0)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(281, 13)
        Me.Label13.TabIndex = 1
        Me.Label13.Text = "Statistiques OGSpy"
        Me.Label13.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label11
        '
        Me.Label11.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label11.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label11.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label11.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label11.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label11.Location = New System.Drawing.Point(5, 224)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(560, 18)
        Me.Label11.TabIndex = 4
        Me.Label11.Text = "Exportation et Importation des Statistiques"
        Me.Label11.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'flpImport
        '
        Me.flpImport.AutoSize = True
        Me.flpImport.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.flpImport.Controls.Add(Me.chkImportAll)
        Me.flpImport.Controls.Add(Me.Label10)
        Me.flpImport.Controls.Add(Me.dtpLastImport2)
        Me.flpImport.Controls.Add(Me.chkImportPlanets)
        Me.flpImport.Controls.Add(Me.chkImportSpyReport)
        Me.flpImport.Dock = System.Windows.Forms.DockStyle.Top
        Me.flpImport.Location = New System.Drawing.Point(5, 171)
        Me.flpImport.Name = "flpImport"
        Me.flpImport.Size = New System.Drawing.Size(560, 53)
        Me.flpImport.TabIndex = 3
        '
        'chkImportAll
        '
        Me.chkImportAll.AutoSize = True
        Me.chkImportAll.BackColor = System.Drawing.SystemColors.ControlDark
        Me.chkImportAll.Location = New System.Drawing.Point(3, 3)
        Me.chkImportAll.Name = "chkImportAll"
        Me.chkImportAll.Size = New System.Drawing.Size(128, 17)
        Me.chkImportAll.TabIndex = 2
        Me.chkImportAll.Text = "Importer toute la base"
        Me.chkImportAll.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.ToolTip1.SetToolTip(Me.chkImportAll, "Exporte toute les données sans tenir compte de la date de dernière exportation")
        Me.chkImportAll.UseVisualStyleBackColor = False
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(137, 0)
        Me.Label10.MinimumSize = New System.Drawing.Size(0, 19)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(152, 19)
        Me.Label10.TabIndex = 0
        Me.Label10.Text = "Date de la dernière Importation"
        Me.Label10.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.ToolTip1.SetToolTip(Me.Label10, "Les informations à partir de cette date seront exportées")
        '
        'dtpLastImport2
        '
        Me.dtpLastImport2.CustomFormat = "yyyy-MM-dd HH:mm"
        Me.dtpLastImport2.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpLastImport2.Location = New System.Drawing.Point(295, 3)
        Me.dtpLastImport2.Name = "dtpLastImport2"
        Me.dtpLastImport2.Size = New System.Drawing.Size(128, 20)
        Me.dtpLastImport2.TabIndex = 1
        Me.ToolTip1.SetToolTip(Me.dtpLastImport2, "Les informations à partir de cette date seront exportées")
        '
        'chkImportPlanets
        '
        Me.chkImportPlanets.AutoSize = True
        Me.chkImportPlanets.Location = New System.Drawing.Point(3, 29)
        Me.chkImportPlanets.Name = "chkImportPlanets"
        Me.chkImportPlanets.Size = New System.Drawing.Size(142, 17)
        Me.chkImportPlanets.TabIndex = 3
        Me.chkImportPlanets.Text = "Importation des Planètes"
        Me.chkImportPlanets.UseVisualStyleBackColor = True
        '
        'chkImportSpyReport
        '
        Me.chkImportSpyReport.AutoSize = True
        Me.chkImportSpyReport.Location = New System.Drawing.Point(151, 29)
        Me.chkImportSpyReport.Name = "chkImportSpyReport"
        Me.chkImportSpyReport.Size = New System.Drawing.Size(204, 17)
        Me.chkImportSpyReport.TabIndex = 4
        Me.chkImportSpyReport.Text = "Importation des rapports d'espionages"
        Me.chkImportSpyReport.UseVisualStyleBackColor = True
        '
        'flpExport
        '
        Me.flpExport.AutoSize = True
        Me.flpExport.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.flpExport.Controls.Add(Me.chkExportAll)
        Me.flpExport.Controls.Add(Me.Label9)
        Me.flpExport.Controls.Add(Me.dtpLastExport2)
        Me.flpExport.Controls.Add(Me.chkExportPlanets)
        Me.flpExport.Controls.Add(Me.chkExportSpyReport)
        Me.flpExport.Dock = System.Windows.Forms.DockStyle.Top
        Me.flpExport.Location = New System.Drawing.Point(5, 118)
        Me.flpExport.Name = "flpExport"
        Me.flpExport.Size = New System.Drawing.Size(560, 53)
        Me.flpExport.TabIndex = 2
        '
        'chkExportAll
        '
        Me.chkExportAll.AutoSize = True
        Me.chkExportAll.BackColor = System.Drawing.SystemColors.ControlDark
        Me.chkExportAll.Location = New System.Drawing.Point(3, 3)
        Me.chkExportAll.Name = "chkExportAll"
        Me.chkExportAll.Size = New System.Drawing.Size(129, 17)
        Me.chkExportAll.TabIndex = 2
        Me.chkExportAll.Text = "Exporter toute la base"
        Me.chkExportAll.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.ToolTip1.SetToolTip(Me.chkExportAll, "Exporte toute les données sans tenir compte de la date de dernière exportation")
        Me.chkExportAll.UseVisualStyleBackColor = False
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(138, 0)
        Me.Label9.MinimumSize = New System.Drawing.Size(0, 19)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(153, 19)
        Me.Label9.TabIndex = 0
        Me.Label9.Text = "Date de la dernière Exportation"
        Me.Label9.TextAlign = System.Drawing.ContentAlignment.BottomCenter
        Me.ToolTip1.SetToolTip(Me.Label9, "Les informations à partir de cette date seront exportées")
        '
        'dtpLastExport2
        '
        Me.dtpLastExport2.CustomFormat = "yyyy-MM-dd HH:mm"
        Me.dtpLastExport2.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpLastExport2.Location = New System.Drawing.Point(297, 3)
        Me.dtpLastExport2.Name = "dtpLastExport2"
        Me.dtpLastExport2.Size = New System.Drawing.Size(128, 20)
        Me.dtpLastExport2.TabIndex = 1
        Me.ToolTip1.SetToolTip(Me.dtpLastExport2, "Les informations à partir de cette date seront exportées")
        '
        'chkExportPlanets
        '
        Me.chkExportPlanets.AutoSize = True
        Me.chkExportPlanets.Location = New System.Drawing.Point(3, 29)
        Me.chkExportPlanets.Name = "chkExportPlanets"
        Me.chkExportPlanets.Size = New System.Drawing.Size(143, 17)
        Me.chkExportPlanets.TabIndex = 3
        Me.chkExportPlanets.Text = "Exportation des Planètes"
        Me.chkExportPlanets.UseVisualStyleBackColor = True
        '
        'chkExportSpyReport
        '
        Me.chkExportSpyReport.AutoSize = True
        Me.chkExportSpyReport.Location = New System.Drawing.Point(152, 29)
        Me.chkExportSpyReport.Name = "chkExportSpyReport"
        Me.chkExportSpyReport.Size = New System.Drawing.Size(205, 17)
        Me.chkExportSpyReport.TabIndex = 4
        Me.chkExportSpyReport.Text = "Exportation des rapports d'espionages"
        Me.chkExportSpyReport.UseVisualStyleBackColor = True
        '
        'flpGalaxies
        '
        Me.flpGalaxies.AutoSize = True
        Me.flpGalaxies.Controls.Add(Me.gbGalaxieSelect)
        Me.flpGalaxies.Controls.Add(Me.btnSelectAllGalaxy)
        Me.flpGalaxies.Controls.Add(Me.btnUnselectAllGalaxy)
        Me.flpGalaxies.Dock = System.Windows.Forms.DockStyle.Top
        Me.flpGalaxies.Location = New System.Drawing.Point(5, 62)
        Me.flpGalaxies.Name = "flpGalaxies"
        Me.flpGalaxies.Padding = New System.Windows.Forms.Padding(4)
        Me.flpGalaxies.Size = New System.Drawing.Size(560, 56)
        Me.flpGalaxies.TabIndex = 1
        '
        'gbGalaxieSelect
        '
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal9)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal8)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal7)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal6)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal5)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal4)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal3)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal2)
        Me.gbGalaxieSelect.Controls.Add(Me.chkGal1)
        Me.gbGalaxieSelect.Location = New System.Drawing.Point(7, 7)
        Me.gbGalaxieSelect.Name = "gbGalaxieSelect"
        Me.gbGalaxieSelect.Size = New System.Drawing.Size(352, 42)
        Me.gbGalaxieSelect.TabIndex = 4
        Me.gbGalaxieSelect.TabStop = False
        Me.gbGalaxieSelect.Text = "Importation et Exportation des Galaxies"
        Me.ToolTip1.SetToolTip(Me.gbGalaxieSelect, "Selection des Galaxies à importer et/ou exporter")
        '
        'chkGal9
        '
        Me.chkGal9.AutoSize = True
        Me.chkGal9.Checked = True
        Me.chkGal9.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal9.Location = New System.Drawing.Point(316, 19)
        Me.chkGal9.Name = "chkGal9"
        Me.chkGal9.Size = New System.Drawing.Size(32, 17)
        Me.chkGal9.TabIndex = 0
        Me.chkGal9.Text = "9"
        Me.chkGal9.UseVisualStyleBackColor = True
        '
        'chkGal8
        '
        Me.chkGal8.AutoSize = True
        Me.chkGal8.Checked = True
        Me.chkGal8.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal8.Location = New System.Drawing.Point(278, 19)
        Me.chkGal8.Name = "chkGal8"
        Me.chkGal8.Size = New System.Drawing.Size(32, 17)
        Me.chkGal8.TabIndex = 0
        Me.chkGal8.Text = "8"
        Me.chkGal8.UseVisualStyleBackColor = True
        '
        'chkGal7
        '
        Me.chkGal7.AutoSize = True
        Me.chkGal7.Checked = True
        Me.chkGal7.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal7.Location = New System.Drawing.Point(240, 19)
        Me.chkGal7.Name = "chkGal7"
        Me.chkGal7.Size = New System.Drawing.Size(32, 17)
        Me.chkGal7.TabIndex = 0
        Me.chkGal7.Text = "7"
        Me.chkGal7.UseVisualStyleBackColor = True
        '
        'chkGal6
        '
        Me.chkGal6.AutoSize = True
        Me.chkGal6.Checked = True
        Me.chkGal6.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal6.Location = New System.Drawing.Point(202, 19)
        Me.chkGal6.Name = "chkGal6"
        Me.chkGal6.Size = New System.Drawing.Size(32, 17)
        Me.chkGal6.TabIndex = 0
        Me.chkGal6.Text = "6"
        Me.chkGal6.UseVisualStyleBackColor = True
        '
        'chkGal5
        '
        Me.chkGal5.AutoSize = True
        Me.chkGal5.Checked = True
        Me.chkGal5.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal5.Location = New System.Drawing.Point(164, 19)
        Me.chkGal5.Name = "chkGal5"
        Me.chkGal5.Size = New System.Drawing.Size(32, 17)
        Me.chkGal5.TabIndex = 0
        Me.chkGal5.Text = "5"
        Me.chkGal5.UseVisualStyleBackColor = True
        '
        'chkGal4
        '
        Me.chkGal4.AutoSize = True
        Me.chkGal4.Checked = True
        Me.chkGal4.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal4.Location = New System.Drawing.Point(126, 19)
        Me.chkGal4.Name = "chkGal4"
        Me.chkGal4.Size = New System.Drawing.Size(32, 17)
        Me.chkGal4.TabIndex = 0
        Me.chkGal4.Text = "4"
        Me.chkGal4.UseVisualStyleBackColor = True
        '
        'chkGal3
        '
        Me.chkGal3.AutoSize = True
        Me.chkGal3.Checked = True
        Me.chkGal3.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal3.Location = New System.Drawing.Point(88, 19)
        Me.chkGal3.Name = "chkGal3"
        Me.chkGal3.Size = New System.Drawing.Size(32, 17)
        Me.chkGal3.TabIndex = 0
        Me.chkGal3.Text = "3"
        Me.chkGal3.UseVisualStyleBackColor = True
        '
        'chkGal2
        '
        Me.chkGal2.AutoSize = True
        Me.chkGal2.Checked = True
        Me.chkGal2.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal2.Location = New System.Drawing.Point(50, 19)
        Me.chkGal2.Name = "chkGal2"
        Me.chkGal2.Size = New System.Drawing.Size(32, 17)
        Me.chkGal2.TabIndex = 0
        Me.chkGal2.Text = "2"
        Me.chkGal2.UseVisualStyleBackColor = True
        '
        'chkGal1
        '
        Me.chkGal1.AutoSize = True
        Me.chkGal1.Checked = True
        Me.chkGal1.CheckState = System.Windows.Forms.CheckState.Checked
        Me.chkGal1.Location = New System.Drawing.Point(12, 19)
        Me.chkGal1.Name = "chkGal1"
        Me.chkGal1.Size = New System.Drawing.Size(32, 17)
        Me.chkGal1.TabIndex = 0
        Me.chkGal1.Text = "1"
        Me.chkGal1.UseVisualStyleBackColor = True
        '
        'btnSelectAllGalaxy
        '
        Me.btnSelectAllGalaxy.FlatStyle = System.Windows.Forms.FlatStyle.Popup
        Me.btnSelectAllGalaxy.Location = New System.Drawing.Point(365, 7)
        Me.btnSelectAllGalaxy.Name = "btnSelectAllGalaxy"
        Me.btnSelectAllGalaxy.Size = New System.Drawing.Size(85, 42)
        Me.btnSelectAllGalaxy.TabIndex = 5
        Me.btnSelectAllGalaxy.Text = "Tout Selectionner"
        Me.btnSelectAllGalaxy.UseVisualStyleBackColor = True
        '
        'btnUnselectAllGalaxy
        '
        Me.btnUnselectAllGalaxy.FlatStyle = System.Windows.Forms.FlatStyle.Popup
        Me.btnUnselectAllGalaxy.Location = New System.Drawing.Point(456, 7)
        Me.btnUnselectAllGalaxy.Name = "btnUnselectAllGalaxy"
        Me.btnUnselectAllGalaxy.Size = New System.Drawing.Size(90, 42)
        Me.btnUnselectAllGalaxy.TabIndex = 5
        Me.btnUnselectAllGalaxy.Text = "Tout Deselectionner"
        Me.btnUnselectAllGalaxy.UseVisualStyleBackColor = True
        '
        'tsImportExportBar
        '
        Me.tsImportExportBar.ImageScalingSize = New System.Drawing.Size(50, 50)
        Me.tsImportExportBar.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.tsButImport, Me.tsButExport, Me.tsButExportImport, Me.tscbComptes, Me.tsButCancel, Me.tsButBrowserOgspy, Me.ToolStripDropDownButton1})
        Me.tsImportExportBar.Location = New System.Drawing.Point(5, 5)
        Me.tsImportExportBar.Name = "tsImportExportBar"
        Me.tsImportExportBar.Size = New System.Drawing.Size(560, 57)
        Me.tsImportExportBar.TabIndex = 0
        Me.tsImportExportBar.Text = "ToolStrip1"
        '
        'tsButImport
        '
        Me.tsButImport.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButImport.Image = Global.OGameObject.My.Resources.Resources.download1glaze_f
        Me.tsButImport.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButImport.Name = "tsButImport"
        Me.tsButImport.Size = New System.Drawing.Size(54, 54)
        Me.tsButImport.Text = "ToolStripButton2"
        Me.tsButImport.ToolTipText = "Importation des données"
        '
        'tsButExport
        '
        Me.tsButExport.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButExport.Image = Global.OGameObject.My.Resources.Resources.upload1_glaze_f
        Me.tsButExport.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButExport.Name = "tsButExport"
        Me.tsButExport.Size = New System.Drawing.Size(54, 54)
        Me.tsButExport.Text = "ToolStripButton3"
        Me.tsButExport.ToolTipText = "Exportation des données"
        '
        'tsButExportImport
        '
        Me.tsButExportImport.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButExportImport.Image = Global.OGameObject.My.Resources.Resources.radiation_nila_f
        Me.tsButExportImport.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButExportImport.Name = "tsButExportImport"
        Me.tsButExportImport.Size = New System.Drawing.Size(54, 54)
        Me.tsButExportImport.Text = "ToolStripButton1"
        Me.tsButExportImport.ToolTipText = "Importation et Exportation des données"
        '
        'tscbComptes
        '
        Me.tscbComptes.BackColor = System.Drawing.SystemColors.InactiveCaption
        Me.tscbComptes.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.tscbComptes.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tscbComptes.ForeColor = System.Drawing.SystemColors.InactiveCaptionText
        Me.tscbComptes.Name = "tscbComptes"
        Me.tscbComptes.Size = New System.Drawing.Size(170, 57)
        '
        'tsButCancel
        '
        Me.tsButCancel.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButCancel.Enabled = False
        Me.tsButCancel.Image = Global.OGameObject.My.Resources.Resources.delete_24
        Me.tsButCancel.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButCancel.Name = "tsButCancel"
        Me.tsButCancel.Size = New System.Drawing.Size(54, 54)
        Me.tsButCancel.Text = "ToolStripButton4"
        Me.tsButCancel.ToolTipText = "Annulation de l'importation/exportation en cours"
        '
        'tsButBrowserOgspy
        '
        Me.tsButBrowserOgspy.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButBrowserOgspy.Image = Global.OGameObject.My.Resources.Resources.mail_glaze_f
        Me.tsButBrowserOgspy.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButBrowserOgspy.Name = "tsButBrowserOgspy"
        Me.tsButBrowserOgspy.Size = New System.Drawing.Size(54, 54)
        Me.tsButBrowserOgspy.Text = "ToolStripButton1"
        Me.tsButBrowserOgspy.ToolTipText = "Connexion au serveur OGSpy avec votre Explorateur Internet"
        '
        'ToolStripDropDownButton1
        '
        Me.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripDropDownButton1.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ToolStripMenuItem1, Me.ToolStripSeparator3, Me.tsmiSelectAllGalaxy, Me.tsmiUnselectAllGalaxy})
        Me.ToolStripDropDownButton1.Image = Global.OGameObject.My.Resources.Resources.settings_nila_f
        Me.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.Size = New System.Drawing.Size(63, 54)
        Me.ToolStripDropDownButton1.Text = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.ToolTipText = "Quelques fonctions utiles...."
        '
        'ToolStripMenuItem1
        '
        Me.ToolStripMenuItem1.Name = "ToolStripMenuItem1"
        Me.ToolStripMenuItem1.Size = New System.Drawing.Size(290, 22)
        Me.ToolStripMenuItem1.Text = "Editer les données reçues avant importation"
        '
        'ToolStripSeparator3
        '
        Me.ToolStripSeparator3.Name = "ToolStripSeparator3"
        Me.ToolStripSeparator3.Size = New System.Drawing.Size(287, 6)
        '
        'tsmiSelectAllGalaxy
        '
        Me.tsmiSelectAllGalaxy.Name = "tsmiSelectAllGalaxy"
        Me.tsmiSelectAllGalaxy.Size = New System.Drawing.Size(290, 22)
        Me.tsmiSelectAllGalaxy.Text = "Selectionner toutes les galaxies"
        '
        'tsmiUnselectAllGalaxy
        '
        Me.tsmiUnselectAllGalaxy.Name = "tsmiUnselectAllGalaxy"
        Me.tsmiUnselectAllGalaxy.Size = New System.Drawing.Size(290, 22)
        Me.tsmiUnselectAllGalaxy.Text = "Deselectionner toutes les galaxies"
        '
        'tpComptes
        '
        Me.tpComptes.Controls.Add(Me.SplitContainerComptes)
        Me.tpComptes.Controls.Add(Me.tsComptesBar)
        Me.tpComptes.Location = New System.Drawing.Point(4, 22)
        Me.tpComptes.Name = "tpComptes"
        Me.tpComptes.Padding = New System.Windows.Forms.Padding(3)
        Me.tpComptes.Size = New System.Drawing.Size(570, 469)
        Me.tpComptes.TabIndex = 0
        Me.tpComptes.Text = "Comptes"
        Me.tpComptes.UseVisualStyleBackColor = True
        '
        'SplitContainerComptes
        '
        Me.SplitContainerComptes.Dock = System.Windows.Forms.DockStyle.Fill
        Me.SplitContainerComptes.FixedPanel = System.Windows.Forms.FixedPanel.Panel1
        Me.SplitContainerComptes.Location = New System.Drawing.Point(3, 40)
        Me.SplitContainerComptes.Name = "SplitContainerComptes"
        '
        'SplitContainerComptes.Panel1
        '
        Me.SplitContainerComptes.Panel1.Controls.Add(Me.lbComptes)
        Me.SplitContainerComptes.Panel1.Padding = New System.Windows.Forms.Padding(5)
        '
        'SplitContainerComptes.Panel2
        '
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label14)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.dtpLastImport)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label8)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.dtpLastExport)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label7)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.tbChunkSize)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label6)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.chkDefaultAccount)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label5)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.tbAccountPassword)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label4)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.tbAccountName)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label3)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.tbServerUrl)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label2)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.tbFriendlyName)
        Me.SplitContainerComptes.Panel2.Controls.Add(Me.Label1)
        Me.SplitContainerComptes.Panel2.Padding = New System.Windows.Forms.Padding(5)
        Me.SplitContainerComptes.Size = New System.Drawing.Size(564, 426)
        Me.SplitContainerComptes.SplitterDistance = 159
        Me.SplitContainerComptes.TabIndex = 3
        '
        'lbComptes
        '
        Me.lbComptes.Dock = System.Windows.Forms.DockStyle.Fill
        Me.lbComptes.FormattingEnabled = True
        Me.lbComptes.IntegralHeight = False
        Me.lbComptes.Location = New System.Drawing.Point(5, 5)
        Me.lbComptes.Name = "lbComptes"
        Me.lbComptes.Size = New System.Drawing.Size(149, 416)
        Me.lbComptes.TabIndex = 0
        '
        'Label14
        '
        Me.Label14.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label14.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle), System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label14.Location = New System.Drawing.Point(5, 254)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(391, 13)
        Me.Label14.TabIndex = 17
        Me.Label14.Text = "N'oublie pas de sauvegarder tes changements"
        Me.Label14.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'dtpLastImport
        '
        Me.dtpLastImport.CustomFormat = "yyyy-MM-dd HH:mm"
        Me.dtpLastImport.Dock = System.Windows.Forms.DockStyle.Top
        Me.dtpLastImport.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpLastImport.Location = New System.Drawing.Point(5, 236)
        Me.dtpLastImport.MaximumSize = New System.Drawing.Size(150, 18)
        Me.dtpLastImport.Name = "dtpLastImport"
        Me.dtpLastImport.Size = New System.Drawing.Size(150, 18)
        Me.dtpLastImport.TabIndex = 16
        Me.dtpLastImport.Value = New Date(2006, 1, 1, 0, 0, 0, 0)
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label8.Location = New System.Drawing.Point(5, 223)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(141, 13)
        Me.Label8.TabIndex = 15
        Me.Label8.Text = "Date de dernière Importation"
        '
        'dtpLastExport
        '
        Me.dtpLastExport.CustomFormat = "yyyy-MM-dd HH:mm"
        Me.dtpLastExport.Dock = System.Windows.Forms.DockStyle.Top
        Me.dtpLastExport.Format = System.Windows.Forms.DateTimePickerFormat.Custom
        Me.dtpLastExport.Location = New System.Drawing.Point(5, 205)
        Me.dtpLastExport.MaximumSize = New System.Drawing.Size(150, 18)
        Me.dtpLastExport.Name = "dtpLastExport"
        Me.dtpLastExport.Size = New System.Drawing.Size(150, 18)
        Me.dtpLastExport.TabIndex = 14
        Me.dtpLastExport.Value = New Date(2006, 1, 1, 0, 0, 0, 0)
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label7.Location = New System.Drawing.Point(5, 192)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(141, 13)
        Me.Label7.TabIndex = 13
        Me.Label7.Text = "Date de dernière exportation"
        '
        'tbChunkSize
        '
        Me.tbChunkSize.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbChunkSize.Enabled = False
        Me.tbChunkSize.Location = New System.Drawing.Point(5, 174)
        Me.tbChunkSize.MaximumSize = New System.Drawing.Size(150, 18)
        Me.tbChunkSize.Name = "tbChunkSize"
        Me.tbChunkSize.Size = New System.Drawing.Size(150, 18)
        Me.tbChunkSize.TabIndex = 12
        Me.ToolTip1.SetToolTip(Me.tbChunkSize, "Nombre maximum de planètes dans un paquet envoyé à OGSpy lors de l'exportation (C" & _
                "hunkSize)")
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label6.Location = New System.Drawing.Point(5, 161)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(209, 13)
        Me.Label6.TabIndex = 11
        Me.Label6.Text = "Quantité de planètes envoyées par passage"
        '
        'chkDefaultAccount
        '
        Me.chkDefaultAccount.AutoSize = True
        Me.chkDefaultAccount.Dock = System.Windows.Forms.DockStyle.Top
        Me.chkDefaultAccount.Location = New System.Drawing.Point(5, 144)
        Me.chkDefaultAccount.Name = "chkDefaultAccount"
        Me.chkDefaultAccount.Size = New System.Drawing.Size(391, 17)
        Me.chkDefaultAccount.TabIndex = 10
        Me.chkDefaultAccount.Text = "Compte par défaut"
        Me.chkDefaultAccount.UseVisualStyleBackColor = True
        '
        'Label5
        '
        Me.Label5.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label5.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label5.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label5.Location = New System.Drawing.Point(5, 131)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(391, 13)
        Me.Label5.TabIndex = 8
        Me.Label5.Text = "Options"
        Me.Label5.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'tbAccountPassword
        '
        Me.tbAccountPassword.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbAccountPassword.Enabled = False
        Me.tbAccountPassword.Location = New System.Drawing.Point(5, 113)
        Me.tbAccountPassword.MaximumSize = New System.Drawing.Size(150, 18)
        Me.tbAccountPassword.Name = "tbAccountPassword"
        Me.tbAccountPassword.PasswordChar = Global.Microsoft.VisualBasic.ChrW(42)
        Me.tbAccountPassword.Size = New System.Drawing.Size(150, 18)
        Me.tbAccountPassword.TabIndex = 7
        Me.ToolTip1.SetToolTip(Me.tbAccountPassword, "Mot de passe du compte tel que donné par l'administateur du serveur OGSpy")
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label4.Location = New System.Drawing.Point(5, 100)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(124, 13)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Mot de passe du compte"
        '
        'tbAccountName
        '
        Me.tbAccountName.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbAccountName.Enabled = False
        Me.tbAccountName.Location = New System.Drawing.Point(5, 82)
        Me.tbAccountName.MaximumSize = New System.Drawing.Size(150, 18)
        Me.tbAccountName.Name = "tbAccountName"
        Me.tbAccountName.Size = New System.Drawing.Size(150, 18)
        Me.tbAccountName.TabIndex = 5
        Me.ToolTip1.SetToolTip(Me.tbAccountName, "Nom de connexion tel que donné par l'administrateur du serveur OGSpy")
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label3.Location = New System.Drawing.Point(5, 69)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(73, 13)
        Me.Label3.TabIndex = 4
        Me.Label3.Text = "Nom de Login"
        '
        'tbServerUrl
        '
        Me.tbServerUrl.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbServerUrl.Enabled = False
        Me.tbServerUrl.Location = New System.Drawing.Point(5, 49)
        Me.tbServerUrl.Name = "tbServerUrl"
        Me.tbServerUrl.Size = New System.Drawing.Size(391, 20)
        Me.tbServerUrl.TabIndex = 3
        Me.ToolTip1.SetToolTip(Me.tbServerUrl, "Adresse donnée par l'administrateur du serveur OGSpy")
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.Location = New System.Drawing.Point(5, 36)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(210, 13)
        Me.Label2.TabIndex = 2
        Me.Label2.Text = "Adresse Internet du Serveur OGSPY (URL)"
        '
        'tbFriendlyName
        '
        Me.tbFriendlyName.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbFriendlyName.Enabled = False
        Me.tbFriendlyName.Location = New System.Drawing.Point(5, 18)
        Me.tbFriendlyName.MaximumSize = New System.Drawing.Size(200, 18)
        Me.tbFriendlyName.Name = "tbFriendlyName"
        Me.tbFriendlyName.Size = New System.Drawing.Size(200, 18)
        Me.tbFriendlyName.TabIndex = 1
        Me.ToolTip1.SetToolTip(Me.tbFriendlyName, "Ne sert que pour vous souvenir de quel compte il s'agit. Apparaitra comme ""nom"" d" & _
                "e compte")
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.Location = New System.Drawing.Point(5, 5)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(206, 13)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Nom de reconnaissance du serveur ogspy"
        '
        'tsComptesBar
        '
        Me.tsComptesBar.AutoSize = False
        Me.tsComptesBar.ImageScalingSize = New System.Drawing.Size(24, 24)
        Me.tsComptesBar.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.tsButAddCompte, Me.tsButRemoveCompte, Me.tsbCopyCompte, Me.ToolStripSeparator1, Me.tsbSaveComptes, Me.ToolStripSeparator2, Me.tsButTestCompte, Me.btnLogin, Me.btnImport})
        Me.tsComptesBar.Location = New System.Drawing.Point(3, 3)
        Me.tsComptesBar.Name = "tsComptesBar"
        Me.tsComptesBar.Size = New System.Drawing.Size(564, 37)
        Me.tsComptesBar.Stretch = True
        Me.tsComptesBar.TabIndex = 2
        Me.tsComptesBar.Text = "ToolStrip1"
        '
        'tsButAddCompte
        '
        Me.tsButAddCompte.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButAddCompte.Image = Global.OGameObject.My.Resources.Resources.ADD_24
        Me.tsButAddCompte.ImageScaling = System.Windows.Forms.ToolStripItemImageScaling.None
        Me.tsButAddCompte.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButAddCompte.Name = "tsButAddCompte"
        Me.tsButAddCompte.Size = New System.Drawing.Size(28, 34)
        Me.tsButAddCompte.Text = "ToolStripButton1"
        Me.tsButAddCompte.ToolTipText = "Ajouter un Compte"
        '
        'tsButRemoveCompte
        '
        Me.tsButRemoveCompte.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButRemoveCompte.Enabled = False
        Me.tsButRemoveCompte.Image = Global.OGameObject.My.Resources.Resources.delete_24
        Me.tsButRemoveCompte.ImageScaling = System.Windows.Forms.ToolStripItemImageScaling.None
        Me.tsButRemoveCompte.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButRemoveCompte.Name = "tsButRemoveCompte"
        Me.tsButRemoveCompte.Size = New System.Drawing.Size(28, 34)
        Me.tsButRemoveCompte.Text = "ToolStripButton1"
        Me.tsButRemoveCompte.ToolTipText = "Supprimer un compte"
        '
        'tsbCopyCompte
        '
        Me.tsbCopyCompte.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsbCopyCompte.Enabled = False
        Me.tsbCopyCompte.Image = Global.OGameObject.My.Resources.Resources.COPY_24
        Me.tsbCopyCompte.ImageScaling = System.Windows.Forms.ToolStripItemImageScaling.None
        Me.tsbCopyCompte.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsbCopyCompte.Name = "tsbCopyCompte"
        Me.tsbCopyCompte.Size = New System.Drawing.Size(28, 34)
        Me.tsbCopyCompte.Text = "ToolStripButton1"
        Me.tsbCopyCompte.ToolTipText = "Créer un nouveau compte en copiant le compte sélectionné"
        '
        'ToolStripSeparator1
        '
        Me.ToolStripSeparator1.Name = "ToolStripSeparator1"
        Me.ToolStripSeparator1.Size = New System.Drawing.Size(6, 37)
        '
        'tsbSaveComptes
        '
        Me.tsbSaveComptes.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsbSaveComptes.Enabled = False
        Me.tsbSaveComptes.Image = Global.OGameObject.My.Resources.Resources.SAVE_24
        Me.tsbSaveComptes.ImageScaling = System.Windows.Forms.ToolStripItemImageScaling.None
        Me.tsbSaveComptes.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsbSaveComptes.Name = "tsbSaveComptes"
        Me.tsbSaveComptes.Size = New System.Drawing.Size(28, 34)
        Me.tsbSaveComptes.Text = "ToolStripButton1"
        Me.tsbSaveComptes.ToolTipText = "Enregistrer les informations de comptes"
        '
        'ToolStripSeparator2
        '
        Me.ToolStripSeparator2.Name = "ToolStripSeparator2"
        Me.ToolStripSeparator2.Size = New System.Drawing.Size(6, 37)
        '
        'tsButTestCompte
        '
        Me.tsButTestCompte.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsButTestCompte.Enabled = False
        Me.tsButTestCompte.Image = Global.OGameObject.My.Resources.Resources.computer_24
        Me.tsButTestCompte.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsButTestCompte.Name = "tsButTestCompte"
        Me.tsButTestCompte.Size = New System.Drawing.Size(28, 34)
        Me.tsButTestCompte.Text = "ToolStripButton1"
        Me.tsButTestCompte.ToolTipText = "Teste la connectivité et les informations avec le compte OGSpy sélectionné"
        '
        'btnLogin
        '
        Me.btnLogin.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnLogin.Image = Global.OGameObject.My.Resources.Resources.run_right_32
        Me.btnLogin.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.btnLogin.Name = "btnLogin"
        Me.btnLogin.Size = New System.Drawing.Size(28, 34)
        Me.btnLogin.Text = "Login"
        Me.btnLogin.ToolTipText = "Se logguer sur le serveur OGSpy dans IE Browser Tab"
        '
        'btnImport
        '
        Me.btnImport.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.btnImport.Image = Global.OGameObject.My.Resources.Resources.undo_24
        Me.btnImport.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.btnImport.Name = "btnImport"
        Me.btnImport.Size = New System.Drawing.Size(28, 34)
        Me.btnImport.Text = "ToolStripButton1"
        '
        'BackgroundWorker1
        '
        '
        'BackgroundWorker2
        '
        '
        'ImportExportCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.tcImportExport)
        Me.Name = "ImportExportCtrl"
        Me.Size = New System.Drawing.Size(578, 495)
        Me.tcImportExport.ResumeLayout(False)
        Me.tpBrowser.ResumeLayout(False)
        Me.tpImportExport.ResumeLayout(False)
        Me.tpImportExport.PerformLayout()
        Me.SplitContainerStat.Panel1.ResumeLayout(False)
        Me.SplitContainerStat.Panel2.ResumeLayout(False)
        Me.SplitContainerStat.ResumeLayout(False)
        Me.flpImport.ResumeLayout(False)
        Me.flpImport.PerformLayout()
        Me.flpExport.ResumeLayout(False)
        Me.flpExport.PerformLayout()
        Me.flpGalaxies.ResumeLayout(False)
        Me.gbGalaxieSelect.ResumeLayout(False)
        Me.gbGalaxieSelect.PerformLayout()
        Me.tsImportExportBar.ResumeLayout(False)
        Me.tsImportExportBar.PerformLayout()
        Me.tpComptes.ResumeLayout(False)
        Me.SplitContainerComptes.Panel1.ResumeLayout(False)
        Me.SplitContainerComptes.Panel2.ResumeLayout(False)
        Me.SplitContainerComptes.Panel2.PerformLayout()
        Me.SplitContainerComptes.ResumeLayout(False)
        Me.tsComptesBar.ResumeLayout(False)
        Me.tsComptesBar.PerformLayout()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents tcImportExport As System.Windows.Forms.TabControl
    Friend WithEvents tpComptes As System.Windows.Forms.TabPage
    Friend WithEvents tpImportExport As System.Windows.Forms.TabPage
    Friend WithEvents tsComptesBar As System.Windows.Forms.ToolStrip
    Friend WithEvents tsButAddCompte As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsButRemoveCompte As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsbCopyCompte As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripSeparator1 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents tsbSaveComptes As System.Windows.Forms.ToolStripButton
    Friend WithEvents SplitContainerComptes As System.Windows.Forms.SplitContainer
    Friend WithEvents lbComptes As System.Windows.Forms.ListBox
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents tbFriendlyName As System.Windows.Forms.TextBox
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbServerUrl As System.Windows.Forms.TextBox
    Friend WithEvents tbAccountName As System.Windows.Forms.TextBox
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents tbAccountPassword As System.Windows.Forms.TextBox
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents tbChunkSize As System.Windows.Forms.TextBox
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents chkDefaultAccount As System.Windows.Forms.CheckBox
    Friend WithEvents dtpLastExport As System.Windows.Forms.DateTimePicker
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents dtpLastImport As System.Windows.Forms.DateTimePicker
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents tsImportExportBar As System.Windows.Forms.ToolStrip
    Friend WithEvents tscbComptes As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents ToolStripSeparator2 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents tsButTestCompte As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsButExportImport As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsButImport As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsButExport As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsButCancel As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripDropDownButton1 As System.Windows.Forms.ToolStripDropDownButton
    Friend WithEvents tsmiSelectAllGalaxy As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents tsmiUnselectAllGalaxy As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents flpGalaxies As System.Windows.Forms.FlowLayoutPanel
    Friend WithEvents gbGalaxieSelect As System.Windows.Forms.GroupBox
    Friend WithEvents chkGal9 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal8 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal7 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal6 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal5 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal4 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal3 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal2 As System.Windows.Forms.CheckBox
    Friend WithEvents chkGal1 As System.Windows.Forms.CheckBox
    Friend WithEvents btnSelectAllGalaxy As System.Windows.Forms.Button
    Friend WithEvents btnUnselectAllGalaxy As System.Windows.Forms.Button
    Friend WithEvents flpExport As System.Windows.Forms.FlowLayoutPanel
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents dtpLastExport2 As System.Windows.Forms.DateTimePicker
    Friend WithEvents chkExportAll As System.Windows.Forms.CheckBox
    Friend WithEvents chkExportPlanets As System.Windows.Forms.CheckBox
    Friend WithEvents chkExportSpyReport As System.Windows.Forms.CheckBox
    Friend WithEvents flpImport As System.Windows.Forms.FlowLayoutPanel
    Friend WithEvents chkImportAll As System.Windows.Forms.CheckBox
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents dtpLastImport2 As System.Windows.Forms.DateTimePicker
    Friend WithEvents chkImportPlanets As System.Windows.Forms.CheckBox
    Friend WithEvents chkImportSpyReport As System.Windows.Forms.CheckBox
    Friend WithEvents Label11 As System.Windows.Forms.Label
    Friend WithEvents SplitContainerStat As System.Windows.Forms.SplitContainer
    Friend WithEvents rtbLogExportImport As System.Windows.Forms.RichTextBox
    Friend WithEvents tsButBrowserOgspy As System.Windows.Forms.ToolStripButton
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents btnExportStatsToOGSpy As System.Windows.Forms.Button
    Friend WithEvents btnRefreshStatsOGS As System.Windows.Forms.Button
    Friend WithEvents lbStatistiquesOGS As System.Windows.Forms.ListBox
    Friend WithEvents btnImportOGSpyStat As System.Windows.Forms.Button
    Friend WithEvents btnLoadStatOGSpy As System.Windows.Forms.Button
    Friend WithEvents lbStatistiquesOGSpy As System.Windows.Forms.ListBox
    Friend WithEvents Label13 As System.Windows.Forms.Label
    Friend WithEvents ToolStripMenuItem1 As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents ToolStripSeparator3 As System.Windows.Forms.ToolStripSeparator
    Friend WithEvents tpBrowser As System.Windows.Forms.TabPage
    Friend WithEvents OgameBrowserCtrl1 As OGameObject.OgameBrowserCtrl
    Friend WithEvents Label14 As System.Windows.Forms.Label
    Friend WithEvents btnLogin As System.Windows.Forms.ToolStripButton
    Friend WithEvents btnImport As System.Windows.Forms.ToolStripButton
    Friend WithEvents BackgroundWorker1 As System.ComponentModel.BackgroundWorker
    Friend WithEvents BackgroundWorker2 As System.ComponentModel.BackgroundWorker

End Class
