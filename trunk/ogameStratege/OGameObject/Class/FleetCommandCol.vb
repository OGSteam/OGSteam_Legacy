

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : FleetCommandCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Collection typés des retour de flottes
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class FleetCommandCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As FleetCommand
        Get
            Return CType(List(index), FleetCommand)
        End Get
        Set(ByVal Value As FleetCommand)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As FleetCommand) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As FleetCommand) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As FleetCommand)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As FleetCommand)
        List.Remove(value)
    End Sub 'Remove
End Class