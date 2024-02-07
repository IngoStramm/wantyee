<?php

/**
 * Calculates classes for the main <html> element.
 *
 * @return void
 */
function wt_the_html_classes()
{
    /**
     * Filters the classes for the main <html> element.
     *
     * @param string The list of classes. Default empty string.
     */
    $classes = apply_filters('wt_html_classes', '');
    if (!$classes) {
        return;
    }
    echo 'class="' . esc_attr($classes) . '"';
}
