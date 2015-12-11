<?php


trait Html_Table
{
    function Html_Table_Width($table)
    {
        $ncells=0;
        foreach ($table as $id => $row)
        {
            $rncells=1;
            if (is_array($row)) { $rncells=count($row); }
            
            $ncells=$this->Max($rncells,$ncells);
        }

        return $ncells;
    }
    
    function Html_Table_Cell($cell,$options=array())
    {
        return $this->Html_Tags("TD",$cell,$options);
    }
    
    function Html_Table_Row($row,$troptions=array(),$tdoptions=array())
    {
        $html="";
        foreach ($row as $id => $cell)
        {
            $html.=$this->Html_Table_Cell($cell,$tdoptions);
        }

        return $this->Html_Tags("TR",$html,$troptions);
    }
    
    function Html_Table($table,$toptions=array(),$troptions=array(),$tdoptions=array())
    {
        $width=$this->Html_Table_Width($table);
        
        $html="";
        foreach ($table as $id => $row)
        {
            if (!is_array($row))
            {
                $tdoptions[ "COLSPAN" ]=$width;
                $row=array($this->Html_C($row));
            }
            elseif (count($row)==1)
            {
                $tdoptions[ "COLSPAN" ]=$width;
            }
            
            $html.=$this->Html_Table_Row($row,$troptions,$tdoptions);
        }
        
        return $this->Html_Tags("TABLE",$html,$toptions);
    }
    
    function Html_Frame($text,$options=array(),$troptions=array(),$tdoptions=array())
    {
        if (empty($options[ "BORDER" ])) { $options[ "BORDER" ]=1; }
        
        return $this->Html_Table(array(array($text)),$options,$troptions,$tdoptions);
        
    }
}

?>
