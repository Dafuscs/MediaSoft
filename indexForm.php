<?php
$newfile =$_FILES ['text']['name'];
$text_2 = $_POST ['description'];
//открываем и создаём копию файла

if (copy($_FILES['text']['tmp_name'],$newfile)){
    echo "Операция прошла успешно" . PHP_EOL;
}
else if (!empty($text_2)){
    echo "Операция прошла успешно" . PHP_EOL;
}
else {
    echo "Возникла ошибка при загрузке" . PHP_EOL;
}

function conversion($text){
    $textlow = mb_strtolower($text);// приводим к нижнему регистру
    $delete = str_replace(["\r\n", "\r", "\n", ".", ","],"", $textlow);//Удаляем пробелы между слов и другие и перевода каретки
    $wordspace = explode(" ", $delete);//разделение слов по пробелу
    return($wordspace);
}

function file_csv($newfile) {
    $text = file_get_contents($newfile);//чтение файла
    $wordspace = conversion($text);
    $result = array_count_values($wordspace);
    $wordcount  = count($wordspace);
    //Создание файла
    mkdir ("texts"); // создание новой директорий
    $extension = 'csv';
    $filename = md5(microtime() . rand(0, 1000));//создание уникального имени каждому файлу
    $file = fopen ( "texts". "/" . $filename . "." . $extension,"w");
    //запись файла
    foreach ($result as $word => $count) {
        fputcsv($file, [$word, $count]);
    }
    fputcsv($file, ['всего слов:', $wordcount]); //Форматирует строку в виде CSV
    fclose($file);// закрытие файла

    //unlink($newfile);
}
function textarea_csv($text_2){

    $wordspace = conversion($text_2);
    $result = array_count_values($wordspace);
    $wordcount = count($wordspace);
    //Создание файла
    mkdir ("texts"); // создание новой директорий
    $extension = 'csv';
    $filename = md5(microtime() . rand(0, 1000));//создание уникального имени каждому файлу
    $file = fopen ( "texts". "/" . $filename . "." . $extension,"w");
    //запись файла
    foreach ($result as $word => $count) {
        fputcsv($file, [$word, $count]);
    }
    fputcsv($file, ['всего слов:', $wordcount]); //Форматирует строку в виде CSV
    fclose($file);// закрытие файла

}
//Проверки
if (!empty($newfile)) {
    file_csv($newfile);
}
if (!empty($text_2)) {
    textarea_csv($text_2);
}

