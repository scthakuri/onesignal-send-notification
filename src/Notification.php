<?php

namespace Suresh\Onesignal;

/**
 * Class to send the push notification
 *
 * @package onesignalSendNotification
 * @property string $app_id
 * @property string $rest_api_key
 */
class Notification{

    /**
     * Initilize the Notification class wil app_id and rest_api_key
     * 
     * @param @app_id, @rest_api_key
     */
    public function __construct(string $app_id, string $rest_api_key){
        $this->app_id = $app_id;
        $this->rest_api_key = $rest_api_key;
        $this->filters = [];
        $this->segments = [];
        $this->players_id = [];
    }


    /**
     * Set Notification Body
     * 
     * @param $body
     */
    public function setBody(string $body = ''): self{
        $this->body = $body;
        return $this;
    }


    /**
     * Set Notification Sub Title
     * 
     * @param $subject
     */
    public function setSubtitle(string $subject = ''): self{
        $this->subject = $subject;
        return $this;
    }


    /**
     * Set Notification filter
     * 
     * @param array|null $filter
     */
    public function setFilter(array $filter): self{
        $this->filters[] = $filter;
        return $this;
    }


    /**
     * Set Notification's Player IDs
     * 
     * @param array|null $player_id
     */
    public function setPlayersId($player_id): self{
        $this->players_id = array_merge($this->players_id, (array)$player_id);
        return $this;
    }


    /**
     * Set Custom Data for Notification
     * 
     * @param array $data
     */
    public function setData(array $data): self{
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Send Notification for particular segment
     * 
     * @param array|null $segment
     */
    public function setSegments($segment): self{
        $this->segments = array_merge($this->segments, (array)$segment);
        return $this;
    }


    /**
     * Prepare Notification for Send
     */
    public function prepare(): self{
        $array_data = [
            'app_id' => $this->app_id,
            'contents' => [
                'en' => $this->body,
            ],
        ];

        if (!empty($this->filters)) {
            $array_data['filters'] = $this->filters;
        }

        if (!empty($this->players_id)) {
            $array_data['include_player_ids'] = $this->players_id;
        }

        if (!empty($this->segments)) {
            $array_data['included_segments'] = $this->segments;
        }

        $this->json_data = \json_encode($array_data);

        return $this;
    }


    /**
     * Send Notification
     */
    public function send(){
        $curlOptions = [
            CURLOPT_URL => 'https://onesignal.com/api/v1/notifications',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ' . $this->rest_api_key,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->json_data,
            CURLOPT_SSL_VERIFYPEER => false,
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);
        curl_reset($ch);
        curl_close($ch);

        return $response;
    }
}