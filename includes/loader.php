<?php 
require_once "constants.php";
// This function loads the head file and recibes as a parameter
// the title of the page, this value changes the name of the page tab.
function loadHead($title){
    
    include_once FOLDER_COMPONENTS . "head.php";
}

// This function loads components from the componets folder
// receiving as parameter the name of the component and then 
// includes the component in the file where the function is called. 
function loadComponent($component){
    
    include FOLDER_COMPONENTS . "$component.php";
}

// This funtion loads images it recives two parameters, 
// image name [file_name.file_type] and class name [class_name]
// FOLDER_IMAGE is a constant define in the constants.php. 
// FOLDER_IMAGE  contain the folder path to the images of the website.
// When the link parameter is true the image will have a link to a page outside of the site.
function loadImage($imageName,$class='',$link=false){

    $image = FOLDER_IMAGES . $imageName;
    if($link){
        echo "<a href='https://scrumfit.co/'><img src='$image' class='$class'/></a>";
    }
    else
    {
        echo "<img src='$image' class='$class'/>";
    }
    
}

// This function receives 2 arguments, an array with names of 
// images and a css class to aply to the image element.
// the shuffle function helps reorganize randomly the elememnts inside the array
// the index always stay in the same position.
// if no value is pass into the class parameter it will be assume to be empty

function adsRandom($imageArray,$class=''){
    // reorganize the elements inside of the array
    shuffle($imageArray);
    // This conditional selects the image for the must expensive advertisement.

    if($imageArray[0]== 'ads_1.png'){
        $class = 'bigAds';
    }
    
    loadImage($imageArray[0],$class,true);

}

// head funciton

function loadTopElements($pageName){
    loadHead($pageName);
    // the loadComponet function receives as a parameter a string 
    // with the name of the componet that should be included.
    loadComponent("topBar");
    loadComponent("navbar");
    
}

// ORDER FILE HANDLING 
function appendOrder($order,$path)
{
  $orderFileContent = file_get_contents($path);
  $array_orders = json_decode($orderFileContent);
  $array_orders [] = $order;
  $json_orders = json_encode($array_orders);
  file_put_contents($path,$json_orders);
}


//ORDERS TABLE

function loadOrders()
{
    $myfile = file_get_contents(FILE_ORDERS);
    $array_order_json = json_decode($myfile,true);

    ?>
    <table>
    <tr>
    <th>Product Code</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>City</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Comment</th>
    <th>Sub Total</th>
    <th>Tax Amount</th>
    <th>Grand Total</th>
    </tr>
    <?php 
        foreach($array_order_json as $value)
        {
    ?>

    <tr>
    <td><?php echo $value["productCode"]; ?></td>
    <td><?php echo $value["firstName"]; ?></td>
    <td><?php echo $value["lastName"]; ?></td>
    <td><?php echo $value["city"]; ?></td>
    <td><?php echo $value["price"]. '$'; ?></td>
    <td><?php echo $value["quantity"]; ?></td>
    <td><?php echo $value["comments"]; ?></td>
    <td class="<?php changeSubTotalColor($value["subTotal"]); ?>"><?php echo $value["subTotal"]. '$'; ?></td>
    <td><?php echo $value["taxAmount"]. '$'; ?></td>
    <td><?php echo $value["grandTotal"] . '$'; ?></td>
    </tr>
    <?php 
        }
    ?>
    </table>
    <?php
}



function changeSubTotalColor($value){
    if($_GET['command'] == 'color')
    {
        if($value < 100){
            echo "red-text";
        }
        elseif($value < 1000)
        {
            echo "lightOrange-text";
        }
        else
        {
            echo "green-text";
        }
    }    
}

function bgChange(){
    if($_GET['command'] == 'print')
    {
        echo 'white';
    }
    else
    {
        echo 'primary';
    }

}

?>