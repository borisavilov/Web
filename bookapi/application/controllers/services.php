<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//  Created by Boris on 27/05/2015.
//  Copyright (c) 2015 EV.TECH All rights reserved.
class Services extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('tbl_users');
		$this->load->model('tbl_books');
    }
	public function stdToArray($obj){
		$reaged = (array)$obj;
		foreach($reaged as $key => &$field){
			if(is_object($field))$field = stdToArray($field);
		}
		return $reaged;
	}
	protected function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}

		if (is_dir($dirPath)) {
			if (self::is_dir_empty($dirPath)) {
				rmdir($dirPath);
			}
		}
	}
	function is_dir_empty($dir) {
	  if (!is_readable($dir)) return NULL; 
	  $handle = opendir($dir);
	  while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != "..") {
		  return FALSE;
		}
	  }
	  return TRUE;
	}
	////////////////////////////////////////////////////
	function login(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/* 
		$posts['username'] = 'test2@hotmail.com'; // or boris
		$posts['password']='boris';		
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$result = $this->tbl_users->bLoginCheck($posts['username'],$posts['password']);
		if($result) {
			$response['status'] = "success";
			$response['user_id'] =  $result['id'];
			$response['username'] =  $result['username'];
			$response['email'] =  $result['email'];
			$response['photo'] =  $result['photo'];
			$response['password'] =  $result['password'];
			$response['message'] =  'logined successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'login failed';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function signup(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		
		//test
		/*
		$posts['username']='Hans';
		$posts['email']='hanschan11116@hotmail.com';
		$posts['password']='simple12345';
		$posts['first_name']='Hans';$posts['last_name']='Chan';
		$_FILES['photo'] = 'testphoto';
		*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$userinfo = array();
		$userinfo['username'] = $posts['username']; 
		$userinfo['email'] = $posts['email']; 
		$userinfo['password'] = $posts['password'];		
		$userinfo['firstname'] = $posts['first_name'];$userinfo['lastname'] = $posts['last_name']; 
		
		$user_id = $this->tbl_users->bRegister($userinfo);
		if($user_id >0 ) {
			$photo_url = '';
			if(isset($_FILES['photo'])) {
				$upload_dir="uploads/"; 
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
				
				$upload_dir.=$user_id."/";
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE; 
				
				$upload_dir.="photo/";
				$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE; 
				
				$file_name = $_FILES['photo']['name'];
				//$ext=pathinfo($file_name, PATHINFO_EXTENSION);
			
				// upload photo
				move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir.$file_name);
			
				/*	regMedias	*/
				$photo_url = $this->get_full_url().'/'.$upload_dir.$file_name;
				//add photo url
				
				$photoinfo = array();
				$photoinfo['photo'] = $photo_url;
				
				$result = $this->tbl_users->bUpdateDataById($photoinfo,$user_id);
				
			}
			
			$response['status'] = "success";
			$response['user_id'] =  $user_id;
			$response['username'] =  $userinfo['username'];
			$response['email'] =  $userinfo['email'];
			$response['password'] =  $userinfo['password'];
			$response['photo'] =  $photo_url;
			$response['message'] =  'signed up successfully';
		}
		else {
			$response['status'] = "fail";
			
			if($user_id == -1)
				$response['message'] = "user name exist";
			else if($user_id == -2)
				$response['message'] = "email exist";
			else
				$response['message'] = "sign up failed";
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function createnewbook(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = '12';
		$posts['book_name']='Hans';
		$posts['book_desc']='13180836958';
		*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}		
		
		$bookinfo = array();
		$bookinfo['user_id'] = $posts['user_id'];
		$bookinfo['book_name'] = $posts['book_name'];$bookinfo['book_desc'] = $posts['book_desc'];
		
		$book_id = $this->tbl_books->bCreateBook($bookinfo);
		if($book_id >0 ) {
			$upload_dir="uploads/"; 
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
			
			$upload_dir.=$bookinfo['user_id']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$bookinfo['book_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
			
			$response['status'] = "success";
			$response['message'] =  'created successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'creat failed';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function createnewchapter(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/* 
		$posts['user_id'] = '123';
		$posts['book_name']='mybook1';
		$posts['chapter_name']='chapter1';
		$posts['chapter_desc']='chapter_desc1';
		 */
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}		
		
		$chapterinfo = array();
		$chapterinfo['user_id'] = $posts['user_id'];
		$chapterinfo['book_name'] = $posts['book_name'];
		$chapterinfo['chapter_name'] = $posts['chapter_name'];
		$chapterinfo['chapter_desc'] = $posts['chapter_desc'];
		
		$book_id = $this->tbl_books->bCreateChapter($chapterinfo);
		if($book_id >0 ) {
			$upload_dir="uploads/"; 
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
			
			$upload_dir.=$chapterinfo['user_id']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$chapterinfo['book_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
			
			$upload_dir.=$chapterinfo['chapter_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;				
			
			$response['status'] = "success";
			$response['message'] =  'created successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'creat failed';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function createnewsubchapter(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/* 
		$posts['user_id'] = '123';
		$posts['book_name']='mybook1';
		$posts['chapter_name']='chapter1';
		$posts['subchapter_name']='subchapter1';
		$posts['subchapter_desc']='subchapter_desc1';
		 */
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}		
		
		$chapterinfo = array();
		$chapterinfo['user_id'] = $posts['user_id'];
		$chapterinfo['book_name'] = $posts['book_name'];
		$chapterinfo['chapter_name'] = $posts['chapter_name'];
		$chapterinfo['subchapter_name'] = $posts['subchapter_name'];
		$chapterinfo['subchapter_desc'] = $posts['subchapter_desc'];
		
		$book_id = $this->tbl_books->bCreateSubChapter($chapterinfo);
		if($book_id >0 ) {
			$upload_dir="uploads/"; 
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$chapterinfo['user_id']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$chapterinfo['book_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$chapterinfo['chapter_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$upload_dir.=$chapterinfo['subchapter_name']."/";
			$dirCreated=(!is_dir($upload_dir)) ? @mkdir($upload_dir, 0777):TRUE;
			
			$response['status'] = "success";
			$response['message'] =  'created successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'creat failed';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function uploadfile(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/* 
		$posts['user_id'] = '123';
		$posts['book_name']='mybook1';
		$posts['chapter_name']='chapter1';
		$posts['filename']='filename1';
		$_FILES['upload_file'] = 'file1';
		  */
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}		
		
		$uploadinfo = array();
		$uploadinfo['user_id'] = $posts['user_id'];
		$uploadinfo['book_name'] = $posts['book_name'];
		$uploadinfo['chapter_name'] = $posts['chapter_name'];
		$uploadinfo['filename'] = $posts['filename'];

		$upload_url = '';
		if(isset($_FILES['upload_file'])) {
			$upload_dir="uploads/".$uploadinfo['user_id']."/".$uploadinfo['book_name']."/".$uploadinfo['chapter_name']."/"; 
			
			$filename = $uploadinfo['filename'];//$_FILES['upload_file']['name'];
			//$ext=pathinfo($filename, PATHINFO_EXTENSION);
			
			// upload photo
			move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload_dir.$filename);
		
			/*	regMedias	*/
			$upload_url = $this->get_full_url().'/'.$upload_dir.$filename;
			
			//add file info
			$book_id = $this->tbl_books->bUploadFile($uploadinfo);
			
			if($book_id >0 ) {
				$response['status'] = "success";
				$response['message'] =  'uploaded successfully';
			}
			else {
				$response['status'] = "fail";
				$response['message'] =  'uploaded file register failed';
			}
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'uploaded file not selected';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function getappinfo(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 123;
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$bookinfos = $this->tbl_books->bGetAppInfoByUserId($posts['user_id']);
		if(count($bookinfos)>0){
			$response['status'] = "success";
			$response['message'] =  'success';
			
			$books = array();
			$book_name = '';$temp_book_name = '';
			$filename = '';$temp_filename = '';
			foreach($bookinfos as $bookinfo){
				$book_name = $bookinfo['book_name'];
				$book_desc = $bookinfo['book_desc'];
				$filename = $bookinfo['filename'];
				
				if($book_name <> $temp_book_name){
					$books[$book_name] = array();
					$books[$book_name]['book_name']=$book_name;
					if(!$book_desc)
						$book_desc='';
					
					$books[$book_name]['book_desc']=$book_desc;
					
					$books[$book_name]['files'] = array();
					
					if($filename)
						$books[$book_name]['files'][]=$filename;
				}else{
					if($filename)
						$books[$book_name]['files'][]=$filename;
				}
				
				$temp_book_name = $book_name;
				$temp_filename = $filename;
			}
			
			$response['books'] =  $books;
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function getbookinfo(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 15;
		$posts['book_name'] = 'hans_book1';
		*/
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$book_desc = $this->tbl_books->bBookDesc($posts['book_name']);
		
		$bookinfos = $this->tbl_books->bGetBookInfoByUserId($posts['user_id'],$posts['book_name']);
		if(count($bookinfos)>0){
			$response['status'] = "success";			
			$response['message'] =  'success';
			
			$chapters = array();
			$chapter_name = '';$temp_chapter_name = '';
			$subchapter_name = '';$temp_subchapter_name = '';
			$filename = '';$temp_filename = '';
			
			foreach($bookinfos as $bookinfo){
				$chapter_name = $bookinfo['chapter_name'];
				$chapter_desc = $bookinfo['chapter_desc'];
				$filename = $bookinfo['filename'];
				if($chapter_name){
					if($chapter_name <> $temp_chapter_name){					
						$chapters[$chapter_name] = array();
						$chapters[$chapter_name]['chapter_name']=$chapter_name;
						if(!$chapter_desc)
							$chapter_desc='';
						
						$chapters[$chapter_name]['chapter_desc']=$chapter_desc;
						
						$chapters[$chapter_name]['files'] = array();

						if($filename)
							$chapters[$chapter_name]['files'][]=$filename;

					}else{
						$chapters[$chapter_name]['chapter_name']=$chapter_name;
						if(!isset($chapters[$chapter_name]))
							$chapters[$chapter_name] = array();
						if(!isset($chapters[$chapter_name]['files']))
							$chapters[$chapter_name]['files'] = array();
						if($filename)
							$chapters[$chapter_name]['files'][]=$filename;

					}
				}
				$temp_chapter_name = $chapter_name;
				$temp_filename = $filename;
			}
			$response['book_name'] =  $posts['book_name'];
			$response['book_desc'] =  $book_desc;
			
			$response['chapters'] =  $chapters;
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function getchapterinfo(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/* 
		$posts['user_id'] = 15;
		$posts['book_name'] = 'hans_book1';
		$posts['chapter_name'] = 'chapter1';
		 */
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$book_desc = $this->tbl_books->bBookDesc($posts['book_name']);
		$chapter_desc = $this->tbl_books->bChapterDesc($posts['book_name'],$posts['chapter_name']);
		
		$bookinfos = $this->tbl_books->bGetChapterInfoByUserId($posts['user_id'],$posts['book_name'],$posts['chapter_name']);
		if(count($bookinfos)>0){
			$response['status'] = "success";
			$response['message'] =  'success';
			
			$subchapters = array();
			$subchapter_name = '';$temp_subchapter_name = '';
			$filename = '';$temp_filename = '';
			
			$subchapters['unassigned files'] = array();
			$subchapters['unassigned files']['subchapter_name']='unassigned';
			$subchapters['unassigned files']['files'] = array();
			
			foreach($bookinfos as $bookinfo){
				$subchapter_name = $bookinfo['subchapter_name'];
				$subchapter_desc = $bookinfo['subchapter_desc'];
				$filename = $bookinfo['filename'];
				
				if($subchapter_name <> $temp_subchapter_name){
					if(!$subchapter_name){
						if($filename)
							$subchapters['unassigned files']['files'][]=$filename;
					}else{
						$subchapters[$subchapter_name] = array();
						$subchapters[$subchapter_name]['subchapter_name']=$subchapter_name;
						if(!$subchapter_desc)
							$subchapter_desc='';
						
						$subchapters[$subchapter_name]['subchapter_desc']=$subchapter_desc;
					
						$subchapters[$subchapter_name]['files'] = array();
						
						if($filename)
							$subchapters[$subchapter_name]['files'][]=$filename;
					}
				}else{
					if(!$subchapter_name){
						if($filename)
							$subchapters['unassigned files']['files'][]=$filename;
					}else{						
						if(!isset($subchapters[$subchapter_name]))
							$subchapters[$subchapter_name] = array();
						if(!isset($subchapters[$subchapter_name]['files']))
							$subchapters[$subchapter_name]['files'] = array();
						
						$subchapters[$subchapter_name]['subchapter_name']=$subchapter_name;
						
						if($filename)
							$subchapters[$subchapter_name]['files'][]=$filename;
					}
				}
				
				$temp_subchapter_name = $subchapter_name;
				$temp_filename = $filename;
			}
			
			$response['book_name'] =  $posts['book_name'];
			$response['book_desc'] =  $book_desc;
			$response['chapter_name'] =  $posts['chapter_name'];
			$response['chapter_desc'] =  $chapter_desc;
			
			$response['subchapters'] =  $subchapters;
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function assignfiles(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/* 
		$posts['user_id'] = 15;
		$posts['book_name'] = 'mybook1';
		$posts['chapter_name'] = 'chapter1';
		$posts['subchapter_name'] = 'subchapter1';
		$posts['files'] = 'filename3.pdf';
		 */
		//print_r( $posts['files']);
		
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		$flag = true; $message = '';
		$assigninfo = array();
		$assigninfo['user_id'] = $posts['user_id'];
		$assigninfo['book_name'] = $posts['book_name'];
		$assigninfo['chapter_name'] = $posts['chapter_name'];
		$assigninfo['subchapter_name'] = $posts['subchapter_name'];
		
		for($i=0;$i<count($posts['files']);$i++){
			$filename = $posts['files'][$i];
			$assigninfo['filename'] = $filename;
			
			$result = $this->tbl_books->bAssignFiles($assigninfo);
			if($result){
				
				$upload_dir="uploads/".$posts['user_id']."/".$posts['book_name']."/".$posts['chapter_name']."/"; 
				$source_path=$upload_dir.$filename;
				
				$target_path=$upload_dir.$posts['subchapter_name']."/";
				$dirCreated=(!is_dir($target_path)) ? @mkdir($target_path, 0777):TRUE;	
				$target_path.=$filename;
				
				if (file_exists($source_path))
				{
					if(rename($source_path, $target_path)) {
						$message .=  " assigned successfully >>>file name:$filename ";
					} else{
						$flag = false;
						$message .=  " file move error >>>file name:$filename ";
					}
				}else{
					$flag = false;
					$message .=  " file path error >>>file name:$filename ";
				}
			}
			else {
				$flag = false;
				$message .=  " uploaded file not registered >>>file name:$filename ";
			}			
		}
		
		if($flag){
			$response['status'] = "success";
			$response['message'] =  'assigned successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  $message;
		}		
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function deletebook(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 123;
		$posts['book_name'] = 'mybook3';
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		//delete in the db
		$result = $this->tbl_books->bDeleteBookByUserId($posts['user_id'],$posts['book_name']);
		if($result){
			$response['status'] = "success";
			//delete in the server
			$upload_dir="uploads/".$posts['user_id']."/"; 
			$dirPath=$upload_dir.$posts['book_name'];
			
			if (! is_dir($dirPath)) {
				$response['message'] =  "The directory $dirPath not exists";
			}else{
				$this->deleteDir($dirPath);
				$response['message'] =  'deleted successfully';
			}
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function deletechapter(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 123;
		$posts['book_name'] = 'mybook1';
		$posts['chapter_name'] = 'chapter1';
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		//delete in the db
		$result = $this->tbl_books->bDeleteChapterByUserId($posts['user_id'],$posts['book_name'],$posts['chapter_name']);
		if($result){
			$response['status'] = "success";
			//delete in the server
			$upload_dir="uploads/".$posts['user_id']."/".$posts['book_name']."/"; 
			$dirPath=$upload_dir.$posts['chapter_name'];
			
			if (! is_dir($dirPath)) {
				$response['message'] =  "The directory $dirPath not exists";
			}else{
				$this->deleteDir($dirPath);
				$response['message'] =  'deleted successfully';
			}
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function deletesubchapter(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 123;
		$posts['book_name'] = 'mybook1';
		$posts['chapter_name'] = 'chapter1';
		$posts['subchapter_name'] = 'subchapter1';
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		//delete in the db
		$result = $this->tbl_books->bDeleteSubChapterByUserId($posts['user_id'],$posts['book_name'],$posts['chapter_name'],$posts['subchapter_name']);
		if($result){
			$response['status'] = "success";
			//delete in the server
			$upload_dir="uploads/".$posts['user_id']."/".$posts['book_name']."/".$posts['chapter_name']."/"; 
			$dirPath=$upload_dir.$posts['subchapter_name'];
			
			if (! is_dir($dirPath)) {
				$response['message'] =  "The directory $dirPath not exists";
			}else{
				$this->deleteDir($dirPath);
				$response['message'] =  'deleted successfully';
			}
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	function deletefile(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
		
		$posts = $this->input->post();
		//test
		/*
		$posts['user_id'] = 123;
		$posts['book_name'] = 'mybook1';
		$posts['chapter_name'] = 'chapter1';
		$posts['filename'] = 'filename1.pdf';
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$response = json_encode($response);
			echo $response;
			exit;
		}
		
		//delete in the db
		$result = $this->tbl_books->bDeleteFileByUserId($posts['user_id'],$posts['book_name'],$posts['chapter_name'],$posts['filename']);
		if($result){
			$response['status'] = "success";
			//delete in the server
			$upload_dir="uploads/".$posts['user_id']."/".$posts['book_name']."/";
			$dirPath=$upload_dir.$posts['chapter_name']."/";
			$file=$dirPath.$posts['filename'];
			
			if (file_exists($file)) {
				unlink($file);
				$response['message'] =  'deleted successfully';
			} else {
				$response['message'] =  "The file $file not exists";
			}
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'not exist';
		}
		
		$response = json_encode($response);
		echo $response;
		exit;
	}
	
	function test(){
		$posts = $this->input->post();
		//test
		/* 
		$posts['username'] = 'test2@hotmail.com'; // or boris
		$posts['password']='boris';		
		*/
		//for android
		if(!$posts)	{
			$posts = json_decode(file_get_contents("php://input"));
			$posts = $this->stdToArray($posts);
		}
		$response = array();
		if(isset($posts) && !($posts)){
			$response['status'] = "fail";
			$response['message'] =  'no post values';
			$this->_output_json( $response );
		}
		
		$result = $this->tbl_users->bLoginCheck($posts['username'],$posts['password']);
		if($result) {
			$response['status'] = "success";
			$response['user_id'] =  $result['id'];
			$response['username'] =  $result['username'];
			$response['email'] =  $result['email'];
			$response['photo'] =  $result['photo'];
			$response['password'] =  $result['password'];
			$response['message'] =  'logined successfully';
		}
		else {
			$response['status'] = "fail";
			$response['message'] =  'login failed';
		}
		
		$this->_output_json( $response );
	}
	function _output_json( $data ){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');
        echo json_encode( $data );
		exit;
    }
}