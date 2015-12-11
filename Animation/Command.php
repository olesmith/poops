<?php


trait Animation_Command 
{
    function Animation_Write_Command($files)
    {
        $loop=$this->Parm("Loop");
        if (empty($loop)) { $loop="0"; }
        
        return
            "/usr/bin/convert ".
            "-loop ".$loop." ".
            "-delay ".$this->Parm("Delay")." ".
            join(" ",$files)." ".
            $this->Images_OutPath.".".$this->Animation_Format;
    }

    function Caller($level=1,$key="function")
    {
        $trace=debug_backtrace();

        return $trace[ $level ][ $key ];
    }
    
    function Animation_System($command,$echo=FALSE)
    {
        $mtime=time();
        $res=system($command);
        $mtime=time()-$mtime;
        
        $msg=$this->Caller(3).", ".$res.": ".$command;

        array_push($this->Commands,$msg.".".$this->Html_BR().$mtime." seconds");
        
        return $res;
    }
    
    function Animation_Write_Command_Run($files)
    {
        return $this->Animation_System($this->Animation_Write_Command($files));
    }


    function Animation_Clean($echo=FALSE)
    {
        //Clean previous
        $this->Animation_System("/bin/rm ".$this->Images_OutPath."/*.".$this->Images_Format,$echo);
        $this->Animation_System("/bin/rm ".$this->Images_OutPath.".".$this->Animation_Format,$echo);
    }
    
    function Animation_Commands_Show()
    {
        return
            $this->Html_Frame
            (
               $this->Html_H(4,"System Commands").
               $this->Html_List(FALSE,$this->Commands),
               array("ALIGN" => 'center',"WIDTH" => '75%')
            );
    }    
}
?>
