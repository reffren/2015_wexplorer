<?php
  $title='Контакты';
  $description='Контактные данные по которым вы всегда можете связаться с мной';
  require_once('header.php'); 
  if(isset($_POST['message_button'])) {
    $name = mysqli_real_escape_string($dbc, trim($_POST ['name']));
	$email = mysqli_real_escape_string($dbc, trim($_POST ['email']));
    $theme = mysqli_real_escape_string($dbc, trim($_POST ['theme']));
    $message = mysqli_real_escape_string($dbc, trim($_POST ['message']));
        if(!empty($name)||!empty($email)||!empty($theme)||!empty($message)) {
        $query = "INSERT INTO messages (name, email, theme, messages, date) VALUES ('$name','$email','$theme','$message', NOW())";
        $result = mysqli_query($dbc, $query);
		$succes=2;
		    }  
			else {
		      $error=1;
			}
    }
?>
<div class="all">
  <div class="header">
  </div>
  <nav itemscope itemType="http://schema.org/SiteNavigationElement" class="navigation"> 
    <ul> 
      <li><a itemprop="url" href="http://wexplorer.ru"><span itemprop="name">Главная</span></a></li> 
      <li><a itemprop="url" href="http://wexplorer.ru/sitemap"><span itemprop="name">Список статей</span></a></li> 
	  <li><a itemprop="url" href="http://wexplorer.ru/ob-avtore"><span itemprop="name">Об авторе</span></a></li>
      <li><a itemprop="url" href="http://wexplorer.ru/contacts"><span itemprop="name">Контакты</span></a></li>
    </ul> 
  </nav> 
  <div class="content">
    <div itemscope itemtype="http://schema.org/PostalAddress" class="post">
	<h1 class="kontakty_h1">Контакты</h1>
	<p class="kontakty_p">Всем привет! По всем возникащим вопросам вы можете связаться со мной:</p><br>
<p>&rarr; <span itemprop="name">Тимур Казанский</span><br>
&rarr; <span itemprop="addressLocality">г. Казань</span><br>
&rarr; Индекс: <span itemprop="postalCode">420094</span><br>
&rarr; <span itemprop="streetAddress">ул. Маршала Чуйкова, 2</span><br>
&rarr; Тел.: <span itemprop="telephone">+79376254668</span><br>
&rarr; E-mail: <span itemprop="email">emailtotimur@gmail.com</span></p><br>
      <div class="commentaries">
		<div class="comment_div_h3">
		  <h3 class="comment_h3"><? if($error==1) { echo 'Вы не заполнили поля помеченные *'; } else { if($error==2) { echo 'Ваше сообщение отправлено, спасибо!'; } else { echo 'Или напишите мне прямо сейчас:'; }} ?></h3>
		</div>
	    <form action="http://wexplorer.ru/contacts" method="post">
	      <div class="com_general">
	        <input type="text" name="name"  placeholder="Ваше Имя *" id="name" value="" tabindex="1"><br>
		    <input type="text" name="email" placeholder="Ваш E-mail *" id="email" value="" tabindex="2"><br>
		    <input type="text" name="theme" placeholder="Тема *" id="theme" value="" tabindex="3"><br>
		  </div>
		  <div class="comment"><textarea name="message" placeholder="Введите текст сообщения *" id="message" tabindex="4"></textarea></div>
		  <div><input type="submit" value="Отправить" name="message_button" class="comment_button" /></div>
        </form>
	  </div>
	</div>
<?php   
  include("sidebar.php");
  include("footer.php");
?>