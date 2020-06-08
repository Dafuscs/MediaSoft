<?php
$newfile = $_FILES['file']['name'];
$text_2 = $_POST['description'];

$pdo = new PDO ('mysql:dbname=mydb;host=localhost:3306', 'root','root');

$selectQueryWords = 'SELECT * FROM `words`';
$oneRow = $pdo -> query($selectQueryWords) -> fetch(PDO::FETCH_ASSOC);
$allRow = $pdo -> query($selectQueryWords) -> fetchAll(PDO::FETCH_ASSOC);
$insertQueryWords = 'INSERT INTO 
`word`(`text_id`,`word`,`count`) 
VALUES (?,?,?)';
$insertQueryUploaded_Text = 'INSERT INTO 
`uploaded_text`(`content`,`date`,`words_count`)
VALUES (?,NOW(),?)';
$insertQueryWordsDB = $pdo -> prepare($insertQueryWords);
$insertQueryUploaded_TextDB = $pdo -> prepare($insertQueryUploaded_Text);
$new_file = $_FILES['file']['name'];



function conversion($text){
    $textlow = mb_strtolower($text); //В нижний регистр
    $delete = str_replace(["\r\n", "\r", "\n", ".", ",","?","!"], "", $textlow); //Удаление точек,запятых,переноса строк и тд
    $wordspace = explode(" ", $delete);  // Разделение слов по пробелу
    return ($wordspace);
}


function file_csv($newfile, $insertQueryWordsDB, $insertQueryUploaded_TextDB,$pdo)  //Записывает слова, а так же значения с формы файла в file.csv
{
    $file = file_get_contents($newfile);
    $text = count( explode(' ', $file) );
    $insertQueryUploaded_TextDB ->execute([$file,$text]);
    $wordspace = conversion($file);
    $result = array_count_values($wordspace);

    $text_id = $pdo -> lastInsertId();

    foreach ($result as $word => $count) {
        $insertQueryWordsDB->execute([$text_id,$word, $count]);
    }

}

function textarea_csv($text_2, $insertQueryWordsDB, $insertQueryUploaded_TextDB,$pdo)  //Записывает слова, а так же значения с формы textarea в textarea.csv
{
    $text = count( explode(' ', $text_2) );
    $insertQueryUploaded_TextDB ->execute([$text_2,$text]);
    $wordspace = conversion($text_2);
    $result = array_count_values($wordspace);

    $text_id = $pdo -> lastInsertId();

    foreach ($result as $word => $count) {
        $insertQueryWordsDB->execute([$text_id,$word, $count]);
    }

}

//Проверки
if (!empty($newfile)) {
    file_csv($newfile, $insertQueryWordsDB, $insertQueryUploaded_TextDB,$pdo);
}
if (!empty($text_2)) {
    textarea_csv($text_2, $insertQueryWordsDB, $insertQueryUploaded_TextDB,$pdo);
}
?>
<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset = "utf-8"/>
    <title>Страница Загрузки</title>
</head>
<body>
<form action="/mainpage.php" target="_blank">
    <button>Главная</button>
</form>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" > <br>
    <textarea name="description"></textarea>
    <input type="submit">
</form>
</body>