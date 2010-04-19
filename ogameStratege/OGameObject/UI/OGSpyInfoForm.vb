Public Class OGSpyInfoForm

    Private pInfo As OGSpyInfo
    Public Property Info() As OGSpyInfo
        Get
            Return pInfo
        End Get
        Set(ByVal value As OGSpyInfo)
            pInfo = value
            If value IsNot Nothing Then
                With value
                    tbServerName.Text = .ServerName
                    tbServerVersion.Text = .ServerVersion
                    tbExportSpy.Text = IIf(.ExportSpyAuth, "Oui", "Non")
                    tbExportStat.Text = IIf(.ExportRankAuth, "Oui", "Non")
                    tbExportSys.Text = IIf(.ExportSysAuth, "Oui", "Non")
                    tbImportSpy.Text = IIf(.ImportSpyAuth, "Oui", "Non")
                    tbImportStat.Text = IIf(.ImportRankAuth, "Oui", "Non")
                    tbImportSys.Text = IIf(.ImportSysAuth, "Oui", "Non")
                End With
            End If
        End Set
    End Property

    Private Sub btnQuit_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnQuit.Click
        Me.Close()
    End Sub
End Class