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
from ui_manageDb import Ui_manageDb
import os, cPickle
from datetime import *
from functions import *
try:from pysqlite2 import dbapi2 as sqlite
except : pass


class manageDb(QtGui.QDialog):
	""" Gestion des bases de données """
	def __init__(self):
		QtGui.QDialog.__init__(self)
		self.ui = Ui_manageDb()
		self.ui.setupUi(self)
		self.dbList = [f for f in os.listdir('./db/') if os.path.isfile(os.path.join('./db/', f))]
		self.bdd = self.dbList[0]
		self.otherDb = [f for f in os.listdir('./db/') if (os.path.isfile(os.path.join('./db/', f))) and (f != self.bdd)]
		self.ui.chooseBdd.addItems(self.dbList)
		self.ui.cibleBrowser.setColumnCount(10)
		#self.ui.cibleBrowser.setHeaderLabels(['Nom', 'Coord.', 'ressources', 'M', 'C', 'D', 'Flotte', 'Def', 'Gain'])
		self.header = customHeader()
		self.ui.cibleBrowser.setHeaderItem(self.header)
		self.loadDb()
		self.connect(self.ui.chooseBdd,QtCore.SIGNAL("currentIndexChanged(const QString &)"), self.changeDb)
		self.connect(self.ui.cibleBrowser,QtCore.SIGNAL("currentItemChanged(QTreeWidgetItem *, QTreeWidgetItem *)"), self.selectItem)
		self.ui.cibleBrowser.setContextMenuPolicy(QtCore.Qt.CustomContextMenu)
		self.connect(self.ui.cibleBrowser,QtCore.SIGNAL("customContextMenuRequested(const QPoint &)"), self.contextMenu)
		self.createCopyItemMenu()
		self.createDisplaceItemMenu()
		self.connect(self.ui.saveCommentButton,QtCore.SIGNAL("clicked()"), self.updateComment)


	def loadDb(self):
		""" Charge une basse de données """
		self.ui.cibleBrowser.clear()
		self.cx = sqlite.connect('./db/'+str(self.bdd))
		self.cur = self.cx.cursor()
		self.cur.execute("select * from cibles")
		for row in self.cur.fetchall():
			dbListViewItem(row, self.ui.cibleBrowser)
		for col in range(10):
			self.ui.cibleBrowser.resizeColumnToContents(col)

	def changeDb(self,name):
		""" Change de base de données """
		self.bdd = str(name)
		self.otherDb = [f for f in os.listdir('./db/') if (os.path.isfile(os.path.join('./db/', f))) and (f != self.bdd)]
		self.createCopyItemMenu()
		self.createDisplaceItemMenu()
		self.loadDb()

	def createCopyItemMenu(self):
		""" Crée les sous menus pour copier une entrée """
		self.copyItemMenu = QtGui.QMenu()
		self.copyItemMenu.setTitle('Copier vers')
		if len(self.otherDb) > 0:
			for i in self.otherDb:
			 self.copyItemMenu.addAction(i)
		self.connect(self.copyItemMenu,QtCore.SIGNAL("triggered(QAction *)"), self.copyItem)

	def createDisplaceItemMenu(self):
		""" Crée les sous menus pour déplacer une entrée """
		self.displaceItemMenu = QtGui.QMenu()
		self.displaceItemMenu.setTitle('Deplacer vers')
		if len(self.otherDb) > 0:
			for i in self.otherDb:
			 self.displaceItemMenu.addAction(i)
		self.connect(self.displaceItemMenu,QtCore.SIGNAL("triggered(QAction *)"), self.displaceItem)

	def selectItem(self,a,b):
		""" Selectionne une entrée """
		self.itemSelected = a
		try:
			self.ui.commentEdit.setHtml(QtCore.QString(self.itemSelected.comment))
			tab = getHtmlReFromFlotte([str(self.itemSelected.dbTupple[7]),str(self.itemSelected.dbTupple[8]),str(self.itemSelected.dbTupple[9]),self.itemSelected.dbTupple[2]],cPickle.loads(str(self.itemSelected.dbTupple[3])).tabFlotte, cPickle.loads(str(self.itemSelected.dbTupple[4])).tabDef, cPickle.loads(str(self.itemSelected.dbTupple[5])).tabTek)
			self.ui.reBrowser.setHtml(QtCore.QString(QtCore.QString.fromUtf8(tab)))
		except:
			self.ui.reBrowser.setHtml('')
			self.ui.commentEdit.setHtml('')

	def contextMenu(self,point):
		""" Menu contextuel sur une entrée """
		item = self.ui.cibleBrowser.itemAt(point)
		if item is not None:
			self.itemSelected = item
			self.menu = QtGui.QMenu()
			self.menu.addAction('Changer le nom', self.changeName)
			self.menu.addAction('Supprimer', self.deleteItem)
			self.menu.addMenu(self.copyItemMenu)
			self.menu.addMenu(self.displaceItemMenu)
			self.menu.popup(self.cursor().pos())

	def deleteItem(self):
		""" Efface une entrée """
		self.cur.execute('delete from cibles where rowid ='+str(self.itemSelected.rowid))
		self.cx.commit()
		self.ui.cibleBrowser.takeTopLevelItem(self.ui.cibleBrowser.indexOfTopLevelItem(self.itemSelected))


	def copyItem(self, action):
		""" copie une entrée dans une autre bdd """
		cx = sqlite.connect('./db/'+str(action.text()))
		cur = cx.cursor()
		cur.execute("insert into cibles (name,coord,flotte,deff,tek,r,m,c,d,vflotte,vdef,gain,timestamp,aflotte,atek,comment) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", (self.itemSelected.name,self.itemSelected.dbTupple[2],self.itemSelected.dbTupple[3],self.itemSelected.dbTupple[4],self.itemSelected.dbTupple[5],self.itemSelected.dbTupple[6],self.itemSelected.dbTupple[7],self.itemSelected.dbTupple[8],self.itemSelected.dbTupple[9],self.itemSelected.dbTupple[10],self.itemSelected.dbTupple[11],self.itemSelected.dbTupple[12],self.itemSelected.dbTupple[13],self.itemSelected.dbTupple[14],self.itemSelected.dbTupple[15],str(self.ui.commentEdit.toHtml().toUtf8())))
		cx.commit()

	def displaceItem(self, action):
		""" déplace une entrée vers une autre bdd """
		self.copyItem(action)
		self.deleteItem()

	def updateComment(self):
		""" edite le commentaire """
		comment = str(self.ui.commentEdit.toHtml().toUtf8())
		self.cur.execute('update cibles set comment = ? where rowid = ?', (comment, str(self.itemSelected.rowid)))
		self.cx.commit()
		self.itemSelected.comment = self.ui.commentEdit.toHtml()

	def changeName(self):
		""" change le champ nom d'une entrée """
		name, ok = QtGui.QInputDialog.getText(self, QtCore.QString.fromUtf8('Edition'),'Entrez le nom', QtGui.QLineEdit.Normal, '')
		if ok == True and len(str(name)) > 0:
			name = str(name)
			self.cur.execute('update cibles set name = ? where rowid = ?', (name, str(self.itemSelected.rowid)))
			self.cx.commit()
			self.itemSelected.name = name
			self.itemSelected.setText(0, name)


