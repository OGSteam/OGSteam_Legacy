Imports FirebirdSql.Data.FirebirdClient

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : AttackReport
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Rapport de bataille
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class AttackReport
    Public ID As Integer
    Public AttackerPlanet As Planet
    Public DefenderPlanet As Planet
    Public RawReport As String
    Public DataSender As String = Player.DefaultDataSender
    Public DataDate As DateTime = Now

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    '''   Verifie l'existence d'un rapport de bataille
    ''' </summary>
    ''' <param name="AttackPlID">ID de l'attaquant</param>
    ''' <param name="DefenderPlID">ID de l'attaqué</param>
    ''' <param name="AttacTime">Date de l'attaque</param>
    ''' <returns></returns>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared Function Exist(ByVal AttackPlID As Integer, ByVal DefenderPlID As Integer, ByVal AttacTime As DateTime) As Boolean
        If OGameDBEngine.Default Is Nothing Then Throw New Exception("Attackreport Update: Database is closed")
        Dim Query As String = "SELECT ID FROM ""COMBATS"" " & _
                              "WHERE " & _
                              """ATTACKER_PLANET""='" & AttackPlID & "' AND " & _
                              """DEFENDER_PLANET""='" & DefenderPlID & "' AND " & _
                              """DATADATE""='" & AttacTime.ToString("yyyy-MM-dd HH:mm:ss") & "'"

        Dim fbc As FbCommand
        fbc = New FbCommand(Query, OGameDBEngine.Default.DBConnection)

        Dim existB As Boolean = fbc.ExecuteReader.Read
        fbc.Dispose()
        Return existB
    End Function
    Public Function result() As AttackResult
        Return New AttackResult(RawReport)
    End Function

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    '''   Initialisation à partir d'une ligne de donnée 
    ''' </summary>
    ''' <param name="drow">La ligne de donnée</param>
    ''' <returns>Un nouveau rapport de bataille</returns>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared Function FromDataRow(ByVal drow As Data.DataRow) As AttackReport
        Dim sr As New AttackReport
        sr.ID = drow("ID")
        sr.DataSender = drow("DATASENDER")
        sr.RawReport = drow("DATA")
        sr.DataDate = drow("DATADATE")
        sr.AttackerPlanet = OGameObject.Planet.FromPlanetID(drow("ATTACKER_PLANET"))
        sr.DefenderPlanet = OGameObject.Planet.FromPlanetID(drow("DEFENDER_PLANET"))
        Return sr
    End Function

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Initialisation à partir d'un ID
    ''' </summary>
    ''' <param name="AttackID">identificateur du rapport de bataille</param>
    ''' <returns>le rapport ou nothing </returns>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared Function FromID(ByVal AttackID As Integer) As AttackReport
        If OGameDBEngine.Default Is Nothing Then Throw New Exception("Attackreport Update: Database is closed")
        Dim Query As String = "SELECT * FROM ""COMBATS"" " & _
                              "WHERE " & _
                              """ID""='" & AttackID & "' ORDER BY ""DATADATE"" DESC"

        Dim fbc As FbCommand
        fbc = New FbCommand(Query, OGameDBEngine.Default.DBConnection)

        With fbc.ExecuteReader
            If .Read Then
                Dim sr As New AttackReport
                sr.ID = .GetValue(.GetOrdinal("ID"))
                sr.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                sr.RawReport = .GetValue(.GetOrdinal("DATA"))
                sr.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                sr.AttackerPlanet = OGameObject.Planet.FromPlanetID(.GetValue(.GetOrdinal("ATTACKER_PLANET")))
                sr.DefenderPlanet = OGameObject.Planet.FromPlanetID(.GetValue(.GetOrdinal("DEFENDER_PLANET")))
                .Close()
                fbc.Dispose()
                Return sr
            End If
        End With
        Return Nothing
    End Function

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Insertion d'un rapport de bataille en base de données
    ''' </summary>
    ''' <remarks>
    ''' Si le rapport existe, il n'y a pas de reinsertion
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Sub Create()
        If OGameDBEngine.Default Is Nothing Then Throw New Exception("Attackreport Update: Database is closed")
        If Not Exist(AttackerPlanet.ID, DefenderPlanet.ID, DataDate) Then
            Try

                Dim InsertQuery As String = _
                        "INSERT INTO COMBATS " & _
                        "(ATTACKER_PLANET,DEFENDER_PLANET,DATA,DATASENDER,DATADATE) " & _
                        "VALUES ('" & AttackerPlanet.ID & "','" & DefenderPlanet.ID & "','" & RawReport.Replace("'", "''") & "','" & DataSender & "','" & DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "')"
                Dim fbc As FbCommand
                fbc = New FbCommand(InsertQuery, OGameDBEngine.Default.DBConnection)
                fbc.ExecuteNonQuery()
                Dim fbca As New FbCommand("SELECT GEN_ID(COMBATS_ID ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
                ID = fbca.ExecuteScalar()
            Catch ex As Exception
                System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
                Throw ex
            End Try

        End If

    End Sub

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Renvoie une Chaine de caractères représentant le rapport de bataille
    ''' </summary>
    ''' <returns>Le rapport sous la forme "date coord attaquant coord attaqué"</returns>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Overrides Function ToString() As String
        Return DataDate.ToString("MM-dd ") & " [" & Me.AttackerPlanet.Coords & "] on [" & Me.DefenderPlanet.Coords & "]"
    End Function

End Class




