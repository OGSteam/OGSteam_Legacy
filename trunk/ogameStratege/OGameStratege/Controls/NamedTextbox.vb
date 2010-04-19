Public Class NamedTextbox
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
    Public WithEvents Caption As System.Windows.Forms.Label
    Public WithEvents Value As System.Windows.Forms.TextBox
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Caption = New System.Windows.Forms.Label
        Me.Value = New System.Windows.Forms.TextBox
        Me.SuspendLayout()
        '
        'Caption
        '
        Me.Caption.Dock = System.Windows.Forms.DockStyle.Left
        Me.Caption.Location = New System.Drawing.Point(0, 0)
        Me.Caption.Name = "Caption"
        Me.Caption.Size = New System.Drawing.Size(88, 16)
        Me.Caption.TabIndex = 0
        Me.Caption.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Value
        '
        Me.Value.Dock = System.Windows.Forms.DockStyle.Fill
        Me.Value.Location = New System.Drawing.Point(88, 0)
        Me.Value.Name = "Value"
        Me.Value.Size = New System.Drawing.Size(128, 20)
        Me.Value.TabIndex = 1
        Me.Value.Text = ""
        '
        'NamedTextbox
        '
        Me.Controls.Add(Me.Value)
        Me.Controls.Add(Me.Caption)
        Me.Name = "NamedTextbox"
        Me.Size = New System.Drawing.Size(216, 16)
        Me.ResumeLayout(False)

    End Sub

#End Region

End Class
