Public Class frmSelectRankType
    Inherits System.Windows.Forms.Form

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'Form overrides dispose to clean up the component list.
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Public WithEvents rbTotalPoints As System.Windows.Forms.RadioButton
    Public WithEvents rbFlottePoints As System.Windows.Forms.RadioButton
    Public WithEvents rbResearchPoints As System.Windows.Forms.RadioButton
    Friend WithEvents GroupBox2 As System.Windows.Forms.GroupBox
    Friend WithEvents dtpUpdate As System.Windows.Forms.DateTimePicker
    Public WithEvents rbUpdate1 As System.Windows.Forms.RadioButton
    Public WithEvents rbUpdate2 As System.Windows.Forms.RadioButton
    Public WithEvents rbUpdate3 As System.Windows.Forms.RadioButton
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Public WithEvents rbAllyTotalPoints As System.Windows.Forms.RadioButton
    Public WithEvents rbAlliFlottePoints As System.Windows.Forms.RadioButton
    Public WithEvents rbAlliResearchPoints As System.Windows.Forms.RadioButton
    Friend WithEvents chkConfirmDialog As System.Windows.Forms.CheckBox
    Friend WithEvents tbClipboardData As System.Windows.Forms.TextBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(frmSelectRankType))
        Me.Label1 = New System.Windows.Forms.Label
        Me.GroupBox1 = New System.Windows.Forms.GroupBox
        Me.rbTotalPoints = New System.Windows.Forms.RadioButton
        Me.rbAllyTotalPoints = New System.Windows.Forms.RadioButton
        Me.rbAlliFlottePoints = New System.Windows.Forms.RadioButton
        Me.rbFlottePoints = New System.Windows.Forms.RadioButton
        Me.rbAlliResearchPoints = New System.Windows.Forms.RadioButton
        Me.rbResearchPoints = New System.Windows.Forms.RadioButton
        Me.GroupBox2 = New System.Windows.Forms.GroupBox
        Me.rbUpdate1 = New System.Windows.Forms.RadioButton
        Me.dtpUpdate = New System.Windows.Forms.DateTimePicker
        Me.rbUpdate2 = New System.Windows.Forms.RadioButton
        Me.rbUpdate3 = New System.Windows.Forms.RadioButton
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.chkConfirmDialog = New System.Windows.Forms.CheckBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.Button2 = New System.Windows.Forms.Button
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.tbClipboardData = New System.Windows.Forms.TextBox
        Me.GroupBox1.SuspendLayout()
        Me.GroupBox2.SuspendLayout()
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        resources.ApplyResources(Me.Label1, "Label1")
        Me.Label1.Name = "Label1"
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.Add(Me.rbTotalPoints)
        Me.GroupBox1.Controls.Add(Me.rbAllyTotalPoints)
        Me.GroupBox1.Controls.Add(Me.rbAlliFlottePoints)
        Me.GroupBox1.Controls.Add(Me.rbFlottePoints)
        Me.GroupBox1.Controls.Add(Me.rbAlliResearchPoints)
        Me.GroupBox1.Controls.Add(Me.rbResearchPoints)
        resources.ApplyResources(Me.GroupBox1, "GroupBox1")
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.TabStop = False
        '
        'rbTotalPoints
        '
        Me.rbTotalPoints.Checked = True
        resources.ApplyResources(Me.rbTotalPoints, "rbTotalPoints")
        Me.rbTotalPoints.Name = "rbTotalPoints"
        Me.rbTotalPoints.TabStop = True
        '
        'rbAllyTotalPoints
        '
        resources.ApplyResources(Me.rbAllyTotalPoints, "rbAllyTotalPoints")
        Me.rbAllyTotalPoints.Name = "rbAllyTotalPoints"
        '
        'rbAlliFlottePoints
        '
        resources.ApplyResources(Me.rbAlliFlottePoints, "rbAlliFlottePoints")
        Me.rbAlliFlottePoints.Name = "rbAlliFlottePoints"
        '
        'rbFlottePoints
        '
        resources.ApplyResources(Me.rbFlottePoints, "rbFlottePoints")
        Me.rbFlottePoints.Name = "rbFlottePoints"
        '
        'rbAlliResearchPoints
        '
        resources.ApplyResources(Me.rbAlliResearchPoints, "rbAlliResearchPoints")
        Me.rbAlliResearchPoints.Name = "rbAlliResearchPoints"
        '
        'rbResearchPoints
        '
        resources.ApplyResources(Me.rbResearchPoints, "rbResearchPoints")
        Me.rbResearchPoints.Name = "rbResearchPoints"
        '
        'GroupBox2
        '
        Me.GroupBox2.Controls.Add(Me.rbUpdate1)
        Me.GroupBox2.Controls.Add(Me.dtpUpdate)
        Me.GroupBox2.Controls.Add(Me.rbUpdate2)
        Me.GroupBox2.Controls.Add(Me.rbUpdate3)
        resources.ApplyResources(Me.GroupBox2, "GroupBox2")
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.TabStop = False
        '
        'rbUpdate1
        '
        Me.rbUpdate1.Checked = True
        resources.ApplyResources(Me.rbUpdate1, "rbUpdate1")
        Me.rbUpdate1.Name = "rbUpdate1"
        Me.rbUpdate1.TabStop = True
        Me.ToolTip1.SetToolTip(Me.rbUpdate1, resources.GetString("rbUpdate1.ToolTip"))
        '
        'dtpUpdate
        '
        Me.dtpUpdate.Format = System.Windows.Forms.DateTimePickerFormat.[Short]
        resources.ApplyResources(Me.dtpUpdate, "dtpUpdate")
        Me.dtpUpdate.Name = "dtpUpdate"
        '
        'rbUpdate2
        '
        resources.ApplyResources(Me.rbUpdate2, "rbUpdate2")
        Me.rbUpdate2.Name = "rbUpdate2"
        Me.ToolTip1.SetToolTip(Me.rbUpdate2, resources.GetString("rbUpdate2.ToolTip"))
        '
        'rbUpdate3
        '
        resources.ApplyResources(Me.rbUpdate3, "rbUpdate3")
        Me.rbUpdate3.Name = "rbUpdate3"
        Me.ToolTip1.SetToolTip(Me.rbUpdate3, resources.GetString("rbUpdate3.ToolTip"))
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.chkConfirmDialog)
        Me.Panel1.Controls.Add(Me.Button1)
        Me.Panel1.Controls.Add(Me.Button2)
        resources.ApplyResources(Me.Panel1, "Panel1")
        Me.Panel1.Name = "Panel1"
        '
        'chkConfirmDialog
        '
        resources.ApplyResources(Me.chkConfirmDialog, "chkConfirmDialog")
        Me.chkConfirmDialog.Checked = True
        Me.chkConfirmDialog.CheckState = System.Windows.Forms.CheckState.Indeterminate
        Me.chkConfirmDialog.Name = "chkConfirmDialog"
        Me.chkConfirmDialog.UseVisualStyleBackColor = True
        '
        'Button1
        '
        Me.Button1.DialogResult = System.Windows.Forms.DialogResult.OK
        resources.ApplyResources(Me.Button1, "Button1")
        Me.Button1.Name = "Button1"
        '
        'Button2
        '
        Me.Button2.DialogResult = System.Windows.Forms.DialogResult.Cancel
        resources.ApplyResources(Me.Button2, "Button2")
        Me.Button2.Name = "Button2"
        '
        'tbClipboardData
        '
        resources.ApplyResources(Me.tbClipboardData, "tbClipboardData")
        Me.tbClipboardData.Name = "tbClipboardData"
        Me.tbClipboardData.ReadOnly = True
        '
        'frmSelectRankType
        '
        Me.AcceptButton = Me.Button1
        resources.ApplyResources(Me, "$this")
        Me.CancelButton = Me.Button2
        Me.Controls.Add(Me.tbClipboardData)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.GroupBox2)
        Me.Controls.Add(Me.GroupBox1)
        Me.Controls.Add(Me.Label1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedToolWindow
        Me.MaximizeBox = False
        Me.MinimizeBox = False
        Me.Name = "frmSelectRankType"
        Me.TopMost = True
        Me.GroupBox1.ResumeLayout(False)
        Me.GroupBox2.ResumeLayout(False)
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

#End Region

    Public Shared LastRankType As OGameObject.enRankType = OGameObject.enRankType.Points

    Private Sub rbTotalPoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbTotalPoints.CheckedChanged
        If rbTotalPoints.Checked Then LastRankType = OGameObject.enRankType.Points
    End Sub

    Private Sub rbFlottePoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbFlottePoints.CheckedChanged
        If rbFlottePoints.Checked Then LastRankType = OGameObject.enRankType.Flotte
    End Sub

    Private Sub rbResearchPoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbResearchPoints.CheckedChanged
        If rbResearchPoints.Checked Then LastRankType = OGameObject.enRankType.Research
    End Sub
    ''' <summary>
    ''' Variable fixe indiquant s'il faut une confirmation utilisateur à la rentrée des données de statistiques
    ''' </summary>
    ''' <remarks></remarks>
    Public Shared AutoConfirmStatsInsertion As Boolean = False

    Private Sub frmSelectRankType_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        chkConfirmDialog.Checked = Not AutoConfirmStatsInsertion
    End Sub

    Private Sub chkConfirmDialog_Leave(ByVal sender As Object, ByVal e As System.EventArgs) Handles chkConfirmDialog.Leave
        AutoConfirmStatsInsertion = Not chkConfirmDialog.Checked
    End Sub

    Private Sub rbAllyTotalPoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbAllyTotalPoints.CheckedChanged
        If rbAllyTotalPoints.Checked Then LastRankType = OGameObject.enRankType.AllyPoints
    End Sub

    Private Sub rbAlliFlottePoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbAlliFlottePoints.CheckedChanged
        If rbAlliFlottePoints.Checked Then LastRankType = OGameObject.enRankType.AllyFlotte
    End Sub

    Private Sub rbAlliResearchPoints_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rbAlliResearchPoints.CheckedChanged
        If rbAlliResearchPoints.Checked Then LastRankType = OGameObject.enRankType.AllyResearch
    End Sub
End Class
