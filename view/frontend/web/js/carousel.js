define([
    'jquery'
], function($)
{
    'use strict';

    $.widget('idealcode.carousel', {
        options: {
            navigation: false
        },

        _create: function() {
            var self = this,
                navigation = {
                    previous: {},
                    next: {}
                };

            self.carousel = {
                node: self.element,
                items: self.element.children('.item'),
                current: {},
                navigation: {}
            };

            self.carousel.node.removeClass('loading');

            // if slides
            if (self.carousel.items.length > 0) {
                self.carousel.current = self.carousel.items.first().addClass('current');
            }

            // if show navigation and slides over 1
            if ((self.options.navigation === true) && (self.carousel.items.length > 1)) {
                self.carousel.navigation = $('<div>').addClass('nav content').appendTo(self.carousel.node);

                navigation.previous = $('<a>')
                    .attr('href', '#')
                    .addClass('prev')
                    .appendTo(self.carousel.navigation)
                    .on('click', function($e) {
                        $e.preventDefault();
                        self._prevElement(self.carousel.current);
                    });

                navigation.next = $('<a>')
                    .attr('href', '#')
                    .addClass('next')
                    .appendTo(self.carousel.navigation)
                    .on('click', function($e) {
                        $e.preventDefault();
                        self._nextElement(self.carousel.current);
                    });
            }
        },

        /**
         * Select next element slide
         * @param $item jQuery object
         * @private
         */
        _nextElement: function($item) {
            var $next,
                $new,
                self = this;

            $next = $item.next('.item');

            if ($next.length > 0) {
                $new = $next;
            } else {
                $new = self.carousel.items.first();
            }

            self._setCurrent($new, $item);
        },

        /**
         * Select preview element slide
         * @param $item jQuery object
         * @private
         */
        _prevElement: function($item) {
            var $prev,
                $new,
                self = this;

            $prev = $item.prev('.item');

            if ($prev.length > 0) {
                $new = $prev;
            } else {
                $new = self.carousel.items.last();
            }

            self._setCurrent($new, $item);
        },

        /**
         * Set current element
         * @param $new jQuery object
         * @param $old jQuery object
         * @private
         */
        _setCurrent: function($new, $old) {
            var self = this;

            $old.removeClass('current');

            self.carousel.current = $new.addClass('current');
        }
    });

    return $.idealcode.carousel;
});
