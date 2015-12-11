<?php

include_once("Html.php");
include_once("Image.php");
include_once("Colors.php");

class Canvas
{
    use Html,Colors,Image;
    
    //*
    //* Variables of Canvas class:
    //*

    var $Parent;
    
    var $Res=array(600,800);
    var $Image=NULL;
    var $Format=NULL;
    
    function Canvas($args=array())
    {
        foreach ($args as $key => $value)
        {
            $this->$key=$value;
        }
        
        $this->Canvas_Init();
    }

    //*
    //* function Canvas_CGI, Parameter list: 
    //*
    //* Reads Canvas from Parms.
    //*

    function Canvas_CGI()
    {
        $this->Res[0]=$this->Parent->Parm("ResX");
        $this->Res[1]=$this->Parent->Parm("ResY");
    }
        
    function Canvas_Init($colors=array())
    {
        $this->Image_Create();
        $this->InitColors($colors);
    }

}
?>
