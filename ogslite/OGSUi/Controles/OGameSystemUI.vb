Imports System.Windows.Forms
Public Class OGameSystemUI
#Region " Evenements Public "

#End Region


    Private Sub SystemesLB_DrawItem(ByVal sender As Object, ByVal e As System.Windows.Forms.DrawItemEventArgs) Handles SystemesLB.DrawItem
        '' On ne dessine pas s'il y a rien
        If e.Index < 0 Then Return

        '' L'élement est il en mode selectionné ?
        Dim bSelected As Boolean = ((e.State And DrawItemState.Selected) = DrawItemState.Selected)
        '' Dessinons le fond
        e.DrawBackground()
        e.DrawFocusRectangle()

        ''
        e.Graphics.DrawString(SystemesLB.Items(e.Index), e.Font, New System.Drawing.SolidBrush(SystemesLB.ForeColor), e.Bounds.X, e.Bounds.Y)
    End Sub


    Private Sub SystemesLB_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles SystemesLB.SelectedIndexChanged

    End Sub
End Class
