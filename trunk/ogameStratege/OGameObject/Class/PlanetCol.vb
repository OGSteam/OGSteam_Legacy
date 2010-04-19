
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : PlanetCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Collection typés de planètes
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class PlanetCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As Planet
        Get
            Return CType(List(index), Planet)
        End Get
        Set(ByVal Value As Planet)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As Planet) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As Planet) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As Planet)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As Planet)
        List.Remove(value)
    End Sub 'Remove
End Class