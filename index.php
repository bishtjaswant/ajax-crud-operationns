<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" type="text/css" href="./style.css">
    <title>crud_operations_ajax$</title>
  </head>
  <body>
    
    <div class="container-fluid">


      <h1 class="text-primary text myheading text-center">Ajax crud operation</h1>
      
      <!--add button-->
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Add user
        </button>
      </div>


      <div class="all">
         <h2 class="text-success">ALL DETAILS</h2>
      </div>
   
       <img class="img-wallpaper" src="./userprofile/honest.gif" alt="wall paper">

      <!-- dynamic data fetching from server -->
      <div id="all_fetch_details">
      
      </div>
    

    </div><!--container closed -->







    <!-- add item modals -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form enctype="multipart/form-data" id="addItemForm">
            <!-- Modal Header -->
            <div class="modal-header ">
              <h4 class="modal-title">Add user </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstname">first name</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="write your first name">
                    <output class="fn"></output>
                  </div> 
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname">last name</label>
                    <input type="text" name="lastname" class="form-control" placeholder="write your last name" id="lastname">
                      <output class="ln"></output>
                  </div>
                </div>
              </div>
             
              <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                <label for="email">email address:</label>
                <input type="email" name="email" placeholder="write your  email address" class="form-control" id="email">
                  <output class="em"></output>
              </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                <label for="phone">phone number:</label>
                <input type="number" name="phone" pattern="/^[0-9]$/" placeholder="numbers....." class="form-control" id="phone">
              </div>
                <output class="ph"></output>
                </div>
              </div>

               <div class="form-group">
                <label for="address">resident address:</label>
                <textarea style="margin-top: 0px; margin-bottom: 0px; height: 88px;"  id="address" name="address"  class="form-control" placeholder="your address"></textarea>
                 <output class="add"></output>
              </div>

                <div class="custom-file">
                  <input type="file" name="photo" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">your profile  (Optional)</label>
                  <output class="picerror"> </output>
                </div>
                            
                         
              
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
 
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" >Submit</button>
                        
            </div>
        
          </form>
        </div>
      </div>
    </div>









    <!-- update item modals -->
    <div class="modal fade" id="updateModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form enctype="multipart/form-data" id="updateItemForm">
            <!-- Modal Header -->
            <div class="modal-header ">
              <h4 class="modal-title">Update Existing Record </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstname">first name</label>
                    <input type="text" name="ufirstname" class="form-control" id="ufirstname" placeholder="write your first name">
                    <output class="fn"></output>
                  </div> 
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname">last name</label>
                    <input type="text" name="ulastname" class="form-control" placeholder="write your last name" id="ulastname">
                      <output class="ln"></output>
                  </div>
                </div>
              </div>
             
              <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                <label for="email">email address:</label>
                <input type="email" name="uemail" placeholder="write your  email address" class="form-control" id="uemail">
                  <output class="em"></output>
              </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                <label for="phone">phone number:</label>
                <input type="number" name="uphone" pattern="/^[0-9]$/" placeholder="numbers....." class="form-control" id="uphone">
              </div>
                <output class="ph"></output>
                </div>
              </div>

               <div class="form-group">
                <label for="address">resident address:</label>
                <textarea style="margin-top: 0px; margin-bottom: 0px; height: 88px;"  id="uaddress" name="uaddress"  class="form-control" placeholder="your address"></textarea>
                 <output class="add"></output>
              </div>

              <div class="row">
                <div class="col-md-6">
                   <div class="custom-file">
                  <input type="file" name="uphoto" class="custom-file-input" id="uphoto">
                  <label class="custom-file-label" for="uphoto">your profile  (Optional)</label>
                  <output class="picerror"> </output>
                </div>

                </div>
 
                <div class="col-md-6">
                  
                <div class="card">
                  <img id="existphoto" class="img-fluid img-responsive img-thumbnail"  width="250px" height="150px" alt="update photo">
                </div>
    
                </div>
 

              </div>
                            
                         
              
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                         <input type="hidden" name="hidden_user_id" id="hidden_user_id">

                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" >Update</button>
                        
            </div>
        
          </form>
        </div>
      </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./external.js"></script>
 
  </body>
</html>