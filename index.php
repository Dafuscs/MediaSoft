<?php
//открываем и создаём копию файла
$newfile =$_FILES ['text']['name'];
if (copy($_FILES['text']['tmp_name'],$newfile)){
    echo "Операцаия прошла успешно" . PHP_EOL;
}
else {
    echo "Возникла ошибка при загрузке" . PHP_EOL;
}
$text = file_get_contents($newfile); // чтение файла
$text_2 = $_POST ['description'];


//File.csv
$textlow = mb_strtolower($text);// приводим к нижнему регистру
$delete = str_replace(["\r\n", "\r", "\n", ".", ","],"", $textlow);//Удаляем пробелы между слов и другие и перевода каретки
$wordspace = explode(" ", $delete);//разделение слов по пробелу
$wordcount = count($wordspace); // подсчёт кол-ва слов
$result = array_count_values($wordspace);// подсчёт всех значений

$entryword = print_r($result,true);//вывод инфо о переменной


touch ("file.csv"); // создание нового файла
$file = fopen('file.csv','w'); //Открыте файла
//вывод
foreach ($result as $word => $count) {
    fputcsv($file, [$word, $count]);
}
fputcsv($file, ['всего слов:', $wordcount]); //Форматирует строку в виде CSV
fclose($file);// закрытие файла
// перемещение файла
mkdir ("texts"); // создание новой директорий
if (rename('file.csv', 'texts/file.csv')) {
    echo "Файл успешно перемещен!" . PHP_EOL;
}else{
    echo "Файл не удалось переместить!" . PHP_EOL;
}
//unlink($file);
//окончание работы с File.csv

// textarea происходят все те же операции что и выше

$textlow = mb_strtolower($text_2);
$delete = str_replace(["\r\n", "\r", "\n", ".", ","],"", $textlow);
$wordspace = explode(" ", $delete);
$wordcount = count($wordspace);
$result = array_count_values($wordspace);

$entryword = print_r($result,true);

touch ("textarea.csv");
$file = fopen('textarea.csv','w');
//вывод
foreach ($result as $word => $count) {
    fputcsv($file, [$word, $count]);
}
fputcsv($file, ['всего слов:', $wordcount]);
fclose($file);

//перемещение файла
mkdir ("texts"); // создание новой директорий
if (rename("textarea.csv", "texts/textarea.csv")) {
    echo "Файл успешно перемещен!" . PHP_EOL;
}else{
    echo "Файл не удалось переместить!" . PHP_EOL;
}
// окончание работы с textarea

// Проверка загруженного файла
if (!empty($text) && !empty($text_2))
{
    textarea_csv($text_2);
    file_csv($text);

} else if (!empty($text) && empty($text_2)){
    file_csv($text);
}
else if (!empty($text_2) && empty($text)){
    textarea_csv($text_2);
} else
    echo "Текст не найден" . PHP_EOL;
