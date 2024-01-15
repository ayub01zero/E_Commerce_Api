<?php

namespace App\Helper;

class helperfunctions
{

    // public function pushNotification()
    // {

    //     $data=[];
    //     $data['message']= "New order notification has been created successfully";

    //     $data['booking_id']="my booking booking_id";
        
    //     $tokens = [];
    //     $tokens[] = 'ea623e41cab24602a6ea843af9b4588dcd5c52a498341ae5c2baec84fbda6448';
    //     $response = $this->sendFirebasePush($tokens,$data);
    //     return response()->json(['result' => $response]);

    // }
    // public function sendFirebasePush($tokens, $data)
    // {

    //     $serverKey = 'AAAAniEZ8AQ:APA91bGDCjCLqw62zk067H9WQkAC7VKuSolBwG0625DTtwoX3ZhPLsNyTadvPufzrTZUdxnX36Cb5JisBvYLGCyb8-tLuGy4rE2OWMrBfQwBPBsyGNmFB-jaHmcCMOg4cUpurm8V4MNS';
        
    //     // prep the bundle
    //     $msg = array
    //     (
    //         'message'   => $data['message'],
    //         'booking_id' => $data['booking_id'],
    //     );

    //     $notifyData = [
    //          "body" => $data['message'],
    //          "title"=> "Port App"
    //     ];

    //     $registrationIds = $tokens;
        
    //     if(count($tokens) > 1){
    //         $fields = array
    //         (
    //             'registration_ids' => $registrationIds, //  for  multiple users
    //             'notification'  => $notifyData,
    //             'data'=> $msg,
    //             'priority'=> 'high'
    //         );
    //     }
    //     else{
            
    //         $fields = array
    //         (
    //             'to' => $registrationIds[0], //  for  only one users
    //             'notification'  => $notifyData,
    //             'data'=> $msg,
    //             'priority'=> 'high'
    //         );
    //     }
            
    //     $headers[] = 'Content-Type: application/json';
    //     $headers[] = 'Authorization: key='. $serverKey;

    //     $ch = curl_init();
    //     curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    //     curl_setopt( $ch,CURLOPT_POST, true );
    //     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    //     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    //     // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    //     curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    //     $result = curl_exec($ch );
    //     if ($result === FALSE) 
    //     {
    //         die('FCM Send Error: ' . curl_error($ch));
    //     }
    //     curl_close( $ch );
    //     return $result;
    // }



}

