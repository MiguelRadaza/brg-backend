<?php

namespace App\Http\Service;

use App\Http\Service\BaseService;
use \Exception;

class FmcPnsService extends BaseService 
{
    use AuthorizesRequests, ValidatesRequests;
    
    private $endPoint = 'https://fcm.googleapis.com/fcm/send';

    public function validate($parameter)
    {
        if (empty($parameter['device_token'])) {
            throw new Exception("Device token is required", 400);
        }
    }

    public function sendPns($parameter)
    {
        $fields = $this->structureParameters($parameter);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->endPoint);
            curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $response = curl_exec($ch);
            $jsonResp = json_decode($response, true);
            curl_close($ch);
            if (isset($jsonResp['success']) && $jsonResp['success'] >= 1) {
                return array(
                    'success' => true,
                    'body' => $jsonResp
                );
            } else {
                throw new Exception($response, 500);
            }
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    public function structureParameters($parameter)
    {
        $fields = array();
        if (is_array($parameter['device_token'])) {
            $fields['registration_ids'] = $parameter['device_token'];
        } else {
            $fields['registration_ids'] = array($parameter['device_token']);
        }

        $parameter['message'] = isset($parameter['message']) ? $parameter['message'] : '';
        $parameter['title'] = isset($parameter['title']) ? $parameter['title'] : '';
        if (!empty($parameter['data'])) { // to send key value pairs
            $fields['data'] = json_decode($parameter['data'], true);
            $fields['data']['message'] = $parameter['message'];
            $fields['data']['title'] = $parameter['title'];
        }
        $fields['priority'] = 'high';
        $fields = json_encode($fields);

        return $fields;
    }
}
