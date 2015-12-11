array
(
   "ResX" => array
   (
      "Default" => 1200,
   ),
   "ResY" => array
   (
      "Default" => 300,
   ),
   
   "a" => array
   (
      "Default" => 0.25,
      "Type" => "REAL",
      "Name" => "Circle Ratio",
      "Size" => 3,
                 "Code_Links" => array
                 (
                    "Name" => "Trochoid",
                    "Function_Regexp" => '((R|D|D2)_Trochoid)',
                 ),
   ),

   //Curve start init parameters
   "T1" => array
   (
      "Default" => 0.0,
      "Type" => "REAL",
      "Name" => "b1",
      "Size" => 3,
                 "Code_Links" => array
                 (
                    "Name" => "Put Image",
                    "Function_Regexp" => '(Image_DrawImage)',
                 ),
   ),
   "T2" => array
   (
      "Default" => 1.0,
      "Type" => "REAL",
      "Name" => "b2",
      "Size" => 3,
   ),
               
   "NL" => array
   (
        "Default" => 4,
      
        "Type" => "TEXT",
        "Name" => "N. Loops",
        "Size" => 2,
   ),
   "Poop" => array
   (
      "Default" => "",
      "Type" => "TEXT",
      "Name" => "Poop Image",
      "Size" => 10,
                 "Code_Links" => array
                 (
                    "Name" => "Animation",
                    "Function_Regexp" => '(TrochoidsParms|AnimateTrochoids)',
                 ),
   ),
   
   "Color_Center" => array
   (
      "Default" => "#fffff",
      "Type" => "COLOR",
      "Name" => "Center Color",
      "Size" => 10,
   ),
   "Color_Final" => array
   (
      "Default" => "#0000ff",
      "Type" => "COLOR",
      "Name" => "Final Point Color",
      "Size" => 10,
   ),
   "Color_Circle_Rolled" => array
   (
      "Default" => "#0000ff",
      "Type" => "COLOR",
      "Name" => "Circle Rolled",
      "Size" => 10,
   ),
   "Color_Circle_UnRolled" => array
   (
      "Default" => "#ff00ff",
      "Type" => "COLOR",
      "Name" => "Circle Unrolled",
      "Size" => 10,
   ),
   "Color_Vector" => array
   (
      "Default" => "#000000",
      "Type" => "COLOR",
      "Name" => "Vector Color",
      "Size" => 10,
   ),
   "Color_Vector2" => array
   (
      "Default" => "#000000",
      "Type" => "COLOR",
      "Name" => "Vector2 Color",
      "Size" => 10,
                 "Code_Links" => array
                 (
                    "Name" => "Colors",
                    "Function_Regexp" => '(ColorHex2Vector|ColorAllocate|IsBackgroundColor|GetColor)',
                 ),
   ),
);