<?php


trait Epitrochoid
{
    function Epitrochoid_Parms()
    {
        $scale=$this->Parm("Scale");
        $r1=abs($this->Parm("r1"));
        $r2=abs($this->Parm("r2"));
        $d=abs($this->Parm("d"));

        $rr=$scale*($r1+2.0*($r2+$d));

        
        $nl=$this->Parm("NL");
        
        //Trochoids scales by 2*$this->Pi
        $this->Parms[ "T1" ][ "Default" ]=0.0;
        $this->Parms[ "T2" ][ "Default" ]=1.0*$nl;
        
        $this->Parms[ "X1" ][ "Default" ]=-$rr;
        $this->Parms[ "X1" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "X2" ][ "Default" ]=$rr;
        $this->Parms[ "X2" ][ "ReadOnly" ]=TRUE;
        
        $this->Parms[ "Y1" ][ "Default" ]=-$rr;
        $this->Parms[ "Y1" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "Y2" ][ "Default" ]=$rr;
        $this->Parms[ "Y2" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "ImageNo" ]=array
           (
              "Default" => $this->Parm("N")/2,
              "Type" => "INT",
              "Name" => "Imagem No.",
              "Size" => 3,
           );
    }
    
    function Epitrochoid_Point($t)
    {
        $r1=$this->Parm("r1");
        $r2=$this->Parm("r2");
        $d=$this->Parm("d");
        
        return $this->Epitrochoid($t,$r1,$r2,$d);
    }
    
    function D_Epitrochoid_Point($t)
    {
        $r1=$this->Parm("r1");
        $r2=$this->Parm("r2");
        $d=$this->Parm("d");
        
        return $this->D_Epitrochoid($t,$r1,$r2,$d);
    }
    
    function D2_Epitrochoid_Point($t)
    {
        $r1=$this->Parm("r1");
        $r2=$this->Parm("r2");
        $d=$this->Parm("d");
        
        return $this->D2_Epitrochoid($t,$r1,$r2,$d);
    }
    
    function Epitrochoid_Animate($t)
    {
        $r1=$this->Parm("r1");
        $r2=$this->Parm("r2");
        $R="Epitrochoid_Point";
        
        //In multiples of 2*pi
        $t*=2.0*$this->Pi;
        
        $pc=array(0.0,0.0);
        
        $colors=$this->Animation_Parameters_Colors();
        
        $centercolor=$this->Parm("Color_Center");
        $finalcolor=$this->Parm("Color_Final");
        $rolledcolor=$this->Parm("Color_Circle_Rolled");
        $unrolledcolor=$this->Parm("Color_Circle_UnRolled");
        $vectorcolor=$this->Parm("Color_Vector");
        $vector2color=$this->Parm("Color_Vector2");

        
        $pepicycloid=$this->$R($t);
        
        $prc=array
        (
            ($r1+$r2)*cos($t),
            ($r1+$r2)*sin($t),
        );

        $poopimg=$this->Parm("Poop");
        if (!empty($poopimg))
        {
            $this->R2_Draw_Image("icons/".$poopimg,$pepicycloid,$t);//no rotating
        }
        else
        {
           $this->R2_Draw_Point($pepicycloid,$colors[ "Color_Final" ],10);
        }

        $this->R2_Draw_Point($pc,$centercolor,5);
        $this->R2_Draw_Circle($prc,$r2,$rolledcolor);
        $this->R2_Draw_Circle($pc,$r1,$centercolor);

        //$pepicycloid-$prc
        $e=$this->Vector_LinComb(1.0,$pepicycloid,-1.0,$prc);
        $f=$this->Vector2_Transverse($e);

        //$prc+$f
        $prn=$this->Vector_LinComb(1.0,$prc,1.0,$f);

        
        $this->R2_Draw_Vector($prc,$pepicycloid,$vectorcolor,0.2);
        $this->R2_Draw_Vector($prc,$prn,$vectorcolor,0.2);

        
        $ni=$this->Parm("NI");
        
        $this->R2_Draw_WCS("White",0.2);
        
        $trochoid=$this->ParametricCurveData($R,0,$t,$ni);
        $this->R2_Draw_Curve_Data($trochoid);

        return array_pop($trochoid);
    }
}
?>
