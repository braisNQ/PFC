<?php
	function aviso($color, $msg, $url, $btn)
	{
		echo '
			<div class="container">
			<div class="alert alert-'.$color.'" role="alert">'.$msg.'</div>
			<ul class="pager">
				<li><a href="'.$url.'">'.$btn.'</a></li>
			</ul>
			</div>
		';		
	}
?>