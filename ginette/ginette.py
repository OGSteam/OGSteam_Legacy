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

try: import psyco; psyco.full()
except: pass

import os, string, re, platform, cPickle, math

print '###################################################'
print 'Ginette V0.3.10'
print "plateforme : ", platform.system(), platform.machine(), platform.architecture()[0]

try:
	from PyQt4 import QtGui, QtCore
	from ui_main import Ui_MainWindow
	from ui_simulatorWidget import Ui_simulatorWidget
	print 'version de PyQt :', QtCore.PYQT_VERSION_STR
except:
	print 'Erreur : le module PyQt4 ne semble pas être installé !'
  #sys.exit()

try: from pysqlite2 import dbapi2 as sqlite
except: print 'SQLite introuvable, les sauvegardes ne seront pas possibles'

print '###################################################'

from savedefdialog import *
from manageDb import *
from managePrefs import *
from histogramWidget import Plotter

from flotte import *
from defense import *
from techno import *
from displacer import *
from csimulator import *
from csimstat import *
from vaisseaux import *

from functions import *

import copy

class GinetteController(QtGui.QMainWindow):
	def __init__(self):
		QtGui.QMainWindow.__init__(self)
		self.version = '0.3.10'
		self.ui = Ui_MainWindow()
		self.ui.setupUi(self)
		self.loadPrefs()
		self.setWindowTitle('Ginette ' + self.version)
		self.ui.tabWidget.removeTab(0)
		self.createTabSimulator()

		self.setQtStyle(self.prefs.qtStyle)
		self.setCss(self.prefs.style)

		self.connect(self.ui.createBdd,QtCore.SIGNAL("triggered()"), self.createDb)
		self.connect(self.ui.manageBdd,QtCore.SIGNAL("triggered()"), self.manageDb)
		self.connect(self.ui.actionApropos,QtCore.SIGNAL("triggered()"), self.showVersion)
		self.connect(self.ui.actionPreferences,QtCore.SIGNAL("triggered()"), self.managePrefs)
		self.connect(self.ui.newTab,QtCore.SIGNAL("triggered()"), self.createTabSimulator)

		self.ui.tabWidget.setContextMenuPolicy(QtCore.Qt.CustomContextMenu)
		self.connect(self.ui.tabWidget,QtCore.SIGNAL("customContextMenuRequested(const QPoint &)"), self.contextTabMenu)

	def contextTabMenu(self, point):
		tab = self.ui.tabWidget.tabBar().tabAt(point)
		if tab is not -1:
			self.tabContext = tab
			self.tabSelected = tab
			self.menu = QtGui.QMenu()
			self.menu.addAction('Fermer l\'onglet', self.deleteTab)
			self.menu.popup(self.cursor().pos())

	def showVersion(self):
		QtGui.QMessageBox.information(self, QtCore.QString('A Propos'), QtCore.QString('Ginette '+self.version+' par Flying Mustash'))

	def createTabSimulator(self):
		tab = SimulatorWidget(self)

		self.ui.tabWidget.addTab(tab,"sim")
		self.ui.tabWidget.setCurrentWidget(tab)
		#self.ui.tabWidget.setTabIcon(self.ui.tabWidget.currentIndex() ,QtGui.QIcon('./bullet1.png'))
		if self.prefs.autoTechno:
			self.ui.tabWidget.currentWidget().ui.tekAarmes.setText(str(self.prefs.techno[0]))
			self.ui.tabWidget.currentWidget().ui.tekAboucl.setText(str(self.prefs.techno[1]))
			self.ui.tabWidget.currentWidget().ui.tekAprotec.setText(str(self.prefs.techno[2]))
			self.ui.tabWidget.currentWidget().ui.tekComb.setText(str(self.prefs.techno[3]))
			self.ui.tabWidget.currentWidget().ui.tekImp.setText(str(self.prefs.techno[4]))
			self.ui.tabWidget.currentWidget().ui.tekHyp.setText(str(self.prefs.techno[5]))
		if self.prefs.autoEngeener:
			self.ui.tabWidget.currentWidget().ui.haveEngeener.setCheckState(QtCore.Qt.Checked)
		for i in range(0,9):
			if re.match('^\d:\d{1,3}:\d{1,2}$', self.prefs.pos[i]):
				self.ui.tabWidget.currentWidget().ui.depart.addItem(self.prefs.pos[i])

	def deleteTab(self):
		tab = self.ui.tabWidget.currentWidget()
		self.ui.tabWidget.removeTab(self.tabContext)
		del(tab)

	def createDb(self):
		""" Création d'une bdd """
		bdd, ok = QtGui.QInputDialog.getText(self, QtCore.QString.fromUtf8('Création de bdd'),'Entrez le nom de la base', QtGui.QLineEdit.Normal, '')
		if ok == True and len(str(bdd)) > 0:
			cx = sqlite.connect('./db/'+str(bdd)+'.db')
			cur = cx.cursor()
			cur.execute("create table cibles (rowid integer primary key, name char(60), coord char(20), flotte text, deff text, tek text, r int, m int, c int, d int, vflotte int, vdef int, gain int, timestamp int, aflotte text, atek text, comment text)")
			cx.commit()

	def manageDb(self):
		""" Gestion des bdd, ouvre le manager """
		self.manageDbDialog = manageDb()
		self.manageDbDialog.show()
		self.connect(self.manageDbDialog.ui.cibleBrowser,QtCore.SIGNAL("itemDoubleClicked(QTreeWidgetItem *, int)"), self.getFltFromDb)

	def getFltFromDb(self,a,v):
		""" Récupération d'une entrée de la bdd """
		self.ui.tabWidget.currentWidget().updateFret()
		self.ui.tabWidget.currentWidget().dTek = cPickle.loads(str(self.manageDbDialog.itemSelected.dbTupple[5]))
		self.ui.tabWidget.currentWidget().dFlotte = cPickle.loads(str(self.manageDbDialog.itemSelected.dbTupple[3]))
		self.ui.tabWidget.currentWidget().dDef = cPickle.loads(str(self.manageDbDialog.itemSelected.dbTupple[4]))
		self.ui.tabWidget.currentWidget().updateInputsFromdTek()
		self.ui.tabWidget.currentWidget().updateInputsFromdFlotte()
		self.ui.tabWidget.currentWidget().updateInputsFromdDef()
		self.ui.tabWidget.currentWidget().ui.ressM.setText(str(self.manageDbDialog.itemSelected.dbTupple[7]))
		self.ui.tabWidget.currentWidget().ui.ressC.setText(str(self.manageDbDialog.itemSelected.dbTupple[8]))
		self.ui.tabWidget.currentWidget().ui.ressD.setText(str(self.manageDbDialog.itemSelected.dbTupple[9]))
		self.ui.tabWidget.currentWidget().ui.cible.setText(str(self.manageDbDialog.itemSelected.dbTupple[2]))
		self.ui.tabWidget.currentWidget().outD()
		self.ui.tabWidget.currentWidget().updateFret()

	def managePrefs(self):
		""" ouvre le dialogue de préférences """
		tempPrefs = copy.deepcopy(self.prefs)
		self.managePrefsDialog = ManagePrefs(tempPrefs)
		r = self.managePrefsDialog.exec_()
		if r == 1:
			cPickle.dump(tempPrefs, open('./config/prefs.obj', 'wb'))
			self.prefs = tempPrefs
			self.setQtStyle(self.prefs.qtStyle)
			self.setCss(self.prefs.style)
		else:
			del(tempPrefs)

	def loadPrefs(self):
		try:self.prefs = cPickle.load(open('./config/prefs.obj'))
		except:self.prefs = PrefsContainer()

	def setQtStyle(self, style):
		if self.prefs.forceQtStyle:
			QtGui.QApplication.setStyle(QtGui.QStyleFactory.create(style))
		else:
			QtGui.QApplication.setStyle(QtGui.QStyleFactory.create(''))

	def setCss(self, theme):
		try : file = open('./config/styles/'+theme+'/style.qss','r').read()
		except: print 'impossible de charger la feuille de style'

		try: app.setStyleSheet(file)
		except: print 'votre version de Qt ne supporte peut-être pas les feuilles de style'


