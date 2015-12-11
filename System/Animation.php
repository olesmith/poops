array
(
   "NI" => array
   (
      "Default" => 200,
      "Type" => "INT",
      "Name" => "No of Intervals",
      "Size" => 3,
      "Code_Links" => array
      (
         "Name" => "Drawing Intervals",
         "Function_Regexp" => '(ParametricCurve)',
      ),
   ),
   "N" => array
   (
      "Default" => 30,
      "Type" => "INT",
      "Name" => "No of Images",
      "Size" => 3,
      "Code_Links" => array
      (
         "Name" => "Images",
         "Function_Regexp" => '(Animation_Clean|Animation_Write_Command)',
      ),
   ),
   "Delay" => array
   (
      "Default" => 5,
      "Type" => "INT",
      "Name" => "Delay",
      "Size" => 3,
   ),
   "Loop" => array
   (
      "Default" => 0,
      "Type" => "INT",
      "Name" => "Loop",
      "Size" => 3,
   ),
   "TrueColor" => array
   (
      "Default" => TRUE,
      "Type" => "BOOL",
      "Name" => "TRUE Color",
    ),
   "Rewrite" => array
   (
      "Default" => TRUE,
      "Type" => "BOOL",
      "Name" => "Rewrite Images",
      "Code_Links" => array
      (
         "Name" => "Rewrite",
         "Function_Regexp" => '(Image_Create|Image_Destroy|Image_Recreate)',
      ),
   ),
);