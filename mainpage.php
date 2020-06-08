<?php
foreach($_GET as $key => $value){
    $id = $value;
}
$pdo = new PDO ('mysql:dbname=mydb;host=localhost:3306', 'root','root');
$selectQueryWords = 'SELECT * FROM words';
$selectQueryUploaded_text = 'SELECT * FROM uploaded_text';
$RowUploaded_text = $pdo -> query($selectQueryUploaded_text) -> fetch(PDO::FETCH_ASSOC);
$allRowUploaded_text = $pdo -> query($selectQueryUploaded_text) -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset = "utf-8"/>
    <title>Main</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <table  cellpadding="5" border="2" align="center" bordercolor="blue">
            <thead bgcolor="#B0E0E6">
            <tr>
                <td>ID</td>
                <td>Content</td>
                <td>Details</td>
            </tr>
            </thead>

            <tbody>
            <?php foreach($allRowUploaded_text as $RowUploaded_text) {?>
                <tr>
                    <td><?= $RowUploaded_text['ID']?></td>
                    <td><?php $string = substr($RowUploaded_text['content'], 0, 100);
                        $string = rtrim($string, "!,.-");
                        $string = substr($string, 0, strrpos($string, ' '));?>

                        <?= $string,"..."?></td>
                    <td><?= $RowUploaded_text['date']?></td>
                    <td><a href="details.php?ID=<?= $RowUploaded_text['ID']?>">Click</a></td>
                </tr>
            <?php }?>
            </tbody>
            <br>
        </table>
    </form>
    <form action="/details.php" target="_blank">
        <button>Детали</button>

    </form>
    <form action="/index.php" target="_blank">
        <button>Загрузка</button>
    </form>
</body>
</html>

