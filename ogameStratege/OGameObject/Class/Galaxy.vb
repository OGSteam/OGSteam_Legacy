Imports System.Xml.Serialization
Imports FirebirdSql.Data.FirebirdClient
Imports System.Text.RegularExpressions
Imports System.IO
Imports System.Xml




''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : Galaxy
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Classe representant un systeme (15 planètes) d'une galaxie
''' </summary>
''' <remarks>
'''  Elle aurait pas du s'appeller Galaxy :p
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class Galaxy
    Public ID As Integer = 0
    Public Galaxy As Integer = 0
    Public System As Integer = 0
    Public DataSender As String = Player.DefaultDataSender
    Public DataDate As DateTime = Now
    Public Planets As New PlanetCol
    Public Overrides Function ToString() As String
        Return "Galaxy " & Galaxy & ", System " & Me.System
    End Function

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Renvoie une planete du systeme
    ''' </summary>
    ''' <param name="index">numéro de la planète</param>
    ''' <value>La planète ou nothing</value>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public ReadOnly Property PlanetNum(ByVal index As Integer) As Planet
        Get
            For Each p As Planet In Planets
                If p.Num = index Then Return p
            Next
            Return Nothing
        End Get
    End Property
    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Coordonnées du systeme
    ''' </summary>
    ''' <value>sous la forme G:SSS</value>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public ReadOnly Property Coords() As String
        Get
            Return Me.Galaxy & ":" & Me.System
        End Get
    End Property

    Public Sub UpdateCreate()
        If OGameDBEngine.Default Is Nothing Then Throw New Exception("Galaxy Creation Error: Database Not Opened")
        Dim query As String
        If ID <> 0 Then
            query = "UPDATE GALAXY SET " & _
                        """DATASENDER""='" & DataSender & "'," & _
                        """DATADATE""='" & DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'"

        Else
            query = "INSERT INTO GALAXY " & _
                    "(GALAXY,SYSTEM,DATADATE,DATASENDER) " & _
                    "VALUES (" & _
                        "'" & Me.Galaxy & "'," & _
                        "'" & Me.System & "'," & _
                        "'" & Me.DataDate.ToString("yyyy-MM-dd HH:mm:ss") & "'," & _
                        "'" & Me.DataSender & "'" & _
                    ")"
        End If
        Dim fbc As FbCommand
        fbc = New FbCommand(query, OGameDBEngine.Default.DBConnection)
        fbc.ExecuteNonQuery()
        fbc.Dispose()
        If ID = 0 Then
            Dim fbca As New FbCommand("SELECT GEN_ID(GEN_GALAXY_ID ,0) FROM RDB$DATABASE", OGameDBEngine.Default.DBConnection)
            ID = fbca.ExecuteScalar()
            fbca.Dispose()
        End If
    End Sub

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Recupère le systeme des coordonnées spécifiés
    ''' </summary>
    ''' <param name="aGalaxy">Numéro de galaxie</param>
    ''' <param name="aSystem">numéro du systeme</param>
    ''' <returns>systeme pointé</returns>
    ''' <remarks>
    ''' Si le systeme n'existe pas , il est crée. Ne retourne donc jamais nothing
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared Function FromCoords(ByVal aGalaxy As Integer, ByVal aSystem As Integer) As Galaxy

        If OGameDBEngine.Default Is Nothing Then Return Nothing
        Dim query As String = "SELECT * FROM GALAXY " & _
                            "WHERE ""GALAXY""='" & aGalaxy & "' AND ""SYSTEM""='" & aSystem & "'"
        Dim fbc As FbCommand
        fbc = New FbCommand(query, OGameDBEngine.Default.DBConnection)
        Dim Gal As New Galaxy
        Try

            With fbc.ExecuteReader
                If Not .Read Then
                    Dim fbc2 As New FbCommand(query, OGameDBEngine.Default.DBConnection)
                    fbc2.CommandText = "SELECT count(*) from PLANETS WHERE GALAXY=" & aGalaxy & " AND SYSTEM=" & aSystem

                    If fbc2.ExecuteScalar > 0 Then
                        Gal.Galaxy = aGalaxy
                        Gal.System = aSystem
                        Gal.DataSender = "Auto"
                        Gal.DataDate = Now
                        Gal.UpdateCreate()
                        For i As Integer = 1 To 15
                            Dim o As Object = Planet.FromCoords(aGalaxy, aSystem, i)
                            If Not o Is Nothing Then Gal.Planets.Add(o)
                        Next
                        fbc.Dispose()
                        .Close()
                        fbc2.Dispose()
                        Return Gal

                    End If
                    fbc2.Dispose()
                    Return Nothing
                End If

                Gal.ID = .GetValue(.GetOrdinal("ID"))
                Gal.Galaxy = aGalaxy
                Gal.System = aSystem
                Gal.DataDate = .GetValue(.GetOrdinal("DATADATE"))
                Gal.DataSender = .GetValue(.GetOrdinal("DATASENDER"))

                For i As Integer = 1 To 15
                    Dim o As Object = Planet.FromCoords(aGalaxy, aSystem, i)
                    If Not o Is Nothing Then Gal.Planets.Add(o)
                Next
                .Close()
            End With
            fbc.Dispose()
        Catch ex As Exception
            Console.WriteLine("Error: " & ex.Message)
            Console.WriteLine(ex.StackTrace)
        End Try

        Return Gal
    End Function

End Class


