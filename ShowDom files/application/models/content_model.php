<?php  
class Content_model extends CI_Model {  
	function Content_model()  
	{  
		parent::__construct();  
		$this->load->library(array('session','geocode'));
	}  
	
	function updateContent(){
		$check = mysql_query('SELECT * FROM tbl_content WHERE page_id = '.$_POST['content_id'].'');
		if(mysql_num_rows($check) == 0){
			$query = mysql_query('INSERT INTO tbl_content VALUES(null, "'.mysql_real_escape_string($_POST['content']).'", '.$_POST['content_id'].')');	
		}else{ 
			$query = mysql_query('UPDATE tbl_content SET content = "'.mysql_real_escape_string($_POST['content']).'" WHERE page_id = '.$_POST['content_id'].'');	
		}
	}
	
	function getContent($contentId){
		$query = $this->db->query("SELECT * FROM tbl_content WHERE page_id = ".$contentId.""); 
		if($query->num_rows() != 0){
			$row = $query->row();  
			return $row->content;	
		}else{
			return '';	
		}
	}
	
	function getContentSections($contentId){
		$query = $this->db->query("SELECT * FROM tbl_content_section WHERE page_id = ".$contentId.""); 
		return $query->result();  
	}
	
	function addContentSection(){
		$query = mysql_query('INSERT INTO tbl_content_section VALUES(null, '.$_POST['content_id'].', "'.mysql_real_escape_string($_POST['title']).'", "'.mysql_real_escape_string($_POST['content']).'")');	
	}
	
	function updateContentSection(){
		$query = mysql_query('UPDATE tbl_content_section SET title = "'.mysql_real_escape_string($_POST['title']).'", content = "'.mysql_real_escape_string($_POST['content']).'" WHERE section_id = '.$_POST['secion_id'].'');	
	}

}  
