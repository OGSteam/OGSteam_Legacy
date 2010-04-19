Imports System.Text.RegularExpressions


''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : FleetCommandRegx
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''  Detection des retours de flottes
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class FleetCommandRegx

    Public Shared FleetCommandPattern As String = _
        PatternsServer.Pattern("fleetreturn").pattern
    '"^\s*(?<Month>\d+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)\s+Commandement\sde\sflot[^\n]*\s*Retour\sde\sflotte\s*(?<Data>.*?)$"
    '"^\s*(?<Month>\d+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)\s+Surveillance\sespace\s*Activité\sde\sespionnage[^\n\r]*\s*(?<Data>.*?)$"
    Public Shared Event OnFleetCommandCreate(ByVal FC As FleetCommand)
    Public Shared Function FleetCommandSearch(ByVal Rawdata As String) As FleetCommandCol
        Dim retval As New FleetCommandCol
        Dim mc As MatchCollection = Regex.Matches(Rawdata, FleetCommandPattern, RegexOptions.Multiline Or RegexOptions.IgnorePatternWhitespace)
        For Each m As Match In mc
            Dim d As DateTime = New DateTime(Now.Year, m.Groups("Month").Value, m.Groups("Day").Value, _
                                                                  m.Groups("Hour").Value, m.Groups("Min").Value, m.Groups("Sec").Value)
            Dim fc As FleetCommand = FleetCommand.FromDateExist(d)
            If fc Is Nothing Then
                fc = New FleetCommand
                fc.DataDate = d
                fc.RawReport = m.Groups("Data").Value
                fc.Create()
                retval.Add(fc)
                RaiseEvent OnFleetCommandCreate(fc)
            End If
        Next
        Return retval
    End Function

End Class
