<?php
function redirect_404() {
	if($_GET['cat']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
		if($_GET['feed']&&$_GET['cat']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
	
			if($_GET['feed']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
				if($_GET['m']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
					if($_GET['page_id']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
					if($_GET['p']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
					if($_GET['author']) {
header("HTTP/1.0 404 Not Found");
include('404.php');
        die;
	}
}

function build_query($user_search) {
    $search_query = "SELECT *,DATE_FORMAT(post_date,'%Y-%m-%d %H:%i') as post_date FROM posts INNER JOIN categories USING (category_ID)";

    // Extract the search keywords into an array
    $clean_search = str_replace(',', ' ', $user_search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
      foreach ($search_words as $word) {
        if (!empty($word)) {
          $final_search_words[] = $word;
        }
      }
    }

    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
      foreach($final_search_words as $word) {
        $where_list[] = "post_content LIKE '%$word%'";
      }
    }
    $where_clause = implode(' OR ', $where_list);

    // Add the keyword WHERE clause to the search query
    if (!empty($where_clause)) {
      $search_query .= " WHERE $where_clause";
    }
    return $search_query;
  }
  
function generate_page_links($cur_page, $num_pages) {
    $page_links = '';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
	    if($cur_page==2) {
          $page_links .= ' <a onclick="new_page(\'_\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
	    }
		else {
      $page_links .= '<a onclick="new_page(\'_page' . ($cur_page - 1) .'\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
        }
	}
    else {
      $page_links .= ' <a class="page_button_none">&larr;</a>';
    }

    // Loop through the pages generating the page number links
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($cur_page == $i) {
        $page_links .= ' <a class="page_button_none">' . $i .'</a>';
      }
      else {
	    if($i==1) {
          $page_links .= '<a onclick="new_page(\'_\')" class="page_button"> ' . $i . '</a>';
		}
		else {
		  $page_links .= '<a onclick="new_page(\'_page' . $i .'\')" class="page_button"> ' . $i . '</a>';
        }
	  }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
      $page_links .= '<a onclick="new_page(\'_page' . ($cur_page + 1) .'\')" class="page_button" title="Следующая страница">&rarr;</a>';
    }
    else {
      $page_links .= ' <a class="page_button_none">&rarr;</a>';
    }

    return $page_links;
  }
  
function generate_page_links_for_category($cur_page, $num_pages, $category_file_name) {
    $page_links = '';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
	    if($cur_page==2) {
          $page_links .= ' <a onclick="new_page(\'_'.$category_file_name.'\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
	    }
		else {
      $page_links .= '<a onclick="new_page(\'_'.$category_file_name.'/page' . ($cur_page - 1) .'\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
        }
	}
    else {
      $page_links .= ' <a class="page_button_none">&larr;</a>';
    }

    // Loop through the pages generating the page number links
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($cur_page == $i) {
        $page_links .= ' <a class="page_button_none">' . $i .'</a>';
      }
      else {
	    if($i==1) {
          $page_links .= '<a onclick="new_page(\'_'.$category_file_name.'\')" class="page_button"> ' . $i . '</a>';
		}
		else {
		  $page_links .= '<a onclick="new_page(\'_'.$category_file_name.'/page' . $i .'\')" class="page_button"> ' . $i . '</a>';
        }
	  }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
      $page_links .= '<a onclick="new_page(\'_'.$category_file_name.'/page' . ($cur_page + 1) .'\')" class="page_button" title="Следующая страница">&rarr;</a>';
    }
    else {
      $page_links .= ' <a class="page_button_none">&rarr;</a>';
    }

    return $page_links;
  }
  
  function generate_page_links_for_search($cur_page, $num_pages, $user_search) {
    $page_links = '';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
	    if($cur_page==2) {
          $page_links .= ' <a onclick="new_page(\'_?s=' . $user_search .'\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
	    }
		else {
      $page_links .= '<a onclick="new_page(\'_page' . ($cur_page - 1) .'&s='. $user_search.'\')" class="page_button" title="Предыдущая страница">&larr;</a> ';
        }
	}
    else {
      $page_links .= ' <a class="page_button_none">&larr;</a>';
    }

    // Loop through the pages generating the page number links
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($cur_page == $i) {
        $page_links .= ' <a class="page_button_none">' . $i .'</a>';
      }
      else {
	    if($i==1) {
          $page_links .= '<a onclick="new_page(\'_?s='. $user_search .'\')" class="page_button"> ' . $i . '</a>';
		}
		else {
		  $page_links .= '<a onclick="new_page(\'_page' . $i .'&s='. $user_search.'\')" class="page_button"> ' . $i . '</a>';
        }
	  }
    }
    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
      $page_links .= '<a onclick="new_page(\'_page' . ($cur_page + 1) .'&s='. $user_search.'\')" class="page_button" title="Следующая страница">&rarr;</a>';
    }
    else {
      $page_links .= ' <a class="page_button_none">&rarr;</a>';
    }

    return $page_links;
  }
  
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
  $url = 'http://www.gravatar.com/avatar/';
  $url .= md5( strtolower( trim( $email ) ) );
  $url .= "?s=$s&d=$d&r=$r";
  if ( $img ) {
    $url = '<img src="' . $url . '"';
    foreach ( $atts as $key => $val )
      $url .= ' ' . $key . '="' . $val . '"';
      $url .= ' />';
  }
 return $url;
}
?>