ALTER TABLE PLAYERS ADD NOOB SMALLINT DEFAULT 0 ;
ALTER TABLE PLAYERS ADD VACANCY SMALLINT DEFAULT 0 ;

CREATE TABLE ALLIANCE (
    ID INTEGER NOT NULL,
    NAME VARCHAR(40),
    ALLIANCEPAGE VARCHAR(250),
    ALLIANCEBOARD VARCHAR(250),
    DATASENDER VARCHAR(30),
    DATADATE TIMESTAMP NOT NULL
);

CREATE GENERATOR GEN_ALLIANCE_ID;
ALTER TABLE ALLIANCE ADD PRIMARY KEY (ID);

SET TERM ^ ;

CREATE TRIGGER ALLIANCE_BI FOR ALLIANCE
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCE_ID,1);
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

CREATE GENERATOR GEN_ALLIANCERANK_ID;

CREATE TABLE ALLIANCERANK (
    ID          INTEGER NOT NULL,
    ALLIANCEID  INTEGER NOT NULL,
    RANK        INTEGER,
    POINTS      INTEGER,
    DATASENDER  VARCHAR(30),
    DATADATE    TIMESTAMP NOT NULL
);

CREATE GENERATOR GEN_ALLIANCEFLOTTE_ID;

CREATE TABLE ALLIANCEFLOTTE (
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
ALTER TABLE ALLIANCERANK ADD PRIMARY KEY (ID);
ALTER TABLE ALLIANCEFLOTTE ADD PRIMARY KEY (ID);
ALTER TABLE ALLIANCERESEARCH ADD PRIMARY KEY (ID);


/******************************************************************************/
/****                             Foreign Keys                             ****/
/******************************************************************************/
ALTER TABLE ALLIANCERANK ADD CONSTRAINT FK_ALLIANCERANK_1 FOREIGN KEY (ALLIANCEID) REFERENCES ALLIANCE (ID);
ALTER TABLE ALLIANCEFLOTTE ADD CONSTRAINT FK_ALLIANCEFLOTTE_1 FOREIGN KEY (ALLIANCEID) REFERENCES ALLIANCE (ID);
ALTER TABLE ALLIANCERESEARCH ADD CONSTRAINT FK_ALLIANCERESEARCH_1 FOREIGN KEY (ALLIANCEID) REFERENCES ALLIANCE (ID);


/******************************************************************************/
/****                               Triggers                               ****/
/******************************************************************************/


SET TERM ^ ;


/******************************************************************************/
/****                         Triggers for tables                          ****/
/******************************************************************************/



/* Trigger: ALLIANCERESEARCH_BI */
CREATE TRIGGER ALLIANCERESEARCH_BI FOR ALLIANCERESEARCH
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCERESEARCH_ID,1);
END
^

/* Trigger: ALLIANCERANK_BI */
CREATE TRIGGER ALLIANCERANK_BI FOR ALLIANCERANK
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCERANK_ID,1);
END
^

/* Trigger: ALLIANCEFLOTTE_BI */
CREATE TRIGGER ALLIANCEFLOTTE_BI FOR ALLIANCEFLOTTE
ACTIVE BEFORE INSERT POSITION 0
AS
BEGIN
  IF (NEW.ID IS NULL) THEN
    NEW.ID = GEN_ID(GEN_ALLIANCEFLOTTE_ID,1);
END
^



SET TERM ; ^



/******************************************************************************/
/****                              Privileges                              ****/
/******************************************************************************/
