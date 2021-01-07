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
            {  $id = $_GET['catid'];
                $th_title = $_POST['title'];
                $th_desc =$_POST['desc'];
                $comment_user =$_SESSION['_userid'];
                $sql= "INSERT INTO `thread` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES 
                        ('$th_title', '$th_desc', '$id', '$comment_user', current_timestamp())";
                 $result= mysqli_query($conn, $sql);
                 $showAlert=true;
                

            }
    ?>
    <?php
        $id = $_GET['catid'];
        $sql= "SELECT * FROM `categories` WHERE `cat_id` = $id ";
        $result= mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result))
            {
                $catname= $row['cat_name'];
                $catdesc= $row['cat_description'];
            }
    ?>
    <!-- INSERT INTO `thread` (`thread_id`, `thread_title`, `thread_desc`, `thread_user`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (NULL, 'issue in install pip', 'unable to download', '0', '1', '0', current_timestamp()); -->

    <?php
          if($showAlert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your thread has been inserted successfully. Please wait for community to respond.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
          }
      ?>
    <!-- Categories -->
    <div class="container my-3">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <center>
                    <h1 class="display-4">Welcome To <?php echo $catname; ?> Forum</h1>
                    <p class="lead"><?php echo $catdesc; ?>

                        <hr>
                    </p>
                </center>
                <p> <strong> FORUM RULES</strong>
                    <br> 1. No Spam / Advertising / Self-promote in the forums
                    <br> 2. Do not post copyright-infringing material
                    <br> 3. Do not post “offensive” posts, links or images
                    <br> 4. Do not cross post questions
                    <br> 5. Do not PM users asking for help
                </p>
            </div>
        </div>
    </div>
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true" ){
    echo'<div class="container">
                <strong><h2>Start a Discussion</h2></strong>
            <form action="'.$_SERVER["REQUEST_URI"].'".$id. method="post">
                <div class="form-group">
                    <label for="title">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your title short.
                    </small>
                </div>
                <div class="form-group">
                    <label for="desc">Illustrate your problem</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>';
    }else{ echo '<div class="container">
        <p class="lead text-secondary">You are not logged in. Please login to start a discussion.</p>
    </div>';
    }

    ?>
    
    <div class="container my-4">
        <h1>Browse Questions</h1>

        <?php
        $id = $_GET['catid'];
        $sql= "SELECT * FROM `thread` WHERE `thread_cat_id` = $id ";
        $result= mysqli_query($conn, $sql);
        $ques=true;
        while($row = mysqli_fetch_assoc($result))
            {   $ques=false;
                $userid = $row['thread_user_id'];
                $id= $row['thread_id'];
                $time= $row['timestamp'];
                
                $title= $row['thread_title'];
                $desc= $row['thread_desc'];
                //removing any tags that could hamper our security
                $title =str_replace("<", "&lt;", $title);
                $title =str_replace(">", "&gt;", $title);
                
                $desc =str_replace("<", "&lt;", $desc);
                $desc =str_replace(">", "&gt;", $desc);
                
                $sql2= "SELECT * FROM `users` WHERE `user_id` = $userid ";
                $result2= mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                echo ' <div class="media my-3">
                <img src="img/user.jpg" width=54px height=54px class="mr-3" alt="...">
                <div class="media-body">
                    <h5 class="mt-0 my-0 font-weight-bold"><a href="thread.php?threadid='.$id.'"  class="text-dark">'.$title.'</a></h5>
                    '.$desc.'</div>'.'<h5 class="mt-0 my-0 font-weight-bold">Asked By : '.$row2["user_name"].' <small> at '.$time.'</small></h5> '.'
            </div>
            <hr>';
            }
        if($ques)
        {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <center>
                    <h1 class="display-4">No Thread Found</h1>
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