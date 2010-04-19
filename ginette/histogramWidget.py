#!/usr/bin/python
# -*- coding: utf8 -*-

from PyQt4 import QtGui, QtCore
import sys
from math import *
import copy

class Plotter(QtGui.QWidget):
	def __init__(self, parent = None):
		QtGui.QWidget.__init__(self, parent)
		self.setMouseTracking(1)
		self.bars = 15.0
		self.mouseOver = False
		self.mouseX = 0.0
		self.mouseY = 0.0
		self.nbValues = 0
		self.setCursor(QtGui.QCursor(QtCore.Qt.CrossCursor))

	def paintEvent(self, event):
		try:
			painter = QtGui.QPainter()
			if self.nbValues > 0:
				try: self.setClasses()
				except: pass
				painter.begin(self)

				painter.setFont(QtGui.QFont("Helvetica [Cronyx]", 7))
				w = self.width()-30.0
				p = w/10.0
				sc = self.tryScale(max(abs(self.maxValue), abs(self.minValue)))
				for i in range(11):
					painter.setPen(QtGui.QColor(255, 255, 255, 70))
					painter.drawLine(QtCore.QLine((i*p)+20.0, 17.0, (i*p)+20.0, self.height()-16.0))
					val = round(self.getValueX(float(i)*p, True)/sc, 3)
					if val > 0.0:
						painter.setPen(QtGui.QColor(QtGui.QColor(0, 0, 0, 255)))
					else:
						painter.setPen(QtGui.QColor(QtGui.QColor(160, 0, 0, 255)))
					painter.setOpacity(1.0)
					painter.drawText(QtCore.QPoint(i*p+5.0, self.height()-5.0), str(val))

				h = self.height()-38.0
				p = h/6.0
				for i in range(7):
					painter.setPen(QtGui.QColor(255, 255, 255, 70))
					painter.drawLine(QtCore.QLine(17.0, i*p+19.0, self.width()-5.0, i*p+19.0))
					painter.setPen(QtGui.QColor(QtGui.QColor(0, 0, 0, 255)))
					painter.drawText(QtCore.QPoint(0, i*p+19.0), str(round(abs((self.height()-38.0)-(i*p))* self.yStepPixel/float(len(self.values))*100.0,1)))


			painter.setBrush(QtGui.QBrush(QtGui.QColor(255, 255, 255, 35)))
			background = QtCore.QRect(-1, -1, self.width()+1, self.height()+1)
			painter.drawRect(background)
			painter.setPen(QtCore.Qt.black)
			painter.setBrush(QtGui.QBrush(QtGui.QColor(0, 0, 255, 60)))
			for i in range(int(self.bars)):
				rect = self.getBar(i)
				painter.drawRect(rect)
			if self.mouseOver:
				painter.setFont(QtGui.QFont("Helvetica [Cronyx]", 9, QtGui.QFont.Bold))
				painter.drawText(QtCore.QPoint(30, 15), 'x: '+str(number_format(self.getValueX()))+'  , y: '+str(number_format(self.getValueY()))+' ('+str(self.perCentY)+' %) ')


			painter.end()
		except: pass

	def mouseMoveEvent(self, event):
		if event.pos().x() > 20.0 and event.pos().y() > 20.0 and event.pos().x() < self.width() and event.pos().y() < self.height() - 17.0:
			self.mouseOver = True
			self.mouseX = event.pos().x()
			self.mouseY = event.pos().y()
			self.update()
		else:
			self.mouseOver = False
			self.update()


	def setClasses(self):
		if self.nbValues > 0:
			step = 1.0 / self.bars * (1.0 + self.maxValue - self.minValue)
			self.values.sort()
			self.barValues = [0] * int(self.bars)
			for i in self.values:
				index = int(floor((i - self.minValue)/ step))
				self.barValues[index] += 1
			self.maxHeightValue = max(self.barValues)
			self.minHeightValue = min(self.barValues)
			self.xStep = (self.width()-30.0)/self.bars
			self.yStep = (self.height()-40.0)/self.maxHeightValue

			self.xStepPixel = (self.maxValue - self.minValue) / (self.width()-30.0)
			self.yStepPixel = (self.maxHeightValue - 0.0) / (self.height()-40.0)


	def getValueX(self, value = False, man = False):
		if not value and not man:
			return int(round(self.minValue + ((float(self.mouseX) - 21.0) * self.xStepPixel)))
		else:
			return self.minValue + (float(value) * self.xStepPixel)

	def getValueY(self, value = False):
		if not value:
			ret = (self.height()-float(self.mouseY) - 18.0) * self.yStepPixel
			self.getPercentY(ret)
			return int(round(ret))

	def getPercentY(self, v):
		self.perCentY = round((v/float(len(self.values)))*100.0, 2)

	def getBar(self, i):
		return QtCore.QRect(i*self.xStep+20.0, self.height()-20.0, self.xStep, -(self.barValues[i]*self.yStep))

	def setBar(self, i):
		self.bars = float(i)
		self.update()

	def setValues(self, values):
		self.values = values
		self.maxValue = max(self.values)
		self.minValue = min(self.values)
		self.nbValues = len(self.values)
		self.update()

	def tryScale(self, v):
		if abs(v/ 1000000000.0) < 10.0 and abs(v/ 1000000000.0) > 1.0:
			return 1000000000.0
		elif abs(v/ 100000000.0) < 10.0 and abs(v/ 100000000.0) > 1.0:
			return 100000000.0
		elif abs(v/ 10000000.0) < 10.0 and abs(v/ 10000000.0) > 1.0:
			return 10000000.0
		elif abs(v/ 1000000.0) < 10.0 and abs(v/ 1000000.0) > 1.0:
			return 1000000.0
		elif abs(v/ 100000.0) < 10.0 and abs(v/ 100000.0) > 1.0:
			return 100000.0
		elif abs(v/ 10000.0) < 10.0 and abs(v/ 10000.0) > 1.0:
			return 10000.0
		elif abs(v/ 1000.0) < 10.0 and abs(v/ 1000.0) > 1.0:
			return 1000.0
		elif abs(v/ 100.0) < 10.0 and abs(v/ 100.0) > 1.0:
			return 100.0
		elif abs(v/ 10.0) < 10.0 and abs(v/ 10.0) > 1.0:
			return 10.0


def number_format(num, places=0):
	places = max(0,places)
	tmp = "%.*f" % (places, num)
	point = tmp.find(".")
	integer = (point == -1) and tmp or tmp[:point]
	decimal = (point != -1) and tmp[point:] or ""
	count =  0
	formatted = []
	for i in range(len(integer), 0, -1):
		count += 1
		formatted.append(integer[i - 1])
		if count % 3 == 0 and i - 1:
			formatted.append(".")
	integer = "".join(formatted[::-1])
	return integer+decimal




if __name__ == "__main__":
	app = QtGui.QApplication(sys.argv)
	window = Plotter()
	window.show()
	sys.exit(app.exec_())