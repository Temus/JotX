<?php
function rating(&$object,$params){
	global $modx;
	
	$tbl = $modx->db->config["table_prefix"]."jot_rating";
	switch($object->event) {
		case "onFirstRun":
			$query = $modx->db->query("SHOW TABLES LIKE '".$tbl."'");
			$returnValue = $modx->db->getRecordCount($query);
			if ($returnValue==0) {
				$sql = "CREATE TABLE IF NOT EXISTS $tbl (
					`id` int(11) NOT NULL,
					`ua` char(32) NOT NULL,
					`value` tinyint(4) NOT NULL,
					UNIQUE KEY `id` (`id`,`ua`)
					) ENGINE=MyISAM;";
				$modx->db->query($sql);
				$modx->db->query('ALTER TABLE '.$object->tbl["content"].' ADD `rating` INT NOT NULL DEFAULT 0 AFTER `publishedby`');
			}
			if (isset($_GET['vote']) && isset($_GET['cid'])) {
				$vote = $_GET['vote']=='down' ? -1 : 1;
				$cid = intval($_GET['cid']);
				$modx->db->query('INSERT INTO '.$tbl.' (`id`, `ua`, `value`) VALUES ("'.$cid.'", "'.md5($_SERVER['HTTP_USER_AGENT']."_".getenv("REMOTE_ADDR")).'", "'.$vote.'") on duplicate key update id = id');
				$res = $modx->db->getValue($modx->db->select('SUM(value)', $tbl, "id=$cid"));
				$modx->db->update('rating = '.$res, $object->tbl["content"], "id=$cid");
				if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
					die($res);
				}
			}
			break;
		case "onReturnOutput":
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
				$modx->regClientStartupScript('<script type="text/javascript">window.jQuery || document.write(\'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"><\/script>\');</script>');
				$modx->regClientStartupScript(MODX_BASE_URL.'assets/snippets/jot/js/rating.js');
				$modx->regClientCSS(MODX_BASE_URL.'assets/snippets/jot/css/rating.css');
			}
			break;
	}
}
?>