
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : DBConfigEntryCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Collection typés de DBConfigEntry
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class DBConfigEntryCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As DBConfigEntry
        Get
            Return CType(List(index), DBConfigEntry)
        End Get
        Set(ByVal Value As DBConfigEntry)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As DBConfigEntry) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As DBConfigEntry) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As DBConfigEntry)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As DBConfigEntry)
        List.Remove(value)
    End Sub 'Remove
End Class