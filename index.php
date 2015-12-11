<?php

include_once("Canvas.php");
include_once("Animation.php");

class Graphics extends Animation
{
}

$animation=new Graphics
(
   array
   (
      /* "ColorNames" => array("Red","Red"), */
      
      /* "DrawPoints" => TRUE, */
      /* "DrawPointsR" => 1, */
      /* "DrawPointsColor" => "Black", */
      
      /* "GeneratorMethod" => "Trochoids", */
    )
);


?>
