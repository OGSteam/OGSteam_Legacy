namespace OgameFarmingInterface
{
    partial class FormAPropos
    {
        /// <summary>
        /// Variable nécessaire au concepteur.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Nettoyage des ressources utilisées.
        /// </summary>
        /// <param name="disposing">true si les ressources managées doivent être supprimées ; sinon, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Code généré par le Concepteur Windows Form

        /// <summary>
        /// Méthode requise pour la prise en charge du concepteur - ne modifiez pas
        /// le contenu de cette méthode avec l'éditeur de code.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( FormAPropos ) );
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.button1 = new System.Windows.Forms.Button();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.linkLabel1 = new System.Windows.Forms.LinkLabel();
            this.label1 = new System.Windows.Forms.Label();
            this.labelVersion = new System.Windows.Forms.Label();
            this.labelDateCompilation = new System.Windows.Forms.Label();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.SuspendLayout();
            // 
            // textBox1
            // 
            this.textBox1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom)
                        | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.textBox1.Location = new System.Drawing.Point( 288, 18 );
            this.textBox1.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.textBox1.Multiline = true;
            this.textBox1.Name = "textBox1";
            this.textBox1.ReadOnly = true;
            this.textBox1.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.textBox1.Size = new System.Drawing.Size( 848, 509 );
            this.textBox1.TabIndex = 0;
            this.textBox1.Text = resources.GetString( "textBox1.Text" );
            // 
            // button1
            // 
            this.button1.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.button1.Location = new System.Drawing.Point( 12, 538 );
            this.button1.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size( 1124, 35 );
            this.button1.TabIndex = 1;
            this.button1.Text = "OK";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler( this.button1_Click );
            // 
            // pictureBox1
            // 
            this.pictureBox1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D;
            this.pictureBox1.Image = global::OgameFarmingInterface.Properties.Resources.LogoPigeon;
            this.pictureBox1.Location = new System.Drawing.Point( 12, 18 );
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size( 253, 259 );
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pictureBox1.TabIndex = 2;
            this.pictureBox1.TabStop = false;
            // 
            // linkLabel1
            // 
            this.linkLabel1.AutoSize = true;
            this.linkLabel1.Location = new System.Drawing.Point( 8, 289 );
            this.linkLabel1.Name = "linkLabel1";
            this.linkLabel1.Size = new System.Drawing.Size( 202, 20 );
            this.linkLabel1.TabIndex = 3;
            this.linkLabel1.TabStop = true;
            this.linkLabel1.Text = "http://mackila.com/phpBB2/";
            this.linkLabel1.LinkClicked += new System.Windows.Forms.LinkLabelLinkClickedEventHandler( this.linkLabel1_LinkClicked );
            // 
            // label1
            // 
            this.label1.Location = new System.Drawing.Point( 8, 318 );
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size( 260, 162 );
            this.label1.TabIndex = 4;
            this.label1.Text = "Gestion des pigeons et simulateurs par Mackila\r\n_______________\r\nWIL Mackila\r\nUni" +
                "vers 21\r\nAlliance WIL\r\n_______________\r\n\r\n";
            // 
            // labelVersion
            // 
            this.labelVersion.Font = new System.Drawing.Font( "Courier New", 8F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)) );
            this.labelVersion.Location = new System.Drawing.Point( 8, 462 );
            this.labelVersion.Name = "labelVersion";
            this.labelVersion.Size = new System.Drawing.Size( 260, 46 );
            this.labelVersion.TabIndex = 5;
            this.labelVersion.Text = "Version";
            // 
            // labelDateCompilation
            // 
            this.labelDateCompilation.Font = new System.Drawing.Font( "Courier New", 8F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)) );
            this.labelDateCompilation.Location = new System.Drawing.Point( 12, 508 );
            this.labelDateCompilation.Name = "labelDateCompilation";
            this.labelDateCompilation.Size = new System.Drawing.Size( 260, 26 );
            this.labelDateCompilation.TabIndex = 6;
            // 
            // FormAPropos
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 1150, 600 );
            this.Controls.Add( this.labelDateCompilation );
            this.Controls.Add( this.labelVersion );
            this.Controls.Add( this.label1 );
            this.Controls.Add( this.linkLabel1 );
            this.Controls.Add( this.pictureBox1 );
            this.Controls.Add( this.button1 );
            this.Controls.Add( this.textBox1 );
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow;
            this.Margin = new System.Windows.Forms.Padding( 4, 5, 4, 5 );
            this.MinimumSize = new System.Drawing.Size( 1158, 622 );
            this.Name = "FormAPropos";
            this.ShowIcon = false;
            this.ShowInTaskbar = false;
            this.Text = "A propos...";
            this.TopMost = true;
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.ResumeLayout( false );
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox textBox1;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.LinkLabel linkLabel1;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label labelVersion;
        private System.Windows.Forms.Label labelDateCompilation;
    }
}