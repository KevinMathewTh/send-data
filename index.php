<?php
    include("connection.php");
   $query="SELECT * FROM contactus";
    $qry=mysqli_query($link, $query);
    $fh = fopen("file.csv","w");
    while($result=mysqli_fetch_array($qry))
    {
    $id=$result["ID"];
    $name=$result["Name"];
    $email=$result["Email"];
    $phone=$result["Phone"];
    $message=$result["Message"];
    $qoute=$result["qoute"];
    $demo=$result["demo"];
    // echo $id." ".$name." ".$email." ".$phone." ".$message." ".$qoute." ".$demo."<br>";
    $data=array(
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "message" =>$message,
        "qoute"=>$qoute,
        "demo"=>$demo
    );
    fputcsv($fh,$data);
    // echo "success";
    }
    fclose($fh);
    // Send Mail code
    $filename = 'file.csv';
    // $path = 'your path goes here';
    // $file = $path . "/" . $filename;
    $file=$filename;

    $mailto = 'mathewthomaskevin@gmail.com';
    $subject = 'Subject';
    $message = 'My message';

    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: name <test@test.com>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
        print_r( error_get_last() );
    }
   
    
    

?>