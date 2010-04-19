Public Class OgspyAccountsForm

    Private Sub OgspyAccountsForm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Dim DBAccount As UniversesDBCol = UniversesDBCol.Load
        If DBAccount.Count Then
            For Each Account As UniverseDB In DBAccount
                For Each RAC As RemoteAccount In Account.RemoteAccounts
                    'ListBox1.Items.Add(RAC.ToString & " - " & Account.ToString)
                    ListBox1.Items.Add(RAC)
                Next
            Next
        End If
    End Sub
    Public RemoteAccountSelected As RemoteAccount
    Private Sub ListBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox1.SelectedIndexChanged
        btnOk.Enabled = ListBox1.SelectedItem IsNot Nothing
        Try
            RemoteAccountSelected = ListBox1.SelectedItem
        Catch ex As Exception

        End Try
    End Sub
End Class