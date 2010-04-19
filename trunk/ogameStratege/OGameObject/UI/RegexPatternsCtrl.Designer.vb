<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class RegexPatternsCtrl
    Inherits System.Windows.Forms.UserControl

    'UserControl remplace la méthode Dispose pour nettoyer la liste des composants.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Requise par le Concepteur Windows Form
    Private components As System.ComponentModel.IContainer

    'REMARQUE : la procédure suivante est requise par le Concepteur Windows Form
    'Elle peut être modifiée à l'aide du Concepteur Windows Form.  
    'Ne la modifiez pas à l'aide de l'éditeur de code.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.TableLayoutPanel1 = New System.Windows.Forms.TableLayoutPanel
        Me.lbBuildResearch = New System.Windows.Forms.Label
        Me.tbBuildResearch = New System.Windows.Forms.TextBox
        Me.TableLayoutPanel1.SuspendLayout()
        Me.SuspendLayout()
        '
        'TableLayoutPanel1
        '
        Me.TableLayoutPanel1.AutoSize = True
        Me.TableLayoutPanel1.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink
        Me.TableLayoutPanel1.CellBorderStyle = System.Windows.Forms.TableLayoutPanelCellBorderStyle.Inset
        Me.TableLayoutPanel1.ColumnCount = 2
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Absolute, 150.0!))
        Me.TableLayoutPanel1.ColumnStyles.Add(New System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 100.0!))
        Me.TableLayoutPanel1.Controls.Add(Me.lbBuildResearch, 0, 0)
        Me.TableLayoutPanel1.Controls.Add(Me.tbBuildResearch, 1, 0)
        Me.TableLayoutPanel1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.TableLayoutPanel1.Location = New System.Drawing.Point(0, 0)
        Me.TableLayoutPanel1.Name = "TableLayoutPanel1"
        Me.TableLayoutPanel1.RowCount = 2
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 11.1588!))
        Me.TableLayoutPanel1.RowStyles.Add(New System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 88.8412!))
        Me.TableLayoutPanel1.Size = New System.Drawing.Size(510, 232)
        Me.TableLayoutPanel1.TabIndex = 0
        '
        'lbBuildResearch
        '
        Me.lbBuildResearch.BackColor = System.Drawing.SystemColors.ActiveCaption
        Me.lbBuildResearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.lbBuildResearch.ForeColor = System.Drawing.SystemColors.ActiveCaptionText
        Me.lbBuildResearch.Location = New System.Drawing.Point(5, 2)
        Me.lbBuildResearch.Name = "lbBuildResearch"
        Me.lbBuildResearch.Size = New System.Drawing.Size(144, 23)
        Me.lbBuildResearch.TabIndex = 0
        Me.lbBuildResearch.Text = "HTML Batiments/Labo"
        Me.lbBuildResearch.TextAlign = System.Drawing.ContentAlignment.MiddleLeft
        '
        'tbBuildResearch
        '
        Me.tbBuildResearch.DataBindings.Add(New System.Windows.Forms.Binding("Text", Global.OGameObject.My.MySettings.Default, "BuildResearch", True, System.Windows.Forms.DataSourceUpdateMode.OnPropertyChanged))
        Me.tbBuildResearch.Dock = System.Windows.Forms.DockStyle.Top
        Me.tbBuildResearch.Location = New System.Drawing.Point(157, 5)
        Me.tbBuildResearch.Multiline = True
        Me.tbBuildResearch.Name = "tbBuildResearch"
        Me.tbBuildResearch.Size = New System.Drawing.Size(348, 19)
        Me.tbBuildResearch.TabIndex = 1
        Me.tbBuildResearch.Text = Global.OGameObject.My.MySettings.Default.BuildResearch
        '
        'RegexPatternsCtrl
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.AutoScroll = True
        Me.Controls.Add(Me.TableLayoutPanel1)
        Me.Name = "RegexPatternsCtrl"
        Me.Size = New System.Drawing.Size(510, 232)
        Me.TableLayoutPanel1.ResumeLayout(False)
        Me.TableLayoutPanel1.PerformLayout()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents TableLayoutPanel1 As System.Windows.Forms.TableLayoutPanel
    Friend WithEvents lbBuildResearch As System.Windows.Forms.Label
    Friend WithEvents tbBuildResearch As System.Windows.Forms.TextBox

End Class
