<?php


class SkInstafeed extends KokenPlugin {

	function __construct($attributes) {
		// register hooks here
		$this->custom_folder = "custom";
		$this->resources_folder = "default";

		$this->require_setup = true;
		$this->register_hook('after_opening_body', 'prependInstafeedToContent');
		$this->register_hook('before_closing_body', 'appendInstafeedToContent');
		$this->register_hook('before_closing_body', 'includeUtilities');
	}

	function includeUtilities() {
		$instafeedPath = "js/instafeed.min.js";
		$output = '<script type="text/javascript" src="' . $this->buildURL($instafeedPath) . '"></script>';

		$cssPath = "css/instafeed.css";
		$output .= '<link rel="stylesheet" href="' . $this->buildURL($cssPath) . '" />';

		$output .= "<script type=\"text/javascript\">
			    var feed = new Instafeed({
			        get: 'user',
					userId: '" . $this->data->instagram_user_id . "',
			        clientId: '" . $this->data->instagram_client_id . "',
			        accessToken: '" . $this->data->instagram_token . "',
			        limit: '" . $this->data->instagram_limit . "',
			        target: 'sk-instafeed',
			        template: '<a href=\"{{link}}\" class=\"sk-instafeed__link\"><img src=\"{{image}}\" class=\"sk-instafeed__iamge\"/></a>'
			    });
			    feed.run();
			</script>";
		echo $output;
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
		echo "<div id=\"sk-instafeed\"></div>";
	}

	function buildURL($file) {
		// get customized version
		if (is_file($this->get_file_path() . DIRECTORY_SEPARATOR . $this->custom_folder . DIRECTORY_SEPARATOR . $file)) {
			return Koken::$location['real_root_folder'] . "/storage/plugins/" . $this->get_key() . "/" . $this->custom_folder . "/" . $file;
		}
		else {
			return Koken::$location['real_root_folder'] . "/storage/plugins/" . $this->get_key() . "/" . $this->resources_folder . "/" . $file;
		}
	}
}