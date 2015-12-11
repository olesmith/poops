<?php


trait Html_Tags
{
    function Html_BR($options=array())
    {
        return
            $this->Html_Tag("BR",$options).
            "";
    }
    
    function Html_HR($options=array())
    {
        return
            $this->Html_Tag("HR",$options).
            "";
    }
    
    function Html_A($url,$content,$options=array())
    {
        $options[ "HREF" ]=$url;
        
        return
            $this->Html_Tags("A",$content,$options).
            "";
    }
    
    function Html_B($content,$options=array())
    {
        return  $this->Html_Tags("B",$content,$options);
    }
    
    function Html_Bs($contents,$options=array())
    {
        $html="";
        foreach ($contents as $id => $content)
        {
            $contents[ $id ]=$this->Html_Tags("B",$content,$options);
        }
        
        return $contents;
    }
    
    function Html_C($content,$options=array())
    {
        return
            $this->Html_Tags("CENTER",$content,$options).
            "";
    }
    
    function Html_H($n,$content,$options=array())
    {
        return
            $this->Html_Tags("H".$n,$content,$options).
            "";
    }
}

?>
