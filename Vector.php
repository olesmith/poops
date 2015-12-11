<?php


trait Vector
{
    function Vector_LinComb($c1,$p1,$c2,$p2)
    {
        $v=array();
        foreach (array_keys($p1) as $d)
        {
            if (!empty($p2[ $d ]))
            {
                $v[ $d ]=$c1*$p1[ $d ]+$c2*$p2[ $d ];
            }
        }
        
        return $v;
    }
    function Vector_DotProduct($p1,$p2)
    {
        $dot=0.0;
        foreach (array_keys($p1) as $d)  { $dot+=$p1[ $d ]*$p2[ $d ]; }
        
        return $dot;
    }

    function Vector_SquareLength($p)
    {        
        return $this->Vector_DotProduct($p,$p);
    }

    function Vector_Length($p)
    {
        return sqrt($this->Vector_SquareLength($p,$p));
    }

    function Vector_Distance($p1,$p2)
    {
        $v=$this->Vector_LinComb(1.0,$p2,-1.0,$p1);
        return $this->Vector_Length($v);
    }

    function Vector($p1,$p2)
    {
        return $this->Vector_LinComb(1.0,$p2,-1.0,$p1);
    }

    function Vector_Scale($p,$fact)
    {
        $v=array();
        foreach (array_keys($p) as $d) { $v[ $d ]=$fact*$p[ $d ]; }
        
        return $v;
    }
    
}
?>
