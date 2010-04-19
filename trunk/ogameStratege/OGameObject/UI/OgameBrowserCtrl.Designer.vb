<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class OgameBrowserCtrl
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
        Me.ToolStrip1 = New System.Windows.Forms.ToolStrip
        Me.tscbURL = New System.Windows.Forms.ToolStripComboBox
        Me.tsbutGo = New System.Windows.Forms.ToolStripButton
        Me.tsbutShowHidePanel = New System.Windows.Forms.ToolStripButton
        Me.ToolStripButton1 = New System.Windows.Forms.ToolStripButton
        Me.ToolStripDropDownButton1 = New System.Windows.Forms.ToolStripDropDownButton
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem = New System.Windows.Forms.ToolStripMenuItem
        Me.StatusStrip1 = New System.Windows.Forms.StatusStrip
        Me.tstlStatus = New System.Windows.Forms.ToolStripStatusLabel
        Me.HauptFrameToolStripStatusLabel1 = New System.Windows.Forms.ToolStripStatusLabel
        Me.SplitContainer1 = New System.Windows.Forms.SplitContainer
        Me.WebBrowser1 = New System.Windows.Forms.WebBrowser
        Me.ToolStripButtonSaveAccountInfo = New System.Windows.Forms.ToolStripButton
        Me.ToolStripButtonApplyAccountInfo = New System.Windows.Forms.ToolStripButton
        Me.ToolStrip1.SuspendLayout()
        Me.StatusStrip1.SuspendLayout()
        Me.SplitContainer1.Panel2.SuspendLayout()
        Me.SplitContainer1.SuspendLayout()
        Me.SuspendLayout()
        '
        'ToolStrip1
        '
        Me.ToolStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.tscbURL, Me.tsbutGo, Me.tsbutShowHidePanel, Me.ToolStripButton1, Me.ToolStripDropDownButton1, Me.ToolStripButtonSaveAccountInfo, Me.ToolStripButtonApplyAccountInfo})
        Me.ToolStrip1.Location = New System.Drawing.Point(0, 0)
        Me.ToolStrip1.Name = "ToolStrip1"
        Me.ToolStrip1.Size = New System.Drawing.Size(564, 25)
        Me.ToolStrip1.TabIndex = 0
        Me.ToolStrip1.Text = "ToolStrip1"
        '
        'tscbURL
        '
        Me.tscbURL.AutoCompleteMode = System.Windows.Forms.AutoCompleteMode.SuggestAppend
        Me.tscbURL.AutoCompleteSource = System.Windows.Forms.AutoCompleteSource.AllUrl
        Me.tscbURL.Items.AddRange(New Object() {"http://ogsteam.fr", "http://www.ogame.fr"})
        Me.tscbURL.Name = "tscbURL"
        Me.tscbURL.Size = New System.Drawing.Size(250, 25)
        Me.tscbURL.Text = "http://www.ogame.fr"
        '
        'tsbutGo
        '
        Me.tsbutGo.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsbutGo.Image = Global.OGameObject.My.Resources.Resources.run_right_32
        Me.tsbutGo.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsbutGo.Name = "tsbutGo"
        Me.tsbutGo.Size = New System.Drawing.Size(23, 22)
        Me.tsbutGo.Text = "Naviguer"
        Me.tsbutGo.ToolTipText = "Naviguer - Go"
        '
        'tsbutShowHidePanel
        '
        Me.tsbutShowHidePanel.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.tsbutShowHidePanel.Image = Global.OGameObject.My.Resources.Resources._41_ico_1
        Me.tsbutShowHidePanel.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.tsbutShowHidePanel.Name = "tsbutShowHidePanel"
        Me.tsbutShowHidePanel.Size = New System.Drawing.Size(23, 22)
        Me.tsbutShowHidePanel.Text = "Cache/Montre panneau"
        '
        'ToolStripButton1
        '
        Me.ToolStripButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButton1.Image = Global.OGameObject.My.Resources.Resources.forbid
        Me.ToolStripButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButton1.Name = "ToolStripButton1"
        Me.ToolStripButton1.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButton1.Text = "ToolStripButton1"
        '
        'ToolStripDropDownButton1
        '
        Me.ToolStripDropDownButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripDropDownButton1.DropDownItems.AddRange(New System.Windows.Forms.ToolStripItem() {Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem})
        Me.ToolStripDropDownButton1.Image = Global.OGameObject.My.Resources.Resources.applications_24
        Me.ToolStripDropDownButton1.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripDropDownButton1.Name = "ToolStripDropDownButton1"
        Me.ToolStripDropDownButton1.Size = New System.Drawing.Size(29, 22)
        Me.ToolStripDropDownButton1.Text = "Options"
        '
        'ConfirmerLentreeDesStatistiquesToolStripMenuItem
        '
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.Checked = True
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.CheckOnClick = True
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.Name = "ConfirmerLentreeDesStatistiquesToolStripMenuItem"
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.Size = New System.Drawing.Size(249, 22)
        Me.ConfirmerLentreeDesStatistiquesToolStripMenuItem.Text = "Confirmer l'entree des statistiques"
        '
        'StatusStrip1
        '
        Me.StatusStrip1.Items.AddRange(New System.Windows.Forms.ToolStripItem() {Me.tstlStatus, Me.HauptFrameToolStripStatusLabel1})
        Me.StatusStrip1.Location = New System.Drawing.Point(0, 341)
        Me.StatusStrip1.Name = "StatusStrip1"
        Me.StatusStrip1.Size = New System.Drawing.Size(564, 23)
        Me.StatusStrip1.TabIndex = 1
        Me.StatusStrip1.Text = "StatusStrip1"
        '
        'tstlStatus
        '
        Me.tstlStatus.Name = "tstlStatus"
        Me.tstlStatus.Size = New System.Drawing.Size(442, 18)
        Me.tstlStatus.Spring = True
        Me.tstlStatus.Text = "OGame Stratege - OGSTeam"
        Me.tstlStatus.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'HauptFrameToolStripStatusLabel1
        '
        Me.HauptFrameToolStripStatusLabel1.BackColor = System.Drawing.Color.Black
        Me.HauptFrameToolStripStatusLabel1.Font = New System.Drawing.Font("Verdana", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.HauptFrameToolStripStatusLabel1.ForeColor = System.Drawing.Color.Gold
        Me.HauptFrameToolStripStatusLabel1.Name = "HauptFrameToolStripStatusLabel1"
        Me.HauptFrameToolStripStatusLabel1.Size = New System.Drawing.Size(107, 18)
        Me.HauptFrameToolStripStatusLabel1.Text = "HauptFrame"
        '
        'SplitContainer1
        '
        Me.SplitContainer1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.SplitContainer1.Location = New System.Drawing.Point(0, 25)
        Me.SplitContainer1.Name = "SplitContainer1"
        Me.SplitContainer1.Panel1Collapsed = True
        '
        'SplitContainer1.Panel2
        '
        Me.SplitContainer1.Panel2.Controls.Add(Me.WebBrowser1)
        Me.SplitContainer1.Size = New System.Drawing.Size(564, 316)
        Me.SplitContainer1.SplitterDistance = 107
        Me.SplitContainer1.TabIndex = 2
        '
        'WebBrowser1
        '
        Me.WebBrowser1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.WebBrowser1.Location = New System.Drawing.Point(0, 0)
        Me.WebBrowser1.MinimumSize = New System.Drawing.Size(20, 20)
        Me.WebBrowser1.Name = "WebBrowser1"
        Me.WebBrowser1.ScriptErrorsSuppressed = True
        Me.WebBrowser1.Size = New System.Drawing.Size(564, 316)
        Me.WebBrowser1.TabIndex = 0
        '
        'ToolStripButtonSaveAccountInfo
        '
        Me.ToolStripButtonSaveAccountInfo.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButtonSaveAccountInfo.Image = Global.OGameObject.My.Resources.Resources.SAVE_24
        Me.ToolStripButtonSaveAccountInfo.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButtonSaveAccountInfo.Name = "ToolStripButtonSaveAccountInfo"
        Me.ToolStripButtonSaveAccountInfo.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButtonSaveAccountInfo.Text = "ToolStripButton2"
        Me.ToolStripButtonSaveAccountInfo.ToolTipText = "Sauvegarde des informations de login pour cet univers"
        '
        'ToolStripButtonApplyAccountInfo
        '
        Me.ToolStripButtonApplyAccountInfo.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image
        Me.ToolStripButtonApplyAccountInfo.Image = Global.OGameObject.My.Resources.Resources.mail_glaze_f
        Me.ToolStripButtonApplyAccountInfo.ImageTransparentColor = System.Drawing.Color.Magenta
        Me.ToolStripButtonApplyAccountInfo.Name = "ToolStripButtonApplyAccountInfo"
        Me.ToolStripButtonApplyAccountInfo.Size = New System.Drawing.Size(23, 22)
        Me.ToolStripButtonApplyAccountInfo.Text = "ToolStripButton2"
        Me.ToolStripButtonApplyAccountInfo.ToolTipText = "Remplit les champs du formulaire de login avec les informations présentes en base" & _
            " de donnée"
        '
        'OgameBrowserCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.Controls.Add(Me.SplitContainer1)
        Me.Controls.Add(Me.StatusStrip1)
        Me.Controls.Add(Me.ToolStrip1)
        Me.Name = "OgameBrowserCtrl"
        Me.Size = New System.Drawing.Size(564, 364)
        Me.ToolStrip1.ResumeLayout(False)
        Me.ToolStrip1.PerformLayout()
        Me.StatusStrip1.ResumeLayout(False)
        Me.StatusStrip1.PerformLayout()
        Me.SplitContainer1.Panel2.ResumeLayout(False)
        Me.SplitContainer1.ResumeLayout(False)
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents ToolStrip1 As System.Windows.Forms.ToolStrip
    Friend WithEvents StatusStrip1 As System.Windows.Forms.StatusStrip
    Friend WithEvents tstlStatus As System.Windows.Forms.ToolStripStatusLabel
    Friend WithEvents SplitContainer1 As System.Windows.Forms.SplitContainer
    Friend WithEvents tsbutGo As System.Windows.Forms.ToolStripButton
    Friend WithEvents tsbutShowHidePanel As System.Windows.Forms.ToolStripButton
    Public WithEvents WebBrowser1 As System.Windows.Forms.WebBrowser
    Friend WithEvents ToolStripButton1 As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripDropDownButton1 As System.Windows.Forms.ToolStripDropDownButton
    Public WithEvents ConfirmerLentreeDesStatistiquesToolStripMenuItem As System.Windows.Forms.ToolStripMenuItem
    Friend WithEvents HauptFrameToolStripStatusLabel1 As System.Windows.Forms.ToolStripStatusLabel
    Public WithEvents tscbURL As System.Windows.Forms.ToolStripComboBox
    Friend WithEvents ToolStripButtonSaveAccountInfo As System.Windows.Forms.ToolStripButton
    Friend WithEvents ToolStripButtonApplyAccountInfo As System.Windows.Forms.ToolStripButton

End Class
