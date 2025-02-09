<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/add-item.css"/>
    <link rel="stylesheet" href="css/font.css" />
    <title>Restaurant | Add Item</title>
</head>
<body>
    <?php
    error_reporting(E_ERROR | E_PARSE);
     //Image Upload
        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
                
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"images/foods/".$file_name);
                echo "<p style='color:white'>images/foods/".$file_name."</p>";
                echo "<p style='color:white'>Success</p";
                $item_image = "images/foods/".$file_name;
            }else{
                print_r($errors);
            }
        }
    ?>

    <?php
        // DB Connection
        include("config/db-connect.php");
        $form_error = "";
        $success_message = "";

        if(isset($_POST["submit"])){
            $item_name = mysqli_real_escape_string($conn, $_POST["item_name"]);
            // $item_image = mysqli_real_escape_string($conn, $_POST["item_image"]);
            $item_price = mysqli_real_escape_string($conn, $_POST["item_price"]);
            $item_type = mysqli_real_escape_string($conn, $_POST["item_type"]);
            $restaurant_id = 1;            

            $query_insert = "INSERT INTO food_item(item_name, item_image, restaurant_id, item_price, item_type) VALUES('$item_name', '$item_image', '$restaurant_id', '$item_price', '$item_type')";
            $query_insert_db = mysqli_query($conn, $query_insert);

            if($query_insert_db){
                $success_message = "Item added";
                // header('Location: '.$_SERVER['REQUEST_URI']);
                echo "<script type='text/javascript'>location.reload(true);</script>";
                // echo "<script>window.location.href='add-item.php'</script>";
            }
            else{
                $form_error = "Not inserted";
            }
        }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php include("logo.html") ?>
        <div class="container">
            <h1>Add a new Item</h1>
            <div class="box">
                <span class="error"><?php echo $success_message; ?></span>
                <span class="error"><?php echo $form_error; ?></span>
                <span><label for="item_name">Item Name</label><span class="error"></span></span>
                <input type="text" name="item_name" id="item_name" required/>
                <!-- <span><label for="item_image">Item Image</label><span class="error"></span></span>
                <input type="file" name="item_image" id="item_image" required/> -->
                <span><label for="item_price">Item Price</label><span class="error"></span></span>
                <input type="number" name="item_price" id="item_price" required/>
                <div class="preference">
                    <input type="radio" value="Veg" name="item_type" id="item_type" required>Veg</input>
                    <input type="radio" value="Non Veg" name="item_type" id="item_type" required>Non Veg</input>
                </div> 
                <form action="" method="POST" enctype="multipart/form-data">
                    <span><label for="item_image">Item Image</label><span class="error"></span></span>
                    <input type="file" name="image" />
                    <!-- <input type="submit"/> -->
                </form>
                <div>
                    <button type="submit" name="submit">Add Item</button>
                </div>
            </div>
        </div>
    </form>
    <?php include("footer.html") ?>
</body>
</html>