<?php
include_once('lib/simple_html_dom.php');
// Create DOM from URL or file
$html = file_get_html('http://techmeme.com/mini');
$list = array();
$i = 0;
foreach ($html->find('div.mini_item') as $element) {
    /*
     * first 14 news are top news
     */
    if($i<=13) {
        if(isset($element->find('a', 0)->class) && $element->find('a', 0)->class=='mini_head') {
            if($element->previousSibling(0)->innertext == 'RELATED:') {
                $output['List'][$i]['from']   = $element->childNodes(0)->innertext.' (RELATED)';
            }else {
                $output['List'][$i]['from']   = $element->childNodes(0)->innertext;
            }
            $output['List'][$i]['link']   = $element->find('a', 0)->innertext;
            $output['List'][$i]['title']  = $element->find('a', 0)->href;
           $i++;
        }
        else if (isset($element->find('div', 0)->class) || isset($element->find('a div', 1)->class)) {
            if($element->previousSibling(0)->innertext == 'RELATED:') {
                $output['List'][$i]['from']   = $element->childNodes(0)->innertext.' (RELATED)';
            }else {
                $output['List'][$i]['from']   = $element->childNodes(0)->innertext;
            }
            $output['List'][$i]['link']   = $element->find('div a', 0)->innertext;
            $output['List'][$i]['title']  = $element->find('div a', 0)->href;
            $i++;
        }
   }
}
if (empty($output['List'])) {
    $output['List']['msg'] = 'No Result Found';
}

print(json_encode($output));
exit();
