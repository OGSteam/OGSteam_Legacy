Imports FirebirdSql.Data.FirebirdClient
Imports System.Xml.Serialization



''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : Planet
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Objet Planète
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class Planet

    Public DataDate As DateTime = Now
    Public DataSender As String = Player.DefaultDataSender
    Private pName As String = ""
    Public Property Name() As String
        Get
            Return pName
        End Get
        Set(ByVal Value As String)
            pName = Trim(Value).Replace(vbTab, "")
        End Set
    End Property
    Public Galaxy As Integer = 0
    Public [System] As Integer = 0
    Public Num As Integer = 0
    Public Owner As Player = New Player

    Private pMoon As String = ""
    Public Property Moon() As String
        Get
            Return pMoon
        End Get
        Set(ByVal Value As String)
            pMoon = Value.Trim
        End Set
    End Property
    Public DebrisField As String = ""
    Public ID As Integer = 0

    Public Function ExportString() As String
        Return Coords & "||" & DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "||" & Name & "||" & IIf(Moon.Trim <> "", 1, 0) & "||" & Owner.Name & "||" & Owner.Alliance
    End Function
    <XmlIgnore()> Public ReadOnly Property Coords() As String
        Get
            Return Galaxy & ":" & Me.System & ":" & Me.Num
        End Get
    End Property
    Public Enum enToStringFormat
        Galaxy
        NameCoords
        CoordsName
        CoordsAllyPlayer
    End Enum
    Public Property LastActivity() As PlanetActivity
        Get
            Dim dummy As New PlanetActivity
            Return dummy
        End Get
        Set(ByVal value As PlanetActivity)

        End Set
    End Property
    <XmlIgnore()> Public ToStringFormat As enToStringFormat = enToStringFormat.Galaxy
    Public Overrides Function ToString() As String

        If ToStringFormat = enToStringFormat.CoordsName Then
            Return Me.Coords & vbTab & Me.Name
        End If
        If ToStringFormat = enToStringFormat.NameCoords Then
            Return Me.Name & "  " & Me.Coords
        End If
        If ToStringFormat = enToStringFormat.CoordsAllyPlayer Then
            Return Me.Coords & vbTab & "[" & Me.Owner.Alliance & "] " & Me.Owner.Name
        End If
        Return Num & IIf(Moon.Length > 0, "(M)", "") & vbTab & Name & "   -  " & Owner.ToString
    End Function
    Public Shared Function FromRemoteDBData(ByVal RawData As String) As Planet
        Dim data() As String = Microsoft.VisualBasic.Strings.Split(RawData, "||")
        If data.Length > 4 Then
            Dim s As String = data(0)
            Dim coo() As String = s.Split(":")
            Dim p As Planet = FromCoords(coo(0), coo(1), coo(2))
            Dim d As New System.DateTime(1970, 1, 1, 0, 0, 0, 0)
            d = d.AddSeconds(data(1))

            If p Is Nothing OrElse d > p.DataDate Then
                If p Is Nothing Then
                    p = New Planet
                    p.Galaxy = coo(0)
                    p.System = coo(1)
                    p.Num = coo(2)
                End If
                p.DataDate = d
                p.Name = data(2)
                p.Moon = IIf(data(3) = 1, "M", "")
                p.DataSender = data(6)
                If data(4).Length > 0 Then
                    Dim pla As Player = Player.FromName(Trim(data(4)))
                    If p.Owner Is Nothing OrElse p.Owner.ID = 0 Then

                        If pla Is Nothing Then
                            pla = Player.CreatePlayer(data(4), data(5))
                        End If

                        p.Owner = pla
                    Else
                        p.Owner.Alliance = data(5)
                        p.Owner.Name = data(4)

                    End If
                    p.Owner.UpdateInsertandGetID()

                End If
                p.Update()
                Return p
            End If
        End If
        Return Nothing
    End Function
    Public Shared Function FromPlanetID(ByVal PlanetID As Integer) As Planet
        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Dim fbc As New FbCommand("SELECT * FROM PLANETS WHERE " & _
                                        """ID""='" & PlanetID & "'", _
                                        OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader
            Try

                If .Read Then 'Reload
                    Dim pla As New Planet

                    pla.ID = .GetValue(.GetOrdinal("ID"))
                    Dim PlayerID As Integer
                    PlayerID = .GetValue(.GetOrdinal("PLAYERID"))
                    pla.Galaxy = .GetValue(.GetOrdinal("GALAXY"))
                    pla.System = .GetValue(.GetOrdinal("SYSTEM"))
                    pla.Num = .GetValue(.GetOrdinal("PLANETNUM"))
                    pla.Owner = Player.FromPlayerID(PlayerID)
                    If pla.Owner Is Nothing Then pla.Owner = New Player
                    pla.Moon = .GetValue(.GetOrdinal("MOON"))
                    pla.DebrisField = .GetValue(.GetOrdinal("FIELDS"))
                    pla.Name = .GetValue(.GetOrdinal("NAME"))
                    pla.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                    pla.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                    .Close()
                    fbc.Dispose()
                    Return pla
                End If
            Catch ex As Exception
                Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
                MsgBox(ex.Message & vbCrLf & ex.StackTrace)
            End Try

        End With
        fbc.Dispose()
        Return Nothing
    End Function
    Public Shared Function FromCoords(ByVal gal As Integer, ByVal System As Integer, ByVal NumPlanet As Integer) As Planet
        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Dim fbc As New FbCommand("SELECT * FROM PLANETS WHERE " & _
                                        """GALAXY""='" & gal & "' AND " & _
                                        """SYSTEM""='" & System & "' AND " & _
                                        """PLANETNUM""='" & NumPlanet & "' ", _
                                        OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader
            If .Read Then 'Reload
                Dim pla As New Planet

                pla.ID = .GetValue(.GetOrdinal("ID"))
                Dim PlayerID As Integer
                PlayerID = .GetValue(.GetOrdinal("PLAYERID"))
                pla.Galaxy = .GetValue(.GetOrdinal("GALAXY"))
                pla.System = .GetValue(.GetOrdinal("SYSTEM"))
                pla.Num = .GetValue(.GetOrdinal("PLANETNUM"))
                pla.Owner = Player.FromPlayerID(PlayerID)
                If pla.Owner Is Nothing Then pla.Owner = New Player
                pla.Moon = .GetValue(.GetOrdinal("MOON"))
                pla.DebrisField = .GetValue(.GetOrdinal("FIELDS"))
                pla.Name = .GetValue(.GetOrdinal("NAME"))
                pla.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pla.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                .Close()
                fbc.Dispose()
                Return pla
            End If
            .Close()
            fbc.Dispose()
        End With
        Return Nothing
    End Function

    Public Sub ReloadOrCreateFromCoords()
        If OGameDBEngine.Default Is Nothing Then Return

        Dim fbc As New FbCommand("SELECT * FROM PLANETS WHERE " & _
                                """GALAXY""='" & Galaxy & "' AND " & _
                                """SYSTEM""='" & Me.System & "' AND " & _
                                """PLANETNUM""='" & Num & "' ", _
                                OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader
            If .Read Then 'Reload
                ID = .GetValue(.GetOrdinal("ID"))
                Dim PlayerID As Integer
                PlayerID = .GetValue(.GetOrdinal("PLAYERID"))
                If PlayerID <> 0 Then
                    Owner = Player.FromPlayerID(PlayerID)
                End If
                Moon = .GetValue(.GetOrdinal("MOON"))
                DebrisField = .GetValue(.GetOrdinal("FIELDS"))
                Name = .GetValue(.GetOrdinal("NAME"))
                DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                DataDate = .GetValue(.GetOrdinal("DATADATE"))

            Else 'Create
                fbc.Dispose()
                fbc = New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
                fbc.ExecuteNonQuery()
                Dim fbca As New FbCommand("SELECT GEN_ID(PLANETS_ID ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
                ID = fbca.ExecuteScalar()
                fbca.Dispose()
            End If
            .Close()
        End With
        fbc.Dispose()
        Return
    End Sub
    Public Sub Update()
        If OGameDBEngine.Default Is Nothing Then Throw New Exception("Database Not Opened for update")
        Dim fbc As FbCommand = New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        If ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(PLANETS_ID ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            ID = fbca.ExecuteScalar()
            fbca.Dispose()
        End If
        fbc.Dispose()
    End Sub
    Public Function InsertString() As String
        Return "INSERT INTO PLANETS " & _
               "(NAME,GALAXY,SYSTEM,PLANETNUM,MOON,FIELDS,PLAYERID,DATASENDER,DATADATE) " & _
               "VALUES (" & _
               "        '" & Name.Replace("'", "''") & "'," & _
               "        '" & Galaxy & "'," & _
               "        '" & Me.System & "'," & _
               "        '" & Me.Num & "'," & _
               "        '" & Me.Moon & "'," & _
               "        '" & Me.DebrisField & "'," & _
               "        '" & Me.Owner.ID & "'," & _
               "        '" & Me.DataSender.Replace("'", "''") & "'," & _
               "        '" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'" & _
               ")"
    End Function
    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function
    Private p_SpyingReports As SpyReportCol = Nothing
    Public ReadOnly Property SpyingReports(Optional ByVal LIMIT As Integer = 50, Optional ByVal refresh As Boolean = False) As SpyReportCol
        Get
            Try

                If p_SpyingReports Is Nothing OrElse refresh Then
                    p_SpyingReports = New SpyReportCol
                    Dim query As String = "SELECT FIRST " & LIMIT & " ID FROM ESPIONAGES WHERE ""PLANET_ID""='" & Me.ID & "' " & _
                                          "ORDER BY DATADATE DESC "
                    Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
                    With fbc.ExecuteReader
                        While .Read
                            p_SpyingReports.Add(SpyReport.FromID(.GetInt32(0)))
                        End While
                        .Close()
                    End With
                    fbc.Dispose()
                End If

            Catch ex As Exception
                Windows.Forms.MessageBox.Show("DB Error: " & ex.Message & vbCrLf & ex.StackTrace)

            End Try
            Return p_SpyingReports
        End Get
    End Property
    Private p_AttackReports As AttackReportCol = Nothing
    Public ReadOnly Property AttackReports(Optional ByVal LIMIT As Integer = 10, Optional ByVal refresh As Boolean = False) As AttackReportCol
        Get
            If p_AttackReports Is Nothing OrElse refresh Then
                p_AttackReports = New AttackReportCol
                Dim query As String = "SELECT FIRST " & LIMIT & " ID FROM COMBATS WHERE ""ATTACKER_PLANET""='" & Me.ID & "' OR ""DEFENDER_PLANET""='" & Me.ID & "'" & _
                                      "ORDER BY ""DATADATE"" DESC"
                Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
                With fbc.ExecuteReader
                    While .Read
                        p_AttackReports.Add(AttackReport.FromID(.GetInt32(0)))
                    End While
                    .Close()
                End With
                fbc.Dispose()

            End If
            Return p_AttackReports
        End Get
    End Property
    Public Function UpdateString() As String
        Return "UPDATE PLANETS SET " & _
                    """NAME""='" & Name.Replace("'", "''") & "'," & _
                    """GALAXY""='" & Galaxy & "'," & _
                    """SYSTEM""='" & Me.System & "'," & _
                    """PLANETNUM""='" & Num & "'," & _
                    """MOON""='" & Moon & "'," & _
                    """FIELDS""='" & DebrisField & "'," & _
                    """PLAYERID""='" & Me.Owner.ID & "'," & _
                    """DATASENDER""='" & Me.DataSender & "'," & _
                    """DATADATE""='" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
                    "WHERE ""ID""='" & ID & "'"
    End Function
End Class




