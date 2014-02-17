<?php

class Comparison {
	/* @var modX $modx */
	public $modx;
	public $initialized = array();


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('comparison_core_path', $config, $this->modx->getOption('core_path') . 'components/comparison/');
		$assetsUrl = $this->modx->getOption('comparison_assets_url', $config, $this->modx->getOption('assets_url') . 'components/comparison/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/',

			'frontend_css' => $this->modx->getOption('comparison_frontend_css', null, '[[+assetsUrl]]css/default.css'),
			'frontend_js' => $this->modx->getOption('comparison_frontend_js', null, '[[+assetsUrl]]js/default.js'),
		), $config);

		//$this->modx->addPackage('comparison', $this->config['modelPath']);
		$this->modx->lexicon->load('comparison:default');
	}


	/**
	 * Initializes AjaxForm into different contexts.
	 *
	 * @param string $ctx The context to load. Defaults to web.
	 * @param array $scriptProperties array with additional parameters
	 *
	 * @return boolean
	 */
	public function initialize($ctx = 'web', $scriptProperties = array()) {
		$this->config = array_merge($this->config, $scriptProperties);
		$this->config['ctx'] = $ctx;
		if (!empty($this->initialized[$ctx])) {
			return true;
		}
		switch ($ctx) {
			case 'mgr': break;
			default:
				if (!defined('MODX_API_MODE') || !MODX_API_MODE) {
					if ($css = trim($this->config['frontend_css'])) {
						if (preg_match('/\.css/i', $css)) {
							$this->modx->regClientCSS(str_replace('[[+assetsUrl]]', $this->config['assetsUrl'], $css));
						}
					}
					if ($js = trim($this->config['frontend_js'])) {
						if (preg_match('/\.js/i', $js)) {
							$this->modx->regClientScript(preg_replace(array('/^\n/', '/\t{7}/'), '', '
								<script type="text/javascript">
									if(typeof jQuery == "undefined") {
										document.write("<script src=\"'.$this->config['assetsUrl'].'js/lib/jquery.min.js\" type=\"text/javascript\"><\/script>");
									}
								</script>
							'), true);
							$this->modx->regClientScript(str_replace('[[+assetsUrl]]', $this->config['assetsUrl'], $js));
						}
					}
				}
				$this->initialized[$ctx] = true;
				break;
		}
		return true;
	}

}