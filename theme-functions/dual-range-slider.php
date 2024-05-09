<?php

/**
 * wt_dual_range_filter
 *
 * @param  number $min
 * @param  number $max
 * @return string
 * 
 * ref: @https://medium.com/@predragdavidovic10/native-dual-range-slider-html-css-javascript-91e778134816
 */
function wt_dual_range_filter($min = 0, $max = 100)
{
    $output = '';
    $output .= '
    <div class="range_container">
        <div class="sliders_control">
            <input id="fromSlider" type="range" value="' . $min . '" min="' . $min . '" max="' . $max . '"/>
            <input id="toSlider" type="range" value="' . $max . '" min="' . $min . '" max="' . $max . '"/>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="form_control_container__time form-label">Min</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input class="form_control_container__time__input form-control" type="number" id="fromInput" name="min-price" value="' . $min . '"/>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form_control_container__time form-label">Max</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input class="form_control_container__time__input form-control" type="number" id="toInput" name="max-price" value="' . $max . '"/>
                </div>
            </div>
        </div>
    </div>';
    return $output;
}
