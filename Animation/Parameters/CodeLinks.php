<?php


trait Animation_Parameters_CodeLinks
{
    function Animation_Parameters_CodeLink_Link($parameter)
    {
        $codelinks=$this->Parms[ $parameter][ "Code_Links" ];
        
        $args=array();
        $args[ "Animation" ]=$this->AnimationName;
        $args[ "ImageNo" ]=$this->Parm("ImageNo");
        $args[ "NoGen" ]=1;
        $args[ "Code_Links" ]=$parameter;

        $url=
            "?".
            $this->Animation_Parameters_Get($args).
            "#Code";

        return $this->Html_A($url,$codelinks[ "Name" ]);


    }
    
    function Animation_Parameters_CodeLink_Command($parameter)
    {
        $codelinks=$this->Parms[ $parameter][ "Code_Links" ];
        $command="/usr/local/bin/ff . function ".$codelinks[ "Function_Regexp" ];
        foreach (array('\[','\]','\(','\)','\|') as $key)
        {
            $command=preg_replace('/'.$key.'/',"\\".$key,$command);
        }
            
        return $command;
    }
    
    function Animation_Parameters_CodeLink_Hit($hit)
    {
        $html=$hit;

        $file="";
        $line="";
        if (preg_match('/^(\S+)/',$hit,$matches))
        {
            $file=$matches[1];            
        }
        
        if (preg_match('/Line\s+(\d+)/',$hit,$matches))
        {
            $line=$matches[1];            
        }

        $file=preg_replace('/,$/',"",$file);
        $lines=file($file);

        
        $start=$line-1;
        $end=$line+1;

        //Search backward through eventual comments
        while ($start>0)
        {
            $rline=preg_replace('/\/\/.*/',"",$lines[ $start-1 ]);
            
            if (preg_match('/\S/',$rline)) { break; }
            
            $start--;
        }

        //Search foreward until next function
        while ($end<count($lines))
        {
             $rline=preg_replace('/\/\/.*/',"",$lines[ $end-1 ]);
             
             if (preg_match('/function /',$rline)) { break; }
             $end++;
        }

        $html="";
        for ($n=$start;$n<$end-1;$n++)
        {
            $html.=$lines[$n];
        }
        
        $n=$line;
        
        //$html=preg_replace('/^\s+/',"",$html);
        $html=preg_replace('/\s+$/',"",$html);

        return
            '//*** '.
            $file.", Line ".$line.":".
            '***//'."\n\n".
            $html."\n\n";
    }
    
    function Animation_Parameters_CodeLink_Hits($codelinks)
    {
        $command="/usr/local/bin/ff . function ".$codelinks[ "Function_Regexp" ];

        foreach (array('\[','\]','\(','\)','\|') as $key)
        {
            $command=preg_replace('/'.$key.'/',"\\".$key,$command);
        }
            
        $hits=$this->System_Pipe($command);
        $hits=preg_split('/\n/',$hits);
        $hits=preg_grep('/Line/',$hits);
        $hits=preg_grep('/function/',$hits);

        $html="";
        foreach ($hits as $hit)
        {
            $html.=
                $this->Animation_Parameters_CodeLink_Hit($hit).
                "\n\n";
                ;
        }

        return
            $this->Html_H
            (
               2,
               "Show me the Code:"
            ).
            $this->Html_H
            (
               4,
               "Functions, ".$codelinks[ "Name" ].", ".
               "Regexp: ".
               $this->Html_Input_Text
               (
                  "Regexp",
                  $codelinks[ "Function_Regexp" ],
                  array
                  (
                     "SIZE" => strlen($codelinks[ "Function_Regexp" ]),
                  )
               ).
               $this->Html_Button_Send("GO")
            ).
            $this->Html_BR().
            $this->Html_Tags("TEXTAREA",$html,array("DISABLED" => "","COLS" => 100,"ROWS" => 20)).
            "";
    }
}

?>
