<?php
class App_Controller extends PHPMailer
{
    // redirects to any page
    public function redirect_to($addr="")
    {
        $wwwroot = WWWROOT;
        header("location:$wwwroot/$addr");
    }

    public function paginate($data, $page=0, $factor=10)
    {
        // mounts the pagination numbers
        $total = count($data);
        $pages = round($total/$factor);
        if (round($total/$factor) < ($total/$factor)) $pages++;
        $regex = "/&page=([0-9]{1,3})/";
        $qstr = preg_replace($regex, '', $_SERVER['QUERY_STRING']);
        $paginator = '<div class="pagination pagination-centered"><ul>';
        $paginator .= '<li><a href="?'.$qstr.'&page=1">Primeiro</a></li>';
        if ($pages > 1) 
            $paginator .= '<li><a href="?'.$qstr.'&page='.($page-1).'">Anterior</a></li>';
        else
            $paginator .= '<li class="active"><a href="?'.$qstr.'&page='.($page).'">&laquo;</a></li>';
        $start = 1;
        $max = $pages;
        if ($pages > 5)
        {
            $start = $page;
            $max = $start + 5;
        }
        for ($i=$start;$i<=$max;$i++)
        {
            $active = $page == $i ? ' class="active"' : '';
            $paginator .= '<li'.$active.'><a href="?'.$qstr.'&page='.$i.'">'.$i.'</a></li>';
            if ($i==$pages)break;
        }
        if ($pages > 1) 
            $paginator .= '<li><a href="?'.$qstr.'&page='.($page+1).'">Próximo</a></li>';
        else
            $paginator .= '<li class="active"><a href="?'.$qstr.'&page='.($page).'">&raquo;</a></li>';
        $paginator .= '<li><a href="?'.$qstr.'&page='.$pages.'">Último</a></li>';
        $paginator .= '</ul></div>';
        // paginates the array
        if (!$page || $page == 1)
        {
            $offset = 0;
        }
        else
        {
            $multiply = (int)$page - 1;
            $offset = $factor * $multiply;
        }
        return array(
            'query' => array_slice($data, $offset, $factor),
            'paginator' => $paginator
        );
    }
    // sends general emails
    function send_email($body, $to, $full_name, $title)
    {
        $mail             = new PHPMailer();
        
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = "smtp.guidepipe.com"; // SMTP server
        $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                                   // 1 = errors and messages
                                                   // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
        $mail->Username   = "guidepipe@guidepipe.com"; // SMTP account username
        $mail->Password   = "Selva44";        // SMTP account password
        
        $mail->SetFrom('guidepipe@guidepipe.com', 'Guidepipe');
        
        $mail->AddReplyTo("noreply@guidepipe.com", "No Reply");
        
        $mail->Subject    = $title;
        
        $mail->MsgHTML($body);
        
        $mail->AddAddress($to, $full_name);
        
        if(!$mail->Send()) 
        {
            return "Mailer Error: " . $mail->ErrorInfo;
        } 
        else 
        {
            return "Message sent!";
        }
    }
    
    // sends authentication email to user
    function send_auth_email($obj, $addr=FALSE)
    {
        if (is_object($obj))
        {
            $body = file_get_contents(WWWROOT."/users/auth?id=".$obj->id);
            $body = eregi_replace("[\]",'',$body);
            return $this->send_email($body, $obj->user_email, $obj->user_full_name, "Please activate your account");
        }
        return false;
    }
}
?>