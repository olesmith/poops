<?php

include_once("Parameters/CodeLinks.php");


trait Animation_Parameters
{
    use Animation_Parameters_CodeLinks;
    
    function Parm($parameter)
    {
        return $this->Html_CGI_Parm($parameter);
    }
    
    function Animation_Parameters_Colors()
    {
        $colors=array();
        foreach ($this->Parms as $parameter => $def)
        {
            if ($def[ "Type" ]="COLOR")
            {
                $colors[ $parameter ]=$this->Parm($parameter);
            }
        }
        return $colors;
    }
    
    function Animation_Colors_Parms_Allocate()
    {
        foreach ($this->Parms as $parameter => $def)
        {
            if ($this->Parms[ $parameter ][ "Type" ]=="COLOR")
            {
                $value=$this->Parm($parameter);
                if (!preg_match('/^#/',$value))
                {
                    $value="#".$value;
                }

                $this->Canvas->ColorAllocate($value,$value);
            }
        }
    }
    
    function Animation_Parameters_Init()
    {
        $this->Animation_Parameters_Add($this->System."/Canvas.php");
        $this->Animation_Parameters_Add($this->System."/Animation.php");
        $this->Animation_Parameters_Add($this->System."/R2.php");
        
        $this->Animation_Parameters_Add($this->System."/Draw.php");
                
        $this->Animation_Parameters_Group_Add($this->System."/Canvas.Group.php");
        $this->Animation_Parameters_Group_Add($this->System."/Draw.Group.php");
        $this->Animation_Parameters_Group_Add($this->System."/R2.Group.php",1);
        
        $this->Animation_Parameters_Read($this->AnimationName);
        
        $parmsmethod=$this->Animation[ "Parameters" ];
        $this->$parmsmethod();

        $this->Animation_Init_Canvas();
        $this->Animation_Colors_Parms_Allocate();
        
        $file=$this->Images_OutPath."/Parms.php";
        if (file_exists($file))
        {
            //$this->ParmsValues=$this->Hash_Read_PHP($file);
            //echo "Paramaters from ".$file;
        }
        
    }
    
    function Animation_Parameters_Save()
    {
        $file=$this->Images_OutPath."/Parms.php";

        $lines=array("array\n(");
        foreach ($this->ParmsValues as $key => $value)
        {
            array_push($lines,"   '".$key."' => '".$value."',\n");
        }
        array_push($lines,");\n");
        $this->File_Write($file,$lines);
    }
    
    
    function Animation_Parameters_Read($animation)
    {
        $setupfile=$this->System."/".$this->AnimationsDir."/".$animation."/Setup.php";
        $this->Animation=$this->Hash_Read_PHP($setupfile);
        
        $parmfile=$this->System."/".$this->AnimationsDir."/".$animation."/Parameters.php";
        $this->Animation_Parameters_Add($parmfile);
        
        $groupfile=$this->System."/".$this->AnimationsDir."/".$animation."/Groups.php";
        
        $this->Animation_Parameters_Group_Add($groupfile,1);
    }
    
    function Animation_Parameters_Add($parms)
    {
        if (!is_array($parms)) { $parms=$this->Hash_Read_PHP($parms); }

        foreach ($parms as $parameter => $def)
        {
            if (empty($this->Parms[ $parameter ])) { $this->Parms[ $parameter ]=array(); }

            foreach ($def as $key => $value)
            {
                $this->Parms[ $parameter ][ $key ]=$value;
            }
        }
    }
    
    function Animation_Parameters_Group_Add($groups,$row=0)
    {
        if (!is_array($groups)) { $groups=$this->Hash_Read_PHP($groups); }

        if (!isset($this->ParmGroups[ $row ])) { $this->ParmGroups[ $row ]=array(); }
        
        foreach ($groups as $group => $datas)
        {
            $this->ParmGroups[ $row ]=
                array_merge
                (
                   $this->ParmGroups[ $row ],
                   array($group => $datas)
                );
        }
    }
    
    function Animation_Parameter_Title($parameter)
    {
        return $this->Html_B($this->Parms[ $parameter ][ "Name" ].":");
    }
    
