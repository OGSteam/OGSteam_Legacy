Imports System.Text.RegularExpressions



''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : GalaxyRegX
''' 
''' -----------------------------------------------------------------------------
''' <summary>
'''     Detection des systemes presse papiers et distant (ogspy)
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class GalaxyRegX

    Public Shared GalaxyDetectPattern As String = _
        PatternsServer.Pattern("galaxycoord").pattern

    Public Shared GalaxyPlanetListPattern As String = _
        PatternsServer.Pattern("galaxyplanet").pattern

    Public Shared Function GalaxyDetected(ByVal RAWDATA As String) As Boolean
        Return Regex.Match(RAWDATA, GalaxyDetectPattern).Success
    End Function
    Public Shared Event OnGalaxyUpdate(ByVal Gal As Galaxy)
    Public Shared Sub GalaxyFromRemoteServer(ByVal rawdata As String)
        Dim Planets() As String = rawdata.Split("§")
        Dim gala As Integer, syst As Integer
        For Each planetdata As String In Planets
            If planetdata.Length > 10 Then
                Dim p As Planet = OGameObject.Planet.FromRemoteDBData(planetdata)
                If Not p Is Nothing Then
                    gala = p.Galaxy
                    syst = p.System
                End If
            End If
        Next
        If gala <> 0 And syst <> 0 Then
            Dim g As New Galaxy
            g.Galaxy = gala
            g.System = syst
            g.DataSender = "Server"
            g.DataDate = Now
            g.UpdateCreate()
            RaiseEvent OnGalaxyUpdate(g)
        End If
    End Sub
    Public Shared Function GalaxyFromHtml(ByVal Document As System.Windows.Forms.HtmlDocument) As Galaxy
        Try
            Dim Gal As Galaxy
            Gal = New Galaxy

            Gal.Galaxy = Document.GetElementById("galaxy_form").GetElementsByTagName("input")(3).GetAttribute("value")
            Gal.System = Document.GetElementById("galaxy_form").GetElementsByTagName("input")(6).GetAttribute("value")
            For i As Integer = 2 To 16
                'Gestion Planète
                Dim KnownPlanet As Boolean = True
                Dim toupdate As Boolean = False
                '' La planète existe-t-elle en BDD ?
                Dim p As Planet = Planet.FromCoords(Gal.Galaxy, Gal.System, i - 1)
                If p Is Nothing Then
                    p = New Planet
                    p.Galaxy = Gal.Galaxy
                    p.System = Gal.System
                    p.Num = i - 1
                    p.Update()
                    KnownPlanet = False
                End If
                
                With Document.GetElementsByTagName("table")(4).GetElementsByTagName("TR")(i).GetElementsByTagName("TH")
                    Dim PlanetName As String = ""


                    If .Item(2).InnerText IsNot Nothing Then
                        If .Item(2).InnerText.IndexOf("(") > 0 Then
                            PlanetName = .Item(2).InnerText.Substring(0, .Item(2).InnerText.IndexOf("(") - 1).Trim
                        Else
                            PlanetName = .Item(2).InnerText
                        End If
                    
                    End If
                    If p.Name <> PlanetName Then
                        toupdate = True
                        If KnownPlanet Then
                            If PlanetName.Trim <> "" Then
                                OGameDBEngine.NewEventInformation("Changement de nom de planète en  " & p.Coords & " : " & p.Name & " -> " & PlanetName, Functions.enOGSEventType.Unclassified)
                            Else
                                OGameDBEngine.NewEventInformation("Disparition de la planète en  " & p.Coords & " : " & p.Name & " n'existe plus.", Functions.enOGSEventType.Unclassified)
                            End If

                        End If

                        p.Name = PlanetName

                    End If
                    If (p.Moon = "" And .Item(3).InnerHtml IsNot Nothing) OrElse (p.Moon.Trim <> "" And .Item(3).InnerHtml Is Nothing) Then
                        toupdate = True
                        p.Moon = IIf(.Item(3).InnerHtml IsNot Nothing, "M", "")
                        If KnownPlanet Then OGameDBEngine.NewEventInformation("** Modification de LUNE **  (" & IIf(p.Moon.Trim <> "", "creation", "destruction") & ") sur " & p.Name & " [ " & p.Coords & " ]", Functions.enOGSEventType.MoonChanged)
                    End If

                    p.DataSender = Player.DefaultDataSender
                    p.DataDate = Now
                    If p.Name.Trim = "" Then

                    End If

                End With
                Dim Playername As String = ""
                Dim Playerstatus As String = ""
                Dim playeralliance As String = ""
                Dim PlayerToUpdate As Boolean = False
                'Gestion Joueur
                With Document.GetElementsByTagName("table")(4).GetElementsByTagName("TR")(i).GetElementsByTagName("TH")
                    'Nom de joueur présent ?
                    If .Item(5).InnerText IsNot Nothing AndAlso .Item(5).InnerText.Trim.Length > 0 Then
                        Dim PlayerPattern As String = "^(?<Playername>.*?)\x20+(?:\((?<Status>[iIvfdbC\x20]+)\)?)"
                        Dim m As Match = Regex.Match(.Item(5).InnerText.Trim, PlayerPattern)

                        If m.Success Then
                            Playername = m.Groups("Playername").Value
                            Playerstatus = m.Groups("Status").Value
                        Else
                            Playername = .Item(5).InnerText.Trim
                            Playerstatus = ""
                        End If
                        If .Item(6).InnerText IsNot Nothing AndAlso .Item(6).InnerText.Trim.Length > 0 Then
                            playeralliance = .Item(6).InnerText.Trim
                        End If

                        Dim pla As Player = Player.FromName(Playername)



                        If pla Is Nothing Then 'Nom non trouvé
                            If p.Owner.Name.Trim <> "" Then
                                If p.Owner.Alliance = playeralliance Then
                                    OGameObject.OGameDBEngine.NewEventInformation("Changement de nom de joueur (?): " & Playername & " [ " & playeralliance & "] was " & p.Owner.Name & " on " & p.Coords, Functions.enOGSEventType.PlayerUpdated)
                                    If OGameDBEngine.Default.Universe.PlayerChangeDetectionKeepData = UniverseDB.enDefaultValue.Ask Then
                                        If System.Windows.Forms.MessageBox.Show(MainAppForm, p.Owner.Name & " a t-il changé de nom ? Découverte du joueur " & Playername & " sur la planète " & p.Coords & vbCrLf & "Voulez-vous associer les données de ce joueur, à celles de l'ancien propriétaire ?", "Changement de nom ou Nouveau propriétaire", Windows.Forms.MessageBoxButtons.YesNo) = MsgBoxResult.Yes Then
                                            p.Owner.Name = Playername
                                            pla = p.Owner
                                            PlayerToUpdate = True
                                            GoTo PlayerOk
                                        End If
                                    ElseIf OGameDBEngine.Default.Universe.PlayerChangeDetectionKeepData = UniverseDB.enDefaultValue.Yes Then
                                        p.Owner.Name = Playername
                                        pla = p.Owner
                                        PlayerToUpdate = True
                                        GoTo PlayerOk
                                    End If
                                End If
                            End If

                            PlayerToUpdate = True

                            pla = Player.CreatePlayer(Playername, playeralliance)
                            pla.DataDate = Now
                        Else 'Changement d'alliance mais meme nom de joueur

                            If pla.Alliance <> playeralliance Then
                                PlayerToUpdate = True

                                OGameObject.OGameDBEngine.NewEventInformation("Changement d'Alliance : " & pla.Name & " était " & IIf(pla.Alliance.Trim = "", "sans alliance ", " [" & pla.Alliance & "] ") & IIf(playeralliance <> "", "a rejoint [" & playeralliance & "]", "a quitté son alliance"), Functions.enOGSEventType.PlayerChangeAlly)
                                pla.Alliance = playeralliance
                            End If
                        End If
