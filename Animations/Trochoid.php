<?php


trait Trochoid
{
    function TrochoidParms()
    {
        $colors=$this->Animation_Parameters_Colors();
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        $nl=$this->Parm("NL");
        $scale=$this->Parm("Scale");
        
        //Trochoids scales by 2*$this->Pi
        $this->Parms[ "T1" ][ "Default" ]=0.0;
        $this->Parms[ "T2" ][ "Default" ]=$nl;
        
        $this->ParmsValues[ "X1" ]=$this->Parms[ "X1" ][ "Default" ]=-0.5*$scale*$a*$this->Pi;
        $this->Parms[ "X1" ][ "ReadOnly" ]=TRUE;

        $this->ParmsValues[ "X2" ]=$this->Parms[ "X2" ][ "Default" ]=2.0*$a*$scale*$nl*$this->Pi-$this->Parms[ "X1" ][ "Default" ];
        $this->Parms[ "X2" ][ "ReadOnly" ]=TRUE;
        
        $this->ParmsValues[ "Y1" ]=$this->Parms[ "Y1" ][ "Default" ]=-1.5*$scale*abs($b);
        $this->Parms[ "Y1" ][ "ReadOnly" ]=TRUE;

        $this->ParmsValues[ "Y2" ]=$this->Parms[ "Y2" ][ "Default" ]=$scale*(2.0*$a+1.5*abs($b));
        $this->Parms[ "Y2" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "ImageNo" ]=array
           (
              "Default" => $this->Parm("N"),
              "Type" => "INT",
              "Name" => "Imagem No.",
              "Size" => 3,
           );
    }
    
    function TrochoidPoint($t)
    {
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return $this->Trochoid($t,$a,$b);
    }
    
    function D_TrochoidPoint($t)
    {
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return $this->D_Trochoid($t,$a,$b);
    }
    
    function D2_TrochoidPoint($t)
    {
        $a=$this->Parm("a");
        $b=$this->Parm("b");
        
        return $this->D2_Trochoid($t,$a,$b);
    }
    
    function AnimateTrochoid($t)
    {
        $R="TrochoidPoint";
        $poopscale=1.0+$t;
        
        //In multiples of 2*pi
        $t*=2.0*$this->Pi;
        
        $pc=array($this->Parm("a")*$t,$this->Parm("a"));

        $colors=$this->Animation_Parameters_Colors();
        
        $this->R2_Draw_Point($pc,$colors[ "Color_Center" ],5);

        $ptrochoid=$this->$R($t);

        
        $poopimg=$this->Parm("Poop");
        if (!empty($poopimg))
        {
            $this->R2_Draw_Image("icons/".$poopimg,$ptrochoid,$t,$poopscale);
        }
        else
        {
           $this->R2_Draw_Point($ptrochoid,$colors[ "Color_Final" ],10);
        }
     
        $this->R2_Draw_Vector($pc,$ptrochoid,$colors[ "Color_Vector" ]);
        $this->R2_Draw_Vector($pc,array($this->Parm("a")*$t,0.0),$colors[ "Color_Vector2" ]);
       
        $tt=$t;
        while ($tt>2.0*$this->Pi) { $tt-=2.0*$this->Pi; }
        
        $this->R2_Draw_Curve
        (
           $this->Arc($pc,$this->Parm("a"),100,-$this->Pi/2.0,-$this->Pi/2.0-$tt),
           $colors[ "Color_Circle_Rolled" ]
        );
        $this->R2_Draw_Curve
        (
           $this->Arc($pc,$this->Parm("a"),100,3.0*$this->Pi/2.0,2*$this->Pi),
           $colors[ "Color_Circle_UnRolled" ]
        );
        $this->R2_Draw_Curve
        (
           $this->Arc($pc,$this->Parm("a"),100,0.0,3.0*$this->Pi/2.0-$tt),
           $colors[ "Color_Circle_UnRolled" ]
        );

        $ni=$this->Parm("NI");
        
        $trochoid=$this->ParametricCurveData($R,0,$t,$ni);
        $this->R2_Draw_Curve_Data($trochoid);
        
        return array_pop($trochoid);
    }
}
?>
