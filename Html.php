<?php

include_once("Html/Options.php");
include_once("Html/Tagging.php");
include_once("Html/Tags.php");
include_once("Html/Frame.php");
include_once("Html/List.php");
include_once("Html/Table.php");
include_once("Html/Form.php");
include_once("Html/Buttons.php");
include_once("Html/Input.php");
include_once("Html/CGI.php");

trait Html
{
    use
        Html_Options,Html_Tagging,Html_Tags,Html_Frame,Html_List,Html_Table,
        Html_Form,Html_Buttons,Html_Input,Html_CGI;
        
    function Html_Open()
    {
        header('Content-type: text/html');
        header('Content-type: text/html;charset=utf-8');
            
        return
            '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
            $this->Html_Tag("HTML").
            $this->Html_Tags
            (
               "HEAD",
               $this->Html_Tags
               (
                 "TITLE",
                 "Poops Graphics"
               ).
               $this->Html_Tag
               (
                 "LINK",
                 array
                 (
                    "REL" => 'stylesheet',
                    "TYPE" => 'text/css',
                    "HREF" => 'poops.css',
                 )
               )
             ).
            $this->Html_Tag("BODY").
            "";
    }

    function Html_Close()
    {
        return
            $this->Html_Tag_Close("BODY").
            $this->Html_Tag_Close("HTML").
            "";
    }
}

?>
