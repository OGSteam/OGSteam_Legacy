Imports FirebirdSql.Data.FirebirdClient


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : OGameDBEngine
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Classe principale d'accès/Création à la base de données OGS
''' </summary>
''' <remarks>
''' Contient une propriété partagée pointant sur une instance d'un éventuel moteur déja lancé
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' ----------------------------------------------------------------------------
Public Class OGameDBEngine

    Public Shared Event EventInformation(ByVal message As String, ByVal EventInfo As enOGSEventType)
    Public Shared Sub NewEventInformation(ByVal message As String, ByVal EventInfo As enOGSEventType)
        RaiseEvent EventInformation(message, EventInfo)
    End Sub

#Region " Variables Partagés / Shared "
    Public Shared ServerType As Integer = 1
    Public Shared Password As String = "masterkey"
    Public Shared UserID As String = "SYSDBA"
    Public Shared DataSource As String = "localhost"
    ''' <summary>
    ''' Version d'OGS
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Shared ReadOnly Property OGSVersion() As String
        Get
            Return ConstantsVersion.OGSVersion
        End Get
    End Property

    Private Shared pdefault As OGameDBEngine = Nothing

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Propriété partagée contenant une instance d'un moteur de BD
    ''' </summary>
    ''' <value>Le moteur instancie ou nothing</value>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared ReadOnly Property [Default]() As OGameDBEngine
        Get
            Return pdefault
        End Get
    End Property
#End Region

    Public ReadOnly Property Opened() As Boolean
        Get
            Return IIf(DBConnection Is Nothing, False, DBConnection.State = ConnectionState.Open)
        End Get
    End Property

    Private pDBOGS_SchemaVersion As String
    ''' <summary>
    ''' Numéro de version du Schéma de création de la base de données OGS
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks>02/06/06 ericalens</remarks>
    Public ReadOnly Property DBOGS_SchemaVersion() As String
        Get
            Return pDBOGS_SchemaVersion
        End Get
    End Property
    ''' <summary>
    ''' Récupère une valeur dans la table de configuration
    ''' </summary>
    ''' <param name="name">Nom de l'option</param>
    ''' <returns>La valeur en base ou Nothing</returns>
    ''' <remarks></remarks>
    Public Function GetConfig(ByVal name As String) As String
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = "SELECT paramvalue FROM Config WHERE paramname='" & name & "'"
        Dim retval As String = cmd.ExecuteScalar()
        cmd.Dispose()
        Return retval
    End Function
    ''' <summary>
    ''' Met à jour ou Insère une valeur dans la table de configuration
    ''' </summary>
    ''' <param name="name">Nom de l'option</param>
    ''' <param name="value">Valeur de l'option</param>
    ''' <remarks></remarks>
    Public Sub SetConfig(ByVal name As String, ByVal value As String)
        Dim ValueExist As String = GetConfig(name)
        Dim cmd As FbCommand = DBConnection.CreateCommand
        If ValueExist Is Nothing Then
            cmd.CommandText = "INSERT INTO CONFIG (ID,paramname,paramvalue) VALUES(null,'" & name & "','" & value & "')"
        Else
            cmd.CommandText = "UPDATE CONFIG SET paramvalue='" & value & "' WHERE paramname='" & name & "'"
        End If
        cmd.ExecuteNonQuery()
        Console.WriteLine("Ecriture Option : " & name & " = '" & value & "'")
        cmd.Dispose()
    End Sub

  
    ''' <summary>
    ''' Mise à jour de la base de données si néccesaire
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Private Function CheckDBVersion() As Boolean
        Dim cmd As FbCommand = DBConnection.CreateCommand
        ''cmd.CommandText = "SELECT paramvalue FROM Config WHERE paramname='dbversion'"
        ''Dim dbversion As String = cmd.ExecuteScalar()
        Dim dbversion As String = GetConfig("dbversion")

        'Ancien format de base de donnée , on verifie "à l'ancienne"
        If dbversion Is Nothing Or dbversion = "2" Then
            'verifie si la structure de la base est a jour

            cmd.CommandText = "SELECT count(*) FROM SPYDATA"
            Try

                cmd.ExecuteScalar()
            Catch ex As Exception

                If ex.Message.IndexOf("Table unknown") > -1 Then

                    Dim tr As IO.TextReader = New IO.StreamReader(TextFileResourceStream("table_spydata.sql"))
                    Dim fbs As New FirebirdSql.Data.Isql.FbScript(tr)
                    fbs.Parse()
                    Dim fbBatch As FirebirdSql.Data.Isql.FbBatchExecution = New FirebirdSql.Data.Isql.FbBatchExecution(DBConnection)
                    For Each s As String In fbs.Results
                        fbBatch.SqlStatements.Add(s)
                    Next
                    fbBatch.Execute()
                    Console.WriteLine("Mise à jour de la base de donnée: " & Me.Universe.UniverseName & ", Ajout de la table 'SPYDATA'")
                    NewEventInformation("Altered Database " & Me.Universe.UniverseName & ", Added 'SPYDATA' Table", Functions.enOGSEventType.ProgramInformation)
                    DBConnection.Open()

                End If


            End Try

            cmd.CommandText = "SELECT count(NOOB) FROM PLAYERS"
            Try
                cmd.ExecuteScalar()
            Catch ex As FirebirdSql.Data.FirebirdClient.FbException

                If ex.Message.IndexOf("Column unknown") > -1 Then

                    Dim tr As IO.TextReader = New IO.StreamReader(TextFileResourceStream("upgradefrom060119.sql"))
                    Dim fbs As New FirebirdSql.Data.Isql.FbScript(tr)
                    fbs.Parse()
                    Dim fbBatch As FirebirdSql.Data.Isql.FbBatchExecution = New FirebirdSql.Data.Isql.FbBatchExecution(DBConnection)
                    For Each s As String In fbs.Results
                        fbBatch.SqlStatements.Add(s)
                    Next
                    fbBatch.Execute()
                    Console.WriteLine("Updated DB 'upgradefrom060119.sql' on " & Me.Universe.UniverseName)
                    NewEventInformation("Database updated 'upgradefrom060119.sql' on " & Me.Universe.UniverseName, Functions.enOGSEventType.ProgramInformation)
                    DBConnection.Open()
                End If
            End Try

            '' DB Version 3 , Ajout du traqueur
            cmd.CommandText = "SELECT count(TRAQUEUR) FROM SPYDATA"
            Try
                cmd.ExecuteScalar()
            Catch ex As FirebirdSql.Data.FirebirdClient.FbException

                If ex.Message.IndexOf("Column unknown") > -1 Then
                    If MsgBox("Voulez vous mettre à jour votre base de donnée en version 3 ?" & vbCrLf _
                            & " (Ajout du TRAQUEUR dans la table des rapports d'espionages)" & vbCrLf _
                            & " Si vous décidez de ne pas permettre cette mise à jour (pour sauvegarder vos bases par exemple ;) ), OGS pourrait planter lors de l'analyse des rapports d'espio !!" _
                            , MsgBoxStyle.YesNo, _
                            "Mise à jour de la base de donnée OGS en version 3" _
                            ) _
                            = MsgBoxResult.Yes Then
                        cmd.CommandText = "ALTER TABLE SPYDATA ADD TRAQUEUR INTEGER DEFAULT 0"
                        cmd.ExecuteNonQuery()
                        cmd.CommandText = "UPDATE SPYDATA SET TRAQUEUR=0 where TRAQUEUR is null"
                        cmd.ExecuteNonQuery()

                    Else
                        SetConfig("dbversion", "2")
                        cmd.Dispose()
                        Console.WriteLine("Mise à jour V3 de la base de donnée non effectué sur " & Me.Universe.UniverseName)
                        NewEventInformation("Mise à jour V3 de la base de donnée non effectué sur " & Me.Universe.UniverseName, Functions.enOGSEventType.ProgramInformation)
                        Exit Function
                    End If
                End If
            End Try
            'Mise à jour , premiere insertion de 'dbversion'
            SetConfig("dbversion", "3")
            dbversion = "3"
            ''cmd.CommandText = "INSERT INTO CONFIG (ID,paramname,paramvalue) VALUES(null,'dbversion','3')"
            ''cmd.ExecuteNonQuery()
            Console.WriteLine("Mise à jour de la base de donnée (Traqueur)en V3 sur " & Me.Universe.UniverseName)
            NewEventInformation("Mise à jour de la base de donnée (Traqueur) en V3 sur " & Me.Universe.UniverseName, Functions.enOGSEventType.ProgramInformation)
        End If

        If dbversion = "3" Then
            SQLScript(My.Resources.update_sql_3_to_4)
            dbversion = "4"
            SetConfig("dbversion", "4")
        Else
            MsgBox("Erreur: Numero de version de la base de donnée inconnu")
        End If
        cmd.Dispose()
        ' MsgBox("DBVersion= " & dbversion)
    End Function
    Public Universe As OGameObject.UniverseDB = Nothing
    Public WithEvents DBConnection As FbConnection = Nothing
    ''' <summary>
    ''' Ouverture de la base de données
    ''' </summary>
    ''' <returns>True si l'ouverture s'est bien passée</returns>
    ''' <remarks></remarks>
    Public Function Open() As Boolean
        If Universe Is Nothing Then Return False
        Console.WriteLine("Request database opening on '" & Me.Universe.DBFileName & "'")
        Dim FbC As New FbConnectionStringBuilder

        FbC.DataSource = DataSource
        FbC.Database = Universe.DBFileName
        FbC.ServerType = ServerType
        FbC.Password = Password
        FbC.UserID = UserID
        FbC.Charset = ConstantsVersion.DB_CHARSET

        DBConnection = New FbConnection(FbC.ToString)
        pdefault = Me
        If Not System.IO.File.Exists(FbC.Database) AndAlso FbC.ServerType = 1 Then
            'if 
            If System.Windows.Forms.MessageBox.Show("'" & System.IO.Path.GetFileNameWithoutExtension(FbC.Database) & "' not found !" & vbCrLf & "Do you want to create a new database ?", "Database not found", Windows.Forms.MessageBoxButtons.YesNo) = MsgBoxResult.Yes Then
                Console.WriteLine("Creating database  '" & Me.Universe.DBFileName & "'")
                Try
                    Console.WriteLine("Creation base de donnée: " & FbC.ToString)
                    FbConnection.CreateDatabase(FbC.ToString)
                Catch ex As Exception
                    System.Windows.Forms.MessageBox.Show("Error while creating database:" & vbCrLf & ex.Message)
                    Console.WriteLine(ex.Message)
                    Console.WriteLine(ex.StackTrace)
                    Return False
                End Try
                DBConnection.Open()
                Dim tr As IO.TextReader = New IO.StreamReader(TextFileResourceStream("dbinit.sql"))
                Dim fbs As New FirebirdSql.Data.Isql.FbScript(tr)
                fbs.Parse()
                Dim fbBatch As FirebirdSql.Data.Isql.FbBatchExecution = New FirebirdSql.Data.Isql.FbBatchExecution(DBConnection)
                For Each s As String In fbs.Results
                    fbBatch.SqlStatements.Add(s)
                Next
                fbBatch.Execute()


            End If
        End If
        Try
