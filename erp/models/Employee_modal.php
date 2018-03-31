<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_modal extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
	
	
    public function delete_employee($id)
    {
        $this->trigger_events('pre_delete_user');

        $this->db->trans_begin();

        // remove user from groups
        //$this->remove_from_group(NULL, $id);

        // delete user from users table should be placed after remove from group
        $this->db->delete($this->tables['users'], array('id' => $id));

        // if user does not exist in database then it returns FALSE else removes the user from groups
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
            $this->set_error('delete_unsuccessful');
            return FALSE;
        }

        $this->db->trans_commit();

        $this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
        $this->set_message('delete_successful');
        return TRUE;
    }
	public function getEmployees(){
		$query = $this->db->get('users');
		foreach($query->result() as $row){
			$data[] = $row;
		}
		return $data;
	}
    
	public function getTaxExchangeRateByMY($month = NULL, $year = NULL){
		$this->db->where('month', $month)
					->where('year', $year);
		$this->db->limit(0,1);
		$query = $this->db->get('tax_exchange_rate');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	
	public function getSalaryTaxTriggerByDate($year_month){
		$this->db->where('year_month', $year_month);
		$this->db->limit(0,1);
		$query = $this->db->get('employee_salary_tax_trigger');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
}
?>