/*
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
*/

#include <stdlib.h>
#include <time.h>
#include <stdio.h>

typedef struct flotte
{
        int *vaisseau;
        float *ps;
        float *pb;
        float *va;
} flotte;


int mypi(flotte aflt, flotte dflt, int rounds[2][7][25]) {

	int i;
	int aNb = 0;
	int dNb = 0;

	// comptage du nombre de vaisseaux + remplissage du 0eme round
	for(i=0;i<25;i++) {
		aNb += aflt.vaisseau[i];
		dNb += dflt.vaisseau[i];
		rounds[0][0][i] = aflt.vaisseau[i];
		rounds[1][0][i] = dflt.vaisseau[i];
	}
	//printf("comptage réussit : %d et %d\n", aNb, dNb);

	// pointeurs sur tableaux
	int *aTab; //type de vaisseau
	float *aPs; //points de strusture
	float *aPb; //points de bouclier
	int *aExp; //Flag d'explosion
	int *dTab;
	float *dPs;
	float *dPb;
	int *dExp;
	// pointeurs sur tableaux temporaires
	int *aTabt;
	float *aPst;
	float *aPbt;
	int *aExpt;
	int *dTabt;
	float *dPst;
	float *dPbt;
	int *dExpt;

	// allocation mémoire des tableaux
	aTab = malloc (aNb * sizeof (int));
	aPs = malloc (aNb * sizeof (float));
	aPb = malloc (aNb * sizeof (float));
	aExp = malloc (aNb * sizeof (int));
	dTab = malloc (dNb * sizeof (int));
	dPs = malloc (dNb * sizeof (float));
	dPb = malloc (dNb * sizeof (float));
	dExp = malloc (dNb * sizeof (int));

	//printf("tableaux créés\n");
	int z;
	int acpt = 0;
	int dcpt = 0;
	// remplissage des tableaux
	for(i=0;i<25;i++) {
		if (aflt.vaisseau[i] > 0) {
			for (z=0;z<aflt.vaisseau[i];z++) {
				aTab[acpt] = i;
				aPs[acpt] = aflt.ps[i];
				aPb[acpt] = aflt.pb[i];
				aExp[acpt] = 0;
				//printf("%d : vaisseau attaquant de type %d\n", acpt, i);
				//printf("vérification : %d, %f, %f\n", aTab[acpt], aPs[acpt], aPb[acpt]);
				acpt++;
			}
		}
		if (dflt.vaisseau[i] > 0) {
			for (z=0;z<dflt.vaisseau[i];z++) {
				dTab[dcpt] = i;
				dPs[dcpt] = dflt.ps[i];
				dPb[dcpt] = dflt.pb[i];
				dExp[dcpt] = 0;
				//printf("%d : vaisseau défenseur de type %d\n", dcpt, i);
				//printf("vérification : %d, %f, %f\n", dTab[dcpt], dPs[dcpt], dPb[dcpt]);
				dcpt++;
			}
		}
	}

	int cible;
	float deg;

	int cpa = 0;
	int cpd = 0;

	int taNb;
	int tdNb;

	int atir = 0;
	int dtir = 0;

	float apuis = 0;
	float dpuis = 0;

	int round = 1;

	// mise des rounds à zero
	int r;
	for(r=1;r<7;r++) {
		for(i=0;i<25;i++) {
			rounds[0][r][i] = 0;
			rounds[1][r][i] = 0;
		}
	}

	int rf = 0;


	while (round <= 6 && aNb > 0 && dNb > 0) {
		//printf("---------------------------------------------------------------------------------\n");
		//printf("ROUND %d -------------------------------------------------------------------------\n", round);
		//printf("---------------------------------------------------------------------------------\n");

		//printf("L'attaquant tire >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n");
		for(i=0;i<aNb;i++) {
			do {
				atir++;
				apuis += aflt.va[aTab[i]];
				cible = randnum(dNb);
				//printf("le vaisseau %d de type %d tire sur le vaisseau %d de type %d\n", i, aTab[i], cible, dTab[cible]);
				//printf(" sa valeur d'attaque est de %f, bouclier defenseur : %f, points de structure : %f\n", aflt.va[aTab[i]], dPb[cible], dPs[cible]);

				if (aflt.va[aTab[i]] * 100.0 > dflt.pb[dTab[cible]] ) { // si le tir dépasse 1% du bouclier
					if (aflt.va[aTab[i]] <= dPb[cible]) { // le tire ne transperse pas le bouclier
						//printf("  N'attaque pas la structure !\n");
						dPb[cible] = dPb[cible] - aflt.va[aTab[i]];
						//printf("   Le bouclier passe à %f\n", dPb[cible]);
					}
					else {
						//printf("  La structure est touchée !\n");
						deg = dPs[cible] + dPb[cible] - aflt.va[aTab[i]];
						//printf("   La structure passe à %f (%f + %f - %f)\n", deg, dPs[cible], dPb[cible], aflt.va[aTab[i]]);
						dPb[cible] = 0.0;
						dPs[cible] = deg;
						if (deg - 0.00005 <= 0.7 * dflt.ps[dTab[cible]]) { // probabilité d'explosion (bug des flottants)
							//printf("    Risque d'explosion du vaisseau de %f  (%f - %f) / %f\n", (dflt.ps[dTab[cible]] - dPs[cible] ) / dflt.ps[dTab[cible]], dflt.ps[dTab[cible]], dPs[cible], dflt.ps[dTab[cible]]);
							//jet = rand()/(RAND_MAX+1.0);
							if (rand()/(RAND_MAX+1.0) - 0.00005 <= (dflt.ps[dTab[cible]] - dPs[cible]) / dflt.ps[dTab[cible]]) { // explosé
								//printf("     EXPLOSED !!!\n");
								dExp[cible] = 1;
							}
						}
					}
				}
				rf = rapid(aTab[i], dTab[cible]);
			} while (rf == 1);
		}
		//printf("---------------------------------------------------------------------\n");
		//printf("Le défenseur tire >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n");
		for(i=0;i<dNb;i++) {
			do {
				dtir++;
				dpuis += dflt.va[dTab[i]];
				cible = randnum(aNb);
				//printf("le vaisseau %d de type %d tire sur le vaisseau %d de type %d\n", i, dTab[i], cible, aTab[cible]);
				//printf(" sa valeur d'attaque est de %f, bouclier defenseur : %f, points de structure : %f\n", dflt.va[dTab[i]], aPb[cible], aPs[cible]);

				if (dflt.va[dTab[i]] * 100.0 > aflt.pb[aTab[cible]] ) { // si le tir dépasse 1% du bouclier
					if (dflt.va[dTab[i]] <= aPb[cible]) { // le tire ne transperse pas le bouclier
						//printf("  N'attaque pas la structure !\n");
						aPb[cible] = aPb[cible] - dflt.va[dTab[i]];
						//printf("   Le bouclier passe à %f\n", aPb[cible]);
					}
					else {
						//printf("  La structure est touchée !\n");
						deg = aPs[cible] + aPb[cible] - dflt.va[dTab[i]];
						//printf("   La structure passe à %f\n", deg);
						aPb[cible] = 0.0;
						aPs[cible] = deg;
						if (deg  - 0.00005 <= 0.7 * aflt.ps[aTab[cible]]) { // probabilité d'explosion (bug des flottants)
							//printf("    Risque d'explosion du vaisseau de %f\n", (aflt.ps[aTab[cible]] - aPs[cible] ) / aflt.ps[aTab[cible]]);
							if (rand()/(RAND_MAX+1.0) - 0.00005 <= (aflt.ps[aTab[cible]] - aPs[cible]) / aflt.ps[aTab[cible]]) { // explosé
								//printf("     EXPLOSED !!!\n");
								aExp[cible] = 1;
							}
						}
					}
				}
				rf = rapid(dTab[i], aTab[cible]);
			} while (rf == 1);
		}

		//printf("l'attaquant tire %d fois avec une puissance totale de %f\n", atir, apuis);
		//printf("le defenseur tire %d fois avec une puissance totale de %f\n", dtir, dpuis);

		// comptage des vaisseaux restants
		taNb = aNb;
		tdNb = dNb;
		for (i=0;i<aNb;i++) {
			if (aExp[i] == 1) {
				taNb -= 1;
			}
			else {
				rounds[0][round][aTab[i]] += 1;
			}
			//printf("> %d\n", aExp[i]);
		}
		//printf("attaquant : %d vaisseaux\n", taNb);

		//printf("------\n");
		for (i=0;i<dNb;i++) {
			if (dExp[i] == 1) {
				tdNb -= 1;
			}
			else {
				rounds[1][round][dTab[i]] += 1;
			}
			//printf("> %d\n", dExp[i]);
		}
		//printf("defenseur : %d vaisseaux\n", tdNb);

		if (round <= 6 && taNb > 0 && tdNb > 0) {

			//printf("réallocation de mémoire\n");
			aTabt = malloc (taNb * sizeof (int));
			aPst = malloc (taNb * sizeof (float));
			aPbt = malloc (taNb * sizeof (float));
			aExpt = malloc (taNb * sizeof (int));
			dTabt = malloc (tdNb * sizeof (int));
			dPst = malloc (tdNb * sizeof (float));
			dPbt = malloc (tdNb * sizeof (float));
			dExpt = malloc (tdNb * sizeof (int));


			// création des tableaux
			cpa = 0;
			for (i=0;i<aNb;i++) {
				if (aExp[i] == 0) {
					aTabt[cpa] = aTab[i];
					aPst[cpa] = aPs[i];
					aPbt[cpa] = aflt.pb[aTab[i]];
					aExpt[cpa] = 0;
					//printf("%d : %d, %f, %f, %d\n", cpa, aTabt[cpa], aPst[cpa], aPbt[cpa], aExpt[cpa]);
					cpa ++;
				}
			}
			//printf("------------------------\n");

			cpd = 0;
			for (i=0;i<dNb;i++) {
				if (dExp[i] == 0) {
					dTabt[cpd] = dTab[i];
					dPst[cpd] = dPs[i];
					dPbt[cpd] = dflt.pb[dTab[i]];
					dExpt[cpd] = 0;
					//printf("%d : %d, %f, %f, %d\n", cpd, dTabt[cpd], dPst[cpd], dPbt[cpd], dExpt[cpd]);
					cpd ++;
				}
			}
			//printf("------------------------\n");


			free(aTab);
			free(aPs);
			free(aPb);
			free(aExp);
			free(dTab);
			free(dPs);
			free(dPb);
			free(dExp);

			aTab = aTabt;
			aPs = aPst;
			aPb = aPbt;
			aExp = aExpt;
			dTab = dTabt;
			dPs = dPst;
			dPb = dPbt;
			dExp = dExpt;

		}

		aNb = taNb;
		dNb = tdNb;

		round ++;

		atir = 0;
		dtir = 0;
		apuis = 0.0;
		dpuis = 0.0;

	}

	free(aTab);
	free(aPs);
	free(aPb);
	free(aExp);
	free(dTab);
	free(dPs);
	free(dPb);
	free(dExp);

	return round - 1;
}