playerok:
                        p.Owner = pla
                        Dim StatusFound As Boolean = False
                        If Playerstatus <> "" Then
                            StatusFound = True
                            If p.Owner.ShortInactive <> (Playerstatus.IndexOf("i") > -1) Then
                                PlayerToUpdate = True
                                p.Owner.ShortInactive = (Playerstatus.IndexOf("i") > -1)
                                p.Owner.Note &= "Changement status Inactivité le " & Now.ToShortDateString & " en " & IIf(p.Owner.ShortInactive, "+i", "-i") & vbCrLf
                                OGameObject.OGameDBEngine.NewEventInformation("Detection de joueur inactif: " & pla.Name & " [ " & pla.Alliance & "] en " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                                If p.Owner.ShortInactive Then
                                    OGameObject.OGameDBEngine.NewEventInformation("Detection d'inactifs : " & pla.Name & " [ " & pla.Alliance & "] en " & p.Coords, Functions.enOGSEventType.NewInactivePlayer)
                                End If
                            End If
                            If p.Owner.LongInactive <> Playerstatus.IndexOf("I") > -1 Then
                                PlayerToUpdate = True
                                p.Owner.LongInactive = Playerstatus.IndexOf("I") > -1
                                p.Owner.Note &= "Changement d'inactivité longue le " & Now.ToShortDateString & " en " & IIf(p.Owner.LongInactive, "+I", "-I") & vbCrLf
                            End If
                            If p.Owner.Blocked <> Playerstatus.IndexOf("b") > -1 Then
                                PlayerToUpdate = True
                                p.Owner.Blocked = Playerstatus.IndexOf("b") > -1
                                p.Owner.Note &= "Changement de blocage le " & Now.ToShortDateString & " en " & IIf(p.Owner.Blocked, "+b", "-b") & vbCrLf
                                OGameObject.OGameDBEngine.NewEventInformation("Changement de blocage : " & IIf(p.Owner.Blocked, "Bloqué", "Débloqué") & " " & pla.Name & " [ " & pla.Alliance & "] on " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If
                            If p.Owner.Noob <> Playerstatus.IndexOf("d") > -1 Then
                                PlayerToUpdate = True
                                p.Owner.Noob = Playerstatus.IndexOf("d") > -1
                                p.Owner.Note &= "Changement de protection noob le  " & Now.ToShortDateString & " en " & IIf(p.Owner.Blocked, "+d", "-d") & vbCrLf
                                OGameObject.OGameDBEngine.NewEventInformation("Changement de protection noob en " & IIf(p.Owner.Noob, "Noob", "n'est plus noob") & " " & pla.Name & " [ " & pla.Alliance & "] on " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If
                            If p.Owner.Vacancy <> Playerstatus.IndexOf("v") > -1 Then
                                PlayerToUpdate = True
                                p.Owner.Vacancy = Playerstatus.IndexOf("v") > -1
                                p.Owner.Note &= "Changement Mode Vacance le " & Now.ToShortDateString & " en " & IIf(p.Owner.Vacancy, "+v", "-v") & vbCrLf
                                OGameObject.OGameDBEngine.NewEventInformation("Changement Mode Vacance : " & IIf(p.Owner.Vacancy, "Passage en mode vacance", "Sort du mode vacance") & " " & pla.Name & " [ " & pla.Alliance & "] en " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If


                            If Not StatusFound AndAlso (p.Owner.ShortInactive OrElse p.Owner.LongInactive) Then
                                PlayerToUpdate = True
                                p.Owner.Note &= "Redevenu actif le " & Now.ToShortDateString
                                p.Owner.LongInactive = False
                                p.Owner.ShortInactive = False
                                OGameObject.OGameDBEngine.NewEventInformation("Suppression du status inactif : " & pla.Name & " [ " & pla.Alliance & "] en " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If
                            If Not StatusFound AndAlso (p.Owner.Vacancy) Then
                                PlayerToUpdate = True
                                p.Owner.Note &= "Sort du mode vacance le " & Now.ToShortDateString & vbCrLf
                                p.Owner.Vacancy = False

                                OGameObject.OGameDBEngine.NewEventInformation("Sortie du mode vacance : " & pla.Name & " [ " & pla.Alliance & "] en " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If
                            If Not StatusFound AndAlso (p.Owner.Noob) Then
                                PlayerToUpdate = True
                                p.Owner.Note &= "Suppression du mode protection noob le " & Now.ToShortDateString & vbCrLf
                                p.Owner.Noob = False

                                OGameObject.OGameDBEngine.NewEventInformation("Suppression du mode protection noob: " & pla.Name & " [ " & pla.Alliance & "] on " & p.Coords, Functions.enOGSEventType.PlayerStatusChanged)
                            End If
                            If PlayerToUpdate Then
                                p.Owner.DataDate = Now
                                p.Owner.DataSender = Player.DefaultDataSender
                                p.Owner.UpdateInsertandGetID()
                            End If
                        End If
                        
                    End If
                    If Playername = "" Then p.Owner = New Player
                    p.Update()
                    Gal.Planets.Add(p)

                    'End If
                    If PlayerToUpdate Then
                        p.Owner.DataDate = Now
                        p.Owner.DataSender = Player.DefaultDataSender
                        p.Owner.UpdateInsertandGetID()
                    End If
                End With

            Next
            Gal.UpdateCreate()
            RaiseEvent OnGalaxyUpdate(Gal)
            Return Gal
        Catch ex As Exception
            'MsgBox("Erreur: " & ex.Message)
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try
    End Function


End Class