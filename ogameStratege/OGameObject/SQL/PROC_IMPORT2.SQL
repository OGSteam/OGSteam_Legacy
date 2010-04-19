SET TERM ^ ;

CREATE PROCEDURE IMPORT_TRANSFERT 
RETURNS (
    PLAYERADDED INTEGER,
    PLANETADDED INTEGER,
    PLAYERUPDATED INTEGER,
    PLANETUPDATED INTEGER,
    PLANETNAME CHAR(25),
    PLAYERNAME CHAR(50),
    ALLIANCETAG CHAR(20),
    GALAXY INTEGER,
    SYSTEM INTEGER,
    NUMPLANET INTEGER)
AS
DECLARE VARIABLE GAL INTEGER;
DECLARE VARIABLE SYS INTEGER;
DECLARE VARIABLE NUM INTEGER;
DECLARE VARIABLE MOON CHAR(1);
DECLARE VARIABLE NAME CHAR(25);
DECLARE VARIABLE OWNERNAME CHAR(50);
DECLARE VARIABLE OWNERALLYTAG CHAR(20);
DECLARE VARIABLE STATUS CHAR(5);
DECLARE VARIABLE DATADATE CHAR(19);
DECLARE VARIABLE DATASENDER CHAR(30);
DECLARE VARIABLE PLANETID INTEGER;
DECLARE VARIABLE PLAYERID INTEGER;
DECLARE VARIABLE PREVDATADATE TIMESTAMP;
DECLARE VARIABLE SHORTINACTIVE CHAR(1);
DECLARE VARIABLE LONGINACTIVE CHAR(1);
DECLARE VARIABLE BLOCKED CHAR(1);
DECLARE VARIABLE VACANCY CHAR(1);
DECLARE VARIABLE NOOB CHAR(1);
begin
    FOR SELECT gal,sys,num,moon,name,ownername,ownerallytag,SHORTINACTIVE,LONGINACTIVE,BLOCKED,VACANCY,NOOB,datadate,datasender
        FROM T_EXTERNAL
        INTO :GAL,:SYS,:NUM,:MOON,:NAME,:OWNERNAME,:OWNERALLYTAG,:SHORTINACTIVE,:LONGINACTIVE,:BLOCKED,:VACANCY,:NOOB,:DATADATE,:DATASENDER
    DO BEGIN
        PLAYERID=null;
        PLANETID=null;
        playeradded='0' ;
        planetadded='0' ;
        playerupdated='0';
        planetupdated='0';
        playername=:ownername;
        alliancetag=:ownerallytag;
        planetname=:name;
        
        galaxy=cast(:gal as integer);
        system=cast(:sys as integer);
        numplanet=cast(:num as integer);

        
        SELECT ID,DATADATE FROM PLANETS WHERE GALAXY=:GAL AND SYSTEM=:SYS AND PLANETNUM=:NUM
                INTO :PLANETID,:PREVDATADATE;
        
        if (:prevdatadate >:datadate ) then
        begin
            suspend;
        end
        
        if (rtrim(:ownername)!='') then
        BEGIN
        
            SELECT FIRST 1 ID FROM PLAYERS WHERE NAME=:OWNERNAME
                INTO :PLAYERID;
			
			IF (:PLAYERID IS NULL) THEN
			BEGIN
					PLAYERID=GEN_ID(PLAYER_ID,1);
					INSERT INTO PLAYERS (ID,NAME,ALLIANCE,DATASENDER,DATADATE,MAINPLANETCOORDS,SHORTINACTIVE,LONGINACTIVE,BLOCKED,VACANCY,NOOB)
                        VALUES (:PLAYERID,rtrim(:OWNERNAME),rtrim(:OWNERALLYTAG),:DATASENDER,:DATADATE,'',:SHORTINACTIVE,:LONGINACTIVE,:BLOCKED,:VACANCY,:NOOB);

					playeradded='1';
        
			END ELSE BEGIN
					UPDATE  PLAYERS SET ALLIANCE=rtrim(:OWNERALLYTAG),SHORTINACTIVE=:SHORTINACTIVE,LONGINACTIVE=:LONGINACTIVE,BLOCKED=:BLOCKED,VACANCY=:VACANCY,NOOB=:NOOB
						WHERE (ID=:PLAYERID);
					playerupdated='1';
			END
			
        END
        else
        BEGIN
            PLAYERID=0;
        END
        
        if (planetid is null) then
        begin
            

            planetid=GEN_ID("PLANETS_ID",1);
            if (:moon='1') then
            begin
				moon='M';
            end else
            begin
                moon='';
            end
            insert into planets (ID,MOON,NAME,GALAXY,SYSTEM,PLANETNUM,PLAYERID,FIELDS,DATASENDER,DATADATE)
                VALUES (:planetid,:moon, rtrim(:name), :gal,:sys,:num, :playerid,'',:DATASENDER,:DATADATE);
            planetadded='1'   ;
        end else

        begin
                 planetupdated='1';
                 UPDATE planets set NAME=rtrim(:name),
                                    PLAYERID=:playerid,
                                    MOON=:MOON ,
                                    DATASENDER=:DATASENDER,
                                    DATADATE=:datadate
                                WHERE (ID=:PLANETID);

        end
         suspend;

    END
END^

SET TERM ; ^

GRANT SELECT ON T_EXTERNAL TO PROCEDURE IMPORT_TRANSFERT;

GRANT SELECT,INSERT,UPDATE ON PLANETS TO PROCEDURE IMPORT_TRANSFERT;

GRANT SELECT,INSERT,UPDATE ON PLAYERS TO PROCEDURE IMPORT_TRANSFERT;

GRANT EXECUTE ON PROCEDURE IMPORT_TRANSFERT TO SYSDBA;