var JuiceSLider = new Class({

	Implements: [Options],

	options:
	{
		closedWidth: 50,				// width of an closed element
		initialExpand: -1, 				// which item to expand initially, use -1 to expand the last item or false to keep all collapsed
										// you can also use the HTTP-GET parameter juiceSlider: page.html?juiceSlider=2 to expand element 3
		hideToggler: true,
		fxDuration: 500,
		fxTransition: 'quad:in:out'
	},

	container: null,
	items: [],

	initialize: function(container,options)
	{
		this.container = container;
		this.setOptions(options);

		var elems = this.container.getChildren();

		// calc width of an single element
		this.itemWidth = this.container.getDimensions().x - elems.length*this.options.closedWidth;

		// generate wrapping div and its classes
		elems.each(function(el,index){
			el.setStyle('width',this.itemWidth);

			var classes = 'juiceSliderItem';
			classes += ' juiceSliderItem'+index;
			if(index==0) classes += ' first';
			if(index==elems.length-1) classes += ' last';

			this.items[index] = new Element('div',{'class':classes}).wraps(el);
		}.bind(this));

		this.items = new Elements(this.items);

		// set initial styles
		this.items.setStyles({
			'height': '100%',
			'overflow': 'hidden',
			'float':'left',
			'position': 'relative',
			'width':this.options.closedWidth
		});

		// register click and hover events
		this.items.each(function(el,index){
			el.addEvents({
				'mouseenter': function(){
					el.addClass('hover');
				},
				'mouseleave': function(){
					el.removeClass('hover');
				}
			});

			// add toggler div
			new Element('div',{
				'class': 'juiceSliderToggler',
				'events': {
					'click':function(){
						this.expand(index);
					}.bind(this)
				},
				'styles': {
					'width': this.options.closedWidth,
					'height': '100%',
					'position': 'absolute',
					'top':0,
					'left':0
				}

			}).inject(el,'top');

		}.bind(this));

		// expand initial item
		var url = new URI(document.location.href);
		if(url.getData('juiceSlider'))
		{
			this.expand(url.getData('juiceSlider'));
		}
		if(this.options.initialExpand == -1)
		{
			this.expand(this.items.length-1);
		}
		else if(this.options.initialExpand === false) {	}
		else
		{
			this.expand(this.options.initialExpand);
		}

	},

	expand: function(index)
	{
		if(this.items[index].getStyle('width').toInt() > this.options.closedWidth) return;

		this.items.removeClass('active');
		this.items[index].addClass('active');

		if(this.options.hideToggler)
		{
			this.items.getElements('.juiceSliderToggler').each(function(el,togglerIndex){
				if(togglerIndex == index)
				{
					el.morph({'opacity':0,'width':0});

				}
				else
				{
					el.morph({'opacity':1,'width':this.options.closedWidth});
				}
			}.bind(this));
		}

		// generate matrix
		var effectMatrix = {};
		for(var i=0; i<this.items.length; i++)
		{
			effectMatrix[i] = {width: (i == index) ? this.itemWidth : this.options.closedWidth};
		}

		var effect = new Fx.Elements(this.items,{
			duration: this.options.fxDuration,
			transition: this.options.fxTransition
		});
		effect.start(effectMatrix);
	}

});