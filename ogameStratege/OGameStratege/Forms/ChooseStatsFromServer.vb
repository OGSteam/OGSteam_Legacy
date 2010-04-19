Public Class ChooseStatsFromServer
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
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents ServerPlayerStatsInfoCtrl1 As OGameStratege.ServerPlayerStatsInfoCtrl
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button2 As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(ChooseStatsFromServer))
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.ServerPlayerStatsInfoCtrl1 = New OGameStratege.ServerPlayerStatsInfoCtrl
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.Button2)
        Me.Panel1.Controls.Add(Me.Button1)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Panel1.Location = New System.Drawing.Point(0, 0)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(304, 48)
        Me.Panel1.TabIndex = 0
        '
        'Button2
        '
        Me.Button2.Dock = System.Windows.Forms.DockStyle.Left
        Me.Button2.Image = CType(resources.GetObject("Button2.Image"), System.Drawing.Image)
        Me.Button2.Location = New System.Drawing.Point(75, 0)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(75, 48)
        Me.Button2.TabIndex = 1
        '
        'Button1
        '
        Me.Button1.Dock = System.Windows.Forms.DockStyle.Left
        Me.Button1.Image = CType(resources.GetObject("Button1.Image"), System.Drawing.Image)
        Me.Button1.Location = New System.Drawing.Point(0, 0)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 48)
        Me.Button1.TabIndex = 0
        '
        'ServerPlayerStatsInfoCtrl1
        '
        Me.ServerPlayerStatsInfoCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.ServerPlayerStatsInfoCtrl1.Location = New System.Drawing.Point(0, 48)
        Me.ServerPlayerStatsInfoCtrl1.Name = "ServerPlayerStatsInfoCtrl1"
        Me.ServerPlayerStatsInfoCtrl1.Size = New System.Drawing.Size(304, 218)
        Me.ServerPlayerStatsInfoCtrl1.TabIndex = 1
        '
        'ChooseStatsFromServer
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(304, 266)
        Me.Controls.Add(Me.ServerPlayerStatsInfoCtrl1)
        Me.Controls.Add(Me.Panel1)
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.Name = "ChooseStatsFromServer"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent
        Me.Text = "ChooseStatsFromServer"
        Me.TopMost = True
        Me.Panel1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        Me.DialogResult = Windows.Forms.DialogResult.Cancel
        Me.Close()
    End Sub
    Private pSHaredDB As OGameObject.SharingDB = Nothing
    Public Property SharedDB() As OGameObject.SharingDB
        Get
            Return pSHaredDB
        End Get
        Set(ByVal Value As OGameObject.SharingDB)
            pSHaredDB = Value
            If Not Value Is Nothing Then
                ServerPlayerStatsInfoCtrl1.OGSPYStatInfo = pSHaredDB.GetStatsInfo
            End If
        End Set
    End Property
    Public StatDateValue As String
    Public StatAvailable As String
    Private Sub ServerPlayerStatsInfoCtrl1_StatDataSelected(ByVal sender As ServerPlayerStatsInfoCtrl, ByVal thedate As String, ByVal StatsAvail As String) Handles ServerPlayerStatsInfoCtrl1.StatDataSelected
        StatDateValue = thedate
        StatAvailable = StatsAvail
        Me.DialogResult = Windows.Forms.DialogResult.OK

        Me.Close()
    End Sub
End Class
