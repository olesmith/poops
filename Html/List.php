<?php


trait Html_List
{
    function Html_List($enumerated,$list,$options=array(),$lioptions=array())
    {
        $html="";
        foreach ($list as $id => $item)
        {
            $html.=$this->Html_Tags("LI",$item,$lioptions);
        }
        
        $tag="UL";
        if ($enumerated) { $tag="OL"; }
            
        return $this->Html_Tags($tag,$html,$options);
    }
}

?>
