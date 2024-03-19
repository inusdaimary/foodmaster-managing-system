<?php

if (isset($_POST['req_type'])) {
    include('connection.php');
    switch ($_POST['req_type']) {

        case 'savefooditems':
            save_fooditems($conn, $_POST, $_FILES);
            break;
        case 'getfooddatalist':
            getfooddatalist($conn, $_POST);
            break;

        case 'deletefooditems':
            deletefooditems($conn, $_POST);
            break;
        case 'updatestatus':
            updatestatus($conn, $_POST);
            break;
    }


    // $conn->close();
}


function  save_fooditems($conn, $data,$file)
{


    // if ( 0 < $file['image']['error'] ) {
    //     echo 'Error: ' .  $file['image']['error'] . '<br>';
    // }
    // else {
    //     move_uploaded_file($file['image']['tmp_name'], 'image/' .  $file['image']['name']);
    //     echo 'done';
    // }

    // echo json_encode($file);
    // die();

    $date = date("Ymd_His");
    

        $fileType  = strtolower(pathinfo($file['image']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ["jpg", "jpeg", "png"];
        if (!in_array($fileType, $allowedExtensions)) {
            return ['status' => 0, 'message' => "Sorry, only JPG, JPEG, PNG , PDF files are allowed."];
            exit;
        }
        $newFileName = $date . "." . $fileType;
    
            if ($file['image']) {
                $image  = $newFileName;
            };

           
       


    
    if ($data['fooditemId'] == '') {
        $foodtype   = $data['foodtype'];
        $foodname   = $data['foodname'];
        $mrp       =   $data['mrp'];
        $sellingprice       =   $data['sellingprice'];
        $Total_QTY  = $data['Total_QTY'];
        $QTY_left   = $data['QTY_left'];
        $date = $data['date'];
        $status  = $data['status'];

        $query = mysqli_query($conn, "INSERT INTO  fooditems(foodtype,foodname,mrp,sellingprice,totalqty,qtyleft,image,status,created_at)VALUE('$foodtype','$foodname','$mrp', '$sellingprice','$Total_QTY', '$QTY_left', '$image','$status','$date')");
        if ($query) {
            echo  json_encode(['status' => 1, 'message' => 'Data  saved Successfully']);
            if (!empty($file['image']["name"])) {
                 addimage($file,  $image);
            }

          
        
        }
    } else if ($data['fooditemId'] != '') {
        $fooditemId =  $data['fooditemId'];
        $foodtype   = $data['foodtype'];
        $foodname   = $data['foodname'];
        $mrp       =   $data['mrp'];
        $sellingprice       =   $data['sellingprice'];
        $date = $data['date'];
        $query = mysqli_query($conn, "UPDATE fooditems SET foodtype='" . $foodtype . "',  foodname='".$foodname."', sellingprice='". $sellingprice."', mrp='" . $mrp . "', image='".$image."', created_at='" . $date . "' WHERE id=" . $fooditemId);
        if ($query) {
            echo  json_encode(['status' => 1, 'message' => 'Data  Update Successfully']);
            if (!empty($file['image']["name"])) {
                addimage($file,  $image);
           }
        }
    }
}



function addimage($files,  $newFileName)
{
    $file = $files['image'];
    $targetDir = "image/";

    	
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $originalFileName = $file['name'];

    $maxFileSize = 10000000; // 10MB
    if ($file['size'] > $maxFileSize) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return 0;
    } else {
        if (move_uploaded_file($file['tmp_name'], $targetDir . $newFileName)) {
            //    return json_encode(['status' => 1, 'image' => 'Document Uploaded Successfull']);

            return 1;
        } else {
            return 0;
        }
    }
}


function getfooddatalist($conn, $data)
{
    $foodtype = $data['foodtype'];


    if($data['foodtype'] == 'All'){
        $sql = mysqli_query($conn, "SELECT * FROM  fooditems");
        $i = 1;
        $html = '';

        $html  = '<table  class="table table-bordered" id="fooddatatbale">';
        $html .= "<thead>
                     <tr>
                        <th style='background-color:#82b639;color:white;'>#</th>
                        <th style='display:none'>id</th>
                        <th style='background-color:#82b639;color:white;'>FoodType</th>
                        <th style='background-color:#82b639;color:white;'>FoodName</th>
                        <th style='background-color:#82b639;color:white;'>Mrp</th>
                        <th style='background-color:#82b639;color:white;'>SellingPrice</th>
                        <th style='background-color:#82b639;color:white;'>Total qty</th>
                        <th style='background-color:#82b639;color:white;'>Qty left</th>
                        <th style='background-color:#82b639;color:white;'>Created_at</th>
                        <th style='background-color:#82b639;color:white;'>Image</th>
                        <th style='background-color:#82b639;color:white;'>Status</th>
                        <th style='display:none'></th>
                        <th style='background-color:#82b639;color:white;'>Action</th>
                        <th style='background-color:#82b639;color:white;'>Delete</th>
                     </tr>
              </thead><tbody>";

        while ($row = mysqli_fetch_array($sql, MYSQLI_BOTH)) {

            if ($row['status'] == 1) {
                $button = '<button class="btn btn-warning" id="edit_btn">Edit</button>';
            } else {

                $button   = '<button deasabled class="btn btn-secondary"  id="edit_btn">Edit</button>';
            }

            if ($row['status'] == 1) {

                $status = '<button class="btn btn-success btn-sm" id="status_btn_a"><i class="fa-solid fa-square-check"></i>&nbsp;Active</button>';
            } else {
                $status = '<button class="btn btn-secondary btn-sm" id="status_btn_ina"><i class="fa-solid fa-square-xmark"></i>&nbsp;Inactive</button>';
            }

            $onClick = "imageinmodak('".$row['image']."')";

            $deletebtn  = '<button class="btn btn-danger btn-sm" id="delete_btn"><i class="fa-solid fa-square-check"></i>&nbsp;Delete</button>';

              $image  = '<img src="image/'.$row['image'].'" style="width: 100%;height: 54px; border-radius: 10px;" 
              onClick= "'.$onClick.'"></img>';

            //   '.imageinmodak($row['image']).'
     
            $html  .= '<tr>
                     <td>' . $i++ . '</td>
                     <td style="display:none">' . $row['id'] . '</td>
                     <td>' . $row['foodtype'] . '</td>
                     <td>' . $row['foodname'] . '</td>
                     <td>' . $row['mrp'] . '</td>
                     <td>' . $row['sellingprice'] . '</td>
                     <td>' . $row['totalqty'] . '</td>
                     <td>' . $row['qtyleft'] . '</td>
                     <td>' . $row['created_at'] . '</td>
                     <td>' .$image . '</td>
                     <td>' . $status . '</td>
                     <td style="display:none">' . $row['status'] . '</td>
                     <td>' . $button . '</td>
                     <td>' . $deletebtn . '</td>
             </tr>';
        }


        $html .=  '</tbody></table>';
        echo json_encode(['status'  => 1, 'table' =>  $html]);
                 
    }

 else  if ($foodtype) {
        $sql = mysqli_query($conn, "SELECT * FROM  fooditems WHERE foodtype = '$foodtype' ");
        $i = 1;
        $html = '';

        $html  = '<table  class="table table-bordered" id="fooddatatbale">';
        $html .= "<thead>
                     <tr>
                        <th style='background-color:#82b639;color:white;'>#</th>
                        <th style='display:none'>id</th>
                        <th style='background-color:#82b639;color:white;'>FoodType</th>
                        <th style='background-color:#82b639;color:white;'>FoodName</th>
                        <th style='background-color:#82b639;color:white;'>Mrp</th>
                        <th style='background-color:#82b639;color:white;'>SellingPrice</th>
                        <th style='background-color:#82b639;color:white;'>Total qty</th>
                        <th style='background-color:#82b639;color:white;'>Qty left</th>
                        <th style='background-color:#82b639;color:white;'>Created_at</th>
                        <th style='background-color:#82b639;color:white;'>Image</th>
                       
                        <th style='background-color:#82b639;color:white;'>Status</th>
                        <th style='display:none'></th>
                        <th style='background-color:#82b639;color:white;'>Action</th>
                        <th style='background-color:#82b639;color:white;'>Delete</th>
                     </tr>
              </thead><tbody>";

        while ($row = mysqli_fetch_array($sql, MYSQLI_BOTH)) {

            if ($row['status'] == 1) {
                $button = '<button class="btn btn-warning" id="edit_btn">Edit</button>';
            } else {

                $button   = '<button deasabled class="btn btn-secondary"  id="edit_btn">Edit</button>';
            }

            if ($row['status'] == 1) {

                $status = '<button class="btn btn-success btn-sm" id="status_btn_a"><i class="fa-solid fa-square-check"></i>&nbsp;Active</button>';
            } else {
                $status = '<button class="btn btn-secondary btn-sm" id="status_btn_ina"><i class="fa-solid fa-square-xmark"></i>&nbsp;Inactive</button>';
            }

            $onClick = "imageinmodak('".$row['image']."')";

            $deletebtn  = '<button class="btn btn-danger btn-sm" id="delete_btn"><i class="fa-solid fa-square-check"></i>&nbsp;Delete</button>';

              $image  = '<img src="image/'.$row['image'].'" style="width: 100%;height: 54px; border-radius: 10px;" 
              onClick= "'.$onClick.'"></img>';

            //   '.imageinmodak($row['image']).'
     
            $html  .= '<tr>
                     <td>' . $i++ . '</td>
                     <td style="display:none">' . $row['id'] . '</td>
                     <td>' . $row['foodtype'] . '</td>
                     <td>' . $row['foodname'] . '</td>
                     <td>' . $row['mrp'] . '</td>
                     <td>' . $row['sellingprice'] . '</td>
                     <td>' . $row['totalqty'] . '</td>
                     <td>' . $row['qtyleft'] . '</td>
                     <td>' . $row['created_at'] . '</td>
                     <td>' .$image . '</td>
                     <td>' . $status . '</td>
                     <td style="display:none">' . $row['status'] . '</td>
                     <td>' . $button . '</td>
                     <td>' . $deletebtn . '</td>
             </tr>';
        }


        $html .=  '</tbody></table>';
        echo json_encode(['status'  => 1, 'table' =>  $html]);
    } else {

        echo 'error';
    }
}

function deletefooditems($conn, $data)
{


    $id = $data['id'];

    $sql = mysqli_query($conn, "DELETE FROM fooditems WHERE id=" . $id);

    if ($sql) {
        echo  json_encode(['status' => 1, 'message' => 'Data  Deleted Successfully']);
    }
}


function updatestatus($conn, $data){
      $id = $data['id'];

    $status =  $data['status'];


   $sql = mysqli_query($conn, "UPDATE fooditems SET status='".$status."' WHERE id=" . $id);


   if ($sql) {
    echo  json_encode(['status' => 1, 'message' => 'Status  Updated Successfully']);
}
}