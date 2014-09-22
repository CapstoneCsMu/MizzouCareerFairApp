<div data-role="page" data-dialog="true" id="linkedinpop">
			<div data-role="header">
				<h1>Student Login</h1>
			</div>
			
			<div data-role="main" class="ui-content">
				<p>You have the ability to Check In at the Employer Booths.  If you would like the Recruiters to have your name and email on their list Log In here with your Mizzou PawPrint and Password</p>
				
				<form method="post" action="tigerlogin.php">
					<div class="ui-field-contain">
						<label for="pawprint">Pawprint:</label>
							<input type="text" name="fullname" id="fullname">       
						<label for="password">Password:</label>
							<input type="password" name="password" id="password">
						<label for="email">E-mail:</label>
							<input type="email" name="email" id="email" placeholder="pawprint@mail.missouri.edu">
					</div>
					<input type="submit" data-inline="true" value="Submit">
				</form>
				<a href="mobile.php">Back to Home</a>
			</div>
			
			<div data-role="footer">
				<h1>Mizzou Tiger Sign In</h1>
			</div>
</div>