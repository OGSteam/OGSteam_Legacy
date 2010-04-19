
/******************************************************************************/
/****                                Tables                                ****/
/******************************************************************************/


CREATE GENERATOR GEN_SPYDATA_ID;

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
    TRAQUEUR         INTEGER,
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
/****                             Primary Keys                             ****/
/******************************************************************************/

ALTER TABLE SPYDATA ADD PRIMARY KEY (ID);


/******************************************************************************/
/****                             Foreign Keys                             ****/
/******************************************************************************/

ALTER TABLE SPYDATA ADD CONSTRAINT FK_SPYDATA_1 FOREIGN KEY (PLANET_ID) REFERENCES PLANETS (ID);


/******************************************************************************/
/****                               Triggers                               ****/
/******************************************************************************/


SET TERM ^ ;


/******************************************************************************/
/****                         Triggers for tables                          ****/
/******************************************************************************/



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
/****                              Privileges                              ****/
/******************************************************************************/
