```sh
composer require amenadiel/jpgraph:^4
```

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// this is important: otherwise we get "imagettftext(): Problem doing text layout" (due to empty texts) on some servers
$error_reporting_level_prev = error_reporting(0);

$titles = ['Planning','Quality','Time','RR','CR','DR'];
$data = [18, 40, 70, 90, 42,66];
$graph = new Graph\RadarGraph (300,280);
$graph->title->Set('Radar with marks');
$graph->title->SetFont(FF_VERDANA,FS_NORMAL,12);
$graph->SetTitles($titles);
$graph->SetCenter(0.5,0.55);
$graph->HideTickMarks();
$graph->SetColor('lightgreen@0.7');
$graph->axis->SetColor('darkgray');
$graph->grid->SetColor('darkgray');
$graph->grid->Show();
$graph->axis->title->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->axis->title->SetMargin(5);
$graph->SetGridDepth(DEPTH_BACK);
$graph->SetSize(0.6);
$plot = new Plot\RadarPlot($data);
$plot->SetColor('red@0.2');
$plot->SetLineWeight(1);
$plot->SetFillColor('red@0.7');
$plot->mark->SetType(MARK_IMG_SBALL,'red');
$graph->Add($plot);

// directly output image
//$graph->Stroke();

// get base64
$img = $graph->Stroke(_IMG_HANDLER);
ob_start();
imagepng($img);
$img_data = ob_get_contents();
ob_end_clean();
$img_data = base64_encode($img_data);
echo $img_data;

// restore error level
error_reporting($error_reporting_level_prev);
```