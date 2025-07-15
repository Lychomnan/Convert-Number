<?php
function convertNumberToWords($number) {
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number));
}

function convertToKhmerWords($number) {
    $khmerDigits = ["", "មួយ", "ពីរ", "បី", "បួន", "ប្រាំ", "ប្រាំមួយ", "ប្រាំពីរ", "ប្រាំបី", "ប្រាំបួន"];
    $units = ["", "ដប់", "រយ", "ពាន់", "ម៉ឺន", "សែន", "លាន"];
    $numStr = strrev((string)$number);
    $khmerWord = "";
    for ($i = 0; $i < strlen($numStr); $i++) {
        $digit = (int)$numStr[$i];
        if ($digit == 0) continue;
        $word = $khmerDigits[$digit] . ($units[$i] != "" ? " " . $units[$i] : "");
        $khmerWord = $word . " " . $khmerWord;
    }
    return trim($khmerWord) . " រៀល";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $riel = $_POST["riel"];
    $usd = round($riel / 4000, 2);
    $englishWords = convertNumberToWords($riel) . " Riels";
    $khmerWords = convertToKhmerWords($riel);

    // Save to text file
    $log = "Input: $riel Riels | English: $englishWords | Khmer: $khmerWords | USD: $usd $\n";
    file_put_contents("conversion_log.txt", $log, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Result</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="container">
        <h2>Conversion Result</h2>
        <div class="result">
            <span class="red"><strong>Input Riel:</strong> <?= $riel ?> ៛</span>
            <span class="blue"><strong>English:</strong> <?= $englishWords ?></span>
            <span class="green"><strong>Khmer:</strong> <?= $khmerWords ?></span>
            <span class="purple"><strong>USD:</strong> <?= $usd ?> $</span>
        </div>
        <br>
        <a href="index.html" style="color: #0cf;">← Go back</a>
    </div>
    </body>
</html>
