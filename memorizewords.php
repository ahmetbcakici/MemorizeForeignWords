<!-- SELECT * FROM words ORDER BY RAND() LIMIT 1; -->
<?php $con = new mysqli('localhost','root','','memorizewords'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script src='voicerss-tts.min.js'></script>
    <link rel="stylesheet" type="text/css" href="mutual.css">
    <title>Memorize Words</title>
</head>
<body>
    <input type="button" onclick="location.href='index.html';" value="BACK"><br>
    <label id='lbl_RANDOMWORD'></label><br>
    <input type="text" id="txt_INPUT" autocomplete="off"><br>   
    <label hidden id='lbl_RANDOMWORDANSWER'></label>
</body>
<script>
var falseansweraudio = new Audio("audio.wav");
var speechspamcontrol = false;
falseansweraudio.volume = 0.05;
$(document).ready(function(e){
    <?php         
        $update = "UPDATE words SET process = '0'";
        if($con->query($update) === TRUE){}
    ?>
    var txt_INPUT = document.getElementById("txt_INPUT");
    var lbl_RANDOMWORDANSWER = document.getElementById('lbl_RANDOMWORDANSWER');
    var lbl_RANDOMWORD = document.getElementById('lbl_RANDOMWORD');
    txt_INPUT.focus();
    function getword(){
        $.ajax({
                url:"insert.php",
                type:"POST",
                data:"value=blabla",
                dataType:"JSON",
                success:function(data){
                    if(Math.floor(Math.random() * 2) == 0 ){
                        lbl_RANDOMWORD.innerHTML=data.eng;
                        lbl_RANDOMWORDANSWER.innerHTML=data.tur;
                        speech(data.eng);
                    }
                    else{
                        lbl_RANDOMWORD.innerHTML=data.tur;
                        lbl_RANDOMWORDANSWER.innerHTML=data.eng;
                    }
                },
                error:function(data){getword();alert("x");}
            });
            txt_INPUT.value = "";
    }
    getword();
    var words = [];
    $('#txt_INPUT').keyup(function(e){
        if(e.keyCode == 13 && txt_INPUT.value != ""){
            if(txt_INPUT.value == lbl_RANDOMWORDANSWER.innerHTML){
                getword();
            }
            else{
                falseansweraudio.play();
                var gelen = document.getElementById("lbl_RANDOMWORDANSWER").textContent;
                words.push(gelen);
                getword();
            }
            
        }
    });
    $('#txt_INPUT').keydown(function(e){
        if(e.keyCode == 16){
            lbl_RANDOMWORDANSWER.style.display = 'block';
            if(speechspamcontrol == false){
            speech(lbl_RANDOMWORDANSWER.innerHTML);
            speechspamcontrol = true;
            }

        }
    });
    $('#txt_INPUT').keyup(function(e){
        if(e.keyCode == 16){
            lbl_RANDOMWORDANSWER.style.display = 'none';
            speechspamcontrol = false;
        }
    });
    function speech(word){
        VoiceRSS.speech({
            key: '5ecd6f8fc1104c3ca4b7f83186a61e7c',
            src: word,
            hl: 'en-us',    
            r: 0, 
            c: 'mp3',
            f: '44khz_16bit_stereo',
            ssml: false
        });
    }
});

</script>
</html>