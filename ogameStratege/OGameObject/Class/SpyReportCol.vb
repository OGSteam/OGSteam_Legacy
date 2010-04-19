<Serializable()> Public Class SpyReportCol
    Inherits CollectionBase
    Public Sub New()

    End Sub
    Public Sub New(ByVal dtable As DataTable)
        MyBase.New()
        For Each dr As DataRow In dtable.Rows
            Add(SpyReport.FromDataRow(dr))
        Next
    End Sub
    Default Public Property Item(ByVal index As Integer) As SpyReport
        Get
            Return CType(List(index), SpyReport)
        End Get
        Set(ByVal Value As SpyReport)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As SpyReport) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As SpyReport) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As SpyReport)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As SpyReport)
        List.Remove(value)
    End Sub 'Remove
End Class