# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'ui_manageDb.ui'
#
# Created: Tue Sep 18 11:50:22 2007
#      by: PyQt4 UI code generator 4.3
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

class Ui_manageDb(object):
    def setupUi(self, manageDb):
        manageDb.setObjectName("manageDb")
        manageDb.setWindowModality(QtCore.Qt.NonModal)
        manageDb.resize(QtCore.QSize(QtCore.QRect(0,0,677,454).size()).expandedTo(manageDb.minimumSizeHint()))

        self.gridlayout = QtGui.QGridLayout(manageDb)
        self.gridlayout.setObjectName("gridlayout")

        self.hboxlayout = QtGui.QHBoxLayout()
        self.hboxlayout.setObjectName("hboxlayout")

        self.label = QtGui.QLabel(manageDb)
        self.label.setObjectName("label")
        self.hboxlayout.addWidget(self.label)

        self.chooseBdd = QtGui.QComboBox(manageDb)
        self.chooseBdd.setObjectName("chooseBdd")
        self.hboxlayout.addWidget(self.chooseBdd)

        spacerItem = QtGui.QSpacerItem(40,20,QtGui.QSizePolicy.Expanding,QtGui.QSizePolicy.Minimum)
        self.hboxlayout.addItem(spacerItem)
        self.gridlayout.addLayout(self.hboxlayout,0,0,1,1)

        self.splitter_2 = QtGui.QSplitter(manageDb)
        self.splitter_2.setOrientation(QtCore.Qt.Vertical)
        self.splitter_2.setObjectName("splitter_2")

        self.cibleBrowser = QtGui.QTreeWidget(self.splitter_2)
        self.cibleBrowser.setContextMenuPolicy(QtCore.Qt.ActionsContextMenu)
        self.cibleBrowser.setTabKeyNavigation(True)
        self.cibleBrowser.setAlternatingRowColors(True)
        self.cibleBrowser.setRootIsDecorated(False)
        self.cibleBrowser.setSortingEnabled(True)
        self.cibleBrowser.setObjectName("cibleBrowser")

        self.splitter = QtGui.QSplitter(self.splitter_2)
        self.splitter.setOrientation(QtCore.Qt.Horizontal)
        self.splitter.setObjectName("splitter")

        self.widget = QtGui.QWidget(self.splitter)
        self.widget.setObjectName("widget")

        self.vboxlayout = QtGui.QVBoxLayout(self.widget)
        self.vboxlayout.setObjectName("vboxlayout")

        self.saveCommentButton = QtGui.QPushButton(self.widget)
        self.saveCommentButton.setObjectName("saveCommentButton")
        self.vboxlayout.addWidget(self.saveCommentButton)

        self.commentEdit = QtGui.QTextEdit(self.widget)
        self.commentEdit.setObjectName("commentEdit")
        self.vboxlayout.addWidget(self.commentEdit)

        self.reBrowser = QtGui.QTextBrowser(self.splitter)
        self.reBrowser.setObjectName("reBrowser")
        self.gridlayout.addWidget(self.splitter_2,1,0,1,1)

        self.retranslateUi(manageDb)
        QtCore.QMetaObject.connectSlotsByName(manageDb)

    def retranslateUi(self, manageDb):
        manageDb.setWindowTitle(QtGui.QApplication.translate("manageDb", "Explorateur de base de données", None, QtGui.QApplication.UnicodeUTF8))
        self.label.setText(QtGui.QApplication.translate("manageDb", "Base de données :", None, QtGui.QApplication.UnicodeUTF8))
        self.cibleBrowser.headerItem().setText(0,QtGui.QApplication.translate("manageDb", "1", None, QtGui.QApplication.UnicodeUTF8))
        self.saveCommentButton.setText(QtGui.QApplication.translate("manageDb", "Sauver le commentaire", None, QtGui.QApplication.UnicodeUTF8))

