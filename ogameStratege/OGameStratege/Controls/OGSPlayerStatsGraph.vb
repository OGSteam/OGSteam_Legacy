Public Class OGSPlayerStatsGraph
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
    Friend WithEvents ZedGraphControl1 As ZedGraph.ZedGraphControl
    Friend WithEvents ContextMenu1 As System.Windows.Forms.ContextMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem2 As System.Windows.Forms.MenuItem
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.ZedGraphControl1 = New ZedGraph.ZedGraphControl
        Me.ContextMenu1 = New System.Windows.Forms.ContextMenu
        Me.MenuItem1 = New System.Windows.Forms.MenuItem
        Me.MenuItem2 = New System.Windows.Forms.MenuItem
        Me.SuspendLayout()
        '
        'ZedGraphControl1
        '
        Me.ZedGraphControl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ZedGraphControl1.ForeColor = System.Drawing.SystemColors.ControlText
        Me.ZedGraphControl1.IsAutoScrollRange = False
        Me.ZedGraphControl1.IsEnableHPan = True
        Me.ZedGraphControl1.IsEnableHZoom = True
        Me.ZedGraphControl1.IsEnableVPan = True
        Me.ZedGraphControl1.IsEnableVZoom = True
        Me.ZedGraphControl1.IsScrollY2 = False
        Me.ZedGraphControl1.IsShowContextMenu = True
        Me.ZedGraphControl1.IsShowCursorValues = False
        Me.ZedGraphControl1.IsShowHScrollBar = False
        Me.ZedGraphControl1.IsShowPointValues = False
        Me.ZedGraphControl1.IsShowVScrollBar = False
        Me.ZedGraphControl1.IsZoomOnMouseCenter = False
        Me.ZedGraphControl1.Location = New System.Drawing.Point(0, 0)
        Me.ZedGraphControl1.Name = "ZedGraphControl1"
        Me.ZedGraphControl1.PanButtons = System.Windows.Forms.MouseButtons.Left
        Me.ZedGraphControl1.PanButtons2 = System.Windows.Forms.MouseButtons.Middle
        Me.ZedGraphControl1.PanModifierKeys2 = System.Windows.Forms.Keys.None
        Me.ZedGraphControl1.PointDateFormat = "g"
        Me.ZedGraphControl1.PointValueFormat = "G"
        Me.ZedGraphControl1.ScrollMaxX = 0
        Me.ZedGraphControl1.ScrollMaxY = 0
        Me.ZedGraphControl1.ScrollMaxY2 = 0
        Me.ZedGraphControl1.ScrollMinX = 0
        Me.ZedGraphControl1.ScrollMinY = 0
        Me.ZedGraphControl1.ScrollMinY2 = 0
        Me.ZedGraphControl1.Size = New System.Drawing.Size(392, 216)
        Me.ZedGraphControl1.TabIndex = 1
        Me.ZedGraphControl1.ZoomButtons = System.Windows.Forms.MouseButtons.Left
        Me.ZedGraphControl1.ZoomButtons2 = System.Windows.Forms.MouseButtons.None
        Me.ZedGraphControl1.ZoomModifierKeys = System.Windows.Forms.Keys.None
        Me.ZedGraphControl1.ZoomModifierKeys2 = System.Windows.Forms.Keys.None
        Me.ZedGraphControl1.ZoomStepFraction = 0.1
        '
        'ContextMenu1
        '
        Me.ContextMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1, Me.MenuItem2})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 0
        Me.MenuItem1.Text = "Points"
        '
        'MenuItem2
        '
        Me.MenuItem2.Index = 1
        Me.MenuItem2.Text = "Rank"
        '
        'OGSPlayerStatsGraph
        '
        Me.Controls.Add(Me.ZedGraphControl1)
        Me.Name = "OGSPlayerStatsGraph"
        Me.Size = New System.Drawing.Size(392, 216)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Public Enum StatsGraphType
        Points
        Rank
    End Enum
    Private pGraphType As StatsGraphType = StatsGraphType.Points
    Public Property GraphType() As StatsGraphType
        Get
            Return pGraphType
        End Get
        Set(ByVal Value As StatsGraphType)
            pGraphType = Value
        End Set
    End Property
    Private pPlayer As OGameObject.Player
    Public Property Player() As OGameObject.Player
        Get
            Return pPlayer
        End Get
        Set(ByVal Value As OGameObject.Player)
            pPlayer = Value
            If Value Is Nothing Then
                ZedGraphControl1.Visible = False
                Return
            End If
            ZedGraphControl1.Visible = True
            GraphConfigured = False
            If ZedGraphControl1.GraphPane.YAxisList.Count > 1 Then ZedGraphControl1.GraphPane.YAxisList.RemoveAt(1)
            ShowStats()

        End Set
    End Property

    Public Sub ShowStats()

        If Not GraphConfigured Then SetupGraphDesign()
        SetPlayerData()
        Dim g As Graphics = CreateGraphics()
        ZedGraphControl1.GraphPane.AxisChange(g)
        g.Dispose()
        ZedGraphControl1.Invalidate()
    End Sub

    Public Sub SetPlayerData()
        If Player Is Nothing Then Return
        With ZedGraphControl1.GraphPane
            .Title = "Evolution Statistique de " & Player.Name & IIf(Player.HaveAlliance, "  [" & Player.Alliance & "]", "")
        End With


        Dim listGlobal As New ZedGraph.PointPairList
        Dim ListFlotte As New ZedGraph.PointPairList
        Dim ListResearch As New ZedGraph.PointPairList
        Dim request As String = "SELECT PR.DATADATE,PR.RANK," & _
