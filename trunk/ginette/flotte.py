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

import sys
sys.path.append('config')
from vaisseaux import *
import copy

from math import *
from decimal import Decimal, getcontext
getcontext().prec = 5 #précision voulue

class flotte:
	def __init__(self):
		self.tabFlotte = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		self.caract = copy.deepcopy(VAISS)
		self.nb = 0
		self.speed = 0
		self.tm = 0
		self.tc = 0
		self.td = 0
		self.total = 0
		self.cdrm = 0
		self.cdrc = 0
		self.cdr = 0
		self.recy = 0


	def setValues(self, index, val):
		#print 'flotte::setValues'
		self.tabFlotte[index] = val
		self.setNb()
		self.setRessources()
		self.setSpeed()
		#self.output()

	def init(self):
		self.setNb()
		self.setRessources()
		self.setSpeed()

	def setArrayValues(self, arr):
		#print 'flotte::setArrayValues'
		self.tabFlotte = copy.deepcopy(arr)
		self.setNb()
		self.setRessources()
		self.setSpeed()

	def setTechno(self, tek):
		#print 'flotte::setTechno'
		self.caract = copy.deepcopy(VAISS) #remise à zero des caractéristiques

		#mise a jours des vitesses/consommation/propultion de base
		if tek.tabTek[8] >= 5: #petit transporteur
			self.caract[0]["tk"] = 8
			self.caract[0]["vb"] = 10000
			self.caract[0]["cd"] = 20

		if tek.tabTek[9] >= 8: #bombardier
			self.caract[9]["tk"] = 9
			self.caract[9]["vb"] = 5000

		#calcul des vitesses/consommations
		for i in range(0, 14):
			if self.caract[i]["tk"] == 7:
				self.caract[i]["vb"] = self.caract[i]["vb"] + (tek.tabTek[7] * 0.1 * self.caract[i]["vb"])
			if self.caract[i]["tk"] == 8:
				self.caract[i]["vb"] = self.caract[i]["vb"] + (tek.tabTek[8] * 0.2 * self.caract[i]["vb"])
			if self.caract[i]["tk"] == 9:
				self.caract[i]["vb"] = self.caract[i]["vb"] + (tek.tabTek[9] * 0.3 * self.caract[i]["vb"])

			self.caract[i]["va"] = self.caract[i]["va"] + (tek.tabTek[2] * 0.1 * self.caract[i]["va"])
			self.caract[i]["ps"] = (self.caract[i]["ps"] + (tek.tabTek[4] * 0.1 * self.caract[i]["ps"]))/10
			self.caract[i]["pb"] = self.caract[i]["pb"] + (tek.tabTek[3] * 0.1 * self.caract[i]["pb"])

		self.setSpeed()
		#self.output()

	def setNb(self):
		#print 'flotte::setNb'
		nbVaiss = 0
		for i in self.tabFlotte:
			nbVaiss += i
		self.nb = nbVaiss

	def setSpeed(self):
		#print 'flotte::setSpeed'
		if self.nb > 0:
			speed = []
			for i in range(0,14):
				if self.tabFlotte[i] > 0:
					speed.append(self.caract[i]["vb"])
			self.speed = int(min(speed))
		else:
			self.speed = 0

	def setRessources(self):
		#print 'flotte::setRessources'
		cpt = 0
		self.tm = 0
		self.tc = 0
		self.td = 0
		self.total = 0
		self.cdrm = 0
		self.cdrc = 0
		self.cdr = 0
		self.recy = 0
		for i in self.tabFlotte:
			if i > 0:
				m = i * self.caract[cpt]["m"]
				c = i * self.caract[cpt]["c"]
				d = i * self.caract[cpt]["d"]
				self.tm += m
				self.tc += c
				self.td += d
			cpt = cpt + 1
		self.total = self.tm + self.tc + self.td
		self.cdrm = self.tm * 0.3
		self.cdrc = self.tc * 0.3
		self.cdr = self.cdrm + self.cdrc
		self.recy = int(ceil(self.cdr / 20000))

	def reset(self):
		self.tabFlotte = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		self.setNb()
		self.setRessources()
		self.setSpeed()


