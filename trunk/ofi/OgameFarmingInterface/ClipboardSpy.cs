using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;
using System.Runtime.InteropServices;

namespace Maf.Windows.Component
{
    public class ClipboardSpy : NativeWindow, IDisposable
    {
        private const int WM_DRAWCLIPBOARD = 0x308;
        private const int WM_CHANGECBCHAIN = 0x030D;

        [DllImport("User32.dll")]
        private static extern IntPtr
            SetClipboardViewer(IntPtr hWndNewViewer);

        [DllImport("User32.dll", CharSet = CharSet.Auto)]
        private static extern bool
            ChangeClipboardChain(IntPtr hWndRemove,
            IntPtr hWndNewNext);

        [DllImport("user32.dll", CharSet = CharSet.Auto)]
        private static extern int SendMessage(IntPtr hwnd, int wMsg,
            IntPtr wParam,
            IntPtr lParam);

        public event EventHandler ClipboardChanged;

        private IntPtr nextClipboardViewer;

        /// <summary>
        /// On instancie la classe en lui affectant le 
        /// même handle que sa fenêtre mère.
        /// </summary>
        /// <param name="form">Fenêtre qui interceptera les évènements du clipboard</param>
        public ClipboardSpy(Form form) {
            this.AssignHandle(form.Handle);
            nextClipboardViewer = SetClipboardViewer(form.Handle);
        }

        /// <summary>
        /// Attention le destructeur ici permet d'être sûr que la change
        /// de notifications sera remise en état si l'instance de la classe
        /// est détruite sans passer par la méthode Dispose.
        /// </summary>
        ~ClipboardSpy()
        {
            this.Dispose();
        }

        // On observe les messages windows
        // qui passent par notre fenêtre
        protected override void WndProc(ref Message m)
        {
            switch (m.Msg) { 
                case WM_DRAWCLIPBOARD:
                    // on recoit ce message lorsque le contenu du presse papier change
                    if (this.ClipboardChanged != null) {
                        this.ClipboardChanged(this, EventArgs.Empty);
                    }
                    SendMessage(nextClipboardViewer, m.Msg, m.WParam, m.LParam);
                    break;

                case WM_CHANGECBCHAIN:
                    // on reçoit ce message lorsque la boucle des applications
                    // recevant les notifications change
                    if (m.WParam == nextClipboardViewer)
                    {
                        nextClipboardViewer = m.LParam;
                    }
                    else {
                        SendMessage(nextClipboardViewer, m.Msg, m.WParam, m.LParam);
                    }
                    break;
            
                default:
                    // tous les autres cas
                    base.WndProc(ref m);
                    break;
            }
        }


        #region IDisposable Members


        public void Dispose()
        {
            // on retire notre fenêtre de la chaine de notifications
            ChangeClipboardChain(this.Handle, nextClipboardViewer);
        }

        #endregion
    }
}
