Imports FirebirdSql.Data.FirebirdClient
Imports System.Text.RegularExpressions
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : Player
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Objet Joueur
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class Player
    Public ID As Integer = 0
    Private pName As String = ""
    Public Property Name() As String
        Get
            Return pName
        End Get
        Set(ByVal Value As String)
            pName = Trim(Value).Replace(vbTab, "")
        End Set
    End Property

    Private pAlliance As String = ""
    Public Property Alliance() As String
        Get
            Return pAlliance
        End Get
        Set(ByVal Value As String)
            pAlliance = Trim(Value).Replace(vbTab, "")
        End Set
    End Property
    Public ReadOnly Property HaveAlliance() As Boolean
        Get
            Return Alliance.Length > 0
        End Get
    End Property
    Public MainPlanetCoords As String = "0:0:0"
    Public Shared DefaultDataSender As String
    Public ShortInactive As Boolean = False
    Public LongInactive As Boolean = False
    Public Noob As Boolean = False
    Public Vacancy As Boolean = False
    Public Blocked As Boolean = False
    Public DataSender As String = DefaultDataSender
    Public DataDate As DateTime = Now
    Public Note As String = ""
    Public pPlanets As PlanetCol = Nothing
    Public ReadOnly Property Planets(Optional ByVal Forcerefresh As Boolean = False) As PlanetCol
        Get
            If ID = 0 Then
                pPlanets = New PlanetCol
                Return pPlanets
            End If
            If pPlanets Is Nothing OrElse Forcerefresh Then
                pPlanets = OGameDBEngine.Default.GetPlayerPlanets(ID)
            End If
            Return pPlanets
        End Get
    End Property
    Public Sub New()

    End Sub
    Public Sub New(ByVal M As Match)
        With M
            Name = M.Groups("Name").Value
            Alliance = .Groups("Alliance").Value
        End With
    End Sub
    Public Enum enToStringFormat
        AllianceName
        AllianceNameID
        AllianceNamePMID
    End Enum
    Public TOStringFormat As enToStringFormat = enToStringFormat.AllianceNameID
    Public Overrides Function ToString() As String
        Select Case TOStringFormat
            Case enToStringFormat.AllianceNameID
                Return "[ " & Alliance & " ]  " & Name & "  ( id=" & ID & ")"
            Case enToStringFormat.AllianceNamePMID
                Return "[ " & Alliance & " ]  " & Name & "  (pm:" & Me.MainPlanetCoords & ",id:" & ID & ")"
        End Select
        Return "[ " & Alliance & " ]  " & Name
    End Function
    Public Function GetLastKnownTechnologie() As spydata
        Dim sql As String = "SELECT FIRST 1 ID FROM SPYDATA WHERE PLANET_ID IN (SELECT ID FROM PLANETS WHERE PLAYERID=" & ID & ") and T_espio>0 ORDER BY DATADATE DESC"
        Dim fbc As New FbCommand(sql, OGameDBEngine.Default.DBConnection)
        Dim sd As New spydata
        If sd.FromID(fbc.ExecuteScalar()) Then
            Return sd
        End If
        Return Nothing
    End Function

    Private pAllRanks As DataTable = Nothing
    Public ReadOnly Property AllRanks() As DataTable
        Get
            If Not pAllRanks Is Nothing Then Return pAllRanks
            Dim query As String
            query = "SELECT PR.DATADATE,PR.RANK," & _
                    "P.NAME,P.ALLIANCE," & _
                    "PR.POINTS," & _
                    "PF.RANK as FlotteRank,PF.POINTS as FlottePoints," & _
                    "PS.RANK as SearchRank,PS.Points as SearchPoints " & _
                    "FROM PLAYERSRANK PR " & _
                    "LEFT JOIN PLAYERS P ON P.ID=PR.PLAYER_ID " & _
                    "LEFT JOIN PLAYERSFLOTTE PF ON (PF.PLAYER_ID=PR.PLAYER_ID AND PF.DATADATE=PR.DATADATE)" & _
                    "LEFT JOIN PLAYERSRESEARCH PS ON (PS.PLAYER_ID=PR.PLAYER_ID AND PS.DATADATE=PR.DATADATE) " & _
                    "WHERE PR.PLAYER_ID='" & Me.ID & "' " & _
                    "ORDER BY PR.DATADATE DESC"
            pAllRanks = OGameDBEngine.Default.SQLCommand(query)
            Return pAllRanks
        End Get
    End Property
    Public Shared Function FromPlayerID(ByVal PlayerID As Integer) As Player
        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Try

            Dim sql As String = "SELECT * FROM ""PLAYERS"" WHERE ""ID""='" & PlayerID & "'"
            Dim fbc As New FbCommand(sql, OGameDBEngine.Default.DBConnection)
            With fbc.ExecuteReader(System.Data.CommandBehavior.SingleRow)
                If .Read Then
                    Dim pl As New Player
                    pl.ID = .GetValue(.GetOrdinal("ID"))
                    pl.MainPlanetCoords = .GetValue(.GetOrdinal("MAINPLANETCOORDS"))
                    pl.Alliance = .GetValue(.GetOrdinal("ALLIANCE"))
                    pl.Name = .GetValue(.GetOrdinal("NAME"))
                    pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                    pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                    pl.ShortInactive = .GetValue(.GetOrdinal("SHORTINACTIVE"))
                    pl.LongInactive = .GetValue(.GetOrdinal("LONGINACTIVE"))
                    pl.Blocked = .GetValue(.GetOrdinal("BLOCKED"))
                    pl.Noob = IIf(.GetValue(.GetOrdinal("NOOB")).Equals(DBNull.Value), False, .GetValue(.GetOrdinal("NOOB")))
                    pl.Vacancy = IIf(.GetValue(.GetOrdinal("VACANCY")).Equals(DBNull.Value), False, .GetValue(.GetOrdinal("VACANCY")))
                    'pl.Vacancy = .GetValue(.GetOrdinal("VACANCY"))
                    pl.Note = IIf(.GetValue(.GetOrdinal("NOTE")).Equals(DBNull.Value), "", .GetValue(.GetOrdinal("NOTE")))
                    .Close()
                    fbc.Dispose()
                    Return pl
                End If
                .Close()
                fbc.Dispose()

            End With
        Catch ex As Exception
            ShowException(ex, "FromPlayerID")
        End Try

        Return Nothing
    End Function
    Public Shared Function FromName(ByVal PlayerName As String) As Player
        PlayerName = Trim(PlayerName)
        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Dim sql As String = "SELECT FIRST 1 * FROM ""PLAYERS"" WHERE ""NAME""='" & PlayerName & "' ORDER BY ID DESC"
        Dim fbc As New FbCommand(sql, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader(System.Data.CommandBehavior.SingleRow)
            If .Read Then
                Dim pl As New Player
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.MainPlanetCoords = .GetValue(.GetOrdinal("MAINPLANETCOORDS"))
                pl.Alliance = .GetValue(.GetOrdinal("ALLIANCE"))
                pl.Name = .GetValue(.GetOrdinal("NAME"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.ShortInactive = .GetValue(.GetOrdinal("SHORTINACTIVE"))
                pl.LongInactive = .GetValue(.GetOrdinal("LONGINACTIVE"))
                pl.Blocked = .GetValue(.GetOrdinal("BLOCKED"))
                pl.Noob = IIf(.GetValue(.GetOrdinal("NOOB")).Equals(DBNull.Value), False, .GetValue(.GetOrdinal("NOOB")))
                pl.Vacancy = IIf(.GetValue(.GetOrdinal("VACANCY")).Equals(DBNull.Value), False, .GetValue(.GetOrdinal("VACANCY")))
                pl.Note = IIf(.GetValue(.GetOrdinal("NOTE")).Equals(DBNull.Value), "", .GetValue(.GetOrdinal("NOTE")))
                .Close()
                fbc.Dispose()
                Return pl
            End If
            .Close()
            fbc.Dispose()
        End With
        Return Nothing
    End Function

    Public Function SearchIDOnNameAlliance() As Integer
        If OGameDBEngine.Default Is Nothing Then Return 0
        Dim sql As String = "SELECT * FROM ""PLAYERS"" WHERE ""NAME""='" & Name & "' AND ""ALLIANCE""='" & Alliance & "'"
        Dim fbc As New FbCommand(sql, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader(System.Data.CommandBehavior.SingleRow)
            If .Read Then
                ID = .GetValue(.GetOrdinal("ID"))
                MainPlanetCoords = .GetValue(.GetOrdinal("MAINPLANETCOORDS"))
            End If
            .Close()
        End With
        fbc.Dispose()
        Return ID
    End Function
    Public Shared Event OnCreatePlayer(ByVal Player As Player)
    Public Shared Function CreatePlayer(ByVal PName As String, ByVal PAlliance As String) As Player
        Dim p As New Player
        p.Name = PName
        p.Alliance = PAlliance
        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Dim fbc As New FbCommand(p.SQLString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        If p.ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(PLAYER_ID ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            p.ID = fbca.ExecuteScalar()
            fbca.Dispose()
        End If
        fbc.Dispose()
        RaiseEvent OnCreatePlayer(p)
        'p.UpdateInsertandGetID()
        Return p
    End Function
    Public Shared Event OnPlayerUpdate(ByVal Player As Player)
    Public Function UpdateInsertandGetID() As Integer
        If OGameDBEngine.Default Is Nothing Then Return 0
        If ID = 0 Then SearchIDOnNameAlliance()
        Dim fbc As New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        fbc.Dispose()
        'RaiseEvent OnPlayerUpdate(Me)
        Return SearchIDOnNameAlliance()

    End Function

    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function

    Private pAllRankPoints As PlayerRankCol = Nothing
    Public Function AllRankPoints() As PlayerRankCol
        If pAllRankPoints Is Nothing Then
            pAllRankPoints = PlayerRank.AllRankPoints(Me)
        End If
        Return pAllRankPoints
    End Function
    Private pRankPoints As PlayerRank = Nothing
    Public Function RankPoints() As PlayerRank
        If pRankPoints Is Nothing Then
            pRankPoints = PlayerRank.RankPoints(Me)
        End If
        Return pRankPoints
    End Function

    Private pAllRankFlotte As PlayerRankCol = Nothing
    Public Function AllRankFlotte() As PlayerRankCol
        If pAllRankFlotte Is Nothing Then
            pAllRankFlotte = PlayerRank.AllRankFlotte(Me)
        End If
        Return pAllRankFlotte
    End Function
    Private pRankFlotte As PlayerRank = Nothing
    Public Function RankFlotte() As PlayerRank
        If pRankFlotte Is Nothing Then
            pRankFlotte = PlayerRank.RankFlotte(Me)
        End If
        Return pRankFlotte
    End Function
    Private pAllRankResearch As PlayerRankCol
    Public Function AllRankResearch() As PlayerRankCol
        If pAllRankResearch Is Nothing Then
            pAllRankResearch = PlayerRank.AllRankResearch(Me)
        End If
        Return pAllRankResearch
    End Function
    Private pRankResearch As PlayerRank
    Public Function RankResearch() As PlayerRank
        If pRankResearch Is Nothing Then
            pRankResearch = PlayerRank.RankResearch(Me)
        End If
        Return pRankResearch
    End Function
    Public Function InsertString() As String
        Return "INSERT INTO PLAYERS " & _
               "(NAME,ALLIANCE,MAINPLANETCOORDS,SHORTINACTIVE,LONGINACTIVE,BLOCKED,NOOB,VACANCY,NOTE,DATASENDER,DATADATE) " & _
               "VALUES (" & _
               "        '" & Name.Replace("'", "''") & "'," & _
               "        '" & Alliance.Replace("'", "''") & "'," & _
               "        '" & MainPlanetCoords.Replace("'", "''") & "'," & _
               "        '" & IIf(ShortInactive, 1, 0) & "'," & _
               "        '" & IIf(LongInactive, 1, 0) & "'," & _
               "        '" & IIf(Blocked, 1, 0) & "'," & _
               "        '" & IIf(Noob, 1, 0) & "'," & _
               "        '" & IIf(Vacancy, 1, 0) & "'," & _
               "        '" & Note.Replace("'", "''") & "'," & _
               "        '" & Me.DataSender.Replace("'", "''") & "'," & _
               "        '" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'" & _
               ")"
    End Function
    Public Function UpdateString() As String
        Return "UPDATE PLAYERS " & _
               "SET ""NAME""='" & Name.Replace("'", "''") & "'," & _
               "    ""ALLIANCE""='" & Alliance.Replace("'", "''") & "'," & _
               "    ""MAINPLANETCOORDS""='" & MainPlanetCoords.Replace("'", "''") & "'," & _
               "    ""SHORTINACTIVE""='" & IIf(ShortInactive, 1, 0) & "'," & _
               "    ""LONGINACTIVE""='" & IIf(LongInactive, 1, 0) & "'," & _
               "    ""BLOCKED""='" & IIf(Blocked, 1, 0) & "'," & _
               "    ""NOOB""='" & IIf(Noob, 1, 0) & "'," & _
               "    ""VACANCY""='" & IIf(Vacancy, 1, 0) & "'," & _
               "    ""NOTE""='" & Note.Replace("'", "''") & "'," & _
               "    ""DATASENDER""='" & Me.DataSender.Replace("'", "''") & "'," & _
               "    ""DATADATE""='" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
               "WHERE ""ID""='" & ID & "'"
    End Function
End Class

<Serializable()> Public Class PlayerCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As Player
        Get
            Return CType(List(index), Player)
        End Get
        Set(ByVal Value As Player)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As Player) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As Player) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As Player)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As Player)
        List.Remove(value)
    End Sub 'Remove
End Class


Public Class PlayersRegex
    Public Shared DATASENDER As String = "Default"
    Public Shared Function PlayerPoints(ByVal RawDataStr As String) As System.Text.RegularExpressions.MatchCollection
        'Dim RegPat As String = "^(?<Place>\d+)\s+[+–*]\s+(?<Name>.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+" & _
        '                    "(?<Alliance>.*?)\s+(?<Points>\d+)"
        Dim regpat As String = PatternsServer.Pattern("playerstatistic_html").pattern
        '"^(?<Place>\d+)\s+[+–*]\s+(?<Name>[^\n]*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(?<Alliance>[^\n]*?)?[ \t]+(?<Points>\d+)"
        Dim mc As MatchCollection = Regex.Matches(RawDataStr, regpat, PatternsServer.Pattern("playerstatistic_html").regexoption)
        If mc.Count < 2 Then
            regpat = PatternsServer.Pattern("playerstatistic").pattern
            mc = Regex.Matches(RawDataStr, regpat, PatternsServer.Pattern("playerstatistic").regexoption)
        End If
        Return mc
    End Function

    Public Shared Function PlayerFlotte(ByVal RawDataStr As String) As System.Text.RegularExpressions.MatchCollection
        'Dim RegPat As String = "^(?<Place>\d+)\s+[+–*]\s+(?<Name>.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+" & _
        '                    "(?<Alliance>.*?)\s+(?<Points>\d+)"
        Dim regpat As String = PatternsServer.Pattern("playerstatistic").pattern
        '"^(?<Place>\d+)\s+[+–*]\s+(?<Name>[^\n]*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(?<Alliance>[^\n]*?)?[ \t]+(?<Points>\d+)"
        Dim mc As MatchCollection = Regex.Matches(RawDataStr, regpat, RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture)
        Return mc
    End Function


    Public Shared Function PlayersFromPlayerPoints(ByVal mc As MatchCollection) As Collections.Specialized.StringCollection
        Dim ret As New Collections.Specialized.StringCollection
        For Each m As Match In mc
            Dim str As String = m.Groups("Place").Value & ControlChars.Tab & "(" & m.Groups("Points").Value & ")" & ControlChars.Tab & m.Groups("Name").Value & ControlChars.Tab & " [" & m.Groups("Alliance").Value & "]"
            ret.Add(str)
        Next
        Return ret
    End Function
    Public Shared UseThisTime As DateTime = Now
    Public Shared Function PlayersFromPlayerPointsCol(ByVal mc As MatchCollection, ByVal RankType As enRankType) As PlayerRankCol
        Dim ret As New PlayerRankCol
        Dim DuplicateMessageBoxShown As Boolean = False
        Dim UnTestedDuplicateChunk As Boolean = True
        For Each m As Match In mc
            Dim p As Player = Player.FromName(m.Groups("Name").Value)
            If p Is Nothing Then p = New Player
            Dim pr As New PlayerRank
            pr.Points = m.Groups("Points").Value.Replace(".", "")
            pr.Rank = m.Groups("Place").Value
            pr.DataDate = UseThisTime
            pr.Ranktype = RankType
            If UnTestedDuplicateChunk AndAlso Not DuplicateMessageBoxShown AndAlso pr.ExistRankDateType Then

                If System.Windows.Forms.MessageBox.Show("There is already a statistic with this datadate , do you want to record new one ?", "Duplicate statistic detected", Windows.Forms.MessageBoxButtons.YesNo, Windows.Forms.MessageBoxIcon.Exclamation, Windows.Forms.MessageBoxDefaultButton.Button2) = Windows.Forms.DialogResult.No Then
                    Return Nothing

                End If
                DuplicateMessageBoxShown = True
            Else
                UnTestedDuplicateChunk = False
            End If
            p.Name = m.Groups("Name").Value
            If p.Alliance <> m.Groups("Alliance").Value And p.ID <> 0 Then

                OGameDBEngine.NewEventInformation("Le joueur " & p.Name & " change d'alliance. " & IIf(p.Alliance = "", "", "Quitte " & p.Alliance) & " rentre dans " & m.Groups("Alliance").Value, Functions.enOGSEventType.PlayerChangeAlly)
                p.Alliance = m.Groups("Alliance").Value
                p.DataSender = DATASENDER
                p.DataDate = Now
                p.Note &= "Change alliance :  Was " & IIf(p.Alliance = "", "without alliance", p.Alliance) & " became " & m.Groups("Alliance").Value & vbCrLf
                p.UpdateInsertandGetID()
            End If
            p.Alliance = m.Groups("Alliance").Value
            If p.SearchIDOnNameAlliance = 0 Then
                p.DataSender = DATASENDER
                p.UpdateInsertandGetID()
                OGameDBEngine.NewEventInformation("Nouveau Joueur detecté (stats) : " & p.Name & " [" & p.Alliance & "] rank " & pr.Rank & " (ID: " & p.ID & ")", Functions.enOGSEventType.NewPlayer)
            End If
            'ret.Add(p)
            'p.UpdateInsertandGetID()
            pr.Player = p
            pr.UpdateInsertandGetID()
            ret.Add(pr)
            'pr.
        Next
        Return ret
    End Function
    Public Shared Sub CheckKnownMainPlanetCoords(ByVal pl As Player)
        Dim coords As String = pl.MainPlanetCoords
        If coords = "" OrElse coords = "0:0:0" Then Return

        Dim sqlQuery As String = "SELECT * FROM PLAYERS WHERE MAINPLANETCOORDS='" & coords & "' and ID<>'" & pl.ID & "' ORDER BY ID ASC"
        With OGameDBEngine.Default.SQLQueryReader(sqlQuery)
            While .Read
                If .Item("ID") <> 0 Then
                    If System.Windows.Forms.MessageBox.Show(MainAppForm, "Do you want to transfert Information from " & .Item("NAME") & " to " & pl.Name, "Detection of known Main Planet Coords", Windows.Forms.MessageBoxButtons.YesNo) = Windows.Forms.DialogResult.Yes Then
                        OGameDBEngine.Default.MoveDataFromPlayerToPlayer(.Item("ID"), pl.ID)
                    End If
                End If
            End While
        End With

    End Sub
    Public Shared Sub DetectMainPlanetCoords(ByVal RAwText As String)
        Dim pattern As String = "^(?<name>[^\n]+)\s\sEnvoyer\smessage.*?\s(?<coord>[\d]+:[\d]+:[\d]+).*?$"
        Dim mc As MatchCollection = Regex.Matches(RAwText, pattern, RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture)

        If mc.Count > 0 Then
            For Each m As Match In mc
                Dim p As Player = Player.FromName(m.Groups("name").Value)
                If Not p Is Nothing Then
                    Dim coords As String = m.Groups("coord").Value
                    If p.MainPlanetCoords <> coords Then
                        OGameDBEngine.NewEventInformation("Research Page: Main coords for " & p.Name & " -> " & coords, Functions.enOGSEventType.MainPlanetDetected)
                        p.MainPlanetCoords = coords
                        p.DataDate = Now
                        p.DataSender = Player.DefaultDataSender
                        p.UpdateInsertandGetID()
                        CheckKnownMainPlanetCoords(p)
                    End If
                End If
            Next
        End If


        pattern = "^\s+(?<Month>[\d]+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)\s+(?<name>.*?)\s\[(?<coord>(?<Galaxy>[\d]+):(?<System>[\d]+):(?<PlanetNum>[\d]+))\].*?R.pondre"
        mc = Regex.Matches(RAwText, pattern, RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture)

        If mc.Count > 0 Then
            For Each m As Match In mc
                Dim p As Player = Player.FromName(m.Groups("name").Value)
                If Not p Is Nothing Then
                    Dim coords As String = m.Groups("coord").Value
                    If p.MainPlanetCoords <> coords Then
                        OGameDBEngine.NewEventInformation("Detection de coordonnées principale de " & p.Name & " -> " & coords, Functions.enOGSEventType.MainPlanetDetected)
                        p.MainPlanetCoords = coords
                        p.DataDate = Now
                        p.DataSender = Player.DefaultDataSender
                        p.UpdateInsertandGetID()
                    End If
                End If
            Next
        End If
    End Sub

End Class