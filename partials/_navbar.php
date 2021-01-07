<?php 
 include 'partials/_loginModal.php';
 include 'partials/_dbconnect.php';
 include 'partials/_signupModal.php';
 session_start();
 $login = false;
 if(isset($_SESSION['loggedin']) &&$_SESSION['loggedin']=="true" ){
  $login = true;
 }
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Let\'s Discuss</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Categories
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
          
          $sql= "SELECT * FROM `categories` ";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            $id =  $row["cat_id"];
            echo '<a class="dropdown-item" href="threads.php?catid='.$id.'">'.$row["cat_name"].'</a>';
          } 
          echo ' </div>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="contact.php" tabindex="-1">Contact Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" id="search" name="search" aria-label="Search">
        <button class="btn btn-success ml-2 my-sm-0" type="submit">Search</button>
     </form>';
     if($login){
          echo ' <p class="text-light my-0 mx-2 ">Welcome '.$_SESSION['username'].'</p>
          <a href="partials/_handlelogout.php" class="btn btn-success ml-0">Logout</a>';
          //  <a class="nav-link" href="/loginsys/logout.php">Logout</a>
           }else{ echo '<button class="btn btn-outline-success ml-2 my-sm-0"  data-toggle="modal" data-target="#loginModal" >Login</button>
      <button class="btn btn-outline-success ml-2 my-sm-0"  data-toggle="modal" data-target="#signupModal" >Signup</button>';
      }
      echo '
    </div>
  </nav>';
    if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
    echo ' <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> Your account has been successfully created. You can now login.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
             </div> ';
  }
  if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
    echo ' <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Failed!</strong> '.$_GET['error'].'!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
             </div> ';
  }

  if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="true"){
    echo ' <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong>  You are now loggedin.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
             </div> ';
  }
  if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false"){
    echo ' <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Failed!</strong> '.$_GET['error'].'!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
             </div> ';
  }

?>