    function Animation_Parameter_PostText($parameter)
    {
        $info="";
        if (!empty($this->Parms[ $parameter ][ "PostText" ]))
        {
            $info=" ".$this->Parms[ $parameter ][ "PostText" ];
        }

        return $info;
    }
    

    function Animation_Parameter_Title_Cell($parameter)
    {
        return
            $this->Html_B
            (
               $this->Animation_Parameter_Title($parameter)
            ).
            "";
    }

    
    function Animation_Parameter_Input($parameter,$options=array())
    {
        if (!empty($this->Parms[ $parameter ][ "ReadOnly" ]))
        {
            return $this->Parm($parameter);
        }
        
        if (!empty($this->Parms[ $parameter ][ "Size" ]))
        {
            $options[ "SIZE" ]=$this->Parms[ $parameter ][ "Size" ];
        }
        
        return $this->Html_Input
        (
           $this->Parms[ $parameter ][ "Type" ],
           $parameter,
           $this->Parm($parameter),
           $options
        );
    }
    
    function Animation_Parameter_Row($parameter)
    {
        return array
        (
           $this->Animation_Parameter_Title_Cell($parameter),
           $this->Animation_Parameter_Input($parameter).
           $this->Animation_Parameter_PostText($parameter),
        );
    }
    
    function Animation_Parameters_Table()
    {
        $table=array();
        foreach ($this->ParmGroups as $id => $row)
        {
                $trow=array();
                foreach ($row as $group => $def)
                {
                    $gtable=array($this->Html_H(2,$group));

                    $hrefs=array();
                    foreach ($def as $parameter)
                    {
                        array_push
                        (
                           $gtable,
                           $this->Animation_Parameter_Row($parameter)
                        );
                        
                        if (!empty($this->Parms[ $parameter ][ "Code_Links" ]))
                        {
                            array_push($hrefs,$this->Animation_Parameters_CodeLink_Link($parameter));
                        }
                    }

                    $html=
                        $this->Html_Table($gtable,array("ALIGN" => 'center')).
                        "";

                    if (!empty($hrefs))
                    {
                        $html.=$this->Html_List("UL",$hrefs);
                    }
                    
                    array_push($trow,$html);
                }
                
                array_push($table,$this->Html_Table(array($trow)));                
        }

        array_push
        (
           $table,
           $this->Html_Buttons()
        );
        
        return $table;
    }
    
    function Animation_Parameters_Table_Html()
    {
        return 
             $this->Html_Table
            (
               $this->Animation_Parameters_Table(),
               array
               (
                  "BORDER" => 1,
                  "ALIGN" => 'center',
               )
            ).
            "";
    }
    
    function Animation_Parameters_Form()
    {
        $table=$this->Animation_Parameters_Table_Html();

        $html=
            $this->Html_Form($table,"?Animation=".$this->AnimationName,"Animation",array(),array("NoGen")).
            "";
        
        if (!empty($_GET[ "Code_Links" ]))
        {
            $parameter=$_GET[ "Code_Links" ];
            $codelinks=$this->Parms[ $parameter][ "Code_Links" ];
            
            if (!empty($_POST[ "Regexp" ]))
            {
                $codelinks[ "Function_Regexp" ]=$_POST[ "Regexp" ];
            }
        
            $html.=
                 "<A NAME='Code'></A>\n".
                 $this->Html_Form
                 (
                     $this->Animation_Parameters_CodeLink_Hits($codelinks),
                     "?Animation=".$this->AnimationName."&NoGen=1&Code_Links=".$parameter,
                     "Code"
                ).
                "";
        }

        return $this->Html_C($html);
    }
    
    function Animation_Parameters_Hash($hash=array())
    {
        foreach ($this->Parms as $parameter => $def)
        {
            $value=$this->Parm($parameter);
            if ($value!=$def[ "Default" ])
            {
                $hash[ $parameter ]=$value;
            }
        }

        return $hash;
    }
    
    function Animation_Parameters_Get($hash=array())
    {
        $hash=array_merge($this->Animation_Parameters_Hash(),$hash);
        
       return
           $this->Html_CGI_Hash2GET($hash);
    }    
}

?>
