  <div data-role="page" data-theme="a" id="myProfile">
        <div data-role="header" data-position="fixed">
            <h1 onclick="$.mobile.silentScroll(0)">My Profile</h1>
            <a data-transition="slidedown" data-icon="arrow-l" data-iconpos="notext" href="#home" rel="external">Home</a> 
			<a data-transition="slide" data-icon="edit" href="#Edit">Edit</a>
        </div>
				
		<div data-role="content">
			<div data-role="tabs">
				<div data-role="navbar">
					<ul>
						<li><a href="#profile">Profile</a></li>
						<li><a href="#code">QR Code</a></li>
						<li><a href="#jobHunt">Job Hunt</a></li>
					</ul>
				</div>
				<div id="profile">
				</div>
				<div id="jobHunt">
					<?php echo"</br><center><script type=\"IN/JYMBII\" data-format=\"inline\"></script></center>" ?>
				</div>
				<div id="code">
				    <h4><center>Have employers scan your QR Code and they will have your information!<center></h4>
					<?php
					echo '<center><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=https://babbage.cs.missouri.edu/~cs4970s14grp2/mizzoucareerfairs/CodeScanned.php?email='.$_SESSION['student_loggedin'].'"&choe=UTF-8"/><center>';
					?>
				</div>
			</div>
		</div>
		<div class="panel left" data-role="panel" id="Edit" data-position="left" data-display="overlay">
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
				<li data-role="list-divider">Edit Profile</li>
				<li><a  style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-edit ui-btn-icon-left" href="updateProfileForm.php">Edit Info</a></li>
				<li><a  style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-cloud ui-btn-icon-left" href="addResume.php">Upload Resume</a></li>
			</ul>
		</div>
	</div>
