 jQuery(window).load(function(){
      var height = jQuery('.woocommerce-product-gallery__wrapper div')[0].style.width+2;
    jQuery('iframe').attr('height',height);
});
jQuery('.woocommerce-product-gallery').each(function() {
  jQuery(this).find('[data-thumb]').each(function() {
    jQuery(this).attr('data-size', jQuery(this).find('iframe').attr('width')+ 'x' + jQuery(this).find('iframe').attr('height'));
  });
});

var initPhotoSwipeFromDOM = function(gallerySelector) {

  // parse slide data (url, title, size ...) from DOM elements
  // (children of gallerySelector)
  var parseThumbnailElements = function(el) {
      var thumbElements = jQuery(el).find('.woocommerce-product-gallery__image:not(.isotope-hidden)').get(),
      numNodes = thumbElements.length,
      items = [],
      figureEl,
      linkEl,
      size,
      item;

    for (var i = 0; i < numNodes; i++) {

      figureEl = thumbElements[i]; // <figure> element

      // include only element nodes
      if (figureEl.nodeType !== 1) {
        continue;
      }

      linkEl = figureEl.children[0]; // <a> element
      
      //size = linkEl.getAttribute('data-size').split('x');
      size1 = jQuery(linkEl).find('img').attr('data-large_image_width');
      size2 = jQuery(linkEl).find('img').attr('data-large_image_height');
      
      // create slide object
      if (jQuery(linkEl).data('type') == 'video') {
        item = {
          html: jQuery(linkEl).data('video')
        };
      } else {
        item = {
          src: linkEl.getAttribute('href'),
          w: parseInt(size1 , 10),
          h: parseInt(size2, 10)
        };
      }

      if (figureEl.children.length > 1) {
        // <figcaption> content
        item.title = jQuery(figureEl).find('.caption').html();
      }

      if (linkEl.children.length > 0) {
        // <img> thumbnail element, retrieving thumbnail url
        item.msrc = linkEl.children[0].getAttribute('src');
      }
      item.title = jQuery(linkEl).find('img').attr('title');
      item.el = figureEl; // save link to element for getThumbBoundsFn
      items.push(item);
    }

    return items;
  };

  // find nearest parent element
  var closest = function closest(el, fn) {
    return el && (fn(el) ? el : closest(el.parentNode, fn));
  };

  function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
  }

  // triggers when user clicks on thumbnail
  var onThumbnailsClick = function(e) {
    e = e || window.event;
    e.preventDefault ? e.preventDefault() : e.returnValue = false;

    var eTarget = e.target || e.srcElement;

    // find root element of slide
    var clickedListItem = closest(eTarget, function(el) {
      return (hasClass(el, 'woocommerce-product-gallery__image'));
    });

    if (!clickedListItem) {
      return;
    }

    // find index of clicked item by looping through all child nodes
    // alternatively, you may define index via data- attribute
    var clickedGallery = clickedListItem.closest('.woocommerce-product-gallery'),
      childNodes = jQuery(clickedListItem.closest('.woocommerce-product-gallery')).find('.woocommerce-product-gallery__image:not(.isotope-hidden)').get(),
      numChildNodes = childNodes.length,
      nodeIndex = 0,
      index;

    for (var i = 0; i < numChildNodes; i++) {
      if (childNodes[i].nodeType !== 1) {
        continue;
      }

      if (childNodes[i] === clickedListItem) {
        index = nodeIndex;
        break;
      }
      nodeIndex++;
    }

    if (index >= 0) {
      // open PhotoSwipe if valid index found
      openPhotoSwipe(index, clickedGallery);
    }
    return false;
  };

  // parse picture index and gallery index from URL (#&pid=1&gid=2)
  var photoswipeParseHash = function() {
    var hash = window.location.hash.substring(1),
      params = {};

    if (hash.length < 5) {
      return params;
    }

    var vars = hash.split('&');
    for (var i = 0; i < vars.length; i++) {
      if (!vars[i]) {
        continue;
      }
      var pair = vars[i].split('=');
      if (pair.length < 2) {
        continue;
      }
      params[pair[0]] = pair[1];
    }

    if (params.gid) {
      params.gid = parseInt(params.gid, 10);
    }

    return params;
  };

  var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
    var pswpElement = document.querySelectorAll('.pswp')[0],
      gallery,
      options,
      items;
    items = parseThumbnailElements(galleryElement);

    // define options (if needed)
    options = {
      
      closeOnScroll: false,
      
      // define gallery index (for URL)
      galleryUID: galleryElement.getAttribute('data-pswp-uid'),

      /*getThumbBoundsFn: function(index) {
        // See Options -> getThumbBoundsFn section of documentation for more info
        var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
          pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
          rect = thumbnail.getBoundingClientRect();

        return {
          x: rect.left,
          y: rect.top + pageYScroll,
          w: rect.width
        };
      }*/

    };

    // PhotoSwipe opened from URL
    if (fromURL) {
      if (options.galleryPIDs) {
        // parse real index when custom PIDs are used
        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
        for (var j = 0; j < items.length; j++) {
          if (items[j].pid == index) {
            options.index = j;
            break;
          }
        }
      } else {
        // in URL indexes start from 1
        options.index = parseInt(index, 10) - 1;
      }
    } else {
      options.index = parseInt(index, 10);
    }

    // exit if index not found
    if (isNaN(options.index)) {
      return;
    }

    if (disableAnimation) {
      options.showAnimationDuration = 0;
    }

    // Pass data to PhotoSwipe and initialize it
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
    gallery.listen('beforeChange', function() {
      var currItem = jQuery(gallery.currItem.container);
      jQuery('.pswp__video').removeClass('active');
      jQuery('.pswp__caption .pswp__caption__center').removeClass('active');
      var currItemIframe = currItem.find('.pswp__video').addClass('active');
      jQuery('.pswp__video').each(function() {
        if (!jQuery(this).hasClass('active')) {
          jQuery(this).attr('src', jQuery(this).attr('src'));
        }
      });
    });

    gallery.listen('close', function() {
      jQuery('.pswp__video').each(function() {
        jQuery(this).attr('src', jQuery(this).attr('src'));
      });
    });

  };

  // loop through all gallery elements and bind events
  var galleryElements = document.querySelectorAll(gallerySelector);

  for (var i = 0, l = galleryElements.length; i < l; i++) {
    galleryElements[i].setAttribute('data-pswp-uid', i + 1);
    galleryElements[i].onclick = onThumbnailsClick;
  }

  // Parse URL and open gallery if it contains #&pid=3&gid=1
  var hashData = photoswipeParseHash();
  if (hashData.pid && hashData.gid) {
    openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
  }

};

// execute above function

initPhotoSwipeFromDOM('.woocommerce-product-gallery');