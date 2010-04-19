<?PHP
/**************************************************************************
           SOGSROV : StalkR's OGame Spy Report Organizer/Viewer            
           ----------------------------------------------------

File name ............... sogsrov_lang_nl.php
Version ................. 1.0
Created on .............. 20/07/2006
Last modification ....... 20/07/2005
Author .................. StalkR
Email ................... stalkr@stalkr.net
Web ..................... http://stalkr.net
License ................. GNU/GPL

***************************************************************************

"SOGSROV : StalkR's OGame Spy Report Organizer/Viewer" is free software; you can
redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation; either version 2 of
the License, or (at your option) any later version.

"SOGSROV : StalkR's OGame Spy Report Organizer/Viewer" is distributed in the hope that
it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with "SOGSROV : StalkR's OGame Spy Report Organizer/Viewer"; if not, write to the
Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
Boston, MA  02110-1301  USA

***************************************************************************

dutch language file contributed by : Lymfo


Example of a dutch spy report

Grondstoffen op PSV PLANET [2:112:7] op 07-20 11:44:30
Metaal:	62798 	Kristal:	35184
Deuterium:	16000 	Energie:	573
Vloten
Verdediging
Kleine laser	1	Grote laser	5
Ion kanon	2	Anti-ballistische raket	13
Gebouwen
Metaal Mijn	10	Kristal Mijn	9
Deuterium fabriek	7	Zonne-energie centrale	10
Fusie centrale	1	Robot fabriek	2
Werf	4	Metaal opslag	1
Onderzoeks lab	6	Alliantie hangar	1
Raket silo	2
Onderzoek
Spionage techniek	2	Computer techniek	3
Schild techniek	2	Pantser techniek	2
Energie techniek	4	Verbrandings motor	3
Impuls motor	2	Laser techniek	6
Ion techniek	4
Kans op contraspionage:0%

*/

// normally you should not have to change this, except if ogame.org changes its sentences,
// or if you want to use this script on an ogame in a different language
$lang['parse.resources'] = 'Grondstoffen op ';
$lang['parse.at'] = "op";
$lang['parse.metal'] = 'Metaal:';
$lang['parse.crystal'] = 'Kristal:';
$lang['parse.deuterium'] = 'Deuterium:';
$lang['parse.energy'] = 'Energie:';
$lang['parse.fleet'] = 'Vloten';
$lang['parse.defense'] = 'Verdediging';
$lang['parse.buildings'] = 'Gebouwen';
$lang['parse.research'] = 'Onderzoek';
$lang['parse.chance'] = 'Kans op contraspionage:';
$lang['parse.notes'] = 'Notities';
$lang['parse.priority'] = 'Prioriteit';
$lang['parse.moon'] = 'Maan';

// interface language
$lang['refresh page'] = "herlaad";
$lang['Spy reports'] = "Spio rapporten";
$lang['Show reports of'] = "Toon spionage rapporten van";
$lang['all galaxies'] = "Melkwegen";
$lang['the galaxy x only'] = "enkel melkweg %s ";
$lang['paste here your spy reports'] = "Zet hier je spio rapporten";
$lang['Send'] = "Verzenden";
$lang['send spy reports.explain'] = "Voegt de spio rapporten in je tekst";

$lang['Import OGSpy reports'] = "Importeer OGSpy reporten";
$lang['Import all'] = "importeer alles";
$lang['only'] = "alleen";
$lang['from galaxy'] = "van melkweg";
$lang['to'] = "naar";
$lang['from system'] = "van system";
$lang['of max'] = "van max";
$lang['hours old'] = "uren oud";
$lang['Import from OGSpy'] = "Importeer van OGSpy";
$lang['OGSpy cannot import.explain'] = "Om OGSpy spionage rapporten toe te voegen, moet je de configuartie informatie geven in de database van jouw OGSpy server.";

