<?php
session_start();
require("conection.php");
require_once ("component.php");
$sql = "SELECT * FROM menu";
$result = mysqli_query($conn, $sql);


if (isset($_POST['remove'])){
  if ($_GET['action'] == 'remove'){
      foreach ($_SESSION['cart'] as $key => $value){
          if($value["product_id"] == $_GET['id']){
              unset($_SESSION['cart'][$key]);
              //echo "<script>alert('Product has been Removed...!')</script>";
              echo "<script>window.location = 'cart.php'</script>";
          }
      }
  }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php
    require_once ('header.php');
?>
<form action="save_purchase.php" method="POST">
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6>My Cart</h6>
                    <hr>

                    <?php

                    $total = 0;
                        if (isset($_SESSION['cart'])){
                            $product_id = array_column($_SESSION['cart'], 'product_id');
                            while ($row = mysqli_fetch_assoc($result)){
                                foreach ($product_id as $id){
                                    if ($row['id'] == $id){
                                        cartElement($row['img'], $row['dishname'],$row['price'], $row['id'], $row['vendor']);
                                        $total = $total + (int)$row['price'];
                                    }
                                }
                            }
                        }else{
                            echo "<h5>Cart is Empty</h5>";
                        }

                    ?>

                </div>
            </div>
            <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

                <div class="pt-4">
                    
            
                    <div class="row price-details">
                    <div class="col-md-6">Number of dishes: </div>
                        <div class="col-md-6">
                            <?php
                                if (isset($_SESSION['cart'])){
                                    $count  = count($_SESSION['cart']);
                                    echo "<h6> $count (dishes)</h6>";
                                }else{
                                    echo "<h6>0 (dishes)</h6>";
                                }
                            ?>
                        </div>
                    
                    </div>
                    <hr>
                    <div class="row price-details">
                        <div class="col-md-6">Total of payment: </div>    
                        <div class="col-md-6">
                            <h6><?php echo $total; ?> VND</h6>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-warning">PAY</button>
                </div>

            </div>
        </div>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
