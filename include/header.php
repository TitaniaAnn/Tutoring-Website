<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tutoring Website - <?php echo($title) ?></title>
    <link rel="stylesheet" href="/tutoring/mockup/styles/style.css" type="text/css" />
    <?php if($style != null || $style != "") {
		echo('<link rel="stylesheet" href="'.$style.'" type="text/css" />');
	} ?>
    <script type="text/javascript" src="/tutoring/mockup/scripts/jquery-1.5.min.js"></script>
    <script type="text/javascript" src="/tutoring/mockup/scripts/jquery-ui-1.8.9.custom.min.js"></script>
    <script type="text/javascript" src="/tutoring/mockup/scripts/functions.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php
                include_once($script);
            ?>
        });
    </script>
    
</head>
<body>
<div id="body">
    <div id="header">
        <div id="title">
            <h1>Tutoring - <?php echo($title) ?></h1>
        </div>
    
