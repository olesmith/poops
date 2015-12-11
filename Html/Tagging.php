<?php


trait Html_Tagging
{
    function Html_Tag($tag,$options=array(),$newline="\n")
    {
        return
            "<".
            strtoupper($tag).
            $this->Html_Options($options).
            ">".$newline;   
    }
    
    function Html_Tag_Close($tag)
    {
        return
            "</".
            strtoupper($tag).
            ">\n";   
    }
    
    function Html_Tags($tag,$content="",$options=array())
    {
        return
            $this->Html_Tag($tag,$options,"").
            $content.
            $this->Html_Tag_Close($tag);
    }
}

?>
