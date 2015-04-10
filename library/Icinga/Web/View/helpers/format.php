<?php
/* Icinga Web 2 | (c) 2013-2015 Icinga Development Team | GPLv2+ */

namespace Icinga\Web\View;

use Icinga\Web\Url;
use Icinga\Util\Format;

$this->addHelperFunction('format', function () {
    return Format::getInstance();
});

$this->addHelperFunction('timeAgo', function ($timestamp) {
    return sprintf(
        '<span class="time-ago" title="%s">%s</span>',
        date('Y-m-d H:i:s', $timestamp), // TODO: internationalized format
        Format::timeAgo($timestamp)
    );
});

$this->addHelperFunction('timeSince', function ($timestamp) {
    return sprintf(
        '<span class="time-since" title="%s">%s</span>',
        date('Y-m-d H:i:s', $timestamp), // TODO: internationalized format
        Format::timeSince($timestamp)
    );
});

$this->addHelperFunction('timeUntil', function ($timestamp) {
    if (! $timestamp) return '';
    return sprintf(
        '<span class="time-until" title="%s">%s</span>',
        date('Y-m-d H:i:s', $timestamp), // TODO: internationalized format
        Format::timeUntil($timestamp)
    );
});

$this->addHelperFunction('prefixedTimeSince', function ($timestamp, $ucfirst = false) {
    return sprintf(
        '<span class="timesince" title="%s">%s</span>',
        date('Y-m-d H:i:s', $timestamp), // TODO: internationalized format
        Format::prefixedTimeSince($timestamp, $ucfirst)
    );
});

$this->addHelperFunction('prefixedTimeUntil', function ($timestamp, $ucfirst = false) {
    if (! $timestamp) return '';
    return sprintf(
        '<span class="timeuntil" title="%s">%s</span>',
        date('Y-m-d H:i:s', $timestamp), // TODO: internationalized format
        Format::prefixedTimeUntil($timestamp, $ucfirst)
    );
});

$this->addHelperFunction('dateTimeRenderer', function ($dateTimeOrTimestamp, $future = false) {
    return DateTimeRenderer::create($dateTimeOrTimestamp, $future);
});
