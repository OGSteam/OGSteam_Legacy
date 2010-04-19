Public Class ServerPlayerStatsInfoCtrl
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
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents ListView1 As System.Windows.Forms.ListView
    Friend WithEvents ColumnHeader1 As System.Windows.Forms.ColumnHeader
    Friend WithEvents ColumnHeader2 As System.Windows.Forms.ColumnHeader
    Friend WithEvents ColumnHeader3 As System.Windows.Forms.ColumnHeader
    Friend WithEvents ColumnHeader4 As System.Windows.Forms.ColumnHeader
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label
        Me.ListView1 = New System.Windows.Forms.ListView
        Me.ColumnHeader1 = New System.Windows.Forms.ColumnHeader
        Me.ColumnHeader2 = New System.Windows.Forms.ColumnHeader
        Me.ColumnHeader3 = New System.Windows.Forms.ColumnHeader
        Me.ColumnHeader4 = New System.Windows.Forms.ColumnHeader
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.Font = New System.Drawing.Font("Comic Sans MS", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(304, 24)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Server Stats Info"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'ListView1
        '
        Me.ListView1.BackColor = System.Drawing.SystemColors.Info
        Me.ListView1.Columns.AddRange(New System.Windows.Forms.ColumnHeader() {Me.ColumnHeader1, Me.ColumnHeader2, Me.ColumnHeader3, Me.ColumnHeader4})
        Me.ListView1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ListView1.ForeColor = System.Drawing.SystemColors.InfoText
        Me.ListView1.FullRowSelect = True
        Me.ListView1.GridLines = True
        Me.ListView1.Location = New System.Drawing.Point(0, 24)
        Me.ListView1.Name = "ListView1"
        Me.ListView1.Size = New System.Drawing.Size(304, 152)
        Me.ListView1.TabIndex = 1
        Me.ListView1.View = System.Windows.Forms.View.Details
        '
        'ColumnHeader1
        '
        Me.ColumnHeader1.Text = "Date"
        Me.ColumnHeader1.Width = 114
        '
        'ColumnHeader2
        '
        Me.ColumnHeader2.Text = "Points"
        '
        'ColumnHeader3
        '
        Me.ColumnHeader3.Text = "Flotte"
        '
        'ColumnHeader4
        '
        Me.ColumnHeader4.Text = "Research"
        '
        'ServerPlayerStatsInfoCtrl
        '
        Me.Controls.Add(Me.ListView1)
        Me.Controls.Add(Me.Label1)
        Me.Name = "ServerPlayerStatsInfoCtrl"
        Me.Size = New System.Drawing.Size(304, 176)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Public Event StatDataSelected(ByVal sender As ServerPlayerStatsInfoCtrl, ByVal thedate As String, ByVal StatsAvail As String)
    Public WriteOnly Property OGSPYStatInfo() As String
        Set(ByVal Value As String)
            ListView1.Items.Clear()

            Dim lines() As String = Microsoft.VisualBasic.Split(Value, "<|>")
            For Each line As String In lines
                If line.Trim.Length > 1 Then
                    Dim data() As String = line.Split("=")
                    If data.Length > 1 Then
                        With ListView1.Items.Add(data(0))
                            .SubItems.Add(IIf(data(1).IndexOf("P") > -1, "Yes", "No"))
                            .SubItems.Add(IIf(data(1).IndexOf("F") > -1, "Yes", "No"))
                            .SubItems.Add(IIf(data(1).IndexOf("R") > -1, "Yes", "No"))
                        End With
                    End If
                End If
            Next

        End Set
    End Property

    Public StatDateValue As String
    Public StatDataAvailable As String
    Private Sub ListView1_SelectedIndexChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles ListView1.SelectedIndexChanged
        If ListView1.SelectedItems.Count <= 0 Then Return
        Try
            StatDataAvailable = ""
            StatDataAvailable &= IIf(ListView1.SelectedItems(0).SubItems(1).Text = "Yes", "P", "")
            StatDataAvailable &= IIf(ListView1.SelectedItems(0).SubItems(2).Text = "Yes", "F", "")
            StatDataAvailable &= IIf(ListView1.SelectedItems(0).SubItems(3).Text = "Yes", "R", "")
            StatDateValue = ListView1.SelectedItems(0).Text
            RaiseEvent StatDataSelected(Me, StatDateValue, StatDataAvailable)
        Catch ex As Exception

        End Try

    End Sub
End Class
