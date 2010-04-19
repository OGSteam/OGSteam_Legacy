CREATE TABLE T_EXTERNAL EXTERNAL FILE '{FILE}' (
    GAL           CHAR(1),
    SYS           CHAR(3),
    NUM           CHAR(3),
    MOON          CHAR(1),
    NAME          CHAR(25),
    OWNERNAME     CHAR(50),
    OWNERALLYTAG  CHAR(20),
	SHORTINACTIVE CHAR(1),
	LONGINACTIVE  CHAR(1),
	BLOCKED		  CHAR(1),
	VACANCY		  CHAR(1),
	NOOB		  CHAR(1),
    DATADATE      CHAR(19),
    DATASENDER    CHAR(30),
    RT            CHAR(2)
);
