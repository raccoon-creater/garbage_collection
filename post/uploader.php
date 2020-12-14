<?php
//uploader.php 画像投稿・透過・編集機能

require 'vendor/autoload.php';
require_once __DIR__ . '/post.php';

class ImageUploader{

    private $_imageFileName;
    private $_imageType;

    public function upload(){
        try{
            //error check
            $this->_validateUpload();

            //type check
            $ext = $this->_validateImageType();

            //save
            $savePath = $this->_save($ext);

            //create thumbnail
            // $this->_createThumbnail($savePath);

            //DBに投稿の内容を登録
            $userId = 1;
            $rarity = $_POST['rarity'];
            $get_place = $_POST['get_place'];

            require_once __DIR__ . '/../classes/upload.php';
            $upload = new Upload();
            $upload->addPost($userId,$savePath,$rarity,$get_place);

        }catch(\Exception $e){
            echo $e->getMessage();
            exit;
        }

        header('Location: /garbage_collection/post/post.php');
        exit;
    }

    private function _createThumbnail($savePath) {
        $imageSize = getimagesize($savePath);
        $width = $imageSize[0];
        $height = $imageSize[1];
        if ($width > THUMBNAIL_WIDTH || $height > THUMBNAIL_HEIGHT) {
            $this->_createThumbnailMain($savePath, $width, $height);
        }
    }
    
    private function _createThumbnailMain($savePath, $width, $height) {
        switch($this->_imageType) {
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($savePath);
                break;
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($savePath);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($savePath);
                break;
        }
        // $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
        // $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
        $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
        imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $width, $height);
    
        switch($this->_imageType) {
            case IMAGETYPE_GIF:
                imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
        }
    }

    private function _save($ext){
        $this->_imageFileName = sprintf(
            '%s_%s.%s',time(),
            sha1(uniqid(mt_rand(),true)),
            $ext
        );
        $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
        $res = move_uploaded_file($_FILES['image']['tmp_name'],$savePath);
        if($res === false){
            throw new \Exception('Could not upload!');
        }
        $client = new GuzzleHttp\Client();
        $res = $client->post('https://api.remove.bg/v1.0/removebg', [
            'multipart' => [
                [
                    'name'     => 'image_file',
                    'contents' => fopen('images/' . $this->_imageFileName, 'r')
                ],
                [
                    'name'     => 'size',
                    'contents' => 'auto'
                ]
            ],
            'headers' => [
                'X-Api-Key' => ''
            ]
        ]);
        
        $fp = fopen('images/' . $this->_imageFileName, "wb");
        fwrite($fp, $res->getBody());
        fclose($fp);

        return $savePath;
    }

    private function _validateImageType(){
        $this->_imageType =  exif_imagetype($_FILES['image']['tmp_name']);
        switch($this->_imageType){
            case IMAGETYPE_GIF:
                return'gif';
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';
            default:
                throw new \Exception('PNG/JPEG/GIF only!');
        }
    }

    private function _validateUpload(){
        // var_dump($_FILES);
        // exit;
        if(!isset($_FILES['image']) || !isset($_FILES['image']['error'])){
            throw new \Exception('Upload Error!');
        }

        switch($_FILES['image']['error']){
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \Exception('File too large!');
            default:
            throw new \Exception('Err: ' . $_FILES['image']['error']);
        }
    }
}