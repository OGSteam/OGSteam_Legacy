<center><b>MySpeach v3.0.1</b></center>
<br /><br />

<?php
  if(!@file_exists('admin/config.php')){
    echo '
      <div style="padding:5px; color:red; font-size:16px">MySpeach n\'est pas install&eacute; : </div>

    <ul>
      <li><a href="installation/">Installation</a></li>
    </ul>
    ';

  }else{
  include("admin/config.php");
?>

<div style="padding:5px; color:blue; font-size:16px">MySpeach est install&eacute;</div>

    <ul>
      <li><a href="admin/">Administration du chat</a></li>
      <li><a href="./chat_exemple.php">Voir MySpeach en action</a></li>
      <li><a href="http://www.graphiks.net/scripts/myspeach.html" target="_blank">FAQ de MySpeach</a></li>
    </ul>
    
    <p>
      Vous avez maintenant install&eacute; MySpeach. <br />
      Pour pouvoir l'afficher sur votre site, voici le code &agrave; copier dans une page .php : 
      <blockquote style="padding:3px; border:1px solid orange; background-color:#EEEEEE; width:80%">
        &lt;?php<br />
        &nbsp;&nbsp;$my_ms['root']="<?php echo $my_ms["absolu_root"].$my_ms["repertoire"]; ?>"; <br />
        &nbsp;&nbsp;include($my_ms['root'].'/chat.php');<br />
        ?&gt;
      </blockquote>

      Si vous avez des probl&egrave;mes lors de la mise en place du chat, le forum d'aide sur <a href="http://www.graphiks.net/" target="_blank">Graphiks.net</a> est la pour &ccedil;a. (<a href="http://www.graphiks.net/forum/forums.html" target="_blank">cliquer ici</a>)
    </p>
<?php
}
?>

<br /><br />
  <p>
  <a href="http://www.graphiks.net/" target="_blank">MySpeach</a>
  </p>
