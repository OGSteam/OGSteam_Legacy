Imports System.Text.RegularExpressions
Imports FirebirdSql.Data.FirebirdClient
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : spydata
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Formes numérique des données d'espionages
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class spydata
    Public Shared RegX As New SpyRegX
    Public ID As Integer
    Public PLANET_ID As Integer
    Public DATADATE As DateTime
    Public DATASENDER As String
    Public METAL As Integer
    Public CRYSTAL As Integer
    Public DEUTERIUM As Integer
    Public ENERGY As Integer
    Public MISSILE_L As Integer
    Public SMALL_L As Integer
    Public HEAVY_L As Integer
    Public ION_C As Integer
    Public GAUSS_C As Integer
    Public PLASMA_C As Integer
    Public SMALL_SD As Integer
    Public LARGE_SD As Integer
    Public SMALL_CS As Integer
    Public LARGE_CS As Integer
    Public INTERCEPT_M As Integer
    Public INTERPLAN_M As Integer
    Public LIGHT_F As Integer
    Public HEAVY_F As Integer
    Public CRUISER As Integer
    Public BATTLE_S As Integer
    Public ESPIONAGE_P As Integer
    Public COLONY_SHIP As Integer
    Public RECYCLER As Integer
    Public BOMBER As Integer
    Public SOLAR_S As Integer
    Public DESTROYER As Integer
    Public TRAQUEUR As Integer
    Public DEATH_STAR As Integer
    Public METAL_MINE As Int16
    Public CRYSTAL_MINE As Int16
    Public DEUTERIUM_SYNTH As Int16
    Public SOLAR_PLANT As Int16
    Public FUSION_PLANT As Int16
    Public ROBOT_FACT As Int16
    Public NANITE As Int16
    Public SHIPYARD As Int16
    Public METAL_STORAGE As Int16
    Public CRYSTAL_STORAGE As Int16
    Public DEUTERIUM_TANK As Int16
    Public RESEARCH_LAB As Int16
    Public ROCKET_SILO As Int16
    Public LUNAR_B As Int16
    Public PHALANGE As Int16
    Public JUMPDOOR As Int16

    Public T_ESPIO As Int16
    Public T_COMPUTER As Int16
    Public T_WEAPON As Int16
    Public T_SHIELD As Int16
    Public T_PROTECT As Int16
    Public T_ENERGY As Int16
    Public T_HYPER As Int16
    Public T_COMBUS As Int16
    Public T_IMPULSE As Int16
    Public T_PROPHYPER As Int16
    Public T_LAZER As Int16
    Public T_IONS As Int16
    Public T_PLASMA As Int16
    Public T_INTERNETWORK As Int16
    Public T_GRAVITON As Int16
    Public SPYDESTROY As Int16