class SimulatorWidget(QtGui.QWidget):
	def __init__(self, parent = None):
		QtGui.QWidget.__init__(self, parent)
		self.ui = Ui_simulatorWidget()
		self.ui.setupUi(self)
		self.wave = 1
		self.ui.nextWave.setVisible(False)
		#self.setProperty("test", QtCore.QVariant(1))
		self.parent = parent

		self.plotter = Plotter(self.ui.tabGraph)
		self.plotter.setGeometry(QtCore.QRect(8,120,440,250))
		self.connect(self.ui.histoBarSlider,QtCore.SIGNAL("valueChanged(int)"), self.plotter.setBar)

		self.aFlotte = flotte()
		self.dFlotte = flotte()
		self.dDef = defense()
		self.aFlotteInputs = (self.ui.aPt, self.ui.aGt, self.ui.aCle, self.ui.aClo, self.ui.aCro, self.ui.aVb, self.ui.aVc, self.ui.aRe, self.ui.aSe, self.ui.aBo, self.ui.aDe, self.ui.aEm, self.ui.aTr)
		self.dFlotteInputs = (self.ui.dPt, self.ui.dGt, self.ui.dCle, self.ui.dClo, self.ui.dCro, self.ui.dVb, self.ui.dVc, self.ui.dRe, self.ui.dSe, self.ui.dBo, self.ui.dSs, self.ui.dDe, self.ui.dEm, self.ui.dTr)
		self.dDefInputs = (self.ui.dLm, self.ui.dLe, self.ui.dLo, self.ui.dCg, self.ui.dAi, self.ui.dLp, self.ui.dPb, self.ui.dGb, self.ui.dMi)
		self.resInputs = (self.ui.ressM, self.ui.ressC, self.ui.ressD)
		self.dTekInputs = (self.ui.tekDarmes, self.ui.tekDboucl, self.ui.tekDprotec)
		self.aTek = techno()
		self.dTek = techno()
		self.Apos = [0, 0, 0, 0]
		self.Dpos = [0, 0, 0, 0]
		self.vitesse = [100]
		self.phallangeStamp = [0]
		self.Displace = displacer(self.vitesse, self.Apos, self.Dpos, self.aFlotte, self.aTek, self)
		self.upAtek()
		self.upDtek()
		self.simButton = 0
		self.isSimulated = False
		self.fretType = self.ui.comboBoxFret.currentIndex()

		self.connect(self.ui.vitesse,QtCore.SIGNAL("valueChanged(int)"), self.calcTime)
		self.connect(self.ui.phallange,QtCore.SIGNAL("dateTimeChanged(const QDateTime&)"), self.phallange)
		self.ui.phallange.setDateTime(QtCore.QDateTime.currentDateTime())
		self.connect(self.ui.copyPaste,QtCore.SIGNAL("textChanged(const QString&)"), self.parseRE)

		self.connect(self.ui.depart,QtCore.SIGNAL("editTextChanged(const QString&)"), self.upApos)
		self.connect(self.ui.cible,QtCore.SIGNAL("textChanged(const QString&)"), self.upDpos)

		self.connect(self.ui.simuler,QtCore.SIGNAL("clicked()"), self.simul)

		self.connect(self.ui.resetAtt,QtCore.SIGNAL("clicked()"), self.resetAtt)
		self.connect(self.ui.resetDef,QtCore.SIGNAL("clicked()"), self.resetDef)
		self.connect(self.ui.swapFlottes,QtCore.SIGNAL("clicked()"), self.swap)
		self.connect(self.ui.saveDef,QtCore.SIGNAL("clicked()"), self.saveDef)
		self.connect(self.ui.nextWave,QtCore.SIGNAL("clicked()"), self.createNextWave)

		self.connect(self.ui.comboBoxFret,QtCore.SIGNAL("activated(int)"), self.updateFretType)

		self.connect(self.ui.comboBoxChooseHisto,QtCore.SIGNAL("activated(int)"), self.changeHisto)

		self.connect(self.ui.ressM,QtCore.SIGNAL("textChanged(const QString&)"), self.updateFret)
		self.connect(self.ui.ressC,QtCore.SIGNAL("textChanged(const QString&)"), self.updateFret)
		self.connect(self.ui.ressD,QtCore.SIGNAL("textChanged(const QString&)"), self.updateFret)


		self.connectAflotte()
		self.connectDflotte()
		self.connectDdef()
		self.connectDtek()
		self.connectAtek()

		self.histoView = 0


	def connectAflotte(self):
		self.connect(self.ui.aPt,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aPt)
		self.connect(self.ui.aGt,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aGt)
		self.connect(self.ui.aCle,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aCle)
		self.connect(self.ui.aClo,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aClo)
		self.connect(self.ui.aCro,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aCro)
		self.connect(self.ui.aVb,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aVb)
		self.connect(self.ui.aVc,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aVc)
		self.connect(self.ui.aRe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aRe)
		self.connect(self.ui.aSe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aSe)
		self.connect(self.ui.aBo,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aBo)
		self.connect(self.ui.aDe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aDe)
		self.connect(self.ui.aEm,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aEm)
		self.connect(self.ui.aTr,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aTr)


	def disconnectAflotte(self):
		self.disconnect(self.ui.aPt,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aPt)
		self.disconnect(self.ui.aGt,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aGt)
		self.disconnect(self.ui.aCle,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aCle)
		self.disconnect(self.ui.aClo,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aClo)
		self.disconnect(self.ui.aCro,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aCro)
		self.disconnect(self.ui.aVb,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aVb)
		self.disconnect(self.ui.aVc,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aVc)
		self.disconnect(self.ui.aRe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aRe)
		self.disconnect(self.ui.aSe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aSe)
		self.disconnect(self.ui.aBo,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aBo)
		self.disconnect(self.ui.aDe,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aDe)
		self.disconnect(self.ui.aEm,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aEm)
		self.disconnect(self.ui.aTr,QtCore.SIGNAL("textChanged(const QString&)"), self.upAflotte_aTr)

	def connectDflotte(self):
		self.connect(self.ui.dPt,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dPt)
		self.connect(self.ui.dGt,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dGt)
		self.connect(self.ui.dCle,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dCle)
		self.connect(self.ui.dClo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dClo)
		self.connect(self.ui.dCro,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dCro)
		self.connect(self.ui.dVb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dVb)
		self.connect(self.ui.dVc,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dVc)
		self.connect(self.ui.dRe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dRe)
		self.connect(self.ui.dSe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dSe)
		self.connect(self.ui.dBo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dBo)
		self.connect(self.ui.dSs,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dSs)
		self.connect(self.ui.dDe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dDe)
		self.connect(self.ui.dEm,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dEm)
		self.connect(self.ui.dTr,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dTr)

	def disconnectDflotte(self):
		self.disconnect(self.ui.dPt,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dPt)
		self.disconnect(self.ui.dGt,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dGt)
		self.disconnect(self.ui.dCle,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dCle)
		self.disconnect(self.ui.dClo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dClo)
		self.disconnect(self.ui.dCro,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dCro)
		self.disconnect(self.ui.dVb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dVb)
		self.disconnect(self.ui.dVc,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dVc)
		self.disconnect(self.ui.dRe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dRe)
		self.disconnect(self.ui.dSe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dSe)
		self.disconnect(self.ui.dBo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dBo)
		self.disconnect(self.ui.dSs,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dSs)
		self.disconnect(self.ui.dDe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dDe)
		self.disconnect(self.ui.dEm,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dEm)
		self.disconnect(self.ui.dTr,QtCore.SIGNAL("textChanged(const QString&)"), self.upDflotte_dTr)

	def connectDdef(self):
		self.connect(self.ui.dLm,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLm)
		self.connect(self.ui.dLe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLe)
		self.connect(self.ui.dLo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLo)
		self.connect(self.ui.dCg,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dCg)
		self.connect(self.ui.dAi,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dAi)
		self.connect(self.ui.dLp,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLp)
		self.connect(self.ui.dPb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dPb)
		self.connect(self.ui.dGb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dGb)
		self.connect(self.ui.dMi,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dMi)
		#self.connect(self.ui.dMip,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dMip)

	def disconnectDdef(self):
		self.disconnect(self.ui.dLm,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLm)
		self.disconnect(self.ui.dLe,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLe)
		self.disconnect(self.ui.dLo,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLo)
		self.disconnect(self.ui.dCg,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dCg)
		self.disconnect(self.ui.dAi,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dAi)
		self.disconnect(self.ui.dLp,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dLp)
		self.disconnect(self.ui.dPb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dPb)
		self.disconnect(self.ui.dGb,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dGb)
		self.disconnect(self.ui.dMi,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dMi)
		#self.disconnect(self.ui.dMip,QtCore.SIGNAL("textChanged(const QString&)"), self.upDdef_dMip)

	def connectDtek(self):
		self.connect(self.ui.tekDarmes,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)
		self.connect(self.ui.tekDboucl,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)
		self.connect(self.ui.tekDprotec,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)

	def disconnectDtek(self):
		self.disconnect(self.ui.tekDarmes,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)
		self.disconnect(self.ui.tekDboucl,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)
		self.disconnect(self.ui.tekDprotec,QtCore.SIGNAL("textChanged(const QString&)"), self.upDtek)

	def connectAtek(self):
		self.connect(self.ui.tekAarmes,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.connect(self.ui.tekAboucl,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.connect(self.ui.tekAprotec,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.connect(self.ui.tekComb,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.connect(self.ui.tekImp,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.connect(self.ui.tekHyp,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)

	def disconnectAtek(self):
		self.disconnect(self.ui.tekAarmes,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.disconnect(self.ui.tekAboucl,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.disconnect(self.ui.tekAprotec,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.disconnect(self.ui.tekComb,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.disconnect(self.ui.tekImp,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)
		self.disconnect(self.ui.tekHyp,QtCore.SIGNAL("textChanged(const QString&)"), self.upAtek)

	def simul(self):
		""" Simulation """
		if self.simButton == 0:
			self.simButton = 1
			self.ui.simuler.setText('STOP')
			self.sim = csimulator(self.aFlotte, self.dFlotte, self.dDef)
			if self.sim.libLoaded == True:
				#self.parent.ui.tabWidget.setTabIcon(self.parent.ui.tabWidget.currentIndex() ,QtGui.QIcon('./bullet2.png'))
				self.sim.stats = csimstat()
				self.sim.stats.M = self.ui.ressM.text().toFloat()[0]
				self.sim.stats.C = self.ui.ressC.text().toFloat()[0]
				self.sim.stats.D = self.ui.ressD.text().toFloat()[0]
				self.sim.stats.out = self.showResult
				QtCore.QObject.connect(self.sim, QtCore.SIGNAL("clicked()"), self.showResult)
				self.ui.nextWave.setVisible(True)
				self.sim.start()
				#self.threads.append(self.sim)
			else:
				QtGui.QMessageBox.information(self, QtCore.QString('Attention'), QtCore.QString(u'Pas de libraire pour votre système : '+platform.system()+' '+platform.machine()+' '+platform.architecture()[0]))
		else:
			#self.parent.ui.tabWidget.setTabIcon(self.parent.ui.tabWidget.currentIndex() ,QtGui.QIcon('./bullet1.png'))
			self.simButton = 0
			self.ui.simuler.setText('START')
			self.isSimulated = True
			self.sim.stopped = 1

	def showResult(self):
		""" affichage des résultats de simulation """
		self.ui.ldPt.setText(str(round(self.sim.stats.dMoy[0], 2)))
		self.ui.ldGt.setText(str(round(self.sim.stats.dMoy[1], 2)))
		self.ui.ldCle.setText(str(round(self.sim.stats.dMoy[2], 2)))
		self.ui.ldClo.setText(str(round(self.sim.stats.dMoy[3], 2)))
		self.ui.ldCr.setText(str(round(self.sim.stats.dMoy[4], 2)))
		self.ui.ldVb.setText(str(round(self.sim.stats.dMoy[5], 2)))
		self.ui.ldVc.setText(str(round(self.sim.stats.dMoy[6], 2)))
		self.ui.ldRe.setText(str(round(self.sim.stats.dMoy[7], 2)))
		self.ui.ldSe.setText(str(round(self.sim.stats.dMoy[8], 2)))
		self.ui.ldBo.setText(str(round(self.sim.stats.dMoy[9], 2)))
		self.ui.ldSs.setText(str(round(self.sim.stats.dMoy[10], 2)))
		self.ui.ldDe.setText(str(round(self.sim.stats.dMoy[11], 2)))
		self.ui.ldEm.setText(str(round(self.sim.stats.dMoy[12], 2)))
		self.ui.ldTr.setText(str(round(self.sim.stats.dMoy[13], 2)))

		self.ui.ldLm.setText(str(round(self.sim.stats.dMoy[14], 2)))
		self.ui.ldle.setText(str(round(self.sim.stats.dMoy[15], 2)))
		self.ui.ldLo.setText(str(round(self.sim.stats.dMoy[16], 2)))
		self.ui.ldCg.setText(str(round(self.sim.stats.dMoy[17], 2)))
		self.ui.ldAi.setText(str(round(self.sim.stats.dMoy[18], 2)))
		self.ui.ldLp.setText(str(round(self.sim.stats.dMoy[19], 2)))
		self.ui.ldPb.setText(str(round(self.sim.stats.dMoy[20], 2)))
		self.ui.ldGb.setText(str(round(self.sim.stats.dMoy[21], 2)))
		self.ui.ldMi.setText(str(round(self.sim.stats.dMoy[22], 2)))

		self.ui.laPt.setText(str(round(self.sim.stats.aMoy[0], 2)))
		self.ui.laGt.setText(str(round(self.sim.stats.aMoy[1], 2)))
		self.ui.laCle.setText(str(round(self.sim.stats.aMoy[2], 2)))
		self.ui.laClo.setText(str(round(self.sim.stats.aMoy[3], 2)))
		self.ui.laCr.setText(str(round(self.sim.stats.aMoy[4], 2)))
		self.ui.laVb.setText(str(round(self.sim.stats.aMoy[5], 2)))
		self.ui.laVc.setText(str(round(self.sim.stats.aMoy[6], 2)))
		self.ui.laRe.setText(str(round(self.sim.stats.aMoy[7], 2)))
		self.ui.laSe.setText(str(round(self.sim.stats.aMoy[8], 2)))
		self.ui.laBo.setText(str(round(self.sim.stats.aMoy[9], 2)))
		self.ui.laDe.setText(str(round(self.sim.stats.aMoy[11], 2)))
		self.ui.laEm.setText(str(round(self.sim.stats.aMoy[12], 2)))
		self.ui.laTr.setText(str(round(self.sim.stats.aMoy[13], 2)))

		self.ui.rnbSims.setText('<b>' + str(int(self.sim.stats.nbSim))+ '</b>')
		self.ui.rnbRounds.setText('<b>' + str(round(self.sim.stats.rMoy, 2))+ '</b> max : ' + str(self.sim.stats.rMax))
		self.ui.labelResult.setText(str(self.sim.stats.nbvA)+' victoires A, '+str(self.sim.stats.nbvD)+' victoires D, '+str(self.sim.stats.nbMn)+' matchs nuls')
		self.ui.labelPertes.setText(number_format(self.sim.stats.perteAMmoy)+ ' m  '+number_format(self.sim.stats.perteACmoy)+ ' c '+number_format(self.sim.stats.perteADmoy)+ ' d (<b>'+number_format(self.sim.stats.perteATmoy)+ '</b>)')
		self.ui.labelCdr.setText(number_format(self.sim.stats.CdrMMoy)+ ' m  '+number_format(self.sim.stats.CdrCMoy)+ ' c  (<b>'+number_format(self.sim.stats.CdrTMoy)+ '</b>)')
		self.ui.labelGains.setText(number_format(self.sim.stats.GainsMmoy)+ ' m  '+number_format(self.sim.stats.GainsCmoy)+ ' c (<b>'+number_format(self.sim.stats.GainsTmoy)+ '</b>)')
		self.ui.buttinT.setText(number_format(self.sim.stats.tButM)+ ' m  '+number_format(self.sim.stats.tButC)+ ' c '+number_format(self.sim.stats.tButD)+ ' d (<b>'+number_format(self.sim.stats.tButT)+ '</b>)')
		self.ui.buttinR.setText(number_format(self.sim.stats.tButMmoy)+ ' m  '+number_format(self.sim.stats.tButCmoy)+ ' c '+number_format(self.sim.stats.tButDmoy)+ ' d (<b>'+number_format(self.sim.stats.tButTmoy)+ '</b>)')
		self.ui.labelTotal.setText(number_format(self.sim.stats.totalButMmoy)+ ' m  '+number_format(self.sim.stats.totalButCmoy)+ ' c '+number_format(self.sim.stats.totalButDmoy)+ ' d (<b>'+number_format(self.sim.stats.totalButTmoy)+ '</b>)')

		self.ui.labelPertesAmin.setText(number_format(self.sim.stats.perteATmin))
		self.ui.labelPertesAmoy.setText(number_format(self.sim.stats.perteATmoy))
		self.ui.labelPertesAmax.setText(number_format(self.sim.stats.perteATmax))
		self.ui.labelPertesDmin.setText(number_format(self.sim.stats.perteDTmin))
		self.ui.labelPertesDmoy.setText(number_format(self.sim.stats.perteDTmoy))
		self.ui.labelPertesDmax.setText(number_format(self.sim.stats.perteDTmax))
		self.ui.labelCdrMin.setText(number_format(self.sim.stats.CdrTMin))
		self.ui.labelCdrMoy.setText(number_format(self.sim.stats.CdrTMoy))
		self.ui.labelCdrMax.setText(number_format(self.sim.stats.CdrTMax))
		if not self.parent.prefs.deutPond:
			self.ui.labelGainsMoy.setText(number_format(self.sim.stats.totalButTmoy))
			self.ui.labelGainsMax.setText(number_format(self.sim.stats.totalButTmax))
			self.ui.labelGainsMin.setText(number_format(self.sim.stats.totalButTmin))
		else:
			pond = float(self.parent.prefs.deutPondValue) * float(self.coutDeut)
			self.ui.labelGainsMoy.setText(number_format(self.sim.stats.totalButTmoy - pond))
			self.ui.labelGainsMax.setText(number_format(self.sim.stats.totalButTmax - pond))
			self.ui.labelGainsMin.setText(number_format(self.sim.stats.totalButTmin - pond))
		self.ui.labelRecyMin.setText(number_format(self.sim.stats.recyMin))
		self.ui.labelRecyMoy.setText(number_format(self.sim.stats.recyMoy))
		self.ui.labelRecyMax.setText(number_format(self.sim.stats.recyMax))
		#QToolTip.add(self.ui.labelGainsMoy,number_format(self.sim.stats.totalButTmoy))

		try: self.plotter.setValues(self.sim.stats.tabResults[self.histoView])
		except: pass

	def createNextWave(self):
		index = self.parent.ui.tabWidget.currentIndex() + 1
		tab = SimulatorWidget(self.parent)
		tab.wave = self.wave + 1
		tab.ui.cible.setText(str(self.ui.cible.text()))
		if re.match('^\d:\d{1,3}:\d{1,2}$', str(self.ui.cible.text())):
			text = str(self.ui.cible.text())
		else:
			text = 'sim'
		self.parent.ui.tabWidget.insertTab(index, tab, text+'('+str(tab.wave)+')')
		self.parent.ui.tabWidget.setTabText(self.parent.ui.tabWidget.currentIndex(), text+'('+str(self.wave)+')')

		tab.ui.tekAarmes.setText(self.ui.tekAarmes.text())
		tab.ui.tekAboucl.setText(self.ui.tekAboucl.text())
		tab.ui.tekAprotec.setText(self.ui.tekAprotec.text())
		tab.ui.tekDarmes.setText(self.ui.tekDarmes.text())
		tab.ui.tekDboucl.setText(self.ui.tekDboucl.text())
		tab.ui.tekDprotec.setText(self.ui.tekDprotec.text())
		tab.ui.tekComb.setText(self.ui.tekComb.text())
		tab.ui.tekImp.setText(self.ui.tekImp.text())
		tab.ui.tekHyp.setText(self.ui.tekHyp.text())

		tab.ui.dPt.setText(ceilInputFromFloat((float(self.ui.ldPt.text()))))
		tab.ui.dGt.setText(ceilInputFromFloat((float(self.ui.ldGt.text()))))
		tab.ui.dCle.setText(ceilInputFromFloat((float(self.ui.ldCle.text()))))
		tab.ui.dClo.setText(ceilInputFromFloat((float(self.ui.ldClo.text()))))
		tab.ui.dCro.setText(ceilInputFromFloat((float(self.ui.ldCr.text()))))
		tab.ui.dVb.setText(ceilInputFromFloat((float(self.ui.ldVb.text()))))
		tab.ui.dVc.setText(ceilInputFromFloat((float(self.ui.ldVc.text()))))
		tab.ui.dRe.setText(ceilInputFromFloat((float(self.ui.ldRe.text()))))
		tab.ui.dSe.setText(ceilInputFromFloat((float(self.ui.ldSe.text()))))
		tab.ui.dBo.setText(ceilInputFromFloat((float(self.ui.ldBo.text()))))
		tab.ui.dSs.setText(ceilInputFromFloat((float(self.ui.ldSs.text()))))
		tab.ui.dDe.setText(ceilInputFromFloat((float(self.ui.ldDe.text()))))
		tab.ui.dEm.setText(ceilInputFromFloat((float(self.ui.ldEm.text()))))
		tab.ui.dTr.setText(ceilInputFromFloat((float(self.ui.ldTr.text()))))

		if self.ui.haveEngeener.isChecked():
			tab.ui.haveEngeener.setCheckState(QtCore.Qt.Checked)
			taux = 0.85
		else:
			tab.ui.haveEngeener.setCheckState(QtCore.Qt.Unchecked)
			taux = 0.7

		tab.ui.dLm.setText(getNextDef(self.ui.dLm.text(), self.ui.ldLm.text(), taux))
		tab.ui.dLe.setText(getNextDef(self.ui.dLe.text(), self.ui.ldle.text(), taux))
		tab.ui.dLo.setText(getNextDef(self.ui.dLo.text(), self.ui.ldLo.text(), taux))
		tab.ui.dCg.setText(getNextDef(self.ui.dCg.text(), self.ui.ldCg.text(), taux))
		tab.ui.dAi.setText(getNextDef(self.ui.dAi.text(), self.ui.ldAi.text(), taux))
		tab.ui.dLp.setText(getNextDef(self.ui.dLp.text(), self.ui.ldLp.text(), taux))
		tab.ui.dPb.setText(getNextDef(self.ui.dPb.text(), self.ui.ldPb.text(), taux))
		tab.ui.dGb.setText(getNextDef(self.ui.dGb.text(), self.ui.ldGb.text(), taux))
		tab.ui.dMi.setText(getNextDef(self.ui.dMi.text(), self.ui.ldMi.text(), taux))

		if self.ui.ressM.text() == '': m = 0.0
		else: m = float(self.ui.ressM.text())
		tab.ui.ressM.setText(str(int(math.ceil(m - float(self.sim.stats.tButMmoy)))))
		if self.ui.ressC.text() == '': c = 0.0
		else: c = float(self.ui.ressC.text())
		tab.ui.ressC.setText(str(int(math.ceil(c - float(self.sim.stats.tButCmoy)))))
		if self.ui.ressD.text() == '': d = 0.0
		else: d = float(self.ui.ressD.text())
		tab.ui.ressD.setText(str(int(math.ceil(d - float(self.sim.stats.tButDmoy)))))

		tab.ui.vitesse.setValue(self.ui.vitesse.value())
		tab.ui.phallange.setDateTime(self.ui.phallange.dateTime())

		for i in range(0,9):
			if re.match('^\d:\d{1,3}:\d{1,2}$', self.parent.prefs.pos[i]):
				tab.ui.depart.addItem(self.parent.prefs.pos[i])

		tab.ui.depart.setEditText(str(self.ui.depart.currentText()))
		self.parent.ui.tabWidget.setCurrentWidget(tab)

	def saveDef(self):
		""" Sauvegarde de la défense dans une bdd """
		dialog = saveDefDialog()
		dialog.ui.editName.setText(self.ui.cible.text())
		dialog.ui.editCoord.setText(self.ui.cible.text())
		ret = dialog.exec_()

		if ret == 1:
			dFlotte = cPickle.dumps(self.dFlotte)
			dDef = cPickle.dumps(self.dDef)
			dTek = cPickle.dumps(self.dTek)
			aFlotte = cPickle.dumps(self.aFlotte)
			aTek = cPickle.dumps(self.aTek)
			r = self.ui.ressM.text().toInt()[0] + self.ui.ressC.text().toInt()[0] + self.ui.ressD.text().toInt()[0]
			m = self.ui.ressM.text().toInt()[0]
			c = self.ui.ressC.text().toInt()[0]
			d = self.ui.ressD.text().toInt()[0]
			if self.isSimulated == True:
				gain = int(self.sim.stats.totalButTmoy)
			else:
				gain = 0
			timestamp = int(time.time())
			cx = sqlite.connect('./db/'+dialog.bdd)
			cur = cx.cursor()
			cur.execute("insert into cibles (name,coord,flotte,deff,tek,r,m,c,d,vflotte,vdef,gain,timestamp,aflotte,atek,comment) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", (str(dialog.ui.editName.text()), str(dialog.ui.editCoord.text()),dFlotte,dDef,dTek,r,m,c,d,self.dFlotte.total,self.dDef.total,gain,timestamp,aFlotte,aTek,''))
			cx.commit()

	def resetAtt(self):
		""" Mise a zero de la flotte attaquante """
		for i in self.aFlotteInputs:
			i.setText('')
		self.aFlotte.reset()


	def resetDef(self):
		""" Mise a zero de la flotte et defense défenseur """
		for i in self.dFlotteInputs:
			i.setText('')
		for i in self.dDefInputs:
			i.setText('')
		self.dFlotte.reset()
		self.dDef.reset()
		self.isSimulated = False

	def swap(self):
		""" échange des flottes attaquant-défenseur """
		self.disconnectDflotte()
		self.disconnectDdef()
		self.disconnectAflotte()
		self.disconnectAtek()
		self.disconnectDtek()
		for i in self.dDefInputs:
			i.setText('')
		self.dDef.reset()
		self.aFlotte, self.dFlotte = self.dFlotte, self.aFlotte
		self.aFlotte.tabFlotte[10]= 0
		for i in range(0, len(self.dFlotte.tabFlotte)):
			if self.dFlotte.tabFlotte[i] > 0:
				self.dFlotteInputs[i].setText(str(self.dFlotte.tabFlotte[i]))
			else:
				self.dFlotteInputs[i].setText('')

		for i in range(0, len(self.aFlotte.tabFlotte)):
			if i <= 9:
				if self.aFlotte.tabFlotte[i] > 0:
					self.aFlotteInputs[i].setText(str(self.aFlotte.tabFlotte[i]))
				else:
					self.aFlotteInputs[i].setText('')
			elif i == 10:
				pass
			else:
				if self.aFlotte.tabFlotte[i] > 0:
					self.aFlotteInputs[i-1].setText(str(self.aFlotte.tabFlotte[i]))
				else:
					self.aFlotteInputs[i-1].setText('')

		self.aTek, self.dTek = self.dTek, self.aTek

		self.ui.tekDarmes.setText(str(self.dTek.tabTek[2]))
		self.ui.tekDboucl.setText(str(self.dTek.tabTek[3]))
		self.ui.tekDprotec.setText(str(self.dTek.tabTek[4]))

		self.ui.tekAarmes.setText(str(self.aTek.tabTek[2]))
		self.ui.tekAboucl.setText(str(self.aTek.tabTek[3]))
		self.ui.tekAprotec.setText(str(self.aTek.tabTek[4]))

		self.ui.tekComb.setText(str(self.aTek.tabTek[7]))
		self.ui.tekImp.setText(str(self.aTek.tabTek[8]))
		self.ui.tekHyp.setText(str(self.aTek.tabTek[9]))

		self.aFlotte.setTechno(self.aTek)
		self.dFlotte.setTechno(self.dTek)
		self.Displace = displacer(self.vitesse, self.Apos, self.Dpos, self.aFlotte, self.aTek, self)
		self.Displace.calcTime()
		self.connectAflotte()
		self.connectDflotte()
		self.connectDdef()
		self.connectAtek()
		self.connectDtek()
		self.outA()
		self.outD()
		self.isSimulated = False

	def updateFretType(self, index):
		if index == 8:
			i = 9
		elif index >= 9:
			i = index+2
		else :
			i = index
		self.fretType = i
		self.updateFret()

	def updateFret(self):
		fretCap = float(VAISS[self.fretType]['fr'])
		m = self.ui.ressM.text().toFloat()[0]
		c = self.ui.ressC.text().toFloat()[0]
		d = self.ui.ressD.text().toFloat()[0]
		nb = int(ceil(getNecessaryFret([m,c,d]) / fretCap))
		self.ui.labelFret.setText(str(nb))

	def updateInputsFromdFlotte(self):
		""" Remplit les LineEdits a partir des données de flotte defenseur """
		self.disconnectDflotte()
		for i in range(0,14):
			if self.dFlotte.tabFlotte[i] == 0:
				self.dFlotteInputs[i].setText('')
			else:
				self.dFlotteInputs[i].setText(str(self.dFlotte.tabFlotte[i]))
		self.connectDflotte()
		self.isSimulated = False

	def updateInputsFromdDef(self):
		""" Remplit les LineEdits a partir des données de defense defenseur """
		self.disconnectDdef()
		for i in range(0,8):
			if self.dDef.tabDef[i] == 0:
				self.dDefInputs[i].setText('')
			else:
				self.dDefInputs[i].setText(str(self.dDef.tabDef[i]))
		self.connectDdef()
		self.isSimulated = False

	def updateInputsFromdTek(self):
		""" Remplit les LineEdits a partir des données de technologie defenseur """
		self.disconnectDtek()
		for i in range(2,5):
			if self.dTek.tabTek[i] == 0:
				self.dTekInputs[i-2].setText('')
			else:
				self.dTekInputs[i-2].setText(str(self.dTek.tabTek[i]))
		self.connectDtek()
		self.isSimulated = False

	def calcTime(self):
		""" Calcul les données de déplacement """
		vitesse = self.ui.vitesse.value() - self.ui.vitesse.value()%10
		self.ui.vitesseLcd.display(vitesse)
		self.vitesse[0] = vitesse
		self.Displace.calcTime()
		if self.parent.prefs.deutPond and self.isSimulated:
			pond = float(self.parent.prefs.deutPondValue) * float(self.coutDeut)
			self.ui.labelGainsMoy.setText(number_format(self.sim.stats.totalButTmoy - pond))
			self.ui.labelGainsMax.setText(number_format(self.sim.stats.totalButTmax - pond))
			self.ui.labelGainsMin.setText(number_format(self.sim.stats.totalButTmin - pond))

	def upAflotte_aPt(self, var):
		self.aFlotte.setValues(0, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aGt(self, var):
		self.aFlotte.setValues(1, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aCle(self, var):
		self.aFlotte.setValues(2, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aClo(self, var):
		self.aFlotte.setValues(3, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aCro(self, var):
		self.aFlotte.setValues(4, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aVb(self, var):
		self.aFlotte.setValues(5, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aVc(self, var):
		self.aFlotte.setValues(6, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aRe(self, var):
		self.aFlotte.setValues(7, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aSe(self, var):
		self.aFlotte.setValues(8, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aBo(self, var):
		self.aFlotte.setValues(9, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aDe(self, var):
		self.aFlotte.setValues(11, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aEm(self, var):
		self.aFlotte.setValues(12, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upAflotte_aTr(self, var):
		self.aFlotte.setValues(13, var.toInt()[0])
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	############################################################################

	def upDflotte_dPt(self, var):
		self.dFlotte.setValues(0, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dGt(self, var):
		self.dFlotte.setValues(1, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dCle(self, var):
		self.dFlotte.setValues(2, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dClo(self, var):
		self.dFlotte.setValues(3, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dCro(self, var):
		self.dFlotte.setValues(4, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dVb(self, var):
		self.dFlotte.setValues(5, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dVc(self, var):
		self.dFlotte.setValues(6, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dRe(self, var):
		self.dFlotte.setValues(7, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dSe(self, var):
		self.dFlotte.setValues(8, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dBo(self, var):
		self.dFlotte.setValues(9, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dSs(self, var):
		self.dFlotte.setValues(10, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dDe(self, var):
		self.dFlotte.setValues(11, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dEm(self, var):
		self.dFlotte.setValues(12, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDflotte_dTr(self, var):
		self.dFlotte.setValues(13, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	############################################################################

	def upDdef_dLm(self, var):
		self.dDef.setValues(0, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dLe(self, var):
		self.dDef.setValues(1, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dLo(self, var):
		self.dDef.setValues(2, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dCg(self, var):
		self.dDef.setValues(3, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dAi(self, var):
		self.dDef.setValues(4, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dLp(self, var):
		self.dDef.setValues(5, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dPb(self, var):
		self.dDef.setValues(6, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dGb(self, var):
		self.dDef.setValues(7, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	def upDdef_dMi(self, var):
		self.dDef.setValues(8, var.toInt()[0])
		self.outD()
		self.isSimulated = False

	############################################################################

	def upAtek(self):
		self.aTek.setValue(self.ui.tekAarmes.text().toInt()[0], 2)
		self.aTek.setValue(self.ui.tekAboucl.text().toInt()[0], 3)
		self.aTek.setValue(self.ui.tekAprotec.text().toInt()[0], 4)
		self.aTek.setValue(self.ui.tekComb.text().toInt()[0], 7)
		self.aTek.setValue(self.ui.tekImp.text().toInt()[0], 8)
		self.aTek.setValue(self.ui.tekHyp.text().toInt()[0], 9)
		self.aFlotte.setTechno(self.aTek)
		self.Displace.calcTime()
		self.outA()
		self.isSimulated = False

	def upDtek(self):
		self.dTek.setValue(self.ui.tekDarmes.text().toInt()[0], 2)
		self.dTek.setValue(self.ui.tekDboucl.text().toInt()[0], 3)
		self.dTek.setValue(self.ui.tekDprotec.text().toInt()[0], 4)
		self.dFlotte.setTechno(self.dTek)
		self.dDef.setTechno(self.dTek)
		self.outD()
		self.isSimulated = False

	def upApos(self, var):
		pos = var.toAscii()
		if re.match('^\d:\d{1,3}:\d{1,2}$', pos):
			match = re.split(':', pos)
			self.Apos[0] = 1
			self.Apos[1] = match[0]
			self.Apos[2] = match[1]
			self.Apos[3] = match[2]
		else:
			self.Apos[0] = 0
		self.Displace.calcTime()

	def upDpos(self, var):
		pos = var.toAscii()
		if re.match('^\d:\d{1,3}:\d{1,2}$', pos):
			match = re.split(':', pos)
			self.Dpos[0] = 1
			self.Dpos[1] = match[0]
			self.Dpos[2] = match[1]
			self.Dpos[3] = match[2]
			self.parent.ui.tabWidget.setTabText(self.parent.ui.tabWidget.currentIndex(), var)
		else:
			self.Dpos[0] = 0
		self.Displace.calcTime()

	def upDisplacement(self, deut, time, phal):
		""" Remplit dans l'interface les données de déplacement """
		self.coutDeut = deut
		self.ui.deutLcd.display(number_format(deut))
		self.ui.timeLcd.display(str(time[0])+'d '+str(time[1]).zfill(2)+':'+str(time[2]).zfill(2)+':'+str(time[3]).zfill(2))
		self.ui.phalLCD.display(phal)

	def phallange(self, var):
		self.phallangeStamp = [var.toTime_t()]
		self.calcTime()

	def changeHisto(self, index):
		self.histoView = index
		self.plotter.setValues(self.sim.stats.tabResults[self.histoView])
		self.plotter.update()

	def parseRE(self, txt):
		""" Parse un rapport d'espionnage """
		txt = str(txt.toUtf8())
		self.ui.copyPaste.clear()
		if re.search('Matières premières sur.*\[\d:\d{1,3}:\d{1,2}\]', txt):
			self.disconnectDflotte()
			self.disconnectDdef()
			self.disconnectDtek()
			flotte = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			defense = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			tek = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

			tekMatches = ['Technologie Espionnage\s+(\d+)', \
								'Technologie Ordinateur\s+(\d+)', \
								'Technologie Armes\s+(\d+)', \
								'Technologie Bouclier\s+(\d+)', \
								'Technologie Protection des vaisseaux spatiaux\s+(\d+)', \
								'Technologie Energie\s+(\d+)', \
								'Technologie Hyperespace\s+(\d+)', \
								'Réacteur à combustion\s+(\d+)', \
								'Réacteur à impulsion\s+(\d+)', \
								'Propulsion hyperespace\s+(\d+)', \
								'Technologie Laser\s+(\d+)', \
								'Technologie Ions\s+(\d+)', \
								'Technologie Plasma\s+(\d+)', \
								'Réseau de recherche intergalactique\s+(\d+)', \
								'Technologie Graviton\s+(\d+)']

			fltMatches = ['Petit transporteur\s+([.\d]+)', \
								'Grand transporteur\s+([.\d]+)', \
								'Chasseur léger\s+([.\d]+)', \
								'Chasseur lourd\s+([.\d]+)', \
								'Croiseur\s+([.\d]+)', \
								'Vaisseau de bataille\s+([.\d]+)', \
								'Vaisseau de colonisation\s+([.\d]+)', \
								'Recycleur\s+([.\d]+)', \
								'Sonde espionnage\s+([.\d]+)', \
								'Bombardier\s+([.\d]+)', \
								'Satellite solaire\s+([.\d]+)', \
								'Destructeur\s+([.\d]+)', \
								'Étoile de la mort\s+([.\d]+)', \
								'Traqueur\s+([.\d]+)']

			defMatches = ['Lanceur de missiles\s+([.\d]+)', \
								'Artillerie laser légère\s+([.\d]+)', \
								'Artillerie laser lourde\s+([.\d]+)', \
								'Canon de Gauss\s+([.\d]+)', \
								'Artillerie à ions\s+([.\d]+)', \
								'Lanceur de plasma\s+([.\d]+)', \
								'Petit bouclier\s+([.\d]+)', \
								'Grand bouclier\s+([.\d]+)', \
								'Missile Interception\s+([.\d]+)']

			resMatches = ['Métal:\s+([.\d]+)', \
								'Cristal:\s+([.\d]+)', \
								'Deutérium:\s+([.\d]+)']

			for i in range(0,len(fltMatches)):
				if re.search(fltMatches[i], txt):
					self.dFlotteInputs[i].setText(re.findall(fltMatches[i], txt)[0].replace('.',''))
					flotte[i] = int(re.findall(fltMatches[i], txt)[0].replace('.',''))
				else:
					self.dFlotteInputs[i].setText('')

			for i in range(0,len(defMatches)):
				if re.search(defMatches[i], txt):
					self.dDefInputs[i].setText(re.findall(defMatches[i], txt)[0].replace('.',''))
					defense[i] = int(re.findall(defMatches[i], txt)[0].replace('.',''))
				else:
					self.dDefInputs[i].setText('')

			for i in range(0,len(resMatches)):
				if re.search(resMatches[i], txt):
					self.resInputs[i].setText(re.findall(resMatches[i], txt)[0].replace('.',''))
				else:
					self.resInputs[i].setText('')

			for i in range(0,len(tekMatches)):
				if re.search(tekMatches[i], txt):
					if i >=2 and i <=4:
						self.dTekInputs[i-2].setText(re.findall(tekMatches[i], txt)[0])
					tek[i] = int(re.findall(tekMatches[i], txt)[0])
				else:
					if i >=2 and i <=4:
						self.dTekInputs[i-2].setText('')

			self.ui.cible.setText(re.findall('Matières premières sur.*\[(\d:\d{1,3}:\d{1,2})\]', txt)[0])
			if not re.search('Recherche', txt):
				QtGui.QMessageBox.information(self, QtCore.QString('Attention'), QtCore.QString('Technologies manquantes !'))

			self.connectDflotte()
			self.connectDdef()
			self.connectDtek()

			self.dTek.setArrayValues(tek)
			self.dFlotte.setTechno(self.dTek)
			self.dDef.setTechno(self.dTek)
			self.dDef.setArrayValues(defense)
			self.dFlotte.setArrayValues(flotte)
			self.outD()
			self.isSimulated = False

	def outA(self):
		""" Remplit les données Attaquant """
		out = '<h5>FLOTTE :</h5><div style="background-color:#dedede"><b>Coût :</b> '+str(number_format(self.aFlotte.tm))+' <b>m,</b> '+str(number_format(self.aFlotte.tc))+' <b>c</b>, '+str(number_format(self.aFlotte.td))+' <b>d</b><br><b>Soit</b> : <b>'+str(number_format(self.aFlotte.total))+'</b> unités<br>'
		out += '<b>CDR :</b> '+str(number_format(self.aFlotte.cdrm))+' <b>m</b>, '+str(number_format(self.aFlotte.cdrc))+' <b>c</b> ('+str(self.aFlotte.recy)+' recycleurs)</div>'
		cpt = 0
		out += '<h5>DETAILS FLOTTE :</h5><table width="100%" bgcolor="#dedede"><tr align="center"  bgcolor="#cdcdcd"><th></th><th>Armes</th><th>Boucl.</th><th>Coque</th><th>Vit.</th><th>M</th><th>C</th><th>D</th></tr>'
		for i in self.aFlotte.tabFlotte:
			if i > 0:
				m = i * self.aFlotte.caract[cpt]["m"]
				c = i * self.aFlotte.caract[cpt]["c"]
				d = i * self.aFlotte.caract[cpt]["d"]
				out += '<tr><td>'+self.aFlotte.caract[cpt]["nm"]+'</td><td align="right">'+str(self.aFlotte.caract[cpt]["va"])+'</td><td align="right">'+str(self.aFlotte.caract[cpt]["pb"])+'</td><td align="right">'+str(self.aFlotte.caract[cpt]["ps"])+'</td><td align="right">'+str(self.aFlotte.caract[cpt]["vb"])+'</td><td align="right">'+str(number_format(m))+'</td><td align="right">'+str(number_format(c))+'</td><td align="right">'+str(number_format(d))+'</td></tr>'
			cpt = cpt + 1
		out += '</table>'
		self.ui.aDetails.setHtml(QtCore.QString.fromUtf8((out)))

	def outD(self):
		""" Remplit les données défenseur """
		out = '<h5>FLOTTE :</h5><div style="background-color:#dedede"><b>Coût :</b> '+str(number_format(self.dFlotte.tm))+' <b>m,</b> '+str(number_format(self.dFlotte.tc))+' <b>c</b>, '+str(number_format(self.dFlotte.td))+' <b>d</b><br><b>Soit</b> : <b>'+str(number_format(self.dFlotte.total))+'</b> unités<br>'
		out += '<b>CDR :</b> '+str(number_format(self.dFlotte.cdrm))+' <b>m</b>, '+str(number_format(self.dFlotte.cdrc))+' <b>c</b> ('+str(self.dFlotte.recy)+' recycleurs)</div>'

		out += '<h5>DEFENSE :</h5><div style="background-color:#dedede"><b>Coût :</b> '+str(number_format(self.dDef.tm))+' <b>m,</b> '+str(number_format(self.dDef.tc))+' <b>c</b>, '+str(number_format(self.dDef.td))+' <b>d</b><br><b>Soit</b> : <b>'+str(number_format(self.dDef.total))+'</b> unités</div>'
		cpt = 0
		out += '<h5>DETAILS FLOTTE :</h5><table width="100%" bgcolor="#dedede"><tr align="center"  bgcolor="#cdcdcd"></th><th><th>Armes</th><th>Boucl.</th><th>Coque</th><th>M</th><th>C</th><th>D</th></tr>'
		for i in self.dFlotte.tabFlotte:
			if i > 0:
				m = i * self.dFlotte.caract[cpt]["m"]
				c = i * self.dFlotte.caract[cpt]["c"]
				d = i * self.dFlotte.caract[cpt]["d"]
				out += '<tr><td>'+self.dFlotte.caract[cpt]["nm"]+'</td><td align="right">'+str(self.dFlotte.caract[cpt]["va"])+'</td><td align="right">'+str(self.dFlotte.caract[cpt]["pb"])+'</td><td align="right">'+str(self.dFlotte.caract[cpt]["ps"])+'</td><td align="right">'+str(number_format(m))+'</td><td align="right">'+str(number_format(c))+'</td><td align="right">'+str(number_format(d))+'</td></tr>'
			cpt = cpt + 1
		out += '</table>'
		cpt = 0
		out +='<h5>DETAILS DEFENSE :</h5><table width="100%" bgcolor="#dedede"><tr align="center"  bgcolor="#cdcdcd"><th></th><th>Armes</th><th>Boucl.</th><th>Coque</th><th>M</th><th>C</th><th>D</th></tr>'
		for i in self.dDef.tabDef:
			if i > 0:
				m = i * self.dDef.caract[cpt]["m"]
				c = i * self.dDef.caract[cpt]["c"]
				d = i * self.dDef.caract[cpt]["d"]
				out +=  '<tr><td>'+self.dDef.caract[cpt]["nm"]+'</td><td align="right">'+str(self.dDef.caract[cpt]["va"])+'</td><td align="right">'+str(self.dDef.caract[cpt]["pb"])+'</td><td align="right">'+str(self.dDef.caract[cpt]["ps"])+'</td><td align="right">'+str(number_format(m))+'</td><td align="right">'+str(number_format(c))+'</td><td align="right">'+str(number_format(d))+'</td></tr>'
			cpt = cpt + 1
		out += '</table>'
		self.ui.dDetails.setHtml(QtCore.QString.fromUtf8((out)))







if __name__ == "__main__":
	app = QtGui.QApplication(sys.argv)
	window = GinetteController()
	window.show()
	sys.exit(app.exec_())