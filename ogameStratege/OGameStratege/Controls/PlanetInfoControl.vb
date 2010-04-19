Public Class PlanetInfoControl
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

        ' This enables mouse support such as the Mouse Wheel
        setstyle(ControlStyles.UserMouse, True)

        ' This will repaint the control whenever it is resized
        setstyle(ControlStyles.ResizeRedraw, False)

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
    Friend WithEvents lblNameCoords As System.Windows.Forms.Label
    Friend WithEvents labResources As System.Windows.Forms.Label
    Friend WithEvents panResources As System.Windows.Forms.Panel
    Friend WithEvents panFlotte As System.Windows.Forms.Panel
    Friend WithEvents labFlotte As System.Windows.Forms.Label
    Friend WithEvents panDefense As System.Windows.Forms.Panel
    Friend WithEvents labDefense As System.Windows.Forms.Label
    Friend WithEvents panBuildings As System.Windows.Forms.Panel
    Friend WithEvents lbBuildings As System.Windows.Forms.Label
    Friend WithEvents panResearch As System.Windows.Forms.Panel
    Friend WithEvents labResearch As System.Windows.Forms.Label
    Friend WithEvents ToolTip1 As System.Windows.Forms.ToolTip
    Friend WithEvents lbbEnergy As OGameStratege.LabelBox
    Friend WithEvents lbbDeuterium As OGameStratege.LabelBox
    Friend WithEvents lbbCristal As OGameStratege.LabelBox
    Friend WithEvents lbbMetal As OGameStratege.LabelBox
    Friend WithEvents lbbDeathStar As OGameStratege.LabelBox
    Friend WithEvents lbbDestroyer As OGameStratege.LabelBox
    Friend WithEvents lbbSolarSat As OGameStratege.LabelBox
    Friend WithEvents lbbBomber As OGameStratege.LabelBox
    Friend WithEvents lbbEspionageProbe As OGameStratege.LabelBox
    Friend WithEvents lbbRecycler As OGameStratege.LabelBox
    Friend WithEvents lbbColonyShip As OGameStratege.LabelBox
    Friend WithEvents lbbBattleShip As OGameStratege.LabelBox
    Friend WithEvents lbbCruiser As OGameStratege.LabelBox
    Friend WithEvents lbbHeavyFighter As OGameStratege.LabelBox
    Friend WithEvents lbbLightFighter As OGameStratege.LabelBox
    Friend WithEvents lbbLargeCargo As OGameStratege.LabelBox
    Friend WithEvents lbbSmalCargo As OGameStratege.LabelBox
    Friend WithEvents lbbInterplanMissile As OGameStratege.LabelBox
    Friend WithEvents lbbInterceptMissile As OGameStratege.LabelBox
    Friend WithEvents lbbLargeShield As OGameStratege.LabelBox
    Friend WithEvents lbbSmallShield As OGameStratege.LabelBox
    Friend WithEvents lbbPlasmaCannon As OGameStratege.LabelBox
    Friend WithEvents lbbGaussCannon As OGameStratege.LabelBox
    Friend WithEvents lbbIonCannon As OGameStratege.LabelBox
    Friend WithEvents lbbheavyLazer As OGameStratege.LabelBox
    Friend WithEvents lbbSmallLazer As OGameStratege.LabelBox
    Friend WithEvents lbbMissileLauncher As OGameStratege.LabelBox
    Friend WithEvents lbbTerraformer As OGameStratege.LabelBox
    Friend WithEvents lbbRocketSilo As OGameStratege.LabelBox
    Friend WithEvents lbbResearchLab As OGameStratege.LabelBox
    Friend WithEvents lbbDeuteriumTank As OGameStratege.LabelBox
    Friend WithEvents lbbCrystalStorage As OGameStratege.LabelBox
    Friend WithEvents lbbMetalStorage As OGameStratege.LabelBox
    Friend WithEvents lbbShipyard As OGameStratege.LabelBox
    Friend WithEvents lbbNaniteFactory As OGameStratege.LabelBox
    Friend WithEvents lbbRoboticFactory As OGameStratege.LabelBox
    Friend WithEvents lbbFusionPlant As OGameStratege.LabelBox
    Friend WithEvents lbbSolarPlant As OGameStratege.LabelBox
    Friend WithEvents lbbDeuthSynth As OGameStratege.LabelBox
    Friend WithEvents lbbCrystalMine As OGameStratege.LabelBox
    Friend WithEvents lbbMetalMine As OGameStratege.LabelBox
    Friend WithEvents lbbIntergalResNet As OGameStratege.LabelBox
    Friend WithEvents lbbPlasmaTech As OGameStratege.LabelBox
    Friend WithEvents lbbIontech As OGameStratege.LabelBox
    Friend WithEvents lbbLazerTech As OGameStratege.LabelBox
    Friend WithEvents lbbHyperspaceEng As OGameStratege.LabelBox
    Friend WithEvents lbbImpulseEng As OGameStratege.LabelBox
    Friend WithEvents lbbCombustionEng As OGameStratege.LabelBox
    Friend WithEvents lbbHyperspaceTech As OGameStratege.LabelBox
    Friend WithEvents lbbEnergyTech As OGameStratege.LabelBox
    Friend WithEvents lbbArmourTech As OGameStratege.LabelBox
    Friend WithEvents lbbShieldingTech As OGameStratege.LabelBox
    Friend WithEvents lbbWeapontech As OGameStratege.LabelBox
    Friend WithEvents lbbComputerTech As OGameStratege.LabelBox
    Friend WithEvents lbbEspionageTech As OGameStratege.LabelBox
    Friend WithEvents ContextMenu1 As System.Windows.Forms.ContextMenu
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Me.lblNameCoords = New System.Windows.Forms.Label
        Me.labResources = New System.Windows.Forms.Label
        Me.panResources = New System.Windows.Forms.Panel
        Me.lbbEnergy = New OGameStratege.LabelBox
        Me.lbbDeuterium = New OGameStratege.LabelBox
        Me.lbbCristal = New OGameStratege.LabelBox
        Me.lbbMetal = New OGameStratege.LabelBox
        Me.panFlotte = New System.Windows.Forms.Panel
        Me.lbbDeathStar = New OGameStratege.LabelBox
        Me.lbbDestroyer = New OGameStratege.LabelBox
        Me.lbbSolarSat = New OGameStratege.LabelBox
        Me.lbbBomber = New OGameStratege.LabelBox
        Me.lbbEspionageProbe = New OGameStratege.LabelBox
        Me.lbbRecycler = New OGameStratege.LabelBox
        Me.lbbColonyShip = New OGameStratege.LabelBox
        Me.lbbBattleShip = New OGameStratege.LabelBox
        Me.lbbCruiser = New OGameStratege.LabelBox
        Me.lbbHeavyFighter = New OGameStratege.LabelBox
        Me.lbbLightFighter = New OGameStratege.LabelBox
        Me.lbbLargeCargo = New OGameStratege.LabelBox
        Me.lbbSmalCargo = New OGameStratege.LabelBox
        Me.labFlotte = New System.Windows.Forms.Label
        Me.panDefense = New System.Windows.Forms.Panel
        Me.lbbInterplanMissile = New OGameStratege.LabelBox
        Me.lbbInterceptMissile = New OGameStratege.LabelBox
        Me.lbbLargeShield = New OGameStratege.LabelBox
        Me.lbbSmallShield = New OGameStratege.LabelBox
        Me.lbbPlasmaCannon = New OGameStratege.LabelBox
        Me.lbbGaussCannon = New OGameStratege.LabelBox
        Me.lbbIonCannon = New OGameStratege.LabelBox
        Me.lbbheavyLazer = New OGameStratege.LabelBox
        Me.lbbSmallLazer = New OGameStratege.LabelBox
        Me.lbbMissileLauncher = New OGameStratege.LabelBox
        Me.labDefense = New System.Windows.Forms.Label
        Me.panBuildings = New System.Windows.Forms.Panel
        Me.lbbTerraformer = New OGameStratege.LabelBox
        Me.lbbRocketSilo = New OGameStratege.LabelBox
        Me.lbbResearchLab = New OGameStratege.LabelBox
        Me.lbbDeuteriumTank = New OGameStratege.LabelBox
        Me.lbbCrystalStorage = New OGameStratege.LabelBox
        Me.lbbMetalStorage = New OGameStratege.LabelBox
        Me.lbbShipyard = New OGameStratege.LabelBox
        Me.lbbNaniteFactory = New OGameStratege.LabelBox
        Me.lbbRoboticFactory = New OGameStratege.LabelBox
        Me.lbbFusionPlant = New OGameStratege.LabelBox
        Me.lbbSolarPlant = New OGameStratege.LabelBox
        Me.lbbDeuthSynth = New OGameStratege.LabelBox
        Me.lbbCrystalMine = New OGameStratege.LabelBox
        Me.lbbMetalMine = New OGameStratege.LabelBox
        Me.lbBuildings = New System.Windows.Forms.Label
        Me.panResearch = New System.Windows.Forms.Panel
        Me.lbbIntergalResNet = New OGameStratege.LabelBox
        Me.lbbPlasmaTech = New OGameStratege.LabelBox
        Me.lbbIontech = New OGameStratege.LabelBox
        Me.lbbLazerTech = New OGameStratege.LabelBox
        Me.lbbHyperspaceEng = New OGameStratege.LabelBox
        Me.lbbImpulseEng = New OGameStratege.LabelBox
        Me.lbbCombustionEng = New OGameStratege.LabelBox
        Me.lbbHyperspaceTech = New OGameStratege.LabelBox
        Me.lbbEnergyTech = New OGameStratege.LabelBox
        Me.lbbArmourTech = New OGameStratege.LabelBox
        Me.lbbShieldingTech = New OGameStratege.LabelBox
        Me.lbbWeapontech = New OGameStratege.LabelBox
        Me.lbbComputerTech = New OGameStratege.LabelBox
        Me.lbbEspionageTech = New OGameStratege.LabelBox
        Me.labResearch = New System.Windows.Forms.Label
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.ContextMenu1 = New System.Windows.Forms.ContextMenu
        Me.panResources.SuspendLayout()
        Me.panFlotte.SuspendLayout()
        Me.panDefense.SuspendLayout()
        Me.panBuildings.SuspendLayout()
        Me.panResearch.SuspendLayout()
        Me.SuspendLayout()
        '
        'lblNameCoords
        '
        Me.lblNameCoords.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.lblNameCoords.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lblNameCoords.Dock = System.Windows.Forms.DockStyle.Top
        Me.lblNameCoords.Font = New System.Drawing.Font("Comic Sans MS", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblNameCoords.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.lblNameCoords.Location = New System.Drawing.Point(0, 0)
        Me.lblNameCoords.Name = "lblNameCoords"
        Me.lblNameCoords.Size = New System.Drawing.Size(184, 40)
        Me.lblNameCoords.TabIndex = 0
        Me.lblNameCoords.Text = "name [Coords]"
        Me.lblNameCoords.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'labResources
        '
        Me.labResources.BackColor = System.Drawing.Color.IndianRed
        Me.labResources.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.labResources.Dock = System.Windows.Forms.DockStyle.Top
        Me.labResources.ForeColor = System.Drawing.Color.White
        Me.labResources.Location = New System.Drawing.Point(0, 40)
        Me.labResources.Name = "labResources"
        Me.labResources.Size = New System.Drawing.Size(184, 16)
        Me.labResources.TabIndex = 1
        Me.labResources.Text = "Ressources"
        Me.labResources.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panResources
        '
        Me.panResources.Controls.Add(Me.lbbEnergy)
        Me.panResources.Controls.Add(Me.lbbDeuterium)
        Me.panResources.Controls.Add(Me.lbbCristal)
        Me.panResources.Controls.Add(Me.lbbMetal)
        Me.panResources.Dock = System.Windows.Forms.DockStyle.Top
        Me.panResources.Location = New System.Drawing.Point(0, 56)
        Me.panResources.Name = "panResources"
        Me.panResources.Size = New System.Drawing.Size(184, 72)
        Me.panResources.TabIndex = 2
        '
        'lbbEnergy
        '
        Me.lbbEnergy.Caption = "Energy"
        Me.lbbEnergy.CaptionWidth = 80
        Me.lbbEnergy.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbEnergy.Location = New System.Drawing.Point(0, 54)
        Me.lbbEnergy.Name = "lbbEnergy"
        Me.lbbEnergy.ReadOnly = False
        Me.lbbEnergy.Size = New System.Drawing.Size(184, 18)
        Me.lbbEnergy.TabIndex = 3
        Me.lbbEnergy.Value = "0"
        '
        'lbbDeuterium
        '
        Me.lbbDeuterium.Caption = "Deuterium"
        Me.lbbDeuterium.CaptionWidth = 80
        Me.lbbDeuterium.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDeuterium.Location = New System.Drawing.Point(0, 36)
        Me.lbbDeuterium.Name = "lbbDeuterium"
        Me.lbbDeuterium.ReadOnly = False
        Me.lbbDeuterium.Size = New System.Drawing.Size(184, 18)
        Me.lbbDeuterium.TabIndex = 2
        Me.lbbDeuterium.Value = "0"
        '
        'lbbCristal
        '
        Me.lbbCristal.Caption = "Cristal"
        Me.lbbCristal.CaptionWidth = 80
        Me.lbbCristal.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbCristal.Location = New System.Drawing.Point(0, 18)
        Me.lbbCristal.Name = "lbbCristal"
        Me.lbbCristal.ReadOnly = False
        Me.lbbCristal.Size = New System.Drawing.Size(184, 18)
        Me.lbbCristal.TabIndex = 1
        Me.lbbCristal.Value = "0"
        '
        'lbbMetal
        '
        Me.lbbMetal.Caption = "Metal"
        Me.lbbMetal.CaptionWidth = 80
        Me.lbbMetal.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbMetal.Location = New System.Drawing.Point(0, 0)
        Me.lbbMetal.Name = "lbbMetal"
        Me.lbbMetal.ReadOnly = False
        Me.lbbMetal.Size = New System.Drawing.Size(184, 18)
        Me.lbbMetal.TabIndex = 0
        Me.lbbMetal.Value = "0"
        '
        'panFlotte
        '
        Me.panFlotte.Controls.Add(Me.lbbDeathStar)
        Me.panFlotte.Controls.Add(Me.lbbDestroyer)
        Me.panFlotte.Controls.Add(Me.lbbSolarSat)
        Me.panFlotte.Controls.Add(Me.lbbBomber)
        Me.panFlotte.Controls.Add(Me.lbbEspionageProbe)
        Me.panFlotte.Controls.Add(Me.lbbRecycler)
        Me.panFlotte.Controls.Add(Me.lbbColonyShip)
        Me.panFlotte.Controls.Add(Me.lbbBattleShip)
        Me.panFlotte.Controls.Add(Me.lbbCruiser)
        Me.panFlotte.Controls.Add(Me.lbbHeavyFighter)
        Me.panFlotte.Controls.Add(Me.lbbLightFighter)
        Me.panFlotte.Controls.Add(Me.lbbLargeCargo)
        Me.panFlotte.Controls.Add(Me.lbbSmalCargo)
        Me.panFlotte.Dock = System.Windows.Forms.DockStyle.Top
        Me.panFlotte.Location = New System.Drawing.Point(0, 144)
        Me.panFlotte.Name = "panFlotte"
        Me.panFlotte.Size = New System.Drawing.Size(184, 232)
        Me.panFlotte.TabIndex = 4
        '
        'lbbDeathStar
        '
        Me.lbbDeathStar.Caption = "Death Star"
        Me.lbbDeathStar.CaptionWidth = 80
        Me.lbbDeathStar.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDeathStar.Location = New System.Drawing.Point(0, 216)
        Me.lbbDeathStar.Name = "lbbDeathStar"
        Me.lbbDeathStar.ReadOnly = False
        Me.lbbDeathStar.Size = New System.Drawing.Size(184, 18)
        Me.lbbDeathStar.TabIndex = 25
        Me.lbbDeathStar.Value = "0"
        '
        'lbbDestroyer
        '
        Me.lbbDestroyer.Caption = "Destroyer"
        Me.lbbDestroyer.CaptionWidth = 80
        Me.lbbDestroyer.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDestroyer.Location = New System.Drawing.Point(0, 198)
        Me.lbbDestroyer.Name = "lbbDestroyer"
        Me.lbbDestroyer.ReadOnly = False
        Me.lbbDestroyer.Size = New System.Drawing.Size(184, 18)
        Me.lbbDestroyer.TabIndex = 24
        Me.lbbDestroyer.Value = "0"
        '
        'lbbSolarSat
        '
        Me.lbbSolarSat.Caption = "Solar Satellite"
        Me.lbbSolarSat.CaptionWidth = 80
        Me.lbbSolarSat.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbSolarSat.Location = New System.Drawing.Point(0, 180)
        Me.lbbSolarSat.Name = "lbbSolarSat"
        Me.lbbSolarSat.ReadOnly = False
        Me.lbbSolarSat.Size = New System.Drawing.Size(184, 18)
        Me.lbbSolarSat.TabIndex = 23
        Me.lbbSolarSat.Value = "0"
        '
        'lbbBomber
        '
        Me.lbbBomber.Caption = "Bomber"
        Me.lbbBomber.CaptionWidth = 80
        Me.lbbBomber.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbBomber.Location = New System.Drawing.Point(0, 162)
        Me.lbbBomber.Name = "lbbBomber"
        Me.lbbBomber.ReadOnly = False
        Me.lbbBomber.Size = New System.Drawing.Size(184, 18)
        Me.lbbBomber.TabIndex = 22
        Me.lbbBomber.Value = "0"
        '
        'lbbEspionageProbe
        '
        Me.lbbEspionageProbe.Caption = "Espionage Probe"
        Me.lbbEspionageProbe.CaptionWidth = 80
        Me.lbbEspionageProbe.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbEspionageProbe.Location = New System.Drawing.Point(0, 144)
        Me.lbbEspionageProbe.Name = "lbbEspionageProbe"
        Me.lbbEspionageProbe.ReadOnly = False
        Me.lbbEspionageProbe.Size = New System.Drawing.Size(184, 18)
        Me.lbbEspionageProbe.TabIndex = 21
        Me.lbbEspionageProbe.Value = "0"
        '
        'lbbRecycler
        '
        Me.lbbRecycler.Caption = "Recycler"
        Me.lbbRecycler.CaptionWidth = 80
        Me.lbbRecycler.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbRecycler.Location = New System.Drawing.Point(0, 126)
        Me.lbbRecycler.Name = "lbbRecycler"
        Me.lbbRecycler.ReadOnly = False
        Me.lbbRecycler.Size = New System.Drawing.Size(184, 18)
        Me.lbbRecycler.TabIndex = 20
        Me.lbbRecycler.Value = "0"
        '
        'lbbColonyShip
        '
        Me.lbbColonyShip.Caption = "Colony Ship"
        Me.lbbColonyShip.CaptionWidth = 80
        Me.lbbColonyShip.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbColonyShip.Location = New System.Drawing.Point(0, 108)
        Me.lbbColonyShip.Name = "lbbColonyShip"
        Me.lbbColonyShip.ReadOnly = False
        Me.lbbColonyShip.Size = New System.Drawing.Size(184, 18)
        Me.lbbColonyShip.TabIndex = 19
        Me.lbbColonyShip.Value = "0"
        '
        'lbbBattleShip
        '
        Me.lbbBattleShip.Caption = "Battle Ship"
        Me.lbbBattleShip.CaptionWidth = 80
        Me.lbbBattleShip.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbBattleShip.Location = New System.Drawing.Point(0, 90)
        Me.lbbBattleShip.Name = "lbbBattleShip"
        Me.lbbBattleShip.ReadOnly = False
        Me.lbbBattleShip.Size = New System.Drawing.Size(184, 18)
        Me.lbbBattleShip.TabIndex = 18
        Me.lbbBattleShip.Value = "0"
        '
        'lbbCruiser
        '
        Me.lbbCruiser.Caption = "Cruiser"
        Me.lbbCruiser.CaptionWidth = 80
        Me.lbbCruiser.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbCruiser.Location = New System.Drawing.Point(0, 72)
        Me.lbbCruiser.Name = "lbbCruiser"
        Me.lbbCruiser.ReadOnly = False
        Me.lbbCruiser.Size = New System.Drawing.Size(184, 18)
        Me.lbbCruiser.TabIndex = 17
        Me.lbbCruiser.Value = "0"
        '
        'lbbHeavyFighter
        '
        Me.lbbHeavyFighter.Caption = "Heavy Fighter"
        Me.lbbHeavyFighter.CaptionWidth = 80
        Me.lbbHeavyFighter.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbHeavyFighter.Location = New System.Drawing.Point(0, 54)
        Me.lbbHeavyFighter.Name = "lbbHeavyFighter"
        Me.lbbHeavyFighter.ReadOnly = False
        Me.lbbHeavyFighter.Size = New System.Drawing.Size(184, 18)
        Me.lbbHeavyFighter.TabIndex = 16
        Me.lbbHeavyFighter.Value = "0"
        '
        'lbbLightFighter
        '
        Me.lbbLightFighter.Caption = "Light Fighter"
        Me.lbbLightFighter.CaptionWidth = 80
        Me.lbbLightFighter.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbLightFighter.Location = New System.Drawing.Point(0, 36)
        Me.lbbLightFighter.Name = "lbbLightFighter"
        Me.lbbLightFighter.ReadOnly = False
        Me.lbbLightFighter.Size = New System.Drawing.Size(184, 18)
        Me.lbbLightFighter.TabIndex = 15
        Me.lbbLightFighter.Value = "0"
        '
        'lbbLargeCargo
        '
        Me.lbbLargeCargo.Caption = "Large Cargo"
        Me.lbbLargeCargo.CaptionWidth = 80
        Me.lbbLargeCargo.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbLargeCargo.Location = New System.Drawing.Point(0, 18)
        Me.lbbLargeCargo.Name = "lbbLargeCargo"
        Me.lbbLargeCargo.ReadOnly = False
        Me.lbbLargeCargo.Size = New System.Drawing.Size(184, 18)
        Me.lbbLargeCargo.TabIndex = 14
        Me.lbbLargeCargo.Value = "0"
        '
        'lbbSmalCargo
        '
        Me.lbbSmalCargo.Caption = "Small Cargo"
        Me.lbbSmalCargo.CaptionWidth = 80
        Me.lbbSmalCargo.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbSmalCargo.Location = New System.Drawing.Point(0, 0)
        Me.lbbSmalCargo.Name = "lbbSmalCargo"
        Me.lbbSmalCargo.ReadOnly = False
        Me.lbbSmalCargo.Size = New System.Drawing.Size(184, 18)
        Me.lbbSmalCargo.TabIndex = 13
        Me.lbbSmalCargo.Value = "0"
        '
        'labFlotte
        '
        Me.labFlotte.BackColor = System.Drawing.Color.IndianRed
        Me.labFlotte.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.labFlotte.Dock = System.Windows.Forms.DockStyle.Top
        Me.labFlotte.ForeColor = System.Drawing.Color.White
        Me.labFlotte.Location = New System.Drawing.Point(0, 128)
        Me.labFlotte.Name = "labFlotte"
        Me.labFlotte.Size = New System.Drawing.Size(184, 16)
        Me.labFlotte.TabIndex = 3
        Me.labFlotte.Text = "Flotte"
        Me.labFlotte.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panDefense
        '
        Me.panDefense.Controls.Add(Me.lbbInterplanMissile)
        Me.panDefense.Controls.Add(Me.lbbInterceptMissile)
        Me.panDefense.Controls.Add(Me.lbbLargeShield)
        Me.panDefense.Controls.Add(Me.lbbSmallShield)
        Me.panDefense.Controls.Add(Me.lbbPlasmaCannon)
        Me.panDefense.Controls.Add(Me.lbbGaussCannon)
        Me.panDefense.Controls.Add(Me.lbbIonCannon)
        Me.panDefense.Controls.Add(Me.lbbheavyLazer)
        Me.panDefense.Controls.Add(Me.lbbSmallLazer)
        Me.panDefense.Controls.Add(Me.lbbMissileLauncher)
        Me.panDefense.Dock = System.Windows.Forms.DockStyle.Top
        Me.panDefense.Location = New System.Drawing.Point(0, 392)
        Me.panDefense.Name = "panDefense"
        Me.panDefense.Size = New System.Drawing.Size(184, 184)
        Me.panDefense.TabIndex = 6
        '
        'lbbInterplanMissile
        '
        Me.lbbInterplanMissile.Caption = "Interplan. Mis."
        Me.lbbInterplanMissile.CaptionWidth = 80
        Me.lbbInterplanMissile.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbInterplanMissile.Location = New System.Drawing.Point(0, 162)
        Me.lbbInterplanMissile.Name = "lbbInterplanMissile"
        Me.lbbInterplanMissile.ReadOnly = False
        Me.lbbInterplanMissile.Size = New System.Drawing.Size(184, 18)
        Me.lbbInterplanMissile.TabIndex = 21
        Me.lbbInterplanMissile.Value = "0"
        '
        'lbbInterceptMissile
        '
        Me.lbbInterceptMissile.Caption = "Intercept Mis."
        Me.lbbInterceptMissile.CaptionWidth = 80
        Me.lbbInterceptMissile.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbInterceptMissile.Location = New System.Drawing.Point(0, 144)
        Me.lbbInterceptMissile.Name = "lbbInterceptMissile"
        Me.lbbInterceptMissile.ReadOnly = False
        Me.lbbInterceptMissile.Size = New System.Drawing.Size(184, 18)
        Me.lbbInterceptMissile.TabIndex = 20
        Me.lbbInterceptMissile.Value = "0"
        '
        'lbbLargeShield
        '
        Me.lbbLargeShield.Caption = "Large Shield"
        Me.lbbLargeShield.CaptionWidth = 80
        Me.lbbLargeShield.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbLargeShield.Location = New System.Drawing.Point(0, 126)
        Me.lbbLargeShield.Name = "lbbLargeShield"
        Me.lbbLargeShield.ReadOnly = False
        Me.lbbLargeShield.Size = New System.Drawing.Size(184, 18)
        Me.lbbLargeShield.TabIndex = 19
        Me.lbbLargeShield.Value = "0"
        '
        'lbbSmallShield
        '
        Me.lbbSmallShield.Caption = "Small Shield"
        Me.lbbSmallShield.CaptionWidth = 80
        Me.lbbSmallShield.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbSmallShield.Location = New System.Drawing.Point(0, 108)
        Me.lbbSmallShield.Name = "lbbSmallShield"
        Me.lbbSmallShield.ReadOnly = False
        Me.lbbSmallShield.Size = New System.Drawing.Size(184, 18)
        Me.lbbSmallShield.TabIndex = 18
        Me.lbbSmallShield.Value = "0"
        '
        'lbbPlasmaCannon
        '
        Me.lbbPlasmaCannon.Caption = "Plasma Cannon"
        Me.lbbPlasmaCannon.CaptionWidth = 80
        Me.lbbPlasmaCannon.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbPlasmaCannon.Location = New System.Drawing.Point(0, 90)
        Me.lbbPlasmaCannon.Name = "lbbPlasmaCannon"
        Me.lbbPlasmaCannon.ReadOnly = False
        Me.lbbPlasmaCannon.Size = New System.Drawing.Size(184, 18)
        Me.lbbPlasmaCannon.TabIndex = 17
        Me.lbbPlasmaCannon.Value = "0"
        '
        'lbbGaussCannon
        '
        Me.lbbGaussCannon.Caption = "Gauss Cannon"
        Me.lbbGaussCannon.CaptionWidth = 80
        Me.lbbGaussCannon.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbGaussCannon.Location = New System.Drawing.Point(0, 72)
        Me.lbbGaussCannon.Name = "lbbGaussCannon"
        Me.lbbGaussCannon.ReadOnly = False
        Me.lbbGaussCannon.Size = New System.Drawing.Size(184, 18)
        Me.lbbGaussCannon.TabIndex = 16
        Me.lbbGaussCannon.Value = "0"
        '
        'lbbIonCannon
        '
        Me.lbbIonCannon.Caption = "Ion Cannon"
        Me.lbbIonCannon.CaptionWidth = 80
        Me.lbbIonCannon.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbIonCannon.Location = New System.Drawing.Point(0, 54)
        Me.lbbIonCannon.Name = "lbbIonCannon"
        Me.lbbIonCannon.ReadOnly = False
        Me.lbbIonCannon.Size = New System.Drawing.Size(184, 18)
        Me.lbbIonCannon.TabIndex = 15
        Me.lbbIonCannon.Value = "0"
        '
        'lbbheavyLazer
        '
        Me.lbbheavyLazer.Caption = "Heavy Lazer"
        Me.lbbheavyLazer.CaptionWidth = 80
        Me.lbbheavyLazer.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbheavyLazer.Location = New System.Drawing.Point(0, 36)
        Me.lbbheavyLazer.Name = "lbbheavyLazer"
        Me.lbbheavyLazer.ReadOnly = False
        Me.lbbheavyLazer.Size = New System.Drawing.Size(184, 18)
        Me.lbbheavyLazer.TabIndex = 14
        Me.lbbheavyLazer.Value = "0"
        '
        'lbbSmallLazer
        '
        Me.lbbSmallLazer.Caption = "Small Lazer"
        Me.lbbSmallLazer.CaptionWidth = 80
        Me.lbbSmallLazer.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbSmallLazer.Location = New System.Drawing.Point(0, 18)
        Me.lbbSmallLazer.Name = "lbbSmallLazer"
        Me.lbbSmallLazer.ReadOnly = False
        Me.lbbSmallLazer.Size = New System.Drawing.Size(184, 18)
        Me.lbbSmallLazer.TabIndex = 13
        Me.lbbSmallLazer.Value = "0"
        '
        'lbbMissileLauncher
        '
        Me.lbbMissileLauncher.Caption = "Missile Launcher"
        Me.lbbMissileLauncher.CaptionWidth = 80
        Me.lbbMissileLauncher.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbMissileLauncher.Location = New System.Drawing.Point(0, 0)
        Me.lbbMissileLauncher.Name = "lbbMissileLauncher"
        Me.lbbMissileLauncher.ReadOnly = False
        Me.lbbMissileLauncher.Size = New System.Drawing.Size(184, 18)
        Me.lbbMissileLauncher.TabIndex = 12
        Me.lbbMissileLauncher.Value = "0"
        '
        'labDefense
        '
        Me.labDefense.BackColor = System.Drawing.Color.IndianRed
        Me.labDefense.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.labDefense.Dock = System.Windows.Forms.DockStyle.Top
        Me.labDefense.ForeColor = System.Drawing.Color.White
        Me.labDefense.Location = New System.Drawing.Point(0, 376)
        Me.labDefense.Name = "labDefense"
        Me.labDefense.Size = New System.Drawing.Size(184, 16)
        Me.labDefense.TabIndex = 5
        Me.labDefense.Text = "Defense"
        Me.labDefense.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panBuildings
        '
        Me.panBuildings.Controls.Add(Me.lbbTerraformer)
        Me.panBuildings.Controls.Add(Me.lbbRocketSilo)
        Me.panBuildings.Controls.Add(Me.lbbResearchLab)
        Me.panBuildings.Controls.Add(Me.lbbDeuteriumTank)
        Me.panBuildings.Controls.Add(Me.lbbCrystalStorage)
        Me.panBuildings.Controls.Add(Me.lbbMetalStorage)
        Me.panBuildings.Controls.Add(Me.lbbShipyard)
        Me.panBuildings.Controls.Add(Me.lbbNaniteFactory)
        Me.panBuildings.Controls.Add(Me.lbbRoboticFactory)
        Me.panBuildings.Controls.Add(Me.lbbFusionPlant)
        Me.panBuildings.Controls.Add(Me.lbbSolarPlant)
        Me.panBuildings.Controls.Add(Me.lbbDeuthSynth)
        Me.panBuildings.Controls.Add(Me.lbbCrystalMine)
        Me.panBuildings.Controls.Add(Me.lbbMetalMine)
        Me.panBuildings.Dock = System.Windows.Forms.DockStyle.Top
        Me.panBuildings.Location = New System.Drawing.Point(0, 592)
        Me.panBuildings.Name = "panBuildings"
        Me.panBuildings.Size = New System.Drawing.Size(184, 256)
        Me.panBuildings.TabIndex = 8
        '
        'lbbTerraformer
        '
        Me.lbbTerraformer.Caption = "Terraformer"
        Me.lbbTerraformer.CaptionWidth = 80
        Me.lbbTerraformer.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbTerraformer.Location = New System.Drawing.Point(0, 234)
        Me.lbbTerraformer.Name = "lbbTerraformer"
        Me.lbbTerraformer.ReadOnly = False
        Me.lbbTerraformer.Size = New System.Drawing.Size(184, 18)
        Me.lbbTerraformer.TabIndex = 35
        Me.lbbTerraformer.Value = "0"
        '
        'lbbRocketSilo
        '
        Me.lbbRocketSilo.Caption = "Rocket Silo"
        Me.lbbRocketSilo.CaptionWidth = 80
        Me.lbbRocketSilo.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbRocketSilo.Location = New System.Drawing.Point(0, 216)
        Me.lbbRocketSilo.Name = "lbbRocketSilo"
        Me.lbbRocketSilo.ReadOnly = False
        Me.lbbRocketSilo.Size = New System.Drawing.Size(184, 18)
        Me.lbbRocketSilo.TabIndex = 34
        Me.lbbRocketSilo.Value = "0"
        '
        'lbbResearchLab
        '
        Me.lbbResearchLab.Caption = "Research Lab"
        Me.lbbResearchLab.CaptionWidth = 80
        Me.lbbResearchLab.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbResearchLab.Location = New System.Drawing.Point(0, 198)
        Me.lbbResearchLab.Name = "lbbResearchLab"
        Me.lbbResearchLab.ReadOnly = False
        Me.lbbResearchLab.Size = New System.Drawing.Size(184, 18)
        Me.lbbResearchLab.TabIndex = 33
        Me.lbbResearchLab.Value = "0"
        '
        'lbbDeuteriumTank
        '
        Me.lbbDeuteriumTank.Caption = "Deuterium Tank"
        Me.lbbDeuteriumTank.CaptionWidth = 80
        Me.lbbDeuteriumTank.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDeuteriumTank.Location = New System.Drawing.Point(0, 180)
        Me.lbbDeuteriumTank.Name = "lbbDeuteriumTank"
        Me.lbbDeuteriumTank.ReadOnly = False
        Me.lbbDeuteriumTank.Size = New System.Drawing.Size(184, 18)
        Me.lbbDeuteriumTank.TabIndex = 32
        Me.lbbDeuteriumTank.Value = "0"
        '
        'lbbCrystalStorage
        '
        Me.lbbCrystalStorage.Caption = "Crystal Storage"
        Me.lbbCrystalStorage.CaptionWidth = 80
        Me.lbbCrystalStorage.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbCrystalStorage.Location = New System.Drawing.Point(0, 162)
        Me.lbbCrystalStorage.Name = "lbbCrystalStorage"
        Me.lbbCrystalStorage.ReadOnly = False
        Me.lbbCrystalStorage.Size = New System.Drawing.Size(184, 18)
        Me.lbbCrystalStorage.TabIndex = 31
        Me.lbbCrystalStorage.Value = "0"
        '
        'lbbMetalStorage
        '
        Me.lbbMetalStorage.Caption = "Metal Storage"
        Me.lbbMetalStorage.CaptionWidth = 80
        Me.lbbMetalStorage.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbMetalStorage.Location = New System.Drawing.Point(0, 144)
        Me.lbbMetalStorage.Name = "lbbMetalStorage"
        Me.lbbMetalStorage.ReadOnly = False
        Me.lbbMetalStorage.Size = New System.Drawing.Size(184, 18)
        Me.lbbMetalStorage.TabIndex = 30
        Me.lbbMetalStorage.Value = "0"
        '
        'lbbShipyard
        '
        Me.lbbShipyard.Caption = "Shipyard"
        Me.lbbShipyard.CaptionWidth = 80
        Me.lbbShipyard.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbShipyard.Location = New System.Drawing.Point(0, 126)
        Me.lbbShipyard.Name = "lbbShipyard"
        Me.lbbShipyard.ReadOnly = False
        Me.lbbShipyard.Size = New System.Drawing.Size(184, 18)
        Me.lbbShipyard.TabIndex = 29
        Me.lbbShipyard.Value = "0"
        '
        'lbbNaniteFactory
        '
        Me.lbbNaniteFactory.Caption = "Nanite Factory"
        Me.lbbNaniteFactory.CaptionWidth = 80
        Me.lbbNaniteFactory.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbNaniteFactory.Location = New System.Drawing.Point(0, 108)
        Me.lbbNaniteFactory.Name = "lbbNaniteFactory"
        Me.lbbNaniteFactory.ReadOnly = False
        Me.lbbNaniteFactory.Size = New System.Drawing.Size(184, 18)
        Me.lbbNaniteFactory.TabIndex = 28
        Me.lbbNaniteFactory.Value = "0"
        '
        'lbbRoboticFactory
        '
        Me.lbbRoboticFactory.Caption = "Robotic Factory"
        Me.lbbRoboticFactory.CaptionWidth = 80
        Me.lbbRoboticFactory.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbRoboticFactory.Location = New System.Drawing.Point(0, 90)
        Me.lbbRoboticFactory.Name = "lbbRoboticFactory"
        Me.lbbRoboticFactory.ReadOnly = False
        Me.lbbRoboticFactory.Size = New System.Drawing.Size(184, 18)
        Me.lbbRoboticFactory.TabIndex = 27
        Me.lbbRoboticFactory.Value = "0"
        '
        'lbbFusionPlant
        '
        Me.lbbFusionPlant.Caption = "Fusion Plant"
        Me.lbbFusionPlant.CaptionWidth = 80
        Me.lbbFusionPlant.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbFusionPlant.Location = New System.Drawing.Point(0, 72)
        Me.lbbFusionPlant.Name = "lbbFusionPlant"
        Me.lbbFusionPlant.ReadOnly = False
        Me.lbbFusionPlant.Size = New System.Drawing.Size(184, 18)
        Me.lbbFusionPlant.TabIndex = 26
        Me.lbbFusionPlant.Value = "0"
        '
        'lbbSolarPlant
        '
        Me.lbbSolarPlant.Caption = "Solar Plant"
        Me.lbbSolarPlant.CaptionWidth = 80
        Me.lbbSolarPlant.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbSolarPlant.Location = New System.Drawing.Point(0, 54)
        Me.lbbSolarPlant.Name = "lbbSolarPlant"
        Me.lbbSolarPlant.ReadOnly = False
        Me.lbbSolarPlant.Size = New System.Drawing.Size(184, 18)
        Me.lbbSolarPlant.TabIndex = 25
        Me.lbbSolarPlant.Value = "0"
        '
        'lbbDeuthSynth
        '
        Me.lbbDeuthSynth.Caption = "Deuterium Synth"
        Me.lbbDeuthSynth.CaptionWidth = 80
        Me.lbbDeuthSynth.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbDeuthSynth.Location = New System.Drawing.Point(0, 36)
        Me.lbbDeuthSynth.Name = "lbbDeuthSynth"
        Me.lbbDeuthSynth.ReadOnly = False
        Me.lbbDeuthSynth.Size = New System.Drawing.Size(184, 18)
        Me.lbbDeuthSynth.TabIndex = 24
        Me.lbbDeuthSynth.Value = "0"
        '
        'lbbCrystalMine
        '
        Me.lbbCrystalMine.Caption = "Cristal Mine"
        Me.lbbCrystalMine.CaptionWidth = 80
        Me.lbbCrystalMine.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbCrystalMine.Location = New System.Drawing.Point(0, 18)
        Me.lbbCrystalMine.Name = "lbbCrystalMine"
        Me.lbbCrystalMine.ReadOnly = False
        Me.lbbCrystalMine.Size = New System.Drawing.Size(184, 18)
        Me.lbbCrystalMine.TabIndex = 23
        Me.lbbCrystalMine.Value = "0"
        '
        'lbbMetalMine
        '
        Me.lbbMetalMine.Caption = "Metal Mine"
        Me.lbbMetalMine.CaptionWidth = 80
        Me.lbbMetalMine.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbMetalMine.Location = New System.Drawing.Point(0, 0)
        Me.lbbMetalMine.Name = "lbbMetalMine"
        Me.lbbMetalMine.ReadOnly = False
        Me.lbbMetalMine.Size = New System.Drawing.Size(184, 18)
        Me.lbbMetalMine.TabIndex = 22
        Me.lbbMetalMine.Value = "0"
        '
        'lbBuildings
        '
        Me.lbBuildings.BackColor = System.Drawing.Color.IndianRed
        Me.lbBuildings.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.lbBuildings.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbBuildings.ForeColor = System.Drawing.Color.White
        Me.lbBuildings.Location = New System.Drawing.Point(0, 576)
        Me.lbBuildings.Name = "lbBuildings"
        Me.lbBuildings.Size = New System.Drawing.Size(184, 16)
        Me.lbBuildings.TabIndex = 7
        Me.lbBuildings.Text = "Buildings"
        Me.lbBuildings.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'panResearch
        '
        Me.panResearch.Controls.Add(Me.lbbIntergalResNet)
        Me.panResearch.Controls.Add(Me.lbbPlasmaTech)
        Me.panResearch.Controls.Add(Me.lbbIontech)
        Me.panResearch.Controls.Add(Me.lbbLazerTech)
        Me.panResearch.Controls.Add(Me.lbbHyperspaceEng)
        Me.panResearch.Controls.Add(Me.lbbImpulseEng)
        Me.panResearch.Controls.Add(Me.lbbCombustionEng)
        Me.panResearch.Controls.Add(Me.lbbHyperspaceTech)
        Me.panResearch.Controls.Add(Me.lbbEnergyTech)
        Me.panResearch.Controls.Add(Me.lbbArmourTech)
        Me.panResearch.Controls.Add(Me.lbbShieldingTech)
        Me.panResearch.Controls.Add(Me.lbbWeapontech)
        Me.panResearch.Controls.Add(Me.lbbComputerTech)
        Me.panResearch.Controls.Add(Me.lbbEspionageTech)
        Me.panResearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.panResearch.Location = New System.Drawing.Point(0, 864)
        Me.panResearch.Name = "panResearch"
        Me.panResearch.Size = New System.Drawing.Size(184, 256)
        Me.panResearch.TabIndex = 10
        '
        'lbbIntergalResNet
        '
        Me.lbbIntergalResNet.Caption = "Intergal Res Net"
        Me.lbbIntergalResNet.CaptionWidth = 80
        Me.lbbIntergalResNet.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbIntergalResNet.Location = New System.Drawing.Point(0, 234)
        Me.lbbIntergalResNet.Name = "lbbIntergalResNet"
        Me.lbbIntergalResNet.ReadOnly = False
        Me.lbbIntergalResNet.Size = New System.Drawing.Size(184, 18)
        Me.lbbIntergalResNet.TabIndex = 49
        Me.lbbIntergalResNet.Value = "0"
        '
        'lbbPlasmaTech
        '
        Me.lbbPlasmaTech.Caption = "Plasma Tech"
        Me.lbbPlasmaTech.CaptionWidth = 80
        Me.lbbPlasmaTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbPlasmaTech.Location = New System.Drawing.Point(0, 216)
        Me.lbbPlasmaTech.Name = "lbbPlasmaTech"
        Me.lbbPlasmaTech.ReadOnly = False
        Me.lbbPlasmaTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbPlasmaTech.TabIndex = 48
        Me.lbbPlasmaTech.Value = "0"
        '
        'lbbIontech
        '
        Me.lbbIontech.Caption = "Ion Tech"
        Me.lbbIontech.CaptionWidth = 80
        Me.lbbIontech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbIontech.Location = New System.Drawing.Point(0, 198)
        Me.lbbIontech.Name = "lbbIontech"
        Me.lbbIontech.ReadOnly = False
        Me.lbbIontech.Size = New System.Drawing.Size(184, 18)
        Me.lbbIontech.TabIndex = 47
        Me.lbbIontech.Value = "0"
        '
        'lbbLazerTech
        '
        Me.lbbLazerTech.Caption = "Lazer Tech"
        Me.lbbLazerTech.CaptionWidth = 80
        Me.lbbLazerTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbLazerTech.Location = New System.Drawing.Point(0, 180)
        Me.lbbLazerTech.Name = "lbbLazerTech"
        Me.lbbLazerTech.ReadOnly = False
        Me.lbbLazerTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbLazerTech.TabIndex = 46
        Me.lbbLazerTech.Value = "0"
        '
        'lbbHyperspaceEng
        '
        Me.lbbHyperspaceEng.Caption = "Hyperspace Eng"
        Me.lbbHyperspaceEng.CaptionWidth = 80
        Me.lbbHyperspaceEng.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbHyperspaceEng.Location = New System.Drawing.Point(0, 162)
        Me.lbbHyperspaceEng.Name = "lbbHyperspaceEng"
        Me.lbbHyperspaceEng.ReadOnly = False
        Me.lbbHyperspaceEng.Size = New System.Drawing.Size(184, 18)
        Me.lbbHyperspaceEng.TabIndex = 45
        Me.lbbHyperspaceEng.Value = "0"
        '
        'lbbImpulseEng
        '
        Me.lbbImpulseEng.Caption = "Impulse Eng"
        Me.lbbImpulseEng.CaptionWidth = 80
        Me.lbbImpulseEng.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbImpulseEng.Location = New System.Drawing.Point(0, 144)
        Me.lbbImpulseEng.Name = "lbbImpulseEng"
        Me.lbbImpulseEng.ReadOnly = False
        Me.lbbImpulseEng.Size = New System.Drawing.Size(184, 18)
        Me.lbbImpulseEng.TabIndex = 44
        Me.lbbImpulseEng.Value = "0"
        '
        'lbbCombustionEng
        '
        Me.lbbCombustionEng.Caption = "Combustion Eng"
        Me.lbbCombustionEng.CaptionWidth = 80
        Me.lbbCombustionEng.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbCombustionEng.Location = New System.Drawing.Point(0, 126)
        Me.lbbCombustionEng.Name = "lbbCombustionEng"
        Me.lbbCombustionEng.ReadOnly = False
        Me.lbbCombustionEng.Size = New System.Drawing.Size(184, 18)
        Me.lbbCombustionEng.TabIndex = 43
        Me.lbbCombustionEng.Value = "0"
        '
        'lbbHyperspaceTech
        '
        Me.lbbHyperspaceTech.Caption = "Hyperspace Tech"
        Me.lbbHyperspaceTech.CaptionWidth = 80
        Me.lbbHyperspaceTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbHyperspaceTech.Location = New System.Drawing.Point(0, 108)
        Me.lbbHyperspaceTech.Name = "lbbHyperspaceTech"
        Me.lbbHyperspaceTech.ReadOnly = False
        Me.lbbHyperspaceTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbHyperspaceTech.TabIndex = 42
        Me.lbbHyperspaceTech.Value = "0"
        '
        'lbbEnergyTech
        '
        Me.lbbEnergyTech.Caption = "Energy Tech"
        Me.lbbEnergyTech.CaptionWidth = 80
        Me.lbbEnergyTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbEnergyTech.Location = New System.Drawing.Point(0, 90)
        Me.lbbEnergyTech.Name = "lbbEnergyTech"
        Me.lbbEnergyTech.ReadOnly = False
        Me.lbbEnergyTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbEnergyTech.TabIndex = 41
        Me.lbbEnergyTech.Value = "0"
        '
        'lbbArmourTech
        '
        Me.lbbArmourTech.Caption = "Armour Tech"
        Me.lbbArmourTech.CaptionWidth = 80
        Me.lbbArmourTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbArmourTech.Location = New System.Drawing.Point(0, 72)
        Me.lbbArmourTech.Name = "lbbArmourTech"
        Me.lbbArmourTech.ReadOnly = False
        Me.lbbArmourTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbArmourTech.TabIndex = 40
        Me.lbbArmourTech.Value = "0"
        '
        'lbbShieldingTech
        '
        Me.lbbShieldingTech.Caption = "Shielding Tech"
        Me.lbbShieldingTech.CaptionWidth = 80
        Me.lbbShieldingTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbShieldingTech.Location = New System.Drawing.Point(0, 54)
        Me.lbbShieldingTech.Name = "lbbShieldingTech"
        Me.lbbShieldingTech.ReadOnly = False
        Me.lbbShieldingTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbShieldingTech.TabIndex = 39
        Me.lbbShieldingTech.Value = "0"
        '
        'lbbWeapontech
        '
        Me.lbbWeapontech.Caption = "Weapon tech"
        Me.lbbWeapontech.CaptionWidth = 80
        Me.lbbWeapontech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbWeapontech.Location = New System.Drawing.Point(0, 36)
        Me.lbbWeapontech.Name = "lbbWeapontech"
        Me.lbbWeapontech.ReadOnly = False
        Me.lbbWeapontech.Size = New System.Drawing.Size(184, 18)
        Me.lbbWeapontech.TabIndex = 38
        Me.lbbWeapontech.Value = "0"
        '
        'lbbComputerTech
        '
        Me.lbbComputerTech.Caption = "Computer Tech"
        Me.lbbComputerTech.CaptionWidth = 80
        Me.lbbComputerTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbComputerTech.Location = New System.Drawing.Point(0, 18)
        Me.lbbComputerTech.Name = "lbbComputerTech"
        Me.lbbComputerTech.ReadOnly = False
        Me.lbbComputerTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbComputerTech.TabIndex = 37
        Me.lbbComputerTech.Value = "0"
        '
        'lbbEspionageTech
        '
        Me.lbbEspionageTech.Caption = "Espionage Tech"
        Me.lbbEspionageTech.CaptionWidth = 80
        Me.lbbEspionageTech.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbbEspionageTech.Location = New System.Drawing.Point(0, 0)
        Me.lbbEspionageTech.Name = "lbbEspionageTech"
        Me.lbbEspionageTech.ReadOnly = False
        Me.lbbEspionageTech.Size = New System.Drawing.Size(184, 18)
        Me.lbbEspionageTech.TabIndex = 36
        Me.lbbEspionageTech.Value = "0"
        '
        'labResearch
        '
        Me.labResearch.BackColor = System.Drawing.Color.IndianRed
        Me.labResearch.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.labResearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.labResearch.ForeColor = System.Drawing.Color.White
        Me.labResearch.Location = New System.Drawing.Point(0, 848)
        Me.labResearch.Name = "labResearch"
        Me.labResearch.Size = New System.Drawing.Size(184, 16)
        Me.labResearch.TabIndex = 9
        Me.labResearch.Text = "Research"
        Me.labResearch.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'PlanetInfoControl
        '
        Me.AutoScroll = True
        Me.Controls.Add(Me.panResearch)
        Me.Controls.Add(Me.labResearch)
        Me.Controls.Add(Me.panBuildings)
        Me.Controls.Add(Me.lbBuildings)
        Me.Controls.Add(Me.panDefense)
        Me.Controls.Add(Me.labDefense)
        Me.Controls.Add(Me.panFlotte)
        Me.Controls.Add(Me.labFlotte)
        Me.Controls.Add(Me.panResources)
        Me.Controls.Add(Me.labResources)
        Me.Controls.Add(Me.lblNameCoords)
        Me.Name = "PlanetInfoControl"
        Me.Size = New System.Drawing.Size(184, 1120)
        Me.panResources.ResumeLayout(False)
        Me.panFlotte.ResumeLayout(False)
        Me.panDefense.ResumeLayout(False)
        Me.panBuildings.ResumeLayout(False)
        Me.panResearch.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private pPlanet As OGameObject.Planet = Nothing
    Public Property Planet() As OGameObject.Planet
        Get
            Return pPlanet
        End Get
        Set(ByVal Value As OGameObject.Planet)
            pPlanet = Value
            If pPlanet Is Nothing Then
                Expanded = False
                lblNameCoords.Text = "(No Planet Selected)"
            Else
                Expanded = True
                If Not Planet Is Nothing Then lblNameCoords.Text = Planet.Name & " - " & Planet.Coords
                If pPlanet.SpyingReports.Count > 0 Then
                    SpyData = pPlanet.SpyingReports.Item(0).GetSpyData
                End If
            End If
        End Set
    End Property
    Private pSpyData As OGameObject.spydata = Nothing
    Public Property SpyData() As OGameObject.spydata
        Get
            Return pSpyData
        End Get
        Set(ByVal Value As OGameObject.spydata)
            If Not Planet Is Nothing Then lblNameCoords.Text = Planet.Name & " - " & Planet.Coords
            pSpyData = Value
            If pSpyData Is Nothing Then
                pSpyData = New OGameObject.spydata
            Else
                lblNameCoords.Text &= vbCrLf & pSpyData.DATADATE
            End If

            With pSpyData

                'Resources
                lbbMetal.Value = .METAL
                lbbCristal.Value = .CRYSTAL
                lbbDeuterium.Value = .DEUTERIUM
                lbbEnergy.Value = .ENERGY

                'Flotte
                lbbBattleShip.Value = .BATTLE_S
                lbbBomber.Value = .BOMBER
                lbbColonyShip.Value = .COLONY_SHIP
                lbbCruiser.Value = .CRUISER
                lbbDeathStar.Value = .DEATH_STAR
                lbbDestroyer.Value = .DESTROYER
                lbbEspionageProbe.Value = .ESPIONAGE_P
                lbbHeavyFighter.Value = .HEAVY_F
                lbbLargeCargo.Value = .LARGE_CS
                lbbLightFighter.Value = .LIGHT_F
                lbbRecycler.Value = .RECYCLER
                lbbSmalCargo.Value = .SMALL_CS
                lbbSolarSat.Value = .SOLAR_S

                'Defense
                lbbGaussCannon.Value = .GAUSS_C
                lbbheavyLazer.Value = .HEAVY_L
                lbbInterceptMissile.Value = .INTERCEPT_M
                lbbInterplanMissile.Value = .INTERPLAN_M
                lbbIonCannon.Value = .ION_C
                lbbMissileLauncher.Value = .MISSILE_L
                lbbPlasmaCannon.Value = .PLASMA_C
                lbbSmallLazer.Value = .SMALL_L
                lbbSmallShield.Value = .SMALL_SD
                lbbLargeShield.Value = .LARGE_SD

                'Buildings
                lbbMetalMine.Value = .METAL_MINE
                lbbCrystalMine.Value = .CRYSTAL_MINE
                lbbDeuthSynth.Value = .DEUTERIUM_SYNTH
                lbbSolarPlant.Value = .SOLAR_PLANT
                lbbFusionPlant.Value = .FUSION_PLANT
                lbbRoboticFactory.Value = .ROBOT_FACT
                lbbNaniteFactory.Value = .NANITE
                lbbShipyard.Value = .SHIPYARD
                lbbMetalStorage.Value = .METAL_STORAGE
                lbbCrystalStorage.Value = .CRYSTAL_STORAGE
                lbbDeuteriumTank.Value = .DEUTERIUM_TANK
                lbbResearchLab.Value = .RESEARCH_LAB
                lbbRocketSilo.Value = .ROCKET_SILO
                lbbTerraformer.Value = "Non Implémenté"

                'Research
                lbbArmourTech.Value = .T_PROTECT
                lbbCombustionEng.Value = .T_COMBUS
                lbbComputerTech.Value = .T_COMPUTER
                lbbEnergyTech.Value = .T_ENERGY
                lbbEspionageTech.Value = .T_ESPIO
                lbbHyperspaceEng.Value = .T_PROPHYPER
                lbbHyperspaceTech.Value = .T_HYPER
                lbbImpulseEng.Value = .T_IMPULSE
                lbbIntergalResNet.Value = .T_INTERNETWORK
                lbbIontech.Value = .T_IONS
                lbbLazerTech.Value = .T_LAZER
                lbbPlasmaTech.Value = .T_PLASMA
                lbbShieldingTech.Value = .T_SHIELD
                lbbWeapontech.Value = .T_WEAPON
            End With
        End Set
    End Property
    Private pReadOnly As Boolean = True
    Public Property [ReadOnly]() As Boolean
        Get
            Return pReadOnly
        End Get
        Set(ByVal Value As Boolean)
            Me.SuspendLayout()
            pReadOnly = Value
            For Each c As LabelBox In panBuildings.Controls
                c.ReadOnly = Value
            Next
            For Each c As LabelBox In panDefense.Controls
                c.ReadOnly = Value
            Next
            For Each c As LabelBox In panFlotte.Controls
                c.ReadOnly = Value
            Next
            For Each c As LabelBox In panResearch.Controls
                c.ReadOnly = Value
            Next
            For Each c As LabelBox In panResources.Controls
                c.ReadOnly = Value
            Next
            Me.ResumeLayout()
        End Set
    End Property
    Private pExpanded As Boolean = False
    Public Property Expanded() As Boolean
        Get
            Return pExpanded
        End Get
        Set(ByVal Value As Boolean)
            Me.SuspendLayout()
            pExpanded = Value
            panBuildings.Visible = pExpanded
            panDefense.Visible = pExpanded
            panFlotte.Visible = pExpanded
            panResearch.Visible = pExpanded
            panResources.Visible = pExpanded
            Me.ResumeLayout()
        End Set
    End Property
#Region "Label Click Event - Expanding Panels "
    Private Sub lbBuildings_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lbBuildings.Click
        panBuildings.Visible = Not panBuildings.Visible
        ResizeControl()
    End Sub
    Private Sub labDefense_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles labDefense.Click
        panDefense.Visible = Not panDefense.Visible
        ResizeControl()
    End Sub
    Private Sub labResearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles labResearch.Click
        panResearch.Visible = Not panResearch.Visible
        ResizeControl()
    End Sub
    Private Sub labFlotte_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles labFlotte.Click
        panFlotte.Visible = Not panFlotte.Visible
        ResizeControl()
    End Sub
    Private Sub labResources_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles labResources.Click
        panResources.Visible = Not panResources.Visible
        ResizeControl()
    End Sub
#End Region
    Private Sub ResizeControl()
        Me.SuspendLayout()
        Me.Height = lblNameCoords.Height + labResources.Height * 5
        If panBuildings.Visible Then Me.Height += panBuildings.Height
        If panDefense.Visible Then Me.Height += panDefense.Height
        If panFlotte.Visible Then Me.Height += panFlotte.Height
        If panResearch.Visible Then Me.Height += panResearch.Height
        If panResources.Visible Then Me.Height += panResources.Height
        Me.ResumeLayout()
    End Sub

    Public Sub IntelligentExpand()
        With pSpyData
            'Y a til des resources ?
            panResources.Visible = (.METAL <> 0 Or .CRYSTAL <> 0 Or .DEUTERIUM <> 0 Or .ENERGY <> 0)

            'Y a t il une flotte ?
            panFlotte.Visible = (.BATTLE_S <> 0 Or .BOMBER <> 0 Or .COLONY_SHIP <> 0 Or .CRUISER <> 0 Or .DEATH_STAR <> 0 _
                    Or .DESTROYER <> 0 Or .ESPIONAGE_P <> 0 Or .HEAVY_F <> 0 _
                    Or .LARGE_CS <> 0 Or .LIGHT_F <> 0 Or .RECYCLER <> 0 Or .SMALL_CS <> 0 Or .SOLAR_S <> 0)
            'Y a til des defenses ?
            panDefense.Visible = .GAUSS_C <> 0 Or .HEAVY_L <> 0 Or .INTERCEPT_M <> 0 Or .INTERPLAN_M <> 0 Or .ION_C <> 0 _
                Or .MISSILE_L <> 0 Or .PLASMA_C <> 0 Or .SMALL_L <> 0 Or .SMALL_SD <> 0 Or .LARGE_SD <> 0
            '
        End With
    End Sub
    Protected Overrides Sub OnLoad(ByVal e As System.EventArgs)
        [ReadOnly] = True
        Expanded = False
        MyBase.OnLoad(e)
    End Sub

    Private Sub lblNameCoords_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lblNameCoords.Click
        Expanded = Not Expanded
    End Sub


End Class
