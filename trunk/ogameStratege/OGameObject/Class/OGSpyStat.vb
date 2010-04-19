''' <summary>
''' Disponibilité des statistiques d'ogspy aprés interprétation
''' des données renvoyés par OGSpy.GetStatsInfo()
''' </summary>
''' <remarks></remarks>
Public Class OGSpyStat
    Public [Date] As Date
    Public Points As Boolean = False
    Public Flotte As Boolean = False
    Public Research As Boolean = False
    Public Overrides Function ToString() As String
        Return Me.Date & _
              IIf(Points, " - Points", "") & _
              IIf(Flotte, " - Flotte", "") & _
              IIf(Research, " - Research", "")
    End Function
    Public Sub New()

    End Sub
    Public Sub New(ByVal vdate As Date, ByVal vPoints As Boolean, ByVal vFlotte As Boolean, ByVal vResearch As Boolean)
        Me.Date = vdate
        Me.Points = vPoints
        Me.Flotte = vFlotte
        Me.Research = vResearch
    End Sub
End Class
