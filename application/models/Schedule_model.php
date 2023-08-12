<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getDocterList($work_day)
    {
        $queryMenu = "SELECT DISTINCT(s.doctor_code),d.doctor_name,d.medical_name FROM `schedule_table` s  inner join dokter d  on d.doctor_code = s.doctor_code WHERE work_day = '$work_day'";
        return $this->db->query($queryMenu);
    }
    public function getPraktekList($doctor_id, $work_day)
    {
        $query = $this->db->get_where('schedule_table', array('doctor_code' => $doctor_id, 'work_day' => $work_day));
        $dataTobeReturn =  $query;
        return $dataTobeReturn;
    }
    public function getDoctorSchedule($praktek_from, $praktek_to)
    {
        $queryMenu = "SELECT DISTINCT(praktek_from),praktek_to FROM `fix_schedule` WHERE praktek_from >= '" . $praktek_from . "' AND praktek_to <= '" . $praktek_to . "' ORDER BY praktek_from asc";
        return $this->db->query($queryMenu);
    }
}
