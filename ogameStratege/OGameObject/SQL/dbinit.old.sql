/******************************************************************************/
/****         Generated by IBExpert 2005.09.25 11/10/2005 03:33:55         ****/
/******************************************************************************/



/******************************************************************************/
/****                              Generators                              ****/
/******************************************************************************/

CREATE GENERATOR GEN_ALLIANCE_ID;
CREATE GENERATOR COMBATS_ID;
CREATE GENERATOR ESPIONAGES_ID;
CREATE GENERATOR GEN_CONFIG_ID;
CREATE GENERATOR GEN_FLEETCOMMANDS_ID;
CREATE GENERATOR GEN_GALAXY_ID;
CREATE GENERATOR GEN_SPACECONTROLS_ID;
CREATE GENERATOR PLANETS_ID;
CREATE GENERATOR PLAYERFLOTTE_ID;
CREATE GENERATOR PLAYERRANK_ID;
CREATE GENERATOR PLAYERSRESEARCH_ID;
CREATE GENERATOR PLAYER_ID;
CREATE GENERATOR GEN_SPYDATA_ID;


/******************************************************************************/
/****                                Tables                                ****/
/******************************************************************************/


CREATE TABLE ALLIANCE (
    ID INTEGER NOT NULL,
    NAME VARCHAR(40),
    ALLIANCEPAGE VARCHAR(250),
    ALLIANCEBOARD VARCHAR(250),
    DATASENDER VARCHAR(30),
    DATADATE TIMESTAMP NOT NULL
);
    
    
CREATE TABLE COMBATS (
    ID               INTEGER NOT NULL,
    ATTACKER_PLANET  INTEGER NOT NULL,
    DEFENDER_PLANET  INTEGER NOT NULL,
    DATA             BLOB SUB_TYPE 1 SEGMENT SIZE 80 NOT NULL,
    DATASENDER       VARCHAR(30),
    DATADATE         TIMESTAMP NOT NULL
);


CREATE TABLE CONFIG (
    ID          SMALLINT NOT NULL,
    PARAMNAME   VARCHAR(20) NOT NULL,
    PARAMVALUE  VARCHAR(200) NOT NULL
);


CREATE TABLE ESPIONAGES (
    ID          INTEGER NOT NULL,
    PLANET_ID   INTEGER NOT NULL,
    DATA        BLOB SUB_TYPE 1 SEGMENT SIZE 80,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL,
    SHAREABLE   SMALLINT DEFAULT 0 NOT NULL
);


CREATE TABLE FLEETCOMMANDS (
    ID          INTEGER NOT NULL,
    DATA        BLOB SUB_TYPE 1 SEGMENT SIZE 80 NOT NULL,
    DATASENDER  VARCHAR(30) NOT NULL,
    DATADATE    TIMESTAMP NOT NULL
);


CREATE TABLE GALAXY (
    ID          INTEGER NOT NULL,
    GALAXY      INTEGER NOT NULL,
    SYSTEM      INTEGER NOT NULL,
    DATADATE    TIMESTAMP NOT NULL,
    DATASENDER  VARCHAR(30) NOT NULL,
    COORDS      COMPUTED BY (GALAXY || ':' || SYSTEM),
    SHAREABLE   SMALLINT DEFAULT 0 NOT NULL
);


CREATE TABLE PLANETS (
    ID          INTEGER NOT NULL,
    NAME        VARCHAR(30) NOT NULL,
    GALAXY      INTEGER,
    SYSTEM      INTEGER,
    PLANETNUM   INTEGER,
    MOON        VARCHAR(20) NOT NULL,
    FIELDS      VARCHAR(30) NOT NULL,
    PLAYERID    INTEGER,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL,
    COORDS      COMPUTED BY (('[' || GALAXY || ':' || SYSTEM || ':' || PLANETNUM || ']'))
);


CREATE TABLE PLAYERS (
    ID                INTEGER NOT NULL,
    NAME              VARCHAR(30) NOT NULL,
    ALLIANCE          VARCHAR(30),
    MAINPLANETCOORDS  VARCHAR(8),
    SHORTINACTIVE     SMALLINT DEFAULT 0,
    LONGINACTIVE      SMALLINT DEFAULT 0,
    NOOB			  SMALLINT DEFAULT 0,
    VACANCY			  SMALLINT DEFAULT 0,
    BLOCKED           SMALLINT DEFAULT 0,
    NOTE              BLOB SUB_TYPE 1 SEGMENT SIZE 80,
    DATASENDER        VARCHAR(30),
    DATADATE          TIMESTAMP NOT NULL
);


