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

from ctypes import *
import time, platform
from PyQt4 import QtCore


class csimulator(QtCore.QThread):
	def __init__(self, aFlotte, dFlotte, dDef):
		QtCore.QThread.__init__(self)
		self.libLoaded = False
		if platform.system() == 'Linux' and platform.architecture()[0] == '32bit':
			try:
				self.libsim = cdll.LoadLibrary("./library/libogsim_linux32.so")
				self.libLoaded = True
			except:
				pass
		elif platform.system() == 'Linux' and platform.architecture()[0] == '64bit':
			try:
				self.libsim = cdll.LoadLibrary("./library/libogsim_linux64.so")
				self.libLoaded = True
			except:
				pass
		elif platform.system() == 'Darwin':
			try:
				self.libsim = cdll.LoadLibrary("./library/libogsim_ppc32.dylib")
				self.libLoaded = True
			except:
				pass
		elif platform.system() == 'Windows':
			try:
				self.libsim = cdll.LoadLibrary("./library/libogsim.dll")
				self.libLoaded = True
			except:
				pass
		else:
			try:
				self.libsim = cdll.LoadLibrary("./library/libogsim.so")
				self.libLoaded = True
			except:
				pass
		self.nbsim = 0
		if self.libLoaded == True:
			self.libsim.randInit()
			self.getFight = self.libsim.mypi
			self.getFight.restype = c_int
			self.stopped = 0
			self.lastime = time.time()

			ta = c_int * 25
			self.ty1 = ta(aFlotte.tabFlotte[0], aFlotte.tabFlotte[1], aFlotte.tabFlotte[2], aFlotte.tabFlotte[3], aFlotte.tabFlotte[4], aFlotte.tabFlotte[5], aFlotte.tabFlotte[6], aFlotte.tabFlotte[7], aFlotte.tabFlotte[8], aFlotte.tabFlotte[9], aFlotte.tabFlotte[10], aFlotte.tabFlotte[11], aFlotte.tabFlotte[12], aFlotte.tabFlotte[13], 0, 0, 0, 0, 0, 0, 0, 0)
			T2 = c_float * 25
			self.ps1 = T2(aFlotte.caract[0]['ps'], aFlotte.caract[1]['ps'], aFlotte.caract[2]['ps'], aFlotte.caract[3]['ps'], aFlotte.caract[4]['ps'], aFlotte.caract[5]['ps'], aFlotte.caract[6]['ps'], aFlotte.caract[7]['ps'], aFlotte.caract[8]['ps'], aFlotte.caract[9]['ps'], aFlotte.caract[10]['ps'], aFlotte.caract[11]['ps'], aFlotte.caract[12]['ps'], aFlotte.caract[13]['ps'])
			T3 = c_float * 25
			self.vb1 = T3(aFlotte.caract[0]["pb"], aFlotte.caract[1]["pb"], aFlotte.caract[2]["pb"], aFlotte.caract[3]["pb"], aFlotte.caract[4]["pb"], aFlotte.caract[5]["pb"], aFlotte.caract[6]["pb"], aFlotte.caract[7]["pb"], aFlotte.caract[8]["pb"], aFlotte.caract[9]["pb"], aFlotte.caract[10]["pb"], aFlotte.caract[11]["pb"], aFlotte.caract[12]["pb"], aFlotte.caract[13]["pb"])
			T4 = c_float * 25
			self.va1 = T4(aFlotte.caract[0]["va"], aFlotte.caract[1]["va"], aFlotte.caract[2]["va"], aFlotte.caract[3]["va"], aFlotte.caract[4]["va"], aFlotte.caract[5]["va"], aFlotte.caract[6]["va"], aFlotte.caract[7]["va"], aFlotte.caract[8]["va"], aFlotte.caract[9]["va"], aFlotte.caract[10]["va"], aFlotte.caract[11]["va"], aFlotte.caract[12]["va"], aFlotte.caract[13]["va"])

			td = c_int * 25
			self.ty2 = td(dFlotte.tabFlotte[0], dFlotte.tabFlotte[1], dFlotte.tabFlotte[2], dFlotte.tabFlotte[3], dFlotte.tabFlotte[4], dFlotte.tabFlotte[5], dFlotte.tabFlotte[6], dFlotte.tabFlotte[7], dFlotte.tabFlotte[8], dFlotte.tabFlotte[9], dFlotte.tabFlotte[10], dFlotte.tabFlotte[11], dFlotte.tabFlotte[12], dFlotte.tabFlotte[13], dDef.tabDef[0], dDef.tabDef[1], dDef.tabDef[2], dDef.tabDef[3], dDef.tabDef[4], dDef.tabDef[5], dDef.tabDef[6], dDef.tabDef[7])

			T5 = c_float * 25
			self.ps2 = T5(dFlotte.caract[0]['ps'], dFlotte.caract[1]['ps'], dFlotte.caract[2]['ps'], dFlotte.caract[3]['ps'], dFlotte.caract[4]['ps'], dFlotte.caract[5]['ps'], dFlotte.caract[6]['ps'], dFlotte.caract[7]['ps'], dFlotte.caract[8]['ps'], dFlotte.caract[9]['ps'], dFlotte.caract[10]['ps'], dFlotte.caract[11]['ps'], dFlotte.caract[12]['ps'], dFlotte.caract[13]['ps'], dDef.caract[0]['ps'], dDef.caract[1]['ps'], dDef.caract[2]['ps'], dDef.caract[3]['ps'], dDef.caract[4]['ps'], dDef.caract[5]['ps'], dDef.caract[6]['ps'], dDef.caract[7]['ps'])
			T6 = c_float * 25
			self.vb2 = T6(dFlotte.caract[0]["pb"], dFlotte.caract[1]["pb"], dFlotte.caract[2]["pb"], dFlotte.caract[3]["pb"], dFlotte.caract[4]["pb"], dFlotte.caract[5]["pb"], dFlotte.caract[6]["pb"], dFlotte.caract[7]["pb"], dFlotte.caract[8]["pb"], dFlotte.caract[9]["pb"], dFlotte.caract[10]["pb"], dFlotte.caract[11]["pb"], dFlotte.caract[12]["pb"], dFlotte.caract[13]["pb"], dDef.caract[0]['pb'], dDef.caract[1]['pb'], dDef.caract[2]['pb'], dDef.caract[3]['pb'], dDef.caract[4]['pb'], dDef.caract[5]['pb'], dDef.caract[6]['pb'], dDef.caract[7]['pb'])
			T7 = c_float * 25
			self.va2 = T7(dFlotte.caract[0]["va"], dFlotte.caract[1]["va"], dFlotte.caract[2]["va"], dFlotte.caract[3]["va"], dFlotte.caract[4]["va"], dFlotte.caract[5]["va"], dFlotte.caract[6]["va"], dFlotte.caract[7]["va"], dFlotte.caract[8]["va"], dFlotte.caract[9]["va"], dFlotte.caract[10]["va"], dFlotte.caract[11]["va"], dFlotte.caract[12]["va"], dFlotte.caract[13]["va"], dDef.caract[0]['va'], dDef.caract[1]['va'], dDef.caract[2]['va'], dDef.caract[3]['va'], dDef.caract[4]['va'], dDef.caract[5]['va'], dDef.caract[6]['va'], dDef.caract[7]['va'])

			self.aflt = flt(self.ty1, self.ps1,self.vb1,self.va1)
			self.bflt = flt(self.ty2, self.ps2,self.vb2,self.va2)

			m = c_int(25)
			n = c_int(7)
			l = c_int(2)
			xarray = c_int * m.value * n.value * l.value
			self.rounds = xarray()

	def run(self):
		while not self.stopped:
			self.nbsim = self.nbsim +1
			ret = self.getFight(self.aflt, self.bflt, self.rounds)
			self.stats.appendRound(ret, self.rounds)
			if time.time() - self.lastime > 0.15:
				self.emit(QtCore.SIGNAL("clicked()"))
				self.lastime = time.time()



class flt(Structure):
	_fields_ = [("vaisseau", POINTER(c_int)),("ps", POINTER(c_float)),("pb", POINTER(c_float)),("pa", POINTER(c_float))]

