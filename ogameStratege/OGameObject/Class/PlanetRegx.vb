Imports System.Text.RegularExpressions

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : PlanetRegx
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Detection des rapports d'espionnages et des constructions/recherches
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class PlanetRegx
    Public Shared DataSender As String = Player.DefaultDataSender
    Public Shared Function SpyingReportMC(ByVal RawDataStr As String) As System.Text.RegularExpressions.MatchCollection

        Dim regpat As String = PatternsServer.Pattern("spyingreport").pattern
        Dim mc As MatchCollection = Regex.Matches(RawDataStr, regpat, RegexOptions.Multiline Or RegexOptions.ExplicitCapture Or RegexOptions.IgnorePatternWhitespace)
        Return mc
    End Function
    Public Shared Event OnSpyingReportDetected(ByVal Report As SpyReport)
    Public Shared Function EmpireBuildResearchDetection(ByVal rawdata As String) As spydata
        Dim retval As spydata = Nothing
        Dim pattern As String = "^\s+(?<ItemName>[^\n]+)\s\(Niveau\s(?<ItemLevel>\d+)\s\)"
        Dim mc As MatchCollection = Regex.Matches(rawdata, pattern, RegexOptions.Singleline Or RegexOptions.Multiline Or RegexOptions.IgnorePatternWhitespace)
        If mc.Count > 0 Then
            retval = New spydata
            For Each m As Match In mc
                If Not retval.setdata(m.Groups("ItemName").Value, m.Groups("ItemLevel").Value) Then
                    Console.WriteLine("MyPlanetDetection not recognized : " & m.Value)
                End If
            Next

        End If
        Return retval
    End Function
    Public Shared Function SpyingReportCol(ByVal mc As MatchCollection) As OGameObject.SpyReportCol
        Dim ret As New SpyReportCol
        For Each m As Match In mc
            Try

                Dim p As New Planet
                p.Galaxy = m.Groups("Galaxy").Value
                p.System = m.Groups("System").Value
                p.Num = m.Groups("PlanetNum").Value
                p.ReloadOrCreateFromCoords()
                p.Name = Trim(CStr(m.Groups("Planet").Value))
                If p.Owner.Name.Trim = "" Then
                    p.Owner.Name = "(unknown)"
                    p.Owner.Alliance = "(unknown)"
                    p.Owner.UpdateInsertandGetID()
                End If
                p.Update()

                Dim pr As New SpyReport
                pr.Planet = p
                pr.RawReport = m.Groups("SpyReport").Value
                pr.DataSender = DataSender
                Dim d As DateTime
                If m.Groups("Month").Value > Now.Month Then
                    d = New DateTime(Now.Year - 1, m.Groups("Month").Value, m.Groups("Day").Value, _
                                                m.Groups("Hour").Value, m.Groups("Min").Value, m.Groups("Sec").Value)
                Else
                    d = New DateTime(Now.Year, m.Groups("Month").Value, m.Groups("Day").Value, _
                                                m.Groups("Hour").Value, m.Groups("Min").Value, m.Groups("Sec").Value)
                End If

                pr.DataDate = d
                If Not pr.ReadFromPlanetIDAndDate Then
                    pr.UpdateInsertandGetID()
                    ret.Add(pr)
                    RaiseEvent OnSpyingReportDetected(pr)
                    Dim sd As New spydata(pr)
                    sd.UpdateInsertandGetID()

                End If
            Catch ex As Exception
                Static FirstError As Boolean = True
                If FirstError Then
                    Beep()
                    FirstError = False
                    Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
                End If
            End Try

        Next
        Return ret
    End Function




End Class