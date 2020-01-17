<?php
namespace App\Services;


/**
 * Class Notification
 * @package App\Services
*/
class Notification
{

     private $email;

    /**
     * Notification constructor.
     * @param $email
     * @param FileUploader $fileUploader
     */
     public function __construct($email, FileUploader $fileUploader)
     {
         /* dd($email); show -- admin@admin.com */
         /* dd($fileUploader); show -- instance of FileUploader */
         $this->email = $email;
     }

     public function sendNotification()
     {

     }
}