<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Let's Discuss</title>
</head>

<body>

    <?php include 'partials/_navbar.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php
        $showAlert=false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method =="POST")
            {  $id = $_GET['threadid'];
                $content = $_POST['comment'];
                $content =str_replace("<", "&lt;", $content);
                $content =str_replace(">", "&gt;", $content);
                $comment_user =$_SESSION['_userid'];
                $sql= "INSERT INTO `comments` (`com_id`, `com_content`, `thread_id`, `com_time`, `com_user_id`)
                                 VALUES (NULL, '$content', '$id', current_timestamp(), '$comment_user')";
                 $result= mysqli_query($conn, $sql);
                 $showAlert=true;
                

            }
    ?>

    <?php
        $id = $_GET['threadid'];
        $sql= "SELECT * FROM `thread` WHERE `thread_id` = $id ";
        $result= mysqli_query($conn, $sql);
        
        while($row = mysqli_fetch_assoc($result))
            {   $thread_cat= $row['thread_cat_id'];
                $title= $row['thread_title'];
                $desc= $row['thread_desc'];
            }
    ?>
     <!-- alert on successfull comment post -->
    <?php
          if($showAlert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your comment has been successfully posted. Thanks for your respond.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
          }
      ?>
    <!-- Categories -->
    <div class="container my-3">
        <div class="jumbotron jumbotron-fluid">
            <div class="container" style="text-align:center;">
                <span>
                    <h2 class="display-4"> <img src="img/user.jpg" style=" align-content:left;" width=54px height=54px
                            class="mr-3" alt="...">
                        <?php echo $title; ?> </h2>
                </span>
                <p class="lead"><?php echo $desc; ?>
                </p>
                <p>Posted By : <strong><?php echo $_SESSION['username']; ?></strong></p>
            </div>
        </div>
        
    </div>
    <?php 
    if(isset($_SESSION['loggedin']) &&$_SESSION['loggedin']=="true" ){
    echo '<div class="container">
            <strong>
                <h2>Wanna Help Him Out</h2>
            </strong>
            <form action="'.$_SERVER["REQUEST_URI"] .'".$id. method="post">
                <div class="form-group">
                    <label for="comment">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
            <hr>
        </div>';
    }else{
        echo '<div class="container">
        <p class="lead text-secondary">You are not logged in. Please login to start a discussion.</p>
    </div>';
    }

    ?>
        

    <div class="container my-4">
        <h1>Browse Comments</h1>
                 
        <?php
        $sql= "SELECT * FROM `comments` WHERE `thread_id` = $id ";
        $result= mysqli_query($conn, $sql);
        $ques=true;
        while($row = mysqli_fetch_assoc($result))
            {   $ques=false;
                $userid= $row['com_user_id'];
                // $username= ...
                $com_time = $row['com_time']; 
                $content= $row['com_content'];
                $sql2= "SELECT * FROM `users` WHERE `user_id` = $userid ";
                $result2= mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                echo ' <div class="media my-3">
                <img src="img/user.jpg" width=54px height=54px class="mr-3" alt="...">
                <div class="media-body">
                <h5 class="mt-0 my-0 font-weight-bold">'.$row2["user_name"].' <small> at '.$com_time.'</small></h5> 
                    '.$content.'
                </div>
            </div>
            <hr>';
            }
        if($ques)
        {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <center>
                    <h1 class="display-4">No Results Found</h1>
                    <p class="lead">Be the first one to ask a question.              
               
                </p>
                </center>
                
            </div>
        </div>';
        }
        ?>

    </div>





    <?php include 'partials/_footer.php'; ?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>