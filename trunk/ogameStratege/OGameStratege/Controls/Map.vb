Public Class Map
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
    Friend WithEvents PartialMapCtrl1 As OGameStratege.PartialMapCtrl
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents panButton As System.Windows.Forms.Panel
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents tbespioinfo As System.Windows.Forms.TextBox
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Panel3 As System.Windows.Forms.Panel
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents lbreportlist As System.Windows.Forms.ListBox
    Friend WithEvents rtbreport As System.Windows.Forms.RichTextBox
    Friend WithEvents lbAttackList As System.Windows.Forms.ListBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.Resources.ResourceManager = New System.Resources.ResourceManager(GetType(Map))
        Me.PlayerInfoCtrl1 = New OGameStratege.PlayerInfoCtrl
        Me.PartialMapCtrl1 = New OGameStratege.PartialMapCtrl
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.panButton = New System.Windows.Forms.Panel
        Me.tbespioinfo = New System.Windows.Forms.TextBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.Label1 = New System.Windows.Forms.Label
        Me.Panel3 = New System.Windows.Forms.Panel
        Me.Label2 = New System.Windows.Forms.Label
        Me.lbreportlist = New System.Windows.Forms.ListBox
        Me.rtbreport = New System.Windows.Forms.RichTextBox
        Me.lbAttackList = New System.Windows.Forms.ListBox
        Me.Panel1.SuspendLayout()
        Me.panButton.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.Panel3.SuspendLayout()
        Me.SuspendLayout()
        '
        'PlayerInfoCtrl1
        '
        Me.PlayerInfoCtrl1.Dock = System.Windows.Forms.DockStyle.Right
        Me.PlayerInfoCtrl1.Location = New System.Drawing.Point(376, 0)
        Me.PlayerInfoCtrl1.Name = "PlayerInfoCtrl1"
        Me.PlayerInfoCtrl1.Player = Nothing
        Me.PlayerInfoCtrl1.Size = New System.Drawing.Size(240, 424)
        Me.PlayerInfoCtrl1.TabIndex = 0
        '
        'PartialMapCtrl1
        '
        Me.PartialMapCtrl1.Dock = System.Windows.Forms.DockStyle.Top
        Me.PartialMapCtrl1.FirstSystem = 1
        Me.PartialMapCtrl1.Galaxy = 0
        Me.PartialMapCtrl1.GridColor = System.Drawing.Color.SteelBlue
        Me.PartialMapCtrl1.LeftColumnWidth = 32
        Me.PartialMapCtrl1.Location = New System.Drawing.Point(0, 0)
        Me.PartialMapCtrl1.MapFont = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.PartialMapCtrl1.Name = "PartialMapCtrl1"
        Me.PartialMapCtrl1.PlanetHeight = 15
        Me.PartialMapCtrl1.ShowGrid = True
        Me.PartialMapCtrl1.Size = New System.Drawing.Size(376, 336)
        Me.PartialMapCtrl1.SystemWidth = 25
        Me.PartialMapCtrl1.TabIndex = 1
        '
        'Panel1
        '
        Me.Panel1.BackgroundImage = CType(resources.GetObject("Panel1.BackgroundImage"), System.Drawing.Image)
        Me.Panel1.Controls.Add(Me.rtbreport)
        Me.Panel1.Controls.Add(Me.Panel3)
        Me.Panel1.Controls.Add(Me.Panel2)
        Me.Panel1.Controls.Add(Me.panButton)
        Me.Panel1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Panel1.DockPadding.All = 4
        Me.Panel1.Location = New System.Drawing.Point(0, 336)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(376, 88)
        Me.Panel1.TabIndex = 2
        '
        'panButton
        '
        Me.panButton.BackColor = System.Drawing.Color.Transparent
        Me.panButton.Controls.Add(Me.tbespioinfo)
        Me.panButton.Controls.Add(Me.Button1)
        Me.panButton.Dock = System.Windows.Forms.DockStyle.Right
        Me.panButton.DockPadding.All = 5
        Me.panButton.Location = New System.Drawing.Point(284, 4)
        Me.panButton.Name = "panButton"
        Me.panButton.Size = New System.Drawing.Size(88, 80)
        Me.panButton.TabIndex = 1
        '
        'tbespioinfo
        '
        Me.tbespioinfo.Dock = System.Windows.Forms.DockStyle.Fill
        Me.tbespioinfo.Location = New System.Drawing.Point(5, 21)
        Me.tbespioinfo.Multiline = True
        Me.tbespioinfo.Name = "tbespioinfo"
        Me.tbespioinfo.Size = New System.Drawing.Size(78, 54)
        Me.tbespioinfo.TabIndex = 1
        Me.tbespioinfo.Text = ""
        '
        'Button1
        '
        Me.Button1.BackColor = System.Drawing.SystemColors.Control
        Me.Button1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Button1.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Button1.Location = New System.Drawing.Point(5, 5)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(78, 16)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Mode Scan"
        Me.ToolTip1.SetToolTip(Me.Button1, "Go to the Scan Galaxy mode view")
        '
        'Panel2
        '
        Me.Panel2.BackColor = System.Drawing.Color.Transparent
        Me.Panel2.Controls.Add(Me.lbreportlist)
        Me.Panel2.Controls.Add(Me.Label1)
        Me.Panel2.Dock = System.Windows.Forms.DockStyle.Left
        Me.Panel2.Location = New System.Drawing.Point(4, 4)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(72, 80)
        Me.Panel2.TabIndex = 2
        '
        'Label1
        '
        Me.Label1.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(72, 16)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "Espionages"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Panel3
        '
        Me.Panel3.BackColor = System.Drawing.Color.Transparent
        Me.Panel3.Controls.Add(Me.lbAttackList)
        Me.Panel3.Controls.Add(Me.Label2)
        Me.Panel3.Dock = System.Windows.Forms.DockStyle.Left
        Me.Panel3.Location = New System.Drawing.Point(76, 4)
        Me.Panel3.Name = "Panel3"
        Me.Panel3.Size = New System.Drawing.Size(72, 80)
        Me.Panel3.TabIndex = 3
        '
        'Label2
        '
        Me.Label2.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.Label2.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.Label2.Location = New System.Drawing.Point(0, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(72, 16)
        Me.Label2.TabIndex = 1
        Me.Label2.Text = "Combats"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'lbreportlist
        '
        Me.lbreportlist.BackColor = System.Drawing.Color.Black
        Me.lbreportlist.Dock = System.Windows.Forms.DockStyle.Right
        Me.lbreportlist.ForeColor = System.Drawing.Color.WhiteSmoke
        Me.lbreportlist.IntegralHeight = False
        Me.lbreportlist.Location = New System.Drawing.Point(0, 16)
        Me.lbreportlist.Name = "lbreportlist"
        Me.lbreportlist.Size = New System.Drawing.Size(72, 64)
        Me.lbreportlist.TabIndex = 5
        '
        'rtbreport
        '
        Me.rtbreport.BackColor = System.Drawing.Color.Gray
        Me.rtbreport.Dock = System.Windows.Forms.DockStyle.Fill
        Me.rtbreport.ForeColor = System.Drawing.Color.White
        Me.rtbreport.Location = New System.Drawing.Point(148, 4)
        Me.rtbreport.Name = "rtbreport"
        Me.rtbreport.Size = New System.Drawing.Size(136, 80)
        Me.rtbreport.TabIndex = 6
        Me.rtbreport.Text = ""
        '
        'lbAttackList
        '
        Me.lbAttackList.BackColor = System.Drawing.Color.Black
        Me.lbAttackList.Dock = System.Windows.Forms.DockStyle.Right
        Me.lbAttackList.ForeColor = System.Drawing.Color.WhiteSmoke
        Me.lbAttackList.IntegralHeight = False
        Me.lbAttackList.Location = New System.Drawing.Point(0, 16)
        Me.lbAttackList.Name = "lbAttackList"
        Me.lbAttackList.Size = New System.Drawing.Size(72, 64)
        Me.lbAttackList.TabIndex = 6
        '
        'Map
        '
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.PartialMapCtrl1)
        Me.Controls.Add(Me.PlayerInfoCtrl1)
        Me.Name = "Map"
        Me.Size = New System.Drawing.Size(616, 424)
        Me.Panel1.ResumeLayout(False)
        Me.panButton.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.Panel3.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

