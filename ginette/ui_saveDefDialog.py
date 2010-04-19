# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'ui_saveDefDialog.ui'
#
# Created: Mon Sep 10 08:54:30 2007
#      by: PyQt4 UI code generator 4.3
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

class Ui_saveDefDialog(object):
    def setupUi(self, saveDefDialog):
        saveDefDialog.setObjectName("saveDefDialog")
        saveDefDialog.resize(QtCore.QSize(QtCore.QRect(0,0,208,139).size()).expandedTo(saveDefDialog.minimumSizeHint()))

        self.buttonBox = QtGui.QDialogButtonBox(saveDefDialog)
        self.buttonBox.setGeometry(QtCore.QRect(24,100,161,32))
        self.buttonBox.setOrientation(QtCore.Qt.Horizontal)
        self.buttonBox.setStandardButtons(QtGui.QDialogButtonBox.Cancel|QtGui.QDialogButtonBox.NoButton|QtGui.QDialogButtonBox.Ok)
        self.buttonBox.setObjectName("buttonBox")

        self.editName = QtGui.QLineEdit(saveDefDialog)
        self.editName.setGeometry(QtCore.QRect(88,8,113,22))
        self.editName.setObjectName("editName")

        self.editCoord = QtGui.QLineEdit(saveDefDialog)
        self.editCoord.setGeometry(QtCore.QRect(88,36,113,22))
        self.editCoord.setObjectName("editCoord")

        self.label = QtGui.QLabel(saveDefDialog)
        self.label.setGeometry(QtCore.QRect(12,12,52,16))
        self.label.setObjectName("label")

        self.label_2 = QtGui.QLabel(saveDefDialog)
        self.label_2.setGeometry(QtCore.QRect(12,40,69,16))
        self.label_2.setObjectName("label_2")

        self.label_3 = QtGui.QLabel(saveDefDialog)
        self.label_3.setGeometry(QtCore.QRect(12,68,52,16))
        self.label_3.setObjectName("label_3")

        self.chooseBdd = QtGui.QComboBox(saveDefDialog)
        self.chooseBdd.setGeometry(QtCore.QRect(88,68,113,22))
        self.chooseBdd.setObjectName("chooseBdd")

        self.retranslateUi(saveDefDialog)
        QtCore.QObject.connect(self.buttonBox,QtCore.SIGNAL("accepted()"),saveDefDialog.accept)
        QtCore.QObject.connect(self.buttonBox,QtCore.SIGNAL("rejected()"),saveDefDialog.reject)
        QtCore.QMetaObject.connectSlotsByName(saveDefDialog)

    def retranslateUi(self, saveDefDialog):
        saveDefDialog.setWindowTitle(QtGui.QApplication.translate("saveDefDialog", "Sauvegarder", None, QtGui.QApplication.UnicodeUTF8))
        self.label.setText(QtGui.QApplication.translate("saveDefDialog", "Nom :", None, QtGui.QApplication.UnicodeUTF8))
        self.label_2.setText(QtGui.QApplication.translate("saveDefDialog", "Coordonées", None, QtGui.QApplication.UnicodeUTF8))
        self.label_3.setText(QtGui.QApplication.translate("saveDefDialog", "Base :", None, QtGui.QApplication.UnicodeUTF8))

