CREATE TABLE `tl_content` (
  `juiceSliderDuration` int(7) NOT NULL default '0',
  `juiceSliderSize` varchar(255) NOT NULL default '',
  `juiceSliderClosedWidth` int(10) NOT NULL default '0',
  `juiceSliderTransition` varchar(15) NOT NULL default '',
  `juiceSliderDuration` int(10) NOT NULL default '500',
  `juiceSliderInitialExpanded` varchar(5) NOT NULL default '0',
  `juiceSliderRelatedCE` int(9) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
