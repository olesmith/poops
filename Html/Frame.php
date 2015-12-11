<?php

trait Html_Frame
{  
    function Html_Frame_Text($html,$options=array())
    {
        $options[ "BORDER" ]=1;
        
        return
            $this->Html_Tags
            (
               "TABLE",
               $this->Html_Tags
               (
                  "TR",
                  $this->Html_Tags("TD",$html)
               ),
               $options
            ).
            "";
    }
    
    function Html_Frame_Image($source,$options=array(),$imgoptions=array())
    {
        $imgoptions[ "SRC" ]=$source;

        return
            $this->Html_Frame_Text
            (
               $this->Html_Tag("IMG",$imgoptions),
               $options
            );
    }
}

?>
