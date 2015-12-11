<?php

define("PI",3.1415927);

trait R2_Curves
{
    function EllipticArc($p,$a,$b,$n=100,$angle1=0.0,$angle2=0.0)
    {
        if (empty($angle2)) { $angle2=2.0*PI; }

        $dangle=($angle2-$angle1)/(1.0*($n-1));

        $ps=array();
        
        $angle=$angle1;
        for ($i=0;$i<$n;$i++)
        {
            if (isset($p[0]) && isset($p[1]))
            {
                array_push
                (
                   $ps,
                   array
                   (
                      $p[0]+$a*cos($angle),
                      $p[1]+$b*sin($angle),
                   )
                );
            }

            $angle+=$dangle;
        }

        return $ps;
    }
    
    function Arc($p,$r,$n=100,$angle1=0.0,$angle2=0.0)
    {
        if (empty($angle2)) { $angle2=2.0*PI; }

        return $this->EllipticArc($p,$r,$r,$n,$angle1,$angle2);
    }
    
    
    function Circle($p,$r,$n=100)
    {
        return $this->Arc($p,$r,$n,0.0,2*PI);
    }
    
    function Ellipse($p,$a,$b,$n=100)
    {
        return $this->EllipticArc($p,$a,$b,$n,0.0,2*PI);
    }

    
    function HyperbolicArc($p,$a,$b,$t1,$t2=0.0,$n,$reflectx=FALSE,$reflecty=FALSE)
    {
        if (empty($n)) { $n=$this->N(); }
        if (empty($t2)) { $t2=$t1; $t1=-$t2;}

        //Circles
        if (!is_array($r)) { $r=array($r,$r); }
        
        $dt=($t2-$t1)/(1.0*($n-1));

        $factx=1.0;
        if ($reflectx) { $factx=-1.0; }
        $facty=1.0;
        if ($reflecty) { $facty=-1.0; }


        $ps=array();
        
        $t=$t1;
        for ($i=0;$i<$n;$i++)
        {
            array_push
            (
               $ps,
               array
               (
                  $p[0]+$factx*$a*cosh($t),
                  $p[1]+$factx*$b*sinh($t),
               )
            );

            $t+=$dt;
        }

        return $ps;
    }
    
    function  Hyperbola($p,$a,$b,$n,$tmax,$reflectx=FALSE,$reflecty=FALSE)
    {
        return $this->HyperbolicArc($p,$a,$b,-$tmax,$tmax,$nP,$reflectx,$reflecty);
    }

    
    function ParametricCurve($R,$t1,$t2,$n)
    {
        $dt=($t2-$t1)/(1.0*($n-1));

        $t=$t1;
        
        $ps=array();
        for ($i=0;$i<$n;$i++)
        {
            array_push
            (
               $ps,
               $this->$R($t)
            );

            $t+=$dt;
        }

        return $ps;
        
    }
    
    function ParametricCurveTangents($R,$t1,$t2,$n)
    {
        $dt=($t2-$t1)/(1.0*($n-1));

        $t=$t1;
        
        $drs=array();
        for ($i=0;$i<$n;$i++)
        {
            array_push
            (
               $drs,
               $this->T($R,$t)
            );

            $t+=$dt;
        }

        return $drs;
        
    }

