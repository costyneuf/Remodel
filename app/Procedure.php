<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    public function __construct($date='', $location='', $room='', $case_procedure='', $lead_surgeon='', $patient_class='', $proc_start='', $proj_end='')
    {
    	$this->date = $date;
    	$this->location = $location;
    	$this->room = $room;
    	$this->case_procedure = $case_procedure;
    	$this->lead_surgeon = $lead_surgeon;
    	$this->patient_class = $patient_class;
    	$this->proc_start = $proc_start;
    	$this->proj_end = $proj_end;
    }

//Date	Location	Room	Case Procedures	Lead Surgeon	Patient Class	Proc Start	Proj End Time
    public static function construct_from_file($file_name)
    {
    	$procedures = [];

    	$fp = fopen('../resources/data/' . $file_name, 'r');


    	$map_keys = fgetcsv($fp);
    	while (($line = fgetcsv($fp)) !== false)
    	{
    		$date = Procedure::sanitize_date($line[0]);
    		$location = $line[1];
    		$room = $line[2];
    		$case_procedure = preg_replace('/[\[\d+\]]/', '', $line[3]);
    		$lead_surgeon = preg_replace('/[\[\d+\]]/', '', $line[4]);
    		$patient_class = $line[5];
    		$proc_start = $line[6];
    		$proj_end = $line[7];

    		$procedure = new Procedure($date, $location, $room, $case_procedure, $lead_surgeon, $patient_class, $proc_start, $proj_end);

    		$procedures[] = $procedure;
    	}

    	fclose($fp);

    	return $procedures;
    }

    public function make_pretty()
    {
        //Changes the start time from military into AM/PM
        $AM = false;
        $start_time = "";
        if(strlen($this->proc_start) > 0){
            $hourInt = intval(substr($this->proc_start, 0, 2));
            if($hourInt > 12){
                $hour =$hourInt - 12;
            }
            elseif($hourInt == 12){
                $hour = 12;
            }
            else{
                $hour = $hourInt;
                $AM = true;
            }
            $start_time = $hour . ':' .substr($this->proc_start, 2, 2);
            if($AM){
                $start_time = $start_time . " AM";
            }
            else{
                $start_time = $start_time . " PM";

            }
        }
        $this->proc_start = $start_time;

        //Changes the end time from military into AM/PM
        $AM = false;
        $end_time = "";
        if(strlen($this->proj_end) > 0){
            $hourInt = intval(substr($this->proj_end, 0, 2));
            if($hourInt > 12){
                $hour =$hourInt - 12;
            }
            elseif($hourInt == 12){
                $hour = 12;
            }
            else{
                $hour = $hourInt;
                $AM = true;
            }
            $end_time = $hour . ':' .substr($this->proj_end, 2, 2);
            if($AM){
                $end_time = $end_time . " AM";
            }
            else{
                $end_time = $end_time . " PM";

            }
        }
        $this->proj_end = $end_time;

        //Remove unwanted text from case_procedure text
        $this->case_procedure = preg_replace('/[\[\d+\]]/', '', $this->case_procedure);
        //Remove unwanted text from lead_surgeon text
        $this->lead_surgeon = preg_replace('/[\[\d+\]]/', '', $this->lead_surgeon);
    }


    //This function should only ever be called by the make_pretty method.
    private static function sanitize_date($date_string)
    {
        $sanitized_date = [];
        $values = explode('/', $date_string);
        for ($i = 0; $i < count($values); $i++) {
            if (is_numeric($values[$i])) {
                $num = (int)$values[$i];
                if ($i == 0) {
                    if (!(0 < $num and $num <= 12)) {
                        throw new Exception('The month must be a number between 1 and 12');
                    }
                    $sanitized_date[0] = $num;
                } elseif ($i == 1){
                    if (!(0 < $num and $num <= 31)) {
                        throw new Exception('The day must be a number between 1 and 31');
                    }
                    $sanitized_date[1] = $num;
                } else {
                    if ($num < 100) {
                        $num += 2000;
                    }
                    if ($num < 2000) {
                        throw new Exception('The year must be at least later than 2000');
                    }
                    $sanitized_date[2] = $num;
                }
            } else {
                throw new Exception('Month, day, and year must be expressed in numbers only');
            }
        }
        return implode('/', $sanitized_date);
    }
}
