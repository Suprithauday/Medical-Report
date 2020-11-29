<!--Edit a practitioner-->

<?php
	if(session_id() == '') {
		session_start();
	}
	
	if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
		$initialID = $_POST['pracID'];
		$initialFirst = $_POST['firstName'];
		$initialLast = $_POST['lastName'];
		$initialUser = $_POST['userName'];
		$initialPass = $_POST['password'];
		$initialAdmin = $_POST['administrator'];

		echo "></td>
		        </tr>
		        <tr>
		            <td>Administrator?</td>";

		            if ($initialAdmin) {
		            	echo "<td><input type=\"radio\" id=\"administrator\" name=\"administrator\" value=\"yes\" checked>Yes</td>";
		            	echo "<td><input type=\"radio\" id=\"administrator\" name=\"administrator\" value=\"no\">No</td>";
		            } else {
		            	echo "<td><input type=\"radio\" id=\"administrator\" name=\"administrator\" value=\"yes\">Yes</td>";
		            	echo "<td><input type=\"radio\" id=\"administrator\" name=\"administrator\" value=\"no\" checked>No</td>";
		            }

		echo "  </tr>
		        <tr>
	        		<td><input type=\"submit\" id=\"submit\" value=\"Confirm Edits\"/></td>
	        	</tr>
		    </table>
		</form>";
	} else {
		echo "You are not authorised to view this page. Please log in.";
		echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
			</form>';
	}
?>