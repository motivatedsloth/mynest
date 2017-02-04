<doctype html>
<html>
<head>
<title>Our Little Nest</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
include "vendor/autoload.php";
use constellation\mynest\Nest;

$nest = new Nest;

foreach($nest->get("cycles") as $zone=>$cycle){
  $params = $cycle->params();
?>
  <h1>Zone <?=$zone?></h1>
<dl>
<dt>Start Time</dt>
<dd><?php echo $cycle->start()->format("M j, Y H:i a"); ?></dd>
<dt>Cycle Length</dt>
<dd><?php echo $cycle->length()->format("%i minutes"); ?></dd>
<dt>Running Time</dt>
<dd><?php echo $cycle->duration()->format("%i minutes"); ?></dd>
<dt>Running now?</dt>
<dd><?php echo $cycle->status(); ?></dd>
</dl>
<h2>Parameters</h2>
<dl>
<dt>Outside Temp</dt>
<dd><?php echo $params[ "outside" ]; ?></dd>
<dt>Target Temp Inside</dt>
<dd><?php echo $params[ "inside" ]; ?></dd>
<dt>Other Sources</dt>
<dd><?php echo $params["other_sources"]; ?></dd>
<dt>Remaining</dt>
<dd><?php echo $params["remaining"]; ?></dd>
</dl>
<?php
}//foreach
?>
</body>
</html>
