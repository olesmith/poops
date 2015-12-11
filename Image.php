<?php


trait Image
{    
    //*
    //* Variables of Image class:
    //*
    
    var $Image=NULL;
    var $Format=NULL;
    
   function Image_Create()
    {
        $this->Canvas_CGI();

        $imagecreate="imagecreate";
        if ($this->Parent->Parm("TrueColor")==1)
        {
            $imagecreate.="truecolor";
        }
        
        $this->Image=$imagecreate($this->Res[0],$this->Res[1]);
    }

    function Image_Destroy()
    {
        imagedestroy($this->Image);
        $this->Image=NULL;
    }

    function Image_Recreate()
    {
        $this->Image_Destroy();
        $this->Canvas_Init();
    }


    function Image_Write($fname,$destroyimage=TRUE)
    {
        $comps=preg_split('/\//',$fname);
        array_pop($comps);
        
        $fdir=join("/",$comps);
        if (!is_dir($fdir))
        {
            mkdir($fdir);
        }

        //var_dump($fdir);
        $written=FALSE;
        if (preg_match('/\.gif$/',$fname))
        {
            imagegif($this->Image,$fname);
            $written=TRUE;

            $this->Format='gif';
        }
        elseif (preg_match('/\.png$/',$fname))
        {
            imagepng($this->Image,$fname);
            $written=TRUE;

            $this->Format='png';
        }
        else { die("Error writing ".$fname); }

        
        if ($destroyimage)
        {
            $this->Image_Destroy();
        }

        return TRUE;
    }

    function Image_Send($fname)
    {
        if ($this->Image_Write($fname))
        {
            if (preg_match('/^(gif|png)$/1',$this->Format))
            {
                header('Content-type: image/'.$this->Format);
            }
        }
    }


    function Image_Show($source,$imgoptions=array())
    {
        $imgoptions[ "SRC" ]=$source;
        
        return
            $this->Parent->Html_Frame
            (
               $this->Parent->Html_Tag("IMG",$imgoptions)
            ).
            "";
    }

    function Image_Write_Show($fname,$imgoptions=array())
    {
        if ($this->Image_Write($fname))
        {
            $this->Image_Show($fname,$imgoptions);
        }
    }

    

    function Image_DrawText($x1,$y1,$text,$color)
    {
        $color=$this->GetColor($color);
        if ($color>0)
        {
            imagestring($this->Image,1,$x1,$y1,$text,$color);
        }
    }

    function Image_DrawLine($x1,$y1,$x2,$y2,$color)
    {
        $color=$this->GetColor($color);
        if ($color>0)
        {
            imageline($this->Image,$x1,$y1,$x2,$y2,$color);
        }
    }

    function Image_DrawEllipse($x1,$y1,$a,$b,$color)
    {
        $color=$this->GetColor($color);
        if ($color>0)
        {
            imagefilledellipse($this->Image,$x1,$y1,$a,$b,$color);
        }
    }
    
    function Image_DrawCircle($x1,$y1,$r,$color)
    {
        $this->Image_DrawEllipse($x1,$y1,$r,$r,$color);
    }
    
    function Image_DrawImage($fname,$x1,$y1,$rotate,$scale=1.0)
    {
        $img=imagecreatefrompng($fname);

        if ($rotate>0)
        {
            $img=imagerotate ($img,$rotate,0);
        }
        
        if ($scale!=1.0)
        {
            var_dump($scale);
            $img=imagescale($img,$scale,$scale);
        }
        
        imagecopy
        (
           $this->Image,
           $img,
           $x1-imagesx($img)/2,$y1-imagesx($img)/2,
           0,0,
           imagesx($img),imagesy($img)
        );

        imagedestroy($img);
    }
}
?>
