<?php

global $b;
    

trait Trochoids
{
    function TrochoidsParms()
    {
        $a=$this->Parm("a");
        $nl=$this->Parm("NL");

        //Poop size is varied
        $b=$this->Parm("T2");
        
        //Trochoids scales by 2*$this->Pi
        $this->Parms[ "T1" ][ "Default" ]=0;
        $this->Parms[ "T2" ][ "Default" ]=$nl;
        
        $this->Parms[ "X1" ][ "Default" ]=-0.25*($a+$b)*$this->Pi;
        $this->Parms[ "X1" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "X2" ][ "Default" ]=$a*$nl*$this->Pi-$this->Parms[ "X1" ][ "Default" ];
        $this->Parms[ "X2" ][ "ReadOnly" ]=TRUE;
        
        $this->Parms[ "Y1" ][ "Default" ]=-1.0*$b;
        $this->Parms[ "Y1" ][ "ReadOnly" ]=TRUE;

        $this->Parms[ "Y2" ][ "Default" ]=2.0*$a+1.5*$b;
        $this->Parms[ "Y2" ][ "ReadOnly" ]=TRUE;

                
        $this->Parms[ "ImageNo" ]=array
           (
              "Default" => $this->Parm("N"),
              "Type" => "INT",
              "Name" => "Imagem No.",
              "Size" => 3,
           );
    }

    function TrochoidsPoint($t)
    {
        $a=$this->Parm("a");
        
        global $b;
        return $this->Trochoid($t,$a,$b);
    }
    
    function D_TrochoidsPoint($t)
    {
        $a=$this->Parm("a");
        global $b;
        
        return $this->D_Trochoid($t,$a,$b);
    }
    
    function D2_TrochoidsPoint($t)
    {
        $a=$this->Parm("a");
        global $b;
        
        return $this->D2_Trochoid($t,$a,$b);
    }
    
    function AnimateTrochoids($bb)
    {
        $R="TrochoidsPoint";
        $ni=$this->Parm("NI");
        $a=$this->Parm("a");
        
        global $b;
        $b=$bb;

        $colors=$this->Animation_Parameters_Colors();
        
        $t=$this->Parm("NL")*$this->Pi;
        //$t=$this->Pi;
        
        $pc=array($this->Parm("a")*$t,$a);
        
        $this->R2_Draw_Point($pc,$colors[ "Color_Center" ],5);

        $ptrochoid=$this->$R($t);

        //Draw Poop
        $poopimg=$this->Parm("Poop");
        if (!empty($poopimg))
        {
            $this->R2_Draw_Image("icons/".$poopimg,$ptrochoid,$t);//no rotating
        }
        else
        {
           $this->R2_Draw_Point($ptrochoid,$colors[ "Color_Final" ],10);
        }
     
        $this->R2_Draw_Vector($pc,$ptrochoid,$colors[ "Color_Vector" ]);
        $this->R2_Draw_Vector($pc,array($a*$t,0.0),$colors[ "Color_Vector2" ]);
       
        $tt=$t;
        while ($tt>2.0*$this->Pi) { $tt-=2.0*$this->Pi; }
        
        $this->R2_Draw_Curve
        (
            $this->Arc($pc,$a),
            $colors[ "Color_Circle_Rolled" ]
        );
        $this->R2_Draw_Curve
        (
            $this->Arc($pc,$a+$b),
            $colors[ "Color_Circle_UnRolled" ]
        );
        
        $trochoid=$this->ParametricCurveData($R,0,$t,$ni);
        $this->R2_Draw_Curve_Data($trochoid);
 
        return array_pop($trochoid);
    }
}
?>
