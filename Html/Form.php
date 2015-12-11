<?php


trait Html_Form
{
    function Html_Form($contents,$url="",$anchor="",$options=array(),$omitargs=array())
    {
        $options[ "METHOD" ]='post';

        if (empty($url))
        {
            $args=array();
            foreach ($_GET as $key => $value)
            {
                if (!preg_grep('/^'.$key.'$/',$omitargs))
                {
                    array_push($args,$key."=".$value);
                }
            }

            $url=join("&",$args);
        }
        
        if (!empty($anchor)) { $anchor="#".$anchor; }
        
        $options[ "ACTION" ]=$url.$anchor;
        
        return
            "<A NAME='FORM'></A>".
            $this->Html_Tags("FORM",$contents,$options);
    }
}

?>