CREATE TABLE PLAYERSFLOTTE (
    ID          INTEGER NOT NULL,
    PLAYER_ID   INTEGER NOT NULL,
    RANK        INTEGER NOT NULL,
    POINTS      INTEGER,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL
);


CREATE TABLE PLAYERSRANK (
    ID          INTEGER NOT NULL,
    PLAYER_ID   INTEGER NOT NULL,
    RANK        INTEGER NOT NULL,
    POINTS      INTEGER NOT NULL,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL
);


CREATE TABLE PLAYERSRESEARCH (
    ID          INTEGER NOT NULL,
    PLAYER_ID   INTEGER NOT NULL,
    RANK        INTEGER NOT NULL,
    POINTS      INTEGER,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL
);


CREATE TABLE SPACECONTROLS (
    ID             INTEGER NOT NULL,
    PLANET_SPYING  INTEGER NOT NULL,
    PLANET_TARGET  INTEGER,
    DATASENDER     VARCHAR(30),
    DATADATE       TIMESTAMP,
    COUNTERESPIO   INTEGER
);

CREATE TABLE SPYDATA (
    ID               INTEGER NOT NULL,
    PLANET_ID        INTEGER,
    DATADATE         TIMESTAMP,
    DATASENDER       VARCHAR(30),
    METAL            INTEGER,
    CRYSTAL          INTEGER,
    DEUTERIUM        INTEGER,
    ENERGY           INTEGER,
    MISSILE_L        INTEGER,
    SMALL_L          INTEGER,
    HEAVY_L          INTEGER,
    ION_C            INTEGER,
    GAUSS_C          INTEGER,
    PLASMA_C         INTEGER,
    SMALL_SD         INTEGER,
    LARGE_SD         INTEGER,
    SMALL_CS         INTEGER,
    LARGE_CS         INTEGER,
    INTERCEPT_M      INTEGER,
    INTERPLAN_M      INTEGER,
    LIGHT_F          INTEGER,
    HEAVY_F          INTEGER,
    CRUISER          INTEGER,
    BATTLE_S         INTEGER,
    ESPIONAGE_P      INTEGER,
    COLONY_SHIP      INTEGER,
    RECYCLER         INTEGER,
    BOMBER           INTEGER,
    SOLAR_S          INTEGER,
    DESTROYER        INTEGER,
    DEATH_STAR       INTEGER,
    METAL_MINE       SMALLINT,
    CRYSTAL_MINE     SMALLINT,
    DEUTERIUM_SYNTH  SMALLINT,
    SOLAR_PLANT      SMALLINT,
    FUSION_PLANT     SMALLINT,
    ROBOT_FACT       SMALLINT,
    NANITE           SMALLINT,
    SHIPYARD         SMALLINT,
    METAL_STORAGE    SMALLINT,
    CRYSTAL_STORAGE  SMALLINT,
    DEUTERIUM_TANK   SMALLINT,
    RESEARCH_LAB     SMALLINT,
    ROCKET_SILO      SMALLINT,
    LUNAR_B          SMALLINT,
    PHALANGE         SMALLINT,
    JUMPDOOR         SMALLINT,
    T_ESPIO			 SMALLINT,
    T_COMPUTER		 SMALLINT,
    T_WEAPON		 SMALLINT,
    T_SHIELD		 SMALLINT,
    T_PROTECT		 SMALLINT,
    T_ENERGY		 SMALLINT,
    T_HYPER			 SMALLINT,
    T_COMBUS		 SMALLINT,
    T_IMPULSE		 SMALLINT,
    T_PROPHYPER		 SMALLINT,
    T_LAZER			 SMALLINT,
    T_IONS			 SMALLINT,
    T_PLASMA         SMALLINT,
    T_INTERNETWORK   SMALLINT,
    T_GRAVITON		 SMALLINT,
    SPYDESTROY       SMALLINT
);


/******************************************************************************/
/****                                Views                                 ****/
/******************************************************************************/


/* View: COMBATSREPORT */
CREATE VIEW COMBATSREPORT(
    ATTACKERNAME,
    ATTACKERPLANET,
    DEFENDERNAME,
    DEFENDERPLANET,
    RAWREPORT,
    DATADATE,
    DATASENDER)
