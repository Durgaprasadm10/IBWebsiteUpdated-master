
/*
 * jQuery One Page Nav Plugin
 * http://github.com/davist11/jQuery-One-Page-Nav
 *
 * Copyright (c) 2010 Trevor Davis (http://trevordavis.net)
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://jquery.org/license
 *
 * @version 3.0.0
 *
 * Example usage:
 * $('#nav').onePageNav({
 *   currentClass: 'current',
 *   changeHash: false,
 *   scrollSpeed: 750
 * });
 */

;(function($, window, document, undefined){

	// our plugin constructor
	var OnePageNav = function(elem, options){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		this.metadata = this.$elem.data('plugin-options');
		this.$win = $(window);
		this.sections = {};
		this.didScroll = false;
		this.$doc = $(document);
		this.docHeight = this.$doc.height();
	};

	// the plugin prototype
	OnePageNav.prototype = {
		defaults: {
			navItems: 'a',
			currentClass: 'current',
			changeHash: false,
			easing: 'swing',
			filter: '',
			scrollSpeed: 750,
			scrollThreshold: 0.5,
			begin: false,
			end: false,
			scrollChange: false
		},

		init: function() {
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			this.config = $.extend({}, this.defaults, this.options, this.metadata);

			this.$nav = this.$elem.find(this.config.navItems);

			//Filter any links out of the nav
			if(this.config.filter !== '') {
				this.$nav = this.$nav.filter(this.config.filter);
			}

			//Handle clicks on the nav
			this.$nav.on('click.onePageNav', $.proxy(this.handleClick, this));

			//Get the section positions
			this.getPositions();

			//Handle scroll changes
			this.bindInterval();

			//Update the positions on resize too
			this.$win.on('resize.onePageNav', $.proxy(this.getPositions, this));

			return this;
		},

		adjustNav: function(self, $parent) {
			self.$elem.find('.' + self.config.currentClass).removeClass(self.config.currentClass);
			$parent.addClass(self.config.currentClass);
		},

		bindInterval: function() {
			var self = this;
			var docHeight;

			self.$win.on('scroll.onePageNav', function() {
				self.didScroll = true;
			});

			self.t = setInterval(function() {
				docHeight = self.$doc.height();

				//If it was scrolled
				if(self.didScroll) {
					self.didScroll = false;
					self.scrollChange();
				}

				//If the document height changes
				if(docHeight !== self.docHeight) {
					self.docHeight = docHeight;
					self.getPositions();
				}
			}, 250);
		},

		getHash: function($link) {
			return $link.attr('href').split('#')[1];
		},

		getPositions: function() {
			var self = this;
			var linkHref;
			var topPos;
			var $target;

			self.$nav.each(function() {
				linkHref = self.getHash($(this));
				$target = $('#' + linkHref);

				if($target.length) {
					topPos = $target.offset().top;
					self.sections[linkHref] = Math.round(topPos);
				}
			});
		},

		getSection: function(windowPos) {
			var returnValue = null;
			var windowHeight = Math.round(this.$win.height() * this.config.scrollThreshold);

			for(var section in this.sections) {
				if((this.sections[section] - windowHeight) < windowPos) {
					returnValue = section;
				}
			}

			return returnValue;
		},

		handleClick: function(e) {
			var self = this;
			var $link = $(e.currentTarget);
			var $parent = $link.parent();
			var newLoc = '#' + self.getHash($link);

			if(!$parent.hasClass(self.config.currentClass)) {
				//Start callback
				if(self.config.begin) {
					self.config.begin();
				}

				//Change the highlighted nav item
				self.adjustNav(self, $parent);

				//Removing the auto-adjust on scroll
				self.unbindInterval();

				//Scroll to the correct position
				self.scrollTo(newLoc, function() {
					//Do we need to change the hash?
					if(self.config.changeHash) {
						window.location.hash = newLoc;
					}

					//Add the auto-adjust on scroll back in
					self.bindInterval();

					//End callback
					if(self.config.end) {
						self.config.end();
					}
				});
			}

			e.preventDefault();
		},

		scrollChange: function() {
			var windowTop = this.$win.scrollTop();
			var position = this.getSection(windowTop);
			var $parent;

			//If the position is set
			if(position !== null) {
				$parent = this.$elem.find('a[href$="#' + position + '"]').parent();

				//If it's not already the current section
				if(!$parent.hasClass(this.config.currentClass)) {
					//Change the highlighted nav item
					this.adjustNav(this, $parent);

					//If there is a scrollChange callback
					if(this.config.scrollChange) {
						this.config.scrollChange($parent);
					}
				}
			}
		},

		scrollTo: function(target, callback) {
			if( main.fixedNav == "1" || main.secondNav == "1"){
			   var offset = $(target).offset().top - main.shrinkNavHeight;
			}
			else{
				var offset = $(target).offset().top;
			}
			$('html, body').animate({
				scrollTop: offset
			}, this.config.scrollSpeed, this.config.easing, callback);
		},

		unbindInterval: function() {
			clearInterval(this.t);
			this.$win.unbind('scroll.onePageNav');
		}
	};

	OnePageNav.defaults = OnePageNav.prototype.defaults;

	$.fn.onePageNav = function(options) {
		return this.each(function() {
			new OnePageNav(this, options).init();
		});
	};

})( jQuery, window , document );




