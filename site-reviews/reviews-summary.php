<?php defined('ABSPATH') || die; ?>

<div class="glsr-summary-wrap summary-wrap-main">
    <div class="{{ class }}">
        <div class="rating-section">
            <span class="rating-section__rating-number">{{ rating }}</span>
            <span class="rating-section__rating-star-text">
                {{ stars }}
                {{ text }}
            </span>
        </div>
        <div class="percentage-section">
            {{ percentages }}
        </div>

    </div>
</div>