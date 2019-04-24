<?php
/*Array ( [photo] => Array ( [name] => cloth.jpeg [type] => image/jpeg [tmp_name] => /opt/lampp/temp/phpSgoexw [error] => 0 [size] => 231181 ) ) */
if ($_SERVER['REQUEST_METHOD']=="POST") {
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
		require_once '../db.php';;
	$sql = "INSERT INTO `users`(`firstname`, `lastname`, `email`, `phone`, `address`, `photo`) VALUES
	( :firstname,:lastname,:email,:phone,:address,:photo ) ";
	$stmt = $pdo->prepare($sql);
	$photo =  "default.jpg";

	if (is_object($stmt)) {
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
									$stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
									$stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
									$stmt->bindParam(':email',$email,PDO::PARAM_STR);
									$stmt->bindParam(':phone',$phone,PDO::PARAM_INT);
									$stmt->bindParam(':address',$address,PDO::PARAM_STR);
									$stmt->bindParam(':photo',$newPhotoName,PDO::PARAM_STR);
									
									if ( (  $stmt->execute()  &&  move_uploaded_file($photoTmpName , "$destination/$newPhotoName")  ) ) {
										
										echo json_encode(['status'=>'success','message'=>'user added']);
									}
						
							}
						} else {
						echo json_encode(['status'=>'picerror', 'message'=> 'Invalid file type. Only JPEG,JPG, and PNG types are accepted.' ]);
						}
		}
		else {
			// this code will be execute  in casee of user does not upload own photo
				$stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
				$stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
				$stmt->bindParam(':email',$email,PDO::PARAM_STR);
				$stmt->bindParam(':phone',$phone,PDO::PARAM_INT);
				$stmt->bindParam(':address',$address,PDO::PARAM_STR);
				$stmt->bindParam(':photo',$photo,PDO::PARAM_STR);
				$stmt->execute();
				if ($stmt->rowCount()>0) {
					echo json_encode(['status'=>'success','message'=>'user added']);
				}
		}
	
	}
	}
}