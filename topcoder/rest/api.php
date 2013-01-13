<?php
	
	require_once("rest.php");
	require_once("helpers.php");
	require_once("config.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = SERVER;
		const DB_USER = USER;
		const DB_PASSWORD = PASSWORD;
		const DB = DATABASE;
		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
		
		private function register(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$name = mysql_real_escape_string($this->_request['name']);
			$email = $this->_request['email'];
			$phone = $this->_request['phone'];
			$pwd = $this->_request['pwd'];
			$c_pwd = $this->_request['c_pwd'];

			$error = null;
			//Check if registration is open
			if(!IS_REGISTRATION_ALLOWED){
				$error = "Registration is not open!";
			}
			else{
				// Validate User Name
				if (!isUserName($name)) {
					$error = "ERROR - Invalid user name. It can contain only alphabets with atleast 5 characters.";
				}

				// Validate Email
				if(!isEmail($email)) {
					$error = $error."<br>ERROR - Invalid email address.";
				}

				// Check User Passwords
				if (!checkPwd($pwd,$c_pwd)) {
					$error = $error."<br>ERROR - Invalid Password or mismatch. Enter 5 chars or more";
				}
			}
			
			if(!$error){
				
				// Automatically collects the hostname or domain  like example.com) 
				$host = $_SERVER['HTTP_HOST'];
				$host_upper = strtoupper($host);
				$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				
				// Generates activation code simple 4 digit number
				$activation_code = rand(1000,9999);
				
				$rs_duplicate = mysql_query("select count(*) as total from topcoders where email='$email'") or die(mysql_error());
				list($total) = mysql_fetch_row($rs_duplicate);
				if ($total > 0){
					$error = "ERROR - The user already registered. Please try again with different email.";
				}
				
				if(!$error) {
						$activation_link = null;
						$topcoder_id = uniqid('tcg_', true);
						$sql_insert = "INSERT INTO topcoders (`topcoder_id`, `name`, `email`, `phone`, `pwd`, `activation_code`) VALUES ('$topcoder_id', '$name', '$email', '$phone', '".md5($pwd)."', '$activation_code');";
						mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error());
						if(IS_REGISTRATION_ALLOWED){
							$activation_link= "http://$host$path/activate?topcoder_id=$topcoder_id&activation_code=$activation_code";
						} else {
							$activation_link= "Your account is *PENDING FOR APPROVAL* and will be soon activated by the administrator.";
						}
						
						if(IS_TO_BE_MAILED){
							$message = "Hello $name !\n
									Thank you for registering with TopCoderGuild. Here are your login details...\n\n
									Registered E-Mail ID: $email\n
									Coder Name: $name \n
									Password: $pwd \n\n
									*****Here is your ACTIVATION LINK*****\n
									$activation_link\n\n
									Thank You!\n\n
									Administrator\n
									TopCoder - GCT CSITA\n
									______________________________________________________\n
									THIS IS AN AUTOMATED RESPONSE. \n
									***DO NOT RESPOND TO THIS EMAIL****
									";
							mail($email, "TopCoder Login Details", $message, "From: \"TopCoder @ GCT.NET.IN\" <auto-reply@$host>\r\n" . "X-Mailer: PHP/" . phpversion());
						}
						
						// If success everything is good send header as "OK" and user details
						$result = array('status' => "Success", "msg" => $activation_link);
						$this->response($this->json($result), 200);
				}
			}
			
			if($error){
				// If invalid inputs "Bad Request" status message and reason
				$result = array('status' => "Failed", "msg" => $error);
				$this->response($this->json($result), 400);
			}
		}
		
		private function activate(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "PUT"){
				$this->response('',406);
			}
			
			//check if activation code and topcoder ID is valid
			$topcoder_id = $this->_request['topcoder_id'];		
			$activation_code = $this->_request['activation_code'];
			
			$rs_check = mysql_query("select activation_status from topcoders where topcoder_id='$topcoder_id' and activation_code='$activation_code'") or die(mysql_error());
			$total = mysql_num_rows($rs_check);
			$error = null;
			if ($total != 1){
				$error = array('status' => "Failed", "msg" => "No such account exists or activation code invalid");
				$this->response($this->json($error), 204);
			}
			else{
				list($activation_status) = mysql_fetch_row($rs_check);
				if($activation_status == 0){
					mysql_query("update topcoders set activation_status='1' WHERE topcoder_id='$topcoder_id' AND activation_code = '$activation_code' ") or die(mysql_error());
					$result = array('status' => "Success", "msg" => "Thank you! Your TCG account has been activated.");
				}
				else{
					$result = array('status' => "Success", "msg" => "Your TCG account is already activated.");
				}
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($result), 200);
			}
			
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Invalid activation request");
			$this->response($this->json($error), 400);
		}
		
		private function login(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$email = $this->_request['email'];		
			$pwd = $this->_request['pwd'];
			
			// Input validations
			if(!empty($email) and !empty($pwd)){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$sql = mysql_query("SELECT topcoder_id, name, user_level FROM topcoders WHERE email = '$email' AND pwd = '".md5($pwd)."' LIMIT 1", $this->db);
					if(mysql_num_rows($sql) > 0){
						$result = mysql_fetch_array($sql,MYSQL_ASSOC);
						
						// If success everythig is good send header as "OK" and user details
						$this->response($this->json($result), 200);
					}
					$this->response('', 204);	// If no records "No Content" status
				}
			}
			
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
			$this->response($this->json($error), 400);
		}
		
		private function users(){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$sql = mysql_query("SELECT topcoder_id, name, email, phone FROM topcoders WHERE activation_status = 1", $this->db);
			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
				// If success everythig is good send header as "OK" and return list of users in JSON format
				$this->response($this->json($result), 200);
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function deleteUser(){
			// Cross validation if the request method is DELETE else it will return "Not Acceptable" status
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			
			$topcoder_id = $this->_request['topcoder_id'];
			$rs_check = mysql_query("select * from topcoders where topcoder_id='$topcoder_id'") or die(mysql_error());
			$total = mysql_num_rows($rs_check);
			if ($total != 1){
				$error = array('status' => "Failed", "msg" => "No such account exists");
				$this->response($this->json($error), 204);
			}
			else{
				mysql_query("DELETE FROM topcoders WHERE topcoder_id='$topcoder_id'") or die(mysql_error());
				$success = array('status' => "Success", "msg" => "Successfully one account deleted.");
				$this->response($this->json($success),200);
			}
		}
		
		private function submitProblem(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			//check if activation code and topcoder ID is valid
			$problem_name = $this->_request['problem_name'];
			$statement = $this->_request['statement'];
			$input = $this->_request['input'];
			$output = $this->_request['output'];
			$time_limit = (int)$this->_request['time_limit'];
			$memory_limit = (int)$this->_request['memory_limit'];
			$problem_id = uniqid('problem_', true);
			
			if(!empty($problem_name) and !empty($statement) and !empty($input) and !empty($time_limit) and !empty($memory_limit)){
				//Need to validate the statement as they may contain some XSS
				$sql_insert = "INSERT INTO problems (`problem_id`, `problem_name`, `statement`, `input`, `output`, `time_limit`, `memory_limit`) VALUES ('$problem_id', '$problem_name', '$statement', '$input', '$output', $time_limit, $memory_limit);";
				mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error());
				
				$result = array('status' => "Success", "msg" => "Problem successfully submitted");
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($result), 200);
			}
			
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Invalid Problem Input");
			$this->response($this->json($error), 400);
		}
		
		private function setContestProblem(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "PUT"){
				$this->response('',406);
			}
			
			//check if activation code and topcoder ID is valid
			$problem_id = $this->_request['problem_id'];
			if(!empty($problem_id)){
				$sql_update = "update problems set isContestProblem=1 WHERE problem_id='$problem_id'";
				$rs_check = mysql_query($sql_update) or die(mysql_error());
				
				$result = array('status' => "Success", "msg" => "Problem set as contest problem");
				$this->response($this->json($result), 200);
			}
			
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Invalid activation request");
			$this->response($this->json($error), 400);
		}
		
		private function problems(){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			
			$sql = mysql_query("SELECT problem_id, problem_name, statement, time_limit, memory_limit FROM problems", $this->db);
			if(mysql_num_rows($sql) > 0){
				$result = array();
				while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC)){
					$result[] = $rlt;
				}
				// If success everythig is good send header as "OK" and return list of users in JSON format
				$this->response($this->json($result), 200);
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function deleteProblem(){
			// Cross validation if the request method is DELETE else it will return "Not Acceptable" status
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			
			$problem_id = $this->_request['problem_id'];
			$rs_check = mysql_query("select * from problems where problem_id='$problem_id'") or die(mysql_error());
			$total = mysql_num_rows($rs_check);
			if ($total != 1){
				$error = array('status' => "Failed", "msg" => "No such problem exists");
				$this->response($this->json($error), 204);
			}
			else{
				mysql_query("DELETE FROM problems WHERE problem_id='$problem_id'") or die(mysql_error());
				$success = array('status' => "Success", "msg" => "Successfully one problem deleted.");
				$this->response($this->json($success),200);
			}
		}
		
		private function submitSolution(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			//check if inputs are is valid
			$problem_id = $this->_request['problem_id'];
			$topcoder_id = $this->_request['topcoder_id'];
			$code = $this->_request['code'];
			$language = $this->_request['language'];
			
			if(!empty($problem_id) and !empty($topcoder_id) and !empty($code)){
				$submission_id = uniqid('solution_', true);
				$resultset = mysql_query("select * from problems where problem_id='$problem_id'") or die(mysql_error());
				$input = mysql_result($result, 0, 'input');
				$output = mysql_result($result, 0, 'output');
				$time_limit = mysql_result($result, 0, 'time_limit');
				$memory_limit = mysql_result($result, 0, 'memory_limit');
				$status = 0; // code not yet evaluated
				//Code Evaluation by ideone starts
				$user = OJ_USER;
				$passwd = OJ_PASSWORD;
				// creating soap client
				$client = new SoapClient("http://ideone.com/api/1/service.wsdl");
				
				$run = true;
				$private = true;
				$server_timeout = 0;
				$submit = $client->createSubmission($user, $passwd, $code, $language, $input, $run, $private);
				if($submit['error']=="OK"){
					$result = $client->getSubmissionStatus($user, $passwd, $submit['link']);
					while ( $result['status'] != 0 ) {
						if($server_timeout > OJ_SERVER_TIMEOUT)
						$msg = "Server Load => Timed Out! Try submitting again!";
						sleep(3);
						$server_timeout+=3;
						$result = $client->getSubmissionStatus( $user, $passwd, $submit['link'] );
					}
					if($result['status'] == 0){
						$details = $client->getSubmissionDetails( $user, $passwd, $submit['link'], true, true, true, true, true );
						if ( $details['error'] == 'OK' ) {
							if($details['result'] != 15 || $details['result'] == 15 && $details['output'] == $output){
								$execution_time = $details['time'];
								$memory_used = $details['memory'];
								if($execution_time > $time_limit)
								$status = 13;
								else if($memory_used > $memory_limit)
								$status = 17;
								else
								$status = $details['result'];
							}
							else
								$status = 10;
						}
						else {
							$msg = "Error in submission!";
							$status = 0;
						}
					}
					else
					$status = $result['result'];
				}
				//Code Evalutation Complete
				
				$sql_insert = "INSERT INTO submissions (`submission_id`, `topcoder_id`, `problem_id`, `status`, `code`) VALUES ('$submission_id', '$topcoder_id', '$problem_id', $status, '$code');";
				mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error());
				
				$result = "Solution successfully processed and submitted";
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($result), 200);
			}
			
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Invalid Solution Submitted");
			$this->response($this->json($error), 400);
		}
		
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>