    function Involute_Vector($pointdata,$tangent)
    {
        return $this->Vector_LinComb
        (
           1.0,
           $pointdata[ "R" ],
           $this->Parm("Involute_Start")-$pointdata[ "S" ],
           $tangent
        );
    }

    
    function ParametricCurveData($R,$t1,$t2,$n)
    {
        $dt=($t2-$t1)/(1.0*($n-1));

        $t=$t1;
        $DR=$D2R="";

        if ($this->Parm("Analytical"))
        {
            $DR="D_".$R;
            $D2R="D2_".$R;
        }
        
        $curvedata=array();
        $lastpoint=array();
        for ($i=0;$i<$n;$i++)
        {
            //Point and derivatives
            $r=$this->$R($t);

            if (method_exists($this,$DR))
            {
               $dr=$this->$DR($t);
            }
            else
            {
                $dr=$this->DR($R,$t);
            }
            
            if (method_exists($this,$D2R))
            {
               $d2r=$this->$D2R($t);
            }
            else
            {
                $d2r=$this->D2R($R,$t);
            }
        
            $len=$this->Vector_Length($dr);

            $tangent=array();
            $normal=array();
            if ($len>0.0)
            {
                $tangent=$this->Vector_Scale($dr,1.0/$len);
                $normal=$this->Vector2_Transverse($tangent);
            }
            
            $pointdata=array
            (
               "i"   => $i,
               "t"   => $t,
               "R"   => $r,
               "DR"  => $dr,
               "D2R" => $d2r,
               "DLength" => $len,
               "T" => $tangent,
               "N" => $normal,
               "S" => 0.0,
               "DS" => 0.0,
            );
            
            $pointdata[ "Curvature" ]=$this->Curvature($R,$t,$dr,$d2r);
            $pointdata[ "Curvature_Radius" ]="";
            if ($pointdata[ "Curvature" ]!=0.0)
            {
                $pointdata[ "Curvature_Radius" ]=1.0/$pointdata[ "Curvature" ];
            }
            
            $pointdata[ "Curvature_Vector" ]=$this->Curvature_Vector($R,$t,$dr,$d2r);
            $pointdata[ "Curvature_Center" ]=$this->Curvature_Center($R,$t,$r,$dr,$d2r);

            if (!empty($lastpoint[ "R" ]))
            {
                $pointdata[ "DS" ]=
                    $this->Vector_Distance
                    (
                       $lastpoint[ "R" ],
                       $pointdata[ "R" ]
                    );
                
                $pointdata[ "S" ]=
                    $lastpoint[ "S" ]+
                    $pointdata[ "DS" ];
               
            }
            
            $pointdata[ "Involute" ]=$this->Involute_Vector($pointdata,$tangent);
             
            $t+=$dt;
            $lastpoint=$pointdata;
            array_push($curvedata,$pointdata);            
        }

        return $curvedata;
        
    }
    
    function Cicloid($t,$r)
    {
        return array
        (
           $r*($t-sin($t)),
           $r*(1.0-cos($t))
        );
    }
    
    function R_Trochoid($t,$a,$b)
    {
        return array
        (
           $a*$t - ($a+$b)*sin($t),
           $a    - ($a+$b)*cos($t)
        );
    }
    
    function Trochoid($t,$a,$b)
    {
        return $this->R_Trochoid($t,$a,$b);
    }
    
    function D_Trochoid($t,$a,$b)
    {
        return array
        (
           $a - ($a+$b)*cos($t),
                ($a+$b)*sin($t)
        );
    }
    
    function D2_Trochoid($t,$a,$b)
    {
        return array
        (
           ($a+$b)*sin($t),
           ($a+$b)*cos($t)
        );
    }
    
    function Epicycloid($t,$r1,$r2)
    {
        $omegat=$t*($r1+$r2)/$r2;
        
        return array
        (
           ($r1+$r2)*cos($t)-$r2*cos($omegat),
           ($r1+$r2)*sin($t)-$r2*sin($omegat),
        );
    }
    
    function R_Epitrochoid($t,$r1,$r2,$d)
    {
        $omegat=$t*($r1+$r2)/$r2;
        
        return array
        (
           ($r1+$r2)*cos($t)-($d+$r2)*cos($omegat),
           ($r1+$r2)*sin($t)-($d+$r2)*sin($omegat),
        );
    }
    
    function Epitrochoid($t,$r1,$r2,$d)
    {
        return $this->R_Epitrochoid($t,$r1,$r2,$d);
    }
    
    function D_Epitrochoid($t,$r1,$r2,$d)
    {
        $omegat=$t*($r1+$r2)/$r2;
        
        return array
        (
           -($r1+$r2)*sin($t)+$omegat*($d+$r2)*sin($omegat),
            ($r1+$r2)*cos($t)-$omegat*($d+$r2)*cos($omegat),
        );
    }
    
    function D2_Epitrochoid($t,$r1,$r2,$d)
    {
        $omegat=$t*($r1+$r2)/$r2;
        
        return array
        (
           -($r1+$r2)*cos($t)+$omegat*$omegat*($d+$r2)*cos($omegat),
           -($r1+$r2)*sin($t)+$omegat*$omegat*($d+$r2)*sin($omegat),
        );
    }
    
    function Hypotrochoid($t,$r1,$r2,$d)
    {
        return $this-> Epitrochoid($t,$r1,-$r2,$d);
    }
}
?>
