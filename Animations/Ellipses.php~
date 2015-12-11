<?php

global $b;
global $Vertices;
$Vertices=array();
    

trait Parabola
{
    function Parabola_Parms()
    {
        $a=$this->Parm("a");
        $scale=$this->Parm("Scale");
        
        $this->Parms[ "X1" ][ "Default" ]=$this->Parm("T1")*$scale;
        $this->Parms[ "X2" ][ "Default" ]=$this->Parm("T2")*$scale;

        $this->Parms[ "Y1" ][ "Default" ]=-5.0*$scale;
        $this->Parms[ "Y2" ][ "Default" ]=10.0*$scale;
                
        $this->Parms[ "ImageNo" ]=array
           (
              "Default" => $this->Parm("N"),
              "Type" => "INT",
              "Name" => "Imagem No.",
              "Size" => 3,
           );
    }

    function Parabola_Point($t)
    {
        $a=$this->Parm("a");
        $c=$this->Parm("c");
        
        global $b;
        return array($t,$a*$t*$t+$b*$t+$c);
    }
    
    function D_Parabola_Point($t)
    {
        $a=$this->Parm("a");
        global $b;
        
        return array(1.0,2.0*$a*$t*+$b);
    }
    
    function D2_Parabola_Point($t)
    {
        $a=$this->Parm("a");
        global $b;
        
        return array(0.0,2.0*$a);
    }
    
    function Animate_Parabola($bb)
    {
        $R="Parabola_Point";
        $a=$this->Parm("a");
        $c=$this->Parm("c");
        $ni=$this->Parm("NI");
        $t1=$this->Parm("T1");
        $t2=$this->Parm("T2");
        
        global $b;
        $b=$bb;

        $colors=$this->Animation_Parameters_Colors();
        $delta=$b*$b-4.0*$a*$c;

        $this->R2_Draw_WCS("White");

        $vertex=array(-0.5*$b/$a,-0.25*$delta/$a);
        $parabola=$this->ParametricCurveData($R,$t1,$t2,$ni);
        $this->R2_Draw_Curve_Data($parabola);

        global $Vertices;
        array_push($Vertices,$vertex);

        foreach ($Vertices as $vertex)
        {
            $this->R2_Draw_Node($vertex,$colors[ "Color_Vertex" ]);
        }
 
        return array_pop($parabola);
    }
}
?>
