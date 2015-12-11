<?php

include_once("Hash.php");
include_once("Animations.php");
include_once("Animation/Parameters.php");
include_once("Animation/Iteration.php");
include_once("Animation/Command.php");

class Animation extends Animations
{
    use Html,Hash;
    use Animation_Parameters,Animation_Iteration,Animation_Command;
    
    var $ParmGroups=array();
    var $Parms=array();
    var $ParmsValues=array();
    
    var $ColorNames=array("Red","Green");

    var $Images_OutPath="";
    var $Images_Format="png";
    var $Images_Destroy=FALSE;
    
    var $Animation_Format="gif";
    
    var $System="System";
    var $AnimationsDir="Animations";
    var $Animations=array();
    var $AnimationName="";
    var $Animation=array();

    var $Commands=array();
    var $Animation_Top="Top.html";
    
    
    function Animation($args=array(),$runargs=array())
    {
        foreach ($args as $key => $value)
        {
            $this->$key=$value;
        }


        $this->Animations_Read();        
        $this->Animation_Parameters_Init();
        
        $this->Animation_Init_Canvas();

        
        $this->Initialize();

        $this->Animation_Run();
    }
    
    function Animations_Read()
    {
        $this->Animations=$this->Dir_Subdirs($this->System."/".$this->AnimationsDir,"",FALSE);

        if (empty($this->Animations)) { die("No animations in Systems path."); }
            
        sort($this->Animations);

        $this->AnimationName=$this->Animations[0];
        if (!empty($_GET[ "Animation" ])) { $this->AnimationName=$_GET[ "Animation" ]; }
        
        $this->Images_OutPath="tmp/".$this->AnimationName;
    }
    
    function Animations_Menu()
    {
        $hrefs=array();
        foreach ($this->Animations as $animation)
        {
            $href=$this->Html_A("?Animation=".$animation,$animation);
            array_push($hrefs,$href);
        }

        return
            $this->Html_C("[ ".join(" | ",$hrefs)." ]");
        
    }
    
            
    function Animation_Init_Canvas()
    {
        $this->Canvas=new Canvas
        (
           array
           (
              "Parent" => $this,
            )
         );
    }
    
    function Animation_Name()
    {
        return $this->Animation[ "Name" ];
    }
    function Animation_Title()
    {
        return $this->Animation[ "Title" ];
    }
    
    function Animation_Html_Top()
    {
        return join("",file($this->Animation_Top));
    }
    
    function Animation_Write_Info()
    {
        $file=$this->System."/".$this->AnimationsDir."/".$this->Animation[ "Info" ];

        $text="";
        if (file_exists($file))
        {
            $text=
              join("",file($file)).
              "<P>".
                "<U>GreaseMonkey:</U> [; \LaTeX ;] on webpages\n".
                "<A HREF='http://www.greasespot.net/'><IMG SRC='icons/greasemonkey.png'></A>";
        }

        return $this->Html_C($text);
    }

    function Animation_GIF_Name()
    {
        return $this->Images_OutPath.".".$this->Animation_Format;
    }

    function Animation_GIF_Write($generate,$files)
    {
        if ($generate)
        {
            $this->Animation_Write_Command_Run($files);
        }

        return $this->Animation_GIF_Name();
    }

    function Animation_GIF_Size()
    {
        return filesize($this->Animation_GIF_Name());
    }

    function Animation_GIF_Title()
    {
        return "GIF Animado, ".$this->Animation_GIF_Name().": ".filesize($this->Animation_GIF_Name())." bytes";
    }

       
    
    function Animation_Run()
    {
        $time=time();
        
        echo
            $this->Html_Open().
            $this->Animation_Html_Top().
            $this->Animations_Menu().
            $this->Html_H(1,$this->Animation_Title()).
            $this->Html_C
            (
               "[ <A HREF='#Form'>Parameters</A>".
               "[ <A HREF='#Animation'>Animation</A>".
               "[ <A HREF='#Image'>Iteration Image</A>".
               "[ <A HREF='#Math'>Math</A>".
               "[ <A HREF='#Numerical'>Numerical</A>".
               "[ <A HREF='#Commands'>Commands</A>".
               ""
            ).
            $this->Animation_Parameters_Form().
            "<A NAME='Animation'></A>".
            "";
        
        $nn=$this->Parm("N")+1;
        
        $dt=($this->Parm("T2")-$this->Parm("T1"))/(1.0*($nn-1));
        $deta=1.0/(1.0*$nn);

        $t=$this->Parm("T1");
        $eta=0.0;

        $generate=TRUE;
        if (!empty($_GET[ "NoGen" ])) { $generate=FALSE; }

        if ($generate)
        {
            $this->Animation_Clean();
        }
        
        $files=array();
        for ($i=0;$i<$nn;$i++)
        {
            array_push
            (
               $files,
               $this->Animation_Iteration_Run($generate,$i,$eta,$t)
            );
            
            $t+=$dt;
            $eta+=$deta;
        }

        echo
            $this->Html_H(1,$this->Animation_Title().": GIF Animado").
            $this->Html_C
            (
                  $this->Canvas->Image_Show
                  (
                     $this->Animation_GIF_Write($generate,$files),
                     array
                     (
                        "TITLE" => $this->Animation_GIF_Title()
                     )
                  )
            ).
            $this->Animation_Iteration_Image_Show().
            "<A NAME='Math'></A>".
            $this->Animation_Write_Info().
            "<A NAME='Numerical'></A>".
            $this->Animation_Iteration_Info().
            "<A NAME='Commands'></A>".
            $this->Animation_Commands_Show();

        $time=time()-$time;

        echo
            "(Execution time: ".($time)." seconds)".
            $this->Html_BR().
            $this->Html_Close().
            "";

        
        if ($generate)
        {
            $this->Animation_Parameters_Save();
        }
    }
}
?>
