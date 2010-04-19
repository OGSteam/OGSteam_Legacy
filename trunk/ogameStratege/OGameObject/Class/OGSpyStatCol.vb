<Serializable()> Public Class OGSpyStatCol
    Inherits CollectionBase
    Default Public Property Item(ByVal index As Integer) As OGSpyStat
        Get
            Return CType(List(index), OGSpyStat)
        End Get
        Set(ByVal Value As OGSpyStat)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As OGSpyStat) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As OGSpyStat) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As OGSpyStat)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As OGSpyStat)
        List.Remove(value)
    End Sub 'Remove

    Public Sub CreateFromAnswer(ByVal OGSpyAnswer As String)

        Try

            Dim lines() As String = Microsoft.VisualBasic.Split(OGSpyAnswer, "<|>")
            For Each line As String In lines
                If line.Trim.Length > 1 Then
                    Dim data() As String = line.Split("=")
                    If data.Length > 1 Then
                        Dim o As New OGSpyStat(data(0), _
                                    data(1).IndexOf("P") > -1, _
                                    data(1).IndexOf("F") > -1, _
                                    data(1).IndexOf("R") > -1)
                        Add(o)
                    End If
                End If
            Next
        Catch ex As Exception
            Beep()
            ShowException(ex, "CreateFromAnswer")
        End Try

    End Sub
End Class