int rapid(int a, int d) {
	if(a == 12) { // edlm
		if(d == 12 || d == 19 || d == 20 || d == 21) {return 0;}
		if(d == 8 || d == 10) {return (rand()/(RAND_MAX+1.0)	<= 0.9992)?1:0;} // ss, se - RF (1250)
		if(d == 2 || d == 14 || d == 15) {return (rand()/(RAND_MAX+1.0)	<= 0.995)?1:0;} // cle, lle, lm - RF (200)
		if(d == 3 || d == 16 || d == 18) {return (rand()/(RAND_MAX+1.0)	<= 0.99)?1:0;} // clo, llo, ai - RF(100)
		if(d == 17) {return (rand()/(RAND_MAX+1.0)	<= 0.98)?1:0;} // cg - RF(50)
		if(d == 4) {return (rand()/(RAND_MAX+1.0)	<= 0.9696969696)?1:0;}  // cr - RF(33)
		if(d == 5) {return (rand()/(RAND_MAX+1.0)	<= 0.9666666666)?1:0;}  // Vb - RF(30)
		if(d == 9) {return (rand()/(RAND_MAX+1.0)	<= 0.96)?1:0;} // bo - RF(25)
		if(d == 13) {return (rand()/(RAND_MAX+1.0)	<= 0.9333333333)?1:0;} // tr - RF(15)
		if(d == 11) {return (rand()/(RAND_MAX+1.0)	<= 0.8)?1:0;} // de - RF(5)

		return (rand()/(RAND_MAX+1.0)	<= 0.996)?1:0;  // autres - RF(250)
	}
	if((d == 8 || d == 10) && a != 8 && a < 14) {return (rand()/(RAND_MAX+1.0)	<= 0.8)?1:0;} // RF(5)

	if(a == 3) { // chasseur lourd
		if(d == 0) {return (rand()/(RAND_MAX+1.0)	<= 0.6666666666)?1:0;} // pt - RF(3)
		return 0;
	}

	if(a == 4) { // croiseur
		if(d == 2) {return (rand()/(RAND_MAX+1.0)	<= 0.8333333333)?1:0;}// cle - RF(6)
		if(d == 14) {return (rand()/(RAND_MAX+1.0)	<= 0.9)?1:0;} // lm - RF(10)
		return 0;
	}
	if(a == 11) { // destructeur
		if(d == 15) {return (rand()/(RAND_MAX+1.0)	<= 0.9)?1:0;} // lle - RF(10)
		if(d == 13) {return (rand()/(RAND_MAX+1.0)	<= 0.5)?1:0;} // tr - RF(2)
		return 0;
	}
	if(a == 9) { // bombardier
		if(d == 14 || d == 15) {return (rand()/(RAND_MAX+1.0)	<= 0.95)?1:0;} // lm; lle- RF(20)
		if(d == 16 || d == 18) {return (rand()/(RAND_MAX+1.0)	<= 0.9)?1:0;} // llo, ions - RF(10)
		return 0;
	}
	if(a == 13) { // traqueur
		if(d == 0 || d == 1) {return (rand()/(RAND_MAX+1.0)	<= 0.6666666666)?1:0;} // pt; gt- RF(3)
		if(d == 4 || d == 3) {return (rand()/(RAND_MAX+1.0)	<= 0.75)?1:0;} // cr, clo - RF(4)
		if(d == 5) {return (rand()/(RAND_MAX+1.0)	<= 0.8571428571)?1:0;} // vb - RF(7)
		return 0;
	}
	return 0;
}

int randnum(int n) {
	if (n <= RAND_MAX) {
		return (int)rand()%n;
	}
	else {
		int a = (int)rand()<<16;
		int b = (int)rand();
		return (a|b)%n;
	}
}

void randInit() {
	srand(time(NULL));
}


int main() {
	return 0;
}




// pour compiler l'bazare :
// gcc -o libogsim libogsim.c

// pour en faire une librairie partagée :
// gcc -c -fPIC -msse -m3dnow -mmmx -ffast-math -O2 libogsim.c
// gcc -shared -o libogsim.so libogsim.o



