<?php

include_once("Iteration/Image.php");
include_once("Iteration/Menu.php");

trait Animation_Iteration
{
    use Animation_Iteration_Image,Animation_Iteration_Menu;
    
    var $CurveData=array();
    
    function Animation_Iteration_Run($generate,$i,$eta,$t)
    {
        $colorname="Red";
        /* $colorvector=$this->Canvas->ColorCombination */
        /* ( */
        /*    $this->ColorNames, */
        /*    array($eta,1.0-$eta), */
        /*    $colorname */
        /* ); */
        
        $file=$this->Animation_Iteration_Image_Name($i);

        if ($generate)
        {
            $genmethod=$this->Animation[ "Generator" ];
            $lastpoint=$this->$genmethod($t);

            $this->Canvas->Image_Write($file,FALSE);
        
            if ($this->Parm("Rewrite")==1)
            {
                $this->Canvas->Image_Recreate();
            }

            $this->CurveData[$i]=$lastpoint;
        }

        return $file;
    }
    
    function Vector_Show($v)
    {
        foreach (array_keys($v) as $i) { $v[ $i ]=sprintf("%0.2f",$v[ $i ]); }
        
        return "(".join(",",$v).")";
    }
    
    function Animation_Iteration_Info()
    {
        $imgno=$this->Parm("ImageNo");

        $table=array();
        foreach ($this->CurveData as $n => $point)
        {
            if ($n!=$imgno) { $n=$this->Animation_Iteration_Menu_Item($n); }
            
            $row=array
            (
               $n,
               sprintf("%0.2f",$point[ "t" ]),
               $this->Vector_Show($point[ "R" ]),
               $this->Vector_Show($point[ "DR" ]),
               $this->Vector_Show($point[ "D2R" ]),
               sprintf("%0.2f",$point[ "DLength" ]),
               $this->Vector_Show($point[ "T" ]),
               $this->Vector_Show($point[ "N" ]),
               sprintf("%0.2f",$point[ "S" ]),
               sprintf("%0.2f",$point[ "DS" ]),
               sprintf("%0.2f",$point[ "Curvature" ]),
               sprintf("%0.2f",$point[ "Curvature_Radius" ]),
               $this->Vector_Show($point[ "Curvature_Vector" ]),
               $this->Vector_Show($point[ "Curvature_Center" ]),
            );

            array_push($table,$row);
        }

        if (empty($table)) { return ""; }
        
        array_unshift
        (
           $table,
             array
             (
                "[;  I  ;]",
                "[;  t  ;]",
                "[;  \\underline{r}(t)  ;]",
                "[;  \\underline{r'(t)}  ;]",
                "[;  \\underline{r''(t)}  ;]",
                "[;  |\\underline{r'(t)}|  ;]",
                "[;  \\underline{t(t)}  ;]",
                "[;  \\underline{n(t)}  ;]",
                "[;  s(t)  ;]",
                "[;  ds  ;]",
                "[;  \\kappa(t)  ;]",
                "[;  \\rho(t)  ;]",
                "[;  \\underline{V(t)}  ;]",
                "[;  \\underline{C(t)}  ;]",
             )
        );

        return $this->Html_C
            (
               $this->Html_H(3,"Geometry Info").
               $this->Html_Table
               (
                  $table,
                  array("BORDER" => 1),
                  array(),
                  array("ALIGN" => 'center')
               )
            );
    }
}
?>
