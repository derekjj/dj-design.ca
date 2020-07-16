<?PHP
$file = file_get_contents("php://input");
if($file)
{
    $data = json_decode(file_get_contents("php://input"), TRUE);
    $email = htmlspecialchars($data['email']);
    $subject = htmlspecialchars($data['subject']);
    $emailMessage = $data['emailMessage'];
    $recaptcha = $data['recaptcha'];
    
    $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdHIEIUAAAAAL10chsVK4jVB1rhv1qKlx3KGJbn&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
    if($response['success'] == true)
    {
        //variables
        $to = 'derek@dj-design.ca'; //Defaulted to avoid people sending to others        
        $emailMessage .=  "\r\n\r\n" .'Reply email is '. $email;
        $emailMessage .=  "\r\n\r\n" .'Email sent from the website.';
        $headers = 'From: noreply' . "\r\n" .
        'Reply-To: '. $email . "\r\n";
        if(mail($to, $subject, $emailMessage, $headers))
        {
            var_dump(http_response_code(202));
        }
        else
        {
            var_dump(http_response_code(409));
        }
    }
    else
    {
        var_dump(http_response_code(409));
    }
}
else {
    var_dump(http_response_code(409));
}
?>
