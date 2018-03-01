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

        $this->getCalendarErrors( $parameters );

        if ( $this->errors ) {
            return false;
        }

        if(isset($parameters['invitees']) AND is_array($parameters['invitees']) AND $parameters['invitees']) {
            $invitees = true;
        } else {
            $invitees = false;
        }

        // Fix is turned on by default
        $outlook_fix = isset($parameters['outlook_fix']) ? $parameters['outlook_fix'] : true;

        $starttime = $this->convertUnixTimeToCalendar($parameters['starttime']);
        $endtime = $this->convertUnixTimeToCalendar($parameters['endtime']);
        $subject = $parameters['subject'];
        $location = isset($parameters['location']) ? $parameters['location'] : '';
        $organizer = $parameters['organizer'];
        $organizer_email = $parameters['organizer_email'];
        $timezone_offset = isset($parameters['timezone_offset']) ? $parameters['timezone_offset'] : '';

        $template = 'BEGIN:VCALENDAR' . chr(10);
        $template .= 'PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN' . chr(10);
        $template .= 'VERSION:2.0' . chr(10);
        $template .= 'METHOD:PUBLISH' . chr(10);
        $template .= 'X-MS-OLK-FORCEINSPECTOROPEN:TRUE' . chr(10);
        $template .= 'TZ:+00' . chr(10);
        $template .= 'BEGIN:VEVENT' . chr(10);
        $template .= 'CLASS:PUBLIC' . chr(10);
        $template .= 'DESCRIPTION:' . $parameters['description'] . chr(10);

        if ( $timezone_offset ) {
            $template .= 'DTEND;TZID=' . $timezone_offset . ':' . $endtime . chr(10);
            $template .= 'DTSTART;TZID=' . $timezone_offset . ':' . $starttime . chr(10);
        } else {
            $template .= 'DTEND:' . $endtime . chr(10);
            $template .= 'DTSTART:' . $starttime . chr(10);
        }

        $template .= 'LOCATION:' . $location . chr(10);

        if (isset($parameters['repeat_daily_until'])) {
            $template .= 'RRULE:FREQ=DAILY;UNTIL='.$this->convertUnixTimeToCalendar($parameters['repeat_daily_until']) . chr(10);
        }

        if (isset($parameters['repeat_weekly_until'])) {
            $template .= 'RRULE:FREQ=WEEKLY';

            if ( isset($parameters['interval']) ) {
                $template .= ';INTERVAL=' . $parameters['interval'];
            }

            if ( isset($parameters['BYDAY']) ) {
                $template .= ';BYDAY=' . $parameters['BYDAY'];
            }

            $template .= chr(10);
        }

        if (isset($parameters['repeat_monthly_until'])) {
            $template .= 'RRULE:FREQ=MONTHLY';

            if ( isset($parameters['interval']) ) {
                $template .= ';INTERVAL=' . $parameters['interval'];
            }

            if ( isset($parameters['BYMONTHDAY']) ) {
                $template .= ';BYMONTHDAY=' . $parameters['BYMONTHDAY'];
            }

            $template .= chr(10);
        }

        $template .= 'PRIORITY:5' . chr(10);
        $template .= 'SEQUENCE:0' . chr(10);
        $template .= 'SUMMARY;LANGUAGE=en-us:' . $subject . chr(10);
        $template .= 'TRANSP:OPAQUE' . chr(10);
        $template .= 'UID:' . \Helper::generateShortcode('15') . '@appzio.com' . chr(10);
        $template .= 'X-MICROSOFT-CDO-BUSYSTATUS:BUSY' . chr(10);
        $template .= 'X-MICROSOFT-CDO-IMPORTANCE:1' . chr(10);
        $template .= 'X-MICROSOFT-DISALLOW-COUNTER:FALSE' . chr(10);
        $template .= 'X-MS-OLK-ALLOWEXTERNCHECK:TRUE' . chr(10);
        $template .= 'X-MS-OLK-AUTOFILLLOCATION:FALSE' . chr(10);
        $template .= 'X-MS-OLK-CONFTYPE:0' . chr(10);
        $template .= 'BEGIN:VALARM' . chr(10);
        $template .= 'TRIGGER:-PT15M' . chr(10);
        $template .= 'ACTION:DISPLAY' . chr(10);
        $template .= 'DESCRIPTION:' . $parameters['description'] . chr(10);
        $template .= 'END:VALARM' . chr(10);
        $template .= 'END:VEVENT' . chr(10);
        $template .= 'END:VCALENDAR' . chr(10);

        return $template;

        // Leaving the other generator for now

        $template = "BEGIN:VCALENDAR";

        if($invitees) {
            $template .= chr(10) .'METHOD:REQUEST';
        }

        $template .= chr(10).
