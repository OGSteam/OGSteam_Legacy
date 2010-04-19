Imports System.Text.RegularExpressions
Public Class AlliancePlayerCtrl
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents tbSearchPattern As System.Windows.Forms.TextBox
    Friend WithEvents cbSearchType As System.Windows.Forms.ComboBox
    Friend WithEvents btnSearch As System.Windows.Forms.Button
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents panLeft As System.Windows.Forms.Panel
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents panRightUp As System.Windows.Forms.Panel
    Friend WithEvents lbPlanets As System.Windows.Forms.ListBox
    Friend WithEvents Splitter2 As System.Windows.Forms.Splitter
    Friend WithEvents panRightDown As System.Windows.Forms.Panel
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents lbSearchResults As System.Windows.Forms.ListBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents tbCountSpyReport As System.Windows.Forms.TextBox
    Friend WithEvents TrackBar1 As System.Windows.Forms.TrackBar
    Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox
    Friend WithEvents rtbSpyReport As System.Windows.Forms.RichTextBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.panMain = New System.Windows.Forms.Panel
        Me.panRightDown = New System.Windows.Forms.Panel
        Me.rtbSpyReport = New System.Windows.Forms.RichTextBox
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.TrackBar1 = New System.Windows.Forms.TrackBar
        Me.tbCountSpyReport = New System.Windows.Forms.TextBox
        Me.Label3 = New System.Windows.Forms.Label
        Me.Splitter2 = New System.Windows.Forms.Splitter
        Me.panRightUp = New System.Windows.Forms.Panel
        Me.lbPlanets = New System.Windows.Forms.ListBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.panLeft = New System.Windows.Forms.Panel
        Me.lbSearchResults = New System.Windows.Forms.ListBox
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.Button1 = New System.Windows.Forms.Button
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.ComboBox1 = New System.Windows.Forms.ComboBox
        Me.Label4 = New System.Windows.Forms.Label
        Me.btnSearch = New System.Windows.Forms.Button
        Me.cbSearchType = New System.Windows.Forms.ComboBox
        Me.tbSearchPattern = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.panMain.SuspendLayout()
        Me.panRightDown.SuspendLayout()
        Me.Panel3.SuspendLayout()
        CType(Me.TrackBar1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.panRightUp.SuspendLayout()
        Me.panLeft.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panMain.Controls.Add(Me.panRightDown)
        Me.panMain.Controls.Add(Me.Splitter2)
        Me.panMain.Controls.Add(Me.panRightUp)
        Me.panMain.Controls.Add(Me.Label2)
        Me.panMain.Controls.Add(Me.Splitter1)
        Me.panMain.Controls.Add(Me.panLeft)
        Me.panMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMain.Location = New System.Drawing.Point(0, 0)
        Me.panMain.Name = "panMain"
        Me.panMain.Size = New System.Drawing.Size(408, 352)
        Me.panMain.TabIndex = 0
        '
        'panRightDown
        '
        Me.panRightDown.Controls.Add(Me.rtbSpyReport)
        Me.panRightDown.Controls.Add(Me.Panel3)
        Me.panRightDown.Controls.Add(Me.Label3)
        Me.panRightDown.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panRightDown.Location = New System.Drawing.Point(179, 139)
        Me.panRightDown.Name = "panRightDown"
        Me.panRightDown.Size = New System.Drawing.Size(225, 209)
        Me.panRightDown.TabIndex = 5
        '
        'rtbSpyReport
        '
        Me.rtbSpyReport.BackColor = System.Drawing.Color.DimGray
        Me.rtbSpyReport.Dock = System.Windows.Forms.DockStyle.Fill
        Me.rtbSpyReport.ForeColor = System.Drawing.Color.Gainsboro
        Me.rtbSpyReport.Location = New System.Drawing.Point(0, 40)
        Me.rtbSpyReport.Name = "rtbSpyReport"
        Me.rtbSpyReport.Size = New System.Drawing.Size(225, 169)
        Me.rtbSpyReport.TabIndex = 5
        Me.rtbSpyReport.Text = ""
        '
        'Panel3
        '
        Me.Panel3.Controls.Add(Me.TrackBar1)
        Me.Panel3.Controls.Add(Me.tbCountSpyReport)
        Me.Panel3.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel3.Location = New System.Drawing.Point(0, 16)
        Me.Panel3.Name = "Panel3"
        Me.Panel3.Size = New System.Drawing.Size(225, 24)
        Me.Panel3.TabIndex = 4
        '
        'TrackBar1
        '
        Me.TrackBar1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.TrackBar1.Location = New System.Drawing.Point(56, 0)
        Me.TrackBar1.Maximum = 0
        Me.TrackBar1.Name = "TrackBar1"
        Me.TrackBar1.Size = New System.Drawing.Size(169, 24)
        Me.TrackBar1.TabIndex = 1
        '
        'tbCountSpyReport
        '
        Me.tbCountSpyReport.Dock = System.Windows.Forms.DockStyle.Left
        Me.tbCountSpyReport.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tbCountSpyReport.Location = New System.Drawing.Point(0, 0)
        Me.tbCountSpyReport.Name = "tbCountSpyReport"
        Me.tbCountSpyReport.ReadOnly = True
        Me.tbCountSpyReport.Size = New System.Drawing.Size(56, 20)
        Me.tbCountSpyReport.TabIndex = 0
        Me.tbCountSpyReport.Text = "0/0"
        Me.tbCountSpyReport.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        '
        'Label3
        '
        Me.Label3.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label3.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label3.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.Label3.Location = New System.Drawing.Point(0, 0)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(225, 16)
        Me.Label3.TabIndex = 3
        Me.Label3.Text = "Spying Reports"
        Me.Label3.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Splitter2
        '
        Me.Splitter2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Splitter2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Splitter2.Location = New System.Drawing.Point(179, 136)
        Me.Splitter2.Name = "Splitter2"
        Me.Splitter2.Size = New System.Drawing.Size(225, 3)
        Me.Splitter2.TabIndex = 4
        Me.Splitter2.TabStop = False
        '
        'panRightUp
        '
        Me.panRightUp.Controls.Add(Me.lbPlanets)
        Me.panRightUp.Dock = System.Windows.Forms.DockStyle.Top
        Me.panRightUp.Location = New System.Drawing.Point(179, 16)
        Me.panRightUp.Name = "panRightUp"
        Me.panRightUp.Size = New System.Drawing.Size(225, 120)
        Me.panRightUp.TabIndex = 3
        '
        'lbPlanets
        '
        Me.lbPlanets.BackColor = System.Drawing.SystemColors.Info
        Me.lbPlanets.Dock = System.Windows.Forms.DockStyle.Fill
        Me.lbPlanets.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbPlanets.IntegralHeight = False
        Me.lbPlanets.Location = New System.Drawing.Point(0, 0)
        Me.lbPlanets.Name = "lbPlanets"
        Me.lbPlanets.Size = New System.Drawing.Size(225, 120)
        Me.lbPlanets.TabIndex = 0
        '
        'Label2
        '
        Me.Label2.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.Label2.Location = New System.Drawing.Point(179, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(225, 16)
        Me.Label2.TabIndex = 2
        Me.Label2.Text = "Planets"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Splitter1
        '
        Me.Splitter1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Splitter1.Location = New System.Drawing.Point(176, 0)
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.Size = New System.Drawing.Size(3, 348)
        Me.Splitter1.TabIndex = 1
        Me.Splitter1.TabStop = False
        '
        'panLeft
        '
        Me.panLeft.Controls.Add(Me.lbSearchResults)
        Me.panLeft.Controls.Add(Me.Panel2)
        Me.panLeft.Controls.Add(Me.Panel1)
        Me.panLeft.Controls.Add(Me.btnSearch)
        Me.panLeft.Controls.Add(Me.cbSearchType)
        Me.panLeft.Controls.Add(Me.tbSearchPattern)
        Me.panLeft.Controls.Add(Me.Label1)
        Me.panLeft.Dock = System.Windows.Forms.DockStyle.Left
        Me.panLeft.Location = New System.Drawing.Point(0, 0)
        Me.panLeft.Name = "panLeft"
        Me.panLeft.Size = New System.Drawing.Size(176, 348)
        Me.panLeft.TabIndex = 0
        '
        'lbSearchResults
        '
        Me.lbSearchResults.BackColor = System.Drawing.SystemColors.Info
        Me.lbSearchResults.Dock = System.Windows.Forms.DockStyle.Fill
        Me.lbSearchResults.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbSearchResults.IntegralHeight = False
        Me.lbSearchResults.Location = New System.Drawing.Point(0, 128)
        Me.lbSearchResults.Name = "lbSearchResults"
        Me.lbSearchResults.SelectionMode = System.Windows.Forms.SelectionMode.MultiExtended
        Me.lbSearchResults.Size = New System.Drawing.Size(176, 196)
        Me.lbSearchResults.TabIndex = 10
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.Button1)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Panel2.Location = New System.Drawing.Point(0, 324)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(176, 24)
        Me.Panel2.TabIndex = 6
        '
        'Button1
        '
        Me.Button1.Enabled = False
        Me.Button1.Location = New System.Drawing.Point(0, 0)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(88, 23)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "..To clipboard"
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.ComboBox1)
        Me.Panel1.Controls.Add(Me.Label4)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 80)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(176, 48)
        Me.Panel1.TabIndex = 5
        '
        'ComboBox1
        '
        Me.ComboBox1.Dock = System.Windows.Forms.DockStyle.Top
        Me.ComboBox1.Location = New System.Drawing.Point(0, 16)
        Me.ComboBox1.Name = "ComboBox1"
        Me.ComboBox1.Size = New System.Drawing.Size(176, 21)
        Me.ComboBox1.TabIndex = 2
        '
        'Label4
        '
        Me.Label4.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label4.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label4.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.Label4.Location = New System.Drawing.Point(0, 0)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(176, 16)
        Me.Label4.TabIndex = 1
        Me.Label4.Text = "Favorites"
        Me.Label4.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'btnSearch
        '
        Me.btnSearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.btnSearch.Enabled = False
        Me.btnSearch.FlatStyle = System.Windows.Forms.FlatStyle.System
        Me.btnSearch.Location = New System.Drawing.Point(0, 57)
        Me.btnSearch.Name = "btnSearch"
        Me.btnSearch.Size = New System.Drawing.Size(176, 23)
        Me.btnSearch.TabIndex = 4
        Me.btnSearch.Text = "Search"
        '
        'cbSearchType
        '
        Me.cbSearchType.Dock = System.Windows.Forms.DockStyle.Top
        Me.cbSearchType.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbSearchType.Items.AddRange(New Object() {"Players from Alliance", "Player name", "Main Planet Coords"})
        Me.cbSearchType.Location = New System.Drawing.Point(0, 36)
        Me.cbSearchType.Name = "cbSearchType"
        Me.cbSearchType.Size = New System.Drawing.Size(176, 21)
        Me.cbSearchType.TabIndex = 2
        '
        'tbSearchPattern
        '
        Me.tbSearchPattern.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbSearchPattern.Location = New System.Drawing.Point(0, 16)
        Me.tbSearchPattern.Name = "tbSearchPattern"
        Me.tbSearchPattern.Size = New System.Drawing.Size(176, 20)
        Me.tbSearchPattern.TabIndex = 1
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(176, 16)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Search"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'AlliancePlayerCtrl
        '
        Me.Controls.Add(Me.panMain)
        Me.Name = "AlliancePlayerCtrl"
        Me.Size = New System.Drawing.Size(408, 352)
        Me.panMain.ResumeLayout(False)
        Me.panRightDown.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.Panel3.PerformLayout()
        CType(Me.TrackBar1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.panRightUp.ResumeLayout(False)
        Me.panLeft.ResumeLayout(False)
        Me.panLeft.PerformLayout()
        Me.Panel2.ResumeLayout(False)
        Me.Panel1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

#Region "  Events "
    Public Event PlayerSelected(ByVal Player As OGameObject.Player)
    Public Event PlanetSelected(ByVal Planet As OGameObject.Planet)
#End Region
    Private Sub panMain_Paint(ByVal sender As System.Object, ByVal e As System.Windows.Forms.PaintEventArgs) Handles panMain.Paint

    End Sub

    Private Sub AlliancePlayerCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        cbSearchType.SelectedIndex = 1
    End Sub

    Private Sub tbSearchPattern_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles tbSearchPattern.TextChanged
        btnSearch.Enabled = tbSearchPattern.Text.Trim.Length > 1
    End Sub
    Public Sub SelectPlanet(ByVal planet As OGameObject.Planet)
        If planet Is Nothing Then Return
        If planet.Owner Is Nothing Then Return
        SelectPlayer(planet.Owner)
        For Each p As OGameObject.Planet In lbPlanets.Items
            If p.Coords = planet.Coords Then
                lbPlanets.SelectedItem = p
                Application.DoEvents()
                Exit Sub
            End If
        Next
    End Sub
    Public Sub SelectPlayer(ByVal player As OGameObject.Player)
        lbSearchResults.Items.Clear()
        If player Is Nothing Then Return
        lbSearchResults.Items.Add(player)
        lbSearchResults.SelectedItem = player
    End Sub
    Protected Friend Sub btnSearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSearch.Click
        lbSearchResults.Items.Clear()
        lbPlanets.Items.Clear()

        'Dim CoordPattern As String = "(?<Gal>[1-9]):(?<Sys>[0-9]+)"
        'Dim m As Match = Regex.Match(tbSearchPattern.Text, CoordPattern)

        'If m.Success Then

        'Else
        With OGameObject.OGameDBEngine.Default
            Dim plcol As OGameObject.PlayerCol
            If cbSearchType.SelectedIndex = 0 Then
                plcol = .PlayersFromTag(tbSearchPattern.Text)
            Else
                plcol = .SearchPlayers(tbSearchPattern.Text, True)
            End If

            If plcol.Count Then
                For Each o As OGameObject.Player In plcol
                    o.TOStringFormat = OGameObject.Player.enToStringFormat.AllianceNamePMID
                    lbSearchResults.Items.Add(o)
                Next
            End If
        End With
        'End If
    End Sub
    Private Sub lbSearchResults_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbSearchResults.SelectedIndexChanged
        'Private Sub lbSearchResults_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs)
        lbPlanets.SuspendLayout()
        lbPlanets.Items.Clear()
        RaiseEvent PlayerSelected(lbSearchResults.SelectedItem)
        If lbSearchResults.SelectedItem Is Nothing Then Return

        For Each pl As OGameObject.Player In lbSearchResults.SelectedItems
            For Each o As OGameObject.Planet In pl.Planets
                o.ToStringFormat = OGameObject.Planet.enToStringFormat.CoordsAllyPlayer
                lbPlanets.Items.Add(o)
            Next
        Next

        lbPlanets.ResumeLayout()
    End Sub


    Private Sub tbSearchPattern_KeyPress(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyPressEventArgs) Handles tbSearchPattern.KeyPress, cbSearchType.KeyPress
        If e.KeyChar = Chr(13) Then
            e.Handled = True
            btnSearch_Click(Nothing, Nothing)
            Exit Sub
        End If
    End Sub

    Private Sub lbPlanets_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbPlanets.SelectedIndexChanged
        RaiseEvent PlanetSelected(lbPlanets.SelectedItem)
        rtbSpyReport.Text = ""
        If lbPlanets.SelectedItem Is Nothing Then
            TrackBar1.Maximum = 0
            TrackBar1.Value = 0
            tbCountSpyReport.Text = "0/0"
            Return
        End If
        With CType(lbPlanets.SelectedItem, OGameObject.Planet)
            TrackBar1.Value = 0
            TrackBar1.Maximum = .SpyingReports.Count
            If .SpyingReports.Count > 0 Then
                TrackBar1.Value = 1
            End If
            tbCountSpyReport.Text = TrackBar1.Value & "/" & TrackBar1.Maximum
        End With

    End Sub


    Private Sub TrackBar1_ValueChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles TrackBar1.ValueChanged
        tbCountSpyReport.Text = TrackBar1.Value & "/" & TrackBar1.Maximum
        rtbSpyReport.Text = ""
        Try
            If lbPlanets.SelectedItem Is Nothing Then Return
            With CType(lbPlanets.SelectedItem, OGameObject.Planet)
                rtbSpyReport.Text = .SpyingReports.Item(TrackBar1.Value - 1).RawReport
                ColorSpyingReport(rtbSpyReport)
            End With
        Catch ex As Exception

        End Try
    End Sub
End Class
