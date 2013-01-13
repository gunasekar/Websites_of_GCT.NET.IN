                                </div>
                                <!-- /mid content -->
                            </div>
                            <!-- /mid -->
							<!-- sidebar -->
							<div id='sidebar'>
								<!-- sidebar 1st container -->
								<div id='sidebar-wrap1'>
								<!-- sidebar 2nd container -->
								<div id='sidebar-wrap2'>
									<ul id='sidelist'>
									<h3>Sidebar</h3>
										<?php
										include "upperSideBar.php";
										if($isProblemsPage == 1 && $tab == 2){
											include "problems_pane.php";
										}
										else if($isProblemsPage == 1 && $tab == 3){
											include "all_problems_pane.php";
										}
										?>
										<li class='box'>
											<h3 class='title'>
											<?php
											if(!isset($_SESSION['id']))
												echo "User Login";
											else
												echo "User Status";
											?>
											</h3>

											<div id='loginblock'>
											<?php
													if(!isset($_SESSION['id'])){
														?>
														<form action='index.php' method='post' name='logForm' id='logForm' >

														<p>Topcoder ID<br />
																<input type='text' name='loginid' class='login'/>
														</p>

														<p>Password<br />
																<input type='password' name='pwd' class='login'/>
														</p>

														<p>
																<input name='doLogin' type='submit' id='doLogin' value='Login'>
														</p>
														
														<p>
																		<div align='center'>New User? <a href='register.php'>Click here!</a></div><br>
														</p>
														<div id='r_copy'><div id='logForm_errorloc'></div></div>
														</form>
														<script language='JavaScript' type='text/javascript'>
														var frmvalidator  = new Validator('logForm');
														frmvalidator.EnableOnPageErrorDisplaySingleBox();
														frmvalidator.EnableMsgsTogether();   

														frmvalidator.addValidation('user_id','req','Please enter your user id');
														frmvalidator.addValidation('user_id','maxlen=30','Maximum length for TopCoder ID is 30');
														frmvalidator.addValidation('user_id','minlen=6','Minimum length for TopCoder ID is 6');

														frmvalidator.addValidation('pwd','req','Please enter your password');
														frmvalidator.addValidation('pwd','minlen=5','Min length for password is 5');
														</script>
														<?php
														   if($err)
															   echo "$err<br>";
														}
														else{
															echo "Hi, You are logged in as  ", $_SESSION['name'];
															echo "<br><p><a href='logout.php'>Logout</a></p>";
														}
														
														if($link != null)
															mysql_close($link);
													?>
											</div>
										</li>
										<!-- /login -->
									</ul>
								</div>
								<!-- /sidebar 2nd container -->
								</div>
								<!-- /sidebar 1st container -->
							</div>
							<!-- /sidebar -->
				</div>
                <!-- /side wrap -->
                </div>
                <!-- /mid column wrap -->
                </div>
                <!-- /main wrapper -->

                <!-- clear main & sidebar sections -->
                <div class='clearcontent'></div>
                <!-- /clear main & sidebar sections -->

                <!-- footer -->
                <div id='footer'>
    	            <p>GCT CSITA - iTeam<br>TopCoder uses <a href='http://ideone.com' target='_blank'>Ideone API</a> &copy; by <a href='http://sphere-research.com' target='_blank'>Sphere Research Labs</a></p>
                </div>
                <!-- /footer -->
                
                <!-- layout controls -->
                <div id='layoutcontrol'>
        	        <a href='javascript:void(0);' class='setFont' title='Increase/Decrease text size'><span>SetTextSize</span></a>
            	    <a href='javascript:void(0);' class='setLiquid' title='Switch between full and fixed width'><span>SetPageWidth</span></a>
                </div>
                <!-- /layout controls -->
               
            </div>
            <!-- /page -->
        </div>
        </div>
        <!-- /page wrappers -->
	</body>
</html>