namespace OgameFarmingInterface
{
    partial class FormProgressionImport
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( FormProgressionImport ) );
            this.buttonAnnulerSimulations = new System.Windows.Forms.Button();
            this.progressBarAvancementSimulations = new System.Windows.Forms.ProgressBar();
            this.backgroundWorkerImportation = new System.ComponentModel.BackgroundWorker();
            this.SuspendLayout();
            // 
            // buttonAnnulerSimulations
            // 
            this.buttonAnnulerSimulations.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonAnnulerSimulations.Location = new System.Drawing.Point( 497, 59 );
            this.buttonAnnulerSimulations.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.buttonAnnulerSimulations.Name = "buttonAnnulerSimulations";
            this.buttonAnnulerSimulations.Size = new System.Drawing.Size( 112, 35 );
            this.buttonAnnulerSimulations.TabIndex = 5;
            this.buttonAnnulerSimulations.Text = "Annuler";
            this.buttonAnnulerSimulations.UseVisualStyleBackColor = true;
            this.buttonAnnulerSimulations.Click += new System.EventHandler( this.buttonAnnulerSimulations_Click );
            // 
            // progressBarAvancementSimulations
            // 
            this.progressBarAvancementSimulations.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.progressBarAvancementSimulations.Location = new System.Drawing.Point( 13, 14 );
            this.progressBarAvancementSimulations.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.progressBarAvancementSimulations.Name = "progressBarAvancementSimulations";
            this.progressBarAvancementSimulations.Size = new System.Drawing.Size( 596, 35 );
            this.progressBarAvancementSimulations.TabIndex = 4;
            // 
            // backgroundWorkerImportation
            // 
            this.backgroundWorkerImportation.WorkerReportsProgress = true;
            this.backgroundWorkerImportation.WorkerSupportsCancellation = true;
            this.backgroundWorkerImportation.DoWork += new System.ComponentModel.DoWorkEventHandler( this.backgroundWorkerImportation_DoWork );
            this.backgroundWorkerImportation.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler( this.backgroundWorkerImportation_RunWorkerCompleted );
            this.backgroundWorkerImportation.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler( this.backgroundWorkerImportation_ProgressChanged );
            // 
            // FormProgressionImport
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 622, 106 );
            this.Controls.Add( this.buttonAnnulerSimulations );
            this.Controls.Add( this.progressBarAvancementSimulations );
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedToolWindow;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject( "$this.Icon" )));
            this.Name = "FormProgressionImport";
            this.Text = "Importation en cours...";
            this.ResumeLayout( false );

        }

        #endregion

        private System.Windows.Forms.Button buttonAnnulerSimulations;
        private System.Windows.Forms.ProgressBar progressBarAvancementSimulations;
        private System.ComponentModel.BackgroundWorker backgroundWorkerImportation;
    }
}