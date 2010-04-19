Imports System.Windows.Forms

''' -----------------------------------------------------------------------------
''' <summary>
''' Fonctions et definitions fourre-tout
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
''' 

Public Module Functions

    Public Enum enOGSEventType
        ProgramInformation
        NewPlayer
        NewInactivePlayer
        NewBlockedPlayer
        PlayerChangeAlly
        MoonChanged
        PlayerStatusChanged
        Import_Planet
        Import_Stats
        Imprts_Spyreport
        Export_Planet
        Export_Stats
        Export_Spyreport
        StatisticDetected
        AttackDetected
        GalaxyDetected
        MainPlanetDetected
        SpyReportDetected
        StartingTask
        PlayerUpdated
        UserPlanetData
        EndingTask
        Unclassified
    End Enum
    Public MainAppForm As Form = Nothing
    ''' <summary>
    ''' Recupère une ressource texte à partir de son nom
    ''' </summary>
    ''' <param name="resourcefilename">Le nom de la ressource</param>
    ''' <returns>Le texte de la ressource</returns>
    ''' <remarks></remarks>
    Public Function TextFileResource(ByVal resourcefilename As String) As String
        Dim result As String = ""
        ' Get our assembly.
        Dim executing_assembly As System.Reflection.Assembly = Reflection.Assembly.GetExecutingAssembly()
        ' Get our namespace.
        Dim my_namespace As String = executing_assembly.GetName().Name.ToString()
        ' Load a text file.
        Dim text_stream As IO.Stream = executing_assembly.GetManifestResourceStream(my_namespace + "." & resourcefilename)
        If Not (text_stream Is Nothing) Then
            Dim stream_reader As New IO.StreamReader(text_stream)
            result = stream_reader.ReadToEnd()
            stream_reader.Close()
        End If
        Return result
    End Function
    Friend Function TextFileResourceStream(ByVal resourcefilename As String) As IO.Stream

        ' Get our assembly.
        Dim executing_assembly As System.Reflection.Assembly = Reflection.Assembly.GetExecutingAssembly()
        ' Get our namespace.
        Dim my_namespace As String = executing_assembly.GetName().Name.ToString()
        ' Load a text file.
        Dim text_stream As IO.Stream = executing_assembly.GetManifestResourceStream(my_namespace + "." & resourcefilename)
        Return text_stream
    End Function
    Public Function Str4Strm(ByVal strm As System.IO.Stream, Optional ByVal CloseStream As Boolean = True) As String
        Dim result As String = String.Empty
        Dim readStream As New System.IO.StreamReader(strm, System.Text.Encoding.Default)
        result = readStream.ReadToEnd
        If CloseStream Then readStream.Close()
        Return result
    End Function

    Public Sub ShowException(ByVal ex As Exception, Optional ByVal extradata As String = "")
        'System.Windows.Forms.MessageBox.Show( _
        '    "Source: " & vbTab & ex.Source & "  " & extradata & vbCrLf & _
        '    "Message: " & vbTab & ex.Message & vbCrLf & _
        '    "Stack Trace:" & vbCrLf & _
        '    ex.StackTrace, _
        '    Application.ProductName & " " & Application.ProductVersion, _
        '    MessageBoxButtons.OK)
        Console.WriteLine("<####: " & Now.ToUniversalTime & " - Error/Exception " & Application.ProductName & " " & Application.ProductVersion & " :####>")
        If extradata.Length > 0 Then Console.WriteLine("<-- ->  " & vbTab & ex.Source & " -->")
        Console.WriteLine("Source: " & vbCrLf & ex.Source)
        Console.WriteLine("Message: " & vbCrLf & ex.Message)
        Console.WriteLine("Stack Trace:")
        Console.WriteLine(ex.StackTrace)
        Console.WriteLine("<### ___________Fin de Rapport________ ###>")
        Beep()
    End Sub
    'Source: http://authors.aspalliance.com/brettb/ROT13EncodingWithASPNet.asp
    'Encodes text using the ROT13 algorithm  
    Public Function ROT13Encode(ByVal InputText As String) As String
        If InputText Is Nothing Then Return String.Empty
        Dim i As Integer
        Dim CurrentCharacter As Char
        Dim CurrentCharacterCode As Integer
        Dim EncodedText As String = ""
        If InputText.Length < 1 Then Return String.Empty
        'Iterate through the length of the input parameter  
        For i = 0 To InputText.Length - 1
            'Convert the current character to a char  
            CurrentCharacter = System.Convert.ToChar(InputText.Substring(i, 1))

            'Get the character code of the current character  
            CurrentCharacterCode = Microsoft.VisualBasic.Asc(CurrentCharacter)

            'Modify the character code of the character, - this  
            'so that "a" becomes "n", "z" becomes "m", "N" becomes "Y" and so on  
            If CurrentCharacterCode >= 97 And CurrentCharacterCode <= 109 Then
                CurrentCharacterCode = CurrentCharacterCode + 13

            Else
                If CurrentCharacterCode >= 110 And CurrentCharacterCode <= 122 Then
                    CurrentCharacterCode = CurrentCharacterCode - 13

                Else
                    If CurrentCharacterCode >= 65 And CurrentCharacterCode <= 77 Then
                        CurrentCharacterCode = CurrentCharacterCode + 13

                    Else
                        If CurrentCharacterCode >= 78 And CurrentCharacterCode <= 90 Then
                            CurrentCharacterCode = CurrentCharacterCode - 13
                        End If
                    End If
                End If 'Add the current character to the string to be returned
            End If
            EncodedText = EncodedText + Microsoft.VisualBasic.ChrW(CurrentCharacterCode)
        Next i

        Return EncodedText
    End Function 'ROT13Encode  
End Module
