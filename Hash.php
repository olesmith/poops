<?php


trait Hash
{
    function Hash_Page($list,$nitems,$leadingrows=array())
    {
        $lists=array(array());
        $nlists=0;
        foreach ($list as $item)
        {
            //if (!isset($lists[ $nlists ])) { $lists[ $nlists ]=array(); }

            array_push($lists[ $nlists ],$item);
            if (count($lists[ $nlists ])>=$nitems)
            {
                $nlists++;
                $lists[ $nlists ]=array();
            }
        }

        foreach ($lists as $id => $list)
        {
            array_splice($lists[ $id ],0,0,$leadingrows);
        }

        return $lists;
    }
    
    function Hash_Read_PHP($file,&$rhash=array())
    {
        if (!file_exists($file))
        {
            die("ReadPHPHash: No such file: $file");
        }

        $text=file($file);
        $text=preg_grep('/(<<<<<|>>>>>|======)/',$text,PREG_GREP_INVERT);

        $text=preg_replace('/<\?php/',"",$text);
        $text=preg_replace('/\?>/',"",$text);

        if (!eval('$hash='.join("",$text).";\nreturn 1;"))
        {
            $text=preg_replace('/\n/',"<BR>",$text);

            echo "Error from eval of file: ".$file."<BR>".join("",$text);
            exit();
        }

        if (is_array($rhash))
        {
            foreach ($rhash as $key => $value)
            {
                if (empty($hash[ $key ])) { $hash[ $key ]=$value; }
            }
        }

        return $hash;
    }
    
    function Dir_Subdirs($path,$regex='',$includepath=TRUE)
    {
        $files=array();
        if ($DH = opendir($path))
        {
            while (false !== ($file = readdir($DH)))
            {
                if ($file!=".." && $file!=".")
                {
                    $fname=join("/",array($path,$file));
                    if (is_dir($fname) && preg_match('/'.$regex.'/',$file))
                    {
                        if ($includepath) { array_push($files,$fname); }
                        else              { array_push($files,$file); }
                    }
                }
            }

            closedir($DH);
        }

        return $files;
    }
    
    function System_Pipe($command)
    {
        $handle = popen($command.' 2>&1', 'r');
        $read = fread($handle, 2096);
        pclose($handle);

        return $read;
    }
    
    function File_Write($file,$lines)
    {
        $myfile = fopen($file, "w") or die("Unable to open file: ".$file);
        foreach ($lines as $line)
        {
            fwrite($myfile,$line);
        }
        
        fclose($myfile);
    }
}

?>
