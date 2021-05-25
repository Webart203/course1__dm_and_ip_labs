<!DOCTYPE html>
<head>
</head>
<body>
    <form method = 'post'>
    <?php
        echo "Данная программа реализует нахождение матрицы достижимости. Нумерация начинается с 1. Применялся алгоритм Флойда-Уоршелла.<br>";
        echo "Ввод осуществлять в формате: индексы двух вершин графа, имеющих связь.<br>";
        echo "Введите связанные точки и расстояния между ними, каждая связь с новой строки:<br>";
        $savedmatrix = isset($_POST['textarea1']) ? $_POST['textarea1'] : '';
        $elements = isset($_POST['textarea2']) ? $_POST['textarea2'] : '';
    ?>
    <textarea id = Textarea11 type="text" name="textarea1" style = 
        "resize: none;
        width: 200px;
        height: 200px;"><?= htmlspecialchars($savedmatrix) ?></textarea><br />
        
    <?php
        echo "Введите число элементов графа:<br>";
    ?>
    <textarea id = Textarea22 rows = "1" type="text" name="textarea2" style = 
        "resize: none;
        height: 20px;
        width: 200px;"><?= htmlspecialchars($elements) ?></textarea><br />
    
    <p><button type="submit">Отправить форму</button></p>    
        <script>
            var text1 = document.getElementById('Textarea11').value;
            var text2 = document.getElementById('Textarea22').value;
            if (text1)
                if (!/^\d+ *\d+((\n)\d+ *\d+)*$/.test(text1)) {
                    alert('Неверный формат связей в графе. Необходимый формат:  исходная точка, конечная точка.');
                }
            if (text2)
                if (!/^( )*\d+$/.test(text2)) {
                    alert('Неверный формат количества точек графа. Необходимый формат: положительное число число.');
                }
        </script>

    </form>
    
    <?php
        //print_r($_POST);
        //var_dump($_POST);
        $importmassive = $_POST[textarea1];
        $importelements = (int)$_POST[textarea2];
        $massivelines = explode("\n", $importmassive);
        $countoflines = count($massivelines);

        for ($i = 0; $i < $countoflines; $i++)
            $setline[$i] = explode(' ', $massivelines[$i]);
        
        for ($i = 0; $i < $importelements; $i++)
            for ($j = 0; $j < $importelements; $j++)
                $matrix[$i][$j] = 0;
        
        for ($i = 0; $i < $countoflines; $i++)
            $matrix[$setline[$i][0]-1][$setline[$i][1]-1] = 1;
                
    ?>
    
    <div style = "float: left;">
    <?php echo "Исходная матрица:";
        echo "<table border = 1>";
        for ($i = 0; $i < $importelements+1; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $importelements+1; $j++)
                if ($i == 0 && $j == 0)
                    echo '<td></td>';
                else if ($i == 0)
                    echo '<td>'.$j.'</td>';
                else if ($j == 0)
                    echo '<td>'.$i.'</td>';
                else
                    echo '<td>'.$matrix[$i-1][$j-1].'</td>';
            echo "</tr>";
        }
        echo "</table>";
    ?>
    </div>
    
    <div style = "float: left; transform: translateX(2.5em);">
    <?php echo "Матрица достижимости:";
        for ($k = 0; $k < $importelements; $k++)
            for ($i = 0; $i < $importelements; $i++)
                for ($j = 0; $j < $importelements; $j++) {
                    $matrix[$i][$j] = ($matrix[$i][$j] || ($matrix[$i][$k] && $matrix[$k][$j]));
                    if ($i == $j)
                        $matrix[$i][$j] = 1;
                    if ($matrix[$i][$j] == null)
                        $matrix[$i][$j] = 0;
                }
        echo "<table border = 1>";
        for ($i = 0; $i < $importelements+1; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $importelements+1; $j++)
                if ($i == 0 && $j == 0)
                    echo '<td></td>';
                else if ($i == 0)
                    echo '<td>'.$j.'</td>';
                else if ($j == 0)
                    echo '<td>'.$i.'</td>';
                else
                    echo '<td>'.$matrix[$i-1][$j-1].'</td>';
            echo "</tr>";
        }
        echo "</table>";
    ?>
    </div>
        
</body>