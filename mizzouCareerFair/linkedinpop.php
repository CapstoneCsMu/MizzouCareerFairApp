<div data-role="page" data-dialog="true" id="linkedinpop">
			<div data-role="header">
				<h1>Log in with LinkedIn</h1>
			</div>
			
			<div data-role="main" class="ui-content">
				<p>You have the ability to Check In at the Employer Booths.  If you would like the Recruiters to have your LinkedIn profile sent to them Sign In Here</p>
				
				<form method="post" action="tigerlogin.php">
					<div class="ui-field-contain">
						<label for="pawprint">LinkedIn:</label>
							<input type="text" name="linkedin" id="linkedin">
						<label for="Name">Full Name:</label>
							<input type="text" name="name" id="name"> 
					</div>
					<input type="submit" data-inline="true" value="Submit">
				</form>
				
				<a href="mobile.php">Back to Home</a>
			</div>
			
			<div data-role="footer">
				<h1>LinkedIn Sign In</h1>
			</div>
</div>