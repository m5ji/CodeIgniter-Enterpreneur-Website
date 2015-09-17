<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>FreshPrints</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to FreshPrints!</h1>
	
	<div id="form_input">
		<?php
		echo form_open('Welcome/data_submitted');
		echo form_label('Apparel Type:', 'apparel_type');
		$options = array(
                  'Gildan G500'  => 'Gildan G500',
                  'American Apparel 2001'    => 'American Apparel 2001',
                  'Canvas 3001C'   => 'Canvas 3001C',
                  'Tultex 0202TC' => 'Tultex 0202TC'
                );

		echo form_dropdown('shirts', $options);
		?> </br>
		
		<?php
		// Show Quantity Field in View Page
		echo form_label('Quantity:', 'quantity');
		$data= array(
		'name' => 'quantity',
		'placeholder' => 'Quantity',
		'class' => 'input_box'
		);
		echo form_input($data);
		?></br>
		
		<?php
		// Show Front Colors Field in View Page
		echo form_label('Number of Front Colors:', 'front_colors');
		$data= array(
		'name' => 'front_colors',
		'placeholder' => 'Number of front colors(<=6)',
		'class' => 'input_box'
		);
		echo form_input($data);
		?></br>
		
		<?php
		// Show Back Colors Field in View Page
		echo form_label('Number of Back Colors:', 'back_colors');
		$data= array(
		'name' => 'back_colors',
		'placeholder' => 'Number of back colors(<=6)',
		'class' => 'input_box'
		);
		echo form_input($data);
		?>
		</div></br>
	
		<div id="form_button">
		<?php
		// Show Update Field in View Page
		$data = array(
		'type' => 'submit',
		'value'=> 'Submit',
		'class'=> 'submit'
		);
		echo form_submit($data); ?>
		</div></br>
		
		<?php 
		// Close Form
		echo form_close();
		?>
		
		<?php 
		// Display Entered values in View Page
		if(isset($error))
		{
			echo "<div id='content_result'>";
			echo "<h3 id='result_id'>You have submitted these values</h3><br/><hr>";
			echo "<div id='result_show'>";
			echo "<label class='label_output'>Error Occurred: </label>".$error;
			echo "<div>";
			echo "</div>";
		} ?>

		<?php 
		// Display Entered values in View Page
		if(isset($total_price) && isset($quantity))
		{
			echo "<div id='content_result'>";
			echo "<h3 id='result_id'>You have submitted these values</h3><br/><hr>";
			echo "<div id='result_show'>";
			echo "<label class='label_output'>Total Price : $</label>".round($total_price, 2);
			echo "</br><label class='label_output'>Price per Item: $</label>".round($total_price/$quantity, 2);
			echo "<div>";
			echo "</div>";
		} ?>


	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>