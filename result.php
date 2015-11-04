<?php
session_start();
require 'config.php';
if(!empty($_SESSION['name'])){
    
    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0; 
	$totalQuestions = 0;
	$totalPerac  =0;
  
   $keys=array_keys($_POST);
   $order=join(",",$keys);

   
   $response=mysql_query("select id,answer from questions where id IN($order) ORDER BY FIELD(id,$order)")   or die(mysql_error());
   
   while($result=mysql_fetch_array($response)){
	   $totalQuestions++;
       if($result['answer']==$_POST[$result['id']]){
               $right_answer++;
           }else if($_POST[$result['id']]==5){
               $unanswered++;
           }
           else{
               $wrong_answer++;
           }
   }
   $totalPerc = (($totalQuestions -  ($wrong_answer + $unanswered)) / $totalQuestions) * 100;
   $name=$_SESSION['name'];  
   mysql_query("update users set score='$right_answer' where user_name='$name'");
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
                Welcome <?php 
                if(!empty($_SESSION['name'])){
                    echo $_SESSION['name'];
                }?>
               
            </p>
        </header>
        <div class="container result">
            
           <hr>   
           <div class="row"> 
                  
                  
                  <div class="col-xs-6 col-sm-12 col-lg-12"> 
                     <a href="<?php echo BASE_PATH;?>" class='btn btn-success'>Start new Quiz!!!</a>                   
                     <a href="<?php echo BASE_PATH.'logout.php';?>" class='btn btn-success'>Logout</a>
                   
                       <div style="margin-top: 30%">
                        <p>Total no. of right answers : <span class="answer"><?php echo $right_answer;?></span></p>
                        <p>Total no. of wrong answers : <span class="answer"><?php echo $wrong_answer;?></span></p>
						<p>Percantage : <span class="answer"><?php echo $totalPerc;?>%</span></p>
                        <p>Total no. of Unanswered Questions : <span class="answer"><?php echo $unanswered;?></span></p>                   
                       </div> 
                   
                   </div>
                    
            </div>    
            <div class="row">    
                    
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/jquery.validate.min.js"></script>

        

    </body>
</html>
<?php }else{
    
 header( 'Location: '.BASE_PATH.'') ;
      
}?>