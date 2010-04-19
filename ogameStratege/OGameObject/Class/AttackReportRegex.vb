Imports System.Text.RegularExpressions

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : AttackreportRegex
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''   Detection des rapports de battailles
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class AttackreportRegex
    Public Shared AttackPattern As String = _
        "(?<AttackReport>Les\sflottes\ssuivantes\sse\strouvent\s.\s(?<Month>[\d]+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)" & _
        ".*?" & _
        "Attaquant\s(?<Attacker>[^\n]+)\s+\((?<AttackPlanet>(?<aGalaxy>[\d]+)\:(?<aSystem>[\d]+)\:(?<aPlanetNum>[\d]+))\)" & _
        ".*?" & _
        "D.fenseur\s(?<Defender>[^\n]+)\s+\((?<DefenderPlanet>(?<dGalaxy>[\d]+)\:(?<dSystem>[\d]+)\:(?<dPlanetNum>[\d]+))\).*)"
    Public Shared AttackPattern2 As String = _
    PatternsServer.Pattern("attackreport").pattern
    
    Public Shared Function AttackReportMatch(ByVal RAWDATA As String) As Match

        Return Regex.Match(RAWDATA, AttackPattern2, RegexOptions.IgnorePatternWhitespace Or RegexOptions.Singleline)

    End Function
    Public Shared Event OnAttackDetected(ByVal Report As AttackReport)
    Public Shared Function AttackReportDetect(ByVal RAWDATA As String) As AttackReport
        If RAWDATA Is Nothing OrElse RAWDATA Is String.Empty Then Return Nothing
        Dim m As Match = AttackReportMatch(RAWDATA)

        If Not m.Success Then Return Nothing
        With m
            Dim ar As New AttackReport
            Dim attg As Integer = m.Groups("aGalaxy").Value
            Dim atts As Integer = m.Groups("aSystem").Value
            Dim attn As Integer = m.Groups("aPlanetNum").Value

            ar.AttackerPlanet = Planet.FromCoords(attg, atts, attn)
            If ar.AttackerPlanet Is Nothing Then
                Dim planet As New Planet
                planet.Galaxy = attg
                planet.System = atts
                planet.Num = attn
                planet.Owner = Player.FromName(m.Groups("Attacker").Value)
                If planet.Owner Is Nothing Then
                    planet.Owner = Player.CreatePlayer(m.Groups("Attacker").Value, "*FromAttack*")

                End If

                If planet.Name.Length = 0 Then planet.Name = "*FromAttack*"
                planet.Update()
                ar.AttackerPlanet = planet

            End If
            'Mise a jour du possesseur de la planète si non rempli
            If ar.AttackerPlanet.Owner Is Nothing OrElse ar.AttackerPlanet.Owner.ID = 0 Then
                ar.AttackerPlanet.Owner = Player.FromName(m.Groups("Attacker").Value)
                If ar.AttackerPlanet.Owner Is Nothing Then
                    ar.AttackerPlanet.Owner = Player.CreatePlayer(m.Groups("Attacker").Value, "*FromAttack*")
                End If
                ar.AttackerPlanet.Update()
            End If

            Dim defg As Integer = m.Groups("dGalaxy").Value
            Dim defs As Integer = m.Groups("dSystem").Value
            Dim defn As Integer = m.Groups("dPlanetNum").Value

            ar.DefenderPlanet = Planet.FromCoords(defg, defs, defn)
            If ar.DefenderPlanet Is Nothing Then
                Dim planet As New Planet
                planet.Galaxy = defg
                planet.System = defs
                planet.Num = defn
                planet.Owner = Player.FromName(m.Groups("Defender").Value)
                If planet.Owner Is Nothing Then
                    planet.Owner = Player.CreatePlayer(m.Groups("Defender").Value, "*FromAttack*")
                End If
                If planet.Name.Length = 0 Then planet.Name = "*FromAttack*"
                planet.Update()
                ar.DefenderPlanet = planet
            End If
            If ar.DefenderPlanet.Owner Is Nothing OrElse ar.DefenderPlanet.Owner.ID = 0 Then
                ar.DefenderPlanet.Owner = Player.FromName(m.Groups("Defender").Value)
                If ar.DefenderPlanet.Owner Is Nothing Then
                    ar.DefenderPlanet.Owner = Player.CreatePlayer(m.Groups("Defender").Value, "*FromAttack*")
                End If
                ar.DefenderPlanet.Update()
            End If

            Dim d As DateTime = New DateTime(Now.Year, m.Groups("Month").Value, m.Groups("Day").Value, _
                                                       m.Groups("Hour").Value, m.Groups("Min").Value, m.Groups("Sec").Value)
            ar.DataDate = d
            ar.RawReport = m.Groups("AttackReport").Value
            ar.Create()
            RaiseEvent OnAttackDetected(ar)
            Return ar
        End With

    End Function

End Class