Public Class PlayerAllianceSubPanel
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
    Friend WithEvents PlayerInfoCtrl1 As OGameStratege.PlayerInfoCtrl
    Friend WithEvents AlliancePlayerCtrl1 As OGameStratege.AlliancePlayerCtrl
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.PlayerInfoCtrl1 = New OGameStratege.PlayerInfoCtrl
        Me.AlliancePlayerCtrl1 = New OGameStratege.AlliancePlayerCtrl
        Me.SuspendLayout()
        '
        'PlayerInfoCtrl1
        '
        Me.PlayerInfoCtrl1.Dock = System.Windows.Forms.DockStyle.Right
        Me.PlayerInfoCtrl1.Location = New System.Drawing.Point(384, 0)
        Me.PlayerInfoCtrl1.Name = "PlayerInfoCtrl1"
        Me.PlayerInfoCtrl1.Player = Nothing
        Me.PlayerInfoCtrl1.Size = New System.Drawing.Size(240, 464)
        Me.PlayerInfoCtrl1.TabIndex = 1
        '
        'AlliancePlayerCtrl1
        '
        Me.AlliancePlayerCtrl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.AlliancePlayerCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.AlliancePlayerCtrl1.Name = "AlliancePlayerCtrl1"
        Me.AlliancePlayerCtrl1.Size = New System.Drawing.Size(384, 464)
        Me.AlliancePlayerCtrl1.TabIndex = 0
        '
        'PlayerAllianceSubPanel
        '
        Me.Controls.Add(Me.AlliancePlayerCtrl1)
        Me.Controls.Add(Me.PlayerInfoCtrl1)
        Me.Name = "PlayerAllianceSubPanel"
        Me.Size = New System.Drawing.Size(624, 464)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub AlliancePlayerCtrl1_PlayerSelected(ByVal Player As OGameObject.Player) Handles AlliancePlayerCtrl1.PlayerSelected
        PlayerInfoCtrl1.Player = Player
    End Sub
    Public Sub SelectPlanet(ByVal planet As OGameObject.Planet)
        AlliancePlayerCtrl1.SelectPlanet(planet)
    End Sub
    Public Sub SelectPlayer(ByVal player As OGameObject.Player)
        AlliancePlayerCtrl1.SelectPlayer(player)
        AlliancePlayerCtrl1.Validate()
    End Sub
    Public Sub SearchSelectPlayer(ByVal playername As String)
        AlliancePlayerCtrl1.cbSearchType.SelectedIndex = 1
        AlliancePlayerCtrl1.tbSearchPattern.Text = playername

        AlliancePlayerCtrl1.btnSearch_Click(Nothing, Nothing)
        If AlliancePlayerCtrl1.lbSearchResults.Items.Count > 0 Then
            AlliancePlayerCtrl1.lbSearchResults.SelectedIndex = 1
        End If
        AlliancePlayerCtrl1.Validate()
    End Sub


End Class
