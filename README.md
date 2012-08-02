JuiceSlider
===========
Contao-Erweiterung zur Erstellung eines horizontalen Sliders auf Mootools-Basis.

Verwendung
------------
Die Erweiterung stellt zwei neue Inhaltselemente ***JuiceSlider Start*** und ***JuiceSlider End*** bereit,
alle Inhaltselemente zwischen diesen Beiden werden im Slider dargestellt.

Konfigurationsoptionen des Start-Elements

* Breite, Höhe des Sliders
* Effekt-Transition
* Dauer des Effekts
* Breite der geschlossenen Elemente
* Initial expandierendes Element


Styling
---------
```html
<div class="juiceSlider">
  <div class="juiceSliderItem juiceSliderItem0 first">
  	<div class="juiceSliderToggler"></div>
    <div class="ce_text">...</div>
  </div>
  <div class="juiceSliderItem juiceSliderItem1">
  	<div class="juiceSliderToggler"></div>
    <div class="ce_text">...</div>
  </div>
  <div class="juiceSliderItem juiceSliderItem2">
  	<div class="juiceSliderToggler"></div>
    <div class="ce_text">...</div>
  </div>
  <div class="juiceSliderItem juiceSliderItem3 last">
  	<div class="juiceSliderToggler"></div>
    <div class="ce_text">...</div>
  </div>
</div>
```

Zusätzlich bekommt jedes `div.juiceSliderItem` die Klasse `hover` beim Überfahren mit der Maus,
sowie die Klasse `active`, falls das Element expandiert ist.


CSS-Basics
----------
```
.juiceSliderItem {background-color:#FFF;border-left:3px solid #F0F;}
.juiceSliderItem.hover {background-color:#defae5;}
.juiceSliderItem.active {background-color:#dee4fa;}

/* if you use togglers */
.juiceSliderToggler {cursor:pointer;background-color:d96808#;}
```


Contact, Licence
----------------
Lizenz: LGPL

Entwickler: Christoph Wiechert, [4ward.media](http://www.4wardmedia.de)