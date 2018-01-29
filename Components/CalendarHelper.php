<?php

namespace Bootstrap\Components;
use \DateTime;
use \DateTimeZone;

trait CalendarHelper {

    /**
     * The model instance. Models are responsible for querying and storing data.
     * They also provide variable, session and validation functionality as well as other useful utility methods.
     *
     * @var \Bootstrap\Models\BootstrapModel $this->model
     */
    public $model;

    /**
     * Users own action (playaction)
     *
     * @var
     */
    public $actionid;

    /**
     * Action id for the config object (action itself)
     */
    public $action_id;

    /**
     * @param $obj
     * @return mixed
     */

    /* 20180129T123000Z */
    public function getCalendarTemplate($parameters){

        if(!isset($parameters['starttime'])){
            $this->errors[] = 'Missing start time';
        }

        if(!isset($parameters['endtime'])){
            $this->errors[] = 'Missing end time';
        }

        if(!isset($parameters['subject'])){
            $this->errors[] = 'Missing subject time';
        }

        if(!isset($parameters['organizer'])){
            $this->errors[] = 'Missing organizer';
        }

        if(!isset($parameters['organizer_email'])){
            $this->errors[] = 'Missing organizer email';
        }

        $starttime = $this->convertUnixTimeToCalendar($parameters['starttime']);
        $endtime = $this->convertUnixTimeToCalendar($parameters['endtime']);
        $subject = $parameters['subject'];
        $organizer = $parameters['organizer'];
        $organizer_email = $parameters['organizer_email'];

        $template =
"BEGIN:VCALENDAR
VERSION:2.0
CALSCALE:GREGORIAN
PRODID:Appzio
METHOD:REQUEST
BEGIN:VEVENT
DTSTART:$starttime
DTEND:$endtime
DTSTAMP:".$this->convertUnixTimeToCalendar(time()) ."
ORGANIZER;CN=$organizer:mailto:$organizer_email
UID:".\Helper::generateShortcode('15')."@appzio.com
CREATED:".$this->convertUnixTimeToCalendar(time());

        if(isset($parameters['description'])){
            $template .= chr(10).'DESCRIPTION:'.$parameters['description'].chr(10);
        }
        if(isset($parameters['location'])){
            $template .= chr(10).'LOCATION:'.$parameters['location'].chr(10);
        }
        if(isset($parameters['description'])){
            $template .= chr(10).'DESCRIPTION:'.$parameters['description'].chr(10);
        }

        $template .= "LAST-MODIFIED:".$this->convertUnixTimeToCalendar(time()) ."
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:$subject
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
";
        return $template;
    }

    public function convertUnixTimeToCalendar($time){
        $difference = $this->get_timezone_offset('Europe/London');
        $time = $time-$difference;
        $time = date('Y-m-d H:i',$time);
        $time = new DateTime($time, new DateTimeZone('Europe/London'));
        $output = $time->format('Ymd') .'T' .$time->format('Hi') .'00Z';
        return $output;
    }

    function get_timezone_offset($remote_tz,$origin_tz = null) {
        if($origin_tz === null) {
            if(!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime("now", $origin_dtz);
        $remote_dt = new DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
        return $offset;
    }



}