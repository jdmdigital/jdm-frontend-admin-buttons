<?php
// If Visual Composer Plugin is active, return the edit front-page link.
if(!function_exists('jdm_edit_with_vc')) {
	function jdm_edit_with_vc(){
		global $page, $post;
		$id = $post->ID;
		$adminURL = admin_url();
		if(is_page()) {
			$type = 'page';
			$vc = true;
		}
		else {
			$vc = false;
		}
		
		$vcEditlink = $adminURL.'post.php?vc_action=vc_inline&amp;post_id='.$id.'&amp;post_type='.$type;
		
		if($vc) {
			return '<a href="'.$vcEditlink.'" class="btn btn-block btn-primary"><span class="glyphicon glyphicon glyphicon-fullscreen"></span> Visual Editor</a>';
		}
		
	}
}
?>