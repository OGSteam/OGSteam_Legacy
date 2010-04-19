#!/usr/bin/python
# -*- coding: utf8 -*-

"""
Copyright (C) 2007 Flying Mustash.

This program is free software ; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation ; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY ; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program ; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
"""

from PyQt4 import QtCore, QtGui
from ui_prefs import Ui_DialogPrefs
import os, cPickle


class ManagePrefs(QtGui.QDialog):
	def __init__(self, prefs):
		QtGui.QDialog.__init__(self)
		self.ui = Ui_DialogPrefs()
		self.ui.setupUi(self)
		self.prefs = prefs
		self.loadValues()

		self.connect(self.ui.listWidgetMenu,QtCore.SIGNAL("currentRowChanged(int)"), self.changeStack)

		self.connect(self.ui.checkBoxAuto,QtCore.SIGNAL("stateChanged(int)"), self.setAutoTechno)
		self.connect(self.ui.groupBoxPond,QtCore.SIGNAL("toggled(bool)"), self.setDeutPond)
		self.connect(self.ui.checkBoxEngeener,QtCore.SIGNAL("stateChanged(int)"), self.setAutoEngeener)

		self.connect(self.ui.lineEditPm,QtCore.SIGNAL("textChanged(const QString&)"), self.setPondValue)

		self.connect(self.ui.lineEditA,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoA)
		self.connect(self.ui.lineEditB,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoB)
		self.connect(self.ui.lineEditP,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoP)
		self.connect(self.ui.lineEditC,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoC)
		self.connect(self.ui.lineEditI,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoI)
		self.connect(self.ui.lineEditH,QtCore.SIGNAL("textChanged(const QString&)"), self.setTechnoH)

		self.connect(self.ui.lineEditP1,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP1)
		self.connect(self.ui.lineEditP2,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP2)
		self.connect(self.ui.lineEditP3,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP3)
		self.connect(self.ui.lineEditP4,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP4)
		self.connect(self.ui.lineEditP5,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP5)
		self.connect(self.ui.lineEditP6,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP6)
		self.connect(self.ui.lineEditP7,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP7)
		self.connect(self.ui.lineEditP8,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP8)
		self.connect(self.ui.lineEditP9,QtCore.SIGNAL("textChanged(const QString&)"), self.setPosP9)

		self.connect(self.ui.comboBoxStyle,QtCore.SIGNAL("currentIndexChanged(const QString&)"), self.setQtStyle)
		self.connect(self.ui.checkBoxForceStyle,QtCore.SIGNAL("stateChanged(int)"), self.setForceStyle)

		self.connect(self.ui.comboBoxCss,QtCore.SIGNAL("currentIndexChanged(const QString&)"), self.setCss)


	def changeStack(self, index):
		self.ui.stackedWidget.setCurrentIndex(index)

	def boolFromCheckBox(self, i):
		if i == 0:return False
		if i == 2:return True

	def boolFromCheckGroup(self, i):
		if i == False:return False
		else:return True

	def boolForCheckBox(self, i):
		if i == True:return QtCore.Qt.Checked
		if i == False:return QtCore.Qt.Unchecked

	def setAutoTechno(self, i):
		self.prefs.autoTechno = self.boolFromCheckBox(i)

	def setAutoEngeener(self, i):
		self.prefs.autoEngeener = self.boolFromCheckBox(i)

	def setDeutPond(self, i):
		self.prefs.deutPond = self.boolFromCheckGroup(i)

	def setPondValue(self, v):
		self.prefs.deutPondValue = str(v)

	def setTechnoA(self, v):
		self.prefs.techno[0] = int(v)

	def setTechnoB(self, v):
		self.prefs.techno[1] = int(v)

	def setTechnoP(self, v):
		self.prefs.techno[2] = int(v)

	def setTechnoC(self, v):
		self.prefs.techno[3] = int(v)

	def setTechnoI(self, v):
		self.prefs.techno[4] = int(v)

	def setTechnoH(self, v):
		self.prefs.techno[5] = int(v)



	def setPosP1(self, v):
		self.prefs.pos[0] = str(v)

	def setPosP2(self, v):
		self.prefs.pos[1] = str(v)

	def setPosP3(self, v):
		self.prefs.pos[2] = str(v)

	def setPosP4(self, v):
		self.prefs.pos[3] = str(v)

	def setPosP5(self, v):
		self.prefs.pos[4] = str(v)

	def setPosP6(self, v):
		self.prefs.pos[5] = str(v)

	def setPosP7(self, v):
		self.prefs.pos[6] = str(v)

	def setPosP8(self, v):
		self.prefs.pos[7] = str(v)

	def setPosP9(self, v):
		self.prefs.pos[8] = str(v)

	def setForceStyle(self, i):
		self.prefs.forceQtStyle = self.boolFromCheckBox(i)

	def setQtStyle(self, v):
		self.prefs.qtStyle = str(v)
		self.prefs.qtStyleIndex = self.ui.comboBoxStyle.currentIndex()

	def setCss(self, v):
		self.prefs.style = str(v)

	def loadValues(self):
		self.ui.checkBoxAuto.setCheckState(self.boolForCheckBox(self.prefs.autoTechno))
		self.ui.checkBoxEngeener.setCheckState(self.boolForCheckBox(self.prefs.autoEngeener))
		self.ui.groupBoxPond.setChecked(self.prefs.deutPond)

		self.ui.lineEditPm.setText(str(self.prefs.deutPondValue))

		self.ui.lineEditA.setText(str(self.prefs.techno[0]))
		self.ui.lineEditB.setText(str(self.prefs.techno[1]))
		self.ui.lineEditP.setText(str(self.prefs.techno[2]))
		self.ui.lineEditC.setText(str(self.prefs.techno[3]))
		self.ui.lineEditI.setText(str(self.prefs.techno[4]))
		self.ui.lineEditH.setText(str(self.prefs.techno[5]))

		self.ui.lineEditP1.setText(str(self.prefs.pos[0]))
		self.ui.lineEditP2.setText(str(self.prefs.pos[1]))
		self.ui.lineEditP3.setText(str(self.prefs.pos[2]))
		self.ui.lineEditP4.setText(str(self.prefs.pos[3]))
		self.ui.lineEditP5.setText(str(self.prefs.pos[4]))
		self.ui.lineEditP6.setText(str(self.prefs.pos[5]))
		self.ui.lineEditP7.setText(str(self.prefs.pos[6]))
		self.ui.lineEditP8.setText(str(self.prefs.pos[7]))
		self.ui.lineEditP9.setText(str(self.prefs.pos[8]))

		self.ui.checkBoxForceStyle.setCheckState(self.boolForCheckBox(self.prefs.forceQtStyle))
		for i in QtGui.QStyleFactory.keys():
			self.ui.comboBoxStyle.addItem(i)
		self.ui.comboBoxStyle.setCurrentIndex(self.prefs.qtStyleIndex)

		cssList = [f for f in os.listdir('./config/styles/') if os.path.isdir(os.path.join('./config/styles/', f)) and os.path.exists('./config/styles/'+f+'/style.qss')]
		for i in cssList:
			self.ui.comboBoxCss.addItem(i)
		index = self.ui.comboBoxCss.findText(self.prefs.style)
		if index is not -1:
			self.ui.comboBoxCss.setCurrentIndex(index)
		else:
			self.ui.comboBoxCss.setCurrentIndex(self.ui.comboBoxCss.findText('defaut'))


class PrefsContainer(object):
	def __init__(self):
		self.autoTechno = True
		self.deutPond = False
		self.deutPondValue = 1
		self.techno = [''] * 6
		self.pos = [''] * 9
		self.forceQtStyle = False
		self.qtStyle = ''
		self.qtStyleIndex = 0
		self.style = 'defaut'
		self.autoEngeener = False

