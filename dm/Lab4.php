<!DOCTYPE html>
<head>  
</head>
<body>
    <form method='post'>
    <?php
        echo "В данной работе вычисляется кратчайший путь в неориентированном графе между двумя вершинами.<br>";
        echo "Вершины в графе нумеруются, начиная с 0 для вершины, от которой мы хотим начать поиск, и идут по порядку.<br>";
        echo "Ввод осуществлять в формате: индесы двух вершин имеющих связь, затем расстояние между ними, каждый элемент разделять пробелом.<br>";
        echo "Введите связанные точки и расстояния между ними, каждая связь с новой строки:<br>";
        $savedvalue1 = isset($_POST['textarea1']) ? $_POST['textarea1'] : '';
        $savedvalue2 = isset($_POST['textarea2']) ? $_POST['textarea2'] : '';
    ?> 
        <textarea id = Textarea11 type="text" name="textarea1" style = 
        "resize: none;
        width: 200px;
        height: 200px;"><?= htmlspecialchars($savedvalue1) ?></textarea><br />
    <?php echo "Введите индекс конечной вершины графа:<br>"; ?>
        <textarea id = Textarea22 rows = "1" type="text" name="textarea2" style = 
        "resize: none;
        height: 20px;
        width: 200px;"><?= htmlspecialchars($savedvalue2) ?></textarea><br />
        <p><button type="submit">Отправить форму</button></p>
        <script>
            var text1 = document.getElementById('Textarea11').value;
            var text2 = document.getElementById('Textarea22').value;
            if (text1)
                if (!/^\d+ *\d+ *\d+((\n)\d+ *\d+ *\d+)*$/.test(text1)) {
                    alert('Неверный формат связей в графе. Необходимый формат:  первая точка, вторая точка, расстояние между точками.');
                }
            if (text2) 
                if (!/^[0-9]*\s*$/s.test(text2)) {
                    alert('Неверно введены искомые точки графа, между которыми надо найти расстояние. Необходимо 2 точки с разделением через пробел.');
                }
        </script>
    </form>
<?php
    function setE($a, $b, $value, $E){
        //установить длину ребра между a и b
        $m = min($a, $b);
        $n = max($a, $b);
        $tempE = array("${m}_${n}" => $value);
        $E = array_merge($E, $tempE);
        return $E;
    }
    function getE($a, $b, $E){
        //получить длину ребра между a и b
        if ($a == $b) return 0;
        $m = min($a, $b);
        $n = max($a, $b);
        return $E["${m}_${n}"];
    }
    function existE($a, $b, $E){
        //возвращает значение true или false, определяет, существует ли связь между данными точками графа
        if ($a == $b) return 0;
        $m = min($a, $b);
        $n = max($a, $b);
        return array_key_exists("${m}_${n}", $E);
    }
    
    $pointsArray = array();
    $massivelines = NULL;
    $importmassive = $_POST[textarea1];
    $importrelation = $_POST[textarea2];
    $massivelines = explode("\n", $importmassive);
    $M = count($massivelines);// кол-во строк
    $start = 0; //индекс начального элемента=значению нач эл-та
    $end = $importrelation;//индекс конечного элемента=значению конечного эл-та
    $E = array();
    $N = count($pointsArray);// кол-во строк
    
    for ($i = 0; $i < $M; $i++)
        $setline[$i] = explode(' ', $massivelines[$i]);

    for ($i = 0; $i < $M; $i++){
        $E = setE($setline[$i][0], $setline[$i][1], $setline[$i][2], $E);
        if (!in_array($setline[$i][0], $pointsArray))
            $pointsArray[] = $setline[$i][0];
        if (!in_array($setline[$i][1], $pointsArray))
            $pointsArray[] = $setline[$i][1];
    }
    

    for ($i = 0; $i < $N; $i++){
        $dmin[$i] = $i == 0 ? 0 : INF;
        $mark[$i] = 0;
    }

    for ($i = 0; $i < $N; $i++){
        $jmin = -1;
        for ($j = 0; $j < $N; $j++)
            if ($mark[$j] == 0 && ($jmin == -1 || $dmin[$j] <= $dmin[$jmin]))
                $jmin = $j;

        $mark[$jmin] = 1;
        if ($jmin == -1) break;
        
        for ($j = 0; $j < $N; $j++)
            if ($mark[$j] == 0 && existE($j, $jmin, $E) && ($dmin[$jmin] + getE($j, $jmin, $E) < $dmin[$j]))
                $dmin[$j] = $dmin[$jmin] + getE($j, $jmin, $E);
    }

    echo "Результат последней работы программы: ";
    echo $dmin[$end];
?>
    
</body>