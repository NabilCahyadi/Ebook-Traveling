<?php
$image = 'public/images/pdg.jpg';
$size = getimagesize($image);
echo "Width: " . $size[0] . "px\n";
echo "Height: " . $size[1] . "px\n";
echo "Ratio: " . round($size[0] / $size[1], 2) . "\n";