retry:
            DBConnection.Open()

            CheckDBVersion()


        Catch ex As FbException
            Console.WriteLine("Cannot open database :")
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
            If System.Windows.Forms.MessageBox.Show("Cannot open database. " & ex.Message & vbCrLf & " Already in use ? Retry ? ", "Database Access error", Windows.Forms.MessageBoxButtons.YesNo) = MsgBoxResult.Yes Then
                GoTo retry
            End If
            Return False
        End Try




        Return True
    End Function

#Region " Commandes SQL Brutes et Script "

    Public Function SQLQueryReader(ByVal sql As String) As FbDataReader
        If DBConnection Is Nothing Then Return Nothing
        Console.WriteLine("SQL Command: " & sql)
        Try

            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = sql
            LastFBCommand = cmd
            Return cmd.ExecuteReader()
        Catch e As Exception
            Console.WriteLine(e.Message & vbCrLf & e.StackTrace)
            Return Nothing
        End Try

    End Function
    Public LastFBCommand As FbCommand
    Public Function SQLCommand(ByVal SQL As String) As DataTable

        If DBConnection Is Nothing Then Return Nothing
        Console.WriteLine("SQL Command: " & SQL)
        Dim dt As New DataTable
        Try

            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = SQL
            LastFBCommand = cmd
            Dim fbda As New FbDataAdapter(cmd)
            'cmd.
            fbda.Fill(dt)
            fbda.Dispose()
            cmd.Dispose()

        Catch ex As Exception
            Console.WriteLine("SQL Error for" & vbCrLf & SQL)
            ShowException(ex)

        End Try
        LastFBCommand = Nothing
        Return dt
    End Function

    Public Sub SQLScript(ByVal SQLScriptString As String)
        Console.WriteLine("Executing Script on  '" & System.IO.Path.GetFileNameWithoutExtension(Me.Universe.DBFileName) & "'")
        Dim tr As IO.TextReader = New IO.StringReader(SQLScriptString)
        Dim fbs As New FirebirdSql.Data.Isql.FbScript(tr)
        fbs.Parse()
        Dim fbBatch As FirebirdSql.Data.Isql.FbBatchExecution = New FirebirdSql.Data.Isql.FbBatchExecution(DBConnection)
        For Each s As String In fbs.Results
            fbBatch.SqlStatements.Add(s)
        Next
        Try
            fbBatch.Execute(True)
        Catch ex As Exception
            ShowException(ex)
        End Try
        tr.Close()
        Try
            If DBConnection.State = ConnectionState.Closed Then DBConnection.Open()
        Catch ex As Exception
            ShowException(ex)
        End Try

    End Sub

