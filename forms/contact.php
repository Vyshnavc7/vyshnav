<?php
$receiving_email_address = 'officialvyshnavc7@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate the form fields (name, email, etc.)
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
    die('Please fill in all fields.');
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
  }

  // Include the email form library
  if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
  } else {
    die('Unable to load the PHP Email Form Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  // Add your SMTP settings here if needed

  $contact->add_message($_POST['name'], 'From');
  $contact->add_message($_POST['email'], 'Email');
  $contact->add_message($_POST['message'], 'Message', 10);

  // Send the email and return 'OK' if successful
  if ($contact->send()) {
    echo 'OK';
  } else {
    echo 'Failed to send email.';
  }
} else {
  // Return an error for invalid requests
  echo 'Invalid request.';
}
?>
