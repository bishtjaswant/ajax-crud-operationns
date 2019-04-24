<?php


if ( $_SERVER['REQUEST_METHOD']=="POST") {
	 $deleteId = htmlspecialchars(strip_tags( $_POST['deleteId'] )) ;
	 if ( is_numeric( $deleteId ) ) { 
	 	$sql =  "SELECT * FROM `users` WHERE `users`.`id` = :deleteId";
	 	require_once '../db.php';
	 	$stmt = $pdo->prepare($sql);
	 	$stmt->execute([':deleteId'=>$deleteId]);
	 		    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 		    	
                    
                 if (unlink("../userprofile/".$row['photo'] ) ) {
                 	   $delete_stmt = $pdo->prepare("DELETE FROM `users` WHERE `users`.`id` = :deleteId");
                   	$delete_stmt->execute([':deleteId'=>$deleteId]);
	 		    	$row = $delete_stmt->fetch(PDO::FETCH_ASSOC);
	 	            echo json_encode(['status'=>'success','message'=>'user deleted']);

                 } else {
	 	            echo json_encode(['status'=>'success','message'=>'user  not deleted yet']);
                 	
                 }

	 }
	 else{
	 	echo json_encode(['status'=>'success','message'=>'delete id must be integer noot other dataType']);
	 }





}