(function($){
    'use strict';

var isMobileDevices = navigator.userAgent.toLowerCase().match(/(iphone|ipod|ipad|android|iemobile)/);

function initParallax(){
	    if( !isMobileDevices){
		  jQuery('.parallax-section-yes').each( function(){
			  var parallax_speed = $(this).data('parallax-speed') != "" ?  $(this).data('parallax-speed') : 1 ;
			  $(this).parallax("50%" , 0.4*parallax_speed);
		  });
	  }
	}
	
//Isotope fixed bug for Full width Portfolios
var portfolios = {
	container : $('.portfolio .portfolio-items.sortable-items') ,
	
	load_isotope : function(){
		 portfolios.container.each( function(){
			 var $that = $(this),
			      mode = ( $that.data('masonry-layout') == 'yes' ) ? 'masonry' : 'fitRows'  ;
			   $that.imagesLoaded(function(){
				   $that.animate({'opacity':1},600);
				   $that.isotope({
				resizable : true , // Enable normal resizing
			   layoutMode : mode , //Set own custom layout to maintian fancy border
			 itemSelector : '.portfolio-item',
		  animationEngine : 'best-available',
		  animationOptions: {
			  duration: 200,
			  easing: 'easeInOutQuad',
			  queue: false
			}
		   });
		 });
    });
   }
   ,
   
   resize : function(){
	   portfolios.container.isotope('layout');
   },
   load_infiniteScroll : function(){

	    //Infinte Scroll
       portfolios.container.infinitescroll({
		    navSelector  : "div.page-nav", 
		    nextSelector : "div.page-nav a:first",  
		    itemSelector : ".portfolio-item",          
		    errorCallback: function() {
		    	portfolios.container.isotope('layout');
				$('#load_more').fadeOut() ;
		    } ,
			loading: {
                finishedMsg: main.nomoreprojects ,
                img: main.url + '/images/loader.gif' ,
                msg: null,
                msgText: '<div class="spinner"></div>',
                selector: '#infinite_scroll_loading',
                speed: "fast" ,
                start: undefined
             },
			contentSelector: portfolios.container
		}, function(posts) {
			  $('#load_more').fadeIn();
		      $(posts).hide();
			  $(posts).imagesLoaded(function(){
				  // Set the opacity if css animation is set
				  $(posts).find('.inner-content').css({'opacity':1});
				  $(posts).fadeIn();
		          portfolios.container.isotope('appended', $(posts));
			      portfolios.container.isotope('layout');
			 });
		});
     }
	 ,
	 init : function(){
		 if( portfolios.container.length > 0) {
		     portfolios.load_isotope();
		     if( portfolios.container.parent().hasClass('posts-with-infinite')  ){
			     portfolios.load_infiniteScroll();
		     }
		     if( portfolios.container.parent().siblings('#load_more').length > 0  ){
		       $(window).unbind('.infscr');
               $('#load_more > a').click(function (e) {
				   if(!$(this).hasClass('no-more-posts')){
				       $('#load_more').hide();
                       portfolios.container.infinitescroll('retrieve');
				   }
                   return false;
               });
		 }
		
		$(window).on("debouncedresize",function(){ portfolios.resize(); });
	 }
  }
}



//Full blog Setup
var blog = {
	container : $('.posts-grid') ,
	load_isotope : function(){
		blog.container.each(function(){
		  var $that = $(this) ,
		      blog_layout = $that.data('masonry') == 'yes' ? 'masonry' : 'fitRows';
		  $('.flexible-slider',$that).bxSlider({ prevText : '' , nextText : '' ,   autoHidePager: true, easing : 'easeInOutQuart' , adaptiveHeight: false});
		  $that.imagesLoaded(function(){
		      $that.animate({ opacity:1 } , 300);
			  $that.parent().find('.spinner-block').fadeOut();
		      $that.isotope({
			     layoutMode: blog_layout,
			     resizable: true ,
			     itemSelector: '.post-grid-item'
		      });
		   });
		});
     }
   ,
   
   resize : function(){
	   blog.container.isotope('layout');
   },
   
   load_infiniteScroll : function(){
	    //Infinte Scroll
       blog.container.infinitescroll({
		    navSelector  : "div.page-nav", 
		    nextSelector : "div.page-nav a:first",  
		    itemSelector : ".post",          
		    errorCallback: function() {
		    	blog.container.isotope('layout');
				$('#load_more').fadeOut();
		    } ,
			loading: {
                finishedMsg: main.nomoreposts,
                img: main.url + '/images/loader.gif' ,
                msg: null,
                msgText: '<div class="spinner"></div>',
                selector: '#infinite_scroll_loading',
                speed: "fast" ,
                start: undefined
             },
			contentSelector: blog.container
		}, function(posts) {
		      $(posts).hide();
			  $(posts).imagesLoaded(function(){
				  // Set the opacity if css animation is set
				  $(posts).find('.inner-content').css({'opacity':1});
				  $(posts).fadeIn();
		          blog.container.isotope('appended', $(posts));
			      blog.container.isotope('layout');
				  $('#load_more').fadeIn();
			 });
		});
     }
	 ,
	 init : function(){
		 if( blog.container.length > 0) {
		     blog.load_isotope();
		     if( blog.container.parent().hasClass('posts-with-infinite')  ){
			     blog.load_infiniteScroll();
		     }
		     if( blog.container.parent().find('#load_more').length > 0  ){
		       $(window).unbind('.infscr');
               $('#load_more > a').click(function (e) {
				   if(!$(this).hasClass('no-more-posts')){
				       $('#load_more').hide();
                       blog.container.infinitescroll('retrieve');
				   }
                   return false;
               });
		 }
		 
		 $(window).on("debouncedresize",function(){ blog.resize(); });
	 }
  }
}



/*---------------------------------------------------------*/
/* Fancy Border Plugin */
/*---------------------------------------------------------*/

     var fancyBorder = {
	     init : function() {
			 				
		 var $gridElements = $('.row-fluid.style2 , row-fluid.style3') ;				
		
		     $gridElements.each(function(index, element) {
            
				var $gridContainer = $(this),
					   topPosition = 0,
						 totalRows = 0,
				   currentRowStart = 0,
						currentDen = 4,
						currentRow = -1,
						currentCell = 1 ,
					   windowWidth = $(window).width(),
							  rows = [],
						   tallest =  [],
						   $cells  =  $gridContainer.find(' > [class*="span"]'),
						 firstCell = $($cells[0]);
				
				if ( $cells.length < 1 ) {
					return false;
				}
				
				if($gridContainer.hasClass('columns-6')  ) {  currentDen = 6 ; }
				else if ($gridContainer.hasClass('columns-5')) {  currentDen = 5 ; } 
				else if ($gridContainer.hasClass('columns-4')) {  currentDen = 4 ; } 
				else if ($gridContainer.hasClass('columns-3')) {  currentDen = 3 ; }
				else if ($gridContainer.hasClass('columns-2')) {  currentDen = 2 ; } 
		 
				if( windowWidth <= 800 ) {
					 if( $gridContainer.hasClass('columns-2') || $gridContainer.hasClass('columns-3') ) 
					 {
					   currentDen = 1 ;	 
					 }
					 else if( $gridContainer.hasClass('columns-6') ){
					   currentDen = 3 ;	
					 }
					 else
					 {
					   currentDen = 2 ;	 
					 }
				}
			
				 
			  $gridContainer.imagesLoaded(function(){
			   $cells.each(function() {
					var $this = $(this);
					
					/* Simplest trick */
					$this.children().css('height' , 'auto');
					
					var currentHeight = $this.children().outerHeight(true) + 2;
					
					if (currentCell % currentDen == true) {
								currentRow++;
								tallest[currentRow] = currentHeight;
								rows.push([]);
								rows[currentRow].push($this);
						} else {					
								if (currentRow < 0) {
									currentRow = 0;
									rows.push([]);
								}
								rows[currentRow].push($this);
								tallest[currentRow] = (tallest[currentRow] < currentHeight) ? (currentHeight) : (tallest[currentRow]);
						   }
							
					  currentCell++;	
				   });
				
					var totalRows = rows.length ,
								i = 0 ,
								j = 0 ;
					
					for (i = 0; i < totalRows; i++) {
		
							var inCurrentRow = rows[i].length;
								
							for (j = 0; j < inCurrentRow; j++) {
								
							rows[i][j].children().css("height", tallest[i]);
								
							if ( j == 0) {
								rows[i][j].addClass("left-columns");
							} else {
								rows[i][j].removeClass("left-columns");
							 }
								
							if ( i == totalRows - 1) {
								rows[i][j].addClass("bottom-columns");
								rows[i][j].removeClass("not-bottom-columns");
							} else {
								rows[i][j].removeClass("bottom-columns");
								rows[i][j].addClass("not-bottom-columns");
							}
								
							if ( i == 0) {
									rows[i][j].addClass("top-columns");
								} else {
									rows[i][j].removeClass("top-columns");
								}	
							
							if ( j == inCurrentRow - 1) {
									rows[i][j].removeClass("not-right-columns");
									rows[i][j].addClass("right-columns");
								} else {
									rows[i][j].addClass("not-right-columns");
									rows[i][j].removeClass("right-columns");
								}
					  
				
							}
						}	 
				  });
			 });

		}
	 }
	  



	var carouselItems = {
		init: function() {
	
			var carousels = $('.carousel-container');
			
			carousels.each(function() {
				var $that = $(this),
				    carouselInstance = $that.find('.carousel-items'),
					    nextCarousel = $that.find('.bx-next'),
		                prevCarousel = $that.find('.bx-prev'),
						  pagination = $that.find('.pagination'),
		             carouselColumns = parseInt(carouselInstance.attr("data-columns"),10) ,
			                autoplay = $that.attr("data-autoplay") == 'yes' ? true : false;
				
				if ($(window).width() <= 500 ) {
					carouselColumns = 1;
				}
				else if( $(window).width() <= 800 ) {
					carouselColumns = 2;
				}
				
				
				carouselInstance.imagesLoaded(function () {
					 if( $('.flexible-slider',carouselInstance).length > 0  ) {
						 $('.flexible-slider', carouselInstance).bxSlider({ prevText : '' , nextText : '' ,   autoHidePager: true, easing : 'easeInOutQuart' , adaptiveHeight: false});
					 }
					carouselInstance.carouFredSel({
						 circular: true,
		    		   responsive: true, 
			             items   : {
						     height : carouselInstance.find('> div:first').outerHeight() ,
						     width  : carouselInstance.find('> div:first').width(),
				        visible     : {
				            min         : 1,
				            max         : carouselColumns
				        }
				    },
					scroll: {
				    	easing          : 'easeInOutQuart',
			            duration        :  800,
			            pauseOnHover    : false
				    },
					pagination :{
						container : pagination
					},
					swipe	: {
						onTouch : true,
						onMouse : true
					},
					auto : {
						play			: autoplay
					},
					prev : {	
						button			: prevCarousel,
						key				: "left"
					},
					next : { 
						button			: nextCarousel,
						key				: "right"
					},
					onCreate : function() {
						carouselItems.resize();
						initParallax();
						jQuery.waypoints( 'viewportHeight' );
				        jQuery.waypoints('refresh');
					}	
				});
				$that.animate({
					'opacity': 1
				},800);
				});
			});			
		},
		
		resize: function() {
			var carousel = $('.carousel-items');
			carousel.each(function() {
				var $that = $(this) ,
				    $ht = 0 ,
				 visibleColumns = parseInt(carousel.data("columns"), 10);
								
				if ($(window).width() <= 500 ) {
					visibleColumns = 1;
				} else if ($(window).width() <= 800) {
					visibleColumns = 2;
				}
				
				$that.find('> div').each(function(){
					$ht = $(this).outerHeight() > $ht ? $(this).outerHeight() : $ht;
				});
				
				$that.trigger("configuration", {
					items   : {	
				    	height : $ht ,
						width  : $that.find('> div:first').width(),
				        visible     : {
				            min         : 1,
				            max         : visibleColumns
				        }
					}
				});
				
				

			});
		}
};
	

/* Google maps */


	function intialize_googlemap(){
		$('.google_map').each(function(index,element) {
                   var  mapId = $(this).attr("id") ,
			       mapElement = element ,
			    mapContainer = $(this),
			   mapZoom = mapContainer.data('zoom'),
			     scrollWheel = mapContainer.data('scrollwheel'),
			  mapTypeControl = mapContainer.data('maptype-control'),
				   mapMarker = mapContainer.data('marker'),
				 markerImage = mapContainer.data('markerimage'),
				  infoWindow = mapContainer.data('infowindow'),
				    mapStyle = mapContainer.data('style'),
					mapColor = mapContainer.data('color'),
				  customInfo = mapContainer.data('custom-info') ,
				  streetview = mapContainer.data('streetview'),
				     mapType = mapContainer.data('maptype'),
				  pancontrol = mapContainer.data('pancontrol'),
				 zoomcontrol = mapContainer.data('zoomcontrol'),
				    zoomsize = mapContainer.data('zoomsize'),
				         lat = mapContainer.data('lat'),
						 lon = mapContainer.data('lon'),
					infoBgColor = mapContainer.data('info-bgcolor'),
					infoColor = mapContainer.data('info-color'),
		   mapTypeIdentifier = '' ,
		      zoomIdentifier = '';
				 	
				
				if (mapType === "satellite") {
				mapTypeIdentifier = google.maps.MapTypeId.SATELLITE;
				} else if (mapType === "terrain") {
				mapTypeIdentifier = google.maps.MapTypeId.TERRAIN;
				} else if (mapType === "hybrid") {
				mapTypeIdentifier = google.maps.MapTypeId.HYBRID;
				} else {
				mapTypeIdentifier = google.maps.MapTypeId.ROADMAP;
				}
				
				if(zoomsize == 'large'){
					zoomIdentifier = google.maps.ZoomControlStyle.SMALL;
				}
				else{
					zoomIdentifier = google.maps.ZoomControlStyle.LARGE;
				}
				
		
		
				if( lat != '' && lon != ''){
				
				  var latlng = new google.maps.LatLng(lat, lon);
				  var settings = {
					  zoom: parseInt(mapZoom, 10),
					  scrollwheel: scrollWheel,
					  streetViewControl : streetview,
					  mapTypeControl : mapTypeControl,
					  panControl : pancontrol,
					  zoomControl : zoomcontrol ,
					  center: latlng,
					  zoomControlOptions : { style: zoomIdentifier },
					  mapTypeId: mapTypeIdentifier
				  };
  
				  var mapInstance = new google.maps.Map(mapElement, settings);
				  
				  var markers = []; 
				  
				  if (mapMarker == 'yes'){
				 
					  if(typeof(global_mapData) != "undefined"){
					  for (var i = 1; i <= Object.keys(global_mapData[mapId]).length; i++) { 
					      
						  if(i == 1){
							  var location = latlng;
						  }
						  else{
							  var location = new google.maps.LatLng(global_mapData[mapId][i].lat, global_mapData[mapId][i].lon);
						  }
						  
						  
					      if(global_mapData[mapId][i].img != ''){
							 markers[i] = new google.maps.Marker({ position: location, map: mapInstance, icon: global_mapData[mapId][i].img , optimized: false , infoWindowIndex : i });
						  }
						  else if (markerImage !=''){
							  var image = markerImage;
							  markers[i] = new google.maps.Marker({ position: location , map: mapInstance, icon: image , optimized: false , infoWindowIndex : i });
						  }
						  else {
							  markers[i] = new google.maps.Marker({ map: mapInstance , position: location , infoWindowIndex : i });
						 } 
						 
		
						 
					   if(  global_mapData[mapId][i].desc != '') {
						   var contentString =  global_mapData[mapId][i].desc;
						   
						   if( customInfo == 'yes'){
							 var infobox_div = document.createElement('div');
							 infobox_div.className = 'brad-info-box';
							 infobox_div.style.cssText = 'background-color:' + infoBgColor +';color:'+ infoColor  +';';
							 infobox_div.innerHTML = contentString;
							 var infobox_options = {
								 content: infobox_div,
								 disableAutoPan: false,
								 maxWidth: 150,
								 pixelOffset: new google.maps.Size(-125, 10),
								 zIndex: null,
								 boxStyle: { 
									background: 'none',
									opacity: 1,
									width: "250px"
								  },
								 closeBoxMargin: "2px 2px 2px 2px",
								 closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
								 infoBoxClearance: new google.maps.Size(1, 1)
							  };
						  
							markers[i]['infowindow'] = new InfoBox(infobox_options);
							markers[i]['infowindow'].open( mapInstance , markers[i] );
							
							if(global_mapData[mapId][i].visible != 'yes'){
								markers[i]['infowindow'].setVisible(false);  
							}
				  
							google.maps.event.addListener(markers[i], 'click', function() {
							  if( this['infowindow'].getVisible() ) {
								  this['infowindow'].setVisible( false );
							  } else {
								  this['infowindow'].setVisible( true );
							  }
							}); 
							
						   }
						   else{
							   markers[i]['infowindow'] = new google.maps.InfoWindow({ content: contentString });
							   if(global_mapData[mapId][i].visible == 'yes'){
								 markers[i]['infowindow'].open( mapInstance , markers[i] );  
							  }
							   google.maps.event.addListener(markers[i], 'click', function() {
							      this['infowindow'].open( mapInstance , this );
							  }); 
						   }
						   
					     }  
						 
					 }
				}
					  
		 }
						  
		   if( mapStyle == 'style1'){
			   var styles = [
						{
						 featureType:"all",
						 elementType:"all",
						 stylers: [
							 { saturation:-100 }
							 ]
						 }
					  ];
				mapInstance.setOptions({styles: styles});		
		   }
		   else if( mapStyle == 'style2'){
			   var styles = [
						  {
							 "stylers" : [
							 { "hue": "#003bff" },
							 { "invert_lightness": true },
							 { "lightness": 10 },
							 { "gamma": 0.91 },
							 { "saturation": -60 }
						   ]
					   },
					   {
						   "featureType": "road.local",
						   "elementType": "labels",
						   "stylers": [
							 { "visibility": "off" }
							]
					   },
					   {
						   "featureType": "landscape",
						   "stylers": [
							 { "visibility": "simplified" }
						   ]
					   },
					   {
						   "featureType": "poi",
						   "stylers": [
							 { "visibility": "off" }
						   ]
					   },
					   {
						   "featureType": "road",
						   "stylers": [
							 { "saturation": -65 }
						   ]
					   },
					   {
						   "featureType": "water",
						   "stylers": [
							 { "saturation": -50 },
							 { "lightness": -25 }
						   ]
					   },
					   {
						   "featureType": "road",
						   "stylers": [
							 { "gamma": 0.9 }
  
						   ]
						 } 
						 ];
				 mapInstance.setOptions({styles: styles});		
			   }
			   
			   else if ( mapStyle == 'style3' && mapColor != '') {
				   var styles = [
							 {
							 featureType:"all",
							 elementType:"all",
							 stylers: [
									{ "hue": mapColor },
									{ "saturation": -20 }
								  ]
							  }
						   ];
				mapInstance.setOptions({styles: styles});
			   }
			}
        });
	}
		 
		 
	if ( $('.google_map').length > 0 ){
		
		google.maps.event.addDomListener(window, 'load', intialize_googlemap);
		
	}	
	

/*--------------------------------------------------------*/
/* main navigation Script
/*--------------------------------------------------------*/

var mainNavigation = {
		  init : function(){
			  $('#main_menu li').hoverIntent({
				       over : function(){$(this).addClass('hover');},
					   out  : function(){$(this).removeClass('hover');},
					   timeout : 200 
			  });
		       $("#main_menu > li > .sub-menu").each(function(){
		           var $this = $(this),
				   	parentOffsetL = $this.parent().offset().left,
					parentOffsetR = $this.parent().offset().right,
					  windowWidth = $(window).outerWidth(),
					      tallest = 0;
				   if( $this.hasClass('brad-mega-menu')){
		               var parentsWidth = $(this).parents("#main_navigation_container").width(),
	                      parentsOffset = $(this).parents("#main_navigation_container").offset().left;
			          $this.css( { 'left' : '-' + Math.ceil( parentOffsetL - parentsOffset ) + 'px' , 'width' : parentsWidth+'px'});
					  $this.css('display','block');
					  $('> li',$this).each(function(){		      
						    if($(this).outerHeight() > tallest ){
								tallest = $(this).outerHeight();
							}
				       });
					  $('> li',$this).css('height',tallest+'px');
					      $this.css('display','none');
				   }
				   else{
					   if( ( parentOffsetL + 210 ) > windowWidth){
						   $this.addClass('offset-left');
					   }
					   else{
						   $this.removeClass('offset-left');
					   }
					   if( ( parentOffsetL + 420 ) > windowWidth ){
						   $this.addClass('offset-left-level3');
					   }
					   else{
						    $this.removeClass('offset-left-level3');
					   }
				   }
	           });
		   },
		   
		   resize : function(){
			   $(window).on("debouncedresize",function(){
				   mainNavigation.init();
			   });
			}
	   };
	 


    $(document).ready(function($){
	    
				
	   	var header_type = $('body').hasClass('transparent-header') ? 'transparent' : 'solid';
              
	    mainNavigation.init();
		mainNavigation.resize();
		
        jQuery('#main_menu li , #side_menu li  , #mobile_navigation .mobile_menu li').each(function() { 
		if(jQuery(this).hasClass('current-menu-item')) {
			jQuery(this).children('a').removeClass('external')
		}
		else {
			jQuery(this).children('a').addClass('external');
		}
	  });
	  
	  
	  if(jQuery('body').hasClass('home')) {
		jQuery('#main_menu > li:first-child').addClass('active');
		jQuery(' #mobile_navigation .mobile_menu > li:first-child').addClass('active');
		jQuery(' #side_menu > li:first-child').addClass('active');
		
		$('#logo a').click( function(event) {
				$(window).scrollTo( { top : 0 } , 750 , { easing: "easeInOutQuart" , offset: 0 , 'axis':'y' } );		
				event.preventDefault();				
			});
	}
	else{
		jQuery('#main_menu > li').each(function(index, element) {
            if( $(this).hasClass('current-menu-ancestor') || $(this).hasClass('current-menu-item') || $(this).hasClass('current-menu-parent') ){
				$(this).addClass('active');
			}
        });
		
	}
	
	var sm_timeout;
	
	jQuery('#side_menu li').each(function(){
		
		if( $(this).find('> .sub-menu').length > 0 ){
			$(this).hoverIntent({
				over : function(){
				  $(this).addClass('selected').find('> .sub-menu').slideDown(); 
		       },
			   out : function(){
				   $(this).removeClass('selected').find('> .sub-menu').slideUp(); 
			   },
			   timeout : 1000 
		});
	  }
	});
	  
	 jQuery('#main_menu, #side_menu').onePageNav({
		currentClass: 'active',
		filter: ':not(.external)',
		easing: "easeInOutQuart" 
	 });	
	 
	 
	 jQuery('#mobile_navigation .mobile_menu').onePageNav({
		currentClass: 'active',
		filter: ':not(.external)' ,
		easing: "easeInOutQuart" ,
		begin: function(){
			removeExpanded();
		}
	  });	
				
	    
		function removeExpanded(){
		   $("body").removeClass('expanded');
	    }
		 
	   //mobile toggle menu
	   $(".toggle-menu").click(function(e) {
		  e.preventDefault();
		  $("body").toggleClass('expanded');
	   });
	   
	   //mobile cross button
	   $("#close-mobile-menu").click(function(e) {
		  e.preventDefault();
		  $("body").removeClass('expanded');
	   });
		
	  $('.side-navigation-mobile .current-page').html( $('.side-navigation-mobile .current_page_item > a').html() );
	   $('.side-navigation-mobile .current-page').live('click', function(e){
		   e.preventDefault();
		   $('.side-navigation-mobile').toggleClass('clicked');
	   });
	  
      //mobile menu events
	  $(window).on("debouncedresize",function(){ if( $(window).width() > 1000  ){ removeExpanded(); }});
	  
	  
	  
	  var header_type = $('body').hasClass('transparent-header') ? 'transparent' : 'solid',
        header_offset = $('#header_wrapper').offset().top ,
		$header_height = $('#header').outerHeight(),
	    $new_offset = $('#header').data('auto-offset') == 1 ? header_offset + ( $header_height - $('#header').data('shrinked-height')) : header_offset + parseInt($('#header').data('offset')),
		$new_offset1 =  header_offset +  $header_height + parseInt($('#header').data('second-nav-offset')) ,
	    header_height = $('#header').data('height');
      
	  if(!isMobileDevices){
		var timeout;
		
		$(window).scroll(function () {
			
			  var $scroll = $(window).scrollTop();
			  
			  if($('#header').hasClass('sticky-nav')){
				if( $scroll > header_offset ){
					$('#header').addClass('stuck');
					$('#header').parent().css('height', $header_height + 'px' );
				}
				else{
					$('#header').removeClass('stuck');
				}
				
				if ( $scroll > $new_offset && !$('#header').hasClass('shrinked') ) {
					$('#header').addClass('shrinked');
					if(header_type == 'transparent'){ $('#header_wrapper').removeClass('transparent-header');}
				} 
				else if( $scroll < $new_offset || $scroll == $new_offset ){
					$('#header').removeClass('shrinked');;
					if(header_type == 'transparent'){ $('#header_wrapper').addClass('transparent-header');}
				}
			}
			
			else if( $('#header').hasClass('second-nav') ){
	  
				if( $scroll > $new_offset1 && !$('#header').hasClass('to-stuck') ){
					$('#header').addClass('to-stuck shrinked');
					$('#header').parent().css('height' , $header_height + 'px');
					clearTimeout(timeout);
					timeout = setTimeout( function(){ $('#header').addClass('stucked');  if(header_type == 'transparent'){ $('#header_wrapper').removeClass('transparent-header');} } , 100 );
				}
				else if( $scroll < $new_offset1 && $('#header').hasClass('to-stuck') ){
					$('#header').removeClass('stucked shrinked to-stuck');
					 if(header_type == 'transparent'){ $('#header_wrapper').addClass('transparent-header');}
				}
			}
		});
	  }
	
		
	/*--------------------------------------------------------------------------*/
	 /* Brad Slider */
	 /*--------------------------------------------------------------------------*/
	 
	 function header_height() {
		var $header_height = $(window).width() <= 1000 ? 65 : parseInt($('#header').attr('data-height')); 
		return $header_height;
	 }
	 
	 function topbar_height() {
		if( $('#top_bar').length <= 0){
			return  0;
		}
		var $topbar_height =  ($(window) <= 800) ? $('#top_bar').height() : 35;
		return $topbar_height;
	 }
	 
	 
	 var stickyHeader = $('#header').hasClass('sticky-nav') ? true : false ;
	 
	 $('.go-top').live('click', function(e){
		 e.preventDefault();
		 $(window).scrollTo( {top : 0 } , 750 , { easing: "easeInOutQuart" , offset: 0 , 'axis':'y' } );	
	 });

    //Set kub burn effects
	 function setSliderKenburn($slider){
			var $that = $slider.find('.item.active > .image');
            if($that.data('kenburn') == 'yes'){
		    var bgps = $that.data('kbstart'),
				bgpe = $that.data('kbend'),
				zos = $that.data('kbzoom-start'),
				zoe = $that.data('kbzoom-end'),
				duration = $that.data('kb-duration');
				
			if (zos==undefined) zos = 100;
			if (zoe==undefined) zoe = 100;
			
			zos = zos/100;
			zoe = zoe/100;
			
			$that.css({ 'background-position' : bgps , scale : zos } );
			
            if( zos != zoe){
			    $that.transition({ 'background-position' : bgpe , scale: zoe },duration,"ease");
			}
			else{
				$that.transition({ 'background-position' : bgpe },duration,"ease");
			}
		 }
	 }
	 
	 function fixSliderVideoBg($slider){
		 
		  var $sliderWidth = $slider.parent().outerWidth(),
		     $sliderHeight = $slider.outerHeight();

		
		  //Set Slider Video by loop over all slides
		  $slider.find('.item').each(function(){
			    var currentItem = $(this) ,
				      isActive  = currentItem.hasClass('active');
				if(!isActive){ currentItem.addClass('active');}	  
			     if( currentItem.find('video').length > 0){
				   var sliderH = $sliderHeight + 20 ,
					videoRatio = currentItem.attr('data-video-ratio'),
					videoW  = currentItem.find('video').width(),
				    videoH = currentItem.find('video').height() ,
					videoR = Math.floor(videoW/videoH) ,
					windowR = $sliderWidth/sliderH;

					if( typeof(videoRatio) == "undefined" || videoRatio != '' ){
					     if( videoRatio == '4:3'){
							 videoR = Math.floor(4/3);
						 }
					    else{
							videoR = Math.floor(16/9);
						}
				   }
				   
				   
                   if(windowR < videoR ) {
                       $(' video , .mejs-overlay , .mejs-container, object',currentItem).width($sliderWidth*videoR).height(sliderH);
					   $(' video , .mejs-overlay , .mejs-container, object',currentItem).css({'top':0 , 'left':-(sliderH*videoR-$sliderWidth)/2 , 'height': sliderH});
                   } 
				   else {
                       $(' video , .mejs-overlay , .mejs-container, object',currentItem).width($sliderWidth).height($sliderWidth/videoR);
					   $(' video , .mejs-overlay , .mejs-container, object',currentItem).css({'top':-($sliderWidth/videoR-sliderH)/2 , 'left':0 , 'height':$sliderWidth/videoR});
                 }
				}
				if(!isActive){ currentItem.removeClass('active');}	  
			 });
	 }
	 
	 
	 function fixSliderHeight($slider){
		 
		    var $sliderWidth = $slider.outerWidth(),
		        $sliderHeight = $slider.outerHeight(),
			    $ht_responsive = $slider.attr("data-rs-height");
		 
		 /*Set Slider Height*/
		 if( $slider.attr('data-fullheight') == "yes" ){
			 $sliderHeight = $(window).height();
			 if($slider.hasClass('header-slider-yes') && header_type == 'solid' && !$('body').hasClass('type4') ){
			    $sliderHeight =  Math.floor( $(window).height() - ( header_height() + topbar_height() ));
			 }
		 }
		 else{
			 if( $ht_responsive == 'yes'){
			     if ( $(window).width() <= 1300 && $(window).width() > 1000) {
                     $sliderHeight = $slider.attr('data-height') * 0.8 ;
                  } else if ($(window).width() <= 1000 && $(window).width() > 768) {
                     $sliderHeight = $slider.attr('data-height') * 0.7;
                  } else {
                     $sliderHeight = $slider.attr('data-height') * 1;
                  }
				 
			 } else {
			     $sliderHeight = $slider.attr('data-height');
			 }
		 }
		 
		 if($slider.find('.carousel-inner').hasClass('parallax-slider-yes') ){
			 $slider.find('.carousel-inner').css({'width' : $slider.width() + 'px'});
			
		 }
		 
		 $slider.css({'height':  $sliderHeight +'px'});
		 $slider.parent().css({'height':  $sliderHeight +'px'});
		 $slider.find('.carousel-inner > .item , .carousel-inner' ).css({'height':  $sliderHeight +'px'});
	   }
		
	 //init slider
	 
	 if($('.brad-slider').length > 0){
			 
		 $('.brad-slider').each(function() {
		   
		     var $slider = $(this) ,
		     header_scheme = $slider.find('.carousel-inner .item:first-child').attr('data-header-scheme'),
			 slider_scheme = $slider.find('.carousel-inner .item:first-child').attr('data-slider-scheme');
			 
			 if(isMobileDevices){
				 $slider.addClass('parallax-disabled');
			 }

		    $('body').removeClass('header-scheme-light header-scheme-dark').addClass(header_scheme);
			$('#header_wrapper').removeClass('header-scheme-light header-scheme-dark').addClass(header_scheme);
			$slider.removeClass('color-dark color-light').addClass(slider_scheme);
						
			
			$slider.imagesLoaded(function(){
				if($slider.find('video').length > 0 ){
		            $('video', $slider).mediaelementplayer({
			            enableKeyboard : false,
                        iPadUseNativeControls : false,
                        pauseOtherPlayers : false,
                        iPhoneUseNativeControls : false,
                         AndroidUseNativeControls : false
                   });
			    }
				
				fixSliderHeight($slider);
				fixSliderVideoBg($slider);
				$('.carousel-preloader' , $slider).fadeOut();
			    $slider.find('.carousel-inner .item:first-child').addClass('active');
				$('.carousel-indicators > li:first-child', $slider).addClass('active');
				$slider.carousel({ pause: false });
				$slider.find('.carousel-indicators , .carousel-control').animate({opacity:1},400);
			    $slider.addClass('load-animation');
				setSliderKenburn($slider);
			});
			
			$slider.on('slide.bs.carousel', function (element) {
				$slider.removeClass('load-animation');
             });

				
             $slider.on('slid.bs.carousel', function (element) {
				 $slider.addClass('load-animation');
				 setSliderKenburn($slider);
			 });
			 
			 if($slider.attr('data-swipe') == 'yes'){
			  $slider.swipe({
                    swipeLeft: function (event, direction, distance, duration, fingerCount) {
                        $slider.carousel('next')
                    },
                    swipeRight: function (event, direction, distance, duration, fingerCount) {
                        $slider.carousel('prev')
                    },
					allowPageScroll: "vertical",
                    threshold: 75
             });
		   }
		   
		   
		   if(!isMobileDevices){
               var skrollrInit = skrollr.init({
					 edgeStrategy: 'set',
					 smoothScrolling: true,
					 forceHeight: false
				  });
				  skrollrInit.refresh();
	    }
		   
		 
		   $(window).on('debouncedresize', function(){
			   fixSliderHeight($slider);
			   fixSliderVideoBg($slider)
		   });
		   
		});
		

	 }
	
	
	//init parallax
	initParallax();
	
	
	/*-------------------------------------------------------------------------*/
	/* columns equal  height Fix
	/*-------------------------------------------------------------------------*/
	function resizeColumnsht(){
		$('.row-fluid.equal-cheight-yes').each(function() {
		   var element = $(this), 
	     childElements = element.find('.section-column'),
	            tallest = 0 ;
		
		 childElements.css('height','auto');

		if( $(window).width() > 800){		
		  element.imagesLoaded(function(){	
			childElements.each(function() {
			  var childElement = $(this); 
			  if( childElement.outerHeight() > tallest){
				  tallest = childElement.outerHeight();
			  }
		     });
		 
		  childElements.css('height', tallest+'px');
		});
	  }
    });
  }
	resizeColumnsht();
	
    $(window).on("debouncedresize", function(){
	  resizeColumnsht();
	});
	
	
	 
	 /* Counto */
	 if( !isMobileDevices){
	     $('.counter-title').each(function(){
			$(this).waypoint(function() {
	        var element = $(this).find('> span > span'),
			  percentage = element.data('percentage');
		    element.countTo({from: 0, to: percentage, speed: 900});
	       },
	       {
			triggerOnce : true ,
			     offset : '100%'
	    });
	  });
	 }
	 else{
		 $('.counter-title').each(function() {
			 var element = $(this).find('> span > span'),
			  percentage = element.data('percentage');
		    element.countTo({from: 0, to: percentage, speed: 900});
	       });
	 }
		
		
	/* ------------------------------------------------------------------------ */
	/* Animated Boxes */
	/* ------------------------------------------------------------------------ */ 
	 function setTitlebarHeight(){
		var $titlebar = $('#titlebar') ,
		    $titleHeight = $titlebar.attr('data-height');
			if ( $(window).width() <= 1300 && $(window).width() > 1000) {
                 $titleHeight = $titleHeight * 0.8 ;
             } else if ($(window).width() <= 1000 ) {
                 $titleHeight = $titleHeight * 0.7;
			 }
			 
			  else if ($(window).width() < 500 ) {
                 $titleHeight = $titleHeight * 0.6;
			 }
			 
		  $titlebar.find(' > .titlebar-wrapper').css( { 'height' : $titleHeight + 'px' , 'min-height' : $titleHeight + 'px' });	 
	}
	 
	 if($('#titlebar').attr('data-rs-height') == 'yes' ) {
		  setTitlebarHeight();
	      $(window).on('debouncedresize',setTitlebarHeight);
	  }
	  
	
	 	
	/* ------------------------------------------------------------------------ */
	/* Animated Boxes */
	/* ------------------------------------------------------------------------ */ 
	 $('.animate-when-visible:not(.portfolio-items)').each(function()
		{
			var element = $(this),
			    effect  = $(this).data('animation-effect') !== '' ?  $(this).data('animation-effect') : 'fadeIn' ,
				itemDelay   = ( isNaN($(this).data('animation-delay')) ? 0 : $(this).data('animation-delay') ) ;
				
				if( !isMobileDevices){
				    element.waypoint(function(direction){
				    setTimeout(function(){
					    element.addClass(effect).addClass('start-animation');
				        } , itemDelay);
                     },{ offset: '80%' , triggerOnce: true} );
				}
				else{
					element.addClass(effect).addClass('start-animation');
				}

		});	
		
	
	/* ------------------------------------------------------------------------ */
	/* Portfolio animation */
	/* ------------------------------------------------------------------------ */ 

	 $('.animate-when-visible.portfolio-items').each(function()
		{
			var element = $(this),
			    effect  = $(this).data('animation-effect') !== '' ?  $(this).data('animation-effect') : 'fadeIn' ,
				itemsDelay   = ( isNaN($(this).data('animation-delay')) ? -1 : $(this).data('animation-delay') ) ,
				objectsToAnimate = $(this).find(' > .portfolio-item > .inner-content');
				
			element.imagesLoaded(function () {
				element.waypoint(function(direction)
				{
				    objectsToAnimate.each(function(i) {
			        var object = $(this); 
				    setTimeout(function(){
						object.addClass(effect).addClass('start-animation');
					} , i*itemsDelay);
                   });	
				},{ offset: '80%' , triggerOnce: true} );
			});
		});		
		
	

	
	/* ------------------------------------------------------------------------ */
	/* Easy Pie chart */
	/* ------------------------------------------------------------------------ */
	
	$('.chart-shortcode').each(function(index, element) {
		var element = $(this);
		 element.easyPieChart({
						animate: 1000,
						lineCap: 'square',
						lineWidth: element.attr('data-linewidth'),
				           size : element.attr('data-size'),
						barColor: element.attr('data-barcolor'),
						trackColor: element.attr('data-trackcolor'),
						scaleColor: 'transparent'
					});
			});

	
	$('.chart-shortcode').each(function(){
		var element = $(this);
             setTimeout(function(){
				element.waypoint(function(direction)
				{
				if (!$(this).hasClass('animated')) {
					$(this).addClass('animated');
					var animatePercentage = parseInt($(this).attr('data-animatepercent'), 10);
					$(this).data('easyPieChart').update(animatePercentage);
				}}, { offset: 'bottom-in-view' , triggerOnce: true} );
              },100);	
	 });
	
	
	/* ------------------------------------------------------------------------ */
	/* Skillbars */
	/* ------------------------------------------------------------------------ */
	
	$('.progress').each(function()
		{
		  var element = $(this),
		      progressBar = $(this),
			  progressValue = progressBar.find('.bar').attr('data-value');
			   
		    if( !isMobileDevices){
             element.waypoint(function(direction){
				 if (!progressBar.hasClass('animated')) {
					progressBar.addClass('animated');
					progressBar.parent().find('.bar-text').animate({ opacity: 1 }, 300 );
					progressBar.find('.bar').animate({
						width: progressValue + "%"
					   }, 600 , "easeInOutQuart");
				  } 
			     }, { offset: '80%' , triggerOnce: true} );
			}
			else{
				progressBar.parent().find('.bar-text').animate({ opacity: 1 }, 300 );
				progressBar.find('.bar').animate({
						width: progressValue + "%"
					   }, 600 , "easeInOutQuart");

			}
		 });
		 
		  		 	  
		  
	

	 
	 //Search Panel
     var searchBtn = $('#header-search-button > a'),
			searchPanel = $('#header-search-panel'),
			searchP = $('#header-search'),
			searchInput = searchPanel.find('input[type="text"]'),
			searchClose = searchPanel.find('.close');
		searchBtn.click(function(e){
			e.preventDefault();
			var _t = $(this);
			if(!_t.hasClass('active')) {
				 searchPanel.fadeIn();
				_t.addClass('active');
			} else {
				_t.removeClass('active');
				searchPanel.fadeOut();
			}
	 }); // searchBtn.click //
		
	 searchClose.click(function(){
			searchBtn.removeClass('active');
			searchPanel.fadeOut();
	});
     
	 
	 
	
	 /*--------------------------------------------------------------------------*/
	 /* Section Settings
	 /*---------------------------------------------------------------------------*/
	
	  
	  function section_video_bg_size() {
                
            $('.section.section-bgtype-video').each(function() {
                   var $this = $(this),
				     windowW = $this.width() , 
                     windowH = $this.outerHeight() + 20 ,
				     videoW  = $this.find('video').width(),
				      videoH = $this.find('video').height() ,
				      videoR = videoW/videoH;
					  
				if( $('#boxed_layout').length > 0 ){
					windowW = $('#boxed_layout').outerWidth();
			
				} 
				    var  windowR = windowW/windowH ;
					
				if($this.data('video-ratio') != undefined && $this.data('video-ratio') != '' ){
					if( $this.data('video-ratio') == '4:3'){ videoR = 4/3;}
					else{ videoR = 16/9;}
				}
				
				if( $this.hasClass('section-height-video')){
					$this.animate({'height':videoHeight},400);
				}	
				else {
                 if(windowR < videoR ) {
                    $(' video , .mejs-overlay , .mejs-container, object',$this).width(windowW*videoR).height(windowH);
					$(' video , .mejs-overlay , .mejs-container, object',$this).css({'top':0 , 'left':-(windowH*videoR-windowW)/2 , 'height':windowH});
                   } else {
                    $(' video , .mejs-overlay , .mejs-container, object',$this).width(windowW).height(windowW/videoR);
					$(' video , .mejs-overlay , .mejs-container, object',$this).css({'top':-(windowW/videoR-windowH)/2 , 'left':0 , 'height':windowW/videoR});
                 }
				}
            });
            
    }

    if( $('.section.section-bgtype-video').length > 0 ){
		section_video_bg_size();
		$('.section.section-bgtype-video').css('visibility', 'visible');
		$('.section.section-bgtype-video > video').mediaelementplayer({
			enableKeyboard: false,
            iPadUseNativeControls: false,
            pauseOtherPlayers: false,
            iPhoneUseNativeControls: false,
            AndroidUseNativeControls: false
         });
		 
		 $(window).on("debouncedresize", function () {
            section_video_bg_size();
         });
	}
	  
	  
	//fancy border init
    fancyBorder.init();
	
	$(window).on("debouncedresize", function () {
            fancyBorder.init();
     });
	
	

		  
	//fit videos
	$('.video:not(".floated-video")').fitVids();

	   
	/* ------------------------------------------------------------------------ */
	/* Portolio Tabs */
	/* ------------------------------------------------------------------------ */ 
	function fixportfolio_tabs(){
		var $element = $('.portfolio-tabs.portfolio-tabs-blackbox');
		if($(window).width() > 1140 && !$('body').hasClass('type4') ){
			$element.css({'margin-left': - $element.offset().left + 'px' , 'width' : $(window).width() + 'px' , 'max-width' : $(window).width() + 'px' });
		}
		else{
			$element.css({'margin-left': 0 ,  'width' : '100%' });
		}
	}
	
	if($('.portfolio-tabs.portfolio-tabs-blackbox').length > 0){
		fixportfolio_tabs();
		$(window).on('debouncedresize',function(){
			fixportfolio_tabs();
		});
	}
	$('.portfolio-tabs > div > ul > li >  a').on('click',function(e){
		e.preventDefault();
		var selector = $(this).attr('data-filter');
		$('.portfolio-items.sortable-items').isotope({ filter: selector });
		$(this).parents('ul').find('li').removeClass('active');
		$(this).parent().addClass('active');
	});	
	

	
	/* ------------------------------------------------------------------------ */
	/* Tooltips */
	/* ------------------------------------------------------------------------ */
	$('.tooltips , .tooltext').each(function(){
		var align = $(this).data('align') != '' ? $(this).data('align') : 'top';
		$(this).find('a[rel="tooltip"]').tooltip({placement: align , animation: true});
	});
    $('#topbar .social-icons a').tooltip({placement: 'bottom', animation: true});
    $('#copyright .social-icons a').tooltip({placement: 'top'});
	 	

	
	if($.fn.bxSlider){


	
	/* ------------------------------------------------------------------------ */
	/* Flexible-slider */
	/* ------------------------------------------------------------------------ */
	var flexible_sliders = [] ,
	  flexible_slider_count = 0;
	 $('.flexible-slider:not(".floated-slideshow")').each(function(){
		 var flexInstance = $(this),
		           effect =  flexInstance.data("effect") != "" ? flexInstance.data("effect") : "fade",
		         autoplay =  flexInstance.data('autoplay') == 'yes' ? true : false ,
		       navigation =  flexInstance.data('navigation') == 'yes' ? true : false ,
		       pagination =  flexInstance.data('pagination') == 'yes' ? true : false ,
			     interval =  isNaN(flexInstance.data('speed')) ? 4000 : flexInstance.data('speed');
		   
		  
		  flexible_sliders[flexible_slider_count] = flexInstance.bxSlider({
			mode : effect ,
			easing : 'easeInOutQuart',
			autoHidePager: true,
			adaptiveHeight: true,
			infiniteLoop: false,
			controls : navigation ,
			auto : autoplay ,
			pause : interval,
			pager : pagination ,
     		prevText : '' ,
			nextText : '' 
		});
			
			flexible_slider_count++;
			
		 });
		 		
	
		
	/* ------------------------------------------------------------------------ */
	/* Quotes Carousel */
	/* ------------------------------------------------------------------------ */	
	$('.bx-carousel-container').each(function(){
	 var carouselInstance = $(this),
			 nextCarousel =  carouselInstance.find('.carousel-next') ,
			 prevCarousel =  carouselInstance.find('.carousel-prev') ,
		     navigation   =  carouselInstance.data('navigation') == 'yes' ? true : false,
			 pagination   =  carouselInstance.data('pagination') == 'yes' ? true : false,
			 autoplay     =  carouselInstance.data('autoplay') == 'yes' ? true : false ,
			 effect     =  carouselInstance.data('effect') != "undefined" ? carouselInstance.data('effect') : "fade" ,
			 interval =  isNaN(carouselInstance.data('speed')) ? 4000 : carouselInstance.data('speed'),
			 adHeight   = !isMobileDevices ? true : false ;
	
	  var bxSlider = carouselInstance.find('.bx-fake-slider').bxSlider({
		     mode : effect ,
			 easing : 'easeInOutQuart',
			 controls : navigation ,
			 adaptiveHeight: adHeight ,
			 auto     : autoplay ,
			 pause : interval,
			 pager : pagination ,
			 autoHidePager : true,
			 pagerSelector : carouselInstance.find('.carousel-pagination'),
			 prevSelector  : prevCarousel ,
			 prevText      : '',
			 nextSelector  : nextCarousel ,
			 nextText      : '',
			 onSliderLoad : function(){
				 carouselInstance.animate({"opacity":1},300);
				 initParallax();
			 }
		}); 
		
		if(!isMobileDevices){
		     carouselInstance.find('blockquote').swipe({
                    swipeLeft: function (event, direction, distance, duration, fingerCount) {
                      bxSlider.goToNextSlide();
                    },
                    swipeRight: function (event, direction, distance, duration, fingerCount) {
                       bxSlider.goToPrevSlide(); 
                    },
                    threshold: 20
           });
		}
	});


  }
  
  
  	/*-------------------------------------------------------------------------*/
	/* Testimonials Setup
	/*-------------------------------------------------------------------------*/
	function testimonial_resize(){
		$('.testimonials-grid:not(.masonry-yes)').each(function(index, element) {
			var $that = $(this),
			    $height = 0;
			
			$that.find('.testimonial-item').each(function(index, element) {
                $height = $(this).find('.testimonial-content-wrapper').outerHeight() > $height ? $(this).find('.testimonial-content-wrapper').outerHeight() : $height;
            });
		
			$that.find('.testimonial-content-wrapper').css('height',$height+'px');
			
		});
	}
	
	testimonial_resize();
	$(window).on('debouncedresize', testimonial_resize);
	
	if($('.testimonials-grid.masonry-yes').length > 0){
	  $('.testimonials-grid.masonry-yes').each(function(index, element) {
		  var $that = $(this);
			  $that.imagesLoaded(function(){
				  $that.isotope({
					  itemSelector: '.testimonial-item',
					  resizable : true , // Enable normal resizing
					 layoutMode : 'masonry' , //Set own custom layout to maintian fancy border
				animationEngine : 'best-available',
				animationOptions: {
					duration: 200,
					easing: 'easeInOutQuad',
					queue: false
				 }
			   });
			  $that.animate({'opacity':1},"fast");
		});
	  });
	  
	  $(window).on('debouncedresize',function(){
		  $('.testimonials-grid.masonry-yes').isotope('layout');
	  });
	  
	}
	  
	
	
	
	
	/*-------------------------------------------------------------------------*/
	/* Post Grid
    /*-------------------------------------------------------------------------*/
	
	blog.init();
	
	/* ------------------------------------------------------------------------ */
	/* Contact Form */
	/* ------------------------------------------------------------------------ */
	 if( $('.contact-form').length > 0 ) {
	    $('.contact-form').each(
		function(){
			var form = $(this),
			formSent = false,
	    formElements = form.find('textarea, select, input[type=text] , input[type=email] , input[type=hidden]'),
		formElementstoCheck = form.find('textarea, select, input[type=text] , input[type=email]'),
		  formSubmit = form.find('input[type=submit]');
			form.submit(function(e) {
				e.preventDefault();
				
				var validationError = false;
				
				formElementstoCheck.each(function(){
				var currentElement = $(this),
				           classes = currentElement.attr('class'),
				             value = currentElement.val();
				   
				if( classes && classes.match("required") && value === '')
				       {
						   currentElement.removeClass("valid error").addClass("error");
						   validationError = true;
					   }
			   
						
				});
				
				if(validationError == false) {
				  var data = {
						action : 'brad_send_mail' ,
						nonce: main.contactNonce,
						fields : {}
					};
				   formElements.each(function(){
						var that = $(this);
						data.fields[ that.attr('name') ] = that.val();
					});
				
					
					formSubmit.attr('disabled','disabled');
					$.ajax({
						type: "POST",
					dataType: "json",
                         url: main.ajaxurl,
                        data: data,
					 success: function (response) {
						if (response.success) {
							
							

							$('.alert-success',form).removeClass("hidden");
							$('.alert-error',form).addClass("hidden");
							if((form.position().top - 80) < $(window).scrollTop()){
								$("html, body").animate({
									 scrollTop: form.offset().top - 80
								}, 300); 
							}
							formElements.val('').removeClass("valid error");
							main.contactNonce = response.nonce;	
							formSubmit.removeAttr('disabled');								
							}
						else{
                           $('.alert-error',form).removeClass("hidden");
						   $('.alert-success',form).addClass("hidden");
					       if((form.position().top - 80) < $(window).scrollTop()){
								$("html, body").animate({
									 scrollTop:form.offset().top - 80
								}, 300);
							}
						 main.contactNonce = response.nonce;
						 formSubmit.removeAttr('disabled');
						 formElements.removeClass("valid error");	
						  }
						}
				  });
				}
			});
		});
     }
	 
	
   /* ------------------------------------------------------------------------ */
   /*  All carousel items
   /* ------------------------------------------------------------------------ */
    carouselItems.init();
		 
   $(window).on('debouncedresize',function() {
		 carouselItems.resize();	
	});
								 
	/*------------------------------------------------------------------------- */
	/* Post Share */
	/*------------------------------------------------------------------------- */
	
	  if($('.post-share').length > 0 ){
		$('.facebook-share , .twitter-share , .reddit-share , .google-share , .linkedin-share , .pinterest-share').on('click',function(){ 
		    window.open( $(this).attr('href') , "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ) 
			return false; 
			});

		$('.post-share').animate({opacity:1});
	 }
		
    /* ------------------------------------------------------------------------ */
	/* Accordions */
	/* ------------------------------------------------------------------------ */
     $('.accordions').each(function(){
	    var active_tab = $(this).data("active-tab");
	     $(this).find('.accordion:nth-child(' + active_tab + ')').find('> .accordion-inner').stop().show().stop().prev().addClass("active");
	});
	
	$('.accordion .accordion-title > a').click(function() {
	    if($(this).parent().next().is(':hidden')) {
	       $(this).parent().parent().parent().find('.accordion-title').removeClass('active').next().slideUp(200);
	       $(this).parent().toggleClass('active').next().slideDown(200);
	    }
	    return false;
	});
	
	/* ------------------------------------------------------------------------ */
	/* Toggles */
	/* ------------------------------------------------------------------------ */
	if( $(".toggle .toggle-title").hasClass('active') ){
		$(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
	}
	
	$(".toggle .toggle-title").click(function(e){
		e.preventDefault();
		if( $(this).hasClass('active') ){
			$(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
		}
		else{
			$(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
		}
	});
	
    /* ------------------------------------------------------------------------ */
	/* Alert Messages */
	/* ------------------------------------------------------------------------ */
	$(".alert .close").click(function(){
		$(this).parent().animate({'opacity' : '0'}, 300).slideUp(300);
		return false;
	});
	
	
	/* ------------------------------------------------------------------------ */
	/* Tabs */
	/* ------------------------------------------------------------------------ */
	$('.tabset').tabset();

    /*--------------------------------------------------------------------------*/
	/* Woocomerce
	/*--------------------------------------------------------------------------*/
	$('.cart-container').hoverIntent({  
	                   over : function(){$(this).addClass('hover');},
					   out  : function(){$(this).removeClass('hover');},
					   timeout : 200 
	       });
	
	  
	
    $('a.add_to_cart_button').click(function(e) {
		var $this = $(this);
		$this.parent().parent().parent().parent().removeClass('in-cart-yes').addClass('loading-yes');
		setTimeout(function(){
			$this.parent().parent().parent().parent().removeClass('loading-yes').addClass('added-to-cart');
			setTimeout(function(){
				$this.parent().parent().parent().parent().removeClass('added-to-cart').addClass('in-cart-yes');
			}, 2000);
		}, 2000);
	});
	
});



 $(window).load(function() {
   
   //Init Portfolios
   portfolios.init();
  		
});
   
}(jQuery))