$lang['Display preferences'] = "Grafische voorkeur";
$lang['Skin URL'] = "Skin URL";
$lang['OGame Language'] = "OGame taal";
$lang['Control menu'] = "Control menu";
$lang['left'] = "links";
$lang['right'] = "rechts";
$lang['Reports per page'] = "Reports van pagina";
$lang['(0 for all)'] = "(0 voor alles)";
$lang['Default color'] = "Default kleur";
$lang['Critical limit color'] = "Kritiek limiet kleur";
$lang['Moon color'] = "Maann kleur";
$lang['Can be empty for no color'] = "Je kan het leeg laten voor geen kleur";
$lang['Low priority color'] = "Lage prioriteitskleur";
$lang['Normal priority color'] = "Normale prioriteitskleur";
$lang['High priority color'] = "Hoge prioriteitskleur";
$lang['Metal limit'] = "Metaal limiet";
$lang['Crystal limit'] = "Kristal limiet";
$lang['Deuterium limit'] = "Deuterium limiet";
$lang['Energy limit'] = "Energie limiet";
$lang['Fleet limit'] = "Vloot limiet";
$lang['Defense limit'] = "Verdediging limiet";
$lang['Buildings limit'] = "Gebouwen limit";
$lang['Research limit'] = "Onderzoek limiet";
$lang['Order by'] = "Sorteer volgens";
$lang['quantity of metal'] = "hoeveelheid metaal";
$lang['quantity of crystal'] = "hoeveelheid kristal";
$lang['quantity of deuterium'] = "hoeveelheid deuterium";
$lang['total quantity of resources'] = "totale hoeveelheid grondstoffen";
$lang['position of the planet/moon'] = "plaats van planet/moon";
$lang['report priority'] = "Rapport prioriteit";
$lang['use these values instead of default ones'] = "Gebruik deze waarden ipv. de standaardwaarden";
$lang['Default values'] = "Standaard waarden";
$lang['Save'] = "Opslaan";

$lang['Credits'] = "Credits";
$lang['version x by y'] = "versie %s door %s";
$lang['for more info it\'s on the official forum'] = "Voor downloads, vragen, ideeën<br>en suggesties, ga naar <a href='http://stalkr.net/forum/viewtopic.php?t=2327' target='_blank'>officiele forum</a>";


$lang['Delete selected'] = "Verwijder gemarkeerde berichten";
$lang['Delete unselected'] = "Verwijder ongemarkeerde berichten";
$lang['Delete displayed'] = "Verwijder alle zichtbare berichten";
$lang['Delete all'] = "Verwijder alles";
$lang['submit delete messages'] = "ok";
$lang['Order by2'] = "Sorteer volgens: ";
$lang['Order by metal'] = "M";
$lang['Order by metal.explain'] = "Sorteer volgens planeten/manen die meer metaal hebben";
$lang['Order by crystal'] = "C";
$lang['Order by crystal.explain'] = "Sorteer volgens planeten/manen die meer kristal hebben";
$lang['Order by deuterium'] = "D";
$lang['Order by deuterium.explain'] = "Sorteer volgens planeten/manen die meer deuterium hebben";
$lang['Order by total'] = "total";
$lang['Order by total.explain'] = "Sorteer volgens planeten/manen die het meest grondstoffen hebben (metaal + kristal + deuterium)";
$lang['Order by position'] = "Positie";
$lang['Order by position.explain'] = "Sorteer volgens planeten/manen posities";
$lang['Order by priority'] = "Prioriteit";
$lang['Order by priority.explain'] = "Sorteer volgens prioriteit van het rapport";

$lang['x for the galaxy y'] = "%s for galaxy %s";
$lang['total reports: x'] = "%s totaal";
$lang['previous page'] = "&lt;- Vorige";
$lang['previous page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
$lang['next page'] = "Volgende -&gt;";
$lang['next page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";

$lang['Action'] = "Actie";
$lang['Date'] = "Datum";
$lang['Player'] = "Speler";

$lang['OGSpy.information not available.explain'] = "De informatie is onbeschikbaar op de OGSpy server: update regelatig de melkweg om dit op te lossen.";
$lang['OGSpy.no server installed.explain'] = "Om deze informatie te hebben, geef een OGSpy server op in de script configuratie.";
$lang['low'] = "laag";
$lang['normal'] = "normaal";
$lang['high'] = "hoog";
$lang['total resources'] = "Totaal grondstoffen:";
$lang['Save note'] = "Opslaan";
$lang['Save note.explain'] = "Slaat alleen deze notitie op.";
$lang['Empty note'] = "Leeg";

$lang['PHP execution time: x sec'] = "PHP executie tijd: <b>%s sec</b>";

//EOF
?>