#End Region

#Region " Commande Search "


    Public Enum enSearchType
        All
        Planet
        Player
        Alliance
        Blocked
        Inactive
    End Enum
    Public Enum enSearchOrder
        Coords
        Alliance
        Player
        Planet
    End Enum
    Public Function Search(ByVal Pattern As String, ByVal SearchType As enSearchType, ByVal orderby As enSearchOrder) As DataTable
        Pattern = Pattern.ToUpper
        Dim query As String
        query = "SELECT planet.name as planetname,planet.galaxy,planet.system,planet.planetnum," & _
                " planet.moon,player.name,player.alliance " & _
                " FROM PLANETS planet " & _
                " LEFT JOIN PLAYERS player on player.id=planet.playerid "
        Dim WHERESQL As String = "WHERE "
        Select Case SearchType
            Case enSearchType.Alliance
                WHERESQL &= "UPPER(player.alliance) like '%" & Pattern & "%'"
            Case enSearchType.Planet
                WHERESQL &= "UPPER(planet.name) like '%" & Pattern & "%'"
            Case enSearchType.Player
                WHERESQL &= "UPPER(player.name) like '%" & Pattern & "%'"
            Case enSearchType.All
                WHERESQL &= "UPPER(player.alliance) like '%" & Pattern & "%' or UPPER(planet.name) like '%" & Pattern & "%' or UPPER(player.name) like '%" & Pattern & "%'"
        End Select

        Dim ORDERSQL As String = "ORDER BY "
        Select Case orderby
            Case enSearchOrder.Alliance
                ORDERSQL &= "player.alliance ASC"
            Case enSearchOrder.Coords
                ORDERSQL &= "planet.galaxy,planet.system,planet.planetnum ASC"
            Case enSearchOrder.Planet
                ORDERSQL &= "planet.name ASC"
            Case enSearchOrder.Player
                ORDERSQL &= "player.name ASC"
        End Select


        Return SQLCommand(query & WHERESQL & ORDERSQL)
    End Function

    Public Function PlayersFromTag(ByVal TAG As String) As PlayerCol
        Dim retval As New PlayerCol
        Dim query As String = _
           "SELECT ID " & _
           "FROM PLAYERS " & _
           "WHERE upper(ALLIANCE) like '%" & TAG.Replace("'", "\'").ToUpper & "%' " & _
           "ORDER BY ALLIANCE,NAME"
        If DBConnection Is Nothing Then Return Nothing
        Try
            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = query
            With cmd.ExecuteReader
                While .Read
                    Dim pl As Player = Player.FromPlayerID(.GetInt32(.GetOrdinal("ID")))
                    If Not pl Is Nothing Then retval.Add(pl)
                End While
                .Close()
            End With
            cmd.Dispose()
        Catch ex As Exception
            ShowException(ex, "(Search Planet)")
        End Try
        Return retval
    End Function
    Public Function PlayersFromMainPlanet(ByVal MainPlanetCoords As String) As PlayerCol
        Dim retval As New PlayerCol
        Dim query As String = _
           "SELECT ID " & _
           "FROM PLAYERS " & _
           "WHERE upper(MAINPLANETCOORDS) like '%" & MainPlanetCoords.Replace("'", "\'").ToUpper & "%' " & _
           "ORDER BY NAME"
        If DBConnection Is Nothing Then Return Nothing
        Try
            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = query
            With cmd.ExecuteReader
                While .Read
                    Dim pl As Player = Player.FromPlayerID(.GetInt32(.GetOrdinal("ID")))
                    If Not pl Is Nothing Then retval.Add(pl)
                End While
                .Close()
            End With
            cmd.Dispose()
        Catch ex As Exception
            ShowException(ex, "(Search Planet)")
        End Try
        Return retval
    End Function

#End Region

#Region " Rapports d'attaques et d'espionages "


    Public Function EspionagesReport() As DataTable

        Return SQLCommand("SELECT * FROM EspionagesReport ORDER BY ""DATADATE"" DESC")
    End Function
    Public Function EspionagesReportCol(Optional ByVal limit As Integer = 0) As SpyReportCol
        Dim LimitSql As String = ""
        If limit > 0 Then
            LimitSql = " FIRST " & limit & " "
        End If
        Return New SpyReportCol(SQLCommand("SELECT " & LimitSql & "E.* FROM Espionages E ORDER BY ""DATADATE"" DESC"))
    End Function

    Public Function AttacksReport() As DataTable

        Return SQLCommand("SELECT * FROM COMBATSREPORT ORDER BY ""DATADATE"" DESC")
    End Function
    Enum enAttackReportsColSorting
        ByDateDesc
        ByDateAsc
        ByCoordsAsc
        ByCoordsDesc
    End Enum
    Public Function AttacksReportCol(Optional ByVal SortingMode As enAttackReportsColSorting = enAttackReportsColSorting.ByDateDesc) As AttackReportCol

        Dim query As String = "SELECT C.* , P.COORDS FROM COMBATS C , PLANETS P WHERE P.ID=C.DEFENDER_PLANET ORDER BY "
        Select Case SortingMode
            Case enAttackReportsColSorting.ByDateDesc
                query &= "C.DATADATE DESC"
            Case enAttackReportsColSorting.ByDateAsc
                query &= "C.DATADATE ASC"
            Case enAttackReportsColSorting.ByCoordsAsc
                query &= "COORDS ASC"
            Case enAttackReportsColSorting.ByCoordsDesc
                query &= "COORDS DESC"
        End Select
        Console.WriteLine("Sorting Attacksreport by " & SortingMode.ToString)
        Return New AttackReportCol(SQLCommand(query))
    End Function
#End Region

