Imports FirebirdSql.Data.FirebirdClient
Imports System.Text.RegularExpressions

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : PlayerRank
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Statistique joueur
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
''' 
Public Class PlayerRank
    Public ID As Integer = 0
    Public DataSender As String = Player.DefaultDataSender
    Public DataDate As DateTime = Now
    Private p_Player As Player
   
    Private pRankType As enRankType = enRankType.Points
    Public Property Ranktype() As enRankType
        Get
            Return pRankType
        End Get
        Set(ByVal Value As enRankType)
            pRankType = Value
        End Set
    End Property
    Public Property Player() As Player
        Get
            Return p_Player
        End Get
        Set(ByVal Value As Player)
            p_Player = Value
        End Set
    End Property

    Private p_Rank As Integer
    Public Property Rank() As Integer
        Get
            Return p_Rank
        End Get
        Set(ByVal Value As Integer)
            p_Rank = Value
        End Set
    End Property
    Protected Function TableName() As String
        Return TableFromType(Ranktype)
    End Function
    Public Function ExistRankDateType() As Boolean
        Dim retval As Boolean = False
        Dim query As String = "SELECT ID FROM " & TableFromType(Me.Ranktype) & _
                            " WHERE DATADATE='" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
                            " AND RANK='" & Rank & "'"
        Dim fbca As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        Dim u As Object = fbca.ExecuteScalar
        retval = Not u Is Nothing
        fbca.Dispose()
        Return retval
    End Function
    Protected Shared Function TableFromType(ByVal _RankType As enRankType) As String
        Select Case _RankType
            Case enRankType.Flotte
                Return "PLAYERSFLOTTE"
            Case enRankType.Points
                Return "PLAYERSRANK"
            Case enRankType.Research
                Return "PLAYERSRESEARCH"
            Case Else
                Return "prout"
        End Select

    End Function
    Protected Function GeneratorName() As String
        Select Case Ranktype
            Case enRankType.Flotte
                Return "PLAYERFLOTTE_ID"
            Case enRankType.Points
                Return "PLAYERRANK_ID"
            Case enRankType.Research
                Return "PLAYERSRESEARCH_ID"
            Case Else
                Return "prout_id"
        End Select
    End Function
    Public Shared Function FromOgspy302(ByVal playername As String, _
                                        ByVal allytag As String, _
                                        ByVal rank As String, _
                                        ByVal points As String, _
                                        ByVal typestats As String, _
                                        ByVal sendername As String, _
                                        ByVal datadate As String) As PlayerRank
        Dim p As New Player

        p.Name = playername
        p.Alliance = allytag
        If p.SearchIDOnNameAlliance = 0 Then
            p.DataSender = sendername
            p.UpdateInsertandGetID()
        End If
        Dim pr As New PlayerRank

        Select Case typestats
            Case "flotte"
                pr.pRankType = enRankType.Flotte
            Case "research"
                pr.pRankType = enRankType.Research
            Case "points"
                pr.pRankType = enRankType.Points
            Case Else
                MsgBox("Stats non reconnu: " & typestats)
        End Select
        pr.Player = p
        pr.Points = CInt(points)
        pr.Rank = CInt(rank)

        pr.DataDate = DateTime.ParseExact(datadate, "yyyy-MM-dd HH:mm:ss", Nothing)
        ' OGameDBEngine.NewEventInformation(typestats & "|" & pr.Rank & "|" & pr.Player.Name, enOGSEventType.Import_Stats)
        pr.UpdateInsertandGetID()
        Return pr
    End Function
    Public Shared Function FromOgSpyLine(ByVal DataLine() As String, ByVal typestat As enRankType) As PlayerRank
        Dim p As New Player

        p.Name = DataLine(1).Trim
        p.Alliance = DataLine(2).Trim
        If p.SearchIDOnNameAlliance = 0 Then
            p.DataSender = DataLine(5)
            p.UpdateInsertandGetID()
        End If
        Dim pr As New PlayerRank
        pr.Ranktype = typestat
        pr.Player = p
        pr.Points = DataLine(4)
        pr.Rank = DataLine(3)

        pr.DataDate = DateTime.ParseExact(DataLine(0), "yyyy-MM-dd HH:mm:ss", Nothing)
        pr.UpdateInsertandGetID()
        Return pr
    End Function
    Private p_Points As Integer
    Public Property Points() As Integer
        Get
            Return p_Points
        End Get
        Set(ByVal Value As Integer)
            p_Points = Value
        End Set
    End Property

    Public Function ExportString() As String
        Return DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "||" & enRankType.GetName(GetType(enRankType), Ranktype) & "||" & Me.Player.Name & "||" & Me.Player.Alliance & "||" & Me.Rank & "||" & Me.Points
    End Function

    Public Function UpdateInsertandGetID() As Integer
        If OGameDBEngine.Default Is Nothing Then Return 0

        Dim fbc As New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        fbc.Dispose()
        Dim fbca As New FbCommand("SELECT GEN_ID(" & GeneratorName() & " ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
        ID = fbca.ExecuteScalar()
        fbca.Dispose()

        Return ID
    End Function
    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function
    Public Function InsertString() As String
        Return "INSERT INTO " & TableName() & " " & _
               "(PLAYER_ID,RANK,POINTS,DATASENDER,DATADATE) " & _
               "VALUES (" & _
               "        '" & Me.Player.ID & "'," & _
               "        '" & Rank & "'," & _
               "        '" & Points & "'," & _
               "        '" & Me.DataSender & "'," & _
               "        '" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'" & _
               ")"
    End Function
    Public Function UpdateString() As String
        Return "UPDATE PLAYERSRANK " & _
               "SET ""RANK""='" & Rank & "'," & _
               "    ""POINTS""='" & Points & "'," & _
               "    ""PLAYER_ID""='" & Me.Player.ID & "'," & _
               "    ""DATASENDER""='" & Me.DataSender & "'," & _
               "    ""DATADATE""='" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
               "WHERE ""ID""='" & ID & "'"
    End Function

    Public Sub New()

    End Sub

    Public Shared Function FromID(ByVal AnId As Integer, ByVal RankTyp As enRankType) As PlayerRank
        Dim query As String = "SELECT * FROM " & TableFromType(RankTyp)
        query &= " WHERE ID='" & AnId & "'"
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            If .Read Then
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Points
                pl.Player = OGameObject.Player.FromPlayerID(.GetOrdinal("PLAYER_ID"))
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))
                .Close()
                fbc.Dispose()
                Return pl
            End If
            .Close()
            fbc.Dispose()

        End With
        Return Nothing
    End Function

    Public Shared Function RankFlotte(ByVal aPlayer As Player) As PlayerRank
        Dim query As String = "SELECT FIRST 1 * FROM ""PLAYERSFLOTTE"" " & _
                              "WHERE PLAYER_ID='" & aPlayer.ID & "' " & _
                              "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            If .Read Then
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Flotte
                pl.Player = aPlayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))
                .Close()
                fbc.Dispose()
                Return pl
            End If
            .Close()
            fbc.Dispose()

        End With
        Return Nothing
    End Function
    Public Shared Function AllRankFlotte(ByVal aPlayer As Player) As PlayerRankCol
        Dim query As String = "SELECT  * FROM ""PLAYERSFLOTTE"" " & _
                              "WHERE PLAYER_ID='" & aPlayer.ID & "' " & _
                              "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim retval As New PlayerRankCol
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            While .Read
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Flotte
                pl.Player = aPlayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))
                retval.Add(pl)
            End While
            .Close()
            fbc.Dispose()

        End With
        Return retval
    End Function

    Public Shared Function RankPoints(ByVal aPlayer As Player) As PlayerRank
        Dim query As String = "SELECT FIRST 1 * FROM ""PLAYERSRANK"" " & _
                              "WHERE PLAYER_ID='" & aPlayer.ID & "' " & _
                              "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            If .Read Then
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Points
                pl.Player = aPlayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))
                .Close()
                fbc.Dispose()

                Return pl
            End If
            .Close()
            fbc.Dispose()

        End With
        Return Nothing

    End Function
    Public Shared Function AllRankPoints(ByVal aplayer As Player) As PlayerRankCol
        Dim query As String = "SELECT * FROM ""PLAYERSRANK"" " & _
                                      "WHERE PLAYER_ID='" & aplayer.ID & "' " & _
                                      "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim retval As New PlayerRankCol
        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            While .Read
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Points
                pl.Player = aplayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))

                retval.Add(pl)
            End While

            .Close()
            fbc.Dispose()

        End With
        Return retval


    End Function

    Public Shared Function RankResearch(ByVal aPlayer As Player) As PlayerRank
        Dim query As String = "SELECT FIRST 1 * FROM ""PLAYERSRESEARCH"" " & _
                              "WHERE PLAYER_ID='" & aPlayer.ID & "' " & _
                              "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader()
            If .Read Then
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Points
                pl.Player = aPlayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))
                .Close()
                fbc.Dispose()

                Return pl
            End If
            .Close()
            fbc.Dispose()

        End With
        Return Nothing
    End Function
    Public Shared Function AllRankResearch(ByVal aPlayer As Player) As PlayerRankCol
        Dim query As String = "SELECT * FROM ""PLAYERSRESEARCH"" " & _
                              "WHERE PLAYER_ID='" & aPlayer.ID & "' " & _
                              "ORDER BY DATADATE DESC"
        If OGameDBEngine.Default Is Nothing Then Return Nothing

        Dim fbc As New FbCommand(query, OGameDBEngine.Default.DBConnection)
        Dim retval As New PlayerRankCol
        With fbc.ExecuteReader()
            While .Read
                Dim pl As New PlayerRank
                pl.Ranktype = enRankType.Points
                pl.Player = aPlayer
                pl.ID = .GetValue(.GetOrdinal("ID"))
                pl.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                pl.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                pl.Rank = .GetValue(.GetOrdinal("RANK"))
                pl.Points = .GetValue(.GetOrdinal("POINTS"))

                retval.Add(pl)
            End While
            .Close()
            fbc.Dispose()

        End With
        Return retval
    End Function

    Public Overrides Function ToString() As String
        Return "(" & DataDate.ToString("MM-dd HH:mm") & ") " & " Rank= " & Rank & " , Points= " & Points
    End Function

End Class


