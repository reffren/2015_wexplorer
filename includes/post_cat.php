<?php
  require_once('header.php');
    if($_GET['categon']) {
      $cat=$_GET['categon'];
    }
  $cur_page=isset($_GET['page']) ? $_GET['page'] : 1;
  $dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  mysqli_query($dbc,"SET NAMES 'utf8'");
    if($id) { //for post
      $query="SELECT *,DATE_FORMAT(post_date,'%Y-%m-%d %H:%i') as post_date FROM posts INNER JOIN categories USING (category_ID) WHERE post_file_name='$id'"; 
    }   else {  //for posts of category and pages
          $query_choose="SELECT *,DATE_FORMAT(post_date,'%Y-%m-%d %H:%i') as post_date FROM posts INNER JOIN categories USING (category_ID) WHERE category_ID='$cat'";
          $result_choose=mysqli_query($dbc, $query_choose);
          $results_per_page = 10;
          $skip=(($cur_page-1)*$results_per_page);
          $total=mysqli_num_rows($result_choose);
          $num_pages=ceil($total/$results_per_page);
          $query="SELECT *,DATE_FORMAT(post_date,'%Y-%m-%d %H:%i') as post_date FROM posts INNER JOIN categories USING (category_ID) WHERE category_ID='$cat' ORDER BY posts.post_ID DESC LIMIT $skip, $results_per_page";
		}
  $data=mysqli_query($dbc, $query);
  $num_rows = mysqli_num_rows($data);
  if($id) {
    $row=mysqli_fetch_array($data);
    $time = $row['post_date'];
    $post_id=$row['post_ID'];
  }
    if(isset($_POST['comment_button'])) {
      $name = mysqli_real_escape_string($dbc, trim($_POST ['name']));
	  $email = mysqli_real_escape_string($dbc, trim($_POST ['email']));
      $site_one = mysqli_real_escape_string($dbc, trim($_POST ['site']));
      $comment_one = mysqli_real_escape_string($dbc, trim($_POST ['comment']));
      $site=str_replace('http://','',$site_one);
	  $comment_two=str_replace('http://','_',$comment_one);
	  $comment=str_replace('www','_',$comment_two);
        if(!empty($name)) {
			if(!empty($comment)) {
        $query = "INSERT INTO commentaries (post_ID, name, site, email, comment, comment_date) VALUES ('$post_id','$name','$site','$email','$comment', NOW())";
        $result = mysqli_query($dbc, $query);
            }
		      else {
		        $error=2;
		      }
		    }  
			else {
		      $error=1;
			}
    }
	// there is it get comments
  $query_comment="SELECT *,DATE_FORMAT(comment_date,'%Y-%m-%d %H:%i') as comment_date FROM commentaries WHERE post_ID='$post_id'";
  $data_comment=mysqli_query($dbc, $query_comment);
  $total_comments=mysqli_num_rows($data_comment);
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
  <div class="content"><?php //for post
  if($id) { ?> 
	<div itemscope itemtype="http://schema.org/BlogPosting" class = "post"> 
		<p>Автор: <span itemprop="author">Тимур Казанский</span><br></p>
		<span>Дата: <time itemprop="datePublished" class="post_date"><?php echo $time; ?></time></span>
        <h1 itemprop="headline" class="post_preview_h1"><?echo $row['post_title']?></h1>
        <article itemprop="articleBody"><?php echo $row['post_content']; ?></article>
		<p>Категория: <span itemprop="articleSection"><?php echo $row['category_name'] ?></span></p>
        <div class="best_post">
		  <h4 class="about_me">Читайте также - самые интересные истории обо мне</h4>
		  <div class="photo_best">
		     <a onclick="new_page('_travel/amsterdam-ulica-krasnyh-fonarey-griby')"><img src="http://wexplorer.ru/best-article/amsterdam.jpg" alt="Амстердам и я"></a><br>
		    <a onclick="new_page('_travel/amsterdam-ulica-krasnyh-fonarey-griby')">Амстердам, улица красных фонарей, грибы и что я видел</a>
		  </div>
		  <div class="photo_best">
		    <a onclick="new_page('_about/kak-ya-chut-ne-razbilsya-prigaya-s-parashyoutom')"><img src="http://wexplorer.ru/best-article/parashyut.jpg" alt="Прыжок с парашютом"></a><br>
		    <a onclick="new_page('_about/kak-ya-chut-ne-razbilsya-prigaya-s-parashyoutom')">Как я чуть не разбился прыгая с парашютом</a>
		  </div>
		  <div class="photo_best">
		    <a onclick="new_page('_about/moi-haski')"><img src="http://wexplorer.ru/best-article/husky.jpg" alt="Мои хаски"></a><br>
		    <a onclick="new_page('_about/moi-haski')">Мои хаски или вся правда об этой породе</a>
		  </div>
		  <div class="photo_best">
		   <a onclick="new_page('_about/motocikl-opasno-ili-net')"><img src="http://wexplorer.ru/best-article/motocikl.jpg" alt="Мотоцикл"></a><br>
		    <a onclick="new_page('_about/motocikl-opasno-ili-net')">Мотоцикл опасно или нет, мой опыт</a>
		  </div>
		  <div class="photo_best">
		    <a onclick="new_page('_travel/3-samyh-beshenyh-attrakciona-evropy')"><img src="http://wexplorer.ru/best-article/amerikanskie-gorki.jpg" alt="Американские горки"></a><br>
		    <a onclick="new_page('_travel/3-samyh-beshenyh-attrakciona-evropy')">3 самых бешеных аттракциона Европы</a>
		  </div>  
		</div>
		<div class="commentaries">
		<div class="comment_div_h3">
		  <h3 class="comment_h3">Оставьте ваш комментарий</h3>
		</div>
		  <form action="http://wexplorer.ru/<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>" method="post">
		    <div class="com_general">
			  <input type="text" name="name" <? if($error==1) echo 'placeholder="Вы не указали Имя"'; else echo 'placeholder="Ваше Имя *"'; ?> id="name" value="" tabindex="1"><br>
		      <input type="text" name="site" placeholder="Сайт (необязательно)" id="site" value="" tabindex="3"><br>
			  <input type="text" name="email" placeholder="Ваш Email *" id="email" value="" tabindex="3"><br>
			</div>
		    <div class="comment"><textarea name="comment"  <? if($error==1) echo 'placeholder="Вы не ввели текст комментария"'; else echo 'placeholder="Введите текст комментария"'; ?> id="comment" tabindex="4"></textarea></div>
		    <div><input type="submit" value="Оставить комментарий" name="comment_butto" class="comment_button" /></div>
		  </form>
		  <div class="all_comments" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
		  <?php if($total_comments) { ?> <h4 class="comment_h4">Комментарии (<?php echo $total_comments; ?>)</h4> <?php } ?>
		  <?php while($row_comment=mysqli_fetch_array($data_comment)) { ?>
		    <div class="comment_img"><img src="<?php echo get_gravatar($row_comment['email']); ?>"></div>
		    <div class="comment_div">
		      <p id="comment_name" itemprop="creator"><a onclick="clean('_<?php echo $row_comment['site']; ?>')" target="_blank"><?php echo $row_comment['name']; ?></a></p>
		      <p id="comment_p" itemprop="commentText"><?php echo $row_comment['comment']; ?></p>
		      <time class="comment_time" itemprop="commentTime"> <?php echo $row_comment['comment_date']; ?></time>
		    </div>
		    <?php } ?>
		  </div>
		</div>
		<?php  }   else { ?>
    <div itemscope itemtype="http://schema.org/Blog" class = "posts">	
<?php	
        for($i=$num_rows; $i>0; $i--) {
		  $row=mysqli_fetch_array($data);
          $time = $row['post_date'];
          $cut=mb_substr($row['post_content'], 0, 300, 'UTF-8');
          $preview = strip_tags($cut); //function delete all tegs of html
?>
        <article itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
        <h2 itemprop="name" class="posts_preview_h1"><a onclick="new_page('_<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>')" class="post_preview_a"><?echo $row['post_title']?></a></h2>
        <p class="posts_date">Дата:<time itemprop="datePublished"><?php echo $time; ?></time></p>
<?php
    if($row['post_picture']) {
        echo '<p class="preview_img"><img src="http://wexplorer.ru/photo_for_preview/'.$row['post_picture'].'" itemprop="image" alt="изображение статьи '.$row['post_title'].'"></p>';
	}
        echo '<p itemprop="description" class="post_preview">'.$preview.'...</p>';
		$category_file_name=$row['category_file_name'];
?>     
        <p class="category">Категория: <a><?php echo $row['category_name'] ?></a></p>
        <a onclick="new_page('_<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>')" class="post_button">Читать полностью</a>
          </article>
<?php   } ?>
      <div class="pages">
<?php   if($num_pages>1) {
          echo generate_page_links_for_category($cur_page, $num_pages, $category_file_name);
        } ?>
      </div>
<?php } ?>
    </div> 
<?php   
  include("sidebar.php");
  include("footer.php");
?>