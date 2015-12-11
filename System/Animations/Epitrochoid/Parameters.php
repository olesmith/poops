array
(
   "ResX" => array
   (
      "Default" => 800,
   ),
   "ResY" => array
   (
      "Default" => 800,
   ),
   "N" => array
   (
      "Default" => 30,
   ),
   "r1" => array
   (
      "Default" => 3.0,
      "Type" => "REAL",
      "Name" => "Inner Circle Ratio",
      "Size" => 3,
                 "Code_Links" => array
                 (
                    "Name" => "Trochoid",
                    "Function_Regexp" => '((R|D|D2)_Epitrochoid)',
                 ),
   ),
   "r2" => array
   (
      "Default" => 1.0,
      "Type" => "REAL",
      "Name" => "Outer Circle Ratio",
      "Size" => 3,
                 "Code_Links" => array
                 (
                    "Name" => "Animation",
                    "Function_Regexp" => 'Epitrochoid_(Parms|Animate)',
                 ),
   ),
   "d" => array
   (
      "Default" => 0.01,
      "Type" => "REAL",
      "Name" => "Poop Ratio",
      "Size" => 3,
   ),

   "Scale" => array
   (
      "Default" => 1.2,
      "Type" => "REAL",
      "Name" => "Scaling",
      "Size" => 3,
   ),
   "Scale" => array
   (
      "Default" => 1.0,
      "Type" => "REAL",
      "Name" => "Scaling",
      "Size" => 3,
   ),

   //Curve start init parameters
   "T1" => array
   (
      "Default" => 0.0,
      "Type" => "REAL",
      "Name" => "t1",
      "Size" => 3,
      "PostText" => "* 2&pi;",
      "ReadOnly" => TRUE,
   ),
   "T2" => array
   (
      "Default" => 3.0,
      "Type" => "REAL",
      "Name" => "t2",
      "Size" => 3,
      "PostText" => "* 2&pi;",
      "ReadOnly" => TRUE,
   ),
               
   "NL" => array
   (
        "Default" => 1,
      
        "Type" => "TEXT",
        "Name" => "No of Loops",
        "Size" => 2,
   ),
   "Poop" => array
   (
      "Default" => "",
      "Type" => "TEXT",
      "Name" => "Poop Image",
      "Size" => 10,
   ),
   
   "Color_Center" => array
   (
      "Default" => "#ffffff",
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
      "Default" => "#ffffff",
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
   ),
   "Color_Curvature" => array
   (
      "Default" => "#000000",
   ),
);