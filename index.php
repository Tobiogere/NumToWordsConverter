<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="POST">

        <input type="number" name="number" placeholder="Input Number"><br><br>
        <button type="submit">Convert</button>

    </form>

    <?php
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num = $_POST["number"];

            $ones = [
                "0" => "zero", "1" => "one", "2" => "two", "3" => "three", "4" => "four", "5" => "five",
                "6" => "six", "7" => "seven", "8" => "eight", "9" => "nine"
            ];

            $teens = [
                "10" => "ten", "11" => "eleven", "12" => "twelve", "13" => "thirteen", "14" => "fourteen",
                "15" => "fifteen", "16" => "sixteen", "17" => "seventeen", "18" => "eighteen", "19" =>
                "nineteen"
            ];
            
            $tens = [
                "1" => ["three_digits" => "one hundred", "four_digits" => "one thousand"],
                "2" => ["two_digits" => "twenty", "three_digits" => "two hundred", "four_digits" => "two thousand"],
                "3" => ["two_digits" => "thirty", "three_digits" => "three hundred", "four_digits" => "three thousand"], 
                "4" => ["two_digits" => "forty", "three_digits" => "four hundred", "four_digits" => "four thousand"], 
                "5" => ["two_digits" => "fifty", "three_digits" => "five hundred", "four_digits" => "five thousand"], 
                "6" => ["two_digits" => "sixty", "three_digits" => "six hundred", "four_digits" => "six thousand"], 
                "7" =>["two_digits" => "seventy", "three_digits" => "seven hundred", "four_digits" => "seven thousand"], 
                "8" => ["two_digits" => "eighty", "three_digits" => "eight hundred", "four_digits" => "eight thousand"], 
                "9" => ["two_digits" => "ninety", "three_digits" => "nine hundred", "four_digits" => "nine thousand"] 
            ];
            // if ($num == 0){
            //         echo $ones[$num];
            //         return;
            //     }

            function convertTowords($num){
                global $ones, $teens, $tens;
                //two digits
                if ($num < 10) {
                    echo $ones[$num];
                } elseif($num < 20 ){
                    echo $teens[$num];
                } elseif($num < 100) {
                    $tens_num = floor($num / 10);
                    $whole = $tens[$tens_num]["two_digits"];
                    //echo $whole;
                    $remain = ($num % 10);
                    if($remain == 0) {
                        echo $whole;
                        return;
                    }
                    $units = $ones[$remain];
                    
                    echo $whole . " " . $units;

                    //three digits
                } elseif($num < 1000){
                    $tens_num = floor($num / 100);
                    $whole = $tens[$tens_num]["three_digits"];
                    $remain = ($num % 100);
                    if($remain == 0) {
                        echo $whole;
                        return;
                    }
                    if($remain < 10){
                        $units = $ones[$remain];
                    } elseif($num < 20){
                        $units = $teens[$remain];
                    } else{
                        $tens_part = floor($remain / 10);
                        $ones_part = $remain % 10;

                        if(isset($tens[$tens_part]["two_digits"])){
                            $tens_word = $tens[$tens_part]["two_digits"];
                        } else {
                            $tens_word = "";
                        }
                        if(isset($ones[$ones_part])) {
                            $ones_word = $ones[$ones_part];
                        } else{
                            $ones_word = "";
                        } 
                        $units = $tens_word . " " . $ones_word;
                    }
                    
                    echo $whole . " " . "and" . " " . $units;

                    //four digits
                }  elseif($num < 1000000) {
                    $thousand = floor($num / 1000);
                    $remain = ($num % 1000);

                    //e.g 5000
                    if($thousand < 10){
                        $thousand_part = $tens[$thousand]["four_digits"];
                        echo $thousand_part;
                        return;
                        //e.g 15,000
                    } elseif($thousand < 20){
                        $thousand_part = $teens[$thousand] . " thousand";
                        echo $thousand_part;
                        if ($remain == 0) return;
                        // e.g 53,000
                    } elseif($thousand < 100){
                        //WHOLE NUMBER part
                        $tens_part = floor($thousand / 10);
                        $ones_part = $thousand % 10;
                        
                        
                        if(isset($tens[$tens_part]["two_digits"])){
                            $tens_word = $tens[$tens_part]["two_digits"];
                        } else{
                            $tens_word = "";
                        }
                        if($ones_part == 0) {
                        echo $tens_word . " thousand";
                        return;
                        }
                        if(isset($ones[$ones_part])) {
                            $ones_word = $ones[$ones_part] .  " thousand";
                        } else{
                            $ones_word = "";
                            echo $tens_word . " " . $ones_word;
                            return;
                        } 
                        //$whole = $tens_word . " " . $ones_word;
                    } else {
                        // Example: 535000 → "five hundred thirty-five thousand"
                        $hundreds = floor($thousand / 100);
                        $tens_ones = $thousand % 100;

                        $hundreds_word = isset($tens[$hundreds]["three_digits"]) ? $tens[$hundreds]["three_digits"] : "";

                        if ($tens_ones == 0) {
                            $thousand_part = $hundreds_word . " thousand";
                            echo $thousand_part;
                            return;
                        } elseif ($tens_ones < 10) {
                            $thousand_part = $hundreds_word . " and " . $ones[$tens_ones] . " thousand";
                            echo $thousand_part;
                            return;
                        } elseif ($tens_ones < 20) {
                            $thousand_part = $hundreds_word . " and " . $teens[$tens_ones] . " thousand";
                            echo $thousand_part;
                            return;
                        } else {
                            $tens_part = floor($tens_ones / 10);
                            $ones_part = $tens_ones % 10;

                            $tens_word = isset($tens[$tens_part]["two_digits"]) ? $tens[$tens_part]["two_digits"] : "";
                            $ones_word = isset($ones[$ones_part]) ? $ones[$ones_part] : "";

                            $thousand_part = $hundreds_word . " and " .$tens_word . " " . $ones_word . " thousand";
                            echo $thousand_part;
                            return;
                        }

                        
                    if($remain == 0) {
                        echo $thousand_part;
                        return;
                    }
                    //REMAINDER PART
                    if($remain < 10){
                        $units = $ones[$remain];
                        echo $thousand_part . " " . $units;
                        return;
                    } elseif($remain < 20){
                        $units = $teens[$remain];
                        echo $thousand_part . " " . $units;
                        return;
                    } elseif($remain < 100){
                        //e.g 5035/1000 = 5.035
                        $tens_part = floor($remain / 10);
                        $ones_part = $remain % 10;

                        if(isset($tens[$tens_part]["two_digits"])){
                            $tens_word = $tens[$tens_part]["two_digits"];
                        } else {
                            $tens_word = "";
                        }
                        if(isset($ones[$ones_part])) {
                            $ones_word = $ones[$ones_part];
                            $units = $tens_word . " " . $ones_word;
                            echo $thousand_part . " " . $units;
                            return;
                        } else{
                            // Example: 924 → "nine hundred and twenty-four"
                            $hundreds = floor($remain / 100);
                            $tens_ones = $remain % 100;

                            $hundreds_word = isset($tens[$hundreds]["three_digits"]) ? $tens[$hundreds]["three_digits"] : "";

                            if ($tens_ones == 0) {
                                $units = $hundreds_word;
                            } elseif ($tens_ones < 10) {
                                $units = $hundreds_word . " and " . $ones[$tens_ones];
                                echo $units;
                                return;
                            } elseif ($tens_ones < 20) {
                                $units = $hundreds_word . " and " . $teens[$tens_ones];
                                echo $units;
                                return;
                            } else {
                                $tens_part = floor($tens_ones / 10);
                                $ones_part = $tens_ones % 10;

                                $tens_word = isset($tens[$tens_part]["two_digits"]) ? $tens[$tens_part]["two_digits"] : "";
                                $ones_word = isset($ones[$ones_part]) ? $ones[$ones_part] : "";

                                $units = $hundreds_word . " and " . $tens_word . " " . $ones_word;
                                echo $units;
                                return;
                            }
                        }
                    }


                        //echo $thousand_part . " " . $units;
                        //return;
                    }
                }
            }
            convertTowords($num);
        }
    
    ?>



</body>
</html>