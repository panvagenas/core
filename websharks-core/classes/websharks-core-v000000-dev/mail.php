<?php
/**
 * Mail.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * Mail.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class mail extends framework
		{
			/**
			 * Sends email to a list of recipients.
			 *
			 * @param array $mail A mail configuration array.
			 *
			 *    Possible configuration elements include:
			 *
			 *     • `subject` (string, NOT empty).
			 *     • `message` (string, NOT empty).
			 *
			 *     • `from_addr` (string, NOT empty).
			 *     • `from_name` (string, optional from name).
			 *
			 *     • `recipients` (string|array, NOT empty).
			 *       Strings may contain multiple email addresses (comma or semicolon separated); which this routine parses into an array.
			 *       NOTE: Emails are ALWAYS sent ONE at a time; making the concept of CC/BCC addresses irrelevant.
			 *
			 *     • `attachments` (optional). An absolute file path, or an array of absolute file paths.
			 *       Or, this can also be an array of attachment configurations.
			 *          Possible attachment configuration elements include:
			 *             • `path` (absolute server path to a file, NOT empty).
			 *             • `name` (optional string name for this file, defaults to ``basename()``).
			 *             • `encoding` (optional string encoding type, defaults to `base64`).
			 *             • `mime_type` (optional string MIME type, defaults to `application/octet-stream`).
			 *
			 * @return boolean|errors TRUE if mail was sent successfully.
			 *    Else this returns an `errors` object instance.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If required configuration elements are missing and/or invalid.
			 *
			 * @assert $mail = array('subject' => 'Test Subject', 'message' => 'Test'."\n".'Message', 'from_addr' => get_bloginfo('admin_email'), 'from_name' => 'WebSharks™ Core', 'recipients' => get_bloginfo('admin_email'), 'attachments' => __FILE__);
			 *    ($mail) === TRUE
			 *
			 * @assert $mail = array('subject' => 'Test Subject', 'message' => 'Test'."\n".'Message', 'from_addr' => get_bloginfo('admin_email'), 'recipients' => get_bloginfo('admin_email'));
			 *    ($mail) === TRUE
			 */
			public function send($mail)
				{
					$this->check_arg_types('array:!empty', func_get_args());

					// Load PHPMailer classes (if NOT already loaded).

					if(!class_exists('PHPMailer'))
						require_once ABSPATH.WPINC.'/class-phpmailer.php';

					if(!class_exists('SMTP'))
						require_once ABSPATH.WPINC.'/class-smtp.php';

					$default_mail_args = array(
						'subject'     => '', // Required.
						'message'     => '', // Required.
						'from_addr'   => '', // Required.
						'recipients'  => '', // Required (string|array).
						'attachments' => '', // Optional (string|array).
						'from_name'   => '', // Optional from name.
					);
					$mail              = $this->check_extension_arg_types(
						'string:!empty', 'string:!empty', 'string:!empty', array('string:!empty', 'array:!empty'),
						array('string', 'array'), 'string', $default_mail_args, $mail, 4
					);

					// Recipients are always parsed into an array here.
					if(!($mail['recipients'] = $this->parse_emails_deep($mail['recipients'])))
						throw $this->©exception(
							__METHOD__.'#recipients_missing', compact('mail'),
							$this->i18n('Email failure. Missing and/or invalid `recipients` value.')
						);

					// Possible file attachment(s).
					if($this->©string->is_not_empty($mail['attachments']))
						$mail['attachments'] = array($mail['attachments']);
					$this->©array->isset_or($mail['attachments'], array(), TRUE);

					// Standardize/validate each attachment.
					foreach($mail['attachments'] as &$_attachment)
						{
							if(!is_array($_attachment))
								$_attachment = array('path' => $_attachment);

							if(!$this->©string->is_not_empty($_attachment['path']))
								throw $this->©exception(
									__METHOD__.'#attachment_path_missing', compact('mail', '_attachment'),
									$this->i18n('Email failure. Missing and/or invalid attachment `path` value.').
									sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($_attachment))
								);
							else if(!is_file($_attachment['path']))
								throw $this->©exception(
									__METHOD__.'#nonexistent_attachment_path', compact('mail', '_attachment'),
									$this->i18n('Email failure. Nonexistent attachment `path` value.').
									sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($_attachment))
								);
							// Other optional specifications.
							$this->©string->is_not_empty_or($_attachment['name'], '', TRUE);
							$this->©string->is_not_empty_or($_attachment['encoding'], 'base64', TRUE);
							$this->©string->is_not_empty_or($_attachment['mime_type'], 'application/octet-stream', TRUE);
						}
					unset($_attachment); // Just a little housekeeping.

					try // PHPMailer (catch exceptions).
						{
							$mailer = new \PHPMailer(TRUE);

							$mailer->SingleTo = TRUE;
							$mailer->CharSet  = 'UTF-8';
							$mailer->Subject  = $mail['subject'];

							if(strip_tags($mail['message']) === $mail['message'])
								$mail['message'] = nl2br($mail['message']);
							$mailer->MsgHTML($mail['message']);

							$mailer->SetFrom($mail['from_addr'], $mail['from_name']);

							foreach($mail['recipients'] as $_recipient_addr)
								$mailer->AddAddress($_recipient_addr);
							unset($_recipient_addr);

							foreach($mail['attachments'] as $_attachment)
								$mailer->AddAttachment(
									$_attachment['path'],
									$_attachment['name'],
									$_attachment['encoding'],
									$_attachment['mime_type']
								);
							unset($_attachment);

							if($this->©option->get('mail.smtp'))
								{
									$mailer->SMTPSecure = $this->©option->get('mail.smtp.secure');
									$mailer->Host       = $this->©option->get('mail.smtp.host');
									$mailer->Port       = (integer)$this->©option->get('mail.smtp.port');
									$mailer->SMTPAuth   = (boolean)$this->©option->get('mail.smtp.username');
									$mailer->Username   = $this->©option->get('mail.smtp.username');
									$mailer->Password   = $this->©option->get('mail.smtp.password');
								}
							$mailer->Send();
						}
					catch(\phpmailerException $exception)
						{
							return $this->©error(__METHOD__, get_defined_vars(), $exception->getMessage());
						}
					catch(\exception $exception)
						{
							return $this->©error(__METHOD__, get_defined_vars(), $exception->getMessage());
						}
					return TRUE; // Default return value.
				}

			/**
			 * Parses email addresses (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a string that may form an email address.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return array Array of parsed email addresses.
			 *
			 * @assert $string = 'Jason Caldwell <jason@example.com>';
			 *    ($string) === array('jason@example.com')
			 *
			 * @assert $string = 'Jason Caldwell <jason@example.com>, Jason Caldwell <jason@example.com>';
			 *    ($string) === array('jason@example.com')
			 *
			 * @assert $string = 'Jason Caldwell <jason1@example.com>, jason2@example.com';
			 *    ($string) === array('jason1@example.com', 'jason2@example.com')
			 *
			 * @assert $string = '<jason1@example.com>; Jason Caldwell <jason2@example.com> ; jason3@example.com';
			 *    ($string) === array('jason1@example.com', 'jason2@example.com', 'jason3@example.com')
			 *
			 * @assert $array = array('Jason Caldwell <jason1@example.com>; Jason Caldwell <jason2@example.com>');
			 *    ($array) === array('jason1@example.com', 'jason2@example.com')
			 *
			 * @assert $array = array('Jason Caldwell <jason1@example.com>', 'Jason Caldwell <jason2@example.com>');
			 *    ($array) === array('jason1@example.com', 'jason2@example.com')
			 *
			 * @assert $array = array('Jason Caldwell <jason1@example.com>; Jason Caldwell <jason2@example.com>', 'jason5@example.com; <jason3@example.com>');
			 *    ($array) === array('jason1@example.com', 'jason2@example.com', 'jason5@example.com', 'jason3@example.com')
			 */
			public function parse_emails_deep($value)
				{
					$emails = array(); // Initialize array.

					if(is_array($value) || is_object($value))
						{
							foreach($value as $_value)
								$emails = array_merge($emails, $this->parse_emails_deep($_value));
							unset($_value); // A little housekeeping.

							return $emails;
						}
					$value                       = strtolower((string)$value);
					$delimiter                   = (strpos($value, ';') !== FALSE) ? ';' : ',';
					$regex_delimitation_splitter = '/'.preg_quote($delimiter, '/').'+/';

					foreach($this->©strings->trim_deep(preg_split($regex_delimitation_splitter, $value)) as $_address)
						{
							if(preg_match('/\<(?P<email>.+?)\>/', $_address, $_m)
							   && strpos($_m['email'], '@') !== FALSE
							)
								$emails[] = ($_address = $_m['email']);

							else if(strpos($_address, '@') !== FALSE)
								$emails[] = $_address;
						}
					unset($_address, $_m); // Housekeeping.

					return array_unique($emails);
				}
		}
	}