AS
select P1.NAME , PL1.COORDS,P2.NAME , PL2.COORDS  ,C.DATA ,C.datadate ,C.datasender
from  COMBATS C
JOIN PLANETS PL1 ON PL1.id=c.attacker_planet
JOIN PLANETS PL2 ON PL2.id =c.defender_planet 
LEFT JOIN PLAYERS P1 ON P1.ID=PL1.playerid
LEFT JOIN PLAYERS P2 ON P2.ID=PL2.playerid
;



/* View: ESPIONAGESREPORT */
CREATE VIEW ESPIONAGESREPORT(
    NAME,
    COORDS,
    RAWREPORT,
    DATADATE,
    DATASENDER)
AS
select P.name , P.coords  ,E.data ,E.datadate ,E.datasender  from planets P, espionages E
where P.id = E.planet_id
;






/* View: RANKINGFLOTTE */
CREATE VIEW RANKINGFLOTTE(
    PLAYER_ID,
    "Rank",
    "Name",
    "Alliance",
    "Points",
    DATADATE,
    DATASENDER)
AS
select DISTINCT P.ID,PR.RANK,P.NAME ,P.ALLIANCE,PR.POINTS,PR.DATADATE,PR.datasender  from PLAYERS P, PLAYERSFLOTTE PR
where (PR.player_id = P.ID
and PR.DATADATE = (SELECT MAX(DATADATE) FROM playersflotte WHERE PLAYER_ID=PR.player_id ))
;



/* View: RANKINGPOINTS */
CREATE VIEW RANKINGPOINTS(
    PLAYER_ID,
    "Rank",
    "Name",
    "Alliance",
    "Points",
    DATADATE,
    DATASENDER)
AS
select DISTINCT P.ID,PR.RANK,P.NAME ,P.ALLIANCE,PR.POINTS,PR.DATADATE,PR.DATASENDER  from PLAYERS P, PLAYERSRANK PR
where (PR.player_id = P.ID
and PR.DATADATE = (SELECT MAX(DATADATE) FROM playersrank WHERE PLAYER_ID=PR.player_id ))
;



/* View: RANKINGRESEARCH */
CREATE VIEW RANKINGRESEARCH(
    PLAYER_ID,
    "Rank",
    "Name",
    "Alliance",
    "Points",
    DATADATE,
    DATASENDER)
AS
select DISTINCT P.ID,PR.RANK,P.NAME ,P.ALLIANCE,PR.POINTS,PR.DATADATE,PR.datasender  from PLAYERS P, playersresearch  PR
where (PR.player_id = P.ID
and PR.DATADATE = (SELECT MAX(DATADATE) FROM playersresearch  WHERE PLAYER_ID=PR.player_id ))
;

/* View: RANKINGALL */
CREATE VIEW RANKINGALL(
    PLAYER_ID,
    "Rank",
    "Name",
    "Alliance",
    "Points",
    "Flotte",
    "Research",
    DATADATE,
    DATASENDER)
AS
select DISTINCT P.ID,
        PR."Rank" ,P.NAME ,P.ALLIANCE,PR."Points" ,
        PF."Points"  ,PRE."Points" ,
        PR.DATADATE,PR.datasender
from PLAYERS P,rankingpoints  PR
LEFT JOIN rankingflotte PF ON PF.player_id = PR.player_id 
LEFT JOIN rankingresearch PRE ON PRE.player_id =PR.player_id 
where (P.ID=PR.player_id)
/*and PR.DATADATE = (SELECT MAX(DATADATE) FROM rankingpoints  WHERE PLAYER_ID=PR.player_id ))*/
;



/******************************************************************************/
/****                             Primary Keys                             ****/
/******************************************************************************/

