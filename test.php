<?php

$text = "У дома очень большой двор. Тропинка от дома ведет к клумбам. В саду у дома есть деревья,недавно я сделал(а) к нему скворечник.
Что бы зайти в дом,нужно отпереть ворота. Рядом с домом стоит гараж. Крыша у дома ну очень красивая.
За городом я увидел(а) рядом с домом бассейн. Моя подруга пригласила к себе в дом. В доме три этажа по девять квартир.
Богатые люди строят себе очень красивые и большие дома с садами,басейнами.";

$text = mb_strtolower($text);

$delete = str_replace(["\r\n", "\r", "\n", ".", ","],"", $text);//Удаляем пробелы между слов и другие и перевода каретки

$result = explode(" ", $delete); // разделение слов по пробелу
print_r(array_count_values($result));

$word = count($result); // суммарное число слов

echo "Всего слов = ", $word;
