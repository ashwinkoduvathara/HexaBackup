<?php
require '/usr/local/cpanel/php/cpanel.php';

$cpanel = new CPANEL();
echo $cpanel->header( 'Hexa Backup' );
$accountName = $cpanel->cpanelprint('$user');
$hostname = $cpanel->cpanelprint('$hostname');

$domainData = [];
// Call the API
$response = $cpanel->uapi(
    'DomainInfo',
    'domains_data'
);

// Handle the response
if ($response['cpanelresult']['result']['status']) {
    $data = $response['cpanelresult']['result']['data'];
    // Do something with the $data
    // So you can see the data shape we print it here.
    //var_dump($data);
    $domainData = $data['addon_domains'] ?? [];

    if (isset($data['main_domain'])) {
		$domainData['main'] = $data['main_domain'];
		if (isset($data['sub_domains'])) {
			$domainData['main']['sub_domains'] = $data['sub_domains'];
		}
	} else {
		if (isset($data['sub_domains'])) {
			$domainData = $data['sub_domains'];
		}
	}
	
}
else {
    // Report errors:
    echo '<pre>';
    var_dump($response['cpanelresult']['result']['errors']);
    echo '</pre>';
}

//get mysql host name
$hostname = '';
$response = $cpanel->uapi(
    'Mysql',
    'get_server_information'
);

// Handle the response
if ($response['cpanelresult']['result']['status']) {
    $data = $response['cpanelresult']['result']['data'];
    // Do something with the $data
    // So you can see the data shape we print it here.
    $hostname = $data['host'];
} else {
    // Report errors:
    echo '<pre>';
    var_dump($response['cpanelresult']['result']['errors']);
    echo '</pre>';
}






?>
<form method="post">
    <h3>Migration Plugin</h3>
    <hr>




	<div class="form-group">
		<button type="submit"  name="backup" class="btn btn-primary">Migrate</button>
	</div>

</form>


<?php

function createBackup() {
    // Path to the backup script in the 'script' folder
    $scriptPath = 'scripts/backup.sh';

    // Get the user's home directory dynamically
    $userDir = getenv('HOME'); // Fetches the home directory of the user executing the script

    // Escape the directory path to prevent command injection
    $userDirEscaped = escapeshellarg($userDir);

    // Run the bash script with the user's home directory as an argument
    $command = "bash $scriptPath $userDirEscaped";
    $output = shell_exec($command);

    // Return the output of the script
    return $output;
}

if (isset($_POST['backup'])) {
    $backupResult = createBackup();

    echo nl2br($backupResult); // Display the backup result on the webpage
}
?>






<script>
function toggleMysql(element) {
	let mysqlConfiguration = document.getElementById("mysql-configuration");
	if (element.value == "mysqli") {
		mysqlConfiguration.style.display = "block"
	} else {
		mysqlConfiguration.style.display = "none"
	}
	return false;
}

function toggleAdvanced() {
	let advancedConfiguration = document.getElementById("advanced-configuration");
	if (advancedConfiguration.style.display == "none") {
		advancedConfiguration.style.display = "block"
	} else {
		advancedConfiguration.style.display = "none"
	}
	
	return false;
}
</script> 
<?php	


echo $cpanel->footer();
$cpanel->end();
?>
