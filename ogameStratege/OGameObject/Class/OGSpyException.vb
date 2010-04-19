''' <summary>
''' Exception/Erreur lors de l'accés au serveur OGSpy
''' </summary>
''' <remarks></remarks>
Public Class OGSpyException
    Inherits Exception

    Private pID As Integer
    Public ReadOnly Property ID() As Integer
        Get
            Return pID
        End Get
    End Property

    Public Sub New(ByVal _message As String, ByVal _ID As Integer)
        MyBase.New(_message)
        pID = _ID
    End Sub
End Class
