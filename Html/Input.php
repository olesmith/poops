<?php

include_once("Input/Select.php");

trait Html_Input
{
    use Html_Input_Select;
    
    function Html_Input($type,$name,$value="",$options=array())
    {
        if (empty($value)) { $value=$this->Parm($name); }
        
        $options[ "TYPE" ]=$type;
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;

        $html="undef";
        if (preg_match('/^(REAL|INT|TEXT)$/',$type))
        {
            $html=$this->Html_Input_Text($name,$value,$options);
        }
        if (preg_match('/^(COLOR)$/',$type))
        {
            $html=$this->Html_Input_Color($name,$value,$options);
        }
        elseif ($type=="BOOL")
        {
            unset($options[ "TYPE" ]);
            unset($options[ "VALUE" ]);
            $html=$this->Html_Select
            (
               $name,
               array
               (
                  "0" => "No",
                  "1" => "Yes",
               ),
               $value,
               $options
            );
        }

        return $html;
    }
    
    function Html_Input_Text($name,$value="",$options=array())
    {
        $options[ "TYPE" ]='text';
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;

        return $this->Html_Tag("INPUT",$options);
    }

    
    function Html_Input_Color($name,$value="",$options=array())
    {
        $options[ "TYPE" ]='color';
        $options[ "NAME" ]=$name;

        if (empty($value))
        {
            $value="#FFFFFF"; //white
        }
        
        //value is hexadecima representation of RGB color array
        $options[ "VALUE" ]=$value;

        
        return $this->Html_Tag("INPUT",$options);
    }
}

?>
