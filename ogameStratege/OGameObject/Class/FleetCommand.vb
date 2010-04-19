
Imports FirebirdSql.Data.FirebirdClient
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : FleetCommand
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Classe gerant les retour de flotte
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class FleetCommand

    Public ID As Integer
    Public RawReport As String
    Public DataSender As String = Player.DefaultDataSender
    Public DataDate As DateTime = Now

    Public Function AlreadyInDatabase() As Boolean
        Return ID <> 0
    End Function
    Public Function NewRecord() As Boolean
        Return ID = 0
    End Function
    Public Shared Function FromID(ByVal FleetCommandID As Integer) As FleetCommand
        Dim CheckExist As String = "SELECT * FROM FLEETCOMMANDS WHERE" & _
                                                """ID""='" & FleetCommandID & "'"
        Dim fbc2 As FbCommand
        fbc2 = New FbCommand(CheckExist, OGameDBEngine.Default.DBConnection)
        With fbc2.ExecuteReader
            If .Read Then
                Dim sr As New FleetCommand
                sr.ID = .GetValue(.GetOrdinal("ID"))
                sr.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                sr.RawReport = .GetValue(.GetOrdinal("DATA"))
                sr.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                .Close()
                fbc2.Dispose()
                Return sr
            End If
            .Close()
            fbc2.Dispose()

        End With
        Return Nothing
    End Function

    Public Shared Function FromDateExist(ByVal FromDate As DateTime) As FleetCommand
        Dim CheckExist As String = "SELECT * FROM FLEETCOMMANDS WHERE" & _
                                        """DATADATE""='" & FromDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim fbc2 As FbCommand
        fbc2 = New FbCommand(CheckExist, OGameDBEngine.Default.DBConnection)
        With fbc2.ExecuteReader
            If .Read Then
                Dim sr As New FleetCommand
                sr.ID = .GetValue(.GetOrdinal("ID"))
                sr.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                sr.RawReport = .GetValue(.GetOrdinal("DATA"))
                sr.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                .Close()
                fbc2.Dispose()
                Return sr
            End If
            .Close()
            fbc2.Dispose()

        End With
        Return Nothing


    End Function
    Public Sub Create()
        If OGameDBEngine.Default Is Nothing Then Return

        Dim fbc As FbCommand
        fbc = New FbCommand(InsertString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        If ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(GEN_FLEETCOMMANDS_ID,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            ID = fbca.ExecuteScalar()
        End If
    End Sub


    Public Function InsertString() As String
        Return "INSERT INTO FLEETCOMMANDS " & _
               "(DATA,DATADATE,DATASENDER )" & _
               "VALUES (" & _
               "        '" & RawReport.Replace("'", "''") & "'," & _
               "        '" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'," & _
               "        '" & Me.DataSender & "'" & _
               ")"
    End Function


End Class


