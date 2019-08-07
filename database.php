<?php
    $con = new mysqli('localhost','root','','memorizeforeignwords');
    $con->set_charset("utf8");


    function countercontrol($id){
        $con = new mysqli('localhost','root','','memorizeforeignwords');
        $select = "SELECT counter FROM repeating WHERE word_id = '$id'";
        $result = $con->query($select);
        if($row = $result->fetch_assoc()){            
            if($row["counter"] >= 3){                
                $select2 = "SELECT * FROM active_words WHERE id = '$id'";
                $result2 = $con->query($select2);
                if($row2 = $result2->fetch_assoc()){
                    $tempforeign = $row2['wordinforeign'];
                    $tempnative = $row2['wordinnative'];
                    $insert = "INSERT INTO all_words (wordinforeign,wordinnative) VALUES ('$tempforeign','$tempnative')";
                    if($con->query($insert) === TRUE){}
                    return true;
                }
            }
        }
        return false;
    }
    if(@$_POST['value']){
        $select = "SELECT id,wordinforeign,wordinnative FROM active_words/* where process = '0'*/ORDER BY RAND()";
        $result = $con->query($select);
        if($result->num_rows>0){
            $row = $result->fetch_assoc();
            $data["eng"] = $row['wordinforeign'];
            $data["tur"] = $row['wordinnative'];
            echo json_encode($data);
        }
        //$update = "UPDATE words SET process = '0'";
        //if($con->query($update) === TRUE){}
        
        //$update = "UPDATE words SET process = process + 1 WHERE word_eng = '$theword'";
        //if($con->query($update) === TRUE){}
    }
    if(@$_POST['eng']){
        $eng = $_POST['eng'];
        $tur = $_POST['tur'];
        $insert = "INSERT INTO active_words (wordinforeign,wordinnative) VALUES ('$eng','$tur')";
        if($con->query($insert) === TRUE){}
    }
    if(@$_POST['control']){
        $wordthatcame = $_POST['word'];
        $id_wordthatcame = 1;
        $selectwordid = "SELECT id FROM active_words WHERE wordinnative = '$wordthatcame' OR wordinforeign = '$wordthatcame'";
        $result = $con->query($selectwordid);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $id_wordthatcame = $row["id"];   
            echo $id_wordthatcame;      
        }
        $selectcontrol = "SELECT * FROM repeating WHERE word_id = '$id_wordthatcame'";
        $result = $con->query($selectcontrol);
        if($result->num_rows < 1){
            $insert = "INSERT INTO repeating (word_id) values ('$id_wordthatcame')";
            if($con->query($insert) === TRUE){}   
        }
        
        if($_POST['control'] == "false"){
            $update = "UPDATE repeating SET counter = counter - 2 WHERE word_id = '$id_wordthatcame'";
            if($con->query($update) === TRUE){}
            countercontrol($id_wordthatcame);            
        }
        else{//CONTROLE POINT FOR 5
            $update = "UPDATE repeating SET counter = counter + 1 WHERE word_id = '$id_wordthatcame'";
            if($con->query($update) === TRUE){}
            if(countercontrol($id_wordthatcame)){
                $deletefromrepeating = "DELETE FROM repeating WHERE word_id = '$id_wordthatcame'";
                if($con->query($deletefromrepeating) === TRUE){}
                $deletefromactive = "DELETE FROM active_words WHERE id = '$id_wordthatcame'";
                if($con->query($deletefromactive) === TRUE){}
            }
        }
    }
?>