#Region " Statistiques Ogame / Rankings "

    Public Function ExportRankingPointsString(ByVal WhichDate As DateTime, ByVal RankingType As enRankType) As String
        If DBConnection Is Nothing Then Return Nothing
        Dim ExportData As String = ""
        Dim query As String = "SELECT * FROM "
        Select Case RankingType
            Case enRankType.Points
                query &= "RANKINGPOINTS"
            Case enRankType.Flotte
                query &= "RANKINGFLOTTE"
            Case enRankType.Research
                query &= "RANKINGRESEARCH"
            Case Else
                Throw New Exception("ExportRankingPoint: Wrong Rank Type")
        End Select
        query &= " WHERE DATADATE='" & WhichDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        With cmd.ExecuteReader
            While .Read
                If ExportData <> "" Then
                    ExportData &= "<->"
                Else
                    '$require = array("datetime", "playername", "allytag", "rank", "points", "sendername");
                    ExportData = "1=datetime,2=playername,3=allytag"
                End If

                Dim d As Date = .GetValue(.GetOrdinal("DATADATE"))
                ExportData &= d.ToString("yyyy-MM-dd HH:mm:ss") & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Name")) & "<||<"
                ExportData &= .GetValue(.GetOrdinal("Alliance")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Rank")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Points")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("DATASENDER"))
            End While
            .Close()
        End With
        cmd.Dispose()
        Return ExportData
    End Function
    Public Function ExportPlayerRankHeader(ByVal whichdate As DateTime) As String
        Return "playername=1,allytag=2,rank=3,points=4,datetime=" & whichdate.ToString("yyyy-MM-dd HH:mm:ss")
    End Function
    Public Function ExportPlayerRank(ByVal WhichDate As DateTime, ByVal RankingType As enRankType) As String
        If DBConnection Is Nothing Then Return Nothing
        Dim ExportData As String = ExportPlayerRankHeader(WhichDate)
        Dim query As String = "SELECT * FROM "
        Select Case RankingType
            Case enRankType.Points
                query &= "RANKINGPOINTS"
            Case enRankType.Flotte
                query &= "RANKINGFLOTTE"
            Case enRankType.Research
                query &= "RANKINGRESEARCH"
            Case Else
                Throw New Exception("ExportRankingPoint: Wrong Rank Type")
        End Select
        query &= " WHERE DATADATE='" & WhichDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        OGameDBEngine.NewEventInformation("Collecte des Statistiques (" & RankingType.ToString & ") de " & WhichDate.ToString("yyyy-MM-dd HH:mm:ss"), enOGSEventType.Export_Stats)
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        With cmd.ExecuteReader
            While .Read
                ExportData &= "<->"
                ExportData &= .GetValue(.GetOrdinal("Name")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Alliance")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Rank")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Points")) & "<||>"
            End While
            .Close()
        End With
        cmd.Dispose()

        Return ExportData
    End Function

    Public Function ExportAlliRankHeader(ByVal whichdate As DateTime) As String
        Return "playername=1,allytag=2,rank=3,points=4,datetime=" & whichdate.ToString("yyyy-MM-dd HH:mm:ss")
    End Function
    Public Function ExportAlliRank(ByVal WhichDate As DateTime, ByVal RankingType As enRankType) As String
        If DBConnection Is Nothing Then Return Nothing
        Dim ExportData As String = ExportAlliRankHeader(WhichDate)
        Dim query As String = "SELECT * FROM "
        Select Case RankingType
            Case enRankType.Points
                query &= "ALLIANCERANK"
            Case enRankType.Flotte
                query &= "ALLIANCEFLOTTE"
            Case enRankType.Research
                query &= "ALLIANCERESEARCH"
            Case Else
                Throw New Exception("ExportAllianceRankingPoint: Wrong Rank Type")
        End Select
        query &= " WHERE DATADATE='" & WhichDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        With cmd.ExecuteReader
            While .Read
                ExportData &= "<->"
                ExportData &= .GetValue(.GetOrdinal("Name")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Alliance")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Rank")) & "<||>"
                ExportData &= .GetValue(.GetOrdinal("Points")) & "<||>"
            End While
            .Close()
        End With
        cmd.Dispose()
        Return ExportData
    End Function


    Public Function StatisticsDate() As DataTable
        'Return SQLCommand("SELECT DISTINCT DATADATE FROM RANKINGPOINTS UNION SELECT DISTINCT DATADATE FROM RANKINGFLOTTE UNION SELECT DISTINCT DATADATE FROM RANKINGRESEARCH ORDER BY 1 DESC")
        Return SQLCommand("SELECT DISTINCT DATADATE FROM PLAYERSRANK ORDER BY DATADATE DESC")
    End Function

    Public Function AlliRankingPoints(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM ALLIANCERANK " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function
    Public Function AlliRankingFlotte(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM ALLIANCEFLOTTE " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function
    Public Function AlliRankingResearch(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM ALLIANCERESEARCH " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function

    Public Function PlayersRankingPoints(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM RANKINGPOINTS " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function
    Public Function PlayersRankingFlotte(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM RANKINGFLOTTE " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function
    Public Function PlayersRankingResearch(Optional ByVal WHERERAMETERS As String = "") As DataTable
        Return SQLCommand("SELECT * FROM RANKINGRESEARCH " & WHERERAMETERS & " ORDER BY ""Rank""")
    End Function

    Public Function DeleteAlliRank(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""ALLIANCERANK"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval
    End Function
    Public Function DeleteAlliFlotte(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""ALLIANCEFLOTTE"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval
    End Function
    Public Function DeleteAlliResearch(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""ALLIANCERESEARCH"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval
    End Function

    Public Function DeletePlayersRank(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""PLAYERSRANK"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval
    End Function
    Public Function DeletePlayersFlotte(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""PLAYERSFLOTTE"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval

    End Function
    Public Function DeletePlayersResearch(Optional ByVal WHERERAMETERS As String = "") As Integer
        Dim Query As String = "DELETE FROM ""PLAYERSRESEARCH"" "
        If WHERERAMETERS <> "" Then Query &= "WHERE " & WHERERAMETERS
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval

    End Function

    'Public Sub ImportStatsFromServer(ByVal RawData As String, ByVal StatType As SharingDB.enTypeStat)
    '    Dim lines() As String = Microsoft.VisualBasic.Split(RawData, "<|>")
    '    Dim countimport As Integer = 0
    '    Dim startannoncerank As Int16 = 0
    '    For Each line As String In lines

    '        If line.Trim.Length > 0 Then
    '            Dim data() As String = Microsoft.VisualBasic.Split(line, "||")
    '            If data.Length > 4 Then

    '                Dim p As PlayerRank = PlayerRank.FromOgSpyLine(data, StatType)
    '                If Not p Is Nothing Then
    '                    countimport = countimport + 1
    '                End If
    '                'MsgBox(p.DataDate)
    '                If countimport = 100 Then
    '                    RaiseEvent EventInformation("Statistics Imports: " & startannoncerank & " to " & p.Rank & " in " & StatType.ToString & " ", Functions.enOGSEventType.Import_Stats)
    '                    countimport = 0
    '                    startannoncerank = p.Rank + 1
    '                End If
    '            End If
    '        End If

    '    Next
    '    If countimport <> 0 Then
    '        RaiseEvent EventInformation("Statistics Imports: " & startannoncerank & " to end in " & StatType.ToString & " ", Functions.enOGSEventType.Import_Stats)
    '    End If

    'End Sub
#End Region

    Public Function FleetCommands() As DataTable
        Return SQLCommand("SELECT DATADATE,""DATA"" FROM FLEETCOMMANDS ORDER BY ""DATADATE"" DESC")
    End Function


    Public Function SearchPlayerID(ByVal PlayerName As String) As Integer
        Return -1
    End Function

    Public Function PhallangeForSystem(ByVal gal As Integer, ByVal syst As Integer) As PlanetCol
        Dim result As New PlanetCol
        Dim query As String = "SELECT DISTINCT SD.PLANET_ID,P.GALAXY,P.SYSTEM FROM SPYDATA SD " & _
            "LEFT JOIN PLANETS P on P.ID=SD.PLANET_ID " & _
            "WHERE p.galaxy=" & gal & " and (" & _
            "(P.system=" & syst & " and SD.PHALANGE>0) " & _
            " OR (sd.phalange>0 and p.system< " & syst & " and (p.system + (log(sd.phalange,2)-1)>= " & syst & ")" & _
            " OR (sd.phalange>0 and p.system> " & syst & " and (p.system - (log(sd.phalange,2)-1)<= " & syst & ")" & _
            ")"

        Return result
    End Function
    Public Function SearchPlanet(ByVal PlanetName As String) As PlanetCol
        Dim retval As New PlanetCol
        Try

            Dim Query As String = "SELECT DISTINCT ID FROM PLANETS " & _
                                  "WHERE UPPER(NAME) LIKE '%" & PlanetName.ToUpper & "%' OR " & _
                                  "      UPPER(COORDS) LIKE '%" & PlanetName.ToUpper & "%'"

            If DBConnection Is Nothing Then Return Nothing
            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = Query
            With cmd.ExecuteReader
                While .Read
                    Dim pl As Planet = Planet.FromPlanetID(.GetInt32(.GetOrdinal("ID")))
                    If Not pl Is Nothing Then retval.Add(pl)
                End While
                .Close()
            End With
            cmd.Dispose()
        Catch ex As Exception
            ShowException(ex, "(Search Planet)")
        End Try

        Return retval
    End Function
    Public Function SearchPlayers(ByVal Playername As String, Optional ByVal OnlyPlayer As Boolean = False) As PlayerCol
        Dim retval As New PlayerCol
        Try

            Dim Query As String = "SELECT DISTINCT ID FROM PLAYERS " & _
                                  "WHERE UPPER(NAME) LIKE '%" & Playername.ToUpper & "%' "
            If OnlyPlayer = False Then Query &= "OR " & _
                                  "      UPPER(ALLIANCE) LIKE '%" & Playername.ToUpper & "%' "
            Query &= " ORDER BY ALLIANCE, NAME"

            If DBConnection Is Nothing Then Return Nothing
            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = Query
            With cmd.ExecuteReader
                While .Read
                    Dim pl As Player = Player.FromPlayerID(.GetInt32(.GetOrdinal("ID")))
                    If Not pl Is Nothing Then retval.Add(pl)
                End While
                .Close()
            End With
            cmd.Dispose()
        Catch ex As Exception
            ShowException(ex, "(Search Players)")
        End Try

        Return retval
    End Function


    Public Function DBStatistic() As String
        Dim Result As String = ""
        Dim objInfo As New System.IO.FileInfo(Me.Universe.DBFileName)
        Result &= "Universe Name: " & Me.Universe.UniverseName & vbCrLf
        Result &= "DB: " & Me.Universe.DBFileName & vbCrLf
        Result &= "Size in Ko: " & Format(objInfo.Length / 1024, "#0.00") & vbCrLf
        Result &= "Last write Access: " & objInfo.LastWriteTime.ToString & vbCrLf

        Result &= vbCrLf
        Dim Query As String = "SELECT count(*) FROM PLANETS"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query
        Result &= "Total Planets: " & cmd.ExecuteScalar & vbCrLf

        cmd.CommandText = "SELECT COUNT(*) FROM PLAYERS"
        Result &= "Total Players: " & cmd.ExecuteScalar & vbCrLf

        cmd.CommandText = "SELECT COUNT(*) FROM COMBATS"
        Result &= "Total Attacks: " & cmd.ExecuteScalar & vbCrLf
        cmd.CommandText = "SELECT COUNT(*) FROM ESPIONAGES"
        Result &= "Total Espionages: " & cmd.ExecuteScalar & vbCrLf
        cmd.CommandText = "SELECT COUNT(*) FROM FLEETCOMMANDS"
        Result &= "Total FleetInfo: " & cmd.ExecuteScalar & vbCrLf

        cmd.Dispose()
        Return Result
    End Function

    Public Function GetPlayerPlanets(ByVal PlayerID As Integer) As PlanetCol
        Dim retval As New PlanetCol

        Dim Query As String = "SELECT DISTINCT ID FROM PLANETS " & _
                              "WHERE PLAYERID='" & PlayerID & "' "

        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = Query

        With cmd.ExecuteReader
            While .Read
                Dim pl As Planet = Planet.FromPlanetID(.GetInt32(.GetOrdinal("ID")))
                If Not pl Is Nothing Then retval.Add(pl)
            End While
            .Close()
        End With
        cmd.Dispose()
        Return retval
    End Function

    Public Function deleteSpyReportWithoutPlanets() As Integer
        Dim retval As Integer = 0
        Dim query As String = "DELETE FROM SPYDATA S " & _
        "WHERE ID in (select S.ID from spydata S LEFT JOIN PLANETS P on P.ID=S.planet_id WHERE playerid=0)"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        retval = cmd.ExecuteNonQuery()
        Console.WriteLine("Espionages deletion: spyings reports without attached planets " & retval & " deleted from 'SPYDATA'")
        query = "DELETE FROM ESPIONAGES S " & _
        "WHERE ID in (select S.ID from ESPIONAGES S LEFT JOIN PLANETS P on P.ID=S.planet_id WHERE playerid=0)"
        cmd.CommandText = query
        Console.WriteLine("Espionages deletion: spyings reports without attached planets " & cmd.ExecuteNonQuery() & " deleted from 'ESPIONAGES'")
        cmd.Dispose()
        Return retval
    End Function
    Public Function PurgeSpyReportSince(ByVal TheTime As DateTime) As Integer
        Dim retval As Integer = 0
        Dim query As String = "DELETE FROM ESPIONAGES WHERE DATADATE<='" & TheTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        retval = cmd.ExecuteNonQuery()
        Console.WriteLine("Espionages purge since " & TheTime.ToString & ": " & retval & " deleted from 'ESPIONAGES'")
        query = "DELETE FROM SPYDATA WHERE DATADATE<='" & TheTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        cmd.CommandText = query
        Console.WriteLine("Espionages purge since " & TheTime.ToString & ": " & cmd.ExecuteNonQuery() & " deleted from 'SPYDATA'")
        cmd.Dispose()
        Return retval

    End Function

    'Public Function PlayersWithoutData() As PlayerCol
    '    Dim query As String = _
    '       "SELECT P.ID,count(planet.id) as PlanetCount,count(pf.id) as FlotteCount,count(pr.id) as ResearcCount,count( " & _
    '       "FROM PLAYERS P " & _
    '       ""

    'End Function
    Public Function GetSpyReportSince(ByVal TheTime As DateTime, Optional ByVal OnlyAllowed As Boolean = False) As SpyReportCol
        If DBConnection Is Nothing Then Return Nothing
        Dim retval As New SpyReportCol
        Try
            Dim query As String = "SELECT ID FROM ESPIONAGES WHERE DATADATE>='" & TheTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"
            If OnlyAllowed Then query &= " AND SHAREABLE<>0"

            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = query

            With cmd.ExecuteReader
                While .Read
                    Dim report As SpyReport = SpyReport.FromID(.GetInt32(.GetOrdinal("ID")))
                    If Not report Is Nothing Then retval.Add(report)
                End While
                .Close()
            End With
            cmd.Dispose()
        Catch ex As Exception
            ShowException(ex)
        End Try

        Return retval
    End Function

    Public Function ExportFile(ByVal filename As String, Optional ByVal Galaxys As String = "123456789", Optional ByVal exportdate As String = "") As Boolean

        Dim query As String = "SELECT P.*,U.NAME AS PLAYERNAME ,U.ALLIANCE " & _
                             "FROM PLANETS P " & _
                             "LEFT JOIN PLAYERS U ON U.id=P.PLAYERID "
        Dim extraquery As String = "WHERE "
        If exportdate.Length Then
            extraquery &= " DATADATE='" & exportdate & "' "
            If Galaxys <> "123456789" Then
                extraquery &= " AND "
            End If
        End If
        If Galaxys <> "123456789" Then
            extraquery &= " ("
            If Galaxys.Length <> 1 Then
                For i As Integer = 0 To Galaxys.Length - 2
                    extraquery &= "GALAXY='" & Galaxys.Chars(i) & "' OR "
                Next
            End If
            extraquery &= "GALAXY='" & Galaxys.Chars(Galaxys.Length - 1) & "') "

        End If
        If extraquery.Length > 6 Then query &= extraquery

        query &= " ORDER BY GALAXY,SYSTEM,PLANETNUM ASC "

        Dim cmd As FbCommand = DBConnection.CreateCommand

        Try
            cmd.CommandText = query
            With cmd.ExecuteReader
                If .HasRows Then
                    Dim contentString As New Text.StringBuilder
                    Dim lastgal As Integer = 0
                    Dim lastsys As Integer = 0
                    Dim count As Integer = 0
                    While .Read
                        contentString.Append(.Item("GALAXY") & CStr(.Item("SYSTEM")).PadLeft(3, "0"))
                        contentString.Append(.Item("PLANETNUM").ToString.PadLeft(3, "0"))
                        contentString.Append(IIf(.Item("MOON") <> "" AndAlso Not .Item("MOON").Equals(DBNull.Value), "M", " "))
                        contentString.Append(.Item("NAME").ToString.PadRight(25))
                        contentString.Append(.Item("PLAYERNAME").ToString.PadRight(50))
                        contentString.Append(.Item("ALLIANCE").ToString.PadRight(20))
                        Dim d As Date = .Item("DATADATE")
                        contentString.Append(d.ToString("yyyy-MM-dd HH:mm:ss"))
                        contentString.Append(.Item("DATASENDER").ToString.PadRight(30) & vbCrLf)
                        'console.
                        If lastgal <> .Item("GALAXY") OrElse lastsys <> .Item("SYSTEM") Then
                            lastgal = .Item("GALAXY")
                            lastsys = .Item("SYSTEM")
                            count = count + 1
                            If count = 50 Then
                                count = 0
                                Console.WriteLine(vbTab & "..." & .Item("GALAXY") & ":" & .Item("SYSTEM"))
                            End If
                        End If
                    End While
                    Try
                        Dim Out As New IO.StreamWriter(filename)
                        Out.Write(contentString)
                        Out.Close()
                        Console.WriteLine("Exported Galaxy to file '" & filename & "' (" & contentString.Length & " bytes)")
                    Catch ex As Exception
                        ShowException(ex)
                    End Try
                End If

                .Close()
            End With
        Catch ex As Exception
            ShowException(ex, "(ExportFile)")
            Return False
        End Try
        cmd.Dispose()
        Return True
    End Function
    Public Event ImportedSystem(ByVal sender As Object, ByVal SystemCoords As String)
    Public Event ImportedLines(ByVal sender As Object, ByVal lines As Integer)
    Public Event ImportedResult(ByVal sender As Object, ByVal PlanetUpdated As Integer, ByVal PlanetAdded As Integer, ByVal PlayerUpdated As Integer, ByVal PlayerAdded As Integer)
    ''' <summary>
    ''' Importation d'un fichier de données sur les planètes/systèmes
    ''' </summary>
    ''' <param name="filename">Nom du fichier importé</param>
    ''' <returns></returns>
    ''' <remarks>23/05/2006 Rica</remarks>
    Public Function ImportFile2(ByVal filename As String) As Boolean

        Console.WriteLine("Importing file " & filename & " ...")
        Dim query As String = "DROP PROCEDURE IMPORT_TRANSFERT;"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        Try
            cmd.CommandText = query

            cmd.ExecuteNonQuery()
        Catch ex As Exception

        End Try

        Try
            cmd.CommandText = "DROP TABLE T_EXTERNAL;"
            cmd.ExecuteNonQuery()
        Catch ex As Exception


        End Try

        query = TextFileResource("T_EXTERNAL2.TPL.SQL").Replace("{FILE}", filename)

        cmd.CommandText = query
        cmd.ExecuteScalar()

        SQLScript(TextFileResource("PROC_IMPORT2.SQL"))

        cmd.CommandText = "SELECT * FROM IMPORT_TRANSFERT"
        cmd.CommandType = CommandType.StoredProcedure
        'cmd.ExecuteScalar()
        LastImportResult = New ImportResult
        LastImportResult.lines = 0
        LastImportResult.lastsystem = -1
        LastImportResult.updatedplanet = 0
        LastImportResult.addedplanet = 0
        LastImportResult.updatedplayer = 0
        LastImportResult.addedplayer = 0
        With cmd.ExecuteReader
            Try

                While .Read
                    LastImportResult.lines = LastImportResult.lines + 1
                    If .Item("SYSTEM") <> LastImportResult.lastsystem Then
                        LastImportResult.lastsystem = .Item("SYSTEM")
                    End If
                    If LastImportResult.lines Mod 150 = 0 Then
                        RaiseEvent ImportedSystem(Me, "150 planètes - 10 systemes")
                    End If
                    If LastImportResult.lines Mod 150 = 0 Then
                        RaiseEvent ImportedLines(Me, LastImportResult.lines)
                    End If
                    LastImportResult.updatedplanet += .Item("PLANETUPDATED")
                    LastImportResult.addedplanet += .Item("PLANETADDED")
                    LastImportResult.updatedplayer += .Item("PLAYERUPDATED")
                    LastImportResult.addedplayer += .Item("PLAYERADDED")
                End While
            Catch ex As Exception

                ShowException(ex, "Erreur lors de l'insertion des données à partir du fichier d'import")

            Finally
                .Close()
            End Try
        End With
        cmd.Dispose()
        With LastImportResult
            RaiseEvent ImportedResult(Me, .updatedplanet, .addedplanet, .updatedplayer, .addedplayer)
        End With
        Console.WriteLine("Fichier importé : " & LastImportResult.lines & " lines.")
        query = "DROP PROCEDURE IMPORT_TRANSFERT;"
        cmd = DBConnection.CreateCommand
        Try
            cmd.CommandText = query
            cmd.ExecuteNonQuery()
        Catch ex As Exception
            ShowException(ex, "Suppression de la procedure IMPORT_TRANSFERTS")
        End Try

        Try
            cmd.CommandText = "DROP TABLE T_EXTERNAL;"
            cmd.ExecuteNonQuery()
        Catch ex As Exception
            ShowException(ex, "Droping table T_EXTERNAL")
        End Try

        cmd.Dispose()
    End Function
    Public LastImportResult As ImportResult
    Structure ImportResult
        Dim lines As Integer
        Dim lastsystem As Integer
        Dim updatedplanet As Integer
        Dim addedplanet As Integer
        Dim updatedplayer As Integer
        Dim addedplayer As Integer
        Public Overrides Function ToString() As String
            Return lines & " lignes, " & addedplanet & " planètes ajoutés, " & _
                   updatedplanet & " planètes mises à jour, " & addedplayer & " joueurs ajoutés, " & _
                   updatedplayer & " joueurs mis à jour"
        End Function
    End Structure
    Public Function ImportFile(ByVal filename As String) As Boolean

        Console.WriteLine("Importing file " & filename & " ...")
        Dim query As String = "DROP PROCEDURE IMPORT_TRANSFERT;"
        Dim cmd As FbCommand = DBConnection.CreateCommand
        Try
            cmd.CommandText = query

            cmd.ExecuteNonQuery()
        Catch ex As Exception

        End Try

        Try
            cmd.CommandText = "DROP TABLE T_EXTERNAL;"
            cmd.ExecuteNonQuery()
        Catch ex As Exception


        End Try

        query = TextFileResource("T_EXTERNAL.TPL.SQL").Replace("{FILE}", filename)

        cmd.CommandText = query
        cmd.ExecuteScalar()

        SQLScript(TextFileResource("PROC_IMPORT.SQL"))

        cmd.CommandText = "SELECT * FROM IMPORT_TRANSFERT"
        cmd.CommandType = CommandType.StoredProcedure
        'cmd.ExecuteScalar()
        Dim lines As Integer = 0
        Dim lastsystem As Integer = -1
        Dim updatedplanet As Integer = 0
        Dim addedplanet As Integer = 0
        Dim updatedplayer As Integer = 0
        Dim addedplayer As Integer = 0
        With cmd.ExecuteReader
            Try

                While .Read
                    lines = lines + 1
                    If .Item("SYSTEM") <> lastsystem Then
                        lastsystem = .Item("SYSTEM")
                        RaiseEvent ImportedSystem(Me, .Item("GALAXY") & ":" & .Item("SYSTEM"))
                    End If
                    If lines Mod 150 Then
                        RaiseEvent ImportedLines(Me, lines)
                    End If
                    updatedplanet += .Item("PLANETUPDATED")
                    addedplanet += .Item("PLANETADDED")
                    updatedplayer += .Item("PLAYERUPDATED")
                    addedplayer += .Item("PLAYERADDED")
                End While
            Catch ex As Exception

                ShowException(ex, "Error while reading records in imported file")

            Finally
                .Close()
            End Try
        End With
        cmd.Dispose()
        RaiseEvent ImportedResult(Me, updatedplanet, addedplanet, updatedplayer, addedplayer)
        Console.WriteLine("File imported : " & lines & " lines.")
        query = "DROP PROCEDURE IMPORT_TRANSFERT;"
        cmd = DBConnection.CreateCommand
        Try
            cmd.CommandText = query
            cmd.ExecuteNonQuery()
        Catch ex As Exception
            ShowException(ex, "Droping procedure IMPORT_TRANSFERTS")
        End Try

        Try
            cmd.CommandText = "DROP TABLE T_EXTERNAL;"
            cmd.ExecuteNonQuery()
        Catch ex As Exception
            ShowException(ex, "Droping table T_EXTERNAL")
        End Try

        cmd.Dispose()
    End Function

    Public Function PlanetsSince(ByVal thetime As DateTime, ByVal gal_required As Integer) As FbDataReader
        Dim query As String = "DROP PROCEDURE EXPORT_TRANSFERT;"

        Dim cmd As FbCommand = DBConnection.CreateCommand

        Try
            Console.WriteLine("Suppression procedure stocké : EXPORT_TRANSFERT")
            cmd.CommandText = query
            cmd.ExecuteNonQuery()

        Catch ex As Exception
            'ShowException(ex, "Suppression procedure stocké")
        End Try
        'DBConnection.
        Console.WriteLine("Creation procedure stocké : EXPORT_TRANSFERT")
        Try

            SQLScript(TextFileResource("PROC_EXPORT.SQL"))
        Catch ex As Exception
            'ShowException(ex, "Création procedure stocké")
        End Try

        'La requête proprement dite

        cmd.CommandText = "SELECT * FROM EXPORT_TRANSFERT(@sincedate,@gal_required)"
        Console.WriteLine("Requète:" & cmd.CommandText)
        cmd.CommandType = CommandType.StoredProcedure
        cmd.Parameters.Add("@sincedate", FbDbType.TimeStamp).Direction = ParameterDirection.Input
        cmd.Parameters.Add("@gal_required", FbDbType.Integer).Direction = ParameterDirection.Input
        cmd.Parameters(0).Value = thetime
        cmd.Parameters(1).Value = gal_required
        Dim re As FbDataReader = cmd.ExecuteReader

        Return re
    End Function
    ''' <summary>
    ''' Récupération d'une collection de planètes dans la BD
    ''' pour envoi à OGSpy  0.301b et inférieur
    ''' </summary>
    ''' <param name="TheTime"></param>
    ''' <param name="reader"></param>
    ''' <param name="GalNumber"></param>
    ''' <param name="MaxPlanetCountChunk"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function GetUpdatedPlanetSinceChunk(ByVal TheTime As DateTime, ByRef reader As FbDataReader, Optional ByVal GalNumber As Integer = 0, Optional ByVal MaxPlanetCountChunk As Integer = 2499) As PlanetCol
        If reader Is Nothing Then
            Dim query As String = "SELECT ID FROM PLANETS WHERE DATADATE>='" & TheTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"
            If GalNumber <> 0 Then query &= " AND Galaxy=" & GalNumber

            Dim cmd As FbCommand = DBConnection.CreateCommand
            cmd.CommandText = query
            reader = cmd.ExecuteReader

        End If
        Dim retval As New PlanetCol

        Dim count As Integer = 0
        With reader
            While .Read

                Dim pl As Planet = Planet.FromPlanetID(.GetInt32(.GetOrdinal("ID")))
                If Not pl Is Nothing Then
                    count = count + 1
                    retval.Add(pl)
                End If
                If count > MaxPlanetCountChunk Then Return retval
            End While
        End With
        If retval.Count = 0 Then
            reader.Close()
            reader = Nothing
        End If

        Return retval
    End Function
    Public Function GetUpdatedPlanetSince(ByVal TheTime As DateTime) As PlanetCol
        If DBConnection Is Nothing Then Return Nothing
        Dim query As String = "SELECT ID FROM PLANETS WHERE DATADATE>='" & TheTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim retval As New PlanetCol
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        With cmd.ExecuteReader
            While .Read
                Dim pl As Planet = Planet.FromPlanetID(.GetInt32(.GetOrdinal("ID")))
                If Not pl Is Nothing Then retval.Add(pl)
            End While
            .Close()
        End With
        cmd.Dispose()
        Return retval
    End Function

    Public Function QueryExecute(ByVal QueryString As String) As Integer
        If DBConnection Is Nothing Then Return 0
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = QueryString
        Dim retval As Integer = cmd.ExecuteNonQuery
        cmd.Dispose()
        Return retval
    End Function
    Public Function GetFavorites() As DBConfigEntryCol
        Dim retval As New DBConfigEntryCol
        Dim query As String = "SELECT ID FROM ""CONFIG"" WHERE PARAMNAME='FAVORITE'"
        If DBConnection Is Nothing Then Return Nothing
        Dim cmd As FbCommand = DBConnection.CreateCommand
        cmd.CommandText = query
        Try

            With cmd.ExecuteReader
                While .Read
                    retval.Add(DBConfigEntry.FromID(.GetInt32(.GetOrdinal("ID"))))
                End While
                .Close()
            End With
        Catch ex As FbException
            System.Windows.Forms.MessageBox.Show("Your database doesnt seems to have the correct structure." & vbCrLf & ex.Message & vbCrLf & ex.StackTrace)
        End Try
        cmd.Dispose()
        Return retval
    End Function
    Public Event DBInfoMessage(ByVal sender As Object, ByVal e As FirebirdSql.Data.FirebirdClient.FbInfoMessageEventArgs)
    Private Sub DBConnection_InfoMessage(ByVal sender As Object, ByVal e As FirebirdSql.Data.FirebirdClient.FbInfoMessageEventArgs) Handles DBConnection.InfoMessage
        RaiseEvent DBInfoMessage(sender, e)
    End Sub
    Private Sub DBConnection_StateChange(ByVal sender As Object, ByVal e As System.Data.StateChangeEventArgs) Handles DBConnection.StateChange
        If e.CurrentState = ConnectionState.Open Then
            RaiseEvent EventInformation("Database Opened", Functions.enOGSEventType.ProgramInformation)
        End If
    End Sub

    Public Sub New(ByVal anUniverse As OGameObject.UniverseDB)
        pdefault = Me
        Universe = anUniverse
    End Sub
    Public Sub Close()
        If Not DBConnection Is Nothing Then
            DBConnection.Close()
            DBConnection = Nothing
        End If
    End Sub
    Protected Overrides Sub Finalize()
        If Not DBConnection Is Nothing Then
            Me.DBConnection.Close()
            DBConnection = Nothing
        End If
        MyBase.Finalize()
    End Sub


    Public Sub MoveDataFromPlayerToPlayer(ByVal origID As Integer, ByVal destID As Integer)

        Dim OrigPlayer As Player = Player.FromPlayerID(origID)
        Dim DestPlayer As Player = Player.FromPlayerID(destID)
        If OrigPlayer Is Nothing OrElse DestPlayer Is Nothing Then
            NewEventInformation("Cannot transfert data: " & IIf(OrigPlayer Is Nothing, origID, destID) & " is not found in players table", Functions.enOGSEventType.ProgramInformation)
            Return
        End If
        DestPlayer.Note = OrigPlayer.Note & vbCrLf & "(was " & OrigPlayer.Name & ")" & vbCrLf & DestPlayer.Note
        If OrigPlayer.MainPlanetCoords <> "0:0:0" AndAlso OrigPlayer.MainPlanetCoords <> "" Then
            DestPlayer.MainPlanetCoords = OrigPlayer.MainPlanetCoords
        End If
        DestPlayer.UpdateInsertandGetID()
        Dim resultMessage As String = ""
        Dim query As String
        'Planètes
        NewEventInformation("Transfering data from " & OrigPlayer.ToString & " to " & DestPlayer.ToString, Functions.enOGSEventType.ProgramInformation)

        query = "UPDATE PLANETS SET PLAYERID='" & destID & "' WHERE PLAYERID='" & origID & "'"
        resultMessage &= QueryExecute(query) & "planets, "

        'Ranking
        query = "UPDATE PLAYERSRANK SET PLAYER_ID='" & destID & "' WHERE PLAYER_ID='" & origID & "'"
        resultMessage &= QueryExecute(query) & " Global Statistics,"

        query = "UPDATE PLAYERSFLOTTE SET PLAYER_ID='" & destID & "' WHERE PLAYER_ID='" & origID & "'"
        resultMessage &= QueryExecute(query) & " Flotte Statistics,"

        query = "UPDATE PLAYERSRESEARCH SET PLAYER_ID='" & destID & "' WHERE PLAYER_ID='" & origID & "'"
        resultMessage &= QueryExecute(query) & " Research Statistics."
        NewEventInformation(resultMessage, Functions.enOGSEventType.ProgramInformation)

    End Sub
End Class
