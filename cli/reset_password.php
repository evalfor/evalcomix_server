<?php
/**
 * This script allows you to reset any local user password.
 *
 * @package    core
 * @subpackage cli
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../configuration/conf.php');
require_once(DIRROOT . '/lib/clilib.php');      // cli only functions
require_once(DIRROOT . '/classes/users.php');
require_once(DIRROOT . '/src/user/user_controller.php');

// Define the input options.
$longparams = array(
        'help' => false,
        'username' => '',
        'password' => '',
        'ignore-password-policy' => false
);

$shortparams = array(
        'h' => 'help',
        'u' => 'username',
        'p' => 'password',
        'i' => 'ignore-password-policy'
);

// now get cli options
list($options, $unrecognized) = cli_get_params($longparams, $shortparams);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
"Reset local user passwords, useful especially for admin acounts.

There are no security checks here because anybody who is able to
execute this file may execute any PHP too.

Options:
-h, --help                    Print out this help
-u, --username=username       Specify username to change
-p, --password=newpassword    Specify new password
--ignore-password-policy      Ignore password policy when setting password

Example:
\$sudo -u www-data /usr/bin/php admin/cli/reset_password.php
\$sudo -u www-data /usr/bin/php admin/cli/reset_password.php --username=claudia --password=clo2clo
";

    echo $help;
    die;
}
if ($options['username'] == '' ) {
    cli_heading('Password reset');
    $prompt = "Enter username (manual authentication only)";
    $username = cli_input($prompt);
} else {
    $username = $options['username'];
}

if (!$user = users::fetch(array('usr_nam'=>$username))) {
    cli_error("Can not find user '$username'");
}

if ($options['password'] == '' ) {
    $prompt = "Enter new password";
    $password = cli_input($prompt);
} else {
    $password = $options['password'];
}

user_controller::change_password($user->id, $password);

echo "Password changed\n";

exit(0); // 0 means success.