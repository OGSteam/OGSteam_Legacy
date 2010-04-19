Imports System
Imports System.Runtime.InteropServices
Imports System.Resources
Imports System.IO

'"SystemQuestion"
'"SystemExclaimation"
'"SystemHand"
'"Maximize"
'"MenuCommand"
'"MenuPopup"
'"Minimize"
'"MailBeep"
'"Open"
'"Close"
'"SystemAsterisk"
'"RestoreUp"
'"RestoreDown"
'"SystemExit"
'"SystemStart"
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : Sound
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''   Gestion du son
''' </summary>
''' <remarks>
''' Probablement a sortir d'OGameObject.dll
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class Sound
    Public Shared enableSound As Boolean = True
    Declare Auto Function PlaySound Lib "winmm.dll" (ByVal name _
      As String, ByVal hmod As Integer, ByVal flags As Integer) As Integer

    Declare Auto Function PlaySound Lib "winmm.dll" (ByVal name _
      As Byte(), ByVal hmod As Integer, ByVal flags As Integer) As Integer

    Public Const SND_SYNC As Integer = &H0 ' play synchronously 
    Public Const SND_ASYNC As Integer = &H1 ' play asynchronously 
    Public Const SND_MEMORY As Integer = &H4  'Play wav in memory
    Public Const SND_ALIAS As Integer = &H10000 'Play system alias wav 
    Public Const SND_NODEFAULT As Integer = &H2
    Public Const SND_FILENAME As Integer = &H20000 ' name is file name 
    Public Const SND_RESOURCE As Integer = &H40004 ' name is resource name or atom 

    Public Shared Sub PlayWaveFileAsync(ByVal fileWaveFullPath As String)
        Try
            If fileWaveFullPath.ToUpper.Trim = "NONE" Then Return
            If enableSound Then PlaySound(fileWaveFullPath, 0, SND_ASYNC Or SND_FILENAME)
        Catch
        End Try
    End Sub
    Public Shared Sub PlayWaveFile(ByVal fileWaveFullPath As String)
        Try
            If fileWaveFullPath.ToUpper.Trim = "NONE" Then Return
            If enableSound Then PlaySound(fileWaveFullPath, 0, SND_FILENAME)
        Catch
        End Try
    End Sub
    Public Shared Sub PlayWaveResource(ByVal WaveResourceName As String)
        If Not enableSound Then Return
        ' get the namespace 
        Dim strNameSpace As String = System.Reflection.Assembly.GetExecutingAssembly().GetName().Name.ToString()

        ' get the resource into a stream
        Dim resourceStream As Stream = System.Reflection.Assembly.GetExecutingAssembly().GetManifestResourceStream(strNameSpace + "." + WaveResourceName)
        If resourceStream Is Nothing Then Exit Sub

        ' bring stream into a byte array
        Dim wavData As Byte()
        ReDim wavData(CInt(resourceStream.Length))
        resourceStream.Read(wavData, 0, CInt(resourceStream.Length))

        ' play the resource
        PlaySound(wavData, 0, SND_ASYNC Or SND_MEMORY)
    End Sub

    Public Shared Sub PlayWaveSystem(ByVal SystemWaveName As String)
        If enableSound Then PlaySound(SystemWaveName, 0&, SND_ALIAS Or SND_ASYNC Or SND_NODEFAULT)
    End Sub
End Class