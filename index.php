<?php
session_start();
require 'config.php';
$res = mysql_query("select * from categories") or die(mysql_error());
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Quiz</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="../../assets/js/html5shiv.js"></script>
		<script src="../../assets/js/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>
		<header>
			<p class="text-center">
				 <?php if(!empty($_SESSION['name'])){echo "Welcome ". $_SESSION['name'];}?>
			</p>
		</header>
		<div class="container">
			<div class="row">				
				<div class="col-xs-10 col-sm-12 col-lg-12">
					<div class="intro">
						<p class="text-center">
							Please enter your name
						</p>
						<?php if(empty($_SESSION['name'])){?>
						<form class="form-signin" method="post" id='signin' name="signin" action="questions.php">
							<div class="form-group">
								<input type="text" id='name' name='name' class="form-control" placeholder="Enter your Name"/>
								<span class="help-block"></span>
							</div>
							<div class="form-group">
							      <select class="form-control" name="category" id="category">
							      <option value="">Choose category</option>
								  <?php while($result = mysql_fetch_object($res)){ ?>
                                  <option value="<?php echo $result->id;?>"><?php echo $result->category_name;?></option>
                                  <?php } ?>                                
                                  </select>
                                <span class="help-block"></span>
							</div>
							
							<br>
							<button class="btn btn-success btn-block" type="submit">
								Start 
							</button>
						</form>
						
						<?php }else{?>
						    <form class="form-signin" method="post" id='signin' name="signin" action="questions.php">
                            <div class="form-group">
                                  <select class="form-control" name="category" id="category">
							      <option value="">Choose category</option>
								  <?php while($result = mysql_fetch_object($res)){ ?>
                                  <option value="<?php echo $result->id;?>"><?php echo $result->category_name;?></option>
                                  <?php } ?>                                
                                  </select>
                                <span class="help-block"></span>
                            </div>
                            
                            <br>
                            <button class="btn btn-success btn-block" type="submit">
                                start
                            </button>
                        </form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<footer></footer>		
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>		
		<script src="js/jquery.validate.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#signin").validate({
					submitHandler : function() {
					    console.log(form.valid());
						if (form.valid()) {
						    alert("sf");
							return true;
						} else {
							return false;
						}

					},
					rules : {
						name : {
							required : true,
							minlength : 3,
							remote : {
								url : "check_name.php",
								type : "post",
								data : {
									username : function() {
										return $("#name").val();
									}
								}
							}
						},
						category:{
						    required : true
						}
					},
					messages : {
						name : {
							required : "Please enter your name",
							remote : "Name is already taken, Please choose some other name"
						},
						category:{
                            required : "Please choose your category to start Quiz"
                        }
					},
					errorPlacement : function(error, element) {
						$(element).closest('.form-group').find('.help-block').html(error.html());
					},
					highlight : function(element) {
						$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
					},
					success : function(element, lab) {
						
						$(lab).addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				});
			});
		</script>

	</body>
</html>
