<?php
$to = 'writer_works@ukr.net';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
      
        $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING);
        
     
        
        $subjects = trim($_POST["subject-1"]);
       // $subject = filter_var(trim($subject), FILTER_SANITIZE_STRING);
        
        
        $work_email = trim($_POST["work_email"]);
            //  $work_email = filter_var(trim($work_email), FILTER_SANITIZE_STRING);
        
        
     
        
        $pages = trim($_POST["pages"]);
      //  $pages = filter_var(trim($pages), FILTER_SANITIZE_STRING);

    

    
 
  $filearray = array();
  if ( !empty( $_FILES['custom_file']['tmp_name'] ) and $_FILES['custom_file']['error'] == 0 ) {
   $filepath = $_FILES['custom_file']['tmp_name'];
   $filename = $_FILES['custom_file']['name'];
  } else {
    $filepath = '';
    $filename = '';
  }
  

                    $body = "Имя: $name\n";
                    $body .= "Номер телефона: $phone\n";
                    $body .= "E-mail: $work_email\n";
                    
                    
                    $body .= "Вид работы: $subjects\n";
                    
                   
                    $body .= "Объем работы, стр: $pages\n";
                    $email = 'writerworks.com.ua';
 
  
if (send_mail($to, $body, $email, $filepath, $filename, $subjects)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Спасибо за отзыв! Мы вам скоро ответим";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Упс! Что-то пошло не так, попытайтесь отправить форму еще раз";
        }
} else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Возникла проблема с отправкой письма, пожалуйста попытайтесь снова.";
    }




// Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($to, $body, $email, $filepath, $filename ,$subjects)
{
  //$subject = 'Тестирование формы с прикреплением файла с сайта proverstka.com.ua';
  $boundary = "--".md5(uniqid(time())); // генерируем разделитель
  $headers = "From: ".$email."\r\n";   
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
  $multipart = "--".$boundary."\r\n";
  $multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";
  $multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

  $body = $body."\r\n\r\n";
 
  $multipart .= $body;
 
  $file = '';
  if ( !empty( $filepath ) ) {
    $fp = fopen($filepath, "r");
    if ( $fp ) {
      $content = fread($fp, filesize($filepath));
      fclose($fp);
      $file .= "--".$boundary."\r\n";
      $file .= "Content-Type: application/octet-stream\r\n";
      $file .= "Content-Transfer-Encoding: base64\r\n";
      $file .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
      $file .= chunk_split(base64_encode($content))."\r\n";
    }
  }
  $multipart .= $file."--".$boundary."--\r\n";
  
  if(mail($to, $subject, $multipart, $headers)){
     return true; 
  }else{
      return false;
  }
 
}
?>