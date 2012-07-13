<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['juiceSliderStart'] 	= '{type_legend},type;{juiceSliderLegend},juiceSliderSize,juiceSliderClosedWidth,juiceSliderInitialExpanded,juiceSliderDuration,juiceSliderTransition;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['juiceSliderEnd'] 		= '{type_legend},type';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['juiceSliderDuration'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['juiceSliderDuration'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => '1000',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit','tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_content']['fields']['juiceSliderClosedWidth'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['juiceSliderClosedWidth'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => '50',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit','tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_content']['fields']['juiceSliderSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['juiceSliderSize'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => serialize(array('400','200')),
	'eval'                    => array('mandatory'=>true,'tl_class'=>'w50','size'=>2,'multiple'=>true)
);
$GLOBALS['TL_DCA']['tl_content']['fields']['juiceSliderTransition'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['juiceSliderTransition'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'				  => 'quad',
	'options'				  => array('linear'=>'linear','quad:in:out'=>'quad:in:out','cubic:in:out'=>'cubic:in:out','quart:in:out'=>'quart:in:out','quint:in:out'=>'quint:in:out',
									   'expo:in:out'=>'expo:in:out','circ:in:out'=>'circ:in:out','sine:in:out'=>'sine:in:out','back:in:out'=>'back:in:out','bounce:in:out'=>'bounce:in:out','elastic:in:out'=>'elastic:in:out'),
	'eval'                    => array('mandatory'=>true,'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_content']['fields']['juiceSliderInitialExpanded'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['juiceSliderInitialExpanded'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => '-1',
	'eval'                    => array('mandatory'=>true,'tl_class'=>'w50')
);

// callback to generate endelement automatically
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('tl_content_juiceSlider','insertElem');
$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = array('tl_content_juiceSlider','deleteElem');



class tl_content_juiceSlider extends System
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}


	/**
	 * Insert the start/end-element if a element is created
	 */
	public function insertElem($dc)
	{
		// only for juiceSlider elements
		if($dc->activeRecord->type != 'juiceSliderStart' && $dc->activeRecord->type != 'juiceSliderEnd') return;

		// only if theres no related element
		if($dc->activeRecord->juiceSliderRelatedCE != 0) return;


		if($dc->activeRecord->type == 'juiceSliderStart')
		{
			$arrSet = array
			(
				'pid' 		=> $dc->activeRecord->pid,
				'type'		=> 'juiceSliderEnd',
				'tstamp' 	=> time(),
				'sorting' 	=> $dc->activeRecord->sorting+1,
				'juiceSliderRelatedCE' => $dc->id
			);
		}
		else
		{
			$arrSet = array
			(
				'pid' 						=> $dc->activeRecord->pid,
				'type'						=> 'juiceSliderStart',
				'tstamp' 					=> time(),
				'sorting' 					=> $dc->activeRecord->sorting-1,
				'juiceSliderDuration' 		=> 1000,
				'juiceSliderSize'			=> serialize(array('400','200')),
				'juiceSliderTransition'		=> 'quad:in:out',
				'juiceSliderClosedWidth'	=> 50,
				'juiceSliderRelatedCE' 		=> $dc->id
			);
		}

		if(in_array('GlobalContentelements',$this->Config->getActiveModules()))
        {
		     $arrSet['do'] = $this->Input->get('do');
        }

		// create element
		$objErg = $this->Database->prepare('INSERT INTO tl_content %s')
						->set($arrSet)->execute();



		$this->Database->prepare('UPDATE tl_content SET juiceSliderRelatedCE=? WHERE id=?')
					->execute($objErg->insertId,$dc->id);
	}


	/**
	 * Also delete the related start/end element
	 */
	public function deleteElem($dc)
	{
		// only for juiceSlider elements
		if($dc->activeRecord->type != 'juiceSliderStart' && $dc->activeRecord->type != 'juiceSliderEnd') return;

		if($dc->activeRecord->id > 0)
		{
			$this->Database->prepare('DELETE FROM tl_content WHERE pid=? AND juiceSliderRelatedCE=? LIMIT 1')
					->execute($dc->activeRecord->pid,$dc->activeRecord->id);
		}
	}
}

