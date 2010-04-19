Public Class WebChannelMessageCtrl


    Private pCssStyle As String = _
    "#header {background: black;color:yellow}" & _
    "#messages {background: yellow;color: black;padding-right:3px;}"
    Public Property CssStyle() As String
        Get
            Return pCssStyle
        End Get
        Set(ByVal value As String)
            pCssStyle = value

        End Set
    End Property

    Private WithEvents pChannel As IRCChannel
    Public Property Channel() As IRCChannel
        Get
            Return pChannel
        End Get
        Set(ByVal value As IRCChannel)
            pChannel = value

            If value Is Nothing Then Return

        End Set
    End Property
    Public ReadOnly Property Header() As System.Windows.Forms.HtmlElement
        Get
            Return WebBrowser1.Document.GetElementById("header")
        End Get
    End Property
    Public ReadOnly Property Messages() As System.Windows.Forms.HtmlElement
        Get
            Return WebBrowser1.Document.GetElementById("messages")
        End Get
    End Property
    '    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
    '        If TextBox1.Text.Length = 0 Then Return
    '    Dim NewDocLine As System.Windows.Forms.HtmlElement'
    '
    '        NewDocLine = WebBrowser1.Document.CreateElement("div")
    '        NewDocLine.SetAttribute("class", "ircmsg")
    '        NewDocLine.InnerText = TextBox1.Text
    '        WebBrowser1.Document.GetElementById("messages").AppendChild(NewDocLine)

    'End Sub

    Public Sub New()

        ' Cet appel est requis par le Concepteur Windows Form.
        InitializeComponent()

        ' Ajoutez une initialisation quelconque après l'appel InitializeComponent().
        Console.WriteLine("BaseDirectory: " & AppDomain.CurrentDomain.BaseDirectory)
        If System.IO.File.Exists(AppDomain.CurrentDomain.BaseDirectory & "channel.css") Then
            Console.WriteLine("Reading " & AppDomain.CurrentDomain.BaseDirectory & "channel.css")
            pCssStyle = System.IO.File.ReadAllText(AppDomain.CurrentDomain.BaseDirectory & "channel.css")
            Console.WriteLine(pCssStyle)
        End If
    End Sub

    Private Sub CreateDocument()
        Console.WriteLine("CreateDocument()")
        If WebBrowser1.Document.GetElementById("header") Is Nothing Then
            WebBrowser1.Navigate("about:blank")
            Console.WriteLine("Navigate")
            WebBrowser1.Document.Write("<html><head><style>" & CssStyle & "</style></head><body><div id='header'><div id='channelname'></div><div id='channeltopic'></div></div><div id='messages'></div><div id='footer'></div></body></html>")
            Console.WriteLine("Document write")
        End If
    End Sub
    Private Sub WebBrowser1_DocumentCompleted(ByVal sender As Object, ByVal e As System.Windows.Forms.WebBrowserDocumentCompletedEventArgs) Handles WebBrowser1.DocumentCompleted
        'CssStyle = about:<head></head><body><div id='header' style='background: black;'></div><div id='messages'></div></body>
        Console.WriteLine("DocumentCompleted")
        CreateDocument()
        UpdateChannelInfo()
        'WebBrowser1.Document.GetElementById("header").InnerText = "Header de la fenètre"
        'MsgBox(WebBrowser1.Document.All(1).InnerHtml) <-- le style
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        MsgBox(WebBrowser1.DocumentText)
    End Sub
    ''' <summary>
    ''' Met a jout les informations (topic/nom) du channel dans le composant web
    ''' </summary>
    ''' <remarks></remarks>
    Public Sub UpdateChannelInfo()
        Console.WriteLine("UpdateChannelInfo start")
        If Channel Is Nothing Then Return
        If Header Is Nothing Then CreateDocument()
        Header.Children("channelname").InnerText = Channel.ChannelName
        Header.Children("channeltopic").InnerText = Channel.Topic
        Console.WriteLine("Topic/name Set")
    End Sub
    Private Delegate Sub _AddUserMessage(ByVal User As String, ByVal message As String)
    Public Sub AddUserMessage(ByVal User As String, ByVal message As String)
        If WebBrowser1 Is Nothing Then Return
        If Me.InvokeRequired Then
            Dim d As New _AddUserMessage(AddressOf Me.AddUserMessage)
            Me.Invoke(d, New Object() {User, message})
            Exit Sub
        End If
        Dim NewDocLine As System.Windows.Forms.HtmlElement

        NewDocLine = WebBrowser1.Document.CreateElement("div")
        NewDocLine.SetAttribute("class", "ircmsg")

        Dim UserEl As System.Windows.Forms.HtmlElement = WebBrowser1.Document.CreateElement("span")
        UserEl.SetAttribute("class", "sender")
        UserEl.InnerText = User
        NewDocLine.AppendChild(UserEl)
        Dim MsgEl As System.Windows.Forms.HtmlElement = WebBrowser1.Document.CreateElement("span")
        MsgEl.SetAttribute("class", "message")
        MsgEl.InnerText = message
        NewDocLine.AppendChild(MsgEl)
        Messages.AppendChild(NewDocLine)
        WebBrowser1.Update()
    End Sub
    Private Delegate Sub _AddInfoMessage(ByVal message As String, ByVal css_class As String, ByVal UseInnerHtml As Boolean)

    Public Sub AddInfoMessage(ByVal message As String, Optional ByVal css_class As String = "info", Optional ByVal UseInnerHtml As Boolean = False)
        If Me.InvokeRequired Then
            Dim d As New _AddInfoMessage(AddressOf Me.AddInfoMessage)
            Me.Invoke(d, New Object() {message, css_class, UseInnerHtml})
            Exit Sub
        End If
        Dim NewDocLine As System.Windows.Forms.HtmlElement
        Try
            NewDocLine = WebBrowser1.Document.CreateElement("div")
            NewDocLine.SetAttribute("class", css_class)
            If UseInnerHtml Then
                NewDocLine.InnerHtml = message
            Else
                NewDocLine.InnerText = message
            End If
            Messages.AppendChild(NewDocLine)
            WebBrowser1.Update()
        Catch e As Exception
        End Try

    End Sub
    Private Sub pChannel_OnMessage(ByVal sender As Object, ByVal e As IRCChannelMessageEvent) Handles pChannel.OnMessage
        AddUserMessage(e.RawMessage.sendernick, e.UserMessage)
    End Sub

    Private Sub PromptLineCB_KeyUp(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles PromptLineCB.KeyUp
        If e.KeyCode = System.Windows.Forms.Keys.Enter Then
            SendTextBtn_Click(Nothing, Nothing)
            e.SuppressKeyPress = True
        End If
    End Sub

    Private Sub SendTextBtn_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles SendTextBtn.Click
        If PromptLineCB.Text.Length <= 0 Then Return
        Channel.Server.SendMessage("PRIVMSG " & Channel.ChannelName & " :" & PromptLineCB.Text)
        AddUserMessage(Channel.Server.Nick, PromptLineCB.Text)
        'AddTextColor(Channel.Server.Nick & ">> ", Drawing.Color.Green)
        'AddMessage(PromptingTextbox.Text)
        PromptLineCB.Text = ""
    End Sub

    Private Sub pChannel_OnNotice(ByVal sender As Object, ByVal e As IRCChannelMessageEvent) Handles pChannel.OnNotice
        AddInfoMessage(e.UserMessage, "notice")
    End Sub

    Private Sub pChannel_OnUserJoin(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserJoin
        AddInfoMessage(e.User.Nick & " a rejoint " & e.Channel.ChannelName, "join")
    End Sub

    Private Sub pChannel_OnUserPart(ByVal sender As Object, ByVal e As UserJoinEventArgs) Handles pChannel.OnUserPart
        AddInfoMessage(e.User.Nick & " a quitté " & e.Channel.ChannelName & " (PART)", "part")
    End Sub

    Private Sub pChannel_OnUserQuit(ByVal sender As Object, ByVal e As UserQuitEventArgs) Handles pChannel.OnUserQuit
        AddInfoMessage(e.User.Nick & " a quitté " & e.Channel.ChannelName & " (QUIT)", "quit")
    End Sub

    Private Sub VoirLeSourceToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles VoirLeSourceToolStripMenuItem.Click
        MsgBox(WebBrowser1.DocumentText)
    End Sub

    Private Sub RechargerLeStyleToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RechargerLeStyleToolStripMenuItem.Click
        If System.IO.File.Exists(AppDomain.CurrentDomain.BaseDirectory & "channel.css") Then
            pCssStyle = System.IO.File.ReadAllText(AppDomain.CurrentDomain.BaseDirectory & "channel.css")
        End If
        Dim SaveDoc As String = WebBrowser1.Document.Body.InnerHtml
        WebBrowser1.Document.OpenNew(True)
        WebBrowser1.Navigate("about:blank")
        WebBrowser1.Document.Write("<html><head><style>" & CssStyle & "</style></head><body><div id='header'><div id='channelname'></div><div id='channeltopic'></div></div><div id='messages'></div><div id='footer'></div></body></html>")
        WebBrowser1.Document.Body.InnerHtml = SaveDoc
    End Sub
End Class
