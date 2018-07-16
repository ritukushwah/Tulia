<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*Application development contants*/

//DB connection based on environment
/*switch ($_SERVER['SERVER_NAME']) {
    case 'localhost':
       define('TL_DB_HOST', 'localhost');
        define('TL_DB_USERNAME', 'root');
        define('TL_DB_PASSWORD', '');
        define('TL_DB_DATABASE_NAME', 'tulia');
        break;
    default:
        define('TL_DB_HOST', 'localhost');
        define('TL_DB_USERNAME', 'tulia_livetulia');
        define('TL_DB_PASSWORD', 'dbS1swW@wN0,');
        define('TL_DB_DATABASE_NAME', 'tulia_livetulia');
        $host     = $_SERVER['HTTP_HOST'];
}*/

define('THEME_BUTTON', 'btn btn-primary');
define('THEME', ''); // skin-1, skin-2, skin-3
define('FROM_EMAIL', 'support@tulia.com');
define('SUPPORT_EMAIL', 'support@tulia.com');
define('SITE_NAME', 'Tulia');
define('DEFAULT_NO_IMG', 'noimagefound.jpg');
define('EDIT_ICON', '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>');
define('DELETE_ICON', '<i class="fa fa-trash-o" aria-hidden="true"></i>');
define('ACTIVE_ICON', '<i class="fa fa-check" aria-hidden="true"></i>');
define('INACTIVE_ICON', '<i class="fa fa-times" aria-hidden="true"></i>');
define('VIEW_ICON', '<i class="fa fa-eye" aria-hidden="true"></i>');
define('PASSWORD_ICON', 'backend_asset/custom/images/key.png');
define('SITE_TITLE','Tulia');
define('COPYRIGHT','Tulia &copy; 2017-2018');
define('ADMIN_EMAIL', 'admin@tulia.com');

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
define('OK',	'200');
define('SERVER_ERROR',	'400');

define('SUCCESS', 'success');
define('FAIL', 'fail');

//Firebase API key for notifications
define('NOTIFICATION_KEY','AAAARhoraBA:APA91bF60FScjvb-3LkAo5zyMMn24xfNRIPLA1Pc0rYI-ijRz0a1ITij6keKaz37SjVP1D5qq9Kl5FXwXaHj2fXs1qo9wkDEA4NjyXxApXFcQkqrQ7n1luy-HUElSOYTJZ8LU8w_1Vlz');

//DB tables
define('USERS', 'users');
define('USER_META', 'usermeta');
define('ATTACHMENTS', 'attachments');
define('CATEGORIES', 'categories');
define('USR_CAT_MAPPING', 'user_category_mapping');
define('EVENT_TYPE', 'event_type');
define('POSTS', 'posts');
define('POST_CAT_MAPPING', 'post_category_mapping');
define('DOING_EVENT', 'doing_event');
define('REVIEWS', 'reviews');
define('ALBUMS', 'albums');
define('NOTIFICATIONS', 'notifications');
define('CONTENT','page_content');
define('FEEDBACK', 'feedback');


define('USER_AVATAR_PATH', 'uploads/user_avatar/');
define('USER_DEFAULT_AVATAR', 'uploads/user_avatar/placeholder.png');
define('CATEGORY_DEFAULT_IMAGE', 'uploads/category/category_placeholder.jpg');
define('CATEGORY_IMAGE_PATH', 'uploads/category/');
define('ALBUM_IMAGE_PATH', 'uploads/user_album/');
define('ADMIN_IMAGE_PATH', 'uploads/profile/');
define('USER_CONTENT','uploads/content/');

