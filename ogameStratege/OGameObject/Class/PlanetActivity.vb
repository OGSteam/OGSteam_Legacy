Public Class PlanetActivity

    Public Shared Event coucou()
    Private _Planet As Planet = Nothing
    Public ReadOnly Property Planet() As Planet
        Get
            Return _Planet
        End Get
    End Property

    Public time As Date '' date du scan
    Public cdr As String '' texte du champ de ruine
    Public OgameActivity As String ''texte de l'activité ogamienne




    Public Sub New()
    End Sub
    Public Sub New(ByVal PA As PlanetActivity)
        _Planet = PA.Planet
        time = PA.time
        cdr = PA.cdr
        OgameActivity = PA.OgameActivity
    End Sub
    Public Sub New(ByVal sCDR As String, ByVal sOGameActivity As String, ByVal sTime As Date, ByVal pPlanet As Planet)
        _Planet = pPlanet
        cdr = sCDR
        time = sTime
        OgameActivity = sOGameActivity
    End Sub

    Public Sub ProcessChange()
        If Planet Is Nothing Then _
            Throw New Exception("PlanetActivity: Le champ '_Planet' n'est pas renseigné")
        If Planet.LastActivity IsNot Nothing Then
            '' Une activité a deja été enregistré sur la planète

            If time > Planet.LastActivity.time Then
                ''La nouvelle activité est plus récente
                If cdr <> Planet.LastActivity.cdr Or _
                   OgameActivity <> Planet.LastActivity.OgameActivity Then

                End If
            End If

        End If

    End Sub
    Public Sub MakeLastActivity()
        Planet.LastActivity = Me

    End Sub

#Region "Base de donnée : Requètes SQL"
    Public ID As Integer = 0
    Public Function SQLString() As String
        If ID = 0 Then Return InsertString()
        Return UpdateString()
    End Function
    Public Function InsertString() As String
        Return "INSERT INTO PLANETACTIVITY " & _
               "(CDR,OGAMEACTIVITY,""TIME"") " & _
               "VALUES (" & _
               "        '" & cdr.Trim & "'," & _
               "        '" & OgameActivity.Trim & "'," & _
               "        '" & Me.time.ToString("yyyy-MM-dd HH:mm:ss") & "'" & _
               ")"
    End Function
    Public Function UpdateString() As String
        Return "UPDATE PLANETS SET " & _
                    """CDR""='" & cdr.Trim & "'," & _
                    """OGAMEACTIVITY""='" & OgameActivity.Trim & "'," & _
                    """TIME""='" & Me.time.ToString("yyyy-MM-dd HH:mm:ss") & "' " & _
                    "WHERE ""ID""='" & ID & "'"
    End Function
#End Region
End Class
