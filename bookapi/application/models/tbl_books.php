<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tbl_books extends CI_Model {
	protected $table_name = 'tbl_books';
	
	function bCheckEmptyChapter($user_id, $book_name){
		$userdata['user_id'] = $user_id;
		$userdata['book_name'] = $book_name;
		$userdata['chapter_name'] = '';
		
		$this->db->where($userdata);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	function bCheckEmptySubChapter($user_id, $book_name, $chapter_name){
		$userdata['user_id'] = $user_id;
		$userdata['book_name'] = $book_name;
		$userdata['chapter_name'] = $chapter_name;
		$userdata['subchapter_name'] = '';
		
		$this->db->where($userdata);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	function bCheckEmptyFile($user_id, $book_name, $chapter_name){
		$userdata['user_id'] = $user_id;
		$userdata['book_name'] = $book_name;
		$userdata['chapter_name'] = $chapter_name;
		$userdata['filename'] = '';
		
		$this->db->where($userdata);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	function bCheckAssignFile($user_id,$book_name,$chapter_name,$filename){
		$userdata['user_id'] = $user_id;
		$userdata['book_name'] = $book_name;
		$userdata['chapter_name'] = $chapter_name;
		$userdata['filename'] = $filename;
		
		$this->db->where($userdata);
		$this->db->select('id');
		$result = $this->db->get($this->table_name)->row_array();
		
		if ($result) return $result['id'];
		else return 0;
	}
	function bBookDesc($book_name){
		$this->db->select('book_desc');
		$this->db->where("book_name='".$book_name."' and book_desc IS NOT NULL", NULL, FALSE);

		$result = $this->db->get($this->table_name)->row_array();
		//print_r($this->db->last_query());
		if ($result) return $result['book_desc'];
		else return '';
	}
	function bChapterDesc($book_name,$chapter_name){
		$this->db->select('chapter_desc');
		$this->db->where("book_name='".$book_name."' and chapter_name='".$chapter_name."' and chapter_desc IS NOT NULL", NULL, FALSE);

		$result = $this->db->get($this->table_name)->row_array();
		//print_r($this->db->last_query());
		if ($result) return $result['chapter_desc'];
		else return '';
	}
	
	
	
	
	//////////////////////////////////////////////
	function bCreateBook($data){
		$this->db->insert($this->table_name, $data);
		$id = $this->db->insert_id();
		if ($id)	return $id;
		else		return 0;
	}
	function bCreateChapter($data){
		//if exist empty chapter name
		$book_id = $this->bCheckEmptyChapter($data['user_id'], $data['book_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bCreateSubChapter($data){
		//if exist empty chapter name
		$book_id = $this->bCheckEmptySubChapter($data['user_id'], $data['book_name'], $data['chapter_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bUploadFile($data){
		//if exist empty File name
		$book_id = $this->bCheckEmptyFile($data['user_id'], $data['book_name'], $data['chapter_name']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
		}else{
			$this->db->insert($this->table_name, $data);
			$book_id = $this->db->insert_id();
		}
		
		if ($book_id)	return $book_id;
		else		return 0;
	}
	function bGetAppInfoByUserId($user_id){
		$this->db->select('book_name,book_desc,filename', false);
		$this->db->from($this->table_name);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('book_name asc, book_desc desc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}	
	function bGetBookInfoByUserId($user_id,$book_name){
		$this->db->select('chapter_name,chapter_desc,subchapter_name,filename', false);
		$this->db->from($this->table_name);
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name));
		$this->db->order_by('chapter_name asc, chapter_desc desc, subchapter_name asc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}
	function bGetChapterInfoByUserId($user_id,$book_name,$chapter_name){
		$this->db->select('subchapter_name,subchapter_desc,filename', false);
		$this->db->from($this->table_name);
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name));
		$this->db->order_by('subchapter_name asc, subchapter_desc desc, filename asc');
		$query = $this->db->get();
		//echo ($this->db->last_query());
		return $query->result_array();
	}
	function bAssignFiles($data){
		//if exist empty File name
		$book_id = $this->bCheckAssignFile($data['user_id'], $data['book_name'], $data['chapter_name'], $data['filename']);
		if($book_id){
			$result = $this->db->update($this->table_name, $data, array('id' => $book_id));
			return $book_id;
		}else
			return 0;
	}
	function bDeleteBookByUserId($user_id,$book_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteChapterByUserId($user_id,$book_name,$chapter_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteSubChapterByUserId($user_id,$book_name,$chapter_name,$subchapter_name){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name, 'subchapter_name'=>$subchapter_name));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	function bDeleteFileByUserId($user_id,$book_name,$chapter_name,$filename){		
		$this->db->where(array('user_id'=>$user_id, 'book_name'=>$book_name, 'chapter_name'=>$chapter_name, 'filename'=>$filename));
		$result = $this->db->delete($this->table_name);
		return $result;
	}
	
	
	
	
	
	
	
}