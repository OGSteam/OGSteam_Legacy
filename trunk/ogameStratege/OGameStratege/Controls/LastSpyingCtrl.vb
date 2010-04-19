''' <summary>
''' Controle d'affichage des rapports d'espionages
''' </summary>
''' <remarks></remarks>
Public Class LastSpyingCtrl
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'UserControl overrides dispose to clean up the component list.
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
    Friend WithEvents panMain As System.Windows.Forms.Panel
    Friend WithEvents panAttackInfo As System.Windows.Forms.Panel
    Friend WithEvents rtbReport As System.Windows.Forms.RichTextBox
    Friend WithEvents panAttackInfoDown As System.Windows.Forms.Panel
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents lbDefenderInfo As System.Windows.Forms.Label
    Friend WithEvents lbDefender As System.Windows.Forms.Label
    Friend WithEvents lbAttackDate As System.Windows.Forms.Label
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents panAttackList As System.Windows.Forms.Panel
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents btnRefresh As System.Windows.Forms.Button
    Friend WithEvents lbAttackList As System.Windows.Forms.ListBox
    Friend WithEvents BtnLastReports As System.Windows.Forms.Button
    Friend WithEvents Label1 As System.Windows.Forms.Label
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.panMain = New System.Windows.Forms.Panel
        Me.panAttackInfo = New System.Windows.Forms.Panel
        Me.rtbReport = New System.Windows.Forms.RichTextBox
        Me.panAttackInfoDown = New System.Windows.Forms.Panel
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.lbDefenderInfo = New System.Windows.Forms.Label
        Me.lbDefender = New System.Windows.Forms.Label
        Me.lbAttackDate = New System.Windows.Forms.Label
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.panAttackList = New System.Windows.Forms.Panel
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.btnRefresh = New System.Windows.Forms.Button
        Me.Label1 = New System.Windows.Forms.Label
        Me.BtnLastReports = New System.Windows.Forms.Button
        Me.lbAttackList = New System.Windows.Forms.ListBox
        Me.panMain.SuspendLayout()
        Me.panAttackInfo.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.panAttackList.SuspendLayout()
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panMain.Controls.Add(Me.panAttackInfo)
        Me.panMain.Controls.Add(Me.Splitter1)
        Me.panMain.Controls.Add(Me.panAttackList)
        Me.panMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMain.Location = New System.Drawing.Point(0, 16)
        Me.panMain.Name = "panMain"
        Me.panMain.Size = New System.Drawing.Size(544, 296)
        Me.panMain.TabIndex = 3
        '
        'panAttackInfo
        '
        Me.panAttackInfo.Controls.Add(Me.rtbReport)
        Me.panAttackInfo.Controls.Add(Me.panAttackInfoDown)
        Me.panAttackInfo.Controls.Add(Me.Panel2)
        Me.panAttackInfo.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panAttackInfo.Location = New System.Drawing.Point(171, 0)
        Me.panAttackInfo.Name = "panAttackInfo"
        Me.panAttackInfo.Size = New System.Drawing.Size(369, 292)
        Me.panAttackInfo.TabIndex = 2
        '
        'rtbReport
        '
        Me.rtbReport.BackColor = System.Drawing.Color.DarkBlue
        Me.rtbReport.Dock = System.Windows.Forms.DockStyle.Fill
        Me.rtbReport.ForeColor = System.Drawing.Color.WhiteSmoke
        Me.rtbReport.Location = New System.Drawing.Point(0, 48)
        Me.rtbReport.Name = "rtbReport"
        Me.rtbReport.Size = New System.Drawing.Size(369, 212)
        Me.rtbReport.TabIndex = 2
        Me.rtbReport.Text = ""
        '
        'panAttackInfoDown
        '
        Me.panAttackInfoDown.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panAttackInfoDown.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.panAttackInfoDown.Location = New System.Drawing.Point(0, 260)
        Me.panAttackInfoDown.Name = "panAttackInfoDown"
        Me.panAttackInfoDown.Size = New System.Drawing.Size(369, 32)
        Me.panAttackInfoDown.TabIndex = 1
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.lbDefenderInfo)
        Me.Panel2.Controls.Add(Me.lbDefender)
        Me.Panel2.Controls.Add(Me.lbAttackDate)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel2.Location = New System.Drawing.Point(0, 0)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(369, 48)
        Me.Panel2.TabIndex = 0
        '
        'lbDefenderInfo
        '
        Me.lbDefenderInfo.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbDefenderInfo.Location = New System.Drawing.Point(0, 32)
        Me.lbDefenderInfo.Name = "lbDefenderInfo"
        Me.lbDefenderInfo.Size = New System.Drawing.Size(369, 16)
        Me.lbDefenderInfo.TabIndex = 11
        Me.lbDefenderInfo.Text = "Label5"
        '
        'lbDefender
        '
        Me.lbDefender.BackColor = System.Drawing.Color.Brown
        Me.lbDefender.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbDefender.ForeColor = System.Drawing.Color.White
        Me.lbDefender.Location = New System.Drawing.Point(0, 16)
        Me.lbDefender.Name = "lbDefender"
        Me.lbDefender.Size = New System.Drawing.Size(369, 16)
        Me.lbDefender.TabIndex = 10
        Me.lbDefender.Text = "Label4"
        Me.lbDefender.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbAttackDate
        '
        Me.lbAttackDate.BackColor = System.Drawing.SystemColors.Info
        Me.lbAttackDate.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbAttackDate.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbAttackDate.Location = New System.Drawing.Point(0, 0)
        Me.lbAttackDate.Name = "lbAttackDate"
        Me.lbAttackDate.Size = New System.Drawing.Size(369, 16)
        Me.lbAttackDate.TabIndex = 0
        Me.lbAttackDate.Text = "Label6"
        Me.lbAttackDate.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Splitter1
        '
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        Me.Splitter1.Location = New System.Drawing.Point(168, 0)
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.Size = New System.Drawing.Size(3, 292)
        Me.Splitter1.TabIndex = 1
        Me.Splitter1.TabStop = False
        '
        'panAttackList
        '
        Me.panAttackList.Controls.Add(Me.lbAttackList)
        Me.panAttackList.Controls.Add(Me.BtnLastReports)
        Me.panAttackList.Controls.Add(Me.Panel1)
        Me.panAttackList.Dock = System.Windows.Forms.DockStyle.Left
        Me.panAttackList.Location = New System.Drawing.Point(0, 0)
        Me.panAttackList.Name = "panAttackList"
        Me.panAttackList.Size = New System.Drawing.Size(168, 292)
        Me.panAttackList.TabIndex = 0
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.btnRefresh)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(168, 24)
        Me.Panel1.TabIndex = 0
        '
        'btnRefresh
        '
        Me.btnRefresh.Dock = System.Windows.Forms.DockStyle.Top
        Me.btnRefresh.Location = New System.Drawing.Point(0, 0)
        Me.btnRefresh.Name = "btnRefresh"
        Me.btnRefresh.Size = New System.Drawing.Size(168, 22)
        Me.btnRefresh.TabIndex = 0
        Me.btnRefresh.Text = "Refresh"
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(544, 16)
        Me.Label1.TabIndex = 2
        Me.Label1.Text = "Espionage reports"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'BtnLastReports
        '
        Me.BtnLastReports.Dock = System.Windows.Forms.DockStyle.Top
        Me.BtnLastReports.Location = New System.Drawing.Point(0, 32)
        Me.BtnLastReports.Name = "BtnLastReports"
        Me.BtnLastReports.Size = New System.Drawing.Size(168, 22)
        Me.BtnLastReports.TabIndex = 1
        Me.BtnLastReports.Text = "Derniers Rapports"
        Me.BtnLastReports.UseVisualStyleBackColor = True
        '
        'lbAttackList
        '
        Me.lbAttackList.BackColor = System.Drawing.SystemColors.Info
        Me.lbAttackList.Dock = System.Windows.Forms.DockStyle.Fill
        Me.lbAttackList.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbAttackList.IntegralHeight = False
        Me.lbAttackList.Location = New System.Drawing.Point(0, 55)
        Me.lbAttackList.Name = "lbAttackList"
        Me.lbAttackList.Size = New System.Drawing.Size(168, 237)
        Me.lbAttackList.TabIndex = 3
        '
        'LastSpyingCtrl
        '
        Me.Controls.Add(Me.panMain)
        Me.Controls.Add(Me.Label1)
        Me.Name = "LastSpyingCtrl"
        Me.Size = New System.Drawing.Size(544, 312)
        Me.panMain.ResumeLayout(False)
        Me.panAttackInfo.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.panAttackList.ResumeLayout(False)
        Me.Panel1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub LastAttacksCtrl_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        resetInfoPanel()
    End Sub
    ''' <summary>
    ''' Mise à zero des différents elements du formulaire
    ''' </summary>
    ''' <remarks></remarks>
    Private Sub resetInfoPanel()
        lbAttackDate.Text = ""
        lbDefender.Text = ""
        lbDefenderInfo.Text = ""
        rtbReport.Text = ""
    End Sub
    ''' <summary>
    ''' Renvoie la totalité des rapports d'espionages
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub btnRefresh_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnRefresh.Click
        If Not OGameObject.OGameDBEngine.Default Is Nothing Then
            Dim u As New Splash
            u.Owner = Me.FindForm
            u.Message = "Retrieving Espionage Data"
            u.Show()
            u.Refresh()
            lbAttackList.Items.Clear()
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            For Each ar As OGameObject.SpyReport In OGameObject.OGameDBEngine.Default.EspionagesReportCol
                lbAttackList.Items.Add(ar)
            Next
            Me.Cursor = System.Windows.Forms.Cursors.Default
            u.Close()
        End If
    End Sub
    ''' <summary>
    ''' Réagit à une selection d'un rapport d'espionage dans la liste
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub lbAttackList_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbAttackList.SelectedIndexChanged
        If lbAttackList.SelectedItem Is Nothing Then
            resetInfoPanel()
        Else
            With CType(lbAttackList.SelectedItem, OGameObject.SpyReport)
                lbAttackDate.Text = "Combat Report on " & .DataDate.ToString

                lbDefender.Text = .Planet.Coords & " - Player : " & .Planet.Owner.Name & IIf(.Planet.Owner.Alliance.Trim <> "", " from alliance " & .Planet.Owner.Alliance, "")
                rtbReport.Text = .RawReport
            End With
        End If
    End Sub
    ''' <summary>
    ''' Retrouve les 40 derniers rapports d'espionages
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <param name="e"></param>
    ''' <remarks></remarks>
    Private Sub BtnLastReports_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnLastReports.Click
        If Not OGameObject.OGameDBEngine.Default Is Nothing Then
            Dim u As New Splash
            u.Owner = Me.FindForm
            u.Message = "Retrieving Espionage Data"
            u.Show()
            u.Refresh()
            lbAttackList.Items.Clear()
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
            For Each ar As OGameObject.SpyReport In OGameObject.OGameDBEngine.Default.EspionagesReportCol(40)
                lbAttackList.Items.Add(ar)
            Next
            Me.Cursor = System.Windows.Forms.Cursors.Default
            u.Close()
        End If

    End Sub
End Class
