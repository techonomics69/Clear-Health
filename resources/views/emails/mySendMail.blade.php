<!DOCTYPE html>
<html>
<head>
    <title>helloclearhealth.com</title>
</head>
<body>
	<?php echo "<pre>";
	print_r($title);
	echo "<pre>";
	exit(); ?>
    <h1>{{ $data['title'] ?? '' }}</h1>
    <p>{{ $data['body'] ?? ''}}</p>
   
    <p>Thank you</p>
</body>
</html>