namespace Updater
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager( typeof( Form1 ) );
            this.webClient1 = new System.Net.WebClient();
            this.progressBar1 = new System.Windows.Forms.ProgressBar();
            this.SuspendLayout();
            // 
            // webClient1
            // 
            this.webClient1.BaseAddress = "";
            this.webClient1.CachePolicy = null;
            this.webClient1.Credentials = null;
            this.webClient1.Encoding = ((System.Text.Encoding)(resources.GetObject( "webClient1.Encoding" )));
            this.webClient1.Headers = ((System.Net.WebHeaderCollection)(resources.GetObject( "webClient1.Headers" )));
            this.webClient1.QueryString = ((System.Collections.Specialized.NameValueCollection)(resources.GetObject( "webClient1.QueryString" )));
            this.webClient1.UseDefaultCredentials = false;
            this.webClient1.DownloadFileCompleted += new System.ComponentModel.AsyncCompletedEventHandler( this.webClient1_DownloadFileCompleted );
            this.webClient1.DownloadProgressChanged += new System.Net.DownloadProgressChangedEventHandler( this.webClient1_DownloadProgressChanged );
            // 
            // progressBar1
            // 
            this.progressBar1.Location = new System.Drawing.Point( 12, 12 );
            this.progressBar1.Name = "progressBar1";
            this.progressBar1.Size = new System.Drawing.Size( 656, 46 );
            this.progressBar1.TabIndex = 2;
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF( 9F, 20F );
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size( 680, 68 );
            this.Controls.Add( this.progressBar1 );
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedToolWindow;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject( "$this.Icon" )));
            this.Name = "Form1";
            this.Text = "Téléchargement de la mise à jour...";
            this.ResumeLayout( false );

        }

        #endregion

        private System.Net.WebClient webClient1;
        private System.Windows.Forms.ProgressBar progressBar1;
    }
}

