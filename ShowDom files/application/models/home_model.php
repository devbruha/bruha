<?php  
class Home_model extends CI_Model {  
	function Home_model()  
	{  
		parent::__construct();  
	}  
	function getData(){  			
		$query = $this->db->query("SELECT * FROM data");
		return $query->result();  
	}  
}  
