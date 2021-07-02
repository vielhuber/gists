<?php
function mail_send($recipient, $subject, $content_text = null, $content_html = null, $attachment = null) {

	// if both plain and html is not available
	if( ($content_text === null || $content_text == "") && ($content_html === null || $content_html == "") ) { return false; }
	
	// if html version is not provided, use plain text version
	if( $content_html === null || $content_html == "" ) { $content_html = $content_text; }
	
	// if plain version is not provided, use html version
	if( $content_text === null || $content_text == "" ) { $content_text = strip_tags( str_replace( array( '<br>', '<br/>', '<br />' ), "\r\n", $content_html ) ); }

	// load the awesome phpmailer
	require_once($_SERVER['DOCUMENT_ROOT'].'/plugins/phpmailer/PHPMailerAutoload.php');
	
	// the e-mail is sent via ssl
	$mail = new PHPMailer;	
	$mail->IsSMTP();
	$mail->Host = "sslout.df.eu";
	$mail->Port = 465;
	$mail->Username = 'smtp@vielhuber.de';
	$mail->Password = 'XXX';
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	// with php 5.6 this is necessary for some providers
	// disclaimer: also use the newest version of phpmailer(!)
	$mail->SMTPOptions = array('tls' => array('verify_peer' => false,"verify_peer_name"=>false,"allow_self_signed"=>true), 'ssl' => array('verify_peer' => false,"verify_peer_name"=>false,"allow_self_signed"=>true));
	//$mail->SMTPDebug  = 2;

	// settings
	$mail->CharSet = 'utf-8'; 	
	$mail->SetFrom('your@email.com', "Your name");
	$mail->IsHTML(true);
			
	// set recipients
	foreach($recipient as $r) {
		if( isset($r["email"]) && $r["email"] != "" && isset($r["name"]) && $r["name"] != "" ) {
	   		$mail->AddAddress($r["email"],$r["name"]);
		}
	}
	//$mail->AddBCC("david@vielhuber.de", "David Vielhuber");
	
	// set subject
	$mail->Subject = $subject;
	
	// load template for html_version
	$content_html_template = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/email.html');
	
	// insert logo
	$content_html_template = str_replace("%EMAIL_LOGO%",'<img width="250" src="cid:logo" alt="" />',$content_html_template);
	$mail->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/images/logo/logo.png','logo');
		
	// insert text
	$content_html_template = str_replace("%EMAIL_SUBJECT%",$subject,$content_html_template);
	$content_html_template = str_replace("%EMAIL_BODY%",$content_html,$content_html_template);
	
	// embed images
	$images = array(); preg_match_all( '/src="([^"]*)"/i', $content_html_template, $images ); $images = $images[1]; $images = array_unique($images);
	foreach($images as $i) {
		if( strpos($i, "http") === false && strpos($i, "cid:") === false ) {
			$content_html_template = str_replace($i, "cid:".$i, $content_html_template);
			$mail->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/email/'.$i, $i);	
		}
	}
	
	// style links
  $needle = "<a ";
  $last_pos = 0;
  $positions = array();
  while(($last_pos = strpos($content_html_template, $needle, $last_pos)) !== false) {
      $positions[] = $last_pos;
      $last_pos = $last_pos + strlen($needle);
  }
  if(!empty($positions)) {
      foreach($positions as $key=>&$bpos) {
          $lpos = strrpos($content_html_template,'</a>',$bpos)+strlen('</a>');
          // verify this is a link
          if(
              strpos($content_html_template,' href',$bpos) !== false && strpos($content_html_template,' href',$bpos) > $bpos && strpos($content_html_template,' href',$bpos) < $lpos
          ) {
              // if this link has a special class, use a completely different markup
              if(
                 strpos($content,'big-link',$bpos) !== false && strpos($content,'big-link',$bpos) > $bpos && strpos($content,'big-link',$bpos) < $lpos
              ) {
                  $href_begin = (strpos($content,'href="',$bpos)+strlen('href="'));
                  $href = substr($content,$href_begin,strpos($content,'"',$href_begin)-$href_begin);
                  $linktext_begin = (strpos($content,'>',$bpos)+strlen('>'));
                  $linktext = substr($content,$linktext_begin,strpos($content,'</a>',$linktext_begin)-$linktext_begin);
                  $new_link = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="-webkit-border-radius: 15px; -moz-border-radius: 15px; border-radius: 15px;" bgcolor="#ff7900"><a href="'.$href.'" style="font-size: 21px; color: #ffffff; text-decoration: none; color: #ffffff; font-weight:bold; text-transform:uppercase; text-decoration: none; -webkit-border-radius: 15px; -moz-border-radius: 15px; border-radius: 15px; padding: 12px 18px; border: 1px solid #ff7900; display: inline-block;font-family: Arial, sans-serif;">'.$linktext.'</a></td></tr></table></td></tr></table>';
                  $content = substr($content, 0, $bpos).''.$new_link.''.substr($content, $lpos);
                  $shift = $lpos-$bpos+strlen($new_link);
              }

              // default style
              else {
                  $style = 'color:#ff7900;';
                  // if style tag already exists
                  if(
                      strpos($content,'style="',$bpos) !== false && strpos($content,'style="',$bpos) > $bpos && strpos($content,'style="',$bpos) < $lpos
                  ) {
                      $npos = strpos($content,'style="',$bpos)+strlen('style="');
                      $content = substr($content, 0, $npos).''.$style.''.substr($content, $npos);
                      $shift = strlen(''.$style.'');
                  }
                  else {
                      $npos = strpos($content,' href',$bpos);
                      $content = substr($content, 0, $npos).' style="'.$style.'"'.substr($content, $npos);
                      $shift = strlen(' style="'.$style.'"');
                  }
              }

              // shift all further positions
              for($i = $key+1; $i < count($positions); $i++) {
                  $positions[$i] = $positions[$i]+$shift;
              }
          }
      }
  }

	// set body
	$mail->Body = $content_html_template;
		
	// plain text version
	$content_text_template = "";
	$content_text_template .= $content_text;
	$content_text_template .= "\n";
	$mail->AltBody = $content_text_template;
	
	// attachments
	if( $attachment !== null && !empty($attachment) ) {
		foreach($attachment as $a) {
			if( file_exists($a["path"]) && $a["name"] != "" ) {
				$mail->AddAttachment( $a["path"], $a["name"] );		
			}			
		}
	}
	
	// send mail
	if(!$mail->Send()) {
	  echo "Mailer Error: ".$mail->ErrorInfo;
	  return false;
	}	
	return true;
	
}