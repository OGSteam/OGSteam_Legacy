
''' -----------------------------------------------------------------------------
''' Project	 : OGameStratege
''' Class	 : RedirectConsoleStream
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Utilitaire pour une seconde redirection des consoles.write(blahblah)
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	27/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class RedirectConsoleStream
    Inherits IO.TextWriter

    Dim pControl As System.Windows.Forms.Control = Nothing

    Public Property Control() As System.Windows.Forms.Control
        Get
            Return pControl
        End Get
        Set(ByVal Value As System.Windows.Forms.Control)
            pControl = Value
        End Set
    End Property
    Private PrevOut As IO.TextWriter = Nothing
    Public Sub redirectOutput()
        PrevOut = Console.Out
        Console.SetOut(Me)

    End Sub
    Public Overrides ReadOnly Property Encoding() As System.Text.Encoding
        Get
            Return Nothing
        End Get
    End Property
    Delegate Sub dlgAddLine(ByVal TextLine As String)
    Public Overrides Sub WriteLine(ByVal value As String)
        If Control.InvokeRequired Then
            Dim d As New dlgAddLine(AddressOf Me.WriteLine)
            Control.Invoke(d, New Object() {value})
            Exit Sub
        End If
        MyBase.WriteLine(value)
    End Sub
    Public Outputtofile As Boolean = False
    Public Overloads Overrides Sub Write(ByVal value As Char)

        If Outputtofile Then
            Dim sw As System.IO.StreamWriter = New System.IO.StreamWriter("ogs_debug.txt", True)
            sw.Write(value)
            sw.Flush()
            sw.Close()
        End If

        Control.Text &= value

        If Not PrevOut Is Nothing Then
            PrevOut.Write(value)
        End If
        MyBase.Write(value)

    End Sub

    Public Overloads Overrides Sub Write(ByVal value As String)
        MyBase.Write(value)
    End Sub
End Class
