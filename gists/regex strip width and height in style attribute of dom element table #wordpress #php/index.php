<?php
$html = '<table style="width: 77.9614%; height: 207px;">
    <tr style="height: 23px;">
        <td style="height: 23px; width: 172.132%; text-align:left;">...</td>
    </tr>
</table>';

$html = preg_replace('/(<(?:table|thead|tbody|td|tr|th)(?:.*)?style="(?:[^"]*)?)(width:(?: *)?\d+(?:\.\d+)?(?:%|px)(?: *)?(?:;*)?(?: *))((?:[^"]*)?"(?:.*)?>)/', '$1$3', $html);
$html = preg_replace('/(<(?:table|thead|tbody|td|tr|th)(?:.*)?style="(?:[^"]*)?)(height:(?: *)?\d+(?:\.\d+)?(?:%|px)(?: *)?(?:;*)?(?: *))((?:[^"]*)?"(?:.*)?>)/', '$1$3', $html);
$html = str_replace([' style=" "', ' style=""'], '', $html);

echo '<textarea style="width:100%;height:100%;">';
echo $html;
echo '</textarea>';

/*
<table>
    <tr>
        <td style="text-align:left;">...</td>
    </tr>
</table>
*/