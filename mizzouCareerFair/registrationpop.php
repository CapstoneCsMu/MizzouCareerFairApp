<div data-role="page" data-dialog="true" id="linkedinpop">
			<div data-role="header">
				<h1>Student Registration</h1>
			</div>
			
			<div data-role="main" class="ui-content">
				<p>Please Enter fields!
				<form method="post" action="registration.php">
					<div class="ui-field-contain">
						<label for="username">Username:</label>
							<input type="text" name="username" id="username" maxlength="10"></br>       
						<label for="password">Password:</label>
							<input type="password" name="password" id="password" maxlength="15"></br> 
						<label for="firstname">Firstname:</label>
							<input type="text" name="firstname" id="firstname"></br> 
						<label for="lastname">Lastname:</label>
							<input type="text" name="lastname" id="lastname"></br> 
						<label for="email">E-mail:</label>
							<input type="email" name="email" id="email" placeholder="yourusername@mail.missouri.edu"></br> 
						<label for="gradDate">Grad. Date:</label>
							<input type="text" name="gradDate" id="gradDate" placeholder="Dec-2015"> </br> 
						<label for="major">Major:</label>
							<input type="text" name="major" id="major">  </br> 
						<label for="resume">Resume:</label>
							<input type="file" name="resume" id="resume"></br>   
						<label for="phone">Phone:</label>
							<input type="text" name="phone" id="phone" placeholder="(xxx)xxx-xxxx"></br> 
						<label for="lifePlan">Career Goals:</label>
							<textarea rows="5" name="lifePlan" wrap="physical" maxlength="200"></textarea></br> 
						<label for="linkedIn">LinkedIn Email:</label>
							<input type="text" name="linkedIn" id="linkedIn">  </br> 	
					</div>
					<input type="submit" data-inline="true" value="Submit">
				</form>
				<a href="mobile.php">Back to Home</a>
			</div>
			
			<div data-role="footer">
				<h1>Mizzou Tiger Registration</h1>
			</div>
</div>