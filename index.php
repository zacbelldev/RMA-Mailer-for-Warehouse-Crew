<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);


require('../PHPMailer/PHPMailerAutoload.php');

if (isset($_POST['submitForm'])) {

    $mail = new PHPMailer;

    $mail->setFrom('zac@monkeybarstorage.com', 'Returns Dept.');
    $mail->addAddress('monkeybarsshipping@gmail.com', 'Zac Bell');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('zac@monkeybarstorage.com', 'Zac Bell');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    if (isset($_FILES['attach1']) && $_FILES['attach1']['error'] == UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['attach1']['tmp_name'],
            $_FILES['attach1']['name']);
    }

    if (isset($_FILES['attach2']) && $_FILES['attach2']['error'] == UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['attach2']['tmp_name'],
            $_FILES['attach2']['name']);
    }

    $mail->isHTML(true);    // Set email format to HTML

    $mail->Subject = 'Return Notification';

    $mail->Body =
        "Returns Manager, <br><br>Below is the information for a return that was just received: " .
        "<br>Received By: " . $_POST['user'] .
        "<br>Customer name: " . $_POST['name'] .
        "<br>RMA # (if found): " . $_POST['rma'] .
        "<br>SKU's/components: " . $_POST['item'] .
        "<br>Items Restocked: " . $_POST['restock'] .
        "<br><br>Notes: " . $_POST['notes'] .
        "<br><br>Best,
    <br><br>The Warehouse";

    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        $messageTwo = 'Message could not be sent.';
        $messageTwo .= 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $messageTwo = 'Message has been sent.';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="user-scalable=no">
    <link rel="stylesheet" type="text/css" href="style.css">
<!--    <link rel="stylesheet" type="text/css" href="/cssFiles/indexCSS.css">-->
<!--    <link rel="stylesheet" type="text/css" href="/cssFiles/snackbar.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<div id="banner">
    <a href="/index.php"><img src="/logo.png"></a>
</div>
<!--<div id="navBar">
    <a href='/index.php'>Previous Page</a><br>
    <h3>Returns Entry</h3>
</div>-->
<div id="bodyDiv">
    <br><br><br><br><br>
    <div id="containerCNC">
        <div id="containerCNCchild1">
            <h3 id ="heading">Return Entry</h3>
            <p><?php if (isset($messageTwo)) {
                    echo $messageTwo;
                    unset($messageTwo);
                } else {
                    echo "<p>** Fields are required.</p>";
                }
                ?></p>
            <form method="post" action="." enctype="multipart/form-data">
                <label id="userLabel" for="user">*Received By: </label><br>
                <input autocomplete="off" type="text" name="user" id="user" required><br><br>

                <label id="rmaLabel" for="rma">RMA # (if found): </label><br>
                <input autocomplete="off" type="text" name="rma" id="rma"><br><br>

                <label id="nameLabel" for="name">*Customer name: </label><br>
                <input autocomplete="off" type="text" name="name" id="name" required><br><br>

                <label id="itemLabel" for="item">*SKU's/components: </label><br>
                <input autocomplete="off" type="text" name="item" id="item" required><br><br>

                <label id="restockLabel" for="restock">*List of items restocked into inventory: </label><br>
                <textarea name="restock" id="restock" required></textarea><br><br>


                <label id="notesLabel" for="notes">Notes (optional): </label><br>
                <textarea name="notes" id="notes"></textarea><br><br>



                <label id="fileInputLabel1" for="fileInput">*Box Condition Image: </label><br>
                <input type="file" name="attach1" class="fileInput"><br><br>

                <label id="fileInputLabel2" for="fileInput">*Close Up Label Image: </label><br>
                <input type="file" name="attach2" class="fileInput"><br><br>



                <input type="submit" name="submitForm" value="Submit" class="submitButton">

            </form>
        </div>
    </div>
</div>
</body>
</html>