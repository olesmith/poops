<?php


trait Html_Buttons
{
    function Html_Button($type,$name="",$options=array())
    {
        if (empty($name)) { $name="GO"; }
        
        $options[ "TYPE" ]=$type;
        return $this->Html_Tags("BUTTON",$name,$options);
    }
    
    function Html_Button_Send($name="",$options=array())
    {
        if (empty($name)) { $name="Send"; }
                     
        return $this->Html_Button('submit',$name,$options);
    }
    
    function Html_Button_Reset($name="",$options=array())
    {
        if (empty($name)) { $name="Reset"; }
        
        return $this->Html_Button('reset',$name,$options);
    }
    
    function Html_Buttons($sendname="",$resetname="",$options=array())
    {
        return
            $this->Html_Button_Send($sendname,$options).
            $this->Html_Button_Reset($resetname,$options).
            "";
    }
}

?>
