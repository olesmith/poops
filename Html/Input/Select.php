<?php


trait Html_Input_Select
{
    function Html_Select($name,$svalues,$svalue,$soptions=array(),$ooptions=array())
    {
        $soptions[ "NAME" ]=$name;

        return
            $this->Html_Tags
            (
               "SELECT",
               $this->Html_Select_Options($svalues,$svalue,$ooptions),
               $soptions
            );
    }
    
    function Html_Select_Options($values,$svalue=0,$ooptions=array())
    {
        $html="";
        foreach ($values as $value => $name)
        {
            $html.=$this->Html_Select_Option($name,$svalue,$value,$ooptions);
        }
        
        return $html;
    }
    
    function Html_Select_Option($name,$svalue,$value,$ooptions=array())
    {
        if (!empty($svalue) && $svalue==$value) { $ooptions[ "SELECTED" ]="1"; }
        
        $ooptions[ "VALUE" ]=$value;
        
        return $this->Html_Tags("OPTION",$name,$ooptions);
    }
    
}

?>