"   P.NAME,P.ALLIANCE," & _
"   PR.POINTS," & _
"   PF.RANK as FlotteRank,PF.POINTS as FlottePoints," & _
"   PS.RANK as SearchRank,PS.Points as SearchPoints" & _
"    FROM PLAYERSRANK PR" & _
"    LEFT JOIN PLAYERS P ON P.ID=PR.PLAYER_ID" & _
"    LEFT JOIN PLAYERSFLOTTE PF ON (PF.PLAYER_ID=PR.PLAYER_ID AND PF.DATADATE=PR.DATADATE)" & _
"    LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PR.PLAYER_ID AND PS.DATADATE=PR.DATADATE)" & _
"WHERE PR.PLAYER_ID = '" & Player.ID & "'" & _
"ORDER BY PR.DATADATE ASC"
        For Each dr As DataRow In OGameObject.OGameDBEngine.Default.SQLCommand(request).Rows
            Dim xd As New ZedGraph.XDate(CDate(dr("DATADATE")))
            Select Case GraphType
                Case StatsGraphType.Points
                    If Not dr("POINTS") Is DBNull.Value Then
                        listGlobal.Add(xd.XLDate, CDbl(dr("POINTS")))
                    End If
                    If Not dr("FlottePoints") Is DBNull.Value Then
                        ListFlotte.Add(xd.XLDate, CDbl(dr("FlottePoints")))
                    End If
                    If Not dr("SearchPoints") Is DBNull.Value Then
                        ListResearch.Add(xd.XLDate, CDbl(dr("SearchPoints")))
                    End If
                Case StatsGraphType.Rank
                    If Not dr("POINTS") Is DBNull.Value Then
                        listGlobal.Add(xd.XLDate, CDbl(dr("RANK")))
                    End If
                    If Not dr("FlottePoints") Is DBNull.Value Then
                        ListFlotte.Add(xd.XLDate, CDbl(dr("FlotteRank")))
                    End If
                    If Not dr("SearchPoints") Is DBNull.Value Then
                        ListResearch.Add(xd.XLDate, CDbl(dr("SearchRank")))
                    End If
            End Select
        Next

        With ZedGraphControl1.GraphPane
            .CurveList.Clear()
            Dim mycurve As ZedGraph.LineItem
            mycurve = .AddCurve("Global", listGlobal, Color.Green)
            mycurve.Line.Width = 1.5F
            mycurve.Line.IsSmooth = True
            mycurve.Line.SmoothTension = 0.5F
            'mycurve.Line.Fill = New ZedGraph.Fill(Color.White, Color.FromArgb(60, 190, 50), 90.0F)
            mycurve.Line.StepType = ZedGraph.StepType.ForwardStep

            mycurve = .AddCurve("Flotte", ListFlotte, Color.Red, ZedGraph.SymbolType.Circle)
            mycurve.IsY2Axis = True

            mycurve = .AddCurve("Recherche", ListResearch, Color.Blue, ZedGraph.SymbolType.Diamond)
            mycurve.YAxisIndex = 1
        End With

    End Sub
    Private GraphConfigured As Boolean = False
    Public Sub SetupGraphDesign()
        With ZedGraphControl1.GraphPane
            .PaneFill = New ZedGraph.Fill(Color.Black)
            .FontSpec.FontColor = Color.Gold


            .XAxis.Title = "Date des statistiques"
            .XAxis.IsShowGrid = True
            .AxisFill = New ZedGraph.Fill(Color.White, Color.SteelBlue, 45.0F)
            .XAxis.Color = Color.White
            .XAxis.ScaleFontSpec.FontColor = Color.White
            .XAxis.TitleFontSpec.FontColor = Color.White

            .YAxis.Title = "Global"
            .YAxis.Color = Color.LightGreen
            .YAxis.ScaleFontSpec.FontColor = Color.LightGreen
            .YAxis.TitleFontSpec.FontColor = Color.LightGreen
            .YAxis.IsReverse = (GraphType = StatsGraphType.Rank)

            .Y2Axis.Title = "Flotte"
            .Y2Axis.IsVisible = True
            .Y2Axis.Color = Color.LightSalmon
            .Y2Axis.ScaleFontSpec.FontColor = Color.LightSalmon
            .Y2Axis.TitleFontSpec.FontColor = Color.LightSalmon
            .Y2Axis.IsReverse = (GraphType = StatsGraphType.Rank)
            Dim YAxis3 As New ZedGraph.YAxis("Recherche")
            YAxis3.Color = Color.LightBlue
            YAxis3.ScaleFontSpec.FontColor = Color.LightBlue
            YAxis3.TitleFontSpec.FontColor = Color.LightBlue
            YAxis3.IsReverse = (GraphType = StatsGraphType.Rank)
            .YAxisList.Add(YAxis3)

            .XAxis.Type = ZedGraph.AxisType.Date

        End With
        GraphConfigured = True
    End Sub


    Private Sub OGSPlayerStatsGraph_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

    End Sub

    Private Sub OGSPlayerStatsGraph_Paint(ByVal sender As Object, ByVal e As System.Windows.Forms.PaintEventArgs) Handles MyBase.Paint
        'ZedGraphControl1.GraphPane.AxisChange(e.Graphics)
    End Sub

    Private Sub MenuItem1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem1.Click
        GraphType = StatsGraphType.Points

    End Sub

    Private Sub MenuItem2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem2.Click
        GraphType = StatsGraphType.Rank
    End Sub
End Class
