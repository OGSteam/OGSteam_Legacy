

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : RemoteAccount
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Compte distant OGSPY
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------

<Serializable()> Public Class RemoteAccount
    Public Sub New()

    End Sub

    Public OGSServerURL As String
    Public LoginName As String
    Public Password As String
    Public FriendlyName As String
    Public LastSendedInfo As DateTime = New DateTime(2005, 1, 1, 0, 0, 0)
    Public LastUpdatedInfo As DateTime = New DateTime(2005, 1, 1, 0, 0, 0)
    Public DefaultAccount As Boolean = False
    Public MaxPlanetCountChunk As Integer = 2000
    Public ExportPlanets As Boolean = True
    Public ImportPlanets As Boolean = True
    Public ImportSpy As Boolean = True
    Public ExportSpy As Boolean = True
    Public Overrides Function ToString() As String
        Return FriendlyName & "(" & LoginName & ")"
    End Function
End Class