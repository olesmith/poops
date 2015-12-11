<?php

include_once("R2.php");
include_once("Animations/Parabolas.php");
include_once("Animations/Ellipses.php");
include_once("Animations/Trochoid.php");
include_once("Animations/Trochoids.php");
include_once("Animations/Epitrochoid.php");
include_once("Animations/Epitrochoids.php");
include_once("Animations/Epitrochoids2.php");

class Animations
{
    use R2;
    use
        Parabola,Ellipses,
        Trochoid,Trochoids,
        Epitrochoid,Epitrochoids,Epitrochoids2;
    
    function ConcentricCircles($parms)
    {
        $pc=array(0.0,0.0);
        return array($this->Ellipse($pc,$parms[0],$parms[1]));
    }

    function ConcentricHyperboles($parms)
    {
        $pc=array(0.0,0.0);
        return array
        (
           $this->Hyperbola($pc,$parms[0],$parms[1],2.0),
           $this->Hyperbola($pc,$parms[0],$parms[1],2.0,TRUE),
        );
    }


    /* function Ellipse($t,$parms) */
    /* { */
    /*     return array */
    /*     ( */
    /*        $parms[ "C" ][0]+$parms[ "a" ]*cos($t), */
    /*        $parms[ "C" ][1]+$parms[ "b" ]*sin($t) */
    /*     ); */
    /* } */
    
    function Ellipses($parm)
    {
        $parms=array
        (
           "a" => $parm,
           "b" => $parm*$parm,
           "C" => array(0.0,0.0),
        );
        
        return array
        (
           $this->ParametricCurve
           (
              "Ellipse",
              0,6.2830,
              $this->NP,
              $parms
           )
        );
    }
    
    
    function Cicloids($t)
    {
        $r=0.25;
        
        $pc=array($r*$t,$r);
        $this->DrawPoint($pc,"Blue",5);

        $pcicloid=$this->Cicloid($t,array("r" => $r));

        $this->DrawPoint($pcicloid,"Blue",10);
        
        $this->DrawVector($pc,$pcicloid,"Black");
        $this->DrawVector($pc,array($r*$t,0.0),"Black");
       
        $this->DrawCurve
        (
           $this->GenEllipticArc($pc,$r,-$this->Pi/2.0,-$this->Pi/2.0-$t),
           "Blue"
        );
        
        return array
        (
           $this->GenParametricCurve
           (
              "Cicloid",
              0,$t,
              $this->NP,
              array("r" => $r)
           )
        );
    }   
}
?>
