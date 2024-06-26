<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess Number Game Task</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        form {
            width: 100%;
            display: contents;
            margin-bottom: 20px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            background: #000;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            width: 50px;
            height: 50px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #ddd;
        }
        button.myvalue {
            width: 100%;
            height: 100%;
            border: none;
            background: none;
            cursor: pointer;
            position: relative;
        }
        .diamond, .bomb {
            color: #FF0000;
        }
        .diamond {
            color: #00FF00;
        }
        .getidnumber {
            font-size: 18px;
            color: #fff;
        }
    </style>
</head>
<body>
<h2>Guessing Game</h2>
<form action="game-task.php" method="post">
    <input type="number" name="number" placeholder="Enter a number" required><br>
    <input type="submit" value="Start">
</form>

<?php
session_start();

if ($_POST) {
    $number = $_POST['number'];
    $_SESSION['randomNumbers'] = "";

    function randomGen($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    $getNumbers = randomGen(1, 25, $number);
    $_SESSION['randomNumbers'] = $getNumbers;

    // echo "<pre>";
    // print_r($_SESSION['randomNumbers']);
}

echo "<table>";
$didNum = 25;
$_SESSION['loopNumbers'] = $didNum;
for ($i = 1; $i <= $didNum; $i++) {
    if ($i % 5 == 1) {
        echo "<tr>";
    }
    echo "<td><button class='myvalue' id='select_$i' value='$i'><i class='fas fa-gem diamond' style='display:none'></i><i class='fa-solid fa-bomb bomb' style='display:none'></i><span class='getidnumber'>$i</span></button></td>";
    if ($i % 5 == 0) {
        echo "</tr>";
    }
}
echo "</table>";
?>

<script>
   $(document).ready(function() {
       var session = <?php echo json_encode($_SESSION['randomNumbers']); ?>;
       console.log(session);
       $(".myvalue").click(function() {
           var clickedValue = parseInt($(this).val());
           console.log(clickedValue);
           var session = <?php echo json_encode($_SESSION['randomNumbers']); ?>;
           var db = JSON.stringify(session);
           db = JSON.parse(db);
           var loopnumber = <?php echo $_SESSION['loopNumbers']; ?>;
           console.log(loopnumber);

           var inArray = $.inArray(clickedValue, db);
           if (inArray != -1) {
               alert("Game Over");
               for (var i = 1; i <= loopnumber; i++) {
                   var id = "select_" + i;
                   if ($.inArray(i, db) != -1) {
                       $('#' + id).find(".bomb").css('display', 'block');
                       $('#' + id).find(".getidnumber").css('display', 'none');
                   } else {
                       $('#' + id).find(".diamond").css('display', 'block');
                       $('#' + id).find(".getidnumber").css('display', 'none');
                   }
               }
           } else {
               var id = "select_" + clickedValue;
               $('#' + id).find(".diamond").css('display', 'block');
               $('#' + id).find(".getidnumber").css('display', 'none');
           }
       });
   });
</script>

</body>
</html>
