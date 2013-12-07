<?php
require_once('./config.php');

$parse = new Parse($templateFile);

if(isset($_REQUEST['query'])) {
	if(!empty($_REQUEST['query'])) {
		$flickr = new Flickr();
		if(!empty($_REQUEST['page'])) {
			$currentPage = intval($_REQUEST['page']);
			$photos = $flickr->search($_REQUEST['query'], $_REQUEST['page']);
		}else {
			$currentPage = 1;
			$photos = $flickr->search($_REQUEST['query']);
		}

		if(is_array($photos['photos']['photo']) && !empty($photos['photos']['photo'])) {
			$image = '<tr><td>
			<a href="http://localhost/flickr_php/search_flickr.php?query=' . urlencode($_REQUEST['query']) . '&page=' . $page = $currentPage-1 . '">Prev</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="http://localhost/flickr_php/search_flickr.php?query=' . urlencode($_REQUEST['query']) . '&page=' . $page = $currentPage+1 . '">Next</a>
			</td></tr>';
			foreach($photos['photos']['photo'] as $photo) {
				$image .= '<tr><td>' . $photo['title'] . '<br/><a href="http://www.flickr.com/photos/' . $photo["owner"] . '/' . $photo["id"] . '/" target="_blank" rel="nofollow"><img src="http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '_s.jpg"/></a></td></tr>';		
			}
			$parse->parseImageForeach(true, $image); 	
		}else {
			$error = 'There is no result coming back from Flickr. Please contact <a href="mailto:sudden308@gmail.com">Lu Chen</a>.';
			$parse->parseImageForeach(false, $error);
		}
	}else {
		$error = 'Please input the search key words. Thanks.';
		$parse->parseImageForeach(false, $error);
	}
}else {
	$parse->renderInitialPageWithoutImage();
}
?>


