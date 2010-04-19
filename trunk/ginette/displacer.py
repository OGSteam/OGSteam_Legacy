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

from math import *
from datetime import *

class displacer:
	def __init__(self, vitesse, aPos, dPos, aFlotte, aTek, win):
		self.pvit = vitesse
		self.aPos = aPos
		self.dPos = dPos
		self.aFlotte = aFlotte
		self.aTek = aTek
		self.win = win
		#print '>>>>>>>>' , self.timeFromSeconds(14066)

	def calcTime(self):
		if self.aPos[0] == 1 and self.dPos[0] == 1 and self.aFlotte.nb > 0:
			self.distance()
			vitesse = self.aFlotte.speed
			g = abs(float(self.aPos[1]) - float(self.dPos[1]))
			s = abs(float(self.aPos[2]) - float(self.dPos[2]))
			p = abs(float(self.aPos[3]) - float(self.dPos[3]))
			if g != 0: nbv = 10 + 35000 / float(self.pvit[0]) * sqrt((g * 20000000) / vitesse)
			elif s != 0: nbv = 10 + 35000 / float(self.pvit[0]) * sqrt((2700000 + s * 95000) / vitesse)
			elif p != 0: nbv = 10 + 35000 / float(self.pvit[0]) * sqrt((1000000 + p * 5000) / vitesse)
			dur = self.timeFromSeconds(nbv)
			phalStp = int(self.win.phallangeStamp[0] - round(nbv))
			phal = str(datetime.fromtimestamp(phalStp))

			#print 'distance :', self.dist
			#print 'trajet :', round(nbv)
			#print ">>> on entre dans la boucle"
			consumption = 0.0
			for i in range(0,14):
				if self.aFlotte.tabFlotte[i] > 0:
					#print ">>> boucle"
					#print '   vaisseau :', self.aFlotte.caract[i]['nm']
					#print "   vitesse du vaisseau :", float(self.aFlotte.caract[i]['vb'])
					spd = 35000 / (round(nbv) * 1 - 10) * sqrt(self.dist * 10 / float(self.aFlotte.caract[i]['vb']))
					#print '   spd :', spd
					#print '   conso du vaisseau :', float(self.aFlotte.caract[i]['cd'])
					#print '   nombre de vaisseaux', float(self.aFlotte.tabFlotte[i])
					basicConsumption = float(self.aFlotte.caract[i]['cd']) * float(self.aFlotte.tabFlotte[i])
					#print '   basicConsuption :', basicConsumption
					#print 'conso : ', basicConsumption * self.dist / 35000 * ((spd / 10) + 1)**2
					consumption += basicConsumption * self.dist / 35000 * ((spd / 10) + 1)**2
					#print '   consuption :', consumption
			consumption = round(consumption) + 1
			#print 'total :', consumption

			self.win.upDisplacement(int(consumption), dur, phal)
		else:
			self.win.upDisplacement(0, [0,0,0,0], 0)


	def timeFromSeconds(self, seconds):
		sec = int(round(seconds % 60))
		mi = int(floor((seconds / 60) % 60))
		hou = int(floor((seconds / 3600) % 24))
		day = int(floor(seconds / 86400))
		return [day, hou, mi, sec]

	def distance(self):
		dist = 0
		if int(self.aPos[1]) - int(self.dPos[1]) != 0: dist = abs(float(self.aPos[1]) - float(self.dPos[1])) * 20000
		elif int(self.aPos[2]) - int(self.dPos[2]) != 0: dist = abs(float(self.aPos[2]) - float(self.dPos[2])) * 5 * 19 + 2700
		elif int(self.aPos[3]) - int(self.dPos[3]) != 0: dist = abs(float(self.aPos[3]) - float(self.dPos[3])) * 5 + 1000
		else: dist = 5
		self.dist = float(dist)


