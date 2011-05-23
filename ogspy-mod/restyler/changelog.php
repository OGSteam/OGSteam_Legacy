<?php
/**
* changelog.php affichage du changelog de modREstyler
* @package modREstyler
* @author oXid_FoX
* @link http://www.ogsteam.fr
*
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');
?>

<center>
  <h2 title="Mise en forme des rapports d'espionnage">REstyler - changelog</h2>
  <h3>Mise en forme des rapports d'espionnage.</h3>
  <h5>by <a href="http://restyler-ogame.ovh.org/contact/" title="contactez-moi">oXid_FoX</a></h5>
</center>
<p>&nbsp;</p>
<p><a href="index.php?action=modREstyler">&larr; Retour &agrave; REstyler</a></p>
<div style="width: 100%; clear: both;">
  <fieldset title="Changelog"><legend><b> Changelog </b></legend><br>
    <div style="font-family:Courier;">
    <?php
    $read_first = 0;  // on lit tout
    include DOSSIER_INCLUDE.'/readchangelog.php';
    ?>

    </div>
  </fieldset>
</div>
<?php
require_once DOSSIER_INCLUDE.'/footer.php';
?>
