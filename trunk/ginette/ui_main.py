# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'ui_main.ui'
#
# Created: Sun Oct 14 16:53:40 2007
#      by: PyQt4 UI code generator 4.3
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

class Ui_MainWindow(object):
    def setupUi(self, MainWindow):
        MainWindow.setObjectName("MainWindow")
        MainWindow.resize(QtCore.QSize(QtCore.QRect(0,0,809,609).size()).expandedTo(MainWindow.minimumSizeHint()))

        sizePolicy = QtGui.QSizePolicy(QtGui.QSizePolicy.Fixed,QtGui.QSizePolicy.Fixed)
        sizePolicy.setHorizontalStretch(0)
        sizePolicy.setVerticalStretch(0)
        sizePolicy.setHeightForWidth(MainWindow.sizePolicy().hasHeightForWidth())
        MainWindow.setSizePolicy(sizePolicy)
        MainWindow.setMinimumSize(QtCore.QSize(809,609))
        MainWindow.setMaximumSize(QtCore.QSize(809,609))

        self.centralwidget = QtGui.QWidget(MainWindow)
        self.centralwidget.setObjectName("centralwidget")

        self.tabWidget = QtGui.QTabWidget(self.centralwidget)
        self.tabWidget.setGeometry(QtCore.QRect(0,4,809,577))
        self.tabWidget.setFocusPolicy(QtCore.Qt.NoFocus)
        self.tabWidget.setObjectName("tabWidget")

        self.tab0 = QtGui.QWidget()
        self.tab0.setObjectName("tab0")
        self.tabWidget.addTab(self.tab0,"")
        MainWindow.setCentralWidget(self.centralwidget)

        self.menuBar = QtGui.QMenuBar(MainWindow)
        self.menuBar.setGeometry(QtCore.QRect(0,0,809,28))
        self.menuBar.setObjectName("menuBar")

        self.menuFichier = QtGui.QMenu(self.menuBar)
        self.menuFichier.setObjectName("menuFichier")

        self.menuAide = QtGui.QMenu(self.menuBar)
        self.menuAide.setObjectName("menuAide")
        MainWindow.setMenuBar(self.menuBar)

        self.actionApropos = QtGui.QAction(MainWindow)
        self.actionApropos.setObjectName("actionApropos")

        self.createBdd = QtGui.QAction(MainWindow)
        self.createBdd.setObjectName("createBdd")

        self.manageBdd = QtGui.QAction(MainWindow)
        self.manageBdd.setObjectName("manageBdd")

        self.actionSystem = QtGui.QAction(MainWindow)
        self.actionSystem.setObjectName("actionSystem")

        self.newTab = QtGui.QAction(MainWindow)
        self.newTab.setObjectName("newTab")

        self.actionPreferences = QtGui.QAction(MainWindow)
        self.actionPreferences.setObjectName("actionPreferences")
        self.menuFichier.addAction(self.newTab)
        self.menuFichier.addSeparator()
        self.menuFichier.addAction(self.createBdd)
        self.menuFichier.addAction(self.manageBdd)
        self.menuFichier.addSeparator()
        self.menuFichier.addAction(self.actionPreferences)
        self.menuAide.addAction(self.actionApropos)
        self.menuBar.addAction(self.menuFichier.menuAction())
        self.menuBar.addAction(self.menuAide.menuAction())

        self.retranslateUi(MainWindow)
        self.tabWidget.setCurrentIndex(0)
        QtCore.QMetaObject.connectSlotsByName(MainWindow)

    def retranslateUi(self, MainWindow):
        MainWindow.setWindowTitle(QtGui.QApplication.translate("MainWindow", "Ginette 0.2", None, QtGui.QApplication.UnicodeUTF8))
        self.tabWidget.setTabText(self.tabWidget.indexOf(self.tab0), QtGui.QApplication.translate("MainWindow", "tab0", None, QtGui.QApplication.UnicodeUTF8))
        self.menuFichier.setTitle(QtGui.QApplication.translate("MainWindow", "Fichier", None, QtGui.QApplication.UnicodeUTF8))
        self.menuAide.setTitle(QtGui.QApplication.translate("MainWindow", "A propos", None, QtGui.QApplication.UnicodeUTF8))
        self.actionApropos.setText(QtGui.QApplication.translate("MainWindow", "Ginette", None, QtGui.QApplication.UnicodeUTF8))
        self.createBdd.setText(QtGui.QApplication.translate("MainWindow", "Créer une base de données", None, QtGui.QApplication.UnicodeUTF8))
        self.manageBdd.setText(QtGui.QApplication.translate("MainWindow", "Explorer une base de données", None, QtGui.QApplication.UnicodeUTF8))
        self.actionSystem.setText(QtGui.QApplication.translate("MainWindow", "Système", None, QtGui.QApplication.UnicodeUTF8))
        self.newTab.setText(QtGui.QApplication.translate("MainWindow", "Nouvel onglet", None, QtGui.QApplication.UnicodeUTF8))
        self.newTab.setShortcut(QtGui.QApplication.translate("MainWindow", "Ctrl+T", None, QtGui.QApplication.UnicodeUTF8))
        self.actionPreferences.setText(QtGui.QApplication.translate("MainWindow", "Préférences", None, QtGui.QApplication.UnicodeUTF8))

