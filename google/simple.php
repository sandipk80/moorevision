<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_CalendarService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");

// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('551238613275-rq4qrb8tbv0f7u501j1odn8slqld6ute.apps.googleusercontent.com');
$client->setClientSecret('UNb3B-iRBrBKeKAk_hdTGzJS');
$client->setRedirectUri('http://localhost/work/gplus-verifytoken-php-master/simple.php');
$client->setDeveloperKey('AIzaSyAB8OsXwcXoa_yMtV1Ttu0QAB4nKLLyejQ');
$cal = new Google_CalendarService($client);
if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  //$calList = $cal->calendarList->listCalendarList();
  //print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

$event = new Google_Event();
$event->setSummary('Appointment');
$event->setLocation('Chandigarh');
$start = new Google_EventDateTime();
$start->setDateTime('2016-08-10T10:00:00.000-07:00');
$event->setStart($start);
$end = new Google_EventDateTime();
$end->setDateTime('2016-08-10T10:25:00.000-07:00');
$event->setEnd($end);
$attendee1 = new Google_EventAttendee();
$attendee1->setEmail('web.codebyte@gmail.com');

$attendees = array($attendee1);
$event->attendees = $attendees;
$createdEvent = $cal->events->insert('0l6h391d9iaqqthhg4gfrtul9o@group.calendar.google.com', $event);
print"<pre>";
print_r($createdEvent);
$calList = $cal->calendarList->listCalendarList();
 print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";	


$_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
?>