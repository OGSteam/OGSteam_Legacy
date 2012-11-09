<?php
// classe simple generant xlm a partir d une bdd ( => evolution inverser ... )
// evolution plus lointaine sous item
class db_xml
{
    private $db;
    private $table;
    private $names;
    private $name;
    private $xml;
    private $where_clause;
    private $conteneur = array();

    //constructeur
    public function __construct($db, $table, $name, $where_clause)
    {
        $this->db = $db;
        $this->table = $table;
        $this->names = $name . "s";
        $this->name = $name;
        $this->where_clause = $where_clause;
        $this->xml = new DOMDocument('1.0', 'utf-8');
    }


    public function generate_db_to_xml($champs = null)
    {
        $items = $this->xml->createElement($this->names);
        $this->dbtoconteneur($champs); // on recupere noeuds enfants dans conteneur

        for ($i = 0; $i < sizeof($this->conteneur); $i++) {
            $items->appendChild($this->conteneur[$i]);
        }

        $this->xml->appendChild($items);
        Header("content-type: application/xml");
        echo $this->xml->saveXML();


    }

    private function dbtoconteneur($champs)
    {
        $selecteur = "*";
        if (is_array($champs)){ $selecteur = " ".$champs[1]."(" . $champs[0] . ") as " . $champs[1]."_".$champs[0] . " ";}
        elseif ($champs != null) {  $selecteur = " DISTINCT(" . $champs . ") ";}
        

        // echo $selecteur." _ ".$champs;
        $request = "SELECT  " . $selecteur . " FROM  " . $this->table . "  " . $this->
            where_clause . " ";
        
        //debug
       // var_dump($request);
        
        if ($result = $this->db->sql_query($request)) {
            while ($row = $this->db->sql_fetch_assoc($result)) {
               
                $item = $this->xml->createElement($this->name);
                foreach ($row as $key => $value) {
                    // echo ''.$key.' => '.$value.'<br />';
                    if ($value == "") {
                        $value = " ";
                    }
                    // var_dump($value);
                    $node = $this->xml->createElement(utf8_encode($key), utf8_encode($value));
                    $item->appendChild($node);
                }
                $this->conteneur[] = $item;
            }
        }

        $this->db->sql_close();
        //echo $request;
    }


    /// hors class
    public static function generate_simple_xlm($ar, $root)
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><{$root}></{$root}>");
        //var_dump($ar);
        $f = create_function('$f,$c,$a', ' 
            foreach($a as $k=>$v) { 
                if(is_array($v)) { 
                    $ch=$c->addChild($k); 
                    $f($f,$ch,$v); 
                } else { 
                    $c->addChild($k,$v); 
                } 
            }');
        $f($f, $xml, $ar);
        //  return $xml->asXML();
        Header("content-type: application/xml");
        echo $xml->asXML();
        
        
        // mis een journal
        journal($ar);
       
        //    echo $xml->saveXML();


    }

}
