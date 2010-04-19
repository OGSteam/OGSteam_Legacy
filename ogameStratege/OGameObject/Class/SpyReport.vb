Imports FirebirdSql.Data.FirebirdClient
Imports System.Xml.Serialization
Imports System.Text.RegularExpressions



''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : SpyReport
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Objet Rapport d'espionnage
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class SpyReport

    <XmlIgnore()> Public Shared DefaultDataSender As String = Player.DefaultDataSender
    <XmlIgnore()> Public ID As Integer = 0
    Public Planet As Planet = New Planet
    Public RawReport As String
    Public shareable As Boolean
    Public DataSender As String = DefaultDataSender
    Public DataDate As DateTime = Now
    Public Shared Function FromDataRow(ByVal drow As Data.DataRow) As SpyReport
        Dim sr As New SpyReport
        sr.ID = drow("ID")
        sr.DataSender = drow("DATASENDER")
        sr.RawReport = drow("DATA")
        sr.DataDate = drow("DATADATE")
        sr.Planet = OGameObject.Planet.FromPlanetID(drow("PLANET_ID"))
        sr.shareable = drow("SHAREABLE")
        Return sr
    End Function
    Public Function InsertString() As String
        Return "INSERT INTO ESPIONAGES " & _
               "(PLANET_ID,DATA,SHAREABLE,DATASENDER,DATADATE) " & _
               "VALUES (" & _
               "        '" & Planet.ID & "'," & _
               "        '" & RawReport.Replace("'", "''") & "'," & _
               "        '" & IIf(shareable, 1, 0) & "'," & _
               "        '" & Me.DataSender & "'," & _
               "        '" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'" & _
               ")"
    End Function
    Public Function ExportString() As String
        Dim RetStr As String
        RetStr = Planet.Coords & "||" & Planet.Name & "||" & DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "||" & RawReport
        Return RetStr
    End Function
    Public Shared Function FromID(ByVal spyID As Integer) As SpyReport
        Dim CheckExist As String = "SELECT * FROM ESPIONAGES WHERE" & _
                                 """ID""='" & spyID & "'"
        Dim fbc2 As New FbCommand(CheckExist, OGameDBEngine.Default.DBConnection)
        Try

            With fbc2.ExecuteReader
                If .Read Then
                    Dim sr As New SpyReport
                    sr.ID = .GetValue(.GetOrdinal("ID"))
                    sr.DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                    sr.RawReport = .GetValue(.GetOrdinal("DATA"))
                    sr.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                    sr.Planet = OGameObject.Planet.FromPlanetID(.GetValue(.GetOrdinal("PLANET_ID")))
                    sr.shareable = .GetValue(.GetOrdinal("SHAREABLE"))
                    .Close()
                    fbc2.Dispose()

                    Return sr
                End If
                .Close()
                fbc2.Dispose()

            End With
        Catch ex As Exception
            System.Windows.Forms.MessageBox.Show(ex.Message & vbCrLf & ex.StackTrace)
        End Try

        Return Nothing
    End Function
    Dim sd As spydata = Nothing
    Public Function GetSpyData() As spydata
        If Planet.System = 275 And Planet.Num = 11 Then
            Console.WriteLine("test")
        End If
        If sd Is Nothing Then
            sd = New spydata
            sd.FromPlanetDate(Planet.ID, DataDate)
        End If

        Return sd
    End Function
    Public Function ReadFromPlanetIDAndDate() As Boolean
        Dim CheckExist As String = "SELECT * FROM ESPIONAGES WHERE" & _
                                 """PLANET_ID""='" & Planet.ID & "' AND " & _
                                 """DATADATE""='" & DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"
        Dim fbc2 As New FbCommand(CheckExist, OGameDBEngine.Default.DBConnection)
        With fbc2.ExecuteReader
            If .Read Then
                ID = .GetValue(.GetOrdinal("ID"))
                DataSender = .GetValue(.GetOrdinal("DATASENDER"))
                RawReport = .GetValue(.GetOrdinal("DATA"))
                shareable = .GetValue(.GetOrdinal("SHAREABLE"))
                .Close()
                fbc2.Dispose()

                Return True
            End If
            .Close()
            fbc2.Dispose()

        End With
        Return False
    End Function
    Public Function UpdateInsertandGetID() As Integer
        If OGameDBEngine.Default Is Nothing Then Return 0


        Dim fbc As New FbCommand(SQLString, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        If ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(ESPIONAGES_ID,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            ID = fbca.ExecuteScalar()
        End If
        fbc.Dispose()
        Return ID

    End Function
    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function

    Public Function UpdateString() As String
        Return "UPDATE ESPIONAGES SET " & _
                    """PLANET_ID""='" & Planet.ID & "'," & _
                    """DATA""='" & RawReport.Replace("'", "''") & "'," & _
                    """DATASENDER""='" & Me.DataSender & "'," & _
                    """SHAREABLE""='" & IIf(Me.shareable, 1, 0) & "'," & _
                    """DATADATE""='" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
                    "WHERE ""ID""='" & ID & "'"

    End Function
    Public Enum enToStringType
        [default]
        DescDatePlayerName
        ShortDateOnly
    End Enum
    <XmlIgnore()> Public ToStringType As enToStringType = enToStringType.default
    Public Overrides Function ToString() As String
        If ToStringType = enToStringType.DescDatePlayerName Then
            Return DataDate.ToString("MM-dd HH:mm") & " - " & Me.Planet.Owner.ToString
        ElseIf ToStringType = enToStringType.ShortDateOnly Then
            Return DataDate.ToString("MM-dd HH:mm")
        End If
        Return "Spy:" & Planet.ToString & " on " & DataDate.ToString
    End Function
End Class




