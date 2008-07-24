<?php

/**
 * Subclass for representing a row from the 'email' table.
 *
 * Originally from [ticketsf]
 *
 * @package lib.model
 */
class Email extends BaseEmail
{
	var $mailer;

	function initialise($name, $email) {
		$this->mailer = new mySfMail();
		$this->mailer->setOriginalEmail($this);
		$this->mailer->setCharset(sfConfig::get("app_mail_charset", "utf-8"));
		$this->mailer->setHostname(sfConfig::get("app_mail_hostname"));
		$this->mailer->setUsername(sfConfig::get("app_mail_username", ""));
		$this->mailer->setPassword(sfConfig::get("app_mail_password", ""));			// if necessary
		$this->mailer->setContentType("text/html");

		$this->setToName($name);
		$this->setToAddress($email);
		$this->mailer->addAddress($this->getToAddress(), $this->getToName());

		$this->setFromName(sfConfig::get("app_mail_from", "Fridex"));
		$this->setFromAddress(sfConfig::get("app_mail_address", "fridex@jevon.org"));
		$this->mailer->setFrom($this->getFromAddress(), $this->getFromName());
	}

	function initialiseUser(User $user) {
		$this->initialise($user->getName(), $user->getEmail());
		$this->setUser($user);
	}

	function setSubject($s) {
		$this->mailer->setSubject($s);
		parent::setSubject($s);
	}

	function getMailer() {
		return $this->mailer;
	}

	var $attachments = array();

	function addAttachment($content_type, $filename, $data) {
		// addStringAttachment($string, $filename, $encoding = 'base64', $type = 'application/octet-stream')
		$this->getMailer()->addStringAttachment($data, $filename, "base64", $content_type);
		$this->attachments[] = array("data" => $data, "filename" => $filename, "content_type" => $content_type);
	}

	function saveAttachments() {
		foreach ($this->attachments as $a) {
			$ea = new EmailAttachment();
			$ea->setEmail($this);
			$ea->setFilename($a["filename"]);
			$ea->setMediaType($a["content_type"]);
			$ea->setContent($a["data"]);
			$ea->save();
		}
	}

}

/** Helper class */
class mySfMail extends sfMail {
	var $original_email;

	function setOriginalEmail(Email $e) {
		$this->original_email = $e;
	}

	function send() {
		$this->original_email->setBody($this->getBody());
		$this->original_email->save();
		$this->original_email->saveAttachments();

		try {
			$output = parent::send();
			$this->original_email->setSentAt(time());
			$this->original_email->save();
			return $output;
		} catch (sfException $e) {
			// do nothing, we don't want things to crash
			sfContext::getInstance()->getLogger()->err("could not send e-mail: " + $e->getMessage());
		}
	}
}
