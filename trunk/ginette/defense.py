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
from defenses import *
import copy

from math import *
from decimal import Decimal, getcontext
getcontext().prec = 5 #précision voulue

class defense:
	def __init__(self):
		self.tabDef = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		self.caract = copy.deepcopy(DEF)

		self.tm = 0
		self.tc = 0
		self.td = 0
		self.total = 0

	def setValues(self, index, val):
		#print 'defense::setValues'
		self.tabDef[index] = val
		self.setRessources()

	def setArrayValues(self, arr):
		#print 'defense::setArrayValues'
		self.tabDef = copy.deepcopy(arr)
		self.setRessources()

	def setTechno(self, tek):
		#print 'defense::setTechno'
		self.caract = copy.deepcopy(DEF) #remise à zero des caractéristiques

		#calcul des vitesses
		for i in range(0, 10):
			self.caract[i]["va"] = self.caract[i]["va"] + (tek.tabTek[2] * 0.1 * self.caract[i]["va"])
			self.caract[i]["ps"] = (self.caract[i]["ps"] + (tek.tabTek[4] * 0.1 * self.caract[i]["ps"]))/10
			self.caract[i]["pb"] = self.caract[i]["pb"] + (tek.tabTek[3] * 0.1 * self.caract[i]["pb"])

		#print self.caract

	def setRessources(self):
		#print 'defense::setRessources'
		cpt = 0
		self.tm = 0
		self.tc = 0
		self.td = 0
		self.total = 0
		for i in self.tabDef:
			if i > 0:
				m = i * self.caract[cpt]["m"]
				c = i * self.caract[cpt]["c"]
				d = i * self.caract[cpt]["d"]
				self.tm += m
				self.tc += c
				self.td += d
			cpt = cpt + 1
		self.total = self.tm + self.tc + self.td

	def setNb(self):
		nbDef = 0
		for i in self.tabDef:
			nbDef += i
		self.nb = nbDef

	def reset(self):
		self.tabDef = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		self.setNb()
		self.setRessources()

