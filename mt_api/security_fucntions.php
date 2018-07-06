<!-- 
    Copyright 2016, 2017 Musto Technologies LLC http://www.mustotechnologies.com
	
	-- GPLv3 License --
	This file is part of MT Kestrel.

    MT Kestrel is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    MT Kestrel is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with MT Kestrel as the COPYING.txt file.  If not, 
	see <http://www.gnu.org/licenses/>.
-->
<?php
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    /*Sets the session name. 
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP. 
     */
    session_name($session_name);
 
	// set to true when SSL is enabled
    $secure = false;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
 
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}
function login($email, $password, $connect) {
	
	// Check $connection
	if (mysqli_connect_errno()) {
    die('<p>Failed to connect to MySQL: '.mysqli_connect_error().'</p>');
	} 
	
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $connect->prepare("SELECT `USERNAME`, `EMAIL`, `PASSWORD`, `ROLE`, `MODULES` FROM `members` WHERE `EMAIL` = ?")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
		
        // get variables from result.
        $stmt->bind_result($username, $email, $db_password, $role, $modules);
        $stmt->fetch();
	
		if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
			
			if (checkbrute($username, $connect) == true) {
                // Account is locked 
                echo "<br><br><h2>Account is locked due to too many password attempts, try again in 5 minutes or contact support</h2><br>";
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
					// Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_email = preg_replace("/[^0-9]+/", "", $email);
                    $_SESSION['user_email'] = $email;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
					$_SESSION['user_role'] = $role;
					$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
					// We record this attempt in the database
					echo "<br><br><h2>Password is NOT correct</h2><br>";
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$remote_addr = $_SERVER['REMOTE_ADDR'];
					echo $remote_addr;
					if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$x_forward = $_SERVER['HTTP_X_FORWARDED_FOR'];	
					} else {
					$x_forward = "not supplied";
					}
					$attempted_action = "login.php";
					$UTC_TIME = date('Y-m-d G:i:s');
					$CUR_TIME = date('Y-m-d G:i:s', strtotime(UTC_OFFSET));
                    $mysqli->query("INSERT INTO `LOGIN_ATTEMPTS`(`USERNAME`, `TIME`, `REMOTE_ADDR`, `X_FORWARD`, `ATTEMPTED_ACTION`, `BROWSER`) VALUES ('$username', '$CUR_TIME', '$remote_addr', '$x_forward', '$attempted_action', '$user_browser')");
					return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
	if (false===$stmt){
		die('prepare() failed: ' . htmlspecialchars($connect->error));
	}
}
function checkbrute($username, $connect) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 5 minutes. 
    $valid_attempts = $now - (5 * 60);
 
    if ($stmt = $connect->prepare("SELECT `TIME` FROM `LOGIN_ATTEMPTS` WHERE `USERNAME` = ? AND `TIME` > '$valid_attempts'")) {
        $stmt->bind_param('i', $username);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 99) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($connect) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_email'], $_SESSION['username'], $_SESSION['user_role'], $_SESSION['login_string'])) {
		$user_role = $_SESSION['user_role'];
        $user_email = $_SESSION['user_email'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
		
		// Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $connect->prepare("SELECT `PASSWORD` FROM `members` WHERE `EMAIL` = ?")) {
            // Bind "$username" to parameter. 
            $stmt->bind_param('s', $user_email);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($db_password);
                $stmt->fetch();
                $login_check = hash('sha512', $db_password . $user_browser);
 
                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
				echo "ERROR: more than one record.";
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
?>
