<?php
//
// Autodeploy script for bitbucket.org service
//
define('TIME_LIMIT', 6000);
$repo_dir = '/var/www/developers/erau.dev.gns-it.com/frontend/.git/erau-frontend.git';
$web_root_dir = '/var/www/developers/erau.dev.gns-it.com/frontend/www/';
$root_dir = '/var/www/developers/erau.dev.gns-it.com/frontend/';
$tree = 'master';
$git_bin = '/usr/bin/git';
$update = false;

// Check request header for permissions
// [in] $_SERVER['REMOTE_ADDR']
// [out] true if allowed / false if denided
function isBitbucket($client)
{
    $permit_list = array(
        '104.192.143.1',
        '104.192.143.2',
        '104.192.143.3',
        '104.192.143.4',
        '104.192.143.5',
        '104.192.143.6',
        '104.192.143.65',
        '104.192.143.66',
        '104.192.143.67',
        '104.192.143.68',
        '104.192.143.69',
        '104.192.143.70',
        '104.192.143.192',
        '104.192.143.193',
        '104.192.143.194',
        '104.192.143.195',
        '104.192.143.196',
        '104.192.143.197',
        '104.192.143.198',
        '104.192.143.199',
        '104.192.143.200',
        '104.192.143.201',
        '104.192.143.202',
        '104.192.143.203',
        '104.192.143.204',
        '104.192.143.205',
        '104.192.143.206',
        '104.192.143.208',
        '104.192.143.209',
        '104.192.143.210',
        '104.192.143.211',
        '104.192.143.212',
        '104.192.143.213',
        '104.192.143.214',
        '104.192.143.215',
        '104.192.143.216',
        '104.192.143.217',
        '104.192.143.218',
        '104.192.143.218',
        '104.192.143.220',
        '104.192.143.221',
        '104.192.143.222',
    );
    if (!in_array($client, $permit_list)) {
        header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);

        return false;
    } else {
        return true;
    }
}

if (array_key_exists('push', $_POST) && isBitbucket($_SERVER['REMOTE_ADDR']) === true) {
    set_time_limit(TIME_LIMIT);
    $payload = $_POST['push'];
    if (empty($payload['changes'])) {
        $update = true;
    } else {
        foreach ($payload['changes'] as $commit) {
            $branch = $commit['new']['name'];
            if ($branch === 'master') {
                $update = true;
                break;
            }
        }
    }
    if ($update) {
        chdir($root_dir);
        $output = array();
        exec($git_bin.' pull origin '.$tree.' 2>&1', $output, $return_code);
        foreach ($output as $key) {
            echo $key."\r\n";
        }
        if ($return_code !== 0) {
            header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
            echo "500 Internal Server Error on script execution. Check <VirtualHost> config or httpd.service status \r\n";
        } else {
            //$sh_exec = shell_exec($root_dir . "deploy.sh 2>&1");
            //echo "Executing deploy.sh script...." . $sh_exec . "\r\n";
            echo "Done. Bye! \r\n";
        }
    }
} else {
    echo "<pre>You do not allowed here! Go away!</pre>";
}