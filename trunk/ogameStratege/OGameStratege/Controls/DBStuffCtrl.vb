Imports System.Xml.Serialization
Imports System.IO
Imports System.Text.RegularExpressions
Public Class DBStuffCtrl
    Inherits System.Windows.Forms.UserControl

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'UserControl overrides dispose to clean up the component list.
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    Friend WithEvents panUp As System.Windows.Forms.Panel
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Splitter1 As System.Windows.Forms.Splitter
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents rtbSQLQuery As System.Windows.Forms.RichTextBox
    Friend WithEvents dgSQLResult As System.Windows.Forms.DataGrid
    Friend WithEvents cbSQLTemplates As System.Windows.Forms.ComboBox
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents btnSave As System.Windows.Forms.Button
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents cbTableName As System.Windows.Forms.ComboBox
    Friend WithEvents btnShowTable As System.Windows.Forms.Button
    Friend WithEvents btnStopRequest As System.Windows.Forms.Button
    Friend WithEvents ContextMenu1 As System.Windows.Forms.ContextMenu
    Friend WithEvents labTime As System.Windows.Forms.Label
    Friend WithEvents Timer1 As System.Windows.Forms.Timer
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(DBStuffCtrl))
        Me.panUp = New System.Windows.Forms.Panel
        Me.rtbSQLQuery = New System.Windows.Forms.RichTextBox
        Me.cbSQLTemplates = New System.Windows.Forms.ComboBox
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.Button2 = New System.Windows.Forms.Button
        Me.btnSave = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.Label1 = New System.Windows.Forms.Label
        Me.Splitter1 = New System.Windows.Forms.Splitter
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.labTime = New System.Windows.Forms.Label
        Me.cbTableName = New System.Windows.Forms.ComboBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.btnStopRequest = New System.Windows.Forms.Button
        Me.btnShowTable = New System.Windows.Forms.Button
        Me.dgSQLResult = New System.Windows.Forms.DataGrid
        Me.ContextMenu1 = New System.Windows.Forms.ContextMenu
        Me.MenuItem1 = New System.Windows.Forms.MenuItem
        Me.Timer1 = New System.Windows.Forms.Timer(Me.components)
        Me.panUp.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.Panel1.SuspendLayout()
        CType(Me.dgSQLResult, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'panUp
        '
        Me.panUp.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.panUp.Controls.Add(Me.rtbSQLQuery)
        Me.panUp.Controls.Add(Me.cbSQLTemplates)
        Me.panUp.Controls.Add(Me.Panel2)
        Me.panUp.Controls.Add(Me.Label1)
        resources.ApplyResources(Me.panUp, "panUp")
        Me.panUp.Name = "panUp"
        '
        'rtbSQLQuery
        '
        resources.ApplyResources(Me.rtbSQLQuery, "rtbSQLQuery")
        Me.rtbSQLQuery.Name = "rtbSQLQuery"
        '
        'cbSQLTemplates
        '
        resources.ApplyResources(Me.cbSQLTemplates, "cbSQLTemplates")
        Me.cbSQLTemplates.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        Me.cbSQLTemplates.Name = "cbSQLTemplates"
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.Button2)
        Me.Panel2.Controls.Add(Me.btnSave)
        Me.Panel2.Controls.Add(Me.Button4)
        Me.Panel2.Controls.Add(Me.Button3)
        Me.Panel2.Controls.Add(Me.Button1)
        resources.ApplyResources(Me.Panel2, "Panel2")
        Me.Panel2.Name = "Panel2"
        '
        'Button2
        '
        resources.ApplyResources(Me.Button2, "Button2")
        Me.Button2.Name = "Button2"
        '
        'btnSave
        '
        resources.ApplyResources(Me.btnSave, "btnSave")
        Me.btnSave.Name = "btnSave"
        '
        'Button4
        '
        resources.ApplyResources(Me.Button4, "Button4")
        Me.Button4.Name = "Button4"
        '
        'Button3
        '
        resources.ApplyResources(Me.Button3, "Button3")
        Me.Button3.Name = "Button3"
        '
        'Button1
        '
        resources.ApplyResources(Me.Button1, "Button1")
        Me.Button1.Name = "Button1"
        '
        'Label1
        '
        resources.ApplyResources(Me.Label1, "Label1")
        Me.Label1.Name = "Label1"
        '
        'Splitter1
        '
        Me.Splitter1.BackColor = System.Drawing.SystemColors.Highlight
        resources.ApplyResources(Me.Splitter1, "Splitter1")
        Me.Splitter1.Name = "Splitter1"
        Me.Splitter1.TabStop = False
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.labTime)
        Me.Panel1.Controls.Add(Me.cbTableName)
        Me.Panel1.Controls.Add(Me.Label2)
        Me.Panel1.Controls.Add(Me.btnStopRequest)
        Me.Panel1.Controls.Add(Me.btnShowTable)
        resources.ApplyResources(Me.Panel1, "Panel1")
        Me.Panel1.Name = "Panel1"
        '
        'labTime
        '
        resources.ApplyResources(Me.labTime, "labTime")
        Me.labTime.Name = "labTime"
        '
        'cbTableName
        '
        Me.cbTableName.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
        resources.ApplyResources(Me.cbTableName, "cbTableName")
        Me.cbTableName.Items.AddRange(New Object() {resources.GetString("cbTableName.Items"), resources.GetString("cbTableName.Items1")})
        Me.cbTableName.Name = "cbTableName"
        '
        'Label2
        '
        resources.ApplyResources(Me.Label2, "Label2")
        Me.Label2.Name = "Label2"
        '
        'btnStopRequest
        '
        Me.btnStopRequest.BackColor = System.Drawing.Color.Firebrick
        resources.ApplyResources(Me.btnStopRequest, "btnStopRequest")
        Me.btnStopRequest.ForeColor = System.Drawing.Color.Gainsboro
        Me.btnStopRequest.Name = "btnStopRequest"
        Me.btnStopRequest.UseVisualStyleBackColor = False
        '
        'btnShowTable
        '
        resources.ApplyResources(Me.btnShowTable, "btnShowTable")
        Me.btnShowTable.Name = "btnShowTable"
        '
        'dgSQLResult
        '
        Me.dgSQLResult.AlternatingBackColor = System.Drawing.Color.LightGray
        Me.dgSQLResult.BackColor = System.Drawing.Color.Gainsboro
        Me.dgSQLResult.BackgroundColor = System.Drawing.Color.Silver
        Me.dgSQLResult.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.dgSQLResult.CaptionBackColor = System.Drawing.Color.LightSteelBlue
        resources.ApplyResources(Me.dgSQLResult, "dgSQLResult")
        Me.dgSQLResult.CaptionForeColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLResult.CaptionVisible = False
        Me.dgSQLResult.DataMember = ""
        Me.dgSQLResult.FlatMode = True
        Me.dgSQLResult.ForeColor = System.Drawing.Color.Black
        Me.dgSQLResult.GridLineColor = System.Drawing.Color.DimGray
        Me.dgSQLResult.GridLineStyle = System.Windows.Forms.DataGridLineStyle.None
        Me.dgSQLResult.HeaderBackColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLResult.HeaderFont = New System.Drawing.Font("Microsoft Sans Serif", 8.0!)
        Me.dgSQLResult.HeaderForeColor = System.Drawing.Color.White
        Me.dgSQLResult.LinkColor = System.Drawing.Color.MidnightBlue
        Me.dgSQLResult.Name = "dgSQLResult"
        Me.dgSQLResult.ParentRowsBackColor = System.Drawing.Color.DarkGray
        Me.dgSQLResult.ParentRowsForeColor = System.Drawing.Color.Black
        Me.dgSQLResult.SelectionBackColor = System.Drawing.Color.CadetBlue
        Me.dgSQLResult.SelectionForeColor = System.Drawing.Color.White
        '
        'ContextMenu1
        '
        Me.ContextMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 0
        resources.ApplyResources(Me.MenuItem1, "MenuItem1")
        '
        'Timer1
        '
        '
        'DBStuffCtrl
        '
        Me.ContextMenu = Me.ContextMenu1
        Me.Controls.Add(Me.dgSQLResult)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.Splitter1)
        Me.Controls.Add(Me.panUp)
        Me.Name = "DBStuffCtrl"
        resources.ApplyResources(Me, "$this")
        Me.panUp.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        CType(Me.dgSQLResult, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

#End Region

    Public ReadOnly Property DB() As OGameObject.OGameDBEngine
        Get
            Return OGameObject.OGameDBEngine.Default
        End Get
    End Property
    Private Sub doExecuteRequest(ByVal state As Object)
        labTime.BackColor = Color.Red
        'Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
        Application.DoEvents()
        Dim AlteredQuery As String = ""
        Dim pattern As String = "(?<all>{(?<ChangeThat>[^}]+)})"


        With Regex.Matches(rtbSQLQuery.Text, pattern)
            If .Count Then
                AlteredQuery = rtbSQLQuery.Text
                For i As Integer = 0 To .Count - 1

                    Dim changewith As String = InputBox(.Item(i).Groups("ChangeThat").Value, "Please enter a value")
                    If changewith.Length Then
                        AlteredQuery = AlteredQuery.Replace(.Item(i).Groups("all").Value, changewith)
                    End If
                Next
            End If
        End With
        Try
            If AlteredQuery.Length Then
                'MessageBox.Show(MainForm.TopForm, AlteredQuery)
                dgSQLResult.SetDataBinding(OGameObject.OGameDBEngine.Default.SQLCommand(AlteredQuery), "")
            Else
                dgSQLResult.SetDataBinding(OGameObject.OGameDBEngine.Default.SQLCommand(rtbSQLQuery.Text), "")
            End If

        Catch ex As Exception
            MessageBox.Show(MainForm.TopForm, "Error: " & ex.Message)
            Console.WriteLine(ex.Message & vbCrLf & ex.StackTrace)
        End Try
        'btnStopRequest.Enabled = False
        'Me.Cursor = System.Windows.Forms.Cursors.Default
        labTime.BackColor = SystemColors.Control

        Timer1.Stop()
        Dim Duration As TimeSpan = Now.Subtract(StartTime)
        labTime.Text = Duration.Minutes & " min " & Duration.Seconds & " secs " & Duration.Milliseconds
    End Sub

    Private pStartTime As DateTime
    Public Property StartTime() As DateTime
        Get
            Return pStartTime
        End Get
        Set(ByVal value As DateTime)
            pStartTime = value
        End Set
    End Property

    Private pEndTime As Date
    Public Property EndTime() As Date
        Get
            Return pEndTime
        End Get
        Set(ByVal value As Date)
            pEndTime = value
        End Set
    End Property

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If OGameObject.OGameDBEngine.Default Is Nothing Then
            MessageBox.Show(MainForm.TopForm, "La base de données n'est pas ouverte")
            Return
        End If
        If rtbSQLQuery.Text = "" Then
            MessageBox.Show(MainForm.TopForm, "Il n'y a pas de requête SQL. Attention, ne fais pas n'importe quoi avec cette partie du logiciel, tu peux tout casser !")
            Return
        End If
        'btnStopRequest.Enabled = True
        pStartTime = Now
        Timer1.Enabled = True
        Me.doExecuteRequest(Nothing)

    End Sub

    Private Sub DBStuffCtrl_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles MyBase.Load
        For Each o As Object In SQLTemplateCol.Templates
            cbSQLTemplates.Items.Add(o)
        Next
        If cbSQLTemplates.Items.Count > 0 Then
            cbSQLTemplates.SelectedIndex = 0
        End If
    End Sub

    Private Sub cbSQLTemplates_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbSQLTemplates.SelectedIndexChanged
        If cbSQLTemplates.SelectedItem Is Nothing Then Return
        rtbSQLQuery.Text = CType(cbSQLTemplates.SelectedItem, SQLTemplate).SQLQuery
        btnSave.Enabled = False
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        Dim st As New SQLTemplate
        st.Caption = InputBox("Choose a title for you SQL Snippet", "New SQL Command", "(New SQL Snippet)")
        If st.Caption.Length > 0 Then
            cbSQLTemplates.Items.Add(st)
            cbSQLTemplates.SelectedItem = st
            Application.DoEvents()
            rtbSQLQuery.Focus()
        End If
    End Sub
    Private d As ShowStructureFrm = Nothing
    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        If d Is Nothing Then
            d = New ShowStructureFrm
            d.Show()
        Else
            d.Close()
            d = Nothing
        End If
    End Sub

    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSave.Click
        SQLTemplateCol.Templates.Clear()
        CType(cbSQLTemplates.SelectedItem, SQLTemplate).SQLQuery = rtbSQLQuery.Text
        For Each s As Object In cbSQLTemplates.Items
            SQLTemplateCol.Templates.Add(s)
        Next
        SQLTemplateCol.Templates.XMLSerialize()
    End Sub

    Private Sub rtbSQLQuery_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles rtbSQLQuery.TextChanged
        btnSave.Enabled = True
    End Sub


    Private Sub cbTableName_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles cbTableName.SelectedIndexChanged
        If cbTableName.SelectedItem Is Nothing Then
            btnShowTable.Enabled = False
        End If
        btnShowTable.Enabled = True

    End Sub

    Private Sub btnShowTable_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnShowTable.Click
        'mainform.TopForm.Universes1.
        Me.Cursor = System.Windows.Forms.Cursors.WaitCursor
        Dim da As New FirebirdSql.Data.FirebirdClient.FbDataAdapter("SELECT * FROM " & cbTableName.SelectedItem, OGameObject.OGameDBEngine.Default.DBConnection)
        Dim dp As New DataTable(cbTableName.SelectedItem)
        da.Fill(dp)
        dgSQLResult.SetDataBinding(dp, "")
        Me.Cursor = System.Windows.Forms.Cursors.Default
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        If cbSQLTemplates.SelectedItem Is Nothing Then Return
        If MessageBox.Show(MainForm.TopForm, "Are you sure you want to remove this template ?", "SQL Template deletion confirmation", MessageBoxButtons.YesNo, MessageBoxIcon.Exclamation) = DialogResult.No Then Return
        cbSQLTemplates.Items.Remove(cbSQLTemplates.SelectedItem)
        SQLTemplateCol.Templates.Clear()
        rtbSQLQuery.Text = ""
        'CType(cbSQLTemplates.SelectedItem, SQLTemplate).SQLQuery = rtbSQLQuery.Text
        For Each s As Object In cbSQLTemplates.Items
            SQLTemplateCol.Templates.Add(s)
        Next
        SQLTemplateCol.Templates.XMLSerialize()
    End Sub

    Private Sub MenuItem1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem1.Click
        If OGameObject.OGameDBEngine.Default Is Nothing Then
            MessageBox.Show(MainForm.TopForm, "La base de données n'est pas ouverte")
            Return
        End If
        If rtbSQLQuery.Text = "" Then
            MessageBox.Show(MainForm.TopForm, "Il n'y a pas de requête SQL. Attention, ne fais pas n'importe quoi avec cette partie du logiciel, tu peux tout casser !")
            Return
        End If
        'btnStopRequest.Enabled = True
        Me.doExecuteRequest(Nothing)
    End Sub

    Private Sub DBStuffCtrl_KeyUp(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles MyBase.KeyUp
        If e.KeyCode = Keys.F5 Then MsgBox("F5")
    End Sub

    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        Dim Duration As TimeSpan = Now.Subtract(StartTime)
        labTime.Text = Duration.Minutes & " min " & Duration.Seconds & " secs " & Duration.Milliseconds
        Application.DoEvents()
    End Sub
End Class

<Serializable()> Public Class SQLTemplate
    Public Caption As String
    Public SQLQuery As String
    Public Overrides Function ToString() As String
        Return Caption
    End Function
End Class
' {[?WHERE GALAXY='(?Galaxie)']}
<Serializable()> Public Class SQLTemplateCol
    Inherits CollectionBase

    Private Shared pTemplates As SQLTemplateCol = Nothing
    Public Shared ReadOnly Property Templates() As SQLTemplateCol
        Get
            If Not pTemplates Is Nothing Then Return pTemplates
            pTemplates = XMLDeSerialize()
            If pTemplates.Count = 0 Then
                Dim ST As New SQLTemplate
                ST.Caption = "Number of planets / Nombre de planetes"
                ST.SQLQuery = "SELECT COUNT(*) AS PlanetCount FROM planets;"
                pTemplates.Add(ST)

                ST = New SQLTemplate
                ST.Caption = "Planets with Moon"
                ST.SQLQuery = "SELECT * FROM Planets WHERE moon='M'"
                pTemplates.Add(ST)

                ST = New SQLTemplate
                ST.Caption = "Players Rank with Change"
                ST.SQLQuery = "select P.NAME, PR.RANK, P.ALLIANCE, PR.POINTS, cast(PR.DATADATE as varchar(40)) as adate from PLAYERS P, PLAYERSRANK PR where (PR.player_id = P.ID) ORDER BY UPPER(NAME) ASC, PR.DATADATE DESC"
                pTemplates.Add(ST)


                ST = New SQLTemplate
                ST.Caption = "Last Player Points Statistics only"
                ST.SQLQuery = "SELECT cast(Rk.datadate as varchar(40)), p.name, rk.rank, rk.points from playersrank rk " & _
                              "left join players p on p.id=rk.player_id WHERE rk.datadate=(SELECT max(datadate) from playersrank)"
                pTemplates.Add(ST)


                ST = New SQLTemplate
                ST.Caption = "All fields in the current Firebird Database"
                ST.SQLQuery = _
                    "SELECT a.RDB$RELATION_NAME, b.RDB$FIELD_NAME, b.RDB$FIELD_ID, d.RDB$TYPE_NAME," & _
                    " c.RDB$FIELD_LENGTH, c.RDB$FIELD_SCALE" & _
                    " FROM   RDB$RELATIONS a" & _
                    " INNER JOIN RDB$RELATION_FIELDS b" & _
                    " ON     a.RDB$RELATION_NAME = b.RDB$RELATION_NAME" & _
                    " INNER JOIN RDB$FIELDS c" & _
                    " ON     b.RDB$FIELD_SOURCE = c.RDB$FIELD_NAME" & _
                    " INNER JOIN RDB$TYPES d" & _
                    " ON     c.RDB$FIELD_TYPE = d.RDB$TYPE" & _
                    " WHERE  a.RDB$SYSTEM_FLAG = 0" & _
                    " AND  d.RDB$FIELD_NAME = 'RDB$FIELD_TYPE'" & _
                    " ORDER BY a.RDB$RELATION_NAME, b.RDB$FIELD_ID "
                pTemplates.Add(ST)

            End If
            Return pTemplates
        End Get
    End Property


    Default Public Property Item(ByVal index As Integer) As SQLTemplate
        Get
            Return CType(List(index), SQLTemplate)
        End Get
        Set(ByVal Value As SQLTemplate)
            List(index) = Value
        End Set
    End Property
    Public Function Add(ByVal value As SQLTemplate) As Integer
        Return List.Add(value)
    End Function 'Add
    Public Function IndexOf(ByVal value As SQLTemplate) As Integer
        Return List.IndexOf(value)
    End Function 'IndexOf
    Public Sub Insert(ByVal index As Integer, ByVal value As SQLTemplate)
        List.Insert(index, value)
    End Sub 'Insert
    Public Sub Remove(ByVal value As SQLTemplate)
        List.Remove(value)
    End Sub 'Remove
    Public Function XMLSerialize(Optional ByVal XMLFilePathName As String = "") As Boolean
        Try
            ' Create a new XmlSerializer instance.
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "sql_templates.xml")

            End If

            Dim s As New Xml.Serialization.XmlSerializer(GetType(SQLTemplateCol))

            ' Writing the XML file to disk requires a TextWriter.
            Dim writer As New StreamWriter(XMLFilePathName)

            ' Serialize the object, and close the StreamWriter.
            s.Serialize(writer, Me)
            writer.Close()
            Return True
        Catch x As System.InvalidOperationException
            System.Windows.Forms.MessageBox.Show(MainForm.TopForm, x.Message)
            Throw New Exception("UniversesDB serialization", x)
        End Try
    End Function
    Public Shared Function XMLDeSerialize(Optional ByVal XMLFilePathName As String = "") As SQLTemplateCol
        Try
            If XMLFilePathName = "" Then
                XMLFilePathName = System.IO.Path.Combine(System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly.Location()), "sql_templates.xml")
            End If
            If IO.File.Exists(XMLFilePathName) Then
                Dim fs As New IO.FileStream(XMLFilePathName, FileMode.Open)
                Dim w As New Xml.Serialization.XmlSerializer(GetType(SQLTemplateCol))
                Dim g As SQLTemplateCol = CType(w.Deserialize(fs), SQLTemplateCol)

                fs.Close()
                Return g
            End If
        Catch x As Exception

        End Try
        Return New SQLTemplateCol
    End Function
End Class