﻿'------------------------------------------------------------------------------
' <auto-generated>
'     Ce code a été généré par un outil.
'     Version du runtime :2.0.50727.832
'
'     Les modifications apportées à ce fichier peuvent provoquer un comportement incorrect et seront perdues si
'     le code est régénéré.
' </auto-generated>
'------------------------------------------------------------------------------

Option Strict On
Option Explicit On

Imports System

Namespace My.Resources
    
    'Cette classe a été générée automatiquement par la classe StronglyTypedResourceBuilder
    'à l'aide d'un outil, tel que ResGen ou Visual Studio.
    'Pour ajouter ou supprimer un membre, modifiez votre fichier .ResX, puis réexécutez ResGen
    'avec l'option /str ou régénérez votre projet VS.
    '''<summary>
    '''  Une classe de ressource fortement typée destinée, entre autres, à la consultation des chaînes localisées.
    '''</summary>
    <Global.System.CodeDom.Compiler.GeneratedCodeAttribute("System.Resources.Tools.StronglyTypedResourceBuilder", "2.0.0.0"),  _
     Global.System.Diagnostics.DebuggerNonUserCodeAttribute(),  _
     Global.System.Runtime.CompilerServices.CompilerGeneratedAttribute(),  _
     Global.Microsoft.VisualBasic.HideModuleNameAttribute()>  _
    Friend Module Resources
        
        Private resourceMan As Global.System.Resources.ResourceManager
        
        Private resourceCulture As Global.System.Globalization.CultureInfo
        
        '''<summary>
        '''  Retourne l'instance ResourceManager mise en cache utilisée par cette classe.
        '''</summary>
        <Global.System.ComponentModel.EditorBrowsableAttribute(Global.System.ComponentModel.EditorBrowsableState.Advanced)>  _
        Friend ReadOnly Property ResourceManager() As Global.System.Resources.ResourceManager
            Get
                If Object.ReferenceEquals(resourceMan, Nothing) Then
                    Dim temp As Global.System.Resources.ResourceManager = New Global.System.Resources.ResourceManager("OGameObject.Resources", GetType(Resources).Assembly)
                    resourceMan = temp
                End If
                Return resourceMan
            End Get
        End Property
        
        '''<summary>
        '''  Remplace la propriété CurrentUICulture du thread actuel pour toutes
        '''  les recherches de ressources à l'aide de cette classe de ressource fortement typée.
        '''</summary>
        <Global.System.ComponentModel.EditorBrowsableAttribute(Global.System.ComponentModel.EditorBrowsableState.Advanced)>  _
        Friend Property Culture() As Global.System.Globalization.CultureInfo
            Get
                Return resourceCulture
            End Get
            Set
                resourceCulture = value
            End Set
        End Property
        
        Friend ReadOnly Property _41_ico_1() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("41_ico_1", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property ADD_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("ADD_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property applications_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("applications_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property arrow_back_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("arrow_back_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property arrow_down_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("arrow_down_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property arrow_forward_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("arrow_forward_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property arrow_up_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("arrow_up_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property computer_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("computer_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property COPY_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("COPY_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property delete_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("delete_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property download1glaze_f() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("download1glaze_f", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property forbid() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("forbid", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property mail_glaze_f() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("mail_glaze_f", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Recherche une chaîne localisée semblable à &lt;!--\sServername\s=\s(?&lt;servername&gt;.*?)\s--&gt;
        '''.*?
        '''&lt;!--\sServerVersion\s=\s(?&lt;serverVersion&gt;.*?)\s--&gt;
        '''.*
        '''\[ExportSysAuth=(?&lt;ExportSysAuth&gt;\d)\]
        '''.*
        '''\[ImportSysAuth=(?&lt;ImportSysAuth&gt;\d)\]
        '''.*
        '''\[ExportSpyAuth=(?&lt;ExportSpyAuth&gt;\d)\]
        '''.*
        '''\[ImportSpyAuth=(?&lt;ImportSpyAuth&gt;\d)\]
        '''.*
        '''\[ExportRankAuth=(?&lt;ExportRankAuth&gt;\d)\]
        '''.*
        '''\[ImportRankAuth=(?&lt;ImportRankAuth&gt;\d)\]
        '''.
        '''</summary>
        Friend ReadOnly Property ogspy_info_regx() As String
            Get
                Return ResourceManager.GetString("ogspy_info_regx", resourceCulture)
            End Get
        End Property
        
        '''<summary>
        '''  Recherche une chaîne localisée semblable à [Login=0].
        '''</summary>
        Friend ReadOnly Property ogspy_loginfailed() As String
            Get
                Return ResourceManager.GetString("ogspy_loginfailed", resourceCulture)
            End Get
        End Property
        
        '''<summary>
        '''  Recherche une chaîne localisée semblable à [Login=1].
        '''</summary>
        Friend ReadOnly Property ogspy_loginsuccess() As String
            Get
                Return ResourceManager.GetString("ogspy_loginsuccess", resourceCulture)
            End Get
        End Property
        
        Friend ReadOnly Property ogsteam_small() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("ogsteam_small", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property radiation_nila_f() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("radiation_nila_f", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property redo_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("redo_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property run_left_32() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("run_left_32", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property run_right_32() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("run_right_32", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property SAVE_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("SAVE_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property settings_nila_f() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("settings_nila_f", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        Friend ReadOnly Property undo_24() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("undo_24", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Recherche une chaîne localisée semblable à .
        '''</summary>
        Friend ReadOnly Property update_sql_3_to_4() As String
            Get
                Return ResourceManager.GetString("update_sql_3_to_4", resourceCulture)
            End Get
        End Property
        
        Friend ReadOnly Property upload1_glaze_f() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("upload1_glaze_f", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
    End Module
End Namespace
