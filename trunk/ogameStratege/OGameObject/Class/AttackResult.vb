
Imports System.Text.RegularExpressions


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : AttackResult
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Classe de resultat de rapport de bataille
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class AttackResult
    Public cristal, metal, deuterium As Integer
    Public AttackerLostUnit, DefenderLostUnit As Integer
    Public FieldMetal, FieldCristal As Integer

    Public Sub New()

    End Sub
    Public Sub New(ByVal Rawdata As String)
        Analyse(Rawdata)
    End Sub

    Public Sub Analyse(ByVal Rawdata As String)
        Dim patternData As String = _
        "(?:(?<metal>\d+)\sunit.s\sde\sm.tal,\s(?<cristal>\d+)\sunit.s\sde\scristal\set\s(?<deuterium>\d+)\sunit.*?)?" + _
        "(?:L'attaquant\sa\sperdu\sau\stotal\s(?<attackerlostunit>[\d\.]+)\sunit.s)?" + _
        ".*?" + _
        "(?:Le\sd.fenseur\sa\sperdu\sau\stotal\s(?<defenderlostunit>[\d\.]+)\sunit)?" + _
        ".*?" + _
        "(?:d.bris\scontenant\s(?<fieldmetal>\d+)\sunit.s\sde\sm.tal\set\s(?<fieldcristal>\d+)\s)?"
        Dim m As Match = Regex.Match(Rawdata, patternData, RegexOptions.IgnorePatternWhitespace Or RegexOptions.Multiline Or RegexOptions.Singleline)
        If m.Success Then
            metal = CInt(m.Groups("metal").Value)
            cristal = CInt(m.Groups("cristal").Value)
            deuterium = CInt(m.Groups("deuterium").Value)
            AttackerLostUnit = CInt(m.Groups("attackerlostunit").Value)
            DefenderLostUnit = CInt(m.Groups("defenderlostunit").Value)
            FieldMetal = CInt(m.Groups("fieldmetal").Value)
            FieldCristal = CInt(m.Groups("fieldcristal").Value)
        End If

    End Sub
End Class