<?php
//connection 

$con = mysqli_connect('localhost', 'root', '', 'shop');


// create 

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $insert = " INSERT INTO `ccustomers`(`id`, `name`, `age`, `address`, `gender`) VALUES (NULL,'$name',$age,'$address',$gender)";
    mysqli_query($con, $insert);
}


// read 

$select = 'SELECT *FROM `ccustomers`';
$i = mysqli_query($con, $select);




// delete row
if (isset($_GET['delete'])) {
    $d = $_GET['delete'];
    $delete_row = "DELETE FROM `ccustomers` WHERE id=$d ";
    mysqli_query($con, $delete_row);
    header("location: shop.php");
}

//edite
$chack = 3;


$name = "";
$address = "";
$age = 0;


if (isset($_GET['edite'])) {
    $d = $_GET['edite'];
    $select_row = "SELECT *FROM `ccustomers` WHERE id = $d ";
    $ed = mysqli_query($con, $select_row);
    $row_data = mysqli_fetch_assoc($ed);
    $chack = $row_data['gender'];
    $name = $row_data['name'];
    $address = $row_data['address'];

    $age = $row_data['age'];

    // header("location: shop.php");

    if (isset($_POST['Update'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $Update = "UPDATE `ccustomers` SET name='$name',age =$age , address='$address', gender = $gender WHERE id= $d";
        mysqli_query($con, $Update);
        header("location: shop.php");
    }
}







$select_state = "SELECT * FROM `state`";
$i_state = mysqli_query($con, $select_state);
$display = mysqli_fetch_assoc($i_state);
$ck = $display['state'];
// print_r($i) ;



if (isset($_GET['state'])) {
    if ($_GET['state'] == "lights") {
        $Update = "UPDATE `state` SET state='lights'";
        mysqli_query($con, $Update);
        header("location: shop.php");
    }else{
        $Update = "UPDATE `state` SET state='black'";
        mysqli_query($con, $Update);
        header("location: shop.php");

    }
    
}



?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>CRUD FROM API</title>

    <link href="main.css" rel="stylesheet">
</head>



<!-- my error -->

<?php if ($ck == "lights") {  ?>
    <body class="lights ">
        <div class="container">
            <a href="?state=black"  class="btn btn-dark m-4" name="black">black</a>
        </div>
    
    
<?php } else { ?>
        <body class="black">
            <div class="container">
                <a href="?state=lights" class="btn btn-light m-4" name="lights">lights</a>
            </div>

        
<?php }; ?>





        <nav class="navbar navbar-dark bg-mynav">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">My App</a>
            </div>
        </nav>

        <section class="container">



            <form action="" method="post" class="col-6 m-auto">
            <h1>create new coustomer</h1>

                <label for="name"> Name</label>
                <input type="text" name="name" id="" class="form-control" value="<?= $name; ?>">

                <label for="age">Age</label>
                <input type="number" name="age" id="" class="form-control" value="<?= $age; ?>">

                <label for="address">Address</label>
                <input type="text" name="address" id="" class="form-control" value="<?= $address ?>">
                <br>
                <?php if ($chack == 1) { ?>

                    <input type="radio" name="gender" id="" checked value="true">
                    <label for="gender">Male</label><br>
                    <input type="radio" name="gender" id="" value="false">

                    <label for="gender">Female</label>
                    <br>
                    <button type="submit"class="btn btn-secondary" name="Update">Update </button>


                <?php } elseif ($chack == 0) { ?>
                    <input type="radio" name="gender" id="" value="true">
                    <label for="gender">Male</label><br>
                    <input type="radio" name="gender" checked id="" value="false">
                    <label for="gender">Female</label><br>
                    <button type="submit"class="btn btn-secondary" name="Update">Update </button>

                <?php } else { ?>
                    <input type="radio" name="gender" id="" value="true">
                    <label for="gender">Male</label><br>
                    <input type="radio" name="gender" id="" value="false">
                    <label for="gender">Female</label><br>
                    <button type="submit"class="btn btn-info mt-3" name="send">Create</button>
                <?php }; ?>



            </form>

        </section>

        <div class="container">
            <div class="d-flex bd-highlight mb-3">
                <div class="me-auto p-2 bd-highlight">
                    <h2>Users
                </div>
            </div>

            <div class="table-responsivetable-dark text-center text-white mt-4">
                <table class="table">
                    <thead>
                        <tr class="table-dark text-center text-white mt-4">
                            <th scope="col">#</th>
                            <th scope="col">Name </th>
                            <th scope="col">Age</th>
                            <th scope="col">address</th>
                            <th scope="col">gender</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>

                        </tr>
                    </thead>
                    <tbody id="mytable">
                        <?php $count = 0; ?>
                        <?php foreach ($i as $itms) : ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <th><?= $itms['name'] ?></th>
                                <th><?= $itms['age'] ?></th>
                                <th><?= $itms['address'] ?></th>
                                <?php if ($itms['gender']) : ?>
                                    <th>Male</th>
                                <?php else : ?>
                                    <th>Female</th>
                                <?php endif; ?>


                                <td><a href="?delete=<?= $itms['id'] ?>" class="btn btn-danger">Delete</a></td>
                                <td><a href="?edite=<?= $itms['id'] ?>" class="btn btn-warning">Edite</a></td>


                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="index.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </body>

</html>