<?php

namespace App\Ultility;

use App\Ultility\Constant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CropImage {

    private $src;
    private $data;
    private $type; 
    private $file;
    private $img_name;
    private $msg;   

    function __construct($cropInfo, $file) {
        $this->setData($cropInfo,$file);         
    }

    private function getExtension($src) {
        if (!empty($src)) {
            $type = exif_imagetype($src);
            if ($type) {                
                return image_type_to_extension($type);                
            }
        }
        
        return false;
    }

    private function setData($info,$file) {
        if (!empty($info)) {
            $this->data = json_decode(stripslashes($info));
        }
        
         if (!empty($file)) {
            $this->file = $file;
        }
    }

    public function moveFile() {
        $file = $this->file;
        $errorCode = $file->getError();
        
        if ($errorCode === UPLOAD_ERR_OK) {
            //var_dump($file);exit;
            $type = exif_imagetype($file->getPathName());

            if ($type) {
                $extension = image_type_to_extension($type);
                
                $imageName = date('YmdHis') . '.original' . $extension;
                $src = storage_path() . Constant::STORE_AVATAR_PATH. $imageName;

                if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

                    if (file_exists($src)) {
                        unlink($src);
                    }

                    $result = false;
                    try {
                        $result = Storage::disk('public')->put(Constant::AVATAR_PATH . $imageName, File::get($file->getPathName()));
                    } catch (Exception $exc) {
                        
                        return false;
                        //return $exc->getTraceAsString();
                    }
                    //$result = move_uploaded_file($file['tmp_name'], $src);
                    if ($result) {
                        $this->src = $src;
                        $this->type = $type;   
                        
                        return $this->crop($this->src, $this->data);
                        
                    } else {
                        $this->msg = 'Failed to save file';
                    }
                } else {
                    $this->msg = 'Please upload image with the following types: JPG, PNG, GIF';
                }
            } else {
                $this->msg = 'Please upload image file';
            }
        } else {
            $this->msg = $this->codeToMessage($errorCode);
        }
    }

    private function crop($src,$data) {        
        $saveCropImage = false;
        $imageName = date('YmdHis') . '.png';
        try {  
            if (!empty($src) && !empty($data)) {
                $dst = storage_path() . "/app/public" . Constant::AVATAR_PATH . $imageName;
                switch ($this->type) {
                    case IMAGETYPE_GIF:
                        $src_img = imagecreatefromgif($src);
                        break;

                    case IMAGETYPE_JPEG:
                        $src_img = imagecreatefromjpeg($src);
                        break;

                    case IMAGETYPE_PNG:
                        $src_img = imagecreatefrompng($src);
                        break;
                }

                if (!$src_img) {
                    $this->msg = "Failed to read the image file";
                    return;
                }

                $size = getimagesize($src);
                $size_w = $size[0]; // natural width
                $size_h = $size[1]; // natural height

                $src_img_w = $size_w;
                $src_img_h = $size_h;

                $degrees = $data->rotate;

                // Rotate the source image
                if (is_numeric($degrees) && $degrees != 0) {
                    // PHP's degrees is opposite to CSS's degrees
                    $new_img = imagerotate($src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127));

                    imagedestroy($src_img);
                    $src_img = $new_img;

                    $deg = abs($degrees) % 180;
                    $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                    $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                    $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                    // Fix rotated image miss 1px issue when degrees < 0
                    $src_img_w -= 1;
                    $src_img_h -= 1;
                }

                $tmp_img_w = $data->width;
                $tmp_img_h = $data->height;
                $dst_img_w = 220;
                $dst_img_h = 220;

                $src_x = $data->x;
                $src_y = $data->y;

                if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                    $src_x = $src_w = $dst_x = $dst_w = 0;
                } else if ($src_x <= 0) {
                    $dst_x = -$src_x;
                    $src_x = 0;
                    $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
                } else if ($src_x <= $src_img_w) {
                    $dst_x = 0;
                    $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
                }

                if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                    $src_y = $src_h = $dst_y = $dst_h = 0;
                } else if ($src_y <= 0) {
                    $dst_y = -$src_y;
                    $src_y = 0;
                    $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
                } else if ($src_y <= $src_img_h) {
                    $dst_y = 0;
                    $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
                }

                // Scale to destination position and size
                $ratio = $tmp_img_w / $dst_img_w;
                $dst_x /= $ratio;
                $dst_y /= $ratio;
                $dst_w /= $ratio;
                $dst_h /= $ratio;

                $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

                // Add transparent background to destination image
                imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
                imagesavealpha($dst_img, true);

                $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

                if ($result) {                    
                    if (imagepng($dst_img, $dst)) {     
                        $this->img_name = $imageName;
                        $saveCropImage = true;
                        //$saveCropImage = Storage::disk('public')->put(Constant::AVATAR_PATH . date('YmdHis') . '.png', File::get($dst));                                            
                    }else{
                        $this->msg = "Failed to save the cropped image file";
                    }                
                } else {
                    $this->msg = "Failed to crop the image file";
                }

                imagedestroy($src_img);
                imagedestroy($dst_img);
                
                return $saveCropImage;
            }
        } catch (Exception $exc) {
            
            return false;
            //return $exc->getTraceAsString();
        }
    }

    private function codeToMessage($code) {
        $errors = array(
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        );

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return 'Unknown upload error';
    }

    public function getResult() {
        return $this->img_name;       
    }

    public function getMsg() {
        return $this->msg;
    }

}
