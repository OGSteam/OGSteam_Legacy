namespace OgameFarmingInterface
{
    partial class FormRapportDErreur
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( FormRapportDErreur ) );
            this.buttonFermer = new System.Windows.Forms.Button();
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.buttonCopier = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.SuspendLayout();
            // 
            // buttonFermer
            // 
            this.buttonFermer.Location = new System.Drawing.Point( 606, 372 );
            this.buttonFermer.Name = "buttonFermer";
            this.buttonFermer.Size = new System.Drawing.Size( 132, 31 );
            this.buttonFermer.TabIndex = 0;
            this.buttonFermer.Text = "Fermer";
            this.buttonFermer.UseVisualStyleBackColor = true;
            this.buttonFermer.Click += new System.EventHandler( this.buttonFermer_Click );
            // 
            // textBox1
            // 
            this.textBox1.Location = new System.Drawing.Point( 12, 206 );
            this.textBox1.Multiline = true;
            this.textBox1.Name = "textBox1";
            this.textBox1.ScrollBars = System.Windows.Forms.ScrollBars.Both;
            this.textBox1.Size = new System.Drawing.Size( 726, 160 );
            this.textBox1.TabIndex = 1;
            this.textBox1.WordWrap = false;
            // 
            // label1
            // 
            this.label1.Location = new System.Drawing.Point( 143, 9 );
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size( 595, 194 );
            this.label1.TabIndex = 2;
            this.label1.Text = resources.GetString( "label1.Text" );
            // 
            // pictureBox1
            // 
            this.pictureBox1.Image = global::OgameFarmingInterface.Properties.Resources.Erreur48;
            this.pictureBox1.Location = new System.Drawing.Point( 12, 21 );
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size( 108, 105 );
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pictureBox1.TabIndex = 3;
            this.pictureBox1.TabStop = false;
            // 
            // buttonCopier
            // 
            this.buttonCopier.Location = new System.Drawing.Point( 468, 372 );
            this.buttonCopier.Name = "buttonCopier";
            this.buttonCopier.Size = new System.Drawing.Size( 132, 31 );
            this.buttonCopier.TabIndex = 4;
            this.buttonCopier.Text = "Copier";
            this.buttonCopier.UseVisualStyleBackColor = true;
            this.buttonCopier.Click += new System.EventHandler( this.buttonCopier_Click );
            // 
            // FormRapportDErreur
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 750, 415 );
            this.Controls.Add( this.buttonCopier );
            this.Controls.Add( this.pictureBox1 );
            this.Controls.Add( this.label1 );
            this.Controls.Add( this.textBox1 );
            this.Controls.Add( this.buttonFermer );
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject( "$this.Icon" )));
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "FormRapportDErreur";
            this.SizeGripStyle = System.Windows.Forms.SizeGripStyle.Hide;
            this.Text = "Erreur";
            this.TopMost = true;
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.ResumeLayout( false );
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button buttonFermer;
        private System.Windows.Forms.TextBox textBox1;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.Button buttonCopier;
    }
}