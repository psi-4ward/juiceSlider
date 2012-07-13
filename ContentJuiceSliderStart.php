<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');



class ContentJuiceSliderStart extends ContentElement
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_juiceslider_start';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### JuiceSlider START ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Generate content element
	 */
	protected function compile()
	{
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/juiceSlider/html/juiceSlider.js';
//		$GLOBALS['TL_CSS'][] = 'system/modules/juiceSlider/html/juiceSlider.css';

		// set width/height style
		$this->juiceSliderSize = deserialize($this->juiceSliderSize);
		$this->arrStyle[] = "height:{$this->juiceSliderSize[1]}px;";
		$this->arrStyle[] = "width:{$this->juiceSliderSize[0]}px;";

		// forceID
		if($this->cssID[0] == '')
		{
			$this->cssID = array('juiceSlider'.$this->id);
		}
		$this->Template->containerID = $this->cssID[0];
	}
}

