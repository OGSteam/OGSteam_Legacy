<?PHP
/**************************************************************************
           SOGSROV : StalkR's OGame Spy Report Organizer/Viewer            
           ----------------------------------------------------

File name ............... sogsrov_lang_en.php
Version ................. 1.0
Created on .............. 02/07/2006
Last modification ....... 02/07/2005
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

english language file contributed by : StalkR


Example of a english spy report (submitted by CK|Cadaz)

Resources on Elphos [3:259:15] at 07-02 13:01:13
Metal:	100790 	Crystal:	34481
Deuterium:	8618 	Energy:	2201
Fleets
Defense
Buildings
Metal Mine	18	Crystal Mine	15
Deuterium Synthesizer	10	Solar Plant	18
Fusion Reactor	3	Robotics Factory	4
Shipyard	4	Metal Storage	1
Research
Espionage Technology	7	Computer Technology	7
Weapons Technology	7	Shielding Technology	7
Armour Technology	7	Energy Technology	6
Hyperspace Technology	3	Combustion Drive	6
Impulse Drive	4	Hyperspace Drive	4
Laser Technology	8	Ion Technology	5
Chance of counter-espionage:0%

*/

// normally you should not have to change this, except if ogame.org changes its sentences,
// or if you want to use this script on an ogame in a different language
$lang['parse.resources'] = 'Resources on ';
$lang['parse.at'] = "at";
$lang['parse.metal'] = 'Metal:';
$lang['parse.crystal'] = 'Crystal:';
$lang['parse.deuterium'] = 'Deuterium:';
$lang['parse.energy'] = 'Energy:';
$lang['parse.fleet'] = 'Fleets';
$lang['parse.defense'] = 'Defense';
$lang['parse.buildings'] = 'Buildings';
$lang['parse.research'] = 'Research';
$lang['parse.chance'] = 'Chance of counter-espionage:';
$lang['parse.notes'] = 'Notes';
$lang['parse.priority'] = 'Priority';
$lang['parse.moon'] = 'moon';

// interface language
$lang['refresh page'] = "refresh";
$lang['Spy reports'] = "Spy reports";
$lang['Show reports of'] = "Show reports of";
$lang['all galaxies'] = "all galaxies";
$lang['the galaxy x only'] = "galaxie %s only";
$lang['paste here your spy reports'] = "Paste here your spy reports...";
$lang['Send'] = "Send";
$lang['send spy reports.explain'] = "Adds the spy reports contained in your text";

$lang['Import OGSpy reports'] = "Import OGSpy reports";
$lang['Import all'] = "import all";
$lang['only'] = "only";
$lang['from galaxy'] = "from galaxy";
$lang['to'] = "to";
$lang['from system'] = "from system";
$lang['of max'] = "of max";
$lang['hours old'] = "hours old";
$lang['Import from OGSpy'] = "Import from OGSpy";
$lang['OGSpy cannot import.explain'] = "To be able to import the OGSpy spy reports, you must give in the SOGSROV configuration the informations to connect to the database of your OGSpy server.";

$lang['Display preferences'] = "Display preferences";
$lang['Skin URL'] = "Skin URL";
$lang['OGame Language'] = "OGame language";
$lang['Control menu'] = "Control menu";
$lang['left'] = "left";
$lang['right'] = "right";
$lang['Reports per page'] = "Reports per page";
$lang['(0 for all)'] = "(0 for all)";
$lang['Default color'] = "Default color";
$lang['Critical limit color'] = "Critical limit color";
$lang['Moon color'] = "Moon color";
$lang['Can be empty for no color'] = "For this, you can leave empty to use no color";
$lang['Low priority color'] = "Low priority color";
$lang['Normal priority color'] = "Normal priority color";
$lang['High priority color'] = "High priority color";
$lang['Metal limit'] = "Metal limit";
$lang['Crystal limit'] = "Crystal limit";
$lang['Deuterium limit'] = "Deuterium limit";
$lang['Energy limit'] = "Energy limit";
$lang['Fleet limit'] = "Fleet limit";
$lang['Defense limit'] = "Defense limit";
$lang['Buildings limit'] = "Buildings limit";
$lang['Research limit'] = "Research limit";
$lang['Order by'] = "Order by";
$lang['quantity of metal'] = "quantity of metal";
$lang['quantity of crystal'] = "quantity of crystal";
$lang['quantity of deuterium'] = "quantity of deuterium";
$lang['total quantity of resources'] = "total quantity of resources";
$lang['position of the planet/moon'] = "position of the planet/moon";
$lang['report priority'] = "report priority";
$lang['use these values instead of default ones'] = "use these values instead of default ones";
$lang['Default values'] = "Default values";
$lang['Save'] = "Save";

$lang['Credits'] = "Credits";
$lang['version x by y'] = "version %s by %s";
$lang['for more info it\'s on the official forum'] = "For download, questions, ideas<br>and suggestions, it's on the <a href='http://stalkr.net/forum/viewtopic.php?t=2327' target='_blank'>official forum</a>";


$lang['Delete selected'] = "Delete selected";
$lang['Delete unselected'] = "Delete unselected";
$lang['Delete displayed'] = "Delete displayed";
$lang['Delete all'] = "Delete all";
$lang['submit delete messages'] = "ok";
$lang['Order by2'] = "Order by: ";
$lang['Order by metal'] = "M";
$lang['Order by metal.explain'] = "Orders by planets/moons that have the more metal";
$lang['Order by crystal'] = "C";
$lang['Order by crystal.explain'] = "Orders by planets/moons that have the more crystal";
$lang['Order by deuterium'] = "D";
$lang['Order by deuterium.explain'] = "Orders by planets/moons that have the more deuterium";
$lang['Order by total'] = "total";
$lang['Order by total.explain'] = "Orders by planets/moons that have the more total resources (metal+crystal+deuterium)";
$lang['Order by position'] = "position";
$lang['Order by position.explain'] = "Orders by the position of the planet/moon";
$lang['Order by priority'] = "priority";
$lang['Order by priority.explain'] = "Orders by the priority of the report";

$lang['x for the galaxy y'] = "%s for galaxy %s";
$lang['total reports: x'] = "%s total";
$lang['previous page'] = "&lt;- Prev";
$lang['previous page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
$lang['next page'] = "Next -&gt;";
$lang['next page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";

$lang['Action'] = "Action";
$lang['Date'] = "Date";
$lang['Player'] = "Player";

$lang['OGSpy.information not available.explain'] = "Information unavailable on the OGSpy server: update regularily the galaxy to solve this.";
$lang['OGSpy.no server installed.explain'] = "To have this information, give an OGSpy server to connect to in the script configuration.";
$lang['low'] = "low";
$lang['normal'] = "normal";
$lang['high'] = "high";
$lang['total resources'] = "Total resources:";
$lang['Save note'] = "Save";
$lang['Save note.explain'] = "Will only save this note";
$lang['Empty note'] = "Empty";

$lang['PHP execution time: x sec'] = "PHP execution time: <b>%s sec</b>";

//EOF
?>