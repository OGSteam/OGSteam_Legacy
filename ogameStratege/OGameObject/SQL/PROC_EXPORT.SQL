SET TERM ^ ;

CREATE PROCEDURE EXPORT_TRANSFERT (sincedate timestamp,gal_required integer)
RETURNS (
    dataline varchar(255),
    GAL INTEGER,
    SYS INTEGER,
	NUM INTEGER,
	MOON VARCHAR(20),
    PLANETNAME VARCHAR(30),
    PLAYERNAME VARCHAR(30),
    ALLYTAG VARCHAR(30),
    DATADATE TIMESTAMP,
    DATASENDER VARCHAR(30),
	STATUS VARCHAR(5)
    )
AS
DECLARE VARIABLE SHORTINACTIVE SMALLINT;
DECLARE VARIABLE LONGINACTIVE SMALLINT;
DECLARE VARIABLE BLOCKED SMALLINT;
DECLARE VARIABLE VACANCY SMALLINT;
DECLARE VARIABLE NOOB SMALLINT;
begin
    FOR SELECT planet.system,planet.planetnum,planet.moon,planet.name,
			   planet.datadate,planet.datasender,
			   player.name,player.alliance,
			   player.shortinactive, player.longinactive,player.blocked,
			   player.noob,player.vacancy
		from planets planet
		left join players player on player.id=planet.playerid
		where planet.datadate>=:sincedate and planet.galaxy=:gal_required
        INTO :SYS,:NUM,:MOON,:PLANETNAME,:DATADATE,:DATASENDER,
             :PLAYERNAME,:ALLYTAG,
             :SHORTINACTIVE,:LONGINACTIVE,:BLOCKED,:NOOB,:VACANCY
    DO BEGIN
        gal=gal_required;
        moon=rtrim(moon);
        if (moon='M') then moon=1;
        STATUS='';
        if (shortinactive=1) then status=status || 'i';
        if (longinactive=1) then status=status || 'I';
        if (blocked=1) then status=status || 'b';
        if (vacancy=1) then status=status || 'v';
        if (noob=1) then status=status || 'd';
        
        
        dataline= gal || '<||>' ||
			sys || '<||>' ||
			num || '<||>' ||
			coalesce(moon,'') || '<||>' ||
			coalesce(planetname,'') || '<||>' ||
			coalesce(playername,'') || '<||>' ||
			coalesce(allytag,'') || '<||>' ||
			coalesce(status,'') || '<||>' ||
			substr(datadate,1,19) || '<||>' ||
			datasender;
		suspend;	
    END
END^

SET TERM ; ^


GRANT SELECT ON PLANETS TO PROCEDURE EXPORT_TRANSFERT;

GRANT SELECT ON PLAYERS TO PROCEDURE EXPORT_TRANSFERT;

GRANT EXECUTE ON PROCEDURE EXPORT_TRANSFERT TO SYSDBA;