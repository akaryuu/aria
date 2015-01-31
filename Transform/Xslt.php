<?php

namespace Aria;

class Transform_Xslt extends TransformAbstract
{

    private $_xsl = null;

    public function setXsl($xsl) {

        $this->_xsl = $xsl;

    }

    public function transform($source)
    {
        $feeddom = new \DomDocument();
        $feeddom->loadXML($source);


        $xsldom = new \DomDocument();
        $xsldom->loadXML($this->_xsl);

        $proc = new \XSLTProcessor();

        $proc->importStylesheet($xsldom);

        $newdom = $proc->transformToDoc($feeddom);

        return $newdom->saveXML();
    }
}
