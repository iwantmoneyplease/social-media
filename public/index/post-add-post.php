<?php
require("../../conn.php");

function createThumbnail($filePath, $thumbWidth = 300) {
    $info = getimagesize($filePath);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($filePath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($filePath);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($filePath);
            break;
        default:
            return $filePath;
    }

    $width = imagesx($image);
    $height = imagesy($image);
    $thumbHeight = floor($height * ($thumbWidth / $width));

    $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    $pathInfo = pathinfo($filePath);
    $thumbPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];

    switch ($mime) {
        case 'image/jpeg': imagejpeg($thumb, $thumbPath); break;
        case 'image/png': imagepng($thumb, $thumbPath); break;
        case 'image/gif': imagegif($thumb, $thumbPath); break;
    }

    imagedestroy($image);
    imagedestroy($thumb);

    return $thumbPath;
}
?>

<?php
require("../../conn.php");

if ($_POST) {
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $type = $_POST['post_type'];

    $user_id = 1; // temporary placeholder until accounts are implemented

    $stmt = $conn->prepare("INSERT INTO posts (user_id, post_title, post_content, post_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $type);
    $stmt->execute();
    $post_id = $conn->insert_id;
    $stmt->close();

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $i => $name) {
            $tmpName = $_FILES['images']['tmp_name'][$i];
            $fileName = time() . "_$name";
            $targetDir = "../uploads/";
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFile)) {

                if ($i === 0) {
                    $thumbPath = createThumbnail($targetFile);

                    $stmtThumb = $conn->prepare("UPDATE posts SET upload_url = ? WHERE post_id = ?");
                    $stmtThumb->bind_param("si", $thumbPath, $post_id);
                    $stmtThumb->execute();
                    $stmtThumb->close();
                }

                $stmtImg = $conn->prepare("INSERT INTO post_images (post_id, image_url) VALUES (?, ?)");
                $stmtImg->bind_param("is", $post_id, $targetFile);
                $stmtImg->execute();
                $stmtImg->close();
            }
        }
    }

    $conn->close();
    header("Location: index.php");
}
?>