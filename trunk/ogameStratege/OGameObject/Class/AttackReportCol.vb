''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : AttackReportCol
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Collection typé de classe AttackReport
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
<Serializable()> Public Class AttackReportCol
    Inherits CollectionBase

    Public Sub New()
        MyBase.New()
    End Sub
    Public Sub New(ByVal dtable As DataTable)
        MyBase.New()
        For Each dr As DataRow In dtable.Rows
            Add(AttackReport.FromDataRow(dr))
        Next
    End Sub
    Default Public Property Item(ByVal index As Integer) As AttackReport
        Get
            Return CType(List(index), AttackReport)
        End Get
        Set(ByVal Value As AttackReport)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As AttackReport) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As AttackReport) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As AttackReport)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As AttackReport)
        List.Remove(value)
    End Sub 'Remove
End Class
