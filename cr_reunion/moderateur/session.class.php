<link rel="stylesheet" type="text/css" href="style.css">
  <style>
  	#alert {
		padding: 20px;
		color: white;
		opacity: 1;
		transition: opacity 0.6s;
		margin-bottom: 15px;
	}

	#alert.success {background-color: #4CAF50;}
	#alert.info {background-color: #2196F3;}
	#alert.warning {background-color: #ff9800;}
	#alert.danger {background-color: #f44336;}

	#closebtn {
	  	margin-left: 15px;
	  	color: white;
	  	font-weight: bold;
	  	float: right;
	  	font-size: 22px;
	  	line-height: 20px;
	  	cursor: pointer;
	  	transition: 0.3s;
	}

	#closebtn:hover {
	  	color: black;
	}
  	
  </style>
  <script>
	// Get all elements with class="closebtn"
	var close = document.getElementsById("closebtn");
	var i;

	// Loop through all close buttons
	for (i = 0; i < close.length; i++) {
	  // When someone clicks on a close button
	  close[i].onclick = function(){

	    // Get the parent of <span class="closebtn"> (<div class="alert">)
	    var div = this.parentElement;

	    // Set the opacity of div to 0 (transparent)
	    div.style.opacity = "0";

	    // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
	    setTimeout(function(){ div.style.display = "none"; }, 600);
	  }
	}
</script>

<?php

class Session{

	public function setFlash($message, $type = 'error'){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type'    => $type);
	}

	public function flash_danger(){
		if(isset($_SESSION['flash'])){
			?>
			<div id="alert" class="danger">
				<?php echo $_SESSION['flash']['message']; ?>
				<span id="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				
			</div>
			<?php
			unset($_SESSION['flash']);
		}
	}

	public function flash_success(){
		if(isset($_SESSION['flash'])){
			?>
			<div id="alert" class="success">
				<?php echo $_SESSION['flash']['message']; ?>
				<span id="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				
			</div>
			<?php
			unset($_SESSION['flash']);
		}
	}

	public function flash_info(){
		if(isset($_SESSION['flash'])){
			?>
			<div id="alert" class="info">
				<?php echo $_SESSION['flash']['message']; ?>
				<span id="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				
			</div>
			<?php
			unset($_SESSION['flash']);
		}
	}

	public function flash_warning(){
		if(isset($_SESSION['flash'])){
			?>
			<div id="alert" class="warning">
				<?php echo $_SESSION['flash']['message']; ?>
				<span id="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				
			</div>
			<?php
			unset($_SESSION['flash']);
		}
	}
}


?>