<?php
extension_check(array( 
	'curl',
	'dom', 
	'gd', 
	'hash',
	'iconv',
	'mcrypt',
	'pcre', 
	'pdo', 
	'pdo_mysql', 
	'simplexml',
	'php-xmlrpc'
));

function extension_check($extensions) {
	$fail = '';
	$pass = '';
	
	if(version_compare(phpversion(), '5.4.0', '<')) {
		$fail .= '<li>Sie ben&ouml;tigen<strong> PHP 5.4.0</strong> (oder h&ouml;her)</li>';
	}
	else if(version_compare(phpversion(), '5.4.0', '<')) {
		$pass .='<li style="background:yellow">Sie haben<strong> '.phpversion().'</strong>. Magento funktioniert noch besser mit PHP 5.5 oder h&ouml;her</li>';
	} else {
		$pass .='<li>Sie haben<strong> '.phpversion().'</strong>. das ist PHP 5.5 oder h&ouml;her</li>';
	}

	if(!ini_get('safe_mode')) {
		$pass .='<li>Safe Mode ist <strong>aus</strong></li>';
		preg_match('/[0-9]\.[0-9]+\.[0-9]+/', shell_exec('mysql -V'), $version);
		
		if(version_compare($version[0], '5.6.0', '<')) {
			$fail .= '<li>Sie ben&ouml;tigen<strong> MySQL 5.6.0</strong> oder h&ouml;her</li>';
		}
		else {
			$pass .='<li>Sie haben<strong> '.$version[0].'</strong>, das ist MYSQL 5.6.0 oder h&ouml;her</li>';
		}
	}
	else { $fail .= '<li>Safe Mode ist <strong>an</strong></li>';  }

	foreach($extensions as $extension) {
		if(!extension_loaded($extension)) {
			$fail .= '<li> Sie ben&ouml;tigen die <strong>'.$extension.'</strong> Erweiterung</li>';
		}
		else{	$pass .= '<li>Sie haben die <strong>'.$extension.'</strong> Erweiterung</li>';
		}
	}
	
	if($fail) {
		echo '<p><strong>Ihr Server ist mit der jetzigen Konfiguration nicht kompatibel mit Magento.</strong>';
		echo '<br>Die folgenden Voraussetzungen wurden nicht erfullt:';
		echo '<ul style="background:red">'.$fail.'</ul></p>';
		echo 'Bitte Kontaktieren Sie Ihren Hosting Provider und bitten Ihn um Unterst&uuml;tzung. <br />Wenn Sie Ihren Server selbst verwalten oder Hilfe ben&ouml;tigen stehen wir ihnen gerne zur Seite: ';
		echo '<a target="_blank" href="https://www.maxanoo.com">www.maxanoo.com</a><br /><br /><br />';
		echo 'Die folgenden Voraussetzungen wurden erf&uuml;llt:<br />';
		echo '<ul>'.$pass.'</ul>';
	} else {
		echo '<p><strong>Herzlichen Gl&uuml;ckwunsch!</strong> Ihr Server ist korrekt f&uuml;r Magento konfiguriert. <a target="_blank" href="https://www.maxanoo.com">Maxanoo</a> w&uuml;nscht Ihnen viel Erfolg</p>';
		echo '<ul style="background:green">'.$pass.'</ul>';

	}
}
?>
