<?php


trait R2_Draw
{
    function R2_Draw_Image($fname,$p,$rotate)
    {
        $px=$this->P2Pix($p);
        if (
              isset($px[0])
              &&
              isset($px[1])
           )
        {
            $this->Canvas->Image_DrawImage($fname,$px[0],$px[1],$rotate);
        }
    }
    
    function R2_Draw_Point($p,$color,$npix=2)
    {
        if (empty($p)) { return; }
        
        $px=$this->P2Pix($p);
        if (
              isset($px[0])
              &&
              isset($px[1])
           )
        {
            $this->Canvas->Image_DrawCircle($px[0],$px[1],$npix,$color);
        }
        
    }

    function R2_Draw_Segment($p1,$p2,$color)
    {
        if (empty($p1) || empty($p2)) { return; }
        
        $px1=$this->P2Pix($p1);
        $px2=$this->P2Pix($p2);

        if (
              isset($px1[0])
              &&
              isset($px1[1])
              &&
              isset($px2[0])
              &&
              isset($px2[1])
           )
        {
            $this->Canvas->Image_DrawLine($px1[0],$px1[1],$px2[0],$px2[1],$color);
        }
    }

    
     function R2_Draw_Node($p,$color)
    {
        if (empty($p)) { return; }

        $px=$this->P2Pix($p);
        if (
              isset($px[0])
              &&
              isset($px[1])
           )
        {
            $this->Canvas->Image_DrawCircle($px[0],$px[1],$this->Parm("Draw_Nodes_Scale"),$color);
        }
    }
   
    
    function R2_Draw_Vector($p1,$p2,$color,$eta=0.1)
    {
        //$v=$p2-$p1;
        $v=$this->Vector($p1,$p2);
        
        $n=$this->Vector2_Transverse($v);

        //$pp=$p1+(1-$eta)*$v;
        $pp=$this->Vector_LinComb(1.0,$p1,1.0-$eta,$v);
        
        //$pp1=$pp+-0.5*$eta*$n;
        $pp1=$this->Vector_LinComb(1.0,$pp,  0.5*$eta,$n);
        $pp2=$this->Vector_LinComb(1.0,$pp,-0.5*$eta,$n);

        $this->R2_Draw_Segment($p1,$p2,$color);
        $this->R2_Draw_Segment($p2,$pp1,$color);
        $this->R2_Draw_Segment($p2,$pp2,$color);
    }
    
    function R2_Draw_Circle($p,$r,$color,$n=100,$options=array())
    {
        $this->R2_Draw_Curve
        (
           $this->Circle($p,$r,$n),
           $color,
           $options
        );
    }
    
    function R2_Draw_Curve($ps,$color,$options=array())
    {
        $p1=array_shift($ps);
        
        $px1=$this->P2Pix($p1);

        $drawpoints=$this->Parm("Draw_Nodes");
        $drawpointsscale=$this->Parm("Draw_Nodes_Scale");
        $drawpointscolor=$this->Parm("Color_Nodes");
        if ($drawpoints && !empty($px1))
        {            
            if (
                  isset($px1[0])
                  &&
                  isset($px1[1])
               )
            {
                $this->Canvas->Image_DrawCircle($px1[0],$px1[1],$drawpointsscale,$color);
            }
        }
        
        foreach ($ps as $p2)
        {
            $px2=$this->P2Pix($p2);

            if (
                  isset($px1[0])
                  &&
                  isset($px1[1])
                  &&
                  isset($px2[0])
                  &&
                  isset($px2[1])
               )
            {
                $this->Canvas->Image_DrawLine($px1[0],$px1[1],$px2[0],$px2[1],$color);
            }

            if ($drawpoints && !empty($px2))
            {
                if (
                      isset($px2[0])
                      &&
                      isset($px2[1])
                   )
                {
                    $this->Canvas->Image_DrawCircle($px2[0],$px2[1],$drawpointsscale,$drawpointscolor);
                }
            }
            
            $px1=$px2;
        }
    }
    
    function R2_Draw_Curve_ACS($ps,$ts,$tcolor,$ncolor)
    {
        $acsevery=$this->Parm("Draw_ACS_Every");
        
        $i=0;
        foreach ($ts as $id => $t)
        {
            if ( ($i % $acsevery)==0)
            {            
                $this->R2_Draw_ACS($ps[ $id ],$t,$tcolor,$ncolor);
            }
            
            $i++;
        }
    }
    
