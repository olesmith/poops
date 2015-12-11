<?php


trait Animation_Iteration_Image
{
    function Animation_Iteration_Image_No($imageno=0)
    {
        if (empty($imageno)) { $imageno=$this->Parm("ImageNo"); }
        
        return $imageno;
    }
    
    function Animation_Iteration_Image_Name($imageno=0)
    {
        return
            $this->Images_OutPath.
            "/anim-".
            $this->Animation_Iteration_Image_No($imageno).".".
            $this->Images_Format;
    }
    
    function Animation_Iteration_Image_Size($imageno=0)
    {
        return filesize($this->Animation_Iteration_Image_Name($imageno));
    }
    
    function Animation_Iteration_Image_Title($imageno=0)
    {
        return
            "Image "." ".$this->Images_Format.", ".
            $this->Animation_Iteration_Image_Name($imageno).": ".
            $this->Animation_Iteration_Image_Size($imageno)." bytes";
    }
    
    function Animation_Iteration_Image($imageno=0)
    {
        return $this->Canvas->Image_Show
        (
           $this->Animation_Iteration_Image_Name($imageno)
        );
    }
    
    function Animation_Iteration_Image_URL($imageno=0,$args=array())
    {
        if (empty($imageno)) { $imageno=$this->Parm("ImageNo"); }

        $args[ "Animation" ]=$this->AnimationName;
        $args[ "ImageNo" ]=$imageno;
        $args[ "NoGen" ]=1;

        return
            "?".
            $this->Animation_Parameters_Get($args).
            "#Image";
    }
    
    
    function Animation_Iteration_Image_Show($imageno=0)
    {
        return
            "<A NAME='Image'></A>".
            $this->Animation_Iteration_Menu().
            $this->Html_C
            (
                  $this->Canvas->Image_Show
                  (
                     $this->Animation_Iteration_Image_Name($imageno),
                     array
                     (
                        "TITLE" => $this->Animation_Iteration_Image_Title($imageno)
                     )
                  )
            );
    }    
}
?>