"VERSION:2.0
CALSCALE:GREGORIAN
PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN
METHOD:REQUEST
X-MS-OLK-FORCEINSPECTOROPEN:TRUE
BEGIN:VEVENT
";

        $template .= 'DTSTART;TZID=Europe/Berlin:'.$starttime.chr(10);
        $template .= 'DTEND:'.$endtime.chr(10);

        // ORGANIZER;CN=$organizer:mailto:$organizer_email

        $template .=
"DTSTAMP:".$this->convertUnixTimeToCalendar(time()) ."
UID:".\Helper::generateShortcode('15')."@appzio.com
CREATED:".$this->convertUnixTimeToCalendar(time());

        if($invitees){
            foreach ($parameters['invitees'] as $invitee){
                $part = "ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=$invitee:MAILTO:$invitee";
                $part = chunk_split($part,73,chr(10).'  ');
                $part = substr($part,0,-3);
                $template .= chr(10) .$part;
                //$template .= chr(10) ."ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=$invitee:MAILTO:$invitee";
            }
        }

        if(isset($parameters['description'])){
            $template .= chr(10).'DESCRIPTION:'.$parameters['description'];
        }
        if(isset($parameters['location'])){
            $template .= chr(10).'LOCATION:'.$parameters['location'];
        }

        if(isset($parameters['url'])){
            $template .= chr(10).'URL:'.$parameters['url'];
        }

        if(isset($parameters['repeat_daily_until'])){
            $template .= chr(10).'RRULE:FREQ=DAILY;UNTIL='.$this->convertUnixTimeToCalendar($parameters['repeat_daily_until']);
        }

        if(isset($parameters['repeat_weekly_until'])){
            $template .= chr(10).'RRULE:FREQ=WEEKLY;UNTIL='.$this->convertUnixTimeToCalendar($parameters['repeat_weekly_until']);

            if ( isset($parameters['BYDAY']) ) {
                $template .= ';BYDAY=' . $parameters['BYDAY'];
            }

            if ( isset($parameters['interval']) ) {
                $template .= ';INTERVAL=' . $parameters['interval'];
            }
        }

        if(isset($parameters['repeat_monthly_until'])){
            $template .= chr(10).'RRULE:FREQ=MONTHLY;UNTIL='.$this->convertUnixTimeToCalendar($parameters['repeat_monthly_until']);

            if ( isset($parameters['BYMONTHDAY']) ) {
                $template .= ';BYMONTHDAY=' . $parameters['BYMONTHDAY'];
            }

            if ( isset($parameters['interval']) ) {
                $template .= ';INTERVAL=' . $parameters['interval'];
            }
        }

        if(isset($parameters['repeat_yearly_until'])){
            $template .= chr(10).'RRULE:FREQ=YEARLY;UNTIL='.$this->convertUnixTimeToCalendar($parameters['repeat_yearly_until']);
        }

        $template .= "
LAST-MODIFIED:".$this->convertUnixTimeToCalendar(time()) ."
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:$subject
TRANSP:OPAQUE
CLASS:PUBLIC
PRIORITY:5";

        if($outlook_fix){
            $template .= " 
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
X-MICROSOFT-CDO-IMPORTANCE:1
X-MICROSOFT-DISALLOW-COUNTER:FALSE
X-MS-OLK-ALLOWEXTERNCHECK:TRUE
X-MS-OLK-AUTOFILLLOCATION:FALSE
X-MS-OLK-CONFTYPE:0";
        }

        if($invitees){
            $template .= "
X-MICROSOFT-CDO-APPT-SEQUENCE:0
X-MICROSOFT-CDO-OWNERAPPTID:2116155342
X-MICROSOFT-CDO-BUSYSTATUS:TENTATIVE
X-MICROSOFT-CDO-INTENDEDSTATUS:BUSY
X-MICROSOFT-CDO-ALLDAYEVENT:FALSE
X-MICROSOFT-CDO-IMPORTANCE:1
X-MICROSOFT-CDO-INSTTYPE:1
X-MICROSOFT-DONOTFORWARDMEETING:FALSE
X-MICROSOFT-DISALLOW-COUNTER:FALSE";
        }

        $template .= "
BEGIN:VALARM
DESCRIPTION:REMINDER
TRIGGER;RELATED=START:-PT15M
ACTION:DISPLAY
END:VALARM
END:VEVENT
END:VCALENDAR
";

        return $template;
    }

    public function getCalendarErrors( $parameters ) {

        $errors = [
            'starttime' => 'Missing start time',
            'endtime' => 'Missing end time',
            'subject' => 'Missing subject',
            'organizer' => 'Missing organizer',
            'organizer_email' => 'Missing organizer email',
        ];

        foreach ($errors as $key => $error) {
            if ( !isset($parameters[$key]) ) {
                $this->errors[] = $error;
            }
        }

        if(!isset($parameters['starttime'])){
            $this->errors[] = 'Missing start time';
        }

    }

    public function convertUnixTimeToCalendar($time){

        // Set the default timezone to UTC
        date_default_timezone_set('UTC');

//        $time = $time + $difference;
//        $difference = $this->get_timezone_offset('Europe/London');

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