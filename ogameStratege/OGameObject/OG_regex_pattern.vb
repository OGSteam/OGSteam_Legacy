Imports System.IO
Imports System.Xml.Serialization
Imports System.Xml
Imports System.Text.RegularExpressions

''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : PatternsServer
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Template regular expressions de detections de données ogame
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class PatternsServer
    Public Shared ReadOnly DefaultPattern() As String = { _
                                              "playerstatistic_html", _
                                              "playerstatistic", _
                                              "spyingreport", _
                                              "galaxyplanet", _
                                              "attackreport", _
                                              "galaxycoord", _
                                              "fleetreturn", _
                                              "ennemyspy", _
                                              "alliancestatistic"}
    Private Shared pDefaultTemplate As Boolean = True
    Public Shared Property DefaultTemplate() As Boolean
        Get
            Return pDefaultTemplate
        End Get
        Set(ByVal Value As Boolean)
            pDefaultTemplate = Value
        End Set
    End Property
    Private Shared planguage As Regex_Pattern.enlanguage = Regex_Pattern.enlanguage.fr
    Public Shared Property language() As Regex_Pattern.enlanguage
        Get
            Return planguage
        End Get
        Set(ByVal Value As Regex_Pattern.enlanguage)
            planguage = Value
        End Set
    End Property

    Private pPatternsCols As Regex_PatternCol = Nothing
    Public ReadOnly Property PatternsCol() As Regex_PatternCol
        Get
            If pPatternsCols Is Nothing Then
                pPatternsCols = New Regex_PatternCol
            End If
            Return pPatternsCols
            'return Default_Regex_PatternFR(
        End Get
    End Property

    Protected Shared DefPatternFrCol As Regex_PatternCol = Nothing
    Public Shared Function Pattern(ByVal devname As String, Optional ByVal lang As Regex_Pattern.enlanguage = Regex_Pattern.enlanguage.defaut) As Regex_Pattern
        Return Default_Regex_PatternFR(devname)
    End Function
    Public Shared Function Default_Regex_PatternFR(ByVal devname As String) As Regex_Pattern
        If DefPatternFrCol Is Nothing Then
            DefPatternFrCol = New Regex_PatternCol
            For Each defdevname As String In DefaultPattern

                Dim patt As New Regex_Pattern
                patt.language = Regex_Pattern.enlanguage.fr
                patt.devname = defdevname.ToLower
                patt.regexoption = RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture
                Select Case patt.devname
                    Case "playerstatistic_html"
                        patt.pattern = "<tr>\s+<th>(?<Place>\d+)&nbsp;&nbsp;" + _
                                       ".*?<\/th>" + _
                                       ".*?" + _
                                       "<th>(?:<font.*?>)?(?<Name>[^\<]*?)<" + _
                                       ".*?" + _
                                       "<th" + _
                                       ".*?" + _
                                       "<th.*?allytag.*?>\s*(?<Alliance>[^\<]*?)<" + _
                                       ".*?" + _
                                       "<th>(?<Points>[\d.]+)<"
                        patt.regexoption = RegexOptions.Singleline Or patt.regexoption Or RegexOptions.IgnorePatternWhitespace
                    Case "playerstatistic"
                        patt.pattern = "^(?<Place>\d+)\s+[+–*]\s+(?<Name>[^\n]*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(?<Alliance>[^\n]*?)?[ \t]+(?<Points>[\d.]+)(?:[\s]*$)"
                    Case "spyingreport"
                        patt.pattern = "(?<SpyReport>Mati.res\spremi.res\ssur(?<Planet>.*?)\s\[(?<PlanetCoords>(?<Galaxy>[\d]+):(?<System>[\d]+):(?<PlanetNum>[\d]+))\]\sle\s(?<Month>[\d]+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)[^%]*Probabilit.\sde\sdestruction\sde\sla\sflotte\sd[\\]?'espionnage\s:(?<ContreEspio>\d+)%)"
                        patt.regexoption = RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture Or RegexOptions.IgnorePatternWhitespace
                    Case "galaxycoord"
                        patt.pattern = "Syst.me.solaire?.(?<Galaxy>\d)\:(?<System>\d+)"
                    Case "galaxyplanet"
                        'patt.pattern = "^(?<PlanetNum>\d+)\s*(?:(?<Moon>M))?(?:[ ]+)(?:(?<Debris>T)?)(?:[ \t ]*\[(?<Ally>[^\n\]]+)\])?(?:[ ])?(?:(?<PlanetName>[^\n]*)[ ]\((?<PlayerName>[^\n\(]*)(?:\((?<Status>[iIg]+)\)?)?.?\))?"
                        patt.pattern = "^(?<PlanetNum>\d+)\s\x09" + _
                            "(?:(?:\x09(?<PlanetName>[^\n\x09\(]*)\x20)(?:\((?:[^\)]+)\))?|(?:\x20+))" + _
                            "(?:(?:\x09(?<Moon>M)\x20\x09)|(?:[\x20\x09]+))?" + _
                            "(?:\x09*(?<PlayerName>[^\x20][^\x09\n\(]+)(?:\x20\((?<Status>[^\)]+)\))?)?" + _
                            "\x20\x09(?<Ally>[^\x20][^\n\x09]+)?" + _
                            "[^\n]+$"
                    Case "attackreport"
                        patt.pattern = _
                        "(?<AttackReport>Les\sflottes\ssuivantes\sse\ssont\saffront.es\sle\s(?<Month>[\d]+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)" & vbCrLf & _
                        ".*?" & vbCrLf & _
                        "Attaquant\s(?<Attacker>[^\n]+)\s+\((?<AttackPlanet>(?<aGalaxy>[\d]+)\:(?<aSystem>[\d]+)\:(?<aPlanetNum>[\d]+))\)" & vbCrLf & _
                        ".*?" & vbCrLf & _
                        "D.fenseur\s(?<Defender>[^\n]+)\s+\((?<DefenderPlanet>(?<dGalaxy>[\d]+)\:(?<dSystem>[\d]+)\:(?<dPlanetNum>[\d]+))\).*)"
                        patt.regexoption = RegexOptions.IgnorePatternWhitespace Or RegexOptions.Singleline
                    Case "fleetreturn"
                        patt.pattern = _
                            "^\s*(?<Month>\d+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)\s+" & vbCrLf & _
                            "(?:(?<from>Quartier.g.n.ral)[^\n]*\s*(?<subject>Retour.de.flotte))" & vbCrLf & _
                            "\s*(?<Data>.*?)$"
                        patt.regexoption = RegexOptions.Multiline Or RegexOptions.IgnorePatternWhitespace
                    Case "ennemyspy"
                        patt.pattern = _
                           "^\s*(?<Month>\d+)-(?<Day>[\d]+)\s+(?<Hour>[\d]+)\:(?<Min>[\d]+)\:(?<Sec>[\d]+)\s+" + _
                           "(?:(?<from>Contr.le.a.rospatial)[^\n]*\s*(?<subject>Activit..d'espionnage))     \s*(?<Data>.*?de.la.plan.te\s(?<FromName>[^[]+)\s\[(?<FromCoords>[\d:]+)\].*?" + _
                           "de.votre.plan.te.(?<ToName>[^[]+)\s\[(?<ToCoords>[\d:]+)\].*?" + _
                           ")$"
                        patt.regexoption = RegexOptions.IgnoreCase Or RegexOptions.Multiline Or RegexOptions.ExplicitCapture Or RegexOptions.IgnorePatternWhitespace
                    Case "alliancestatistic"
                        patt.pattern = "^(?<rank>\d+)\s+[\+\–\*]\s+" & _
                                       "(?<Name>.*?)(?<membres>\d+)\s*(?<total>\d+)\s*(?<parmembre>\d+)"
                End Select

                DefPatternFrCol.Add(patt)
            Next
        End If
        For Each p As Regex_Pattern In DefPatternFrCol
            If p.devname = devname.ToLower AndAlso p.language = Regex_Pattern.enlanguage.fr Then
                Return p
            End If
        Next
        Return Nothing
    End Function
