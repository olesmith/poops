<?php


trait Html_Options
{
    function Html_Options($options=array())
    {
        $text="";
        foreach ($options as $option => $value)
        {
            $text.=" ".strtolower($option)."='".$value."'";
        }

        return $text;
    }
}

?>
