
''' -----------------------------------------------------------------------------
''' Project	 : OGameObject
''' Class	 : ConstantsVersion
''' 
''' -----------------------------------------------------------------------------
''' <summary>
''' Classe avec methodes shareable pour les constantes globales
''' </summary>
''' <remarks>
''' </remarks>
''' <history>
''' 	[eric]	26/04/2006	Created
''' </history>
''' -----------------------------------------------------------------------------
Public Class ConstantsVersion
    ''' -----------------------------------------------------------------------------
    ''' <summary>
    ''' Numéro de version global d'OGS
    ''' </summary>
    ''' <remarks>
    ''' Sous la forme "AAMMJJ" (Année/Mois/Jour)
    ''' </remarks>
    ''' <history>
    ''' 	[eric]	26/04/2006	Created
    ''' </history>
    ''' -----------------------------------------------------------------------------
    Public Shared ReadOnly OGSVersion As String = "071010+dev"
    Public Shared DB_CHARSET As String = "ISO8859_1"

End Class
