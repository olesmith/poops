array
(
   "Draw_ACS_Scale" => array
   (
      "Default" => 0.25,
      "Type" => "REAL",
      "Name" => "CCS Scale",
      "Size" => 3,
   ),
   "Draw_Nodes_Scale" => array
   (
      "Default" => 3,
      "Type" => "INT",
      "Name" => "Node Size",
      "Size" => 2,
      "Code_Links" => array
      (
         "Name" => "Nodes",
         "Function_Regexp" => '(R2_Draw_(Point|Node))',
      ),
   ),
   "Draw_Nodes" => array
   (
      "Default" => TRUE,
      "Type" => "BOOL",
      "Name" => "Show Nodes",
   ),
   "Draw_ACS_Last" => array
   (
      "Default" => TRUE,
      "Type" => "BOOL",
      "Name" => "Show CCS, Final",
   ),
   "Draw_ACS_All" => array
   (
      "Default" => FALSE,
      "Type" => "BOOL",
      "Name" => "Show CCS, All",
   ),
   "Draw_ACS_Every" => array
   (
      "Default" => 5,
      "Type" => "INT",
      "Name" => "CCS Every N",
      "Size" => 1,
      "Code_Links" => array
      (
         "Name" => "CCS/WCS",
         "Function_Regexp" => '(R2_Draw_[AW]CS)',
      ),
   ),
   "Involute_Start" => array
   (
      "Default" => 0.01,
      "Type" => "INT",
      "Name" => "Involute Start Const",
      "Size" => 1,
   ),

   
   "Color_Curve" => array
   (
      "Default" => "#ff0000", //red
      "Type" => "COLOR",
      "Name" => "Curve Color",
      "Size" => 10,
   ),
   "Color_Nodes" => array
   (
      "Default" => "#000000", //black - no draw
      "Type" => "COLOR",
      "Name" => "Node Color",
      "Size" => 10,
   ),
   "Color_Tangents" => array
   (
      "Default" => "#000000", //black - no draw
      "Type" => "COLOR",
      "Name" => "Tangents Color",
      "Size" => 10,
   ),
   "Color_Normals" => array
   (
      "Default" => "#000000", //black - no draw
      "Type" => "COLOR",
      "Name" => "Normals Color",
      "Size" => 10,
   ),
   "Color_Curvature" => array
   (
      "Default" => "#ff9900", //orange - draw
      "Type" => "COLOR",
      "Name" => "Evolute Color",
      "Size" => 10,
      "Code_Links" => array
      (
         "Name" => "Evolute",
         "Function_Regexp" => '(Curvature|ParametricCurveData)',
      ),
   ),
   "Color_Oscillating" => array
   (
      "Default" => "#00ff00", //green - draw
      "Type" => "COLOR",
      "Name" => "Oscillating Circle Color",
      "Size" => 10,
   ),
   "Color_Involute" => array
   (
      "Default" => "#000000", //black - no draw
      "Type" => "COLOR",
      "Name" => "Involute Color",
      "Size" => 10,
      "Code_Links" => array
      (
         "Name" => "Involute",
         "Function_Regexp" => '(Involute_Vector|ParametricCurveData)',
      ),
   ),
);