class dbListViewItem(QtGui.QTreeWidgetItem):
	""" Entrée correspondant à une ligne dans la bdd et dans la liste """
	def __init__(self, dbTupple, parent=None):
		QtGui.QTreeWidgetItem.__init__(self, parent)
		self.parent = parent
		self.dbTupple = dbTupple
		self.rowid = dbTupple[0]
		self.name = dbTupple[1]
		self.comment = dbTupple[16]
		self.colType = [0]*10
		self.setText(0, self.name)
		self.colType[0] = 'string'
		self.setText(1, dbTupple[2])
		self.colType[1] = 'coord'
		self.setText(2, QtCore.QString(str(number_format(self.dbTupple[6]))))
		self.setTextAlignment (2, 2)
		self.colType[2] = 'fInt'
		self.setText(3, QtCore.QString(str(number_format(self.dbTupple[7]))))
		self.setTextAlignment (3, 2)
		self.colType[3] = 'fInt'
		self.setText(4, QtCore.QString(str(number_format(self.dbTupple[8]))))
		self.setTextAlignment (4, 2)
		self.colType[4] = 'fInt'
		self.setText(5, QtCore.QString(str(number_format(self.dbTupple[9]))))
		self.setTextAlignment (5, 2)
		self.colType[5] = 'fInt'
		self.setText(6, QtCore.QString(str(number_format(self.dbTupple[10]))))
		self.setTextAlignment (6, 2)
		self.colType[6] = 'fInt'
		self.setText(7, QtCore.QString(str(number_format(self.dbTupple[11]))))
		self.setTextAlignment (7, 2)
		self.colType[7] = 'fInt'
		self.setText(8, QtCore.QString(str(number_format(self.dbTupple[12]))))
		self.setTextAlignment (8, 2)
		self.colType[8] = 'fInt'
		self.setText(9, QtCore.QString(str(datetime.fromtimestamp(self.dbTupple[13]))))
		self.setTextAlignment (9, 2)
		self.colType[9] = 'date'

	def __lt__ (self, other):
		""" Surcharge de l'opérateur < pour permettre le tri suivant les données """
		sortCol = self.parent.sortColumn()
		if self.colType[sortCol] == 'fInt':
			myNumber = self.text(sortCol).replace('.','').toInt()
			otherNumber = other.text(sortCol).replace('.','').toInt()
			return myNumber < otherNumber
		if self.colType[sortCol] == 'coord':
			myNumber = self.text(sortCol).split(':')
			mN = myNumber[0].toInt()[0] * 10000000 + myNumber[1].toInt()[0] * 5000 + myNumber[2].toInt()[0]
			otherNumber = other.text(sortCol).split(':')
			oN = otherNumber[0].toInt()[0] * 10000000 + otherNumber[1].toInt()[0] * 5000 + otherNumber[2].toInt()[0]
			return mN < oN
		if self.colType[sortCol] == 'date':
			myNumber = self.dbTupple[13]
			otherNumber = other.dbTupple[13]
			return myNumber < otherNumber
		if self.colType[sortCol] == 'string':
			return self.text(sortCol).compare(other.text(sortCol)) < 0




class customHeader(QtGui.QTreeWidgetItem):
	""" Header perso, peut-être à virer """
	def __init__(self):
		QtGui.QTreeWidgetItem.__init__(self)
		self.setText(0, QtCore.QString('Nom'))
		self.setTextAlignment (0, 4)
		self.setText(1, QtCore.QString('Coord'))
		self.setTextAlignment (1, 4)
		self.setText(2, QtCore.QString('Ressources'))
		self.setTextAlignment (2, 4)
		self.setText(3, QtCore.QString('M'))
		self.setTextAlignment (3, 4)
		self.setText(4, QtCore.QString('C'))
		self.setTextAlignment (4, 4)
		self.setText(5, QtCore.QString('D'))
		self.setTextAlignment (5, 4)
		self.setText(6, QtCore.QString('Flotte'))
		self.setTextAlignment (6, 4)
		self.setText(7, QtCore.QString('Def'))
		self.setTextAlignment (7, 4)
		self.setText(8, QtCore.QString('Gain'))
		self.setTextAlignment (8, 4)
		self.setText(9, QtCore.QString('Date'))
		self.setTextAlignment (9, 4)
