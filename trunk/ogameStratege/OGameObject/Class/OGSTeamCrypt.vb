Imports System
Imports System.IO
Imports System.Xml
Imports System.Text
Imports System.Security.Cryptography
''' <summary>
'''  Classe pour cryptage des mot de passes
''' </summary>
''' <remarks>
''' NB: la clef etant en clair... c'est juste pour eviter que le mdp soit
''' directement lisible dans le fichier XML.
''' Bien evidemment... il est pas trés compliqué connaissant la clef de decrypter
''' ces mots de passes... Je n'ai pas d'alternative
''' source: http://www.codeproject.com/aspnet/encrypt.asp
''' </remarks>
Public Class OGSTeamCrypt
    ' Encrypt the text
    Public Shared Function EncryptText(ByVal strText As String) As String
        Return Encrypt(strText, "ogsteam")
    End Function

    'Decrypt the text 
    Public Shared Function DecryptText(ByVal strText As String) As String
        Return Decrypt(strText, "ogsteam")
    End Function

    'The function used to encrypt the text
    Private Shared Function Encrypt(ByVal strText As String, ByVal strEncrKey _
             As String) As String
        Dim byKey() As Byte = {}
        Dim IV() As Byte = {&H12, &H34, &H56, &H78, &H90, &HAB, &HCD, &HEF}

        Try
            byKey = System.Text.Encoding.UTF8.GetBytes(Left(strEncrKey, 8))

            Dim des As New DESCryptoServiceProvider()
            Dim inputByteArray() As Byte = Encoding.UTF8.GetBytes(strText)
            Dim ms As New MemoryStream()
            Dim cs As New CryptoStream(ms, des.CreateEncryptor(byKey, IV), _
                   CryptoStreamMode.Write)
            cs.Write(inputByteArray, 0, inputByteArray.Length)
            cs.FlushFinalBlock()
            Return Convert.ToBase64String(ms.ToArray())

        Catch ex As Exception
            Return ex.Message
        End Try

    End Function

    'The function used to decrypt the text
    Private Shared Function Decrypt(ByVal strText As String, ByVal sDecrKey _
               As String) As String
        Dim byKey() As Byte = {}
        Dim IV() As Byte = {&H12, &H34, &H56, &H78, &H90, &HAB, &HCD, &HEF}
        Dim inputByteArray(strText.Length) As Byte

        Try
            byKey = System.Text.Encoding.UTF8.GetBytes(Left(sDecrKey, 8))
            Dim des As New DESCryptoServiceProvider()
            inputByteArray = Convert.FromBase64String(strText)
            Dim ms As New MemoryStream()
            Dim cs As New CryptoStream(ms, des.CreateDecryptor(byKey, _
                 IV), CryptoStreamMode.Write)

            cs.Write(inputByteArray, 0, inputByteArray.Length)
            cs.FlushFinalBlock()
            Dim encoding As System.Text.Encoding = System.Text.Encoding.UTF8

            Return encoding.GetString(ms.ToArray())

        Catch ex As Exception
            Return ex.Message
        End Try

    End Function
End Class
