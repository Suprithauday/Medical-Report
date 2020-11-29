<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset=utf-8" />
    <link rel="stylesheet" href="../style.css">
    <script src="../FormVerify.js"></script>
    <?php
    include("../operations.php");
    session_start();
    ?>
    <title>BIOM 9450: A Web-Based Medication and Diet Regime Management System </title>
</head>

<body>
<header>
			<form id="logout" method="POST" action="../index.php">
				<input type="submit" id="logoutSubmit" value="Log Out"/>
			</form>
            <form id="backToControlPanel" method="POST" action="../controls/controls.php">
				<input type="submit" id="backToControlPanelSubmit" value="Back"/>
			</form>
			<hr>
		</header>
		<?php
			if (isset($_SESSION['userName']) && $_SESSION['isAdmin']) {
				echo '<h3>View Relationships</h3>
				<form id="insertRelationships" method="POST" action="../insertForm.php">
					<input type="submit" id="insertRelationshipSubmit" value="Insert Relationship"/>
					<input type="hidden" id="formType" name="formType" value="relationship"/>
			  	</form><br>';
				echo '<form id="searchRelationships" method="POST" action="../Connections/ViewCon.php">
						<input type="text" id="relationshipSearch" name="relationshipSearch" placeholder="search"></td>
						<input type="submit" id="searchRelationshipSubmit" value="Search Relationships"/>
					</form>';
				
				$isAdmin = $_SESSION['isAdmin'];
				$conn = openConnection();

				if (isset($_POST['relationshipSearch'])) {
					$searchTerms = $_POST['relationshipSearch'];
				} else {
					$searchTerms = '';
				}
				
				displayConnections($conn, $isAdmin, $searchTerms);
			} else {
				echo "You are not authorised to view this page. Please log in.";
				echo '<form id="login" method="POST" action="../index.php">
				<input type="submit" id="loginSubmit" value="Log In"/></td>
				</form>';
			}
		?>
		
	</body>

</html>