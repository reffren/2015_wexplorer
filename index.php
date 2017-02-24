<?php
  include("stuff/db.php");
    $dbc_index=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_query($dbc_time,"SET NAMES 'utf8'");
    $query_index="SELECT unix_timestamp(post_last_modified) as unix_date FROM posts ORDER BY post_ID DESC LIMIT 1";
    $data_index=mysqli_query($dbc_index, $query_index);
	$row_index=mysqli_fetch_array($data_index);
    $last_modified_time=$row_index['unix_date'];
  $title='Блог Тимура Казанского';
  $description='Блог Тимура Казанского в котором он пишет о создании сайтов для начинающих, информационных технологиях, программировании, бизнесе, о себе и своих путешествиях';
  require_once('header.php');
  $cur_page=isset($_GET['page']) ? $_GET['page'] : 1;
  $user_search=$_GET['s'];
  $dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  mysqli_query($dbc,"SET NAMES 'utf8'");
  
  $results_per_page = 10;  // number of results per page
  $skip = (($cur_page - 1) * $results_per_page);
  
    if($user_search) {
      $user_search = mysqli_real_escape_string($dbc, trim($user_search));
      $query = build_query($user_search);
	  $data = mysqli_query($dbc, $query);
	  $total = mysqli_num_rows($data);
		if($total==0) {
		  $error_search='Ничего не найдено';
		}
      $num_pages = ceil($total / $results_per_page);
      // Query again to get just the subset of results
      $query =  $query . " LIMIT $skip, $results_per_page";
      $data = mysqli_query($dbc, $query);
    } else {  
        $query_choose="SELECT post_content FROM posts";
        $result=mysqli_query($dbc, $query_choose);
        $total=mysqli_num_rows($result);
        $num_pages=ceil($total/$results_per_page);
        mysqli_query($dbc,"SET NAMES 'utf8'");
        $query="SELECT *,DATE_FORMAT(post_date,'%Y-%m-%d %H:%i') as post_date FROM posts INNER JOIN categories USING (category_ID) ORDER BY posts.post_ID DESC LIMIT $skip, $results_per_page";
        $data=mysqli_query($dbc, $query);
    }
	if($total) {
  $num_rows = mysqli_num_rows($data);
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
    <div itemscope itemtype="http://schema.org/Blog" class = "posts">
<?php
  if($error_search) { echo '<h2 class="posts_preview_h1">'.$error_search.'</h2>';
    echo '<p class="post_preview">Извините, но к сожалению по вашему запросу, ничего не найдено.</p>';  } 
  for($i=$num_rows; $i>0; $i--) {
    $row=mysqli_fetch_array($data);
    $time = $row['post_date'];	
    $cut=mb_substr($row['post_content'], 0, 300, 'UTF-8');
    $preview = strip_tags($cut); //function delete all tegs of html
?>
        <article itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
      <h2 itemprop="name" class="posts_preview_h1"><a itemprop="url" href="http://wexplorer.ru/<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>" class="post_preview_a"><?echo $row['post_title']?></a></h2> 
	  <p class="posts_date">Дата:<time itemprop="datePublished"><?php echo $time; ?></time></p>
<?php
    if($row['post_picture']) {
        echo '<p class="preview_img"><img src="http://wexplorer.ru/photo_for_preview/'.$row['post_picture'].'" itemprop="image" alt="изображение статьи '.$row['post_title'].'"></p>';
	}
        echo '<p itemprop="description" class="post_preview">'.$preview.'...</p>';
?>
        <p class="category">Категория: <a onclick="new_page('_<?php echo $row['category_file_name']?>')"><? echo $row['category_name'] ?></a></p>
        <a onclick="new_page('_<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>')" class="post_button">Читать полностью</a>
          </article>
<?php } ?>
      <div class="pages">
<?php if($num_pages>1) {
        if($user_search) {
		  echo generate_page_links_for_search($cur_page, $num_pages, $user_search);
		} else {
            echo generate_page_links($cur_page, $num_pages);
		  }			
      } ?>
      </div>
    </div> 
<?php  
  include("sidebar.php"); 
  include("footer.php");
?>