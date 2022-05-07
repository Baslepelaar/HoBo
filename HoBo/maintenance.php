<?php
    $bg = array('bg-01.jpg', 'bg-02.jpg', 'bg-03.jpg', 'bg-04.jpg', 'bg-05.jpg', 'bg-06.jpg', 'bg-07.jpg', ); // array of filenames

    $i = rand(0, count($bg)-1); // generate random number size of the array
    $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen

    require_once 'backend/class/Maintenance.php';

    $maintenance = new Maintenance();
    if($maintenance->getMaintenance() != '1') {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>

    <meta charset= "utf-8">
    <meta http-equiv="language" content="NL">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Bas, William, Mathieu">
    <meta name="keywords" content="Hobo, streaming website, streaming">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/maintenance.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Script -->
    <script src="https://use.fontawesome.com/213a34779b.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Icon -->
    <link rel="icon" type="image/png" href="img/Logo.png" />

    <title>Hobo | Maintenance</title>

    <style type="text/css">
        body.maintenance {
            background: url(img/<?php echo $selectedBg; ?>);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            position: center;
        }
    </style>
</head>
<body class="maintenance">
<div class="content">
    <div class="maintenance-center">
        <div class="maintenance-content">
            <h2 style="padding-top: 1rem; text-transform: uppercase;"><strong>Maintenance</strong></h2>
            <h1 style="font-size: 50px;"><strong>HoBo</strong></h1>
            <h4 style="padding-top: 1rem; padding-bottom: 1rem; text-transform: uppercase;"><strong><i class="fa fa-clock-o" aria-hidden="true"></i> We will be back soon</strong></h4>
        </div>
    </div>
</div>
</body>
</html>