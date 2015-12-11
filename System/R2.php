array
(
              //Default Min/Max
              "X1" => array
              (
                 "Default" => -0.5,
                 "Type" => "REAL",
                 "Name" => "X1",
                 "Size" => 3,
                 "Code_Links" => array
                 (
                    "Name" => "Scale Image",
                    "Function_Regexp" => '(P2s?Pix)',
                 ),
              ),
              "Y1" => array
              (
                 "Default" => -0.25,
                 "Type" => "REAL",
                 "Name" => "Y1",
                 "Size" => 3,
              ),
              "X2" => array
              (
                 "Default" => 5.0,
                 "Type" => "REAL",
                 "Name" => "X2",
                 "Size" => 3,
              ),
              "Y2" => array
              (
                 "Default" => 1.0,
                 "Type" => "REAL",
                 "Name" => "Y2",
                 "Size" => 3,
              ),
              "Analytical" => array
              (
                 "Default" => FALSE,
                 "Type" => "BOOL",
                 "Name" => "Analytical Derivatives",
                 "Code_Links" => array
                 (
                    "Name" => "Derivatives",
                    "Function_Regexp" => '(Df|DR|D2R|DR2_Normal|DR2_Tangent|Curvature)',
                 ),
              ),
);