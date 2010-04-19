Imports System.Drawing.Drawing2D
Public Class RankVariation
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call
        Me.SetStyle(ControlStyles.DoubleBuffer _
                 Or ControlStyles.UserPaint _
                 Or ControlStyles.AllPaintingInWmPaint, _
                 True)
        '
        ' This enables mouse support such as the Mouse Wheel
        setstyle(ControlStyles.UserMouse, True)

        ' This will repaint the control whenever it is resized
        setstyle(ControlStyles.ResizeRedraw, True)

        Me.UpdateStyles()
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
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents lblCurrentStat As System.Windows.Forms.Label
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.lblCurrentStat = New System.Windows.Forms.Label
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Panel1.Controls.Add(Me.lblCurrentStat)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Bottom
        Me.Panel1.Location = New System.Drawing.Point(0, 176)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(472, 32)
        Me.Panel1.TabIndex = 0
        '
        'lblCurrentStat
        '
        Me.lblCurrentStat.Anchor = CType(((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Left) _
                    Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.lblCurrentStat.Location = New System.Drawing.Point(8, 8)
        Me.lblCurrentStat.Name = "lblCurrentStat"
        Me.lblCurrentStat.Size = New System.Drawing.Size(440, 23)
        Me.lblCurrentStat.TabIndex = 0
        Me.lblCurrentStat.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'RankVariation
        '
        Me.BackColor = System.Drawing.SystemColors.Control
        Me.Controls.Add(Me.Panel1)
        Me.ForeColor = System.Drawing.Color.Black
        Me.Name = "RankVariation"
        Me.Size = New System.Drawing.Size(472, 208)
        Me.Panel1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private pGraphBackgroundBrush As Brush = Nothing
    Public ReadOnly Property GraphBackgroundBrush() As Brush
        Get
            If pGraphBackgroundBrush Is Nothing Then
                pGraphBackgroundBrush = New LinearGradientBrush(Me.ClientRectangle, Color.White, GraphBackgroundColor, LinearGradientMode.Vertical)
            End If
            Return pGraphBackgroundBrush
        End Get
    End Property
    Private pGraphBackgroundColor As Color = Color.Yellow
    Public Property GraphBackgroundColor() As Color
        Get
            Return pGraphBackgroundColor
        End Get
        Set(ByVal Value As Color)
            If Value.Equals(pGraphBackgroundColor) Then Return
            pGraphBackgroundColor = Value
            If Not pGraphBackgroundBrush Is Nothing Then
                pGraphBackgroundBrush.Dispose()
                pGraphBackgroundBrush = Nothing
            End If
            Me.Invalidate()
        End Set
    End Property
    Private pHeaderFont As Font = Nothing
    Public Property HeaderFont() As Font
        Get
            If pHeaderFont Is Nothing Then Return Me.Font
            Return pHeaderFont
        End Get
        Set(ByVal Value As Font)
            If Value.Equals(Me.Font) Then
                pHeaderFont = Nothing
                Exit Property
            End If
            pHeaderFont = Value
            Me.Invalidate()
        End Set
    End Property
    Private pPlayer As OGameObject.Player = Nothing
    Public Property Player() As OGameObject.Player
        Get
            Return pPlayer
        End Get
        Set(ByVal Value As OGameObject.Player)
            pPlayer = Value
        End Set
    End Property

    Protected Overrides Sub OnPaint(ByVal e As System.Windows.Forms.PaintEventArgs)
        MyBase.OnPaint(e)

        'If Player Is Nothing Then
        '    PaintNoData(e)
        '    Exit Sub
        'End If

        PaintRulesHeaders(e)

    End Sub
    Protected Sub PaintData(ByVal e As System.Windows.Forms.PaintEventArgs)

    End Sub
    Protected Sub PaintNoData(ByVal e As System.Windows.Forms.PaintEventArgs)

        With e.Graphics
            Dim s As String = "There is no player selected for this graphics"
            Dim strf As New StringFormat
            strf.LineAlignment = StringAlignment.Center
            strf.Alignment = StringAlignment.Center
            .DrawString(s, Me.Font, New SolidBrush(Me.ForeColor), RectangleF.op_Implicit(Me.ClientRectangle), strf)
            strf.Dispose()
        End With
    End Sub
    Protected GraphRectF As RectangleF
    Protected OriginPF As PointF
    Protected Sub PaintRulesHeaders(ByVal e As System.Windows.Forms.PaintEventArgs)
        With e.Graphics
            Dim strf As New StringFormat
            strf.LineAlignment = StringAlignment.Center
            strf.Alignment = StringAlignment.Center

            Dim txt As String = "Statistics evolution for XXXXXXXX" & vbCrLf & "on XXXXXXXXXXX"
            Dim thesize As SizeF = .MeasureString(txt, HeaderFont, Me.Width * 0.6, strf)
            Dim HeaderRect As New RectangleF(Me.ClientSize.Width * 0.2, 3, Me.ClientSize.Width * 0.6, thesize.Height + 8)

            'Le rectangle du haut
            HeaderRect.Inflate(2, 2)
            .DrawRectangle(Pens.Black, Rectangle.Round(HeaderRect))
            HeaderRect.Inflate(-2, -2)
            .FillRectangle(Brushes.DarkGreen, Rectangle.Round(HeaderRect))
            .DrawString(txt, HeaderFont, Brushes.Gold, HeaderRect, strf)

            'Le rectangle du bas
            GraphRectF = New RectangleF(10, HeaderRect.Bottom + 10, Me.ClientSize.Width - 10 * 2, Me.ClientSize.Height - 10 * 2 - HeaderRect.Bottom - 35)
            .FillRectangle(GraphBackgroundBrush, GraphRectF)
            .DrawRectangle(Pens.Black, Rectangle.Round(GraphRectF))

            OriginPF = New PointF(GraphRectF.Left + 5, GraphRectF.Bottom - 20)

            'Les regles
            .DrawLine(Pens.DarkBlue, OriginPF, New PointF(OriginPF.X, GraphRectF.Y + 5))
            .DrawLine(Pens.DarkBlue, OriginPF, New PointF(GraphRectF.Right - 5, OriginPF.Y))
            strf.Dispose()
        End With

    End Sub

    Private Sub RankVariation_SizeChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.SizeChanged
        If Not pGraphBackgroundBrush Is Nothing Then
            pGraphBackgroundBrush.Dispose()
            pGraphBackgroundBrush = Nothing
        End If
    End Sub

    Public ReadOnly Property EntryCount() As Integer
        Get
            Return 5
        End Get
    End Property

    Public ReadOnly Property EntryWidth() As Integer
        Get
            Return 25
        End Get
    End Property

    Public ReadOnly Property EntryShown() As Integer
        Get

        End Get
    End Property
End Class
