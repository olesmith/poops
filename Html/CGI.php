<?php


trait Html_CGI
{
    function Html_CGI_Parm($parameter)
    {
        if (isset($this->ParmsValues[ $parameter ])) { return $this->ParmsValues[ $parameter ]; }
        
        $value="";
        if (!empty($this->Parms[ $parameter ][ "Default" ])) {$value=$this->Parms[ $parameter ][ "Default" ]; }
        
        if (isset($_POST[ $parameter ]))
        {
            $value=$_POST[ $parameter ];
        }
        elseif (isset($_GET[ $parameter ]))
        {
            $value=$_GET[ $parameter ];
        }
        elseif (isset($_COOKIE[ $parameter ]))
        {
            $value=$_COOKIE[ $parameter ];
        }

        if ($this->Parms[ $parameter ][ "Type" ]=="REAL")
        {
            //$value=floatval($value);
        }
        elseif ($this->Parms[ $parameter ][ "Type" ]=="INT")
        {
            //$value=intval($value);
        }
        
        if ($this->Parms[ $parameter ][ "Type" ]=="COLOR")
        {
            //Can't have # in GET parameters. Restore
            if (!preg_match('/^#/',$value))
            {
                $value="#".$value;
            }

            //$this->Canvas->ColorAllocate($value,$value);
        }
        
        $this->ParmsValues[ $parameter ]=$value;

        return $value;
    }

    function Html_CGI_Hash2GET($hash)
    {
        $gets=array();
        foreach ($hash as $key => $value)
        {
            //Can't have # in GET parameters
            $value=preg_replace('/^#/',"",$value);
            array_push($gets,$key."=".$value);
        }

        return join("&",$gets);
    }
}

?>
