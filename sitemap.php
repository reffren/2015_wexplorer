<?php
  include("stuff/db.php");
    $dbc_index=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_query($dbc_time,"SET NAMES 'utf8'");
    $query_index="SELECT unix_timestamp(post_last_modified) as unix_date FROM posts ORDER BY post_ID DESC LIMIT 1";
    $data_index=mysqli_query($dbc_index, $query_index);
	$row_index=mysqli_fetch_array($data_index);
    $last_modified_time=$row_index['unix_date'];
  $title='Список статей';
  $description='Страница на которой вы найдете все статьи блога Тимура Казанского';
  require_once('header.php');
  $dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  mysqli_query($dbc,"SET NAMES 'utf8'");
  $query="SELECT * FROM posts INNER JOIN categories USING (category_ID) ORDER BY posts.category_ID DESC";
  $data=mysqli_query($dbc, $query);
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
    <div class = "sitemap">
	<h1 class="sitemap_h1">Список статей и уроков</h1>
<?php 
    $i='';
    while($row=mysqli_fetch_array($data)) { ?>
<?php if($i == $row['category_name']) { ?>
        <p itemprop="itemListElement" class="sitemap_p">&rarr; <a itemprop="url" href="<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>"><?echo $row['post_title']?></a></p>
		  <?php } else { if($i) { echo '</div>'; }?>
          <?php $i=$row['category_name']; ?>
		  <div itemscope itemType="http://schema.org/ItemList">
          <h3 itemprop="name" class="sitemap_h3"><?php echo $i; ?></h3>
          <p itemprop="itemListElement" class="sitemap_p">&rarr; <a itemprop="url" class="sitemap_a" href="<?php echo $row['category_file_name'].'/'.$row['post_file_name']?>"><?echo $row['post_title']?></a></p>
		  <?php   }
    } ?>
    </div> 
	</div>
<?php 
  include("sidebar.php");  
  include("footer.php");
?>