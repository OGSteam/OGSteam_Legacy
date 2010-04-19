namespace OgameFarmingInterface
{
    partial class Form1
    {
        /// <summary>
        /// Variable nécessaire au concepteur.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Nettoyage des ressources utilisées.
        /// </summary>
        /// <param name="disposing">true si les ressources managées doivent être supprimées ; sinon, false.</param>
        protected override void Dispose( bool disposing )
        {
            if ( disposing && (components != null) )
            {
                components.Dispose();
            }
            base.Dispose( disposing );
        }

        #region Code généré par le Concepteur Windows Form

        /// <summary>
        /// Méthode requise pour la prise en charge du concepteur - ne modifiez pas
        /// le contenu de cette méthode avec l'éditeur de code.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            System.Windows.Forms.ListViewGroup listViewGroup1 = new System.Windows.Forms.ListViewGroup( "ListViewGroup", System.Windows.Forms.HorizontalAlignment.Left );
            System.Windows.Forms.ListViewGroup listViewGroup2 = new System.Windows.Forms.ListViewGroup( "ListViewGroup", System.Windows.Forms.HorizontalAlignment.Left );
            System.Windows.Forms.ListViewGroup listViewGroup3 = new System.Windows.Forms.ListViewGroup( "ListViewGroup", System.Windows.Forms.HorizontalAlignment.Left );
            System.Windows.Forms.ListViewGroup listViewGroup4 = new System.Windows.Forms.ListViewGroup( "ListViewGroup", System.Windows.Forms.HorizontalAlignment.Left );
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( Form1 ) );
            this.statusStrip1 = new System.Windows.Forms.StatusStrip();
            this.toolStripStatusLabel1 = new System.Windows.Forms.ToolStripStatusLabel();
            this.listViewResultats = new System.Windows.Forms.ListView();
            this.columnHeader_Nom = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_Coordonnees = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_Metal = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_Cristal = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_Deuterium = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_NombreGT = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_NombrePT = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_ChampsDeRuinesPotentiel = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_Defenses = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_DefsLegeres = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_DefsMoyennes = new System.Windows.Forms.ColumnHeader();
            this.columnHeader_DefsLourdes = new System.Windows.Forms.ColumnHeader();
            this.contextMenuStripMenuListView = new System.Windows.Forms.ContextMenuStrip( this.components );
            this.toolStripMenuItemCopierLesCoordonnees = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStrip1 = new System.Windows.Forms.ToolStrip();
            this.toolStripButton_AfficheRapport = new System.Windows.Forms.ToolStripButton();
            this.toolStripContainer1 = new System.Windows.Forms.ToolStripContainer();
            this.statusStrip1.SuspendLayout();
            this.contextMenuStripMenuListView.SuspendLayout();
            this.toolStrip1.SuspendLayout();
            this.toolStripContainer1.BottomToolStripPanel.SuspendLayout();
            this.toolStripContainer1.ContentPanel.SuspendLayout();
            this.toolStripContainer1.TopToolStripPanel.SuspendLayout();
            this.toolStripContainer1.SuspendLayout();
            this.SuspendLayout();
            // 
            // statusStrip1
            // 
            this.statusStrip1.Dock = System.Windows.Forms.DockStyle.None;
            this.statusStrip1.Items.AddRange( new System.Windows.Forms.ToolStripItem[] {
            this.toolStripStatusLabel1} );
            this.statusStrip1.Location = new System.Drawing.Point( 0, 0 );
            this.statusStrip1.Name = "statusStrip1";
            this.statusStrip1.Padding = new System.Windows.Forms.Padding( 1, 0, 9, 0 );
            this.statusStrip1.Size = new System.Drawing.Size( 1390, 22 );
            this.statusStrip1.TabIndex = 2;
            this.statusStrip1.Text = "statusStrip1";
            // 
            // toolStripStatusLabel1
            // 
            this.toolStripStatusLabel1.Name = "toolStripStatusLabel1";
            this.toolStripStatusLabel1.Size = new System.Drawing.Size( 0, 17 );
            // 
            // listViewResultats
            // 
            this.listViewResultats.Columns.AddRange( new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader_Nom,
            this.columnHeader_Coordonnees,
            this.columnHeader_Metal,
            this.columnHeader_Cristal,
            this.columnHeader_Deuterium,
            this.columnHeader_NombreGT,
            this.columnHeader_NombrePT,
            this.columnHeader_ChampsDeRuinesPotentiel,
            this.columnHeader_Defenses,
            this.columnHeader_DefsLegeres,
            this.columnHeader_DefsMoyennes,
            this.columnHeader_DefsLourdes} );
            this.listViewResultats.ContextMenuStrip = this.contextMenuStripMenuListView;
            this.listViewResultats.Dock = System.Windows.Forms.DockStyle.Fill;
            this.listViewResultats.FullRowSelect = true;
            listViewGroup1.Header = "ListViewGroup";
            listViewGroup1.Name = "listViewGroup1";
            listViewGroup1.Tag = "Nom";
            listViewGroup2.Header = "ListViewGroup";
            listViewGroup2.Name = "listViewGroup2";
            listViewGroup3.Header = "ListViewGroup";
            listViewGroup3.Name = "listViewGroup3";
            listViewGroup4.Header = "ListViewGroup";
            listViewGroup4.Name = "listViewGroup4";
            this.listViewResultats.Groups.AddRange( new System.Windows.Forms.ListViewGroup[] {
            listViewGroup1,
            listViewGroup2,
            listViewGroup3,
            listViewGroup4} );
            this.listViewResultats.Location = new System.Drawing.Point( 0, 0 );
            this.listViewResultats.MultiSelect = false;
            this.listViewResultats.Name = "listViewResultats";
            this.listViewResultats.Size = new System.Drawing.Size( 1390, 558 );
            this.listViewResultats.Sorting = System.Windows.Forms.SortOrder.Ascending;
            this.listViewResultats.TabIndex = 3;
            this.listViewResultats.UseCompatibleStateImageBehavior = false;
            this.listViewResultats.View = System.Windows.Forms.View.Details;
            this.listViewResultats.VirtualMode = true;
            this.listViewResultats.MouseDoubleClick += new System.Windows.Forms.MouseEventHandler( this.listViewResultats_MouseDoubleClick );
            this.listViewResultats.KeyDown += new System.Windows.Forms.KeyEventHandler( this.listViewResultats_KeyDown );
            this.listViewResultats.ColumnClick += new System.Windows.Forms.ColumnClickEventHandler( this.listViewResultats_ColumnClick );
            this.listViewResultats.RetrieveVirtualItem += new System.Windows.Forms.RetrieveVirtualItemEventHandler( this.listViewResultats_RetrieveVirtualItem );
            this.listViewResultats.ItemSelectionChanged += new System.Windows.Forms.ListViewItemSelectionChangedEventHandler( this.listViewResultats_ItemSelectionChanged );
            // 
            // columnHeader_Nom
            // 
            this.columnHeader_Nom.Text = "Nom";
            this.columnHeader_Nom.Width = 156;
            // 
            // columnHeader_Coordonnees
            // 
            this.columnHeader_Coordonnees.Text = "Coordonnées";
            this.columnHeader_Coordonnees.Width = 122;
            // 
            // columnHeader_Metal
            // 
            this.columnHeader_Metal.Text = "Metal";
            this.columnHeader_Metal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_Metal.Width = 103;
            // 
            // columnHeader_Cristal
            // 
            this.columnHeader_Cristal.Text = "Cristal";
            this.columnHeader_Cristal.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_Cristal.Width = 92;
            // 
            // columnHeader_Deuterium
            // 
            this.columnHeader_Deuterium.Text = "Deutérium";
            this.columnHeader_Deuterium.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_Deuterium.Width = 92;
            // 
            // columnHeader_NombreGT
            // 
            this.columnHeader_NombreGT.Text = "GTs";
            this.columnHeader_NombreGT.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_NombreGT.Width = 56;
            // 
            // columnHeader_NombrePT
            // 
            this.columnHeader_NombrePT.Text = "PTs";
            this.columnHeader_NombrePT.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_NombrePT.Width = 57;
            // 
            // columnHeader_ChampsDeRuinesPotentiel
            // 
            this.columnHeader_ChampsDeRuinesPotentiel.Text = "Ruines possibles";
            this.columnHeader_ChampsDeRuinesPotentiel.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_ChampsDeRuinesPotentiel.Width = 166;
            // 
            // columnHeader_Defenses
            // 
            this.columnHeader_Defenses.Text = "Défenses";
            this.columnHeader_Defenses.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_Defenses.Width = 103;
            // 
            // columnHeader_DefsLegeres
            // 
            this.columnHeader_DefsLegeres.Text = "légères";
            this.columnHeader_DefsLegeres.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_DefsLegeres.Width = 87;
            // 
            // columnHeader_DefsMoyennes
            // 
            this.columnHeader_DefsMoyennes.Text = "moyennes";
            this.columnHeader_DefsMoyennes.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_DefsMoyennes.Width = 95;
            // 
            // columnHeader_DefsLourdes
            // 
            this.columnHeader_DefsLourdes.Text = "lourdes";
            this.columnHeader_DefsLourdes.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            this.columnHeader_DefsLourdes.Width = 81;
            // 
            // contextMenuStripMenuListView
            // 
            this.contextMenuStripMenuListView.Items.AddRange( new System.Windows.Forms.ToolStripItem[] {
            this.toolStripMenuItemCopierLesCoordonnees} );
            this.contextMenuStripMenuListView.Name = "contextMenuStripMenuListView";
            this.contextMenuStripMenuListView.Size = new System.Drawing.Size( 270, 30 );
            // 
            // toolStripMenuItemCopierLesCoordonnees
            // 
            this.toolStripMenuItemCopierLesCoordonnees.Name = "toolStripMenuItemCopierLesCoordonnees";
            this.toolStripMenuItemCopierLesCoordonnees.Size = new System.Drawing.Size( 269, 26 );
            this.toolStripMenuItemCopierLesCoordonnees.Text = "Copier les coordonnées";
            this.toolStripMenuItemCopierLesCoordonnees.Click += new System.EventHandler( this.toolStripMenuItemCopierLesCoordonnees_Click );
            // 
            // toolStrip1
            // 
            this.toolStrip1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.toolStrip1.AutoSize = false;
            this.toolStrip1.Dock = System.Windows.Forms.DockStyle.None;
            this.toolStrip1.GripStyle = System.Windows.Forms.ToolStripGripStyle.Hidden;
            this.toolStrip1.Items.AddRange( new System.Windows.Forms.ToolStripItem[] {
            this.toolStripButton_AfficheRapport} );
            this.toolStrip1.Location = new System.Drawing.Point( 3, 0 );
            this.toolStrip1.Name = "toolStrip1";
            this.toolStrip1.Size = new System.Drawing.Size( 147, 25 );
            this.toolStrip1.TabIndex = 4;
            this.toolStrip1.Text = "toolStrip1";
            // 
            // toolStripButton_AfficheRapport
            // 
            this.toolStripButton_AfficheRapport.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton_AfficheRapport.Image = ((System.Drawing.Image)(resources.GetObject( "toolStripButton_AfficheRapport.Image" )));
            this.toolStripButton_AfficheRapport.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton_AfficheRapport.Name = "toolStripButton_AfficheRapport";
            this.toolStripButton_AfficheRapport.Size = new System.Drawing.Size( 23, 22 );
            this.toolStripButton_AfficheRapport.Text = "Affiche le rapport";
            this.toolStripButton_AfficheRapport.Click += new System.EventHandler( this.toolStripButton_AfficheRapport_Click );
            // 
            // toolStripContainer1
            // 
            // 
            // toolStripContainer1.BottomToolStripPanel
            // 
            this.toolStripContainer1.BottomToolStripPanel.Controls.Add( this.statusStrip1 );
            // 
            // toolStripContainer1.ContentPanel
            // 
            this.toolStripContainer1.ContentPanel.Controls.Add( this.listViewResultats );
            this.toolStripContainer1.ContentPanel.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.toolStripContainer1.ContentPanel.Size = new System.Drawing.Size( 1390, 558 );
            this.toolStripContainer1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.toolStripContainer1.Location = new System.Drawing.Point( 0, 0 );
            this.toolStripContainer1.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.toolStripContainer1.Name = "toolStripContainer1";
            this.toolStripContainer1.Size = new System.Drawing.Size( 1390, 605 );
            this.toolStripContainer1.TabIndex = 5;
            this.toolStripContainer1.Text = "toolStripContainer1";
            // 
            // toolStripContainer1.TopToolStripPanel
            // 
            this.toolStripContainer1.TopToolStripPanel.Controls.Add( this.toolStrip1 );
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 1390, 605 );
            this.Controls.Add( this.toolStripContainer1 );
            this.Name = "Form1";
            this.Text = "Aide au pillage d\'inactifs - Mackila";
            this.statusStrip1.ResumeLayout( false );
            this.statusStrip1.PerformLayout();
            this.contextMenuStripMenuListView.ResumeLayout( false );
            this.toolStrip1.ResumeLayout( false );
            this.toolStrip1.PerformLayout();
            this.toolStripContainer1.BottomToolStripPanel.ResumeLayout( false );
            this.toolStripContainer1.BottomToolStripPanel.PerformLayout();
            this.toolStripContainer1.ContentPanel.ResumeLayout( false );
            this.toolStripContainer1.TopToolStripPanel.ResumeLayout( false );
            this.toolStripContainer1.ResumeLayout( false );
            this.toolStripContainer1.PerformLayout();
            this.ResumeLayout( false );

        }

        #endregion

        private System.Windows.Forms.StatusStrip statusStrip1;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel1;
        private System.Windows.Forms.ListView listViewResultats;
        private System.Windows.Forms.ColumnHeader columnHeader_Nom;
        private System.Windows.Forms.ColumnHeader columnHeader_Coordonnees;
        private System.Windows.Forms.ColumnHeader columnHeader_Metal;
        private System.Windows.Forms.ColumnHeader columnHeader_Cristal;
        private System.Windows.Forms.ColumnHeader columnHeader_Deuterium;
        private System.Windows.Forms.ColumnHeader columnHeader_NombreGT;
        private System.Windows.Forms.ColumnHeader columnHeader_NombrePT;
        private System.Windows.Forms.ToolStrip toolStrip1;
        private System.Windows.Forms.ToolStripContainer toolStripContainer1;
        private System.Windows.Forms.ContextMenuStrip contextMenuStripMenuListView;
        private System.Windows.Forms.ToolStripMenuItem toolStripMenuItemCopierLesCoordonnees;
        private System.Windows.Forms.ColumnHeader columnHeader_ChampsDeRuinesPotentiel;
        private System.Windows.Forms.ColumnHeader columnHeader_DefsLegeres;
        private System.Windows.Forms.ColumnHeader columnHeader_DefsMoyennes;
        private System.Windows.Forms.ColumnHeader columnHeader_DefsLourdes;
        private System.Windows.Forms.ColumnHeader columnHeader_Defenses;
        private System.Windows.Forms.ToolStripButton toolStripButton_AfficheRapport;
    }
}

