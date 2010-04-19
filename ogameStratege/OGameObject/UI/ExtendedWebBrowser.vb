Imports System
Imports System.Security
Imports System.ComponentModel
Imports System.Collections.Generic
Imports System.Text
Imports System.Runtime.InteropServices
Imports System.Runtime.InteropServices.ComTypes
Imports System.Windows.Forms
Imports System.Security.Permissions

Public Class ExtendedWebBrowser
    Inherits System.Windows.Forms.WebBrowser
    ' Private axIWebBrowser2 As UnsafeNativeMethods.IWebBrowser2

    Protected Overrides Sub WndProc(ByRef m As System.Windows.Forms.Message)
        'Hack pour les flashs
        Select Case m.Msg
            Case &H201, &H204, &H207, &H21
                MyBase.DefWndProc(m)
                Return
        End Select
        MyBase.WndProc(m)
    End Sub
End Class



