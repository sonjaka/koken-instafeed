<?php



class SkText extends KokenPlugin {

	function __construct($attributes) {
		// register hooks here
		$this->require_setup = true;
		$this->register_hook('after_opening_body', 'prependInstafeedToContent');
		$this->register_hook('before_closing_body', 'appendInstafeedToContent');
		$this->register_hook('before_closing_body', 'includeInstafeedLibrary');
	}

	function includeInstafeedLibrary() {
		echo "<script type=\"text/javascript\" src=\"storage/plugins/sk-instagram/resources/js/instafeed.min.js\"></script>
			<script type=\"text/javascript\">
			    var feed = new Instafeed({
			        get: 'user',
					userId: '" . $this->data->instagram_user_id . "',
			        clientId: '" . $this->data->instagram_client_id . "',
			        accessToken: '" . $this->data->instagram_token . "',
			        limit: '" . $this->data->instagram_limit . "',
			        template: '<a href=\"{{link}}\" class=\"sk-instafeed__link\"><img src=\"{{image}}\" class=\"sk-instafeed__iamge\"/></a>'
			    });
			    feed.run();
			</script>";
	}

	function prependInstafeedToContent() {
		if ($this->data->location == 'above') {
			$this->renderInstafeed($this->data);
		}
	}

	function appendInstafeedToContent() {
		if ($this->data->location == 'below') {
			$this->renderInstafeed($this->data);
		}
	}

	function renderInstafeed($settings) {
		echo "<div id=\"instafeed\"></div>";
	}
}