<?php
// Pobieranie danych z pliku CSV za pomocą URL.
$url = 'https://gist.githubusercontent.com/miisieq/379bb51bb376b2fd597d19281a7bbff6/raw/573dd374139cc72ffb555fef80af8263d2d26cd2/php_internship_data.csv';
$csvData = file_get_contents($url);
$dataArray = []; // Tablica będzie posiadać przetworzone dane.
$explodeCsvDataArray = explode("\n", $csvData); // Rozdzielenie danych na tablice, które będą posiadały imię i datę.
foreach ($explodeCsvDataArray as $element) { 
    $row = str_getcsv($element); // Rozdzielenie wartości imion i dat na osobne elementy tablicy.
    $dataArray[] = $row; // Dodanie przetworzonych danych do tablicy.
}
$namesArray = array_column($dataArray, 0); // Wstawienie wszystkich imion do nowej tablicy.
$formatedNamesArray = array_replace($namesArray,array_fill_keys(array_keys($namesArray, null),'')); // Zmienienie występujących wartości null na '' aby uniknąć błędów.
$countedNamesArray = array_count_values($formatedNamesArray); // Zliczenie wystąpień imion.
arsort($countedNamesArray); // Sortowanie tablicy malejąco.
$topNamesArray = array_slice($countedNamesArray, 0, 10, true); // Pobranie 10 najczęściej występujących imion do nowej tablicy.
// Wyświetlenie TOP 10 imion.
echo "TOP 10 IMION <br>";
foreach ($topNamesArray as $name => $count) {
    echo mb_convert_case($name, MB_CASE_TITLE, "UTF-8") . ': ' . $count . ' wystąpień' . "<br>"; 
}

// Zadanie dodatkowe
$datesArray = array_column($dataArray, 1); // Pobranie wszystkich dat do tablicy.
$filteredDatesArray = array_filter($datesArray, function ($date) {
    return intval(substr($date, 0, 4)) >= 2000; // Wstawienie do nowej tablicy wszystkich dat, dla osób urodzonych od 1 stycznia 2000.
});
$countedDatesArray = array_count_values($filteredDatesArray); // Zliczenie wystąpień dat.
arsort($countedDatesArray); // Sortowanie tablicy malejąco.
$topDatesArray = array_slice($countedDatesArray, 0, 10, true); // Pobranie 10 najczęściej powtarzających się dat.
// Wyświetlenie TOP 10 dat.
echo "<br>TOP 10 DAT <br>";
foreach ($topDatesArray as $date => $count) {
    echo  date("d.m.Y", strtotime($date)) . ': ' . $count . ' wystąpień' . "<br>";
}
