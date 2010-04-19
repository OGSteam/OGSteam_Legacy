namespace OgameFarmingInterface
{
    partial class FormGestionComptesOGSpy
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( FormGestionComptesOGSpy ) );
            this.listView1 = new System.Windows.Forms.ListView();
            this.columnHeaderURL = new System.Windows.Forms.ColumnHeader();
            this.columnHeaderLogin = new System.Windows.Forms.ColumnHeader();
            this.columnHeaderMotDePasse = new System.Windows.Forms.ColumnHeader();
            this.buttonAjouter = new System.Windows.Forms.Button();
            this.buttonSupprimer = new System.Windows.Forms.Button();
            this.buttonCharger = new System.Windows.Forms.Button();
            this.buttonSynchroniser = new System.Windows.Forms.Button();
            this.groupBoxGestionComptes = new System.Windows.Forms.GroupBox();
            this.groupBoxFonctionsAvancees = new System.Windows.Forms.GroupBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.groupBoxGestionComptes.SuspendLayout();
            this.groupBoxFonctionsAvancees.SuspendLayout();
            this.SuspendLayout();
            // 
            // listView1
            // 
            this.listView1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.listView1.Columns.AddRange( new System.Windows.Forms.ColumnHeader[] {
            this.columnHeaderURL,
            this.columnHeaderLogin,
            this.columnHeaderMotDePasse} );
            this.listView1.FullRowSelect = true;
            this.listView1.HideSelection = false;
            this.listView1.Location = new System.Drawing.Point( 15, 25 );
            this.listView1.Name = "listView1";
            this.listView1.Size = new System.Drawing.Size( 515, 245 );
            this.listView1.TabIndex = 0;
            this.listView1.UseCompatibleStateImageBehavior = false;
            this.listView1.View = System.Windows.Forms.View.Details;
            this.listView1.VirtualMode = true;
            this.listView1.DoubleClick += new System.EventHandler( this.listView1_DoubleClick );
            this.listView1.VirtualItemsSelectionRangeChanged += new System.Windows.Forms.ListViewVirtualItemsSelectionRangeChangedEventHandler( this.listView1_VirtualItemsSelectionRangeChanged );
            this.listView1.KeyDown += new System.Windows.Forms.KeyEventHandler( this.listView1_KeyDown );
            this.listView1.RetrieveVirtualItem += new System.Windows.Forms.RetrieveVirtualItemEventHandler( this.listView1_RetrieveVirtualItem );
            this.listView1.ItemSelectionChanged += new System.Windows.Forms.ListViewItemSelectionChangedEventHandler( this.listView1_ItemSelectionChanged );
            // 
            // columnHeaderURL
            // 
            this.columnHeaderURL.Text = "Serveur";
            this.columnHeaderURL.Width = 300;
            // 
            // columnHeaderLogin
            // 
            this.columnHeaderLogin.Text = "Login";
            this.columnHeaderLogin.Width = 100;
            // 
            // columnHeaderMotDePasse
            // 
            this.columnHeaderMotDePasse.Text = "Pass";
            this.columnHeaderMotDePasse.Width = 100;
            // 
            // buttonAjouter
            // 
            this.buttonAjouter.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonAjouter.Location = new System.Drawing.Point( 546, 25 );
            this.buttonAjouter.Name = "buttonAjouter";
            this.buttonAjouter.Size = new System.Drawing.Size( 157, 36 );
            this.buttonAjouter.TabIndex = 1;
            this.buttonAjouter.Text = "Ajouter";
            this.buttonAjouter.UseVisualStyleBackColor = true;
            this.buttonAjouter.Click += new System.EventHandler( this.buttonAjouter_Click );
            // 
            // buttonSupprimer
            // 
            this.buttonSupprimer.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonSupprimer.Location = new System.Drawing.Point( 546, 67 );
            this.buttonSupprimer.Name = "buttonSupprimer";
            this.buttonSupprimer.Size = new System.Drawing.Size( 157, 36 );
            this.buttonSupprimer.TabIndex = 2;
            this.buttonSupprimer.Text = "Supprimer";
            this.buttonSupprimer.UseVisualStyleBackColor = true;
            this.buttonSupprimer.Click += new System.EventHandler( this.buttonSupprimer_Click );
            // 
            // buttonCharger
            // 
            this.buttonCharger.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonCharger.Location = new System.Drawing.Point( 546, 109 );
            this.buttonCharger.Name = "buttonCharger";
            this.buttonCharger.Size = new System.Drawing.Size( 157, 36 );
            this.buttonCharger.TabIndex = 3;
            this.buttonCharger.Text = "Charger";
            this.buttonCharger.UseVisualStyleBackColor = true;
            this.buttonCharger.Click += new System.EventHandler( this.buttonCharger_Click );
            // 
            // buttonSynchroniser
            // 
            this.buttonSynchroniser.Location = new System.Drawing.Point( 26, 36 );
            this.buttonSynchroniser.Name = "buttonSynchroniser";
            this.buttonSynchroniser.Size = new System.Drawing.Size( 165, 36 );
            this.buttonSynchroniser.TabIndex = 4;
            this.buttonSynchroniser.Text = "Synchroniser";
            this.buttonSynchroniser.UseVisualStyleBackColor = true;
            this.buttonSynchroniser.Click += new System.EventHandler( this.buttonSynchroniser_Click );
            // 
            // groupBoxGestionComptes
            // 
            this.groupBoxGestionComptes.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.groupBoxGestionComptes.Controls.Add( this.label1 );
            this.groupBoxGestionComptes.Controls.Add( this.listView1 );
            this.groupBoxGestionComptes.Controls.Add( this.buttonAjouter );
            this.groupBoxGestionComptes.Controls.Add( this.buttonCharger );
            this.groupBoxGestionComptes.Controls.Add( this.buttonSupprimer );
            this.groupBoxGestionComptes.Location = new System.Drawing.Point( 12, 12 );
            this.groupBoxGestionComptes.Name = "groupBoxGestionComptes";
            this.groupBoxGestionComptes.Size = new System.Drawing.Size( 718, 311 );
            this.groupBoxGestionComptes.TabIndex = 5;
            this.groupBoxGestionComptes.TabStop = false;
            this.groupBoxGestionComptes.Text = "Gestion des comptes";
            // 
            // groupBoxFonctionsAvancees
            // 
            this.groupBoxFonctionsAvancees.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.groupBoxFonctionsAvancees.Controls.Add( this.label2 );
            this.groupBoxFonctionsAvancees.Controls.Add( this.buttonSynchroniser );
            this.groupBoxFonctionsAvancees.Location = new System.Drawing.Point( 12, 329 );
            this.groupBoxFonctionsAvancees.Name = "groupBoxFonctionsAvancees";
            this.groupBoxFonctionsAvancees.Size = new System.Drawing.Size( 718, 97 );
            this.groupBoxFonctionsAvancees.TabIndex = 6;
            this.groupBoxFonctionsAvancees.TabStop = false;
            this.groupBoxFonctionsAvancees.Text = "Fonctions avancées";
            // 
            // label1
            // 
            this.label1.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point( 12, 278 );
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size( 456, 20 );
            this.label1.TabIndex = 4;
            this.label1.Text = "Attention : les informations enregistrées ne sont pas protégées.";
            // 
            // label2
            // 
            this.label2.Location = new System.Drawing.Point( 197, 22 );
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size( 506, 61 );
            this.label2.TabIndex = 5;
            this.label2.Text = "Cette opération peut être longue.\r\nElle récupère toutes les informations de chaqu" +
                "e compte, puis envoie toutes les informations récupérées à tous les comptes séle" +
                "ctionnés.";
            // 
            // FormGestionComptesOGSpy
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 742, 438 );
            this.Controls.Add( this.groupBoxFonctionsAvancees );
            this.Controls.Add( this.groupBoxGestionComptes );
            this.Icon = ((System.Drawing.Icon)(resources.GetObject( "$this.Icon" )));
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "FormGestionComptesOGSpy";
            this.ShowInTaskbar = false;
            this.Text = "Gestion avancée des comptes OGSpy";
            this.TopMost = true;
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler( this.FormGestionComptesOGSpy_FormClosing );
            this.groupBoxGestionComptes.ResumeLayout( false );
            this.groupBoxGestionComptes.PerformLayout();
            this.groupBoxFonctionsAvancees.ResumeLayout( false );
            this.ResumeLayout( false );

        }

        #endregion

        private System.Windows.Forms.ListView listView1;
        private System.Windows.Forms.Button buttonAjouter;
        private System.Windows.Forms.Button buttonSupprimer;
        private System.Windows.Forms.Button buttonCharger;
        private System.Windows.Forms.Button buttonSynchroniser;
        private System.Windows.Forms.GroupBox groupBoxGestionComptes;
        private System.Windows.Forms.GroupBox groupBoxFonctionsAvancees;
        private System.Windows.Forms.ColumnHeader columnHeaderURL;
        private System.Windows.Forms.ColumnHeader columnHeaderLogin;
        private System.Windows.Forms.ColumnHeader columnHeaderMotDePasse;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
    }
}