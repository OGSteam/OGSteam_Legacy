
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : OgameAccountInfoCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Collection typés de comptes ogame
''' </summary>
''' <remarks>
''' Les mots de passes sont cryptés 
''' </remarks>
''' <history>
''' 	[eric]	15/10/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class OgameAccountInfoCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As OGameAccountInfo
        Get
            Return CType(List(index), OGameAccountInfo)
        End Get
        Set(ByVal Value As OGameAccountInfo)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As OGameAccountInfo) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As OGameAccountInfo) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As OGameAccountInfo)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As OGameAccountInfo)
        List.Remove(value)
    End Sub 'Remove
End Class
