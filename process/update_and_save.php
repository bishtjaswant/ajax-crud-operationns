<?php  
/*Array ( [photo] => Array ( [name] => cloth.jpeg [type] => image/jpeg [tmp_name] => /opt/lampp/temp/phpSgoexw [error] => 0 [size] => 231181 ) ) */
if ($_SERVER['REQUEST_METHOD']=="POST") {

	$uid =   htmlspecialchars(trim($_POST['id']));
	$firstname = ucfirst( htmlspecialchars(trim($_POST['firstname'] ) ));
	$lastname = ucfirst( htmlspecialchars(trim($_POST['lastname'] )));
	$email = htmlspecialchars(trim($_POST['email'])) ;
	$phone = htmlspecialchars(trim($_POST['phone'])) ;
	$address = htmlspecialchars(trim($_POST['address']) );
	
	if (empty($firstname) || $firstname=='') {
		echo json_encode(['status'=>'fn','message'=>'write your first name']);
	}
	elseif (empty($lastname) || $lastname=='') {
		echo json_encode(['status'=>'ln','message'=>'write your last name']);
	}
	elseif (empty($email) || $email=='') {
		echo json_encode(['status'=>'em','message'=>'write your email address']);
	}
		elseif (empty($phone) || $phone=='') {
		echo json_encode(['status'=>'ph','message'=>'write your phone number']);
	}
elseif (empty($address) || $address=='') {
		echo json_encode(['status'=>'add','message'=>'write your address']);
	}



	else {

	require_once '../db.php';
 
		if (isset($_FILES['photo'])) {
			// this code will be execute  in casee of user want to upload own photo
			
       					$photoName   = $_FILES['photo']['name'];
						$photoType   = $_FILES['photo']['type'];
						$photoTmpName   = $_FILES['photo']['tmp_name'];
						$photoSize = $_FILES['photo']['size'];
						// codding for upload user's pic
						$maxsize    = 2097152;
						$destination = '../userprofile/';
						// allow for
						$allowed_format =['jpeg','png','jpg'];
						// exetention
						$get_exetention = explode(".", $photoName );
						$photo_exetention = end($get_exetention);
						// new name to pic
						$newPhotoName = rand(000000,999999)."-". uniqid('user-'). $photoName;

						// check format
						if (in_array( $photo_exetention,$allowed_format )) {
						// check file size
							if ( ( $photoSize>= $maxsize || $photoSize===0 ) ) {
							echo json_encode(['status'=>'picerror', 'message'=>'File too large. File must be less than 2 megabytes.' ]);
							} else {

							
	                            	$select_query = "SELECT `users`.`photo` FROM `users` WHERE `users`.`id`= :uid";
	                            	$stmt =  $pdo->prepare($select_query);
	                            	$stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
	                            	$stmt->execute();
                                       
									// check file exist or not
									$row  =  $stmt->fetch(PDO::FETCH_ASSOC);

									// print_r($row); exit;

                        if (  file_exists("../userprofile/".$row['photo'] )  ) {
                          
                                
			                       /*update query*/
                                     $update_sql = "UPDATE `users` SET `firstname`=:firstname,`lastname`=:lastname,`email`=:email,`phone`=:phone,`address`=:address, 
                                     `photo`=:photo WHERE `users`.`id` = :uid";

                                    $stmt =  $pdo->prepare($update_sql);
                                    $stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
									$stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
									$stmt->bindParam(':email',$email,PDO::PARAM_STR);
									$stmt->bindParam(':phone',$phone,PDO::PARAM_INT);
									$stmt->bindParam(':address',$address,PDO::PARAM_STR);
									$stmt->bindParam(':photo',$newPhotoName,PDO::PARAM_STR);
									$stmt->bindParam(':uid',$uid,PDO::PARAM_INT); 
									$stmt->execute() ;

												if ($stmt->rowCount()>0) {
                                           
                                           // delete the exist photo
                                                  unlink( "../userprofile/".$row['photo'] ) ;


                                                     // move to destinatiion
                                                   move_uploaded_file($photoTmpName , "$destination/$newPhotoName" );

									            	echo json_encode(['status'=>'success','message'=>'user updated']);
													
												} else {
										echo json_encode(['status'=>'success','message'=>'failed to user updated']);
													
												}

 

                            }
                            else {
                            	echo 'file not found';
                            }
					}
						} else {
						echo json_encode(['status'=>'picerror', 'message'=> 'Invalid file type. Only JPEG,JPG, and PNG types are accepted.' ]);
						}
		}
		else {
 
 // this code will be execute  in casee of user does not upload own photo

   $update_sql = "UPDATE `users` SET `firstname`=:firstname,`lastname`=:lastname,`email`=:email,`phone`=:phone,`address`=:address WHERE `users`.`id` = :uid ";
 
	$stmt = $pdo->prepare($update_sql);
	$photo =  "default.jpg";
			
				$stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
				$stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
				$stmt->bindParam(':email',$email,PDO::PARAM_STR);
				$stmt->bindParam(':phone',$phone,PDO::PARAM_INT);
				$stmt->bindParam(':address',$address,PDO::PARAM_STR);
				$stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
				$stmt->execute();
				if ($stmt->rowCount()>0) {
					echo json_encode(['status'=>'success','message'=>'user updated']);
				}
		}
	
	
	}
}