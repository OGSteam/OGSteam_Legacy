# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'ui_prefs.ui'
#
# Created: Tue Oct 23 15:42:43 2007
#      by: PyQt4 UI code generator 4.3
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

class Ui_DialogPrefs(object):
    def setupUi(self, DialogPrefs):
        DialogPrefs.setObjectName("DialogPrefs")
        DialogPrefs.resize(QtCore.QSize(QtCore.QRect(0,0,521,257).size()).expandedTo(DialogPrefs.minimumSizeHint()))

        self.gridlayout = QtGui.QGridLayout(DialogPrefs)
        self.gridlayout.setObjectName("gridlayout")

        self.vboxlayout = QtGui.QVBoxLayout()
        self.vboxlayout.setObjectName("vboxlayout")

        self.splitter = QtGui.QSplitter(DialogPrefs)
        self.splitter.setOrientation(QtCore.Qt.Horizontal)
        self.splitter.setObjectName("splitter")

        self.listWidgetMenu = QtGui.QListWidget(self.splitter)
        self.listWidgetMenu.setMaximumSize(QtCore.QSize(120,16777215))

        font = QtGui.QFont()
        font.setPointSize(9)
        font.setWeight(50)
        font.setStrikeOut(False)
        font.setBold(False)
        self.listWidgetMenu.setFont(font)
        self.listWidgetMenu.setObjectName("listWidgetMenu")

        self.stackedWidget = QtGui.QStackedWidget(self.splitter)
        self.stackedWidget.setMinimumSize(QtCore.QSize(16,16))
        self.stackedWidget.setObjectName("stackedWidget")

        self.page = QtGui.QWidget()
        self.page.setObjectName("page")

        self.checkBoxAuto = QtGui.QCheckBox(self.page)
        self.checkBoxAuto.setGeometry(QtCore.QRect(24,16,345,21))
        self.checkBoxAuto.setFocusPolicy(QtCore.Qt.NoFocus)
        self.checkBoxAuto.setObjectName("checkBoxAuto")

        self.groupBoxPond = QtGui.QGroupBox(self.page)
        self.groupBoxPond.setGeometry(QtCore.QRect(16,44,353,57))
        self.groupBoxPond.setFocusPolicy(QtCore.Qt.NoFocus)
        self.groupBoxPond.setCheckable(True)
        self.groupBoxPond.setObjectName("groupBoxPond")

        self.label = QtGui.QLabel(self.groupBoxPond)
        self.label.setGeometry(QtCore.QRect(16,24,81,16))
        self.label.setObjectName("label")

        self.lineEditPm = QtGui.QLineEdit(self.groupBoxPond)
        self.lineEditPm.setGeometry(QtCore.QRect(112,20,49,22))
        self.lineEditPm.setFocusPolicy(QtCore.Qt.NoFocus)
        self.lineEditPm.setObjectName("lineEditPm")

        self.checkBoxEngeener = QtGui.QCheckBox(self.page)
        self.checkBoxEngeener.setGeometry(QtCore.QRect(24,108,345,21))
        self.checkBoxEngeener.setFocusPolicy(QtCore.Qt.NoFocus)
        self.checkBoxEngeener.setObjectName("checkBoxEngeener")
        self.stackedWidget.addWidget(self.page)

        self.page_2 = QtGui.QWidget()
        self.page_2.setObjectName("page_2")

        self.label_6 = QtGui.QLabel(self.page_2)
        self.label_6.setGeometry(QtCore.QRect(168,16,93,16))
        self.label_6.setObjectName("label_6")

        self.lineEditC = QtGui.QLineEdit(self.page_2)
        self.lineEditC.setGeometry(QtCore.QRect(264,12,29,22))
        self.lineEditC.setObjectName("lineEditC")

        self.label_7 = QtGui.QLabel(self.page_2)
        self.label_7.setGeometry(QtCore.QRect(168,44,93,16))
        self.label_7.setObjectName("label_7")

        self.label_8 = QtGui.QLabel(self.page_2)
        self.label_8.setGeometry(QtCore.QRect(168,72,93,16))
        self.label_8.setObjectName("label_8")

        self.lineEditI = QtGui.QLineEdit(self.page_2)
        self.lineEditI.setGeometry(QtCore.QRect(264,40,29,22))
        self.lineEditI.setObjectName("lineEditI")

        self.lineEditH = QtGui.QLineEdit(self.page_2)
        self.lineEditH.setGeometry(QtCore.QRect(264,68,29,22))
        self.lineEditH.setObjectName("lineEditH")

        self.line = QtGui.QFrame(self.page_2)
        self.line.setGeometry(QtCore.QRect(8,92,309,16))
        self.line.setFrameShape(QtGui.QFrame.HLine)
        self.line.setFrameShadow(QtGui.QFrame.Sunken)
        self.line.setObjectName("line")

        self.lineEditP1 = QtGui.QLineEdit(self.page_2)
        self.lineEditP1.setGeometry(QtCore.QRect(40,120,65,22))
        self.lineEditP1.setObjectName("lineEditP1")

        self.lineEditP4 = QtGui.QLineEdit(self.page_2)
        self.lineEditP4.setGeometry(QtCore.QRect(40,148,65,22))
        self.lineEditP4.setObjectName("lineEditP4")

        self.lineEditP7 = QtGui.QLineEdit(self.page_2)
        self.lineEditP7.setGeometry(QtCore.QRect(40,176,65,22))
        self.lineEditP7.setObjectName("lineEditP7")

        self.lineEditP2 = QtGui.QLineEdit(self.page_2)
        self.lineEditP2.setGeometry(QtCore.QRect(144,120,65,22))
        self.lineEditP2.setObjectName("lineEditP2")

        self.lineEditP5 = QtGui.QLineEdit(self.page_2)
        self.lineEditP5.setGeometry(QtCore.QRect(144,148,65,22))
        self.lineEditP5.setObjectName("lineEditP5")

        self.lineEditP8 = QtGui.QLineEdit(self.page_2)
        self.lineEditP8.setGeometry(QtCore.QRect(144,176,65,22))
        self.lineEditP8.setObjectName("lineEditP8")

        self.lineEditP6 = QtGui.QLineEdit(self.page_2)
        self.lineEditP6.setGeometry(QtCore.QRect(248,148,65,22))
        self.lineEditP6.setObjectName("lineEditP6")

        self.lineEditP9 = QtGui.QLineEdit(self.page_2)
        self.lineEditP9.setGeometry(QtCore.QRect(248,176,65,22))
        self.lineEditP9.setObjectName("lineEditP9")

        self.lineEditP3 = QtGui.QLineEdit(self.page_2)
        self.lineEditP3.setGeometry(QtCore.QRect(248,120,65,22))
        self.lineEditP3.setObjectName("lineEditP3")

        self.label_9 = QtGui.QLabel(self.page_2)
        self.label_9.setGeometry(QtCore.QRect(16,124,20,16))
        self.label_9.setObjectName("label_9")

        self.label_10 = QtGui.QLabel(self.page_2)
        self.label_10.setGeometry(QtCore.QRect(16,152,20,16))
        self.label_10.setObjectName("label_10")

        self.label_11 = QtGui.QLabel(self.page_2)
        self.label_11.setGeometry(QtCore.QRect(16,180,20,16))
        self.label_11.setObjectName("label_11")

        self.label_12 = QtGui.QLabel(self.page_2)
        self.label_12.setGeometry(QtCore.QRect(120,152,20,16))
        self.label_12.setObjectName("label_12")

        self.label_13 = QtGui.QLabel(self.page_2)
        self.label_13.setGeometry(QtCore.QRect(120,124,20,16))
        self.label_13.setObjectName("label_13")

        self.label_14 = QtGui.QLabel(self.page_2)
        self.label_14.setGeometry(QtCore.QRect(120,180,20,16))
        self.label_14.setObjectName("label_14")

        self.label_15 = QtGui.QLabel(self.page_2)
        self.label_15.setGeometry(QtCore.QRect(224,180,20,16))
        self.label_15.setObjectName("label_15")

        self.label_16 = QtGui.QLabel(self.page_2)
        self.label_16.setGeometry(QtCore.QRect(224,152,20,16))
        self.label_16.setObjectName("label_16")

        self.label_17 = QtGui.QLabel(self.page_2)
        self.label_17.setGeometry(QtCore.QRect(224,124,20,16))
        self.label_17.setObjectName("label_17")

        self.label_18 = QtGui.QLabel(self.page_2)
        self.label_18.setGeometry(QtCore.QRect(124,100,89,16))
        self.label_18.setAlignment(QtCore.Qt.AlignCenter)
        self.label_18.setObjectName("label_18")

        self.label_19 = QtGui.QLabel(self.page_2)
        self.label_19.setGeometry(QtCore.QRect(24,16,93,16))
        self.label_19.setObjectName("label_19")

        self.label_20 = QtGui.QLabel(self.page_2)
        self.label_20.setGeometry(QtCore.QRect(24,44,93,16))
        self.label_20.setObjectName("label_20")

        self.label_21 = QtGui.QLabel(self.page_2)
        self.label_21.setGeometry(QtCore.QRect(24,72,93,16))
        self.label_21.setObjectName("label_21")

        self.lineEditB = QtGui.QLineEdit(self.page_2)
        self.lineEditB.setGeometry(QtCore.QRect(120,40,29,22))
        self.lineEditB.setObjectName("lineEditB")

        self.lineEditA = QtGui.QLineEdit(self.page_2)
        self.lineEditA.setGeometry(QtCore.QRect(120,12,29,22))
        self.lineEditA.setObjectName("lineEditA")

        self.lineEditP = QtGui.QLineEdit(self.page_2)
        self.lineEditP.setGeometry(QtCore.QRect(120,68,29,22))
        self.lineEditP.setObjectName("lineEditP")
        self.stackedWidget.addWidget(self.page_2)

        self.page_3 = QtGui.QWidget()
        self.page_3.setObjectName("page_3")

        self.comboBoxStyle = QtGui.QComboBox(self.page_3)
        self.comboBoxStyle.setGeometry(QtCore.QRect(205,24,129,22))
        self.comboBoxStyle.setObjectName("comboBoxStyle")

        self.checkBoxForceStyle = QtGui.QCheckBox(self.page_3)
        self.checkBoxForceStyle.setGeometry(QtCore.QRect(25,24,173,21))
        self.checkBoxForceStyle.setFocusPolicy(QtCore.Qt.NoFocus)
        self.checkBoxForceStyle.setObjectName("checkBoxForceStyle")

        self.label_5 = QtGui.QLabel(self.page_3)
        self.label_5.setGeometry(QtCore.QRect(25,60,169,16))
        self.label_5.setObjectName("label_5")

        self.comboBoxCss = QtGui.QComboBox(self.page_3)
        self.comboBoxCss.setGeometry(QtCore.QRect(204,56,129,22))
        self.comboBoxCss.setObjectName("comboBoxCss")
        self.stackedWidget.addWidget(self.page_3)
        self.vboxlayout.addWidget(self.splitter)

        self.buttonBox = QtGui.QDialogButtonBox(DialogPrefs)
        self.buttonBox.setOrientation(QtCore.Qt.Horizontal)
        self.buttonBox.setStandardButtons(QtGui.QDialogButtonBox.Cancel|QtGui.QDialogButtonBox.NoButton|QtGui.QDialogButtonBox.Ok)
        self.buttonBox.setObjectName("buttonBox")
        self.vboxlayout.addWidget(self.buttonBox)
        self.gridlayout.addLayout(self.vboxlayout,0,0,1,1)

        self.retranslateUi(DialogPrefs)
        self.stackedWidget.setCurrentIndex(0)
        QtCore.QObject.connect(self.buttonBox,QtCore.SIGNAL("accepted()"),DialogPrefs.accept)
        QtCore.QObject.connect(self.buttonBox,QtCore.SIGNAL("rejected()"),DialogPrefs.reject)
        QtCore.QMetaObject.connectSlotsByName(DialogPrefs)
        DialogPrefs.setTabOrder(self.lineEditA,self.lineEditB)
        DialogPrefs.setTabOrder(self.lineEditB,self.lineEditP)
        DialogPrefs.setTabOrder(self.lineEditP,self.lineEditC)
        DialogPrefs.setTabOrder(self.lineEditC,self.lineEditI)
        DialogPrefs.setTabOrder(self.lineEditI,self.lineEditH)
        DialogPrefs.setTabOrder(self.lineEditH,self.lineEditP1)
        DialogPrefs.setTabOrder(self.lineEditP1,self.lineEditP2)
        DialogPrefs.setTabOrder(self.lineEditP2,self.lineEditP3)
        DialogPrefs.setTabOrder(self.lineEditP3,self.lineEditP4)
        DialogPrefs.setTabOrder(self.lineEditP4,self.lineEditP5)
        DialogPrefs.setTabOrder(self.lineEditP5,self.lineEditP6)
        DialogPrefs.setTabOrder(self.lineEditP6,self.lineEditP7)
        DialogPrefs.setTabOrder(self.lineEditP7,self.lineEditP8)
        DialogPrefs.setTabOrder(self.lineEditP8,self.lineEditP9)
        DialogPrefs.setTabOrder(self.lineEditP9,self.comboBoxStyle)
        DialogPrefs.setTabOrder(self.comboBoxStyle,self.comboBoxCss)
        DialogPrefs.setTabOrder(self.comboBoxCss,self.buttonBox)
        DialogPrefs.setTabOrder(self.buttonBox,self.listWidgetMenu)

    def retranslateUi(self, DialogPrefs):
        DialogPrefs.setWindowTitle(QtGui.QApplication.translate("DialogPrefs", "Préférences", None, QtGui.QApplication.UnicodeUTF8))
        self.listWidgetMenu.clear()

        item = QtGui.QListWidgetItem(self.listWidgetMenu)
        item.setText(QtGui.QApplication.translate("DialogPrefs", "Général", None, QtGui.QApplication.UnicodeUTF8))

        item1 = QtGui.QListWidgetItem(self.listWidgetMenu)
        item1.setText(QtGui.QApplication.translate("DialogPrefs", "Infos perso.", None, QtGui.QApplication.UnicodeUTF8))

        item2 = QtGui.QListWidgetItem(self.listWidgetMenu)
        item2.setText(QtGui.QApplication.translate("DialogPrefs", "Apparence", None, QtGui.QApplication.UnicodeUTF8))
        self.checkBoxAuto.setText(QtGui.QApplication.translate("DialogPrefs", "Ouvrir un onglet avec ses technologies remplies", None, QtGui.QApplication.UnicodeUTF8))
        self.groupBoxPond.setTitle(QtGui.QApplication.translate("DialogPrefs", "Ponderer les gain avec le coût de consommation", None, QtGui.QApplication.UnicodeUTF8))
        self.label.setText(QtGui.QApplication.translate("DialogPrefs", "Pondération :", None, QtGui.QApplication.UnicodeUTF8))
        self.checkBoxEngeener.setText(QtGui.QApplication.translate("DialogPrefs", "Officier ingénieur par défaut pour les vagues suivantes", None, QtGui.QApplication.UnicodeUTF8))
        self.label_6.setText(QtGui.QApplication.translate("DialogPrefs", "T. Combustion", None, QtGui.QApplication.UnicodeUTF8))
        self.label_7.setText(QtGui.QApplication.translate("DialogPrefs", "T. Impulsion", None, QtGui.QApplication.UnicodeUTF8))
        self.label_8.setText(QtGui.QApplication.translate("DialogPrefs", "T. Hyperespace", None, QtGui.QApplication.UnicodeUTF8))
        self.label_9.setText(QtGui.QApplication.translate("DialogPrefs", "P1", None, QtGui.QApplication.UnicodeUTF8))
        self.label_10.setText(QtGui.QApplication.translate("DialogPrefs", "P4", None, QtGui.QApplication.UnicodeUTF8))
        self.label_11.setText(QtGui.QApplication.translate("DialogPrefs", "P7", None, QtGui.QApplication.UnicodeUTF8))
        self.label_12.setText(QtGui.QApplication.translate("DialogPrefs", "P5", None, QtGui.QApplication.UnicodeUTF8))
        self.label_13.setText(QtGui.QApplication.translate("DialogPrefs", "P2", None, QtGui.QApplication.UnicodeUTF8))
        self.label_14.setText(QtGui.QApplication.translate("DialogPrefs", "P8", None, QtGui.QApplication.UnicodeUTF8))
        self.label_15.setText(QtGui.QApplication.translate("DialogPrefs", "P9", None, QtGui.QApplication.UnicodeUTF8))
        self.label_16.setText(QtGui.QApplication.translate("DialogPrefs", "P6", None, QtGui.QApplication.UnicodeUTF8))
        self.label_17.setText(QtGui.QApplication.translate("DialogPrefs", "P3", None, QtGui.QApplication.UnicodeUTF8))
        self.label_18.setText(QtGui.QApplication.translate("DialogPrefs", "Positions", None, QtGui.QApplication.UnicodeUTF8))
        self.label_19.setText(QtGui.QApplication.translate("DialogPrefs", "T. Arme", None, QtGui.QApplication.UnicodeUTF8))
        self.label_20.setText(QtGui.QApplication.translate("DialogPrefs", "T. Bouclier", None, QtGui.QApplication.UnicodeUTF8))
        self.label_21.setText(QtGui.QApplication.translate("DialogPrefs", "T. Protection", None, QtGui.QApplication.UnicodeUTF8))
        self.checkBoxForceStyle.setText(QtGui.QApplication.translate("DialogPrefs", "Forcer un style Qt", None, QtGui.QApplication.UnicodeUTF8))
        self.label_5.setText(QtGui.QApplication.translate("DialogPrefs", "Utiliser la feuille de style :", None, QtGui.QApplication.UnicodeUTF8))