End Class

<Serializable()> Public Class Regex_Pattern
    Public Enum enlanguage
        defaut
        fr
        org
        it
        es
        sk
    End Enum
    Public language As enlanguage
    Public devname As String
    Public pattern As String
    Public regexoption As System.Text.RegularExpressions.RegexOptions
End Class

<Serializable()> Public Class Regex_PatternCol
    Inherits CollectionBase
    'public function LocalizedPattern(devname as String,language as 
    Default Public Property Item(ByVal index As Integer) As Regex_Pattern
        Get
            Return CType(List(index), Regex_Pattern)
        End Get
        Set(ByVal Value As Regex_Pattern)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As Regex_Pattern) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As Regex_Pattern) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As Regex_Pattern)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As Regex_Pattern)
        List.Remove(value)
    End Sub 'Remove

    Public Function XMLSerialize(ByVal XMLFilePathName As String) As Boolean
        Try
            ' Create a new XmlSerializer instance.
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "detect.xml")
            End If

            Dim s As New Xml.Serialization.XmlSerializer(GetType(Regex_PatternCol))

            ' Writing the XML file to disk requires a TextWriter.
            Dim writer As New StreamWriter(XMLFilePathName)

            ' Serialize the object, and close the StreamWriter.
            s.Serialize(writer, Me)
            writer.Close()
            Return True
        Catch x As System.InvalidOperationException
            System.Windows.Forms.MessageBox.Show(x.Message)
            Throw New Exception("Template", x)
        End Try
    End Function
    Public Shared Function XMLDeSerialize(ByVal XMLFilePathName As String) As Regex_PatternCol
        Try
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "detect.xml")
            End If

            Dim fs As New IO.FileStream(XMLFilePathName, FileMode.Open)
            Dim w As New Xml.Serialization.XmlSerializer(GetType(Regex_PatternCol))
            Dim g As Regex_PatternCol = CType(w.Deserialize(fs), Regex_PatternCol)

            fs.Close()
            Return g

        Catch x As Exception
            Windows.Forms.MessageBox.Show(x.Message & vbCrLf & x.StackTrace)
            'Throw New Exception("Account deserialization error", x)
        End Try
        Return Nothing
    End Function

End Class


