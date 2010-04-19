''' <summary>
''' Classe d'accés aux Données Alliances
''' </summary>
''' <remarks>01/06/2006  ericalens - Création</remarks>
Public Class Ally

#Region " Definition des types de relation de l'alliance "

    ''' <summary>
    '''  Diplomatique , différents type de statut
    ''' </summary>
    ''' <remarks></remarks>
    Public Enum enRelationType
        Unknown = 0
        Guerre = 1
        Commercial = 2
        PacteTotal = 3
        PacteNonAggression = 4
        Autres = 5
    End Enum

   
#End Region

#Region " Propriétés "

    Private pID As Integer
    ''' <summary>
    ''' Identificateur en base de données locale
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property ID() As Integer
        Get
            Return pID
        End Get
        Set(ByVal value As Integer)
            pID = value
        End Set
    End Property

    Private pName As String
    ''' <summary>
    ''' Nom de l'alliance
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property Name() As String
        Get
            Return pName
        End Get
        Set(ByVal value As String)
            pName = value
        End Set
    End Property


    Private pAlliancePage As String
    ''' <summary>
    ''' Site de l'alliance
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property AlliancePage() As String
        Get
            Return pAlliancePage
        End Get
        Set(ByVal value As String)
            pAlliancePage = value
        End Set
    End Property


    Private pBoardPage As String
    ''' <summary>
    ''' Forums de l'alliance
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property BoardPage() As String
        Get
            Return pBoardPage
        End Get
        Set(ByVal value As String)
            pBoardPage = value
        End Set
    End Property


    Private pDataDate As Date
    ''' <summary>
    ''' Date de saisie
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property DataDate() As Date
        Get
            Return pDataDate
        End Get
        Set(ByVal value As Date)
            pDataDate = value
        End Set
    End Property


    Private pDataSender As String
    ''' <summary>
    ''' Nom de l'utilisateur ayant saisi l'alliance
    ''' </summary>
    ''' <value></value>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Property DataSender() As String
        Get
            Return pDataSender
        End Get
        Set(ByVal value As String)
            pDataSender = value
        End Set
    End Property


    Private pRelationType As enRelationType
    Public Property RelationType() As enRelationType
        Get
            Return pRelationType
        End Get
        Set(ByVal value As enRelationType)
            pRelationType = value
        End Set
    End Property

#End Region

#Region " Constructeurs "
    ''' <summary>
    ''' Constructeur par défaut
    ''' </summary>
    ''' <remarks>Envoyeur = Player.defautdatasender, et relationtype=Unknown</remarks>
    Public Sub New()
        pRelationType = enRelationType.Unknown
        pDataSender = Player.DefaultDataSender
        pDataDate = Now
    End Sub
#End Region

#Region " Accés Base de données "

    ''' <summary>
    ''' Lecture dans la base à partir d'un ID
    ''' </summary>
    ''' <param name="dbID"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Shared Function FromID(ByVal dbID As Integer) As Ally
        Return Nothing
    End Function

    ''' <summary>
    ''' Recherche et lecture à partir d'un nom d'alliance
    ''' </summary>
    ''' <param name="AllyName"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Shared Function FromName(ByVal AllyName As String) As Ally
        Return Nothing
    End Function


    ''' <summary>
    ''' Sauvegarde/Insertion en base de données
    ''' </summary>
    ''' <returns>Resultat de l'insertion/sauvegarde. False=Erreur</returns>
    ''' <remarks></remarks>
    Function SaveInsert() As Boolean
        Return False
    End Function


#End Region

#Region " Recherche des informations liés "
    ''' <summary>
    ''' Joueurs appartenant a l'alliance
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function Players() As PlayerCol
        Return Nothing
    End Function

    ''' <summary>
    ''' Dernière statistique connue d'un type donnée
    ''' </summary>
    ''' <param name="stattype">Type de stat</param>
    ''' <returns>Nothing si aucune</returns>
    ''' <remarks></remarks>
    Public Function LastStat(ByVal stattype As AllyRank.enStatType) As AllyRank
        Return Nothing
    End Function

    ''' <summary>
    ''' Planètes des joueurs de l'alliance
    ''' </summary>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function Planets() As PlanetCol
        Return Nothing
    End Function

    ''' <summary>
    ''' Relation diplomatique avec une autre alliance
    ''' </summary>
    ''' <param name="Alliance"></param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function RelationWith(ByVal Alliance As Ally) As enRelationType
        Return enRelationType.Unknown
    End Function

    ''' <summary>
    ''' Liste des alliances avec diplomatie connu
    ''' </summary>
    ''' <param name="RelType">Type de relation recherché ou nothing pour toutes</param>
    ''' <returns></returns>
    ''' <remarks></remarks>
    Public Function DiplomaticIssue(Optional ByVal RelType As enRelationType = Nothing) As AllyCol
        Return Nothing
    End Function


#End Region

End Class
