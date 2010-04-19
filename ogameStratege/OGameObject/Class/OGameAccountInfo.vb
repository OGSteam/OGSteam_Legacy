<Serializable()> Public Class OGameAccountInfo
    Public LoginName As String
    Public PasswordEncrypted As String
    Public OgameUniverseTitle As String
    Public ReadOnly Property UncryptedPassword() As String
        Get
            Return OGSTeamCrypt.DecryptText(PasswordEncrypted)
        End Get
    End Property
    Public Sub SetUncryptedPassword(ByVal RealPassword As String)
        PasswordEncrypted = OGSTeamCrypt.EncryptText(RealPassword)
    End Sub
    Public Overrides Function ToString() As String
        Return LoginName & " (" & OgameUniverseTitle & ")"
    End Function
End Class