ALTER TABLE COMBATS ADD PRIMARY KEY (ID);
ALTER TABLE ALLIANCE ADD PRIMARY KEY (ID);
ALTER TABLE CONFIG ADD PRIMARY KEY (ID);
ALTER TABLE ESPIONAGES ADD PRIMARY KEY (ID);
ALTER TABLE FLEETCOMMANDS ADD CONSTRAINT PK_FLEETCOMMANDS PRIMARY KEY (ID);
ALTER TABLE GALAXY ADD CONSTRAINT PK_GALAXY PRIMARY KEY (ID);
ALTER TABLE PLANETS ADD PRIMARY KEY (ID);
ALTER TABLE PLAYERS ADD PRIMARY KEY (ID);
ALTER TABLE PLAYERSFLOTTE ADD PRIMARY KEY (ID);
ALTER TABLE PLAYERSRANK ADD PRIMARY KEY (ID);
ALTER TABLE PLAYERSRESEARCH ADD PRIMARY KEY (ID);
ALTER TABLE SPYDATA ADD PRIMARY KEY (ID);

/******************************************************************************/
/****                             Foreign Keys                             ****/
/******************************************************************************/

ALTER TABLE COMBATS ADD CONSTRAINT FK_COMBATS_3 FOREIGN KEY (ATTACKER_PLANET) REFERENCES PLANETS (ID);
ALTER TABLE COMBATS ADD CONSTRAINT FK_COMBATS_4 FOREIGN KEY (DEFENDER_PLANET) REFERENCES PLANETS (ID);
ALTER TABLE ESPIONAGES ADD CONSTRAINT FK_ESPIONAGES_1 FOREIGN KEY (PLANET_ID) REFERENCES PLANETS (ID);
ALTER TABLE PLAYERSFLOTTE ADD CONSTRAINT FK_PLAYERSFLOTTE_1 FOREIGN KEY (PLAYER_ID) REFERENCES PLAYERS (ID);
ALTER TABLE PLAYERSRANK ADD CONSTRAINT FK_PLAYERSRANK_1 FOREIGN KEY (PLAYER_ID) REFERENCES PLAYERS (ID);
ALTER TABLE PLAYERSRESEARCH ADD CONSTRAINT FK_PLAYERSRESEARCH_1 FOREIGN KEY (PLAYER_ID) REFERENCES PLAYERS (ID);
ALTER TABLE SPYDATA ADD CONSTRAINT FK_SPYDATA_1 FOREIGN KEY (PLANET_ID) REFERENCES PLANETS (ID);

/******************************************************************************/
/****                               Indices                                ****/
/******************************************************************************/

CREATE UNIQUE INDEX COMBATS_IDX1 ON COMBATS (DATADATE, ATTACKER_PLANET, DEFENDER_PLANET);
CREATE INDEX ESPIONAGES_IDX1 ON ESPIONAGES (PLANET_ID);
CREATE INDEX PLANETS_IDX1 ON PLANETS (GALAXY, SYSTEM, PLANETNUM);
CREATE INDEX PLAYERS_IDX1 ON PLAYERS (NAME, ALLIANCE);


/******************************************************************************/
/****                               Triggers                               ****/
/******************************************************************************/


SET TERM ^ ;


/******************************************************************************/
/****                         Triggers for tables                          ****/
/******************************************************************************/


/* Trigger: ALLIANCE_BI */

CREATE TRIGGER ALLIANCE_BI FOR ALLIANCE
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCE_ID,1);
END


/* Trigger: CONFIG_BI */
CREATE TRIGGER CONFIG_BI FOR CONFIG
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_CONFIG_ID,1);
END
^


/* Trigger: FLEETCOMMANDS_BI */
CREATE TRIGGER FLEETCOMMANDS_BI FOR FLEETCOMMANDS
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_FLEETCOMMANDS_ID,1);
END
^


/* Trigger: GALAXY_BI */
CREATE TRIGGER GALAXY_BI FOR GALAXY
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_GALAXY_ID,1);
END
^


/* Trigger: SPACECONTROLS_BI */
CREATE TRIGGER SPACECONTROLS_BI FOR SPACECONTROLS
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_SPACECONTROLS_ID,1);
END
^


/* Trigger: TRIGGER_COMBATS_ID */
CREATE TRIGGER TRIGGER_COMBATS_ID FOR COMBATS
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("COMBATS_ID",1);
END
^


/* Trigger: TRIGGER_ESPIONAGES_ID */
CREATE TRIGGER TRIGGER_ESPIONAGES_ID FOR ESPIONAGES
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("ESPIONAGES_ID",1);
END
^


/* Trigger: TRIGGER_PLANETS_ID */
CREATE TRIGGER TRIGGER_PLANETS_ID FOR PLANETS
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("PLANETS_ID",1);
END
^


