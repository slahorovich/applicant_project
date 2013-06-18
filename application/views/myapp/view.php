<html>
<head>
<title>Customer Paradise Developer Exam</title>
</head>
<body>
	<h1><?php echo $contact->getData('name'); ?></h1>
	<ul>
		<?php foreach($contact->getData() as $key => $field): ?>
			<li>
				<strong>
					<?php echo ucwords($key) ?> :
				</strong>
				<?php echo $field ?>
			</li>
		<?php endforeach; ?>
	</ul>
</body>
</html>