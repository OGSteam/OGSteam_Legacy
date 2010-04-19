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

import re, math

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



def getHtmlReFromFlotte(mat, flotte, deff, tek):
	fltNames = ['Petit transporteur', \
					'Grand transporteur', \
					'Chasseur léger', \
					'Chasseur lourd', \
					'Croiseur', \
					'Vaisseau de bataille', \
					'Vaisseau de colonisation', \
					'Recycleur', \
					'Sonde espionnage', \
					'Bombardier', \
					'Satellite solaire', \
					'Destructeur', \
					'Étoile de la mort', \
					'Traqueur']
	defNames = ['Lanceur de missiles', \
					'Artillerie laser légère', \
					'Artillerie laser lourde', \
					'Canon de Gauss', \
					'Artillerie à ions', \
					'Lanceur de plasma', \
					'Petit bouclier', \
					'Grand bouclier', \
					'Missile Interception']
	tekNames = ['Technologie Espionnage', \
					'Technologie Ordinateur', \
					'Technologie Armes', \
					'Technologie Bouclier', \
					'Technologie Protection des vaisseaux spatiaux', \
					'Technologie Energie', \
					'Technologie Hyperespace', \
					'Réacteur à combustion', \
					'Réacteur à impulsion', \
					'Propulsion hyperespace', \
					'Technologie Laser', \
					'Technologie Ions', \
					'Technologie Plasma', \
					'Réseau de recherche intergalactique', \
					'Technologie Graviton']
	ret = '<center><table style="color:#fff" cellspacing="3" width="380" bgcolor="#344566"><tr><td colspan="4" bgcolor="#263148">Matières premières sur  '+str(mat[3])+'</td></tr>'
	ret += '<tr><td>Métal</td><td align="right">'+mat[0]+'</td><td>Cristal</td><td align="right">'+mat[1]+'</td></tr>'
	ret += '<tr><td>Deutérium</td><td align="right">'+mat[2]+'</td><td></td><td></td></tr>'
	cpt = 1
	ret += '<tr><td colspan="4" bgcolor="#263148">Flotte</td></tr><tr>'
	for i in range(0,len(flotte)):
		if flotte[i] > 0:
			ret += '<td>'+fltNames[i]+'</td><td align="right">'+str(flotte[i])+'</td>'
			if cpt % 2 == 0:
				ret += '</tr><tr>'
			cpt = cpt+1
	ret = re.sub("</tr><tr>$", '', ret)

	cpt = 1
	ret += '<tr><td colspan="4" bgcolor="#263148">Défense</td></tr><tr>'
	for i in range(0,len(deff)):
		if deff[i] > 0:
			ret += '<td>'+defNames[i]+'</td><td align="right">'+str(deff[i])+'</td>'
			if cpt % 2 == 0:
				ret += '</tr><tr>'
			cpt = cpt+1
	ret = re.sub("</tr><tr>$", '', ret)

	cpt = 1
	ret += '<tr><td colspan="4" bgcolor="#263148">Recherche</td></tr><tr>'
	for i in range(0,len(tek)):
		if tek[i] > 0:
			ret += '<td>'+tekNames[i]+'</td><td align="right">'+str(tek[i])+'</td>'
			if cpt % 2 == 0:
				ret += '</tr><tr>'
			cpt = cpt+1
	ret = re.sub("</tr><tr>$", '', ret)
	ret += '</tr></table></center>'
	return ret


def getNecessaryFret(res):
	m = float(res[0])/2
	c = float(res[1])/2
	d = float(res[2])/2
	return max(m+c+d,min((2*m+c+d)*3/4,(2*m+d)))


def ceilInputFromFloat(n):
	i = math.ceil(n)
	if i == 0.0:
		return ''
	else:
		return str(int(i))

def getNextDef(a,b,t):
	if a == '': a = 0.0
	else: a = float(a)
	if b == '': b = 0.0
	else: b = float(b)
	return ceilInputFromFloat(b+(a-b)*t)