/* Trigger: TRIGGER_PLAYERFLOTTE_ID */
CREATE TRIGGER TRIGGER_PLAYERFLOTTE_ID FOR PLAYERSFLOTTE
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("PLAYERFLOTTE_ID",1);
  
END
^


/* Trigger: TRIGGER_PLAYERRANK_ID */
CREATE TRIGGER TRIGGER_PLAYERRANK_ID FOR PLAYERSRANK
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("PLAYERRANK_ID",1);
END
^


/* Trigger: TRIGGER_PLAYERRESEARCH_ID */
CREATE TRIGGER TRIGGER_PLAYERRESEARCH_ID FOR PLAYERSRESEARCH
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("PLAYERSRESEARCH_ID",1);
  
END
^


/* Trigger: TRIGGER_PLAYER_ID */
CREATE TRIGGER TRIGGER_PLAYER_ID FOR PLAYERS
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID("PLAYER_ID",1);
END
^


/* Trigger: SPYDATA_BI */
CREATE TRIGGER SPYDATA_BI FOR SPYDATA
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_SPYDATA_ID,1);
END
^


SET TERM ; ^


/******************************************************************************/
/****                                Tables                                ****/
/******************************************************************************/


CREATE GENERATOR GEN_ALLIANCERESEARCH_ID;

CREATE TABLE ALLIANCERESEARCH (
    ID          INTEGER NOT NULL,
    ALLIANCEID  INTEGER NOT NULL,
    RANK        INTEGER,
    POINTS      INTEGER,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL
);




/******************************************************************************/
/****                             Primary Keys                             ****/
/******************************************************************************/

ALTER TABLE ALLIANCERESEARCH ADD PRIMARY KEY (ID);


/******************************************************************************/
/****                             Foreign Keys                             ****/
/******************************************************************************/

ALTER TABLE ALLIANCERESEARCH ADD CONSTRAINT FK_ALLIANCERESEARCH_1 FOREIGN KEY (ALLIANCEID) REFERENCES ALLIANCE (ID);


/******************************************************************************/
/****                               Triggers                               ****/
/******************************************************************************/


SET TERM ^ ;


/******************************************************************************/
/****                         Triggers for tables                          ****/
/******************************************************************************/



/* Trigger: ALLIANCERANK_BI */
CREATE TRIGGER ALLIANCERESEARCH_BI FOR ALLIANCERESEARCH
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCERESEARCH_ID,1);
END
^


SET TERM ; ^

/*
 * The contents of this file are subject to the Interbase Public
 * License Version 1.0 (the "License"); you may not use this file
 * except in compliance with the License. You may obtain a copy
 * of the License at http://www.Inprise.com/IPL.html
 *
 * Software distributed under the License is distributed on an
 * "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express
 * or implied. See the License for the specific language governing
 * rights and limitations under the License.
 *
 * The Original Code was created by Inprise Corporation
 * and its predecessors. Portions created by Inprise Corporation are
 * Copyright (C) Inprise Corporation.
 *
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 * $Id: ib_udf.sql,v 1.5 2004/08/30 15:58:17 skidder Exp $
 * Revision 1.2  2000/11/28 06:47:52  fsg
 * Changed declaration of ascii_char in ib_udf.sql
 * to get correct result as proposed by Claudio Valderrama
 * 2001.5.19 Claudio Valderrama, add the declaration of alternative
 * substrlen function to handle string,start,length instead.
 *
 */
