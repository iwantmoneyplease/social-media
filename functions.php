<?php 
function displayMsg($type, $string){
    echo " <div class='alert alert-{$type}' role='alert'>
                <p>{$string}</p>
            </div>
        ";
}
function uploadImg($i, $conn, $last_project_id){
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
    $ogtarget = $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if($_POST["posttype"] === "create") {
    $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
        if($check !== false)
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file))
    {
        $index = 1;
        $target_file = $target_dir . pathinfo($ogtarget,PATHINFO_FILENAME) . "-" . $index . "." . $imageFileType;
        while(file_exists($target_file)) {
            $index = $index + 1;
            $target_file = $target_dir . pathinfo($ogtarget,PATHINFO_FILENAME) . "-" . $index . "." . $imageFileType;
        }
        echo "New name: " . $target_file;
    }

    // Check file size
    if ($_FILES["files"]["size"][$i] > 500000)
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" )
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }
        else {
        if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file))
        {
            echo "The file ". htmlspecialchars( basename( $_FILES["files"]["name"][$i])). " has been uploaded.";

            $sql = "INSERT INTO images (url) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $target_file);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    return $target_file;
}

function createThumbnail(){
    
}
?>