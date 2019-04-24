<?php 


if ($_SERVER['REQUEST_METHOD'] == "POST") {

 
    // $update_id = 2;
    $update_id = htmlspecialchars(trim(strip_tags($_POST['id'])));

    require_once '../db.php';
    
     
     if (is_numeric($update_id)) {
     	 $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `users`.`id` = :update_id  ");
    	 $stmt->execute([':update_id'=>$update_id]);

		    if ($stmt->rowCount()>0) {
		    	 
		    	$data = $stmt->fetch(PDO::FETCH_ASSOC);
		    	
		    	echo json_encode( $data  );


		    }else {
	      	echo json_encode(['status'=>'success','message'=>'no record']);
		    	
		    }


     }
     else{
	 	echo json_encode(['status'=>'success','message'=>'update id must be integer not other dataType']);
	 }






    $pdo = null;




}