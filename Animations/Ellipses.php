<?php


trait Ellipses
{
    function Ellipse_Parms()
    {
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        $scale=$this->Parm("Scale")*$this->Max($a,$b);
        
        $this->Parms[ "X1" ][ "Default" ]=-$scale;
        $this->Parms[ "X2" ][ "Default" ]= $scale;

        $this->Parms[ "Y1" ][ "Default" ]=-$scale;
        $this->Parms[ "Y2" ][ "Default" ]= $scale;
                
        $this->Parms[ "X1" ][ "ReadOnly" ]=TRUE;
        $this->Parms[ "X2" ][ "ReadOnly" ]=TRUE;
        $this->Parms[ "Y1" ][ "ReadOnly" ]=TRUE;
        $this->Parms[ "Y2" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "ImageNo" ]=array
           (
              "Default" => $this->Parm("N"),
              "Type" => "INT",
              "Name" => "Imagem No.",
              "Size" => 3,
           );
    }

    function Ellipse_Point($t)
    {
        if (empty($t)) { $t=0.0; }
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return array($a*cos($t),$b*sin($t));
    }
    
    function D_Ellipse_Point($t)
    {
        if (empty($t)) { $t=0.0; }
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return array(-$a*sin($t),$b*cos($t));
    }
    
    function D2_Ellipse_Point($t)
    {
        if (empty($t)) { $t=0.0; }
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return array(-$a*cos($t),-$b*sin($t));
    }
    
    function Animate_Ellipse($t)
    {
        if (empty($t)) { $t=0.0; }
        $R="Ellipse_Point";
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        $ni=$this->Parm("NI");
        $t1=0;
        $t2=$t;

        
        $colors=$this->Animation_Parameters_Colors();

        $this->R2_Draw_WCS("Green");

        $ellipse=$this->ParametricCurveData($R,$t1,$t2,$ni);
        $this->R2_Draw_Curve_Data($ellipse);

 
        return array_pop($ellipse);
    }
}
?>
