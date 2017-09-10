<?php
/**
* 邮件服务类
*/
class Mail extends \PHPMailer
{
	function __construct()
	{
		date_default_timezone_set('PRC');

		$this->CharSet = config('mail.charset');
		$this->isSMTP();
		$this->SMTPDebug = config('mail.smtp_debug');
		$this->Debugoutput = config('mail.debug_output');
		$this->Host = config('mail.host');
		$this->Port = config('mail.port');
		$this->SMTPAuth = config('mail.smtp_auth');
		$this->SMTPSecure = config('mail.smtp_secure');
		$this->Username = config('mail.username');
		$this->Password = config('mail.password');
		$this->setFrom(config('mail.from'), config('mail.from_name'));
		$this->addReplyTo(config('mail.reply_to'), config('mail.reply_to_name'));
	}

	/**
	 * 发送邮件
	 * @param  [type] $toMail      收件人地址
	 * @param  [type] $toName      收件人名称
	 * @param  [type] $subject     邮件主题
	 * @param  [type] $content     邮件内容，支持html
	 * @param  [type] $attachment  附件列表。文件路径或路径数组
	 * @return [type]              成功返回true，失败返回错误消息
	 */
	function sendMail($toMail, $toName, $subject, $content, $attachment = null)
	{
		$this->addAddress($toMail, $toName);
		$this->Subject = $subject;
		$this->msgHTML($content);
		
		if($attachment) { // 添加附件
			if(!is_array($attachment)){
				is_file($attachment) && $this->AddAttachment($attachment);
			}
			else{
				foreach ($attachment as $file) {
		            is_file($file) && $this->AddAttachment($file);
		        }
	        }       
	    }

		if(!$this->send()){ // 发送
		    return $this->ErrorInfo;
		}
		else{
		    return true;
		}
	}
}
