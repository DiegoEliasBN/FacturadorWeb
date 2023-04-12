<?php
class DocumentWizard
{
    protected $doc = null;
    function __construct()
    {
        $this->createDomDocument();
    }
    protected function createDomDocument(){
        $this->doc = new DomDocument('1.0', 'UTF-8');
        $this->doc->preserveWhiteSpace = false;
        //$this->doc->formatOutput = true;
    }
    protected function getNodo($nodoNombre, $nodoValor = null)
    {
        if (isset($nodoValor)){
            return $this->doc->createElement($nodoNombre, $nodoValor);
        }else{
            return $this->doc->createElement($nodoNombre);
        }
    }
    protected function appendNodeIfValueIsNotNull($nombre, $value, &$elemet)
    {
        if (isset($value) && strlen((string)$value) > 0) {
            $elemet->appendChild($this->getNodo($nombre, $value));
        }
    }
/*
    protected void insertBeforeNodeIfValueIsNotNull(String nombre, String value, Element parentElemet, Element refElemet)
    {
        if (value != null) {
            if (!value.trim().equals("")) {
                parentElemet.insertBefore(getNodo(nombre, value), refElemet);
            }
        }
    }
*/
    protected function generateDocument(){
        $xml = $this->generateDocumentAsString();
        //$dom = new DOMDocument('1.0', 'UTF-8');
        //$xml = $this->formatXmlString($xml);
        //$dom->preserveWhiteSpace = false;
        //$dom->formatOutput = true;
        //$dom->loadXML($xml);
        return $xml;
    }
    public function generateDocumentAsString(){
        return $this->doc->saveXML();
        //Hacer el identen en 4 espacios
        /*return preg_replace_callback('/^( +)</m', function($a) {
            return str_repeat(' ',intval(strlen($a[1]) / 2) * 4).'<';
        }, $this->doc->saveXML());*/
    }
    protected function formatXmlString($xml) {
        // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
        // now indent the tags
        $token      = strtok($xml, "\n");
        $result     = ''; // holds formatted version as it is built
        $pad        = 0; // initial indent
        $matches    = array(); // returns from preg_matches()
        // scan each line and adjust indent based on opening/closing tags
        while ($token !== false) :
            // test for the various tag states
            // 1. open and closing tags on same line - no change
            if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
                $indent=0;
            // 2. closing tag - outdent now
            elseif (preg_match('/^<\/\w/', $token, $matches)) :
                $pad-=0;
            // 3. opening tag - don't pad this one, only subsequent tags
            elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
                $indent=0;
            // 4. no indentation needed
            else :
                $indent = 0;
            endif;
            // pad the line with the required number of leading spaces
            $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token   = strtok("\n"); // get the next token
            $pad    += $indent; // update the pad size for subsequent lines
        endwhile;
        return $result;
    }
}