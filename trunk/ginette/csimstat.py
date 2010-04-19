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

from decimal import Decimal, getcontext
getcontext().prec = 5 #précision voulue

from PyQt4 import QtCore
import copy
from vaisseaux import *
from defenses import *

class csimstat(QtCore.QObject):
    def __init__(self):
        QtCore.QObject.__init__(self)
        self.defInCdr = 0
        self.rounds = []
        self.tabResults = [0]*6
        self.tabResults[0] = []
        self.tabResults[1] = []
        self.tabResults[2] = []
        self.tabResults[3] = []
        self.tabResults[4] = []
        self.tabResults[5] = []
        self.nbSim = 0.0
        self.aMoy = [.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0]
        self.dMoy = [.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0]
        self.rMoy = 0.0
        self.rMax = 0.0


        self.Acaract = copy.deepcopy(VAISS)
        self.Dcaract = copy.deepcopy(VAISS)
        self.Dcaractd = copy.deepcopy(DEF)

        self.perteAMmax = 0.0
        self.perteACmax = 0.0
        self.perteADmax = 0.0
        self.perteATmax = 0.0

        self.perteAMmin = 0.0
        self.perteACmin = 0.0
        self.perteADmin = 0.0
        self.perteATmin = 0.0

        self.perteAMmoy = 0.0
        self.perteACmoy = 0.0
        self.perteADmoy = 0.0
        self.perteATmoy = 0.0


        self.perteDMmax = 0.0
        self.perteDCmax = 0.0
        self.perteDDmax = 0.0
        self.perteDTmax = 0.0
        self.perteDMfmax = 0.0
        self.perteDCfmax = 0.0
        self.perteDDfmax = 0.0
        self.perteDTfmax = 0.0
        self.perteDMdmax = 0.0
        self.perteDCdmax = 0.0
        self.perteDDdmax = 0.0
        self.perteDTdmax = 0.0

        self.perteDMmoy = 0.0
        self.perteDCmoy = 0.0
        self.perteDDmoy = 0.0
        self.perteDTmoy = 0.0

        self.perteDMfmoy = 0.0
        self.perteDCfmoy = 0.0
        self.perteDDfmoy = 0.0
        self.perteDTfmoy = 0.0

        self.CdrMMoy = 0.0
        self.CdrCMoy = 0.0
        self.CdrTMoy = 0.0

        self.CdrTMax = 0.0

        self.M = 0.0
        self.C = 0.0
        self.D = 0.0

        self.tButMmoy = 0.0
        self.tButCmoy = 0.0
        self.tButDmoy = 0.0
        self.tButTmoy = 0.0

        self.totalButMmoy = 0.0
        self.totalButCmoy = 0.0
        self.totalButDmoy = 0.0
        self.totalButTmoy = 0.0

        self.totalButTmax = 0.0
        self.totalButTmin = 0.0

        self.recyMin = 0
        self.recyMoy = 0
        self.recyMax = 0

        self.nbvA = 0
        self.nbvD = 0
        self.nbMn = 0



    def appendRound(self, nb, rounds):
        self.fret = 0.0
        self.nbSim += 1.0
        self.rounds.append(rounds)
        #print rounds
        #print '----------------------------------------------------------------------------------------'
        #print rounds[0][-1]
        #print '----------------------------------------------------------------------------------------'
        #print rounds[1][-1]
        #print '****************************************************************************************'
        nbA = 0
        nbD = 0

        perteA = [.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0]

        perteAM = 0.0
        perteAC = 0.0
        perteAD = 0.0
        perteAT = 0.0

        self.rMoy = ((self.rMoy * (self.nbSim-1.0)) + nb) / self.nbSim
        self.rMax = max(nb, self.rMax)


        for i in range(0,14):
            self.aMoy[i] = ((self.aMoy[i] * (self.nbSim-1.0)) + rounds[0][nb][i]) / self.nbSim
            perteA[i] = rounds[0][0][i] - rounds[0][nb][i]
            #if perteA[i] > 0:                                                        # <-------------------- TODO !!!!!
                #self.emit(QtCore.SIGNAL("aFleetDestroyed"), str(i), perteA[i])
                #print i, ' : ', perteA[i]
            perteAM += self.Acaract[i]['m'] * perteA[i]
            perteAC += self.Acaract[i]['c'] * perteA[i]
            perteAD += self.Acaract[i]['d'] * perteA[i]
            self.fret += self.Acaract[i]['fr'] * rounds[0][nb][i]
            nbA += rounds[0][nb][i]
        #print "-------------------------------------------------"
        #print "-------------------------------------------------"
        #print "perte métal :", perteAM
        #print "perte cristal :", perteAC
        #print "perte deut :", perteAD
        perteAT = perteAM + perteAC + perteAD
        #print "perte totale :", perteAT
        #print "--------"
        self.perteAMmax = max(perteAM, self.perteAMmax)
        self.perteACmax = max(perteAC, self.perteACmax)
        self.perteADmax = max(perteAD, self.perteADmax)
        self.perteATmax = max(perteAT, self.perteATmax)
        #print "perte métal max :", self.perteAMmax
        #print "perte cristal max :", self.perteACmax
        #print "perte deut max :", self.perteADmax
        #print "perte totale max :", self.perteATmax
        #print "--------"
        if self.nbSim == 1:
            self.perteAMmin = perteAM
            self.perteACmin = perteAC
            self.perteADmin = perteAD
            self.perteATmin = perteAT

        else:
            self.perteAMmin = min(perteAM, self.perteAMmin)
            self.perteACmin = min(perteAC, self.perteACmin)
            self.perteADmin = min(perteAD, self.perteADmin)
            self.perteATmin = min(perteAT, self.perteATmin)
        #print "perte métal min :", self.perteAMmin
        #print "perte cristal min :", self.perteACmin
        #print "perte deut min :", self.perteADmin
        #print "perte totale min :", self.perteATmin
        #print "--------"
        self.perteAMmoy = ((self.perteAMmoy * (self.nbSim-1.0)) + perteAM) / self.nbSim
        self.perteACmoy = ((self.perteACmoy * (self.nbSim-1.0)) + perteAC) / self.nbSim
        self.perteADmoy = ((self.perteADmoy * (self.nbSim-1.0)) + perteAD) / self.nbSim
        self.perteATmoy = ((self.perteATmoy * (self.nbSim-1.0)) + perteAT) / self.nbSim
        #print "perte métal moyenne :", self.perteAMmoy
        #print "perte cristal moyenne :", self.perteACmoy
        #print "perte deut moyenne :", self.perteADmoy
        #print "perte totale moyenne :", self.perteATmoy


        perteD = [.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0,.0]
        perteDM = 0.0
        perteDC = 0.0
        perteDD = 0.0
        perteDT = 0.0
        perteDMf = 0.0
        perteDCf = 0.0
        perteDDf = 0.0
        perteDTf = 0.0
        perteDMd = 0.0
        perteDCd = 0.0
        perteDDd = 0.0
        perteDTd = 0.0


        for i in range(0,22):
            self.dMoy[i] = ((self.dMoy[i] * (self.nbSim-1.0)) + rounds[1][nb][i]) / self.nbSim
            perteD[i] = rounds[1][0][i] - rounds[1][nb][i]
            nbD += rounds[1][nb][i]
            if i < 14:
                perteDMf += self.Dcaract[i]['m'] * perteD[i]
                perteDCf += self.Dcaract[i]['c'] * perteD[i]
                perteDDf += self.Dcaract[i]['d'] * perteD[i]
            else:
                perteDMd += self.Dcaractd[i-14]['m'] * perteD[i]
                perteDCd += self.Dcaractd[i-14]['c'] * perteD[i]
                perteDDd += self.Dcaractd[i-14]['d'] * perteD[i]
            #print "moyenne attaquant :", self.aMoy[i]


        if nbA > 0 and nbD == 0:
            self.nbvA += 1
            vA = 1
        elif nbD > 0 and nbA == 0:
            self.nbvD += 1
            vA = 0
        else:
            self.nbMn +=1
            vA = 0

        perteDTf = perteDMf + perteDCf + perteDDf
        perteDTd = perteDMd + perteDCd + perteDDd
        perteDT = perteDTf + perteDTd
        #print "--------"
        #print "perte totale def flotte :", perteDTf
        #print "perte totale def def :", perteDTd
        #print "perte totale def :", perteDT
        #print "--------"
        self.perteDMmax = max(perteDMf+perteDMd, self.perteDMmax)
        self.perteDCmax = max(perteDCf+perteDCd, self.perteDCmax)
        self.perteDDmax = max(perteDDf+perteDDd, self.perteDDmax)
        self.perteDTmax = max(perteDT, self.perteDTmax)
        #print "--------"
        #print "perte métal def max :", self.perteDMmax
        #print "perte cristal def max :", self.perteDCmax
        #print "perte deut def max :", self.perteDDmax
        #print "perte totale def max :", self.perteDTmax
        self.perteDMfmax = max(perteDMf, self.perteDMfmax)
        self.perteDCfmax = max(perteDCf, self.perteDCfmax)
        self.perteDDfmax = max(perteDDf, self.perteDDfmax)
        self.perteDTfmax = max(perteDTf, self.perteDTfmax)
        #print "--------"
        #print "perte métal def flotte max :", self.perteDMfmax
        #print "perte cristal def flotte max :", self.perteDCfmax
        #print "perte deut def flotte max :", self.perteDDfmax
        #print "perte totale def flotte max :", self.perteDTfmax
        #print "--------"
        self.perteDMdmax = max(perteDMd, self.perteDMdmax)
        self.perteDCdmax = max(perteDCd, self.perteDCdmax)
        self.perteDDdmax = max(perteDDd, self.perteDDdmax)
        self.perteDTdmax = max(perteDTd, self.perteDTdmax)
        #print "--------"
        #print "perte métal def def max :", self.perteDMdmax
        #print "perte cristal def def max :", self.perteDCdmax
        #print "perte deut def def max :", self.perteDDdmax
        #print "perte totale def def max :", self.perteDTdmax
        #print "--------"


        if self.nbSim == 1:
            self.perteDMmin = perteDMf + perteDMd
            self.perteDCmin = perteDCf + perteDCd
            self.perteDDmin = perteDDf + perteDDd
            self.perteDTmin = perteDTf + perteDTd

            self.perteDMfmin = perteDMf
            self.perteDCfmin = perteDCf
            self.perteDDfmin = perteDDf
            self.perteDTfmin = perteDTf

        else:
            self.perteDMmin = min(perteDMf + perteDMd, self.perteDMmin)
            self.perteDCmin = min(perteDCf + perteDCd, self.perteDCmin)
            self.perteDDmin = min(perteDDf + perteDDd, self.perteDDmin)
            self.perteDTmin = min(perteDTf + perteDTd, self.perteDTmin)

            self.perteDMfmin = min(perteDMf, self.perteDMfmin)
            self.perteDCfmin = min(perteDCf, self.perteDCfmin)
            self.perteDDfmin = min(perteDDf, self.perteDDfmin)
            self.perteDTfmin = min(perteDTf, self.perteDTfmin)

        #print "--------"
        #print "perte métal def min :", self.perteDMmin
        #print "perte cristal def min :", self.perteDCmin
        #print "perte deut def min :", self.perteDDmin
        #print "perte totale def min :", self.perteDTmin
        #print "--------"
        #print "perte métal def flotte min :", self.perteDMfmin
        #print "perte cristal def flotte min :", self.perteDCfmin
        #print "perte deut def flotte min :", self.perteDDfmin
        #print "perte totale def flotte min :", self.perteDTfmin
        #print "--------"


        self.perteDMmoy = ((self.perteDMmoy * (self.nbSim-1.0)) + (perteDMf + perteDMd)) / self.nbSim
        self.perteDCmoy = ((self.perteDCmoy * (self.nbSim-1.0)) + (perteDCf + perteDCd)) / self.nbSim
        self.perteDDmoy = ((self.perteDDmoy * (self.nbSim-1.0)) + (perteDDf + perteDMd)) / self.nbSim
        self.perteDTmoy = ((self.perteDTmoy * (self.nbSim-1.0)) + perteDT) / self.nbSim
        #print "--------"
        #print "perte métal def moyen :", self.perteDMmoy
        #print "perte cristal def moyen :", self.perteDCmoy
        #print "perte deut def moyen :", self.perteDDmoy
        #print "perte totale def moyen :", self.perteDTmoy
        #print "--------"
        self.perteDMfmoy = ((self.perteDMfmoy * (self.nbSim-1.0)) + (perteDMf)) / self.nbSim
        self.perteDCfmoy = ((self.perteDCfmoy * (self.nbSim-1.0)) + (perteDCf)) / self.nbSim
        self.perteDDfmoy = ((self.perteDDfmoy * (self.nbSim-1.0)) + (perteDDf)) / self.nbSim
        self.perteDTfmoy = ((self.perteDTfmoy * (self.nbSim-1.0)) + perteDTf) / self.nbSim
        #print "--------"
        #print "perte métal def flotte moyen :", self.perteDMfmoy
        #print "perte cristal def flotte moyen :", self.perteDCfmoy
        #print "perte deut def flotte moyen :", self.perteDDfmoy
        #print "perte totale def flotte moyen :", self.perteDTfmoy



        if self.defInCdr == 0:
            self.CdrMMoy = (self.perteAMmoy + self.perteDMfmoy) * 0.3
            self.CdrCMoy = (self.perteACmoy + self.perteDCfmoy) * 0.3
            self.CdrTMoy = (self.perteAMmoy + self.perteDMfmoy + self.perteACmoy + self.perteDCfmoy) * 0.3

            self.CdrTMax = max((perteAM + perteDMf + perteAC + perteDCf) * 0.3 , self.CdrTMax)



            if self.nbSim == 1:
                self.CdrTMin = (perteAM + perteDMf + perteAC + perteDCf) * 0.3
            else:
                self.CdrTMin = min((perteAM + perteDMf + perteAC + perteDCf) * 0.3 , self.CdrTMin)





        self.recyMax = self.CdrTMax / 20000
        self.recyMoy = self.CdrTMoy / 20000
        self.recyMin = self.CdrTMin / 20000



        self.GainsMmoy = self.CdrMMoy - self.perteAMmoy
        self.GainsCmoy = self.CdrCMoy - self.perteACmoy
        self.GainsTmoy = self.CdrTMoy - self.perteATmoy


        self.tButM = self.M / 2
        self.tButC = self.C / 2
        self.tButD = self.D / 2
        self.tButT = self.tButM + self.tButC + self.tButD

        if vA == 1:
            ret = butin(self.M, self.C, self.D, self.fret)
        else:
            ret = [[.0,.0,.0,.0],[.0,.0,.0,.0],[.0,.0,.0,.0]]

        self.tButMmoy = ((self.tButMmoy * (self.nbSim-1.0)) + ret[2][0]) / self.nbSim
        self.tButCmoy = ((self.tButCmoy * (self.nbSim-1.0)) + ret[2][1]) / self.nbSim
        self.tButDmoy = ((self.tButDmoy * (self.nbSim-1.0)) + ret[2][2]) / self.nbSim
        self.tButTmoy = ((self.tButTmoy * (self.nbSim-1.0)) + ret[2][3]) / self.nbSim


        self.totalButMmoy = (((self.tButMmoy + self.GainsMmoy)* (self.nbSim-1.0)) + (ret[2][0] + self.CdrMMoy - self.perteAMmoy)) / self.nbSim
        self.totalButCmoy = (((self.tButCmoy + self.GainsCmoy)* (self.nbSim-1.0)) + (ret[2][1] + self.CdrCMoy - self.perteACmoy)) / self.nbSim
        self.totalButDmoy = self.tButDmoy
        self.totalButTmoy = (((self.tButTmoy + self.GainsTmoy)* (self.nbSim-1.0)) + (ret[2][3]) + self.CdrTMoy - self.perteATmoy)/ self.nbSim


        if self.nbSim == 1:
            self.totalButTmax = ((perteAM + perteDMf + perteAC + perteDCf) * 0.3) + ret[2][3] - perteAT
            self.totalButTmin = ((perteAM + perteDMf + perteAC + perteDCf) * 0.3) + ret[2][3] - perteAT
        else:
            self.totalButTmax = max(((perteAM + perteDMf + perteAC + perteDCf) * 0.3) + ret[2][3] - perteAT, self.totalButTmax)
            self.totalButTmin = min(((perteAM + perteDMf + perteAC + perteDCf) * 0.3) + ret[2][3] - perteAT, self.totalButTmin)

        self.tabResults[0].append(((perteAM + perteDMf + perteAC + perteDCf) * 0.3) + ret[2][3] - perteAT)

        self.tabResults[1].append(((perteAM + perteDMf + perteAC + perteDCf) * 0.3) - perteDTf - perteDTd * 0.7) #TODO: prendre en compte l'officier ingénieur

        self.tabResults[2].append(perteAT)
        self.tabResults[3].append(perteDTf + perteDTd * 0.7) #TODO: prendre en compte l'officier ingénieur
        self.tabResults[4].append((perteAM + perteDMf + perteAC + perteDCf) * 0.3)
        self.tabResults[5].append(((perteAM + perteDMf + perteAC + perteDCf) * 0.3) / 20000)


def butin(M,C,D,Fret):
    but = [[.0,.0,.0,.0],[.0,.0,.0,.0],[.0,.0,.0,.0]]

    but[0][0] = min(Fret/3 , M/2)
    but[0][1] = min((Fret-but[0][0])/2 , C/2)
    but[0][2] = min(Fret-but[0][0]-but[0][1] , D/2);
    but[0][3] = but[0][0] + but[0][1] + but[0][2] + but[0][3]

    but[1][0] = min((Fret-but[0][3])/2 , M/2-but[0][0])
    but[1][1] = min(Fret-but[0][3]-but[1][0] , C/2-but[0][1])
    but[1][2] = 0.0
    but[1][3] = but[1][0] + but[1][1] + but[1][2] + but[1][3]

    but[2][0] = but[0][0]+but[1][0]
    but[2][1] = but[0][1]+but[1][1]
    but[2][2] = but[0][2]+but[1][2]
    but[2][3] = but[0][3]+but[1][3]

    return but

