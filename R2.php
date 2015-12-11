<?php

include_once("Vector.php");

include_once("R2/Curves.php");
include_once("R2/Draw.php");
include_once("DR2.php");

trait R2
{
    use Vector,DR2;
    use R2_Curves,R2_Draw;
    
    var $Pi=3.1415927;
    
    var $Canvas=NULL;
    var $Min=array(0.0,0.0),$Max=array(1.0,1.0);

    //Matrix and vector, transforming coordinates to pixels.
    var $A=array(array(0.0,0.0),array(0.0,0.0));
    var $b=array(0.0,0.0);
    
    function R2($args=array())
    {
        foreach ($args as $key => $value)
        {
            $this->$key=$value;
        }

        if ($this->Canvas)
        {
            $this->Initialize();
        }
    }

    function Initialize()
    {
        $this->R2_CGI();
        
        $dx=1.0*($this->Parm("X2")-$this->Parm("X1"));
        $dy=1.0*($this->Parm("Y2")-$this->Parm("Y1"));

        //scale x axis
        $this->A[0][0]= (1.0*$this->Canvas->Res[0])/$dx;

        //scale y axis
        $this->A[1][1]=(1.0*$this->Canvas->Res[1])/$dy;

        $this->A[0][1]=0.0;
        $this->A[1][0]=0.0;

        $this->b[ 0 ]=-$this->A[ 0 ][ 0 ]*$this->Parm("X1");
        $this->b[ 1 ]=-$this->A[ 1 ][ 1 ]*$this->Parm("Y1");
    }
    
    function R2_CGI()
    {
        if (isset($_POST[ "X1" ]))
        {
            $this->Min[0]=$_POST[ "X1" ];
        }
        if (isset($_POST[ "X2" ]))
        {
            $this->Min[1]=$_POST[ "Y1" ];
        }
        
        if (isset($_POST[ "X2" ]))
        {
            $this->Max[0]=$_POST[ "X2" ];
        }
        if (isset($_POST[ "Y2" ]))
        {
            $this->Max[1]=$_POST[ "Y2" ];
        }
    }
    
    function Max($n1,$n2)
    {
        if ($n1>$n2) { return $n1; }
        else         { return $n2; }
    }

    function P2Pix($p)
    {
        if (empty($p)) { return array(); }
        
        $pix=array();
        for ($i=0;$i<2;$i++)
        {
            if (!empty($p[ $i ]))
            {
                $pix[ $i ]=$this->A[ $i ][ $i ]*$p[ $i ]+$this->b[ $i ];
            }
            
        }
        
        //Flip vertical orientation!
        if (!empty($pix[1]))
        {
            $pix[1]=$this->Canvas->Res[1]-$pix[1];
        }

        return $pix;
    }
    
    function Ps2Pix($ps)
    {
        $pix=array();
        foreach ($ps as $id => $p)
        {
            array_push($pix,$this->P2Pix($p));
        }

        return $pix;
    }
   
    
    function Vector2_Transverse($v)
    {
        if (!empty($v[0]) && !empty($v[1]))
        {
            return array(-$v[1],$v[0]);
        }

        return array();
    }
}
?>
