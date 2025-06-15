<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="POST">

        <input type="number" name="number" autofocus placeholder="Input Number"><br><br>
        <button type="submit">Convert</button>

    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num = $_POST["number"];

        $ones = [
            "0" => "zero",
            "1" => "one",
            "2" => "two",
            "3" => "three",
            "4" => "four",
            "5" => "five",
            "6" => "six",
            "7" => "seven",
            "8" => "eight",
            "9" => "nine"
        ];

        $teens = [
            "10" => "ten",
            "11" => "eleven",
            "12" => "twelve",
            "13" => "thirteen",
            "14" => "fourteen",
            "15" => "fifteen",
            "16" => "sixteen",
            "17" => "seventeen",
            "18" => "eighteen",
            "19" =>
            "nineteen"
        ];

        $tens = [
            "1" => ["three_digits" => "one hundred", "four_digits" => "one thousand"],
            "2" => ["two_digits" => "twenty", "three_digits" => "two hundred", "four_digits" => "two thousand"],
            "3" => ["two_digits" => "thirty", "three_digits" => "three hundred", "four_digits" => "three thousand"],
            "4" => ["two_digits" => "forty", "three_digits" => "four hundred", "four_digits" => "four thousand"],
            "5" => ["two_digits" => "fifty", "three_digits" => "five hundred", "four_digits" => "five thousand"],
            "6" => ["two_digits" => "sixty", "three_digits" => "six hundred", "four_digits" => "six thousand"],
            "7" => ["two_digits" => "seventy", "three_digits" => "seven hundred", "four_digits" => "seven thousand"],
            "8" => ["two_digits" => "eighty", "three_digits" => "eight hundred", "four_digits" => "eight thousand"],
            "9" => ["two_digits" => "ninety", "three_digits" => "nine hundred", "four_digits" => "nine thousand"]
        ];
        // if ($num == 0){
        //         echo $ones[$num];
        //         return;
        //     }

        function belowThousand($num)
        {
            global $ones, $teens, $tens;
            if ($num < 10) {
                echo $ones[$num];
            } elseif ($num < 20) {
                echo $teens[$num];
            } elseif ($num < 100) {
                $tens_num = floor($num / 10);
                $whole = $tens[$tens_num]["two_digits"];
                //echo $whole;
                $remain = ($num % 10);
                if ($remain == 0) {
                    echo $whole;
                    return;
                }
                $units = $ones[$remain];

                echo $whole . " " . $units;

                //three digits
            } elseif ($num < 1000) {
                $tens_num = floor($num / 100);
                $whole = $tens[$tens_num]["three_digits"];
                $remain = ($num % 100);
                if ($remain == 0) {
                    echo $whole;
                    return;
                }
                //REMAINDER
                if ($remain < 10) {
                    $units = $ones[$remain];
                } elseif ($remain < 20) {
                    $units = $teens[$remain];
                } else {
                    $tens_part = floor($remain / 10);
                    $ones_part = $remain % 10;

                    if (isset($tens[$tens_part]["two_digits"])) {
                        $tens_word = $tens[$tens_part]["two_digits"];
                    } else {
                        $tens_word = "";
                    }
                    if (isset($ones[$ones_part])) {
                        $ones_word = $ones[$ones_part];
                    } else {
                        $ones_word = "";
                    }
                    $units = $tens_word . " " . $ones_word;
                }

                return $whole . " " . "and" . " " . $units;
            }
        }

        // function convertTowords($num){
        //     global $ones, $teens, $tens;
        //two digits


        function aboveThousand($num)
        {
            //global $ones, $teens, $tens;
            if ($num < 1000000) {
                $thousand = floor($num / 1000);
                $remain = ($num % 1000);


                $thousand_word = belowThousand($thousand) . " " . " thousand";
                $remainder_word = belowThousand($remain);
                // echo $thousand_word;
                // echo $remain;
                if ($remain == 0) {
                    // echo $remain;
                    return $thousand_word;
                } else {
                    return $thousand_word . ", " . $remainder_word;
                    // return $thousand_word . $remainder_word;
                }
            }
        }

        function aboveMillion($num)
        {
            if ($num < 1000000000) {
                $million = floor($num / 1000000);
                $remain = ($num % 1000000);
                $million_word = belowThousand($million) . " million";

                if ($remain > 0) {
                    $remainder_word = aboveThousand($remain);
                } else {
                    $remainder_word = "";
                }
                if ($remain == 0) {
                    return $million_word;
                } else {
                    return $million_word . ", " . $remainder_word;
                }
            }
        }
        function convertTowords($num)
        {
            if ($num < 1000) {
                return belowThousand($num);
            } elseif ($num < 1000000) {
                return aboveThousand($num);
            } elseif ($num < 1000000000) {
                return aboveMillion($num);
            } elseif ($num == 1000000000) {
                return " one billion";
            }
        }
        echo convertTowords($num);
    }


    ?>
</body>

</html>