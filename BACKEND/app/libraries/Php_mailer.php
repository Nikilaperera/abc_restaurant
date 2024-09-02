<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once APPPATH . 'libraries/PHPMailer/src/PHPMailer.php';
require_once APPPATH . 'libraries/PHPMailer/src/SMTP.php';
require_once APPPATH . 'libraries/PHPMailer/src/Exception.php';

class Php_mailer
{

    protected $CI;
    protected $email;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->email = new PHPMailer(true);
    }

    public function sendEmail($to, $cc = null, $subject, $body)
    {

        try {
            $this->email->SMTPDebug = 2; // Enable verbose debug output
            $this->email->isSMTP(); // Set mailer to use SMTP
            $this->email->Host = 'mail.webgenex.lk'; // Specify main and backup SMTP servers
            $this->email->SMTPDebug = 3;
            $this->email->SMTPAuth = false; // Enable SMTP authentication
            $this->email->SMTPAutoTLS = false;
            $this->email->Port = 2525; // TCP port to connect to
            // $this->email->isSMTP();
            // $this->email->Host = 'smtp.gmail.com';  // Replace with  SMTP server address
            // $this->email->SMTPAuth = true;
            // $this->email->Username = 'nikila@webgenex.lk'; // Replace with  email address
            // $this->email->Password = 'WebGenex@80A';  // Replace with  email password
            // $this->email->SMTPAutoTLS = true;
            // $this->email->SMTPSecure = 'tls'; // TLS encryption, you can use 'ssl' as well
            // $this->email->Port = 587; // SMTP port, change if needed
            // TCP port to connect to

            $this->email->setFrom('nikila@webgenex.lk', 'WebGenex Lanka'); // Replace with  email and name
            $this->email->addAddress($to); // Set the recipients email address
            $this->email->isHTML(true);
            if (!empty($cc)) {
                $this->email->addCC($cc); // Add CC email address
            }
            $this->email->addBCC('nikila@webgenex.lk');
            $this->email->Subject = $subject;
            $this->email->Body = $body;
            $this->email->AltBody = strip_tags($body);

            $this->email->send();
            $this->email->clearAddresses();
            $data= 'Email sent successfully.';
             echo json_encode($data);
        } catch (Exception $e) {
            echo 'Error: ' . $this->email->ErrorInfo;
        }
    }


    public function sendEmailTimeTable($to, $cc = null, $subject, $body)
    {
        try {
            $this->email->SMTPDebug = 2; // Enable verbose debug output
            $this->email->isSMTP(); // Set mailer to use SMTP
            $this->email->Host = 'mail.webgenex.lk'; // Specify main and backup SMTP servers
            $this->email->SMTPDebug = 3;
            $this->email->SMTPAuth = false; // Enable SMTP authentication
            $this->email->SMTPAutoTLS = false;
            $this->email->Port = 2525; // TCP port to connect to
            // $this->email->isSMTP();
            // $this->email->Host = 'smtp.gmail.com';  // Replace with  SMTP server address
            // $this->email->SMTPAuth = true;
            // $this->email->Username = 'nikila@webgenex.lk'; // Replace with  email address
            // $this->email->Password = 'WebGenex@80A';  // Replace with  email password
            // $this->email->SMTPAutoTLS = true;
            // $this->email->SMTPSecure = 'tls'; // TLS encryption, you can use 'ssl' as well
            // $this->email->Port = 587; // SMTP port, change if needed
            // TCP port to connect to

            $this->email->setFrom('nikila.webgenex.lk', 'WebGenex'); // Replace with  email and name
            $this->email->addAddress($to); // Set the recipients email address
            if (!empty($cc)) {
                $this->email->addCC($cc); // Add CC email address
            }
            $this->email->Subject = $subject;
            $this->email->Body = $body;
            $this->email->AltBody = strip_tags($body);


            $this->email->send();
//            $data= 'Email sent successfully.';
            $this->email->clearAddresses();
//             echo json_encode($data);
        } catch (Exception $e) {
//            echo 'Error: ' . $this->email->ErrorInfo;
        }
    }


    public function facilityEmail($to, $cc = null, $subject, $body)
    {
        try {
            $this->email->SMTPDebug = 2; // Enable verbose debug output
            $this->email->isSMTP(); // Set mailer to use SMTP
            $this->email->Host = 'mail.webgenex.lk'; // Specify main and backup SMTP servers
            $this->email->SMTPDebug = 3;
            $this->email->SMTPAuth = false; // Enable SMTP authentication
            $this->email->SMTPAutoTLS = false;
            $this->email->Port = 2525; // TCP port to connect to
            // $this->email->isSMTP();
            // $this->email->Host = 'smtp.gmail.com';  // Replace with  SMTP server address
            // $this->email->SMTPAuth = true;
            // $this->email->Username = 'nikila@webgenex.lk'; // Replace with  email address
            // $this->email->Password = 'WebGenex@80A';  // Replace with  email password
            // $this->email->SMTPAutoTLS = true;
            // $this->email->SMTPSecure = 'tls'; // TLS encryption, you can use 'ssl' as well
            // $this->email->Port = 587; // SMTP port, change if needed
            // TCP port to connect to

            $this->email->setFrom('nikila.webgenex.lk', 'WebGenex'); // Replace with  email and name
            $this->email->addAddress($to); // Set the recipients email address
            if (!empty($cc)) {
                $this->email->addCC($cc); // Add CC email address
            }
            $this->email->Subject = $subject;
            $this->email->Body = $body;
            $this->email->AltBody = strip_tags($body);

            $this->email->send();
            // $data= 'Email sent successfully.';
            //  echo json_encode($data);
        } catch (Exception $e) {
            // echo 'Error: ' . $this->email->ErrorInfo;
        }
    }

    public function sendUserCredentials($to, $cc = null, $subject, $body)
    {

        try {
            $this->email->SMTPDebug = 2; // Enable verbose debug output
            $this->email->isSMTP(); // Set mailer to use SMTP
            $this->email->Host = 'mail.webgenex.lk'; // Specify main and backup SMTP servers
            $this->email->SMTPDebug = 3;
            $this->email->SMTPAuth = false; // Enable SMTP authentication
            $this->email->SMTPAutoTLS = false;
            $this->email->Port = 2525; // TCP port to connect to
            // $this->email->isSMTP();
            // $this->email->Host = 'smtp.gmail.com';  // Replace with  SMTP server address
            // $this->email->SMTPAuth = true;
            // $this->email->Username = 'nikila@webgenex.lk'; // Replace with  email address
            // $this->email->Password = 'WebGenex@80A';  // Replace with  email password
            // $this->email->SMTPAutoTLS = true;
            // $this->email->SMTPSecure = 'tls'; // TLS encryption, you can use 'ssl' as well
            // $this->email->Port = 587; // SMTP port, change if needed

            $this->email->setFrom('nikila@webgenex.lk', 'WebGenex'); // Replace with  email and name
            $this->email->addAddress($to); // Set the recipients email address
            $this->email->isHTML(true);
            if (!empty($cc)) {
                $this->email->addCC($cc); // Add CC email address
            }
            $this->email->addBCC('nikila@webgenex.lk');
            $this->email->Subject = $subject;
            $this->email->Body = $body;
            $this->email->AltBody = strip_tags($body);

            $this->email->send();
            $this->email->clearAddresses();
           return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
