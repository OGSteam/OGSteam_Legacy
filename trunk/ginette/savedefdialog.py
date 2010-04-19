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
from ui_saveDefDialog import Ui_saveDefDialog
import os


class saveDefDialog(QtGui.QDialog):
	def __init__(self):
		QtGui.QDialog.__init__(self)
		self.ui = Ui_saveDefDialog()
		self.ui.setupUi(self)
		self.ui.setupUi(self)
		self.dbList = [f for f in os.listdir('./db/') if os.path.isfile(os.path.join('./db/', f))]
		self.ui.chooseBdd.addItems(self.dbList)
		self.bdd = self.dbList[0]
		self.connect(self.ui.chooseBdd,QtCore.SIGNAL("currentIndexChanged(const QString &)"), self.chooseBdd)


	def chooseBdd(self, name):
		self.bdd = str(name)



