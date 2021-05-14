<!DOCTYPE html>
<head>  
</head>
<body>
    <form method='post'>
    <?php
        echo "� ������ ������ ����������� ���������� ���� � ����������������� ����� ����� ����� ���������.<br>";
        echo "������� � ����� ����������, ������� � 0 ��� �������, �� ������� �� ����� ������ �����, � ���� �� �������.<br>";
        echo "���� ������������ � �������: ������ ���� ������ ������� �����, ����� ���������� ����� ����, ������ ������� ��������� ��������.<br>";
        echo "������� ��������� ����� � ���������� ����� ����, ������ ����� � ����� ������:<br>";
        $savedvalue1 = isset($_POST['textarea1']) ? $_POST['textarea1'] : '';
        $savedvalue2 = isset($_POST['textarea2']) ? $_POST['textarea2'] : '';
    ?> 
        <textarea id = Textarea11 type="text" name="textarea1" style = 
        "resize: none;
        width: 200px;
        height: 200px;"><?= htmlspecialchars($savedvalue1) ?></textarea><br />
    <?php echo "������� ������ �������� ������� �����:<br>"; ?>
        <textarea id = Textarea22 rows = "1" type="text" name="textarea2" style = 
        "resize: none;
        height: 20px;
        width: 200px;"><?= htmlspecialchars($savedvalue2) ?></textarea><br />
        <p><button type="submit">��������� �����</button></p>
        <script>
            var text1 = document.getElementById('Textarea11').value;
            var text2 = document.getElementById('Textarea22').value;
            if (text1)
                if (!/^\d+ *\d+ *\d+((\n)\d+ *\d+ *\d+)*$/.test(text1)) {
                    alert('�������� ������ ������ � �����. ����������� ������:  ������ �����, ������ �����, ���������� ����� �������.');
                }
            if (text2) 
                if (!/^[0-9]*\s*$/s.test(text2)) {
                    alert('������� ������� ������� ����� �����, ����� �������� ���� ����� ����������. ���������� 2 ����� � ����������� ����� ������.');
                }
        </script>
    </form>
<?php
    function setE($a, $b, $value, $E){
        //���������� ����� ����� ����� a � b
        $m = min($a, $b);
        $n = max($a, $b);
        $tempE = array("${m}_${n}" => $value);
        $E = array_merge($E, $tempE);
        return $E;
    }
    function getE($a, $b, $E){
        //�������� ����� ����� ����� a � b
        if ($a == $b) return 0;
        $m = min($a, $b);
        $n = max($a, $b);
        return $E["${m}_${n}"];
    }
    function existE($a, $b, $E){
        //���������� �������� true ��� false, ����������, ���������� �� ����� ����� ������� ������� �����
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
    $M = count($massivelines);// ���-�� �����
    $start = 0; //������ ���������� ��������=�������� ��� ��-��
    $end = $importrelation;//������ ��������� ��������=�������� ��������� ��-��
    $E = array();
    $N = count($pointsArray);// ���-�� �����
    
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

    echo "��������� ��������� ������ ���������: ";
    echo $dmin[$end];
?>
    
</body>