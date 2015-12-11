<?php


trait Animation_Iteration_Menu
{
    function Animation_Iteration_Menu_Item($imageno=0)
    {
        $n=$this->Parm("N");
        $n=strlen($n);

        return
            $this->Html_A
            (
               $this->Animation_Iteration_Image_URL($imageno),
               sprintf("%0".$n."d",$imageno)
            );
    }
    
    function Animation_Iteration_Menu()
    {
        $links=array();
        for ($imageno=1;$imageno<=$this->Parm("N");$imageno++)
        {
            array_push
            (
               $links,
               $this->Animation_Iteration_Menu_Item($imageno)
            );
        }
        
        $links=$this->Hash_Page($links,$this->Parm("N")/5);
        
        $html=array();
        foreach ($links as $rlinks)
        {
            if (!empty($rlinks))
            {
                array_push($html,"[ ".join(" | ",$rlinks)." ]");
            }
        }

        return
            $this->Html_C
            (
               join($this->Html_BR(),$html)
            );
    }
    
}
?>
