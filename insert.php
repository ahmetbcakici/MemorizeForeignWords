<?php
//Hata oranlarını kaydet , bilinemeyenlerin üzerinde dur
//Kelimeleri seslendir
//Belli başarı yakalanan kelimeleri yok et
    $con = new mysqli('localhost','root','','memorizewords');
    $con->set_charset("utf8");
    $words = array();
    if(@$_POST['value']){
        $select = "SELECT word_eng,word_tur FROM words where process = '0' ORDER BY RAND()"; 
        $result = $con->query($select);
        if($result->num_rows>0){
            $row = $result->fetch_assoc();
            $theword = $row['word_eng'];
            $thewordanswer = $row['word_tur'];
        }
        else{
            $update = "UPDATE words SET process = '0'";
            if($con->query($update) === TRUE){}
        }
        $update = "UPDATE words SET process = process + 1 WHERE word_eng = '$theword'";
        if($con->query($update) === TRUE){}

        $data["eng"] = $theword;
        $data["tur"] = $thewordanswer;
        echo json_encode($data);
    }
    if(@$_POST['eng']){
    $eng = $_POST['eng'];
    $tur = $_POST['tur'];
    $insert = "INSERT INTO words (word_eng,word_tur) VALUES ('$eng','$tur')";
    if($con->query($insert) === TRUE){}
    }
?>