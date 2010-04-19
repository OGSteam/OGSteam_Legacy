
Imports System.IO

''' -----------------------------------------------------------------------------
''' <summary>
''' Quelques fonctions utiles un peu partout
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	27/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Module Functions
    Friend Function TextFileResource(ByVal resourcefilename As String) As String
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

    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Coloration des rapports d'espionnages
    ''' </summary>
    ''' <param name="rtb"></param>
    ''' <remarks>
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	27/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Sub ColorSpyingReport(ByVal rtb As System.Windows.Forms.RichTextBox)
        Dim FrenchSpyTitle() As String = _
            {"Matières premières", _
             "Défense", _
             "Flotte", _
             "Bâtiments", _
             "Recherche", _
             "Probabilité de défense contre-espionnage:"}

        Dim FrenchSpyData() As String = { _
                "Métal:", _
                "Cristal:", _
                "Deutérium:", _
                "Energie:", _
                "Mine de métal", _
                "Mine de cristal", _
                "Synthétiseur de deutérium", _
                "Centrale électrique solaire", _
                "Centrale électrique de fusion", _
                "Usine de robots", _
                "Usine de nanites", _
                "Réservoir de deutérium", _
                "Silo de missiles", _
                "Chantier spatial", _
                "Laboratoire de recherche", _
                "Hangar de métal", _
                "Hangar de cristal", _
                "Hangar de deutérium", _
                "Technologie Espionnage", _
                "Technologie Ordinateur", _
                "Technologie Armes", _
                "Technologie Bouclier", _
                "Technologie énergie", _
                "Technologie de laser", _
                "Réacteur à combustion", _
                "Réacteur à impulsion", _
                "Propulsion hyperespace", _
                "Technologie Energie", _
                "Technologie Laser", _
                "Technologie Hyperespace", _
                "Technologie Protection des vaisseaux spatiaux" _
                }
        Dim FrenchSpyWeapon() As String = { _
                "Lanceur de missiles", _
                "Artillerie laser légère", _
                "Artillerie laser lourde", _
                "Artillerie à ions", _
                "Canon de Gauss", _
                "Missile Interception", _
                "Lanceur de plasma", _
                "Petit bouclier", _
                "Grand bouclier", _
                "Chasseur léger", _
                "Grand transporteur", _
                "Croiseur", _
                "Vaisseau de bataille", _
                "Sonde espionnage", _
                "Satellite solaire", _
                "Probabilité de destruction de la flotte d'espionnage ", _
                "Bombardier" _
                }

        For Each s As String In FrenchSpyTitle
            Dim inipos As Integer = rtb.Text.IndexOf(s)
            If inipos > -1 Then
                rtb.Select(inipos, s.Length)
                rtb.SelectionColor = System.Drawing.Color.Gold
                'rtb.s()
            End If
        Next
        For Each s As String In FrenchSpyData
            Dim inipos As Integer = rtb.Text.IndexOf(s)
            If inipos > -1 Then
                rtb.Select(inipos, s.Length)
                rtb.SelectionColor = System.Drawing.Color.Yellow
                'rtb.s()
            End If
        Next
        For Each s As String In FrenchSpyWeapon
            Dim inipos As Integer = rtb.Text.IndexOf(s)
            If inipos > -1 Then
                rtb.Select(inipos, s.Length)
                rtb.SelectionColor = System.Drawing.Color.LightPink
                'rtb.s()
            End If
        Next
    End Sub
    Declare Function PlaySound Lib "winmm.dll" (ByVal data() As Byte, _
        ByVal hMod As IntPtr, ByVal hwFlags As Integer) As Integer
    Const SND_ASYNC As Integer = &H1        'Play asynchronously
    Const SND_MEMORY As Integer = &H4       'Play wav in memory 

    Public Sub TimeThisProc(ByVal msg As String)
        Console.WriteLine(Now.Ticks & " : " & msg)
    End Sub
    Public Function GetFileContents(ByVal FullPath As String, _
       Optional ByRef ErrInfo As String = "") As String

        Dim strContents As String
        Dim objReader As StreamReader
        Try

            objReader = New StreamReader(FullPath)
            strContents = objReader.ReadToEnd()
            objReader.Close()
            Return strContents
        Catch Ex As Exception
            ErrInfo = Ex.Message
            Return String.Empty
        End Try
    End Function

    Public Function SaveTextToFile(ByVal strData As String, _
     ByVal FullPath As String, _
       Optional ByVal ErrInfo As String = "") As Boolean


        Dim bAns As Boolean = False
        Dim objReader As StreamWriter
        Try


            objReader = New StreamWriter(FullPath)
            objReader.Write(strData)
            objReader.Close()
            bAns = True
        Catch Ex As Exception
            ErrInfo = Ex.Message

        End Try
        Return bAns
    End Function
End Module
