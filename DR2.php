<?php


trait DR2
{
    var $Eps=1.0E-6;
    
    function Df($func,$t)
    {
        return
            ($this->$func($t+0.5*$this->Eps)-$this->$func($t-0.5*$eps))/$this->Eps;
    }
    
    function DR($R,$t)
    {
        $r1=$this->$R($t+0.5*$this->Eps);
        $r2=$this->$R($t-0.5*$this->Eps);
        $dr=$this->Vector($r1,$r2);
        
        return $this->Vector_Scale($dr,1.0/$this->Eps);
    }
    
    function D2R($R,$t)
    {
        $dr1=$this->DR($R,$t+0.5*$this->Eps);
        $dr2=$this->DR($R,$t-0.5*$this->Eps);
        
        $dr2=$this->Vector($dr1,$dr2);
        
        return $this->Vector_Scale($dr2,1.0/$this->Eps);
    }
    
    function DR2_Tangent($R,$t,$dr=NULL)
    {
        if ($dr==NULL) { $dr=$this->DR($R,$t); }
        
        $len=$this->Vector_Length($dr);
        if ($len>0.0)
        {
            return $this->Vector_Scale($dr,1.0/$len);
        }

        return array();
    }
    
    function T($R,$t,$dr=NULL)
    {
        return $this->DR2_Tangent($R,$t,$dr);
    }
    
    function DR2_Normal($R,$t,$dr=NULL)
    {
        if ($dr==NULL) { $dr=$this->DR($R,$t); }
        
        $len=$this->Vector_Length($dr);
        if ($len>0.0)
        {
            $n=$this->Vector2_Transversor($dr);
            return $this->Vector_Scale($n,1.0/$len);
        }

        return array();
    }
    
    function N($R,$t,$dr=NULL)
    {
        return $this->DR2_Normal($R,$t,$dr);
    }
    
    function Curvature($R,$t,$dr=NULL,$d2r=NULL)
    {
        if ($dr==NULL) { $dr=$this->DR($R,$t); }
        
        $len=$this->Vector_Length($dr);
        if ($len>0.0)
        {
            if ($d2r==NULL) { $d2r=$this->D2R($R,$t); }

            if (
                  isset($dr[0])
                  &&
                  isset($dr[1])
                  &&
                  isset($d2r[0])
                  &&
                  isset($d2r[1])
               )
            {
                return ($dr[0]*$d2r[1]-$dr[1]*$d2r[0])/pow($len,3.0);
            }
        }
        
        return NULL;
    }
    
    function Curvature_Vector($R,$t,$dr=NULL,$d2r=NULL)
    {
        if ($dr==NULL) { $dr=$this->DR($R,$t); }
        
        $curvature=$this->Curvature($R,$t,$dr,$d2r);
        if ($curvature!=NULL && $curvature!=0.0)
        {
            $n=$this->Vector2_Transverse($dr);
            $len=$this->Vector_Length($n);

            if ($len>0.0)
            {
                $len*=$curvature;
                return $this->Vector_Scale($n,1.0/$len);
            }
        }

        return array();
    }
    
    function Curvature_Center($R,$t,$r=NULL,$dr=NULL,$d2r=NULL)
    {
        $curvaturevector=$this->Curvature_Vector($R,$t,$dr,$d2r);
        if (!empty($curvaturevector))
        {
            if ($r==NULL) { $r=$this->$R($t); }
            
            return $this->Vector_LinComb(1.0,$r,1.0,$curvaturevector);
        }

        return array();
    }
}
?>
