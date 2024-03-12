<?php
 
   try {
        if (empty($_FILES['file'])) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
            default:
                throw new Exception('An error occured');
        }

        if ($_FILES['file']['size'] > 1000000) {
            throw new Exception('File too large');
        }

        $mime_types = ['image/png', 'image/jpeg', 'image/gif'];
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $_FILES['file']['tmp_name']);
        if (!in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        $pathinfo = pathinfo($_FILES['file']['name']);
        // $fname = $pathinfo['filename'];
        $fname = 'image';
        $extension = $pathinfo['extension'];

        $dest = 'hinh/' . $fname . '.' . $extension;
        $image = $fname . '.' . $extension;
        $i = 1;
        while (file_exists($dest)) {
            $dest = 'hinh/' . $fname . "-$i." . $extension;
            $image = $fname . "-$i." . $extension;
            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
           
        } else {
            throw new Exception('Unable to move file.');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>