#Region "Table SpyDATA"
    Public Function UpdateInsertandGetID() As Integer
        If OGameDBEngine.Default Is Nothing Then Return 0
        Try


            Dim fbc As New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
            fbc.ExecuteNonQuery()
            If ID = 0 Then
                Dim fbca As New FbCommand("SELECT GEN_ID(GEN_SPYDATA_ID,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
                ID = fbca.ExecuteScalar()
            End If
            fbc.Dispose()
            Return ID
        Catch ex As Exception
            Return 0
        End Try

    End Function

    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function
    Public Function exist() As Integer
        Dim query As String = _
          "SELECT ID " & _
          "FROM SPYDATA " & _
          "WHERE PLANET_ID='" & PLANET_ID & "' AND DATADATE='" & DATADATE.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim retval As Integer = 0
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader

            If .Read Then
                retval = .GetValue(0)
            End If
            .Close()

        End With
        fbc.Dispose()
        Return retval
    End Function
    Public Function FromPlanetDate(ByVal _PlanetID As Integer, ByVal _datadate As DateTime) As Boolean
        Dim query As String = "SELECT ID FROM SPYDATA " & _
        "WHERE ""DATADATE""='" & _datadate.ToString("yyyy-MM-dd HH:mm:ss") & "' AND " & _
               "PLANET_ID=" & _PlanetID
        Dim retval As Boolean = False
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader
            If .Read Then
                retval = FromID(.GetInt32(0))
            End If
            .Close()
        End With


        fbc.Dispose()
        Return retval
    End Function
    Public Function FromID(ByVal SpyDataID As Integer) As Boolean
        Dim query As String = _
              "SELECT * " & _
              "FROM SPYDATA " & _
              "WHERE ID='" & SpyDataID & "'"
        Dim retval As Boolean = False
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader

            If .Read Then
                'retval = .GetValue(.GetOrdinal(""))
                ID = SpyDataID
                retval = True
                DATADATE = .GetValue(.GetOrdinal("DATADATE"))
                DATASENDER = .GetValue(.GetOrdinal("DATASENDER"))
                PLANET_ID = .GetValue(.GetOrdinal("PLANET_ID"))
                METAL = .GetValue(.GetOrdinal("METAL"))
                CRYSTAL = .GetValue(.GetOrdinal("CRYSTAL"))
                DEUTERIUM = .GetValue(.GetOrdinal("DEUTERIUM"))
                ENERGY = .GetValue(.GetOrdinal("ENERGY"))
                MISSILE_L = .GetValue(.GetOrdinal("MISSILE_L"))
                SMALL_L = .GetValue(.GetOrdinal("SMALL_L"))
                HEAVY_L = .GetValue(.GetOrdinal("HEAVY_L"))
                ION_C = .GetValue(.GetOrdinal("ION_C"))
                GAUSS_C = .GetValue(.GetOrdinal("GAUSS_C"))
                PLASMA_C = .GetValue(.GetOrdinal("PLASMA_C"))
                SMALL_SD = .GetValue(.GetOrdinal("SMALL_SD"))
                LARGE_SD = .GetValue(.GetOrdinal("LARGE_SD"))
                SMALL_CS = .GetValue(.GetOrdinal("SMALL_CS"))
                LARGE_CS = .GetValue(.GetOrdinal("LARGE_CS"))
                INTERCEPT_M = .GetValue(.GetOrdinal("INTERCEPT_M"))
                INTERPLAN_M = .GetValue(.GetOrdinal("INTERPLAN_M"))
                LIGHT_F = .GetValue(.GetOrdinal("LIGHT_F"))
                HEAVY_F = .GetValue(.GetOrdinal("HEAVY_F"))
                CRUISER = .GetValue(.GetOrdinal("CRUISER"))
                BATTLE_S = .GetValue(.GetOrdinal("BATTLE_S"))
                ESPIONAGE_P = .GetValue(.GetOrdinal("ESPIONAGE_P"))
                COLONY_SHIP = .GetValue(.GetOrdinal("COLONY_SHIP"))
                RECYCLER = .GetValue(.GetOrdinal("RECYCLER"))
                BOMBER = .GetValue(.GetOrdinal("BOMBER"))
                SOLAR_S = .GetValue(.GetOrdinal("SOLAR_S"))
                DESTROYER = .GetValue(.GetOrdinal("DESTROYER"))
                TRAQUEUR = .GetValue(.GetOrdinal("TRAQUEUR"))
                DEATH_STAR = .GetValue(.GetOrdinal("DEATH_STAR"))
                METAL_MINE = .GetValue(.GetOrdinal("METAL_MINE"))
                CRYSTAL_MINE = .GetValue(.GetOrdinal("CRYSTAL_MINE"))
                DEUTERIUM_SYNTH = .GetValue(.GetOrdinal("DEUTERIUM_SYNTH"))
                SOLAR_PLANT = .GetValue(.GetOrdinal("SOLAR_PLANT"))
                FUSION_PLANT = .GetValue(.GetOrdinal("FUSION_PLANT"))
                ROBOT_FACT = .GetValue(.GetOrdinal("ROBOT_FACT"))
                NANITE = .GetValue(.GetOrdinal("NANITE"))
                SHIPYARD = .GetValue(.GetOrdinal("SHIPYARD"))
                METAL_STORAGE = .GetValue(.GetOrdinal("METAL_STORAGE"))
                CRYSTAL_STORAGE = .GetValue(.GetOrdinal("CRYSTAL_STORAGE"))
                DEUTERIUM_TANK = .GetValue(.GetOrdinal("DEUTERIUM_TANK"))
                RESEARCH_LAB = .GetValue(.GetOrdinal("RESEARCH_LAB"))
                ROCKET_SILO = .GetValue(.GetOrdinal("ROCKET_SILO"))
                LUNAR_B = .GetValue(.GetOrdinal("LUNAR_B"))
                PHALANGE = .GetValue(.GetOrdinal("PHALANGE"))
                JUMPDOOR = .GetValue(.GetOrdinal("JUMPDOOR"))
                T_ESPIO = .GetValue(.GetOrdinal("T_ESPIO"))
                T_COMPUTER = .GetValue(.GetOrdinal("T_COMPUTER"))
                T_WEAPON = .GetValue(.GetOrdinal("T_WEAPON"))
                T_SHIELD = .GetValue(.GetOrdinal("T_SHIELD"))
                T_PROTECT = .GetValue(.GetOrdinal("T_PROTECT"))
                T_ENERGY = .GetValue(.GetOrdinal("T_ENERGY"))
                T_HYPER = .GetValue(.GetOrdinal("T_HYPER"))
                T_COMBUS = .GetValue(.GetOrdinal("T_COMBUS"))
                T_IMPULSE = .GetValue(.GetOrdinal("T_IMPULSE"))
                T_PROPHYPER = .GetValue(.GetOrdinal("T_PROPHYPER"))
                T_LAZER = .GetValue(.GetOrdinal("T_LAZER"))
                T_IONS = .GetValue(.GetOrdinal("T_IONS"))
                T_PLASMA = .GetValue(.GetOrdinal("T_PLASMA"))
                T_INTERNETWORK = .GetValue(.GetOrdinal("T_INTERNETWORK"))
                T_GRAVITON = .GetValue(.GetOrdinal("T_GRAVITON"))
                SPYDESTROY = .GetValue(.GetOrdinal("SPYDESTROY"))
            End If
            .Close()

        End With
        fbc.Dispose()
        Return retval
    End Function
    Public Function InsertString() As String


        Dim query As String = "INSERT INTO SPYDATA (" & _
         "PLANET_ID,DATADATE,DATASENDER,METAL,CRYSTAL,DEUTERIUM,ENERGY,MISSILE_L,SMALL_L,HEAVY_L,ION_C,GAUSS_C," & _
         "PLASMA_C,SMALL_SD,LARGE_SD,SMALL_CS,LARGE_CS,INTERCEPT_M,INTERPLAN_M,LIGHT_F,HEAVY_F,CRUISER,BATTLE_S,ESPIONAGE_P,COLONY_SHIP," & _
         "RECYCLER,BOMBER,SOLAR_S,DESTROYER,TRAQUEUR,DEATH_STAR,METAL_MINE,CRYSTAL_MINE,DEUTERIUM_SYNTH,SOLAR_PLANT," & _
         "FUSION_PLANT, ROBOT_FACT,NANITE, SHIPYARD, METAL_STORAGE, CRYSTAL_STORAGE, DEUTERIUM_TANK, RESEARCH_LAB, ROCKET_SILO, " & _
         "LUNAR_B, PHALANGE, JUMPDOOR, " & _
         "T_ESPIO ,T_COMPUTER ,T_WEAPON ,T_SHIELD , T_PROTECT , T_ENERGY , T_HYPER , T_COMBUS , T_IMPULSE , T_PROPHYPER , T_LAZER , T_IONS ,T_PLASMA , T_INTERNETWORK , T_GRAVITON , SPYDESTROY " & _
         ") VALUES ('" & _
         PLANET_ID & " ','" & DATADATE.ToString("yyyy-MM-dd HH:mm:ss") & "','" & DATASENDER & "','" & METAL & "','" & CRYSTAL & "','" & DEUTERIUM & "','" & ENERGY & "','" & MISSILE_L & "','" & SMALL_L & "','" & HEAVY_L & "','" & ION_C & "','" & GAUSS_C & "','" & _
         PLASMA_C & "','" & SMALL_SD & "','" & LARGE_SD & "','" & SMALL_CS & "','" & LARGE_CS & "','" & INTERCEPT_M & "','" & INTERPLAN_M & "','" & LIGHT_F & "','" & HEAVY_F & "','" & CRUISER & "','" & BATTLE_S & "','" & ESPIONAGE_P & "','" & COLONY_SHIP & "','" & _
         RECYCLER & "','" & BOMBER & "','" & SOLAR_S & "','" & DESTROYER & "','" & TRAQUEUR & "','" & DEATH_STAR & "','" & METAL_MINE & "','" & CRYSTAL_MINE & "','" & DEUTERIUM_SYNTH & "','" & SOLAR_PLANT & "','" & _
         FUSION_PLANT & "','" & ROBOT_FACT & "','" & NANITE & "','" & SHIPYARD & "','" & METAL_STORAGE & "','" & CRYSTAL_STORAGE & "','" & DEUTERIUM_TANK & "','" & RESEARCH_LAB & "','" & ROCKET_SILO & "','" & _
         LUNAR_B & "','" & PHALANGE & "','" & JUMPDOOR & _
         "'," & T_ESPIO & "," & T_COMPUTER & "," & T_WEAPON & "," & T_SHIELD & "," & T_PROTECT & "," & T_ENERGY & "," & T_HYPER & "," & T_COMBUS & "," & T_IMPULSE & "," & T_PROPHYPER & "," & T_LAZER & "," & T_IONS & "," & T_PLASMA & "," & T_INTERNETWORK & "," & T_GRAVITON & "," & SPYDESTROY & _
         ")"

        Return query
    End Function
    Public Function UpdateString() As String
        Dim query As String = "UPDATE SPYDATA "

        query &= "SET PLANET_ID='" & PLANET_ID & "'" & _
         "DATADATE='" & DATADATE.ToString("yyyy-MM-dd HH:mm:ss") & "',DATASENDER='" & DATASENDER & "',METAL='" & METAL & "',CRYSTAL='" & CRYSTAL & "',DEUTERIUM='" & DEUTERIUM & "',ENERGY='" & 1 & "',MISSILE_L='" & MISSILE_L & "',SMALL_L='" & SMALL_L & "',HEAVY_L='" & HEAVY_L & "',ION_C='" & ION_C & "',GAUSS_C='" & GAUSS_C & "'," & _
         "PLASMA_C='" & PLASMA_C & "',SMALL_SD='" & SMALL_SD & "',LARGE_SD='" & LARGE_SD & "',SMALL_CS='" & SMALL_CS & "',LARGE_CS='" & LARGE_CS & "',INTERCEPT_M='" & INTERCEPT_M & "',INTERPLAN_M='" & INTERPLAN_M & "',LIGHT_F='" & LIGHT_F & "',HEAVY_F='" & HEAVY_F & "',CRUISER='" & CRUISER & "',BATTLE_S='" & BATTLE_S & "',ESPIONAGE_P='" & ESPIONAGE_P & "',COLONY_SHIP='" & COLONY_SHIP & "'," & _
         "RECYCLER='" & RECYCLER & "',BOMBER='" & BOMBER & "',SOLAR_S='" & SOLAR_S & "',DESTROYER='" & DESTROYER & "',TRAQUEUR='" & TRAQUEUR & "',DEATH_STAR='" & DEATH_STAR & "',METAL_MINE='" & METAL_MINE & "',CRYSTAL_MINE='" & CRYSTAL_MINE & "',DEUTERIUM_SYNTH='" & DEUTERIUM_SYNTH & "',SOLAR_PLANT='" & SOLAR_PLANT & "'," & _
         "FUSION_PLANT='" & FUSION_PLANT & "', ROBOT_FACT='" & ROBOT_FACT & "',NANITE='" & NANITE & "', SHIPYARD='" & SHIPYARD & "', METAL_STORAGE='" & METAL_STORAGE & "', CRYSTAL_STORAGE='" & CRYSTAL_STORAGE & "', DEUTERIUM_TANK='" & DEUTERIUM_TANK & "', RESEARCH_LAB='" & RESEARCH_LAB & "', ROCKET_SILO='" & ROCKET_SILO & "', " & _
         "LUNAR_B='" & LUNAR_B & "', PHALANGE='" & PHALANGE & "', JUMPDOOR ='" & JUMPDOOR & "', " & _
         "T_ESPIO='" & T_ESPIO & "',T_COMPUTER='" & T_COMPUTER & "',T_WEAPON='" & T_WEAPON & "',T_SHIELD='" & T_SHIELD & "',T_PROTECT='" & T_PROTECT & "',T_ENERGY='" & T_ENERGY & "',T_HYPER='" & T_HYPER & "',T_COMBUS='" & T_COMBUS & "',T_IMPULSE='" & T_IMPULSE & "',T_PROPHYPER='" & T_PROPHYPER & "',T_LAZER='" & T_LAZER & "',T_IONS='" & T_IONS & "',T_PLASMA='" & T_PLASMA & "',T_INTERNETWORK='" & T_INTERNETWORK & "',T_GRAVITON='" & T_GRAVITON & "',SPYDESTROY =" & SPYDESTROY
        Return query
    End Function
#End Region

    Public Function HaveRessources() As Boolean
        With Me
            Return (.METAL <> 0 Or .CRYSTAL <> 0 Or .DEUTERIUM <> 0 Or .ENERGY <> 0)
        End With
    End Function
    Public Function HaveFlotte() As Boolean
        With Me
            Return (.BATTLE_S <> 0 Or .BOMBER <> 0 Or .COLONY_SHIP <> 0 Or .CRUISER <> 0 Or .DEATH_STAR <> 0 _
                    Or .DESTROYER <> 0 Or .TRAQUEUR <> 0 Or .ESPIONAGE_P <> 0 Or .HEAVY_F <> 0 _
                    Or .LARGE_CS <> 0 Or .LIGHT_F <> 0 Or .RECYCLER <> 0 Or .SMALL_CS <> 0 Or .SOLAR_S <> 0)
        End With
    End Function
    Public Function HaveDefense() As Boolean
        With Me
            Return .GAUSS_C <> 0 Or .HEAVY_L <> 0 Or .INTERCEPT_M <> 0 Or .INTERPLAN_M <> 0 Or .ION_C <> 0 _
                Or .MISSILE_L <> 0 Or .PLASMA_C <> 0 Or .SMALL_L <> 0 Or .SMALL_SD <> 0 Or .LARGE_SD <> 0
        End With
    End Function
    Public Function HaveBuildings() As Boolean
        With Me
            Return .METAL_MINE <> 0 Or .CRYSTAL_MINE <> 0 Or .DEUTERIUM_SYNTH <> 0 Or .SOLAR_PLANT <> 0 Or _
                     .FUSION_PLANT <> 0 Or .ROBOT_FACT <> 0 Or .NANITE <> 0 Or .SHIPYARD <> 0 Or .METAL_STORAGE <> 0 Or _
                     .CRYSTAL_STORAGE <> 0 Or .DEUTERIUM_TANK <> 0 Or .RESEARCH_LAB <> 0 Or .ROCKET_SILO <> 0
        End With
    End Function
    Public Function HaveTechnologies() As Boolean
        With Me
            Return .T_PROTECT <> 0 Or .T_COMBUS <> 0 Or .T_COMPUTER <> 0 Or .T_ENERGY <> 0 Or _
                     .T_ESPIO <> 0 Or .T_PROPHYPER <> 0 Or .T_HYPER <> 0 Or .T_IMPULSE <> 0 Or _
                     .T_INTERNETWORK <> 0 Or .T_IONS <> 0 Or .T_LAZER <> 0 Or .T_PLASMA <> 0 Or _
                     .T_SHIELD <> 0 Or .T_WEAPON <> 0
        End With
    End Function

    Public Sub MergeData(ByVal MergedData As spydata)
        With MergedData
            If MergedData.HaveBuildings Then
                CRYSTAL_MINE = .CRYSTAL_MINE
                Me.CRYSTAL_STORAGE = .CRYSTAL_STORAGE
                Me.FUSION_PLANT = .FUSION_PLANT
                Me.DEUTERIUM_SYNTH = .DEUTERIUM_SYNTH
                Me.DEUTERIUM_TANK = .DEUTERIUM_TANK
                Me.JUMPDOOR = .JUMPDOOR
                Me.LARGE_SD = .LARGE_SD
                Me.LUNAR_B = .LUNAR_B
                Me.METAL_MINE = .METAL_MINE
                Me.METAL_STORAGE = .METAL_STORAGE
                Me.NANITE = .NANITE
                Me.PHALANGE = .PHALANGE
                Me.RESEARCH_LAB = .RESEARCH_LAB
                Me.ROBOT_FACT = .ROBOT_FACT
                Me.ROCKET_SILO = .ROCKET_SILO
                Me.SHIPYARD = .SHIPYARD
                Me.SMALL_SD = .SMALL_SD
                Me.SOLAR_PLANT = .SOLAR_PLANT
            End If

            If MergedData.HaveTechnologies Then
                T_COMBUS = .T_COMBUS
                T_COMPUTER = .T_COMPUTER
                T_ENERGY = .T_ENERGY
                T_ESPIO = .T_ESPIO
                T_GRAVITON = .T_GRAVITON
                T_HYPER = .T_HYPER
                T_IMPULSE = .T_IMPULSE
                T_INTERNETWORK = .T_INTERNETWORK
                T_IONS = .T_IONS
                T_LAZER = .T_LAZER
                T_PLASMA = .T_PLASMA
                T_PROPHYPER = .T_PROPHYPER
                T_PROTECT = .T_PROTECT
                T_SHIELD = .T_SHIELD
                T_WEAPON = .T_WEAPON
            End If
        End With


    End Sub
    Public Sub New()

    End Sub

    Public Sub New(ByVal SpyText As String)
        Analyse(SpyText)
    End Sub
    Public Sub New(ByVal SpyRep As SpyReport)
        PLANET_ID = SpyRep.Planet.ID
        DATASENDER = SpyRep.DataSender
        DATADATE = SpyRep.DataDate
        Analyse(SpyRep.RawReport)
    End Sub
    Public Function setdata(ByVal dataname As String, ByVal datavalue As String) As Boolean
        Dim retval As Boolean = True
        Select Case dataname
            Case RegX.METAL_MINE
                METAL_MINE = datavalue
            Case RegX.METAL_STORAGE
                METAL_STORAGE = datavalue
            Case RegX.CRYSTAL_MINE
                CRYSTAL_MINE = datavalue
            Case RegX.CRYSTAL_STORAGE
                CRYSTAL_STORAGE = datavalue
            Case RegX.DEUTERIUM_SYNTH
                DEUTERIUM_SYNTH = datavalue
            Case RegX.DEUTERIUM_TANK
                DEUTERIUM_TANK = datavalue
            Case RegX.FUSION_PLANT
                FUSION_PLANT = datavalue
            Case RegX.JUMPDOOR
                JUMPDOOR = datavalue
            Case RegX.LUNAR_B
                LUNAR_B = datavalue
            Case RegX.NANITE
                NANITE = datavalue
            Case RegX.PHALANGE
                PHALANGE = datavalue
            Case RegX.RESEARCH_LAB
                RESEARCH_LAB = datavalue
            Case RegX.ROBOT_FACT
                ROBOT_FACT = datavalue
            Case RegX.ROCKET_SILO
                ROCKET_SILO = datavalue
            Case RegX.SHIPYARD
                SHIPYARD = datavalue
            Case RegX.SOLAR_PLANT
                SOLAR_PLANT = datavalue
            Case RegX.T_COMBUS
                T_COMBUS = datavalue
            Case RegX.T_COMPUTER
                T_COMPUTER = datavalue
            Case RegX.T_ENERGY
                T_ENERGY = datavalue
            Case RegX.T_ESPIO
                T_ESPIO = datavalue
            Case RegX.T_GRAVITON
                T_GRAVITON = datavalue
            Case RegX.T_HYPER
                T_HYPER = datavalue
            Case RegX.T_IMPULSE
                T_IMPULSE = datavalue
            Case RegX.T_INTERNETWORK
                T_INTERNETWORK = datavalue
            Case RegX.T_IONS
                T_IONS = datavalue
            Case RegX.T_LAZER
                T_LAZER = datavalue
            Case RegX.T_PLASMA
                T_PLASMA = datavalue
            Case RegX.T_PROPHYPER
                T_PROPHYPER = datavalue
            Case RegX.T_PROTECT
                T_PROTECT = datavalue
            Case RegX.T_SHIELD
                T_SHIELD = datavalue
            Case RegX.T_WEAPON
                T_WEAPON = datavalue
            Case Else
                retval = False
        End Select

        Return retval
    End Function
    Public Overrides Function ToString() As String
        Dim retval As String = ""
        If Me.HaveRessources Then
            retval &= "Resources: Metal " & METAL & ", Crystal " & CRYSTAL & ",Deuterium " & DEUTERIUM & ", Energy " & ENERGY & vbCrLf
        End If
        If Me.HaveDefense Then
            retval &= "Defense: Miss. " & MISSILE_L & ", Laz.Leg " & SMALL_L & ", Laz.Lourd " & HEAVY_L
        End If
        Return retval
    End Function
    Public Sub reset()
        ID = 0
        METAL = 0
        CRYSTAL = 0
        DEUTERIUM = 0
        ENERGY = 0
        MISSILE_L = 0
        SMALL_L = 0
        HEAVY_L = 0
        ION_C = 0
        GAUSS_C = 0
        PLASMA_C = 0
        SMALL_SD = 0
        LARGE_SD = 0
        INTERCEPT_M = 0
        INTERPLAN_M = 0
        SMALL_CS = 0
        LARGE_CS = 0
        LIGHT_F = 0
        HEAVY_F = 0
        CRUISER = 0
        BATTLE_S = 0
        ESPIONAGE_P = 0
        COLONY_SHIP = 0
        RECYCLER = 0
        BOMBER = 0
        SOLAR_S = 0
        DESTROYER = 0
        TRAQUEUR = 0
        DEATH_STAR = 0
        METAL_MINE = 0
        CRYSTAL_MINE = 0
        DEUTERIUM_SYNTH = 0
        SOLAR_PLANT = 0
        FUSION_PLANT = 0
        ROBOT_FACT = 0
        NANITE = 0
        SHIPYARD = 0
        METAL_STORAGE = 0
        CRYSTAL_STORAGE = 0
        DEUTERIUM_TANK = 0
        RESEARCH_LAB = 0
        ROCKET_SILO = 0
        LUNAR_B = 0
        PHALANGE = 0
        JUMPDOOR = 0
        T_ESPIO = 0
        T_COMPUTER = 0
        T_WEAPON = 0
        T_SHIELD = 0
        T_PROTECT = 0
        T_ENERGY = 0
        T_HYPER = 0
        T_COMBUS = 0
        T_IMPULSE = 0
        T_PROPHYPER = 0
        T_LAZER = 0
        T_IONS = 0
        T_PLASMA = 0
        T_INTERNETWORK = 0
        T_GRAVITON = 0
        SPYDESTROY = 0
    End Sub

    Public Function TotalRecyclables() As Integer
        Dim retval As Integer = 0
        retval += SMALL_CS * 1200
        retval += LARGE_CS * 3600
        retval += LIGHT_F * 1200
        retval += HEAVY_F * 3000
        retval += CRUISER * 8100
        retval += BATTLE_S * 18000
        retval += ESPIONAGE_P * 300
        retval += COLONY_SHIP * 9000
        retval += RECYCLER * 4800
        retval += BOMBER * 22500
        retval += SOLAR_S * 600
        retval += DESTROYER * 33000
        retval += TRAQUEUR * 21000
        retval += DEATH_STAR * 2700000
        Return retval
    End Function
    Public Function RecyclerNeeded() As Integer
        Return TotalRecyclables() / 20000
    End Function
    ''' <summary>
    ''' Nombre total de ressources
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function TotalRessources() As Integer
        Return METAL + CRYSTAL + DEUTERIUM
    End Function
    ''' <summary>
    ''' Approximation du nombre de GT pour les ressources de ce RE
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function LargeCargoNeeded() As Integer
        Dim totres As Integer = 0
        ''totres = METAL / 3 + CRYSTAL / 3 + DEUTERIUM / 3
        totres = (METAL - METAL / 3) / 2 + (CRYSTAL - CRYSTAL / 3) / 3
        Return Math.Round(totres / 25000)

    End Function
    ''' <summary>
    ''' Analyse un rapport d'espionage brut et parse les différents élements
    ''' </summary>
    ''' <param name="spytext"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function Analyse(ByVal spytext As String) As Boolean
        reset()
        Try
            Dim NumbPatt As String = "\s*(?<value>[\d.]+)"
            Dim m As Match
            m = Regex.Match(spytext, RegX.METAL & NumbPatt)
            If m.Success Then
                METAL = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.CRYSTAL & NumbPatt)
            If m.Success Then
                CRYSTAL = m.Groups("value").Value.Replace(".", "").Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.DEUTERIUM & NumbPatt)
            If m.Success Then
                DEUTERIUM = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.METAL & NumbPatt)
            If m.Success Then
                METAL = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.ENERGY & NumbPatt)
            If m.Success Then
                ENERGY = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.MISSILE_L & NumbPatt)
            If m.Success Then
                MISSILE_L = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SMALL_L & NumbPatt)
            If m.Success Then
                SMALL_L = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.HEAVY_L & NumbPatt)
            If m.Success Then
                HEAVY_L = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.ION_C & NumbPatt)
            If m.Success Then
                ION_C = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.GAUSS_C & NumbPatt)
            If m.Success Then
                GAUSS_C = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.PLASMA_C & NumbPatt)
            If m.Success Then
                PLASMA_C = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SMALL_SD & NumbPatt)
            If m.Success Then
                SMALL_SD = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.LARGE_SD & NumbPatt)
            If m.Success Then
                LARGE_SD = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SMALL_CS & NumbPatt)
            If m.Success Then
                SMALL_CS = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.LARGE_CS & NumbPatt)
            If m.Success Then
                LARGE_CS = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.INTERCEPT_M & NumbPatt)
            If m.Success Then
                INTERCEPT_M = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.LIGHT_F & NumbPatt)
            If m.Success Then
                LIGHT_F = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.HEAVY_F & NumbPatt)
            If m.Success Then
                HEAVY_F = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.CRUISER & NumbPatt)
            If m.Success Then
                CRUISER = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.BATTLE_S & NumbPatt)
            If m.Success Then
                BATTLE_S = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.ESPIONAGE_P & NumbPatt)
            If m.Success Then
                ESPIONAGE_P = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.COLONY_SHIP & NumbPatt)
            If m.Success Then
                COLONY_SHIP = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.RECYCLER & NumbPatt)
            If m.Success Then
                RECYCLER = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.BOMBER & NumbPatt)
            If m.Success Then
                BOMBER = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SOLAR_S & NumbPatt)
            If m.Success Then
                SOLAR_S = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.DESTROYER & NumbPatt)
            If m.Success Then
                DESTROYER = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.TRAQUEUR & NumbPatt)
            If m.Success Then
                TRAQUEUR = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.DEATH_STAR & NumbPatt)
            If m.Success Then
                DEATH_STAR = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.METAL_MINE & NumbPatt)
            If m.Success Then
                METAL_MINE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.CRYSTAL_MINE & NumbPatt)
            If m.Success Then
                CRYSTAL_MINE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.DEUTERIUM_SYNTH & NumbPatt)
            If m.Success Then
                DEUTERIUM_SYNTH = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SOLAR_PLANT & NumbPatt)
            If m.Success Then
                SOLAR_PLANT = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.FUSION_PLANT & NumbPatt)
            If m.Success Then
                FUSION_PLANT = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.ROBOT_FACT & NumbPatt)
            If m.Success Then
                ROBOT_FACT = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.NANITE & NumbPatt)
            If m.Success Then
                NANITE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.SHIPYARD & NumbPatt)
            If m.Success Then
                SHIPYARD = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.METAL_STORAGE & NumbPatt)
            If m.Success Then
                METAL_STORAGE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.CRYSTAL_STORAGE & NumbPatt)
            If m.Success Then
                CRYSTAL_STORAGE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.DEUTERIUM_TANK & NumbPatt)
            If m.Success Then
                DEUTERIUM_TANK = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.RESEARCH_LAB & NumbPatt)
            If m.Success Then
                RESEARCH_LAB = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.ROCKET_SILO & NumbPatt)
            If m.Success Then
                ROCKET_SILO = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.LUNAR_B & NumbPatt)
            If m.Success Then
                LUNAR_B = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.PHALANGE & NumbPatt)
            If m.Success Then
                PHALANGE = m.Groups("value").Value.Replace(".", "")
            End If

            m = Regex.Match(spytext, RegX.JUMPDOOR & NumbPatt)
            If m.Success Then
                JUMPDOOR = m.Groups("value").Value.Replace(".", "")
            End If


            m = Regex.Match(spytext, RegX.T_ESPIO & NumbPatt)
            If m.Success Then
                T_ESPIO = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_COMPUTER & NumbPatt)
            If m.Success Then
                T_COMPUTER = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_WEAPON & NumbPatt)
            If m.Success Then
                T_WEAPON = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_SHIELD & NumbPatt)
            If m.Success Then
                T_SHIELD = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_PROTECT & NumbPatt)
            If m.Success Then
                T_PROTECT = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_ENERGY & NumbPatt)
            If m.Success Then
                T_ENERGY = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_HYPER & NumbPatt)
            If m.Success Then
                T_HYPER = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_COMBUS & NumbPatt)
            If m.Success Then
                T_COMBUS = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_IMPULSE & NumbPatt)
            If m.Success Then
                T_IMPULSE = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_PROPHYPER & NumbPatt)
            If m.Success Then
                T_PROPHYPER = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_LAZER & NumbPatt)
            If m.Success Then
                T_LAZER = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_IONS & NumbPatt)
            If m.Success Then
                T_IONS = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_PLASMA & NumbPatt)
            If m.Success Then
                T_PLASMA = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_INTERNETWORK & NumbPatt)
            If m.Success Then
                T_INTERNETWORK = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.T_GRAVITON & NumbPatt)
            If m.Success Then
                T_GRAVITON = m.Groups("value").Value.Replace(".", "")
            End If
            m = Regex.Match(spytext, RegX.SPYDESTROY & NumbPatt)
            If m.Success Then
                SPYDESTROY = m.Groups("value").Value.Replace(".", "")
            End If

        Catch ex As Exception
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try


    End Function
End Class
