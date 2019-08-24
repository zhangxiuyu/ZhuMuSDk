<?php
/**
 * Created by PhpStorm.
 * User: 张秀雨
 * Date: 2019/7/31
 * Time: 9:41
 */

class MeetingZhuMu
{
    private $SendRequest;

    public function __construct($SendRequest)
    {
        $this->SendRequest = $SendRequest;
    }

    public function createMeeting($meetingData)
    {
        return $this->SendRequest->requestUrl($meetingData,'/v3/meeting/create');
    }

    public function getMeeting($meeting)
    {
        return $this->SendRequest->requestUrl($meeting,'/v3/meeting/get');
    }

    public function updateMeeting($meeting)
    {
        return $this->SendRequest->requestUrl($meeting,'/v3/meeting/update');
    }
}