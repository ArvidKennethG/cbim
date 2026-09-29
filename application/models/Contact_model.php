<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Contact Model (BE-07)
 * 
 * Handles contact form data storage and rate limiting queries.
 * 
 * Required database table:
 * CREATE TABLE IF NOT EXISTS `contact_messages` (
 *     `id` INT(11) NOT NULL AUTO_INCREMENT,
 *     `nama` VARCHAR(100) NOT NULL,
 *     `email` VARCHAR(100) NOT NULL,
 *     `subjek` VARCHAR(200) NOT NULL,
 *     `pesan` TEXT NOT NULL,
 *     `ip_address` VARCHAR(45) NOT NULL,
 *     `created_at` DATETIME NOT NULL,
 *     `status` ENUM('unread','read','replied') DEFAULT 'unread',
 *     PRIMARY KEY (`id`),
 *     INDEX `idx_ip_created` (`ip_address`, `created_at`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */
class Contact_model extends CI_Model
{
    private $table = 'contact_messages';

    /**
     * Save contact form submission
     */
    public function save_contact($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Get submission count for rate limiting
     * 
     * @param string $ip IP address
     * @param int $hours Number of hours to look back
     * @return int Count of submissions
     */
    public function get_submission_count($ip, $hours = 1)
    {
        $time_ago = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        return $this->db
            ->where('ip_address', $ip)
            ->where('created_at >=', $time_ago)
            ->count_all_results($this->table);
    }

    /**
     * Get all contact messages (for admin panel)
     */
    public function get_all_messages($limit = 50, $offset = 0)
    {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result_array();
    }

    /**
     * Mark message as read
     */
    public function mark_as_read($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['status' => 'read']);
    }
}
