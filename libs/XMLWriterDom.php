<?php
class XMLWriterDom extends DomDocument{
    public function __construct()
    {
        parent::__construct();
    }

    public function createSimpleElement(string $el, $txt = "", $attributes = [])
    {
        $node = $this->createElement($el);
        $this->writeAttributes($node, $attributes);

        if(!empty(trim($txt))){
            $txt = $this->createTextNode($txt);
            $node->appendChild($txt);
        }

        return $node;
    }


    public function wrapBuildTree(array $data, string $txtElementWrapper, $attributes = [])
    {
        $wrap = $this->createElement($txtElementWrapper);
        $this->writeAttributes($wrap, $attributes);

        foreach ($data as $key => $value) {
            $attributes = [];
            if(strstr($key, '?')){
                list($key, $queryString) = explode('?', $key);
                parse_str($queryString, $attributes);
            }
            $item = $this->typeNode($key, $value, $attributes);

            $wrap->appendChild($item);
        }

        return $wrap;
    }

    public function buildTree(object $root, array $data, $attributes = [])
    {
        foreach ($data as $key => $value) {
            $attributes = [];
            if(strstr($key, '?')){
                list($key, $queryString) = explode('?', $key);
                parse_str($queryString, $attributes);
            }
            $wrap = $this->createElement($key);
            $this->writeAttributes($wrap, $attributes);

            $item = $this->typeNode($key, $value, $attributes);

            $node = $wrap->appendChild($item);
            $root->appendChild($node);
        }
    }

    protected function writeAttributes(object $wrap, array $attributes)
    {
        if(!empty($attributes)){
            foreach ($attributes as $attrKey => $attrValue) {
                $wrap->setAttribute($attrKey, $attrValue);
            }
        }

        return $wrap;
    }

    protected function typeNode(string $key, $value, array $attributes)
    {
        if(is_array($value)){
            $node = $this->wrapBuildTree($value, $key, $attributes);
        }

        if(is_string($value)){
            $node = $this->createSimpleElement($key, $value, $attributes);
        }

        return $node;
    }
}
?>
