<?php
	// Returns comment count
	function countcomments_mode(&$object) {
		global $modx;
		$view = ($object->isModerator) ? $object->config["moderation"]["view"] : 1;
		$output = $object->provider->GetCommentCount($object->config["docids"],$object->config["tagids"],$view,$object->config["userids"]);
		$object->config["html"]["count-comments"] = $output;
		if ($object->config["output"]) return $output;
	}
?>
