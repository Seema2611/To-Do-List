<?php 

//INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'books', 'plz buy books from ', current_timestamp());
$insert=false;
$update=false;
$delete=false;
//connec with database
$servername="localhost:3366";
$username="root";
$password="";
$database="notes";
//create connection
$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn){
  die("Sorry we failed to connect:". mysqli_connect_error());
} 

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = '$sno'";
  $result = mysqli_query($conn, $sql);  // Execute the delete query
  if(!$result){
    echo "Error deleting record: " . mysqli_error($conn); // Handle errors
  }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
  if (isset($_POST['snoUpdate'])){
   //update the record
      $sno=$_POST["snoUpdate"];
      $title=$_POST["titleUpdate"];
      $description=$_POST["descriptionUpdate"];
    //sql query to executed
      $sql="UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = '$sno'" ;
      $result=mysqli_query($conn,$sql);
      if($result){
        $update=true;
      }else{
        echo "we could not update the record successfully";
      }
    }
  else{
        $title=$_POST["title"];
        $description=$_POST["description"];
    //sql query to executed
        $sql="INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
        $result=mysqli_query($conn,$sql);

    if($result){
        //echo "The record has been inserted successfully!<br>";
        $insert=true;
    }else{
        echo "the record was not inserted because of this error---->" . mysqli_error($conn);
    }

}
}


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>inotes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">



</head>

<body>




  <!--update Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">update note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/notes/index.php" method="post">
          <div class="modal-body">

            <input type="hidden" name="snoUpdate" id="snoUpdate">
            <div class="form-group">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleUpdate" name="titleUpdate"><br>

            </div>
            <div class="form-group">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionUpdate" name="descriptionUpdate"></textarea><br>

            </div>

           

          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">To-Do List</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>

        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    ?>

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/notes/index.php" method="post">
      <div class="form-group">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title"><br>

      </div>
      <div class="form-group">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description"></textarea><br>

      </div>

      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container my-4">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT * FROM `notes` ORDER BY `sno` DESC";

        $result=mysqli_query($conn,$sql);
        $sno=0;
        while($row=mysqli_fetch_assoc($result)){
          $sno=$sno + 1;
            echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td> <button class='update btn btn-sm btn-primary' id=" .$row['sno']. ">Update</button>  <button class='delete btn btn-sm btn-primary' id=" .$row['sno']. ">Delete</button> </td>

            </tr>";
           
        }
        
        

        ?>


      </tbody>
    </table>
  </div>
  <hr>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    updates = document.getElementsByClassName('update');
    Array.from(updates).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("update",);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleUpdate.value = title;
        descriptionUpdate.value = description;
        snoUpdate.value = e.target.id;
        console.log(e.target.id)
        $('#updateModal').modal('toggle');


      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        let sno = e.target.id;
        if (confirm("Are you sure you want to delete this note!")) {
          window.location = `/notes/index.php?delete=${sno}`;  
        } else {
      console.log("no");
    }
  });
});

  </script>
</body>

</html>