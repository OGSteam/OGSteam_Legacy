Public Class PlayersStatsCtrl
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
    Public WithEvents panMain As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents lbStatisticsDate As System.Windows.Forms.ListBox
    Friend WithEvents panStatsInfo As System.Windows.Forms.Panel
    Friend WithEvents cbStatsType As System.Windows.Forms.ComboBox
    Friend WithEvents panGraph As System.Windows.Forms.Panel
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents dgStatsResults As System.Windows.Forms.DataGrid
    Friend WithEvents OgsPlayerStatsGraph1 As OGameStratege.OGSPlayerStatsGraph
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.panMain = New System.Windows.Forms.Panel
        Me.panStatsInfo = New System.Windows.Forms.Panel
        Me.dgStatsResults = New System.Windows.Forms.DataGrid
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.panGraph = New System.Windows.Forms.Panel
        Me.OgsPlayerStatsGraph1 = New OGameStratege.OGSPlayerStatsGraph
        Me.cbStatsType = New System.Windows.Forms.ComboBox
        Me.lbStatisticsDate = New System.Windows.Forms.ListBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.panMain.SuspendLayout()
        Me.panStatsInfo.SuspendLayout()
        CType(Me.dgStatsResults, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.panGraph.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panMain.Controls.Add(Me.panStatsInfo)
        Me.panMain.Controls.Add(Me.lbStatisticsDate)
        Me.panMain.Controls.Add(Me.Label1)
        Me.panMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMain.Location = New System.Drawing.Point(0, 0)
        Me.panMain.Name = "panMain"
        Me.panMain.Size = New System.Drawing.Size(576, 408)
        Me.panMain.TabIndex = 0
        '
        'panStatsInfo
        '
        Me.panStatsInfo.Controls.Add(Me.dgStatsResults)
        Me.panStatsInfo.Controls.Add(Me.Splitter1)
        Me.panStatsInfo.Controls.Add(Me.panGraph)
        Me.panStatsInfo.Controls.Add(Me.cbStatsType)
        Me.panStatsInfo.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panStatsInfo.Location = New System.Drawing.Point(120, 16)
        Me.panStatsInfo.Name = "panStatsInfo"
        Me.panStatsInfo.Size = New System.Drawing.Size(452, 388)
        Me.panStatsInfo.TabIndex = 2
        '
        'dgStatsResults
        '
        Me.dgStatsResults.AlternatingBackColor = System.Drawing.Color.White
        Me.dgStatsResults.BackColor = System.Drawing.Color.White
        Me.dgStatsResults.BackgroundColor = System.Drawing.Color.Gainsboro
        Me.dgStatsResults.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.dgStatsResults.CaptionBackColor = System.Drawing.Color.Silver
        Me.dgStatsResults.CaptionFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgStatsResults.CaptionForeColor = System.Drawing.Color.Black
        Me.dgStatsResults.CaptionVisible = False
        Me.dgStatsResults.DataMember = ""
        Me.dgStatsResults.Dock = System.Windows.Forms.DockStyle.Fill
        Me.dgStatsResults.FlatMode = True
        Me.dgStatsResults.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgStatsResults.ForeColor = System.Drawing.Color.DarkSlateGray
        Me.dgStatsResults.GridLineColor = System.Drawing.Color.DarkGray
        Me.dgStatsResults.HeaderBackColor = System.Drawing.Color.DarkGreen
        Me.dgStatsResults.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgStatsResults.HeaderForeColor = System.Drawing.Color.White
        Me.dgStatsResults.LinkColor = System.Drawing.Color.DarkGreen
        Me.dgStatsResults.Location = New System.Drawing.Point(0, 21)
        Me.dgStatsResults.Name = "dgStatsResults"
        Me.dgStatsResults.ParentRowsBackColor = System.Drawing.Color.Gainsboro
        Me.dgStatsResults.ParentRowsForeColor = System.Drawing.Color.Black
        Me.dgStatsResults.SelectionBackColor = System.Drawing.Color.DarkSeaGreen
        Me.dgStatsResults.SelectionForeColor = System.Drawing.Color.Black
        Me.dgStatsResults.Size = New System.Drawing.Size(452, 120)
        Me.dgStatsResults.TabIndex = 3
        '
        'Splitter1
        '
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        Me.Splitter1.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Splitter1.Location = New System.Drawing.Point(0, 141)
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.Size = New System.Drawing.Size(452, 3)
        Me.Splitter1.TabIndex = 2
        Me.Splitter1.TabStop = False
        '
        'panGraph
        '
        Me.panGraph.Controls.Add(Me.OgsPlayerStatsGraph1)
        Me.panGraph.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.panGraph.Location = New System.Drawing.Point(0, 144)
        Me.panGraph.Name = "panGraph"
        Me.panGraph.Size = New System.Drawing.Size(452, 244)
        Me.panGraph.TabIndex = 1
        '
        'OgsPlayerStatsGraph1
        '
        Me.OgsPlayerStatsGraph1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.OgsPlayerStatsGraph1.Location = New System.Drawing.Point(0, 0)
        Me.OgsPlayerStatsGraph1.Name = "OgsPlayerStatsGraph1"
        Me.OgsPlayerStatsGraph1.Player = Nothing
        Me.OgsPlayerStatsGraph1.Size = New System.Drawing.Size(452, 244)
        Me.OgsPlayerStatsGraph1.TabIndex = 0
        '
        'cbStatsType
        '
        Me.cbStatsType.BackColor = System.Drawing.SystemColors.Highlight
        Me.cbStatsType.Dock = System.Windows.Forms.DockStyle.Top
        Me.cbStatsType.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbStatsType.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.cbStatsType.Items.AddRange(New Object() {"Order By Points", "Order By Flotte", "Order By Research"})
        Me.cbStatsType.Location = New System.Drawing.Point(0, 0)
        Me.cbStatsType.Name = "cbStatsType"
        Me.cbStatsType.Size = New System.Drawing.Size(452, 21)
        Me.cbStatsType.TabIndex = 0
        '
        'lbStatisticsDate
        '
        Me.lbStatisticsDate.BackColor = System.Drawing.SystemColors.Info
        Me.lbStatisticsDate.Dock = System.Windows.Forms.DockStyle.Left
        Me.lbStatisticsDate.ForeColor = System.Drawing.SystemColors.InfoText
        Me.lbStatisticsDate.IntegralHeight = False
        Me.lbStatisticsDate.Location = New System.Drawing.Point(0, 16)
        Me.lbStatisticsDate.Name = "lbStatisticsDate"
        Me.lbStatisticsDate.Size = New System.Drawing.Size(120, 388)
        Me.lbStatisticsDate.TabIndex = 1
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.Font = New System.Drawing.Font("Comic Sans MS", 11.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(572, 16)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Statistics"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'PlayersStatsCtrl
        '
        Me.Controls.Add(Me.panMain)
        Me.Name = "PlayersStatsCtrl"
        Me.Size = New System.Drawing.Size(576, 408)
        Me.panMain.ResumeLayout(False)
        Me.panStatsInfo.ResumeLayout(False)
        CType(Me.dgStatsResults, System.ComponentModel.ISupportInitialize).EndInit()
        Me.panGraph.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub PlayersStatsCtrl_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        lbStatisticsDate.Items.Clear()
        If OGameObject.OGameDBEngine.Default Is Nothing Then Return
        Dim u As New Splash
        'u.Parent = Me

        u.Message = "Retrieving Statistics date. Please Wait...."
        u.Show()
        Application.DoEvents()
        cbStatsType.SelectedIndex = 0
        lbStatisticsDate.DataSource = OGameObject.OGameDBEngine.Default.StatisticsDate
        lbStatisticsDate.DisplayMember = "DATADATE"
        lbStatisticsDate.ValueMember = "DATADATE"
        'lbStatisticsDate.SelectedIndex = 0
        u.Close()
        Application.DoEvents()
        ReloadStatistics()
    End Sub

    Private Sub cbStatsType_SelectedIndexChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbStatsType.SelectedIndexChanged
        If lbStatisticsDate.Items.Count < 1 Then Return
        ReloadStatistics()
    End Sub
    Private Sub ReloadStatistics()
        Dim u As New Splash
        Try

            Dim query As String = "SELECT * FROM RANKINGALL"
            Me.Cursor = System.Windows.Forms.Cursors.WaitCursor

            'u.Parent = Me

            u.Message = "Retrieving Statistics data. Please Wait...."
            u.Show()
            Application.DoEvents()

            Select Case cbStatsType.SelectedIndex
                Case 0
                    query = "SELECT PR.RANK," & _
                            "P.NAME,P.ALLIANCE,P.MAINPLANETCOORDS," & _
                            "PR.POINTS," & _
                            "PF.RANK as FlotteRank,PF.POINTS as FlottePoints," & _
                            "PS.RANK as SearchRank,PS.Points as SearchPoints " & _
                            "FROM PLAYERSRANK PR " & _
                            "LEFT JOIN PLAYERS P ON P.ID=PR.PLAYER_ID " & _
                            "LEFT JOIN PLAYERSFLOTTE PF ON (PF.PLAYER_ID=PR.PLAYER_ID AND PF.DATADATE=PR.DATADATE)" & _
                            "LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PR.PLAYER_ID AND PS.DATADATE=PR.DATADATE) "
                    If lbStatisticsDate.SelectedItem Is Nothing Then
                        query &= "WHERE PR.DATADATE=(SELECT MAX(DATADATE) FROM PLAYERSRANK)"
                    Else
                        query &= "WHERE PR.DATADATE='" & CType(CType(lbStatisticsDate.SelectedItem, DataRowView).Item("DATADATE"), Date).ToString("yyyy-MM-dd HH:mm:ss") & "'"
                    End If

                    query &= "ORDER BY PR.RANK"
                Case 1
                    query = "SELECT PF.RANK," & _
                            "P.NAME,P.ALLIANCE,P.MAINPLANETCOORDS," & _
                            "PF.POINTS," & _
                            "PR.RANK as GlobalRank,PR.POINTS as GlobalPoints," & _
                            "PS.RANK as SearchRank,PS.Points as SearchPoints " & _
                            "FROM PLAYERSFLOTTE PF " & _
                            "LEFT JOIN PLAYERS P ON P.ID=PF.PLAYER_ID " & _
                            "LEFT JOIN PLAYERSRANK PR ON (PR.PLAYER_ID=PF.PLAYER_ID AND PR.DATADATE=PF.DATADATE)" & _
                            "LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PF.PLAYER_ID AND PS.DATADATE=PF.DATADATE) "
                    If lbStatisticsDate.SelectedItem Is Nothing Then
                        query &= "WHERE PF.DATADATE=(SELECT MAX(DATADATE) FROM PLAYERSFLOTTE)"
                    Else
                        query &= "WHERE PF.DATADATE='" & CType(CType(lbStatisticsDate.SelectedItem, DataRowView).Item("DATADATE"), Date).ToString("yyyy-MM-dd HH:mm:ss") & "'"
                    End If

                    query &= "ORDER BY PF.RANK"

                Case 2
                    Me.Cursor = System.Windows.Forms.Cursors.Default
                    u.Close()
                    MessageBox.Show(MainForm.TopForm, "nononono... j'ai pas implémenté le ranking par recherche... mais pour ce qu'on en a a faire...")
                    Return
            End Select
            dgStatsResults.SetDataBinding(OGameObject.OGameDBEngine.Default.SQLCommand(query), "")
        Catch ex As Exception
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        Finally
            Me.Cursor = System.Windows.Forms.Cursors.Default
            u.Close()

        End Try

    End Sub

    Private Sub lbStatisticsDate_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbStatisticsDate.SelectedIndexChanged
        ReloadStatistics()
    End Sub


    Private Sub dgStatsResults_CurrentCellChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles dgStatsResults.CurrentCellChanged
        If dgStatsResults.CurrentRowIndex > -1 Then
            OgsPlayerStatsGraph1.Player = OGameObject.Player.FromName(dgStatsResults.Item(dgStatsResults.CurrentRowIndex, 1))
        End If
    End Sub
End Class
