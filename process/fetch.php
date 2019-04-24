<?php



if (  ( $_SERVER['REQUEST_METHOD'] ==  "POST" && $_POST['fetchDetails']=="read_record" )  ) {
	 require_once '../db.php';

	 $sql = "SELECT * FROM `users`  ORDER BY `users`.`id` DESC "; 
	 $stmt = $pdo->prepare($sql);
     $stmt->execute();

                  	            // retrived
   $html =  <<<SHOW_DATA

  <table class="table table-border">
    <thead>
      <tr>
        <th>#</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th> 
        <th>Phone</th> 
        <th>Address</th>
        <th>photo</th> 
        <th colspan="3">Actions</th>
      </tr>
    </thead>
    <tbody>
SHOW_DATA;


     if ($stmt->rowCount()>0) {
     
     	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $id = 1;


foreach ($rows as $row) {
	
$html .= <<<SHOW_DATA
      <tr>
        <td>{$id}</td>
        <td>{$row['firstname']}</td>
        <td>{$row['lastname']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['address']}</td>
        <td> <img src="./userprofile/{$row['photo']}" width="100px" height="100px" class="img-thumbnail"></td>
        
        <td>
          <button type="button" id="getUserDetails" data-id="{$row['id']} " class="btn btn-sm btn-success">Edit</a>
          <button type="button" id="deleteUserNow" data-id="{$row['id']}"  class="btn btn-sm btn-danger">Delete</a>
        </td>     
      </tr>
SHOW_DATA;
      $id++;
}

$html .= <<<SHOW_DATA
 
    </tbody>
  </table>
SHOW_DATA;




     }
     else{
     	$html .= <<<SHOW_DATA
    <tfoot>
		<tr>
                <td class="text-danger">no data  found</td>
		</tr>
    </tfoot>
    </tbody>
  </table>
SHOW_DATA;
     	 
     }

     echo json_encode(['template'=>$html]); 
 

}

 