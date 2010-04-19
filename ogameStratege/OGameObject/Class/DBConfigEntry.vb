Imports FirebirdSql.Data.FirebirdClient


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : DBConfigEntry
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Entrée de configuration dans la base de donnée
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class DBConfigEntry

    Public ID As Integer
    Public ParamName As String
    Public ParamValue As String
    Public Sub New()

    End Sub
    Public Sub New(ByVal Name As String, ByVal value As String)
        ParamName = Name
        ParamValue = value
    End Sub
    Public Shared Function Exist(ByVal Name As String, ByVal Value As String) As Boolean
        If OGameDBEngine.Default Is Nothing Then Return False
        Dim Query As String = "SELECT ID FROM CONFIG WHERE " & _
                            "PARAMNAME='" & Name & "' AND " & _
                            "PARAMVALUE='" & Value.Replace("'", "''") & "'"
        Dim fbc As FbCommand
        fbc = New FbCommand(Query, OGameDBEngine.Default.DBConnection)
        Dim existB As Boolean = fbc.ExecuteReader.Read
        fbc.Dispose()
        Return existB
    End Function
    Public Shared Function FromID(ByVal ConfigID As Integer) As DBConfigEntry
        Dim Query As String = "SELECT * FROM CONFIG WHERE " & _
                                    "ID='" & ConfigID & "'  "
        Dim fbc As FbCommand
        fbc = New FbCommand(Query, OGameDBEngine.Default.DBConnection)
        With fbc.ExecuteReader
            If .Read Then
                Dim DBC As New DBConfigEntry
                DBC.ID = ConfigID
                DBC.ParamName = .GetValue(.GetOrdinal("PARAMNAME"))
                DBC.ParamValue = .GetValue(.GetOrdinal("PARAMVALUE"))
                .Close()
                fbc.Dispose()
                Return DBC
            End If
            .Close()
            fbc.Dispose()
        End With
        Return Nothing
    End Function
    Public Sub InsertUpdate()
        Dim Query As String
        If ID <> 0 Then
            Query = "UPDATE CONFIG SET " & _
                        """PARAMNAME""='" & ParamName & "', " & _
                        """PARAMVALUE""='" & ParamValue & "' " & _
                        "WHERE ID='" & ID & "'"
        Else
            Query = "INSERT INTO CONFIG " & _
                    "(PARAMNAME,PARAMVALUE) " & _
                    "VALUES(" & _
                    "'" & ParamName.Replace("'", "''") & "', " & _
                    "'" & ParamValue.Replace("'", "''") & "' " & _
                    ")"
        End If
        If OGameDBEngine.Default Is Nothing Then Return


        Dim fbc As FbCommand
        fbc = New FbCommand(Query, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        If ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(GEN_CONFIG_ID,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            ID = fbca.ExecuteScalar()
        End If

    End Sub
End Class

