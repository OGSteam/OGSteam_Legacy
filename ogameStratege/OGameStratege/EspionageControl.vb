Public Class EspionageControl
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
    Friend WithEvents panFlotte As System.Windows.Forms.Panel
    Friend WithEvents Label61 As System.Windows.Forms.Label
    Friend WithEvents Label62 As System.Windows.Forms.Label
    Friend WithEvents Label63 As System.Windows.Forms.Label
    Friend WithEvents Label64 As System.Windows.Forms.Label
    Friend WithEvents panDefense As System.Windows.Forms.Panel
    Friend WithEvents Label41 As System.Windows.Forms.Label
    Friend WithEvents Label42 As System.Windows.Forms.Label
    Friend WithEvents Label43 As System.Windows.Forms.Label
    Friend WithEvents Label44 As System.Windows.Forms.Label
    Friend WithEvents Label45 As System.Windows.Forms.Label
    Friend WithEvents Label46 As System.Windows.Forms.Label
    Friend WithEvents Label47 As System.Windows.Forms.Label
    Friend WithEvents Label48 As System.Windows.Forms.Label
    Friend WithEvents Label49 As System.Windows.Forms.Label
    Friend WithEvents Label50 As System.Windows.Forms.Label
    Friend WithEvents Label51 As System.Windows.Forms.Label
    Friend WithEvents Label52 As System.Windows.Forms.Label
    Friend WithEvents Label53 As System.Windows.Forms.Label
    Friend WithEvents Label54 As System.Windows.Forms.Label
    Friend WithEvents Label55 As System.Windows.Forms.Label
    Friend WithEvents Label56 As System.Windows.Forms.Label
    Friend WithEvents Label57 As System.Windows.Forms.Label
    Friend WithEvents Label58 As System.Windows.Forms.Label
    Friend WithEvents Label59 As System.Windows.Forms.Label
    Friend WithEvents Label60 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents panResearch As System.Windows.Forms.Panel
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents panBuildings As System.Windows.Forms.Panel
    Friend WithEvents Label33 As System.Windows.Forms.Label
    Friend WithEvents Label34 As System.Windows.Forms.Label
    Friend WithEvents Label35 As System.Windows.Forms.Label
    Friend WithEvents Label36 As System.Windows.Forms.Label
    Friend WithEvents Label37 As System.Windows.Forms.Label
    Friend WithEvents Label38 As System.Windows.Forms.Label
    Friend WithEvents Label39 As System.Windows.Forms.Label
    Friend WithEvents Label40 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents Label65 As System.Windows.Forms.Label
    Friend WithEvents Label66 As System.Windows.Forms.Label
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        
        Me.Label17 = New System.Windows.Forms.Label
        Me.Label18 = New System.Windows.Forms.Label
        Me.Label19 = New System.Windows.Forms.Label
        Me.Label20 = New System.Windows.Forms.Label
        Me.Label21 = New System.Windows.Forms.Label
        Me.Label22 = New System.Windows.Forms.Label
        Me.Label23 = New System.Windows.Forms.Label
        Me.Label24 = New System.Windows.Forms.Label
        Me.Label25 = New System.Windows.Forms.Label
        Me.Label26 = New System.Windows.Forms.Label
        Me.Label27 = New System.Windows.Forms.Label
        Me.Label28 = New System.Windows.Forms.Label
        Me.Label29 = New System.Windows.Forms.Label
        Me.Label30 = New System.Windows.Forms.Label
        Me.Label31 = New System.Windows.Forms.Label
        Me.Label32 = New System.Windows.Forms.Label
        Me.Label61 = New System.Windows.Forms.Label
        Me.Label62 = New System.Windows.Forms.Label
        Me.Label63 = New System.Windows.Forms.Label
        Me.Label64 = New System.Windows.Forms.Label
        Me.panDefense = New System.Windows.Forms.Panel
        Me.Label41 = New System.Windows.Forms.Label
        Me.Label42 = New System.Windows.Forms.Label
        Me.Label43 = New System.Windows.Forms.Label
        Me.Label44 = New System.Windows.Forms.Label
        Me.Label45 = New System.Windows.Forms.Label
        Me.Label46 = New System.Windows.Forms.Label
        Me.Label47 = New System.Windows.Forms.Label
        Me.Label48 = New System.Windows.Forms.Label
        Me.Label49 = New System.Windows.Forms.Label
        Me.Label50 = New System.Windows.Forms.Label
        Me.Label51 = New System.Windows.Forms.Label
        Me.Label52 = New System.Windows.Forms.Label
        Me.Label53 = New System.Windows.Forms.Label
        Me.Label54 = New System.Windows.Forms.Label
        Me.Label55 = New System.Windows.Forms.Label
        Me.Label56 = New System.Windows.Forms.Label
        Me.Label57 = New System.Windows.Forms.Label
        Me.Label58 = New System.Windows.Forms.Label
        Me.Label59 = New System.Windows.Forms.Label
        Me.Label60 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.Label8 = New System.Windows.Forms.Label
        Me.panResearch = New System.Windows.Forms.Panel
        Me.Label7 = New System.Windows.Forms.Label
        Me.panBuildings = New System.Windows.Forms.Panel
        Me.Label33 = New System.Windows.Forms.Label
        Me.Label34 = New System.Windows.Forms.Label
        Me.Label35 = New System.Windows.Forms.Label
        Me.Label36 = New System.Windows.Forms.Label
        Me.Label37 = New System.Windows.Forms.Label
        Me.Label38 = New System.Windows.Forms.Label
        Me.Label39 = New System.Windows.Forms.Label
        Me.Label40 = New System.Windows.Forms.Label
        Me.Label6 = New System.Windows.Forms.Label
        Me.Label65 = New System.Windows.Forms.Label
        Me.Label66 = New System.Windows.Forms.Label
        Me.panMain.SuspendLayout()
        Me.PanSubMain.SuspendLayout()
        Me.panFlotte.SuspendLayout()
        Me.panMaterial.SuspendLayout()
        Me.panDefense.SuspendLayout()
        Me.panBuildings.SuspendLayout()
        Me.SuspendLayout()
        '
        'panMain
        '
        Me.panMain.Controls.Add(Me.PanSubMain)
        Me.panMain.Controls.Add(Me.Label3)
        Me.panMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.panMain.Location = New System.Drawing.Point(0, 0)
        Me.panMain.Name = "panMain"
        Me.panMain.Size = New System.Drawing.Size(200, 520)
        Me.panMain.TabIndex = 0
        '
        'Label3
        '
        Me.Label3.BackColor = System.Drawing.SystemColors.Highlight
        Me.Label3.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label3.ForeColor = System.Drawing.SystemColors.HighlightText
        Me.Label3.Location = New System.Drawing.Point(0, 0)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(200, 16)
        Me.Label3.TabIndex = 21
        Me.Label3.Text = "Espionages"
        Me.Label3.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'PanSubMain
        '
        Me.PanSubMain.Controls.Add(Me.Label8)
        Me.PanSubMain.Controls.Add(Me.panResearch)
        Me.PanSubMain.Controls.Add(Me.Label7)
        Me.PanSubMain.Controls.Add(Me.panBuildings)
        Me.PanSubMain.Controls.Add(Me.Label6)
        Me.PanSubMain.Controls.Add(Me.panDefense)
        Me.PanSubMain.Controls.Add(Me.Label2)
        Me.PanSubMain.Controls.Add(Me.panFlotte)
        Me.PanSubMain.Controls.Add(Me.Label4)
        Me.PanSubMain.Controls.Add(Me.panMaterial)
        Me.PanSubMain.Controls.Add(Me.Label5)
        Me.PanSubMain.Controls.Add(Me.Label1)
        Me.PanSubMain.Dock = System.Windows.Forms.DockStyle.Fill
        Me.PanSubMain.Location = New System.Drawing.Point(0, 16)
        Me.PanSubMain.Name = "PanSubMain"
        Me.PanSubMain.Size = New System.Drawing.Size(200, 504)
        Me.PanSubMain.TabIndex = 22
        '
        'panFlotte
        '
        Me.panFlotte.BackColor = System.Drawing.Color.DarkSlateGray
        Me.panFlotte.Controls.Add(Me.Label17)
        Me.panFlotte.Controls.Add(Me.Label18)
        Me.panFlotte.Controls.Add(Me.Label19)
        Me.panFlotte.Controls.Add(Me.Label20)
        Me.panFlotte.Controls.Add(Me.Label21)
        Me.panFlotte.Controls.Add(Me.Label22)
        Me.panFlotte.Controls.Add(Me.Label23)
        Me.panFlotte.Controls.Add(Me.Label24)
        Me.panFlotte.Controls.Add(Me.Label25)
        Me.panFlotte.Controls.Add(Me.Label26)
        Me.panFlotte.Controls.Add(Me.Label27)
        Me.panFlotte.Controls.Add(Me.Label28)
        Me.panFlotte.Controls.Add(Me.Label29)
        Me.panFlotte.Controls.Add(Me.Label30)
        Me.panFlotte.Controls.Add(Me.Label31)
        Me.panFlotte.Controls.Add(Me.Label32)
        Me.panFlotte.Controls.Add(Me.Label61)
        Me.panFlotte.Controls.Add(Me.Label62)
        Me.panFlotte.Controls.Add(Me.Label63)
        Me.panFlotte.Controls.Add(Me.Label64)
        Me.panFlotte.Controls.Add(Me.Label65)
        Me.panFlotte.Controls.Add(Me.Label66)
        Me.panFlotte.Dock = System.Windows.Forms.DockStyle.Top
        Me.panFlotte.Location = New System.Drawing.Point(0, 80)
        Me.panFlotte.Name = "panFlotte"
        Me.panFlotte.Size = New System.Drawing.Size(200, 112)
        Me.panFlotte.TabIndex = 40
        '
        'Label4
        '
        Me.Label4.BackColor = System.Drawing.Color.Navy
        Me.Label4.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label4.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.ForeColor = System.Drawing.Color.White
        Me.Label4.Location = New System.Drawing.Point(0, 64)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(200, 16)
        Me.Label4.TabIndex = 39
        Me.Label4.Text = "Flotte"
        Me.Label4.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'panMaterial
        '
        Me.panMaterial.BackColor = System.Drawing.Color.DarkSlateGray
        Me.panMaterial.Controls.Add(Me.Label9)
        Me.panMaterial.Controls.Add(Me.Label10)
        Me.panMaterial.Controls.Add(Me.Label11)
        Me.panMaterial.Controls.Add(Me.Label12)
        Me.panMaterial.Controls.Add(Me.Label13)
        Me.panMaterial.Controls.Add(Me.Label14)
        Me.panMaterial.Controls.Add(Me.Label15)
        Me.panMaterial.Controls.Add(Me.Label16)
        Me.panMaterial.Dock = System.Windows.Forms.DockStyle.Top
        Me.panMaterial.Location = New System.Drawing.Point(0, 32)
        Me.panMaterial.Name = "panMaterial"
        Me.panMaterial.Size = New System.Drawing.Size(200, 32)
        Me.panMaterial.TabIndex = 36
        '
        'Label5
        '
        Me.Label5.BackColor = System.Drawing.Color.Navy
        Me.Label5.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label5.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.ForeColor = System.Drawing.Color.White
        Me.Label5.Location = New System.Drawing.Point(0, 16)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(200, 16)
        Me.Label5.TabIndex = 35
        Me.Label5.Text = "Material"
        Me.Label5.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label1
        '
        Me.Label1.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label1.Location = New System.Drawing.Point(0, 0)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(200, 16)
        Me.Label1.TabIndex = 34
        Me.Label1.Text = "Material on"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label9
        '
        Me.Label9.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label9.Location = New System.Drawing.Point(8, 0)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(40, 16)
        Me.Label9.TabIndex = 0
        Me.Label9.Text = "Metal"
        Me.Label9.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label10
        '
        Me.Label10.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label10.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label10.ForeColor = System.Drawing.Color.Yellow
        Me.Label10.Location = New System.Drawing.Point(48, 0)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(56, 16)
        Me.Label10.TabIndex = 0
        Me.Label10.Text = "Metal"
        Me.Label10.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label11
        '
        Me.Label11.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label11.Location = New System.Drawing.Point(104, 0)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(40, 16)
        Me.Label11.TabIndex = 0
        Me.Label11.Text = "Crystal"
        Me.Label11.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label12
        '
        Me.Label12.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label12.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label12.ForeColor = System.Drawing.Color.Yellow
        Me.Label12.Location = New System.Drawing.Point(144, 0)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(56, 16)
        Me.Label12.TabIndex = 0
        Me.Label12.Text = "Crystal"
        Me.Label12.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label13
        '
        Me.Label13.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label13.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label13.ForeColor = System.Drawing.Color.Yellow
        Me.Label13.Location = New System.Drawing.Point(144, 16)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(56, 16)
        Me.Label13.TabIndex = 0
        Me.Label13.Text = "Energy"
        Me.Label13.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label14
        '
        Me.Label14.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label14.Location = New System.Drawing.Point(104, 16)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(40, 16)
        Me.Label14.TabIndex = 0
        Me.Label14.Text = "Energy"
        Me.Label14.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label15
        '
        Me.Label15.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label15.Location = New System.Drawing.Point(8, 16)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(40, 16)
        Me.Label15.TabIndex = 0
        Me.Label15.Text = "Deut"
        Me.Label15.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label16
        '
        Me.Label16.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label16.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label16.ForeColor = System.Drawing.Color.Yellow
        Me.Label16.Location = New System.Drawing.Point(48, 16)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(56, 16)
        Me.Label16.TabIndex = 0
        Me.Label16.Text = "Deut"
        Me.Label16.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label17
        '
        Me.Label17.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label17.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label17.Location = New System.Drawing.Point(8, 8)
        Me.Label17.Name = "Label17"
        Me.Label17.Size = New System.Drawing.Size(40, 16)
        Me.Label17.TabIndex = 20
        Me.Label17.Text = "LightF"
        Me.Label17.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label18
        '
        Me.Label18.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label18.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label18.ForeColor = System.Drawing.Color.Yellow
        Me.Label18.Location = New System.Drawing.Point(48, 8)
        Me.Label18.Name = "Label18"
        Me.Label18.Size = New System.Drawing.Size(56, 16)
        Me.Label18.TabIndex = 17
        Me.Label18.Text = "LightF"
        Me.Label18.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label19
        '
        Me.Label19.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label19.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label19.Location = New System.Drawing.Point(104, 8)
        Me.Label19.Name = "Label19"
        Me.Label19.Size = New System.Drawing.Size(40, 16)
        Me.Label19.TabIndex = 24
        Me.Label19.Text = "HeavyF"
        Me.Label19.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label20
        '
        Me.Label20.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label20.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label20.ForeColor = System.Drawing.Color.Yellow
        Me.Label20.Location = New System.Drawing.Point(144, 8)
        Me.Label20.Name = "Label20"
        Me.Label20.Size = New System.Drawing.Size(56, 16)
        Me.Label20.TabIndex = 21
        Me.Label20.Text = "HeavyF"
        Me.Label20.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label21
        '
        Me.Label21.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label21.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label21.ForeColor = System.Drawing.Color.Yellow
        Me.Label21.Location = New System.Drawing.Point(144, 24)
        Me.Label21.Name = "Label21"
        Me.Label21.Size = New System.Drawing.Size(56, 16)
        Me.Label21.TabIndex = 11
        Me.Label21.Text = "Cruiser"
        Me.Label21.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label22
        '
        Me.Label22.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label22.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label22.Location = New System.Drawing.Point(104, 24)
        Me.Label22.Name = "Label22"
        Me.Label22.Size = New System.Drawing.Size(40, 16)
        Me.Label22.TabIndex = 9
        Me.Label22.Text = "Cruiser"
        Me.Label22.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label23
        '
        Me.Label23.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label23.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label23.Location = New System.Drawing.Point(8, 24)
        Me.Label23.Name = "Label23"
        Me.Label23.Size = New System.Drawing.Size(40, 16)
        Me.Label23.TabIndex = 16
        Me.Label23.Text = "BShip"
        Me.Label23.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label24
        '
        Me.Label24.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label24.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label24.ForeColor = System.Drawing.Color.Yellow
        Me.Label24.Location = New System.Drawing.Point(48, 24)
        Me.Label24.Name = "Label24"
        Me.Label24.Size = New System.Drawing.Size(56, 16)
        Me.Label24.TabIndex = 14
        Me.Label24.Text = "BShip"
        Me.Label24.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label25
        '
        Me.Label25.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label25.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label25.Location = New System.Drawing.Point(8, 40)
        Me.Label25.Name = "Label25"
        Me.Label25.Size = New System.Drawing.Size(40, 16)
        Me.Label25.TabIndex = 19
        Me.Label25.Text = "Bomber"
        Me.Label25.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label26
        '
        Me.Label26.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label26.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label26.ForeColor = System.Drawing.Color.Yellow
        Me.Label26.Location = New System.Drawing.Point(48, 40)
        Me.Label26.Name = "Label26"
        Me.Label26.Size = New System.Drawing.Size(56, 16)
        Me.Label26.TabIndex = 18
        Me.Label26.Text = "Bomber"
        Me.Label26.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label27
        '
        Me.Label27.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label27.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label27.Location = New System.Drawing.Point(104, 40)
        Me.Label27.Name = "Label27"
        Me.Label27.Size = New System.Drawing.Size(40, 16)
        Me.Label27.TabIndex = 23
        Me.Label27.Text = "Destroy"
        Me.Label27.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label28
        '
        Me.Label28.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label28.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label28.ForeColor = System.Drawing.Color.Yellow
        Me.Label28.Location = New System.Drawing.Point(48, 56)
        Me.Label28.Name = "Label28"
        Me.Label28.Size = New System.Drawing.Size(56, 16)
        Me.Label28.TabIndex = 13
        Me.Label28.Text = "Colo"
        Me.Label28.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label29
        '
        Me.Label29.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label29.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label29.Location = New System.Drawing.Point(8, 56)
        Me.Label29.Name = "Label29"
        Me.Label29.Size = New System.Drawing.Size(40, 16)
        Me.Label29.TabIndex = 15
        Me.Label29.Text = "Colo"
        Me.Label29.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label30
        '
        Me.Label30.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label30.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label30.Location = New System.Drawing.Point(104, 56)
        Me.Label30.Name = "Label30"
        Me.Label30.Size = New System.Drawing.Size(40, 16)
        Me.Label30.TabIndex = 10
        Me.Label30.Text = "Recycl"
        Me.Label30.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label31
        '
        Me.Label31.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label31.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label31.ForeColor = System.Drawing.Color.Yellow
        Me.Label31.Location = New System.Drawing.Point(144, 56)
        Me.Label31.Name = "Label31"
        Me.Label31.Size = New System.Drawing.Size(56, 16)
        Me.Label31.TabIndex = 12
        Me.Label31.Text = "Recycl"
        Me.Label31.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label32
        '
        Me.Label32.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label32.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label32.ForeColor = System.Drawing.Color.Yellow
        Me.Label32.Location = New System.Drawing.Point(144, 40)
        Me.Label32.Name = "Label32"
        Me.Label32.Size = New System.Drawing.Size(56, 16)
        Me.Label32.TabIndex = 22
        Me.Label32.Text = "Destroy"
        Me.Label32.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label61
        '
        Me.Label61.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label61.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label61.ForeColor = System.Drawing.Color.Yellow
        Me.Label61.Location = New System.Drawing.Point(48, 72)
        Me.Label61.Name = "Label61"
        Me.Label61.Size = New System.Drawing.Size(56, 16)
        Me.Label61.TabIndex = 13
        Me.Label61.Text = "Spy"
        Me.Label61.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label62
        '
        Me.Label62.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label62.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label62.Location = New System.Drawing.Point(8, 72)
        Me.Label62.Name = "Label62"
        Me.Label62.Size = New System.Drawing.Size(40, 16)
        Me.Label62.TabIndex = 15
        Me.Label62.Text = "Spy"
        Me.Label62.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label63
        '
        Me.Label63.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label63.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label63.Location = New System.Drawing.Point(104, 72)
        Me.Label63.Name = "Label63"
        Me.Label63.Size = New System.Drawing.Size(40, 16)
        Me.Label63.TabIndex = 10
        Me.Label63.Text = "Solar"
        Me.Label63.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label64
        '
        Me.Label64.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label64.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label64.ForeColor = System.Drawing.Color.Yellow
        Me.Label64.Location = New System.Drawing.Point(144, 72)
        Me.Label64.Name = "Label64"
        Me.Label64.Size = New System.Drawing.Size(56, 16)
        Me.Label64.TabIndex = 12
        Me.Label64.Text = "Solar"
        Me.Label64.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panDefense
        '
        Me.panDefense.BackColor = System.Drawing.Color.DarkSlateGray
        Me.panDefense.Controls.Add(Me.Label41)
        Me.panDefense.Controls.Add(Me.Label42)
        Me.panDefense.Controls.Add(Me.Label43)
        Me.panDefense.Controls.Add(Me.Label44)
        Me.panDefense.Controls.Add(Me.Label45)
        Me.panDefense.Controls.Add(Me.Label46)
        Me.panDefense.Controls.Add(Me.Label47)
        Me.panDefense.Controls.Add(Me.Label48)
        Me.panDefense.Controls.Add(Me.Label49)
        Me.panDefense.Controls.Add(Me.Label50)
        Me.panDefense.Controls.Add(Me.Label51)
        Me.panDefense.Controls.Add(Me.Label52)
        Me.panDefense.Controls.Add(Me.Label53)
        Me.panDefense.Controls.Add(Me.Label54)
        Me.panDefense.Controls.Add(Me.Label55)
        Me.panDefense.Controls.Add(Me.Label56)
        Me.panDefense.Controls.Add(Me.Label57)
        Me.panDefense.Controls.Add(Me.Label58)
        Me.panDefense.Controls.Add(Me.Label59)
        Me.panDefense.Controls.Add(Me.Label60)
        Me.panDefense.Dock = System.Windows.Forms.DockStyle.Top
        Me.panDefense.Location = New System.Drawing.Point(0, 208)
        Me.panDefense.Name = "panDefense"
        Me.panDefense.Size = New System.Drawing.Size(200, 80)
        Me.panDefense.TabIndex = 47
        '
        'Label41
        '
        Me.Label41.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label41.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label41.Location = New System.Drawing.Point(8, 0)
        Me.Label41.Name = "Label41"
        Me.Label41.Size = New System.Drawing.Size(40, 16)
        Me.Label41.TabIndex = 36
        Me.Label41.Text = "Missile"
        Me.Label41.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label42
        '
        Me.Label42.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label42.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label42.ForeColor = System.Drawing.Color.Yellow
        Me.Label42.Location = New System.Drawing.Point(48, 0)
        Me.Label42.Name = "Label42"
        Me.Label42.Size = New System.Drawing.Size(56, 16)
        Me.Label42.TabIndex = 33
        Me.Label42.Text = "Missile"
        Me.Label42.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label43
        '
        Me.Label43.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label43.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label43.Location = New System.Drawing.Point(104, 0)
        Me.Label43.Name = "Label43"
        Me.Label43.Size = New System.Drawing.Size(40, 16)
        Me.Label43.TabIndex = 40
        Me.Label43.Text = "Lazer"
        Me.Label43.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label44
        '
        Me.Label44.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label44.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label44.ForeColor = System.Drawing.Color.Yellow
        Me.Label44.Location = New System.Drawing.Point(144, 0)
        Me.Label44.Name = "Label44"
        Me.Label44.Size = New System.Drawing.Size(56, 16)
        Me.Label44.TabIndex = 37
        Me.Label44.Text = "Lazer"
        Me.Label44.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label45
        '
        Me.Label45.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label45.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label45.ForeColor = System.Drawing.Color.Yellow
        Me.Label45.Location = New System.Drawing.Point(144, 16)
        Me.Label45.Name = "Label45"
        Me.Label45.Size = New System.Drawing.Size(56, 16)
        Me.Label45.TabIndex = 27
        Me.Label45.Text = "Ion"
        Me.Label45.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label46
        '
        Me.Label46.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label46.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label46.Location = New System.Drawing.Point(104, 16)
        Me.Label46.Name = "Label46"
        Me.Label46.Size = New System.Drawing.Size(40, 16)
        Me.Label46.TabIndex = 25
        Me.Label46.Text = "Ion"
        Me.Label46.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label47
        '
        Me.Label47.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label47.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label47.Location = New System.Drawing.Point(8, 16)
        Me.Label47.Name = "Label47"
        Me.Label47.Size = New System.Drawing.Size(40, 16)
        Me.Label47.TabIndex = 32
        Me.Label47.Text = "HLazer"
        Me.Label47.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label48
        '
        Me.Label48.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label48.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label48.ForeColor = System.Drawing.Color.Yellow
        Me.Label48.Location = New System.Drawing.Point(48, 16)
        Me.Label48.Name = "Label48"
        Me.Label48.Size = New System.Drawing.Size(56, 16)
        Me.Label48.TabIndex = 30
        Me.Label48.Text = "HLazer"
        Me.Label48.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label49
        '
        Me.Label49.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label49.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label49.Location = New System.Drawing.Point(8, 32)
        Me.Label49.Name = "Label49"
        Me.Label49.Size = New System.Drawing.Size(40, 16)
        Me.Label49.TabIndex = 35
        Me.Label49.Text = "Gauss"
        Me.Label49.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label50
        '
        Me.Label50.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label50.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label50.ForeColor = System.Drawing.Color.Yellow
        Me.Label50.Location = New System.Drawing.Point(48, 32)
        Me.Label50.Name = "Label50"
        Me.Label50.Size = New System.Drawing.Size(56, 16)
        Me.Label50.TabIndex = 34
        Me.Label50.Text = "Gauss"
        Me.Label50.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label51
        '
        Me.Label51.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label51.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label51.Location = New System.Drawing.Point(104, 32)
        Me.Label51.Name = "Label51"
        Me.Label51.Size = New System.Drawing.Size(40, 16)
        Me.Label51.TabIndex = 39
        Me.Label51.Text = "Plasma"
        Me.Label51.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label52
        '
        Me.Label52.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label52.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label52.ForeColor = System.Drawing.Color.Yellow
        Me.Label52.Location = New System.Drawing.Point(48, 48)
        Me.Label52.Name = "Label52"
        Me.Label52.Size = New System.Drawing.Size(56, 16)
        Me.Label52.TabIndex = 29
        Me.Label52.Text = "SShield"
        Me.Label52.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label53
        '
        Me.Label53.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label53.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label53.Location = New System.Drawing.Point(8, 48)
        Me.Label53.Name = "Label53"
        Me.Label53.Size = New System.Drawing.Size(40, 16)
        Me.Label53.TabIndex = 31
        Me.Label53.Text = "SShield"
        Me.Label53.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label54
        '
        Me.Label54.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label54.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label54.Location = New System.Drawing.Point(104, 48)
        Me.Label54.Name = "Label54"
        Me.Label54.Size = New System.Drawing.Size(40, 16)
        Me.Label54.TabIndex = 26
        Me.Label54.Text = "LShield"
        Me.Label54.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label55
        '
        Me.Label55.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label55.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label55.ForeColor = System.Drawing.Color.Yellow
        Me.Label55.Location = New System.Drawing.Point(144, 48)
        Me.Label55.Name = "Label55"
        Me.Label55.Size = New System.Drawing.Size(56, 16)
        Me.Label55.TabIndex = 28
        Me.Label55.Text = "LShield"
        Me.Label55.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label56
        '
        Me.Label56.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label56.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label56.ForeColor = System.Drawing.Color.Yellow
        Me.Label56.Location = New System.Drawing.Point(144, 32)
        Me.Label56.Name = "Label56"
        Me.Label56.Size = New System.Drawing.Size(56, 16)
        Me.Label56.TabIndex = 38
        Me.Label56.Text = "Plasma"
        Me.Label56.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label57
        '
        Me.Label57.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label57.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label57.ForeColor = System.Drawing.Color.Yellow
        Me.Label57.Location = New System.Drawing.Point(48, 64)
        Me.Label57.Name = "Label57"
        Me.Label57.Size = New System.Drawing.Size(56, 16)
        Me.Label57.TabIndex = 29
        Me.Label57.Text = "Intercep"
        Me.Label57.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label58
        '
        Me.Label58.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label58.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label58.Location = New System.Drawing.Point(8, 64)
        Me.Label58.Name = "Label58"
        Me.Label58.Size = New System.Drawing.Size(40, 16)
        Me.Label58.TabIndex = 31
        Me.Label58.Text = "Intercep"
        Me.Label58.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label59
        '
        Me.Label59.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label59.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label59.Location = New System.Drawing.Point(104, 64)
        Me.Label59.Name = "Label59"
        Me.Label59.Size = New System.Drawing.Size(40, 16)
        Me.Label59.TabIndex = 26
        Me.Label59.Text = "InterPl"
        Me.Label59.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label60
        '
        Me.Label60.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label60.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label60.ForeColor = System.Drawing.Color.Yellow
        Me.Label60.Location = New System.Drawing.Point(144, 64)
        Me.Label60.Name = "Label60"
        Me.Label60.Size = New System.Drawing.Size(56, 16)
        Me.Label60.TabIndex = 28
        Me.Label60.Text = "InterPl"
        Me.Label60.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label2
        '
        Me.Label2.BackColor = System.Drawing.Color.Navy
        Me.Label2.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(0, 192)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(200, 16)
        Me.Label2.TabIndex = 46
        Me.Label2.Text = "Defense"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label8
        '
        Me.Label8.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label8.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label8.Location = New System.Drawing.Point(0, 472)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(200, 16)
        Me.Label8.TabIndex = 52
        Me.Label8.Text = "Material on"
        Me.Label8.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panResearch
        '
        Me.panResearch.BackColor = System.Drawing.Color.DarkSlateGray
        Me.panResearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.panResearch.Location = New System.Drawing.Point(0, 432)
        Me.panResearch.Name = "panResearch"
        Me.panResearch.Size = New System.Drawing.Size(200, 40)
        Me.panResearch.TabIndex = 51
        '
        'Label7
        '
        Me.Label7.BackColor = System.Drawing.Color.Navy
        Me.Label7.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label7.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label7.ForeColor = System.Drawing.Color.White
        Me.Label7.Location = New System.Drawing.Point(0, 416)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(200, 16)
        Me.Label7.TabIndex = 50
        Me.Label7.Text = "Research"
        Me.Label7.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'panBuildings
        '
        Me.panBuildings.BackColor = System.Drawing.Color.DarkSlateGray
        Me.panBuildings.Controls.Add(Me.Label33)
        Me.panBuildings.Controls.Add(Me.Label34)
        Me.panBuildings.Controls.Add(Me.Label35)
        Me.panBuildings.Controls.Add(Me.Label36)
        Me.panBuildings.Controls.Add(Me.Label37)
        Me.panBuildings.Controls.Add(Me.Label38)
        Me.panBuildings.Controls.Add(Me.Label39)
        Me.panBuildings.Controls.Add(Me.Label40)
        Me.panBuildings.Dock = System.Windows.Forms.DockStyle.Top
        Me.panBuildings.Location = New System.Drawing.Point(0, 304)
        Me.panBuildings.Name = "panBuildings"
        Me.panBuildings.Size = New System.Drawing.Size(200, 112)
        Me.panBuildings.TabIndex = 49
        '
        'Label33
        '
        Me.Label33.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label33.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label33.ForeColor = System.Drawing.Color.Yellow
        Me.Label33.Location = New System.Drawing.Point(140, 16)
        Me.Label33.Name = "Label33"
        Me.Label33.Size = New System.Drawing.Size(56, 16)
        Me.Label33.TabIndex = 23
        Me.Label33.Text = "Crystal"
        Me.Label33.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label34
        '
        Me.Label34.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label34.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label34.ForeColor = System.Drawing.Color.Yellow
        Me.Label34.Location = New System.Drawing.Point(140, 32)
        Me.Label34.Name = "Label34"
        Me.Label34.Size = New System.Drawing.Size(56, 16)
        Me.Label34.TabIndex = 18
        Me.Label34.Text = "Energy"
        Me.Label34.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label35
        '
        Me.Label35.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label35.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label35.Location = New System.Drawing.Point(100, 32)
        Me.Label35.Name = "Label35"
        Me.Label35.Size = New System.Drawing.Size(40, 16)
        Me.Label35.TabIndex = 17
        Me.Label35.Text = "Energy"
        Me.Label35.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label36
        '
        Me.Label36.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label36.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label36.Location = New System.Drawing.Point(4, 32)
        Me.Label36.Name = "Label36"
        Me.Label36.Size = New System.Drawing.Size(40, 16)
        Me.Label36.TabIndex = 20
        Me.Label36.Text = "Deut"
        Me.Label36.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label37
        '
        Me.Label37.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label37.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label37.ForeColor = System.Drawing.Color.Yellow
        Me.Label37.Location = New System.Drawing.Point(44, 32)
        Me.Label37.Name = "Label37"
        Me.Label37.Size = New System.Drawing.Size(56, 16)
        Me.Label37.TabIndex = 19
        Me.Label37.Text = "Deut"
        Me.Label37.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label38
        '
        Me.Label38.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label38.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label38.Location = New System.Drawing.Point(100, 16)
        Me.Label38.Name = "Label38"
        Me.Label38.Size = New System.Drawing.Size(40, 16)
        Me.Label38.TabIndex = 24
        Me.Label38.Text = "Crystal"
        Me.Label38.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label39
        '
        Me.Label39.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label39.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label39.ForeColor = System.Drawing.Color.Yellow
        Me.Label39.Location = New System.Drawing.Point(44, 16)
        Me.Label39.Name = "Label39"
        Me.Label39.Size = New System.Drawing.Size(56, 16)
        Me.Label39.TabIndex = 21
        Me.Label39.Text = "Metal"
        Me.Label39.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label40
        '
        Me.Label40.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label40.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label40.Location = New System.Drawing.Point(4, 16)
        Me.Label40.Name = "Label40"
        Me.Label40.Size = New System.Drawing.Size(40, 16)
        Me.Label40.TabIndex = 22
        Me.Label40.Text = "Metal"
        Me.Label40.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label6
        '
        Me.Label6.BackColor = System.Drawing.Color.Navy
        Me.Label6.Dock = System.Windows.Forms.DockStyle.Top
        Me.Label6.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label6.ForeColor = System.Drawing.Color.White
        Me.Label6.Location = New System.Drawing.Point(0, 288)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(200, 16)
        Me.Label6.TabIndex = 48
        Me.Label6.Text = "Buildings"
        Me.Label6.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'Label65
        '
        Me.Label65.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label65.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label65.ForeColor = System.Drawing.Color.Yellow
        Me.Label65.Location = New System.Drawing.Point(96, 88)
        Me.Label65.Name = "Label65"
        Me.Label65.Size = New System.Drawing.Size(64, 16)
        Me.Label65.TabIndex = 13
        Me.Label65.Text = "DeathStar"
        Me.Label65.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label66
        '
        Me.Label66.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label66.ForeColor = System.Drawing.Color.Gainsboro
        Me.Label66.Location = New System.Drawing.Point(32, 88)
        Me.Label66.Name = "Label66"
        Me.Label66.Size = New System.Drawing.Size(72, 16)
        Me.Label66.TabIndex = 15
        Me.Label66.Text = "DeathStar"
        Me.Label66.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'EspionageControl
        '
        Me.Controls.Add(Me.panMain)
        Me.Name = "EspionageControl"
        Me.Size = New System.Drawing.Size(200, 520)
        Me.panMain.ResumeLayout(False)
        Me.PanSubMain.ResumeLayout(False)
        Me.panFlotte.ResumeLayout(False)
        Me.panMaterial.ResumeLayout(False)
        Me.panDefense.ResumeLayout(False)
        Me.panBuildings.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Friend WithEvents Label32 As System.Windows.Forms.Label
    Friend WithEvents Label31 As System.Windows.Forms.Label
    Friend WithEvents Label30 As System.Windows.Forms.Label
    Friend WithEvents Label29 As System.Windows.Forms.Label
    Friend WithEvents Label28 As System.Windows.Forms.Label
    Friend WithEvents Label27 As System.Windows.Forms.Label
    Friend WithEvents Label26 As System.Windows.Forms.Label
    Friend WithEvents Label25 As System.Windows.Forms.Label
    Friend WithEvents Label24 As System.Windows.Forms.Label
    Friend WithEvents Label23 As System.Windows.Forms.Label
    Friend WithEvents Label22 As System.Windows.Forms.Label
    Friend WithEvents Label21 As System.Windows.Forms.Label
    Friend WithEvents Label20 As System.Windows.Forms.Label
    Friend WithEvents Label19 As System.Windows.Forms.Label
    Friend WithEvents Label18 As System.Windows.Forms.Label
    Friend WithEvents Label17 As System.Windows.Forms.Label
End Class
