

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : RemoteAccountCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Collection typés de comptes distant
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class RemoteAccountCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As RemoteAccount
        Get
            Return CType(List(index), RemoteAccount)
        End Get
        Set(ByVal Value As RemoteAccount)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As RemoteAccount) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As RemoteAccount) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As RemoteAccount)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As RemoteAccount)
        List.Remove(value)
    End Sub 'Remove
End Class