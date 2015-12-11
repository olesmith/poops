<?php


trait Colors
{
    var $Colors=array
    (
       "Black" => "#000000", //array(255,255,255),
       "White" => "#ffffff", //array(255,255,255),
       "Black" => "#000000", //array(0,0,0),
       "Red"   => "#ff0000", //array(255,0,0),
       "Green" => "#00ff00", //array(0,255,0),
       "Blue"  => "#0000ff", //array(0,0,255),
       "Yellow"  => "#ffff00", //array(255,255,0),
       "Cyan"  => "#00ffff", //array(0,255,255),
       "Pink"  => "#ff00ff", //array(255,0,255),
       "Orange"  => "#ff9900", //array(255, 153, 0),
    );

    var $Palette=array();
    
    function InitColors($colors=array())
    {
        if (empty($colors)) { $colors=$this->Colors; }
        
        foreach ($colors as $color => $colorvector)
        {
            $this->ColorAllocate($colorvector,$color);
        }
    }

    function ColorHex2Vector($colorhex)
    {
        if (preg_match('/^#[0-9a-f]{6}/i',$colorhex))
        {
            $r=hexdec(substr($colorhex,1,2));
            $g=hexdec(substr($colorhex,3,2));
            $b=hexdec(substr($colorhex,5,2));

            return array($r,$g,$b);
        }            
    }
    
    function ColorAllocate($colorvector,$colorname)
    {
        if (!empty($this->Palette[ $colorname ])) { return; }
        
        if (!is_array($colorvector))
        {
            $colorvector=$this->ColorHex2Vector($colorvector);
        }
        
        $this->Palette[ $colorname ]=imagecolorallocate
        (
           $this->Image,
           $colorvector[0],
           $colorvector[1],
           $colorvector[2]
        );
        
        $this->Colors[ $colorname ]=$colorvector;
    }
    
    function IsBackgroundColor($colorname)
    {
        $colors=array_keys($this->Palette);
        $bkcolor=array_shift($colors);

        $res=FALSE;
        if ($bkcolor==$colorname) { $res=TRUE; }

        return $res;
    }
    
    function IsNotBackgroundColor($colorname)
    {
        return !$this->IsBackgroundColor($colorname);
    }
    
    function GetColor($colorname)
    {
        $color=NULL;
        if (is_string($colorname))
        {
            if (!isset($this->Palette[ $colorname ]))
            {
                $this->ColorAllocate($colorname,$colorname);
            }
            
            if (!isset($this->Palette[ $colorname ]))
            {
                die("Poops::GetColor: No such color: '".$colorname."'");
            }
            
            $color=$this->Palette[ $colorname ];
        }

        return $color;
    }


    function ColorCombination($colors,$etas,$colorname)
    {
        $color=array(0,0,0);
        $etaacc=0.0;
        foreach ($colors as $cid => $rcolor)
        {
            $reta=$etaacc;
            if (!empty($etas[ $cid ])) { $reta=$etas[ $cid ]; }

            if (!is_array($rcolor))
            {
                $rcolor=$this->Colors[ $rcolor ];
            }

            for ($c=0;$c<3;$c++)
            {
                $color[ $c ]+=$reta*$rcolor[ $c ];
            }

            $etaacc+=$reta;
        }
        
        for ($c=0;$c<3;$c++)
        {
            $color[ $c ]=intval($color[ $c ]);
        }

        if (!empty($colorname))
        {
            $this->ColorAllocate($color,$colorname);
        }
        
        return $color;
    }
    }

?>
