<?php
    namespace App\NumberToArray;

    class NumberArray
    {
        
        public function CreateArray($array)
        {
            $hour = "08:00";
            $arrayFinal = [];
            foreach ($array as $value) {
                $arrayFinal[$hour] = $value;
                $hour = date("H:i", strtotime($hour) + 30);
            }
            return $arrayFinal;
        }
    }
