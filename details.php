<?php
foreach($_GET as $key => $value){
    $id = $value;
}


$pdo = new PDO ('mysql:dbname=mydb;host=localhost:3306', 'root','root');
$selectQueryWords = 'SELECT `word`,`count`,`text_id` FROM `words` WHERE text_id = :id';
$selectQueryWordsDB = $pdo -> prepare($selectQueryWords);
$selectQueryWordsDB -> execute(['id' => $id]);
$selectQueryWords = $selectQueryWordsDB -> fetchAll(PDO::FETCH_ASSOC);

$selectQueryUploaded_text = 'SELECT `ID`,`content`,`words_count` FROM `uploaded_text` WHERE `ID` =:id';
$selectQueryUploaded_textDB = $pdo -> prepare($selectQueryUploaded_text );
$selectQueryUploaded_textDB -> execute(['id' => $id]);
$selectUploaded_text = $selectQueryUploaded_textDB -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset = "utf-8"/>
    <title>Details</title>
</head>
<body>

<form action="/mainpage.php" target="_blank">
    <button>На главную</button><br>
</form>

<form method="post" enctype="multipart/form-data">
    <table cellpadding="5" border="2" align="center" bordercolor="blue" >
        <?php foreach($selectUploaded_text as $RowUploaded_text) {?>
            <tr>
                <td>
                    <?= $RowUploaded_text['content']?>
                </td>
            </tr>

            <tr>
                <td>Всего слов : <?= $RowUploaded_text['words_count']?></td>
            </tr>
        <?php }?>
        <br>
    </table>
</form>

<form method="post" enctype="multipart/form-data">
    <table  cellpadding="5" border="2" align="center" bordercolor="blue">
        <thead bgcolor="#B0E0E6">
        <tr>
            <td>Word</td>
            <td>Count</td>
        </tr>
        </thead>

        <tbody>
        <?php foreach($selectQueryWords as $RowWords) {?>
            <tr>
                <td><?= $RowWords['word']?></td>
                <td><?= $RowWords['count']?></td>
            </tr>
        <?php }?>
        </tbody>
        <br>
    </table>
</form>

</body>

</html>