    function R2_Draw_ACS($p,$tangent,$tcolor,$ncolor)
    {
        $scale=$this->Parm("Draw_ACS_Scale");
        
        $n=$this->Vector2_Transverse($tangent);
        $ptangent=$this->Vector_LinComb(1.0,$p,$scale,$tangent);

            
        $pnormal=$this->Vector_LinComb(1.0,$p,$scale,$n);
        
        $this->R2_Draw_Vector($p,$ptangent,$ncolor);
        $this->R2_Draw_Vector($p,$pnormal,$tcolor);
    }
    
    function R2_Draw_WCS($color)
    {
        $p1=array(-0.1,0.0);
        $p2=array(1.0,0.0);
        $this->R2_Draw_Vector($p1,$p2,$color,0.0);

        $p1=array(0.0,-0.1);
        $p2=array(0.0,1.0);
        
        $this->R2_Draw_Vector($p1,$p2,$color,0.0);
    }
    
    
    function R2_Draw_Curve_Data($curvedata,$options=array())
    {
        $pdata1=array_shift($curvedata);
        
        $px1=$this->P2Pix($pdata1[ "R" ]);
        
        $acsall=$this->Parm("Draw_ACS_All");
        $acsevery=$this->Parm("Draw_ACS_Every");

        $colors=$this->Animation_Parameters_Colors();
        

        if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Nodes" ])>0)
        {
            $this->R2_Draw_Node($pdata1[ "R" ],$colors[ "Color_Nodes" ]);
        }

        if (
              $this->Canvas->IsNotBackgroundColor($colors[ "Color_Tangents" ])>0
              ||
              $this->Canvas->IsNotBackgroundColor($normalcolor)>0
           )
        {
            $acsall=1; 
        }

        $s=0.0;
                
        $i=0;
        foreach ($curvedata as $pdata2)
        {
            $px2=$this->P2Pix($pdata2[ "R" ]);

            if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Curve" ])>0)
            {
                $this->R2_Draw_Segment($pdata1[ "R" ],$pdata2[ "R" ],$colors[ "Color_Curve" ]);
            }
            
            $px1=$px2;
            if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Nodes" ])>0)
            {
                $this->R2_Draw_Node($pdata2[ "R" ],$colors[ "Color_Nodes" ]);
            }

            if ($acsall>0 && $acsevery>0 && ($i % $acsevery)==0)
            {
                $this->R2_Draw_ACS
                (
                   $pdata2[ "R" ],
                   $pdata2[ "T" ],
                   $colors[ "Color_Normals" ],
                   $colors[ "Color_Tangents" ]
                );

            }

            $max=$this->Parm("X2")-$this->Parm("X1");
            if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Curvature" ])>0)
            {
                if (abs($pdata1[ "Curvature_Radius" ])<$max && abs($pdata2[ "Curvature_Radius" ])<$max)
                {
                    $this->R2_Draw_Segment
                    (
                       $pdata1[ "Curvature_Center" ],
                       $pdata2[ "Curvature_Center" ],
                       $colors[ "Color_Curvature" ]
                    );
                }
            }

            if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Involute" ])>0)
            {
                if (abs($pdata1[ "Involute" ])<$max && abs($pdata2[ "Involute" ])<$max)
                {
                    $this->R2_Draw_Segment
                    (
                       $pdata1[ "Involute" ],
                       $pdata2[ "Involute" ],
                       $colors[ "Color_Involute" ]
                    );
                }
            }

            $s+=$pdata2[ "DS" ];
                   
            $i++;
            $pdata1=$pdata2;
        }

        if ($this->Canvas->IsNotBackgroundColor($colors[ "Color_Oscillating" ]))
        {
            if (abs($pdata1[ "Curvature_Radius" ])<$max)
            {
                $this->R2_Draw_Node
                (
                   $pdata1[ "Curvature_Center" ],
                   $colors[ "Color_Oscillating" ]
                );

                $this->R2_Draw_Curve
                (
                   $this->Arc($pdata1[ "Curvature_Center" ],$pdata1[ "Curvature_Radius" ]),
                   $colors[ "Color_Oscillating" ]
                );
            }
        }
            
     }
    
}
?>
