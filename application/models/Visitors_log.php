<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visitors_log extends CI_Model
{

    public function log_visitor($ip_address)
    {
        
        $session_key = 'visitor_' . md5($ip_address);

        if (!$this->session->userdata($session_key)) {
            $data = array(
                'ip_address' => $ip_address,
                'visit_date' => date('Y-m-d'),
                'visit_month' => date('Y-m'),
                'visit_year' => date('Y')
            );

            $this->db->insert('visitor_logs', $data);

            $this->session->set_userdata($session_key, true);
        }
    }

    public function get_daily_visits()
    {
        $today = date('Y-m-d');
        return $this->db->where('visit_date', $today)->count_all_results('visitor_logs');
    }

    public function get_monthly_visits()
    {
        $this_month = date('Y-m');
        return $this->db->where('visit_month', $this_month)->count_all_results('visitor_logs');
    }

    public function get_yearly_visits()
    {
        $this_year = date('Y');
        return $this->db->where('visit_year', $this_year)->count_all_results('visitor_logs');
    }
}