#Region " Evenements Envoyés "
    ''' <summary>
    '''  Evenement: Demande de passage en mode Request
    ''' (Bien joue , je sais plus a quoi ca correspond..... :/ )
    ''' </summary>
    ''' <param name="sender"></param>
    ''' <remarks></remarks>
    Public Event ScanModeRequest(ByVal sender As Object)
    ''' <summary>
    ''' Evenement: transmet ce meme evenement venant de la map
    ''' </summary>
    ''' <param name="Galaxy">Le systeme demandé , impoprement appellé Galaxy</param>
    ''' <remarks></remarks>
    Public Event SystemSelected(ByVal Sender As Object, ByVal Galaxy As OGameObject.Galaxy)
#End Region
    Private Sub PartialMapCtrl1_PlanetSelected(ByVal sender As Object, ByVal planet As OGameObject.Planet) Handles PartialMapCtrl1.PlanetSelected
        rtbreport.Text = ""
        lbreportlist.Items.Clear()
        If planet Is Nothing Then Return

        PlayerInfoCtrl1.Player = planet.Owner
        If planet.Owner Is Nothing Then Return
        If planet.SpyingReports.Count > 0 Then
            For Each pl As OGameObject.Planet In PlayerInfoCtrl1.lbPlanets.Items
                If pl.Coords = planet.Coords Then
                    PlayerInfoCtrl1.lbPlanets.SelectedItem = pl
                    Exit For
                End If
            Next
        End If
    End Sub

    Private Sub PlayerInfoCtrl1_PlanetSelected(ByVal sender As Object, ByVal Planet As OGameObject.Planet) Handles PlayerInfoCtrl1.PlanetSelected
        Try

            rtbreport.Text = ""
            tbespioinfo.Text = ""
            lbreportlist.Items.Clear()
            lbAttackList.Items.Clear()
            If Planet Is Nothing Then Return

            If Planet.SpyingReports.Count Then
                For Each spr As OGameObject.SpyReport In Planet.SpyingReports
                    spr.ToStringType = OGameObject.SpyReport.enToStringType.ShortDateOnly
                    lbreportlist.Items.Add(spr)
                Next
                For Each ar As OGameObject.AttackReport In Planet.AttackReports
                    lbAttackList.Items.Add(ar)
                Next
                rtbreport.Text = Planet.SpyingReports.Item(0).RawReport
                lbreportlist.SelectedItem = Planet.SpyingReports.Item(0)
                ColorSpyingReport(rtbreport)
                With Planet.SpyingReports.Item(0).GetSpyData
                    tbespioinfo.Text = "LC:" & .LargeCargoNeeded & vbCrLf & "rec:" & .RecyclerNeeded
                End With
            End If
        Catch ex As Exception
            Beep()
            Console.WriteLine("Error/Exception on PlayerInfoCtrl1_PlanetSelected: " & vbCrLf & ex.Message & vbCrLf & ex.StackTrace)
        End Try

    End Sub

    Private Sub Map_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        PartialMapCtrl1.doReadSystems()
        'PartialMapCtrl1.do
    End Sub

    Private Sub PartialMapCtrl1_SystemSelected(ByVal sender As Object, ByVal Galaxy As OGameObject.Galaxy) Handles PartialMapCtrl1.SystemSelected
        If Not Galaxy Is Nothing Then
            RaiseEvent SystemSelected(Me, Galaxy)
            'MessageBox.Show(MainForm.TopForm, "Quand j'aurais le temps , j'afficherai le systeme " & Galaxy.ToString & " dans l'ecran galaxie")
        End If
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        RaiseEvent ScanModeRequest(Me)
    End Sub

    Private Sub lbreportlist_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbreportlist.SelectedIndexChanged
        Try
            If Not lbreportlist.SelectedItem Is Nothing Then
                With CType(lbreportlist.SelectedItem, OGameObject.SpyReport)
                    rtbreport.Text = .RawReport
                    ColorSpyingReport(rtbreport)
                    tbespioinfo.Text = "LC:" & .GetSpyData.LargeCargoNeeded & vbCrLf & "rec:" & .GetSpyData.RecyclerNeeded
                End With

            End If
        Catch ex As Exception

        End Try
    End Sub
    Public Event PlanetInfoRequest(ByVal sender As Object, ByVal planet As OGameObject.Planet)
    Private Sub PartialMapCtrl1_PlanetInfoRequest(ByVal sender As Object, ByVal planet As OGameObject.Planet) Handles PartialMapCtrl1.PlanetInfoRequest
        RaiseEvent PlanetInfoRequest(sender, planet)
    End Sub

    Private Sub lbAttackList_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbAttackList.SelectedIndexChanged
        Try

            If Not lbAttackList.SelectedItem Is Nothing Then
                With CType(lbAttackList.SelectedItem, OGameObject.AttackReport)
                    rtbreport.Text = .RawReport
                    tbespioinfo.Text = ""
                End With
            End If
        Catch ex As Exception

        End Try

    End Sub
End Class
