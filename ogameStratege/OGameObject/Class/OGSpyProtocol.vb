Imports System.Collections.Generic
Public Class OGSpyProtocol
    Public Shared RowSeparator() As String = {"<->"}
    Public Shared FieldsSeparator() As String = {"<||>"}

    Private pHTMLData As String
    Public Property HTMLData() As String
        Get
            Return pHTMLData
        End Get
        Set(ByVal value As String)
            pHTMLData = value
            pFields = Nothing
            pLines = Nothing
        End Set
    End Property
    Private pLines() As String = Nothing
    Public ReadOnly Property Lines() As String()
        Get
            If pLines Is Nothing Then
                pLines = HTMLData.Split(RowSeparator, _
                                                  StringSplitOptions.None)
            End If
            Return pLines
        End Get
    End Property
    Private pFields As Collections.Specialized.NameValueCollection = Nothing
    Public ReadOnly Property Fields() As Collections.Specialized.NameValueCollection
        Get
            If pFields Is Nothing Then
                pFields = New Collections.Specialized.NameValueCollection
                Dim FieldsLine As String = Lines(0)
                Dim Field() As String = FieldsLine.Split(",")
                For Each s As String In Field
                    Dim FieldVal() As String = s.Split("=")
                    pFields.Add(FieldVal(0), FieldVal(1))
                Next
            End If
            Return pFields
        End Get
    End Property

    Private pItems As List(Of List(Of String))
    Public ReadOnly Property Items() As List(Of List(Of String))
        Get
            If pItems Is Nothing Then
                pItems = New List(Of List(Of String))
                For i As Integer = 1 To Lines.GetLength(0) - 1
                    Dim values() As String = Lines(i).Split(FieldsSeparator, StringSplitOptions.None)
                    Dim a As New List(Of String)
                    a.AddRange(values)
                    pItems.Add(a)
                Next
            End If
            Return pItems
        End Get
    End Property
    Default Public ReadOnly Property Item(ByVal i As Integer) As List(Of String)
        Get
            If i < 0 Or i > Items.Count - 1 Then Return Nothing
            Return Items(i)
        End Get
    End Property
    Public Overrides Function ToString() As String
        Dim Info As New System.Text.StringBuilder
        Info.AppendLine("Paquet OGSpy")
        Info.AppendLine("------------")
        Info.AppendLine("Champs:")
        For Each s As String In Fields.Keys
            Info.AppendLine(" - " & s)
        Next
        Info.AppendLine("Premier Enregistrement:")
        For Each s As String In Item(0)
            Info.AppendLine(" - " & s)
        Next
        Return Info.ToString()
    End Function
End Class
