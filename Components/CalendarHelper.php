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

        if(isset($parameters['invitees']) AND is_array($parameters['invitees']) AND $parameters['invitees']) {
            $invitees = true;
        } else {
            $invitees = false;
        }

        $starttime = $this->convertUnixTimeToCalendar($parameters['starttime']);
        $endtime = $this->convertUnixTimeToCalendar($parameters['endtime']);
        $subject = $parameters['subject'];
        $organizer = $parameters['organizer'];
        $organizer_email = $parameters['organizer_email'];

        $template = "BEGIN:VCALENDAR";

        if($invitees) {
            $template .= chr(10) .'METHOD:REQUEST';
        }

        $template .= chr(10).
"VERSION:2.0
CALSCALE:GREGORIAN
PRODID:Appzio
METHOD:REQUEST
BEGIN:VEVENT
";
        $template .= 'DTSTART:'.$starttime.chr(10);
        $template .= 'DTEND:'.$endtime.chr(10);
        $template .=
"DTSTAMP:".$this->convertUnixTimeToCalendar(time()) ."
ORGANIZER;CN=$organizer:mailto:$organizer_email
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

        if(isset($parameters['url'])){
            $template .= chr(10).'URL:'.$parameters['url'];
        }

        $template .= "
LAST-MODIFIED:".$this->convertUnixTimeToCalendar(time()) ."
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:$subject
TRANSP:OPAQUE
CLASS:PUBLIC
PRIORITY:5";

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

    public function convertUnixTimeToCalendar($time){
//        $difference = $this->get_timezone_offset('Europe/London');
//        $time = $time + $difference;
        $time = $time + 3600;
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