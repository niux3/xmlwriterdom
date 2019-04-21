<?php
    header('Content-Type: text/xml; charset=utf-8');
    require_once './libs/XMLWriterDom.php';
    $xml = new XMLWriterDom();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->load('./data.xml');

    $root = $xml->documentElement;
    $dom = [
        'lorem?attr=une+valeur&autre-attr=encore+une+valeur' => 'une valeur',
        'ipsum' => [
            'sousipsux' => 'une autre valeur',
            'blaor' => 'et une autre valeur',
            'guylux?attr=une+valeur&autre-attr=encore+une+valeur' => [
                'gnu' => 'et encore une valeur',
                'linux' => 'encore une valeur',
            ],
        ],
        'indolore?attr=une+valeur&autre-attr=encore+une+valeur' => 'et une valeur',
        'ores' => 'et une valeur',
    ];
    $nodes = $xml->wrapBuildTree($dom, 'wrap');
    $root->appendChild($nodes);
    echo $xml->saveXML();
?>