/*****************************************
 *
 *	a b s
 *
 *****************************************
 *
 * Functional description:
 * 	Returns the absolute value of a 
 * 	number.  
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION abs 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_abs' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a c o s
 *
 *****************************************
 *
 * Functional description:
 *	Returns the arccosine of a number 
 *	between -1 and 1, if the number is
 *	out of bounds it returns NaN, as handled
 *	by the _matherr routine.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION acos 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_acos' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a s c i i _ c h a r
 *
 *****************************************
 *
 * Functional description:
 *	Returns the ASCII character corresponding
 *	with the value passed in.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION ascii_char
	INTEGER
	RETURNS CSTRING(1) FREE_IT
	ENTRY_POINT 'IB_UDF_ascii_char' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a s c i i _ v a l
 *
 *****************************************
 *
 * Functional description:
 *	Returns the ascii value of the character
 * 	passed in.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION ascii_val
	CHAR(1)
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_ascii_val' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a s i n
 *
 *****************************************
 *
 * Functional description:
 *	Returns the arcsin of a number between
 *	-1 and 1, if the number is out of
 *	range NaN is returned.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION asin 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_asin' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a t a n
 *
 *****************************************
 *
 * Functional description:
 *	Returns the arctangent of a number.
 *	
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION atan 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_atan' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	a t a n 2
 *
 *****************************************
 *
 * Functional description:
 * 	Returns the arctangent of the
 *	first param / the second param.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION atan2 
	DOUBLE PRECISION, DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_atan2' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	b i n _ a n d
 *
 *****************************************
 *
 * Functional description:
 *	Returns the result of a binary AND 
 *	operation performed on the two numbers.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION bin_and 
	INTEGER, INTEGER
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_bin_and' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	b i n _ o r
 *
 *****************************************
 *
 * Functional description:
 *	Returns the result of a binary OR 
 *	operation performed on the two numbers.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION bin_or 
	INTEGER, INTEGER
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_bin_or' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	b i n _ x o r
 *
 *****************************************
 *
 * Functional description:
 *	Returns the result of a binary XOR 
 *	operation performed on the two numbers.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION bin_xor 
	INTEGER, INTEGER
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_bin_xor' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	c e i l i n g
 *
 *****************************************
 *
 * Functional description:
 *	Returns a double value representing 
 *	the smallest integer that is greater 
 *	than or equal to the input value.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION ceiling 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_ceiling' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	c o s
 *
 *****************************************
 *
 * Functional description:
 *	The cos function returns the cosine 
 *	of x. If x is greater than or equal 
 *	to 263, or less than or equal to -263, 
 *	a loss of significance in the result 
 *	of a call to cos occurs, in which case 
 *	the function generates a _TLOSS error 
 *	and returns an indefinite (same as a 
 *	quiet NaN).
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION cos 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_cos' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	c o s h
 *
 *****************************************
 *
 * Functional description:
 *	The cosh function returns the hyperbolic cosine 
 *	of x. If x is greater than or equal 
 *	to 263, or less than or equal to -263, 
 *	a loss of significance in the result 
 *	of a call to cos occurs, in which case 
 *	the function generates a _TLOSS error 
 *	and returns an indefinite (same as a 
 *	quiet NaN).
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION cosh 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_cosh' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	c o t
 *
 *****************************************
 *
 * Functional description:
 *	Returns 1 over the tangent of the
 *	input parameter.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION cot 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_cot' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	d i v
 *
 *****************************************
 *
 * Functional description:
 *	Returns the quotient part of the division
 *	of the two input parameters.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION div 
	INTEGER, INTEGER
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_div' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	f l o o r
 *
 *****************************************
 *
 * Functional description:
 * 	Returns a floating-point value 
 * 	representing the largest integer that 
 *	is less than or equal to x	
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION floor 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_floor' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l n
 *
 *****************************************
 *
 * Functional description:
 *	Returns the natural log of a number.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION ln 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_ln' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l o g
 *
 *****************************************
 *
 * Functional description:
 *	log (x,y) returns the logarithm 
 *	base x of y.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION log 
	DOUBLE PRECISION, DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_log' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l o g 1 0
 *
 *****************************************
 *
 * Functional description:
 *	Returns the logarithm base 10 of the
 *	input parameter.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION log10 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_log10' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l o w e r
 *
 *****************************************
 *
 * Functional description:
 *	Returns the input string into lower 
 *	case characters.  Note: This function
 *	will not work with international and 
 *	non-ascii characters.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION lower 
	CSTRING(255)
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_lower' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l p a d
 *
 *****************************************
 *
 * Functional description:
 *	Appends the given character to beginning
 *	of the input string until length of the result
 *	string becomes equal to the given number.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION lpad 
	CSTRING(255), INTEGER, CSTRING(1)
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_lpad' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	l t r i m
 *
 *****************************************
 *
 * Functional description:
 *	Removes leading spaces from the input
 *	string.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION ltrim 
	CSTRING(255)
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_ltrim' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	m o d
 *
 *****************************************
 *
 * Functional description:
 *	Returns the remainder part of the 
 *	division of the two input parameters.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION mod 
	INTEGER, INTEGER
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_mod' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	p i
 *
 *****************************************
 *
 * Functional description:
 *	Returns the value of pi = 3.1459...
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION pi 
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_pi' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	r a n d
 *
 *****************************************
 *
 * Functional description:
 *	Returns a random number between 0 
 *	and 1.  Note the random number
 *	generator is seeded using the current 
 *	time.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION rand 
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_rand' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	r p a d
 *
 *****************************************
 *
 * Functional description:
 *	Appends the given character to end
 *	of the input string until length of the result
 *	string becomes equal to the given number.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION rpad 
	CSTRING(255), INTEGER, CSTRING(1)
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_rpad' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	r t r i m
 *
 *****************************************
 *
 * Functional description:
 *	Removes trailing spaces from the input
 *	string.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION rtrim 
	CSTRING(255)
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_rtrim' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s i g n
 *
 *****************************************
 *
 * Functional description:
 *	Returns 1, 0, or -1 depending on whether
 * 	the input value is positive, zero or 
 *	negative, respectively.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION sign 
	DOUBLE PRECISION
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_sign' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s i n
 *
 *****************************************
 *
 * Functional description:
 *	Returns the sine of x. If x is greater 
 *	than or equal to 263, or less than or 
 *	equal to -263, a loss of significance 
 *	in the result occurs, in which case the 
 *	function generates a _TLOSS error and 
 *	returns an indefinite (same as a quiet NaN).
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION sin 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_sin' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s i n h
 *
 *****************************************
 *
 * Functional description:
 *	Returns the hyperbolic sine of x. If x is greater 
 *	than or equal to 263, or less than or 
 *	equal to -263, a loss of significance 
 *	in the result occurs, in which case the 
 *	function generates a _TLOSS error and 
 *	returns an indefinite (same as a quiet NaN).
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION sinh 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_sinh' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s q r t
 *
 *****************************************
 *
 * Functional description:
 *	Returns the square root of a number.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION sqrt 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_sqrt' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s u b s t r
 *
 *****************************************
 *
 * Functional description:
 *	substr(s,m,n) returns the substring 
 *	of s which starts at position m and
 *	ending at position n.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *      Change by Claudio Valderrama: when n>length(s),
 *      the result will be the original string instead
 *      of NULL as it was originally designed.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION substr 
	CSTRING(255), SMALLINT, SMALLINT
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_substr' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s u b s t r l e n
 *
 *****************************************
 *
 * Functional description:
 *	substr(s,i,l) returns the substring 
 *	of s which starts at position i and
 *	ends at position i+l-1, being l the length.
 *	Note: This function is NOT limited to
 *	receiving and returning only 255 characters,
 *	rather, it can use as long as 32767 
 * 	characters which is the limit on an 
 *	INTERBASE character string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION substrlen 
	CSTRING(255), SMALLINT, SMALLINT
	RETURNS CSTRING(255) FREE_IT
	ENTRY_POINT 'IB_UDF_substrlen' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	s t r l e n
 *
 *****************************************
 *
 * Functional description:
 *	Returns the length of a given string.
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION strlen 
	CSTRING(32767)
	RETURNS INTEGER BY VALUE
	ENTRY_POINT 'IB_UDF_strlen' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	t a n
 *
 *****************************************
 *
 * Functional description:
 * 	Returns the tangent of x. If x is 
 *	greater than or equal to 263, or less 
 *	than or equal to -263, a loss of 
 *	significance in the result occurs, in 
 *	which case the function generates a 
 *	_TLOSS error and returns an indefinite 
 *	(same as a quiet NaN).
 *
 *****************************************/
DECLARE EXTERNAL FUNCTION tan 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_tan' MODULE_NAME 'ib_udf';

/*****************************************
 *
 *	t a n h
 *
 *****************************************
 *
 * Functional description:
 * 	Returns the tangent of x. If x is 
 *	greater than or equal to 263, or less 
 *	than or equal to -263, a loss of 
 *	significance in the result occurs, in 
 *	which case the function generates a 
 *	_TLOSS error and returns an indefinite 
 *	(same as a quiet NaN).
 *	
 *****************************************/
DECLARE EXTERNAL FUNCTION tanh 
	DOUBLE PRECISION
	RETURNS DOUBLE PRECISION BY VALUE
	ENTRY_POINT 'IB_UDF_tanh' MODULE_NAME 'ib_udf';

