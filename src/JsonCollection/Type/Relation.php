<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection\Type;

/**
 * Class Relation
 * @package JsonCollection\Type
 * @link https://www.iana.org/assignments/link-relations/link-relations.xml
 */
final class Relation
{
    /**
     *
     */
    private function __construct()
    {
    }

    const ABOUT               = 'about';
    const ALTERNATE           = 'alternate';
    const APPENDIX            = 'appendix';
    const ARCHIVES            = 'archives';
    const AUTHOR              = 'author';
    const BOOKMARK            = 'bookmark';
    const CANONICAL           = 'canonical';
    const CHAPTER             = 'chapter';
    const COLLECTION          = 'collection';
    const CONTENTS            = 'contents';
    const COPYRIGHT           = 'copyright';
    const CREATE_FORM         = 'create-form';
    const CURRENT             = 'current';
    const DESCRIBEDBY         = 'describedby';
    const DESCRIBES           = 'describes';
    const DISCLOSURE          = 'disclosure';
    const DUPLICATE           = 'duplicate';
    const EDIT                = 'edit';
    const EDIT_FORM           = 'edit-form';
    const EDIT_MEDIA          = 'edit-media';
    const ENCLOSURE           = 'enclosure';
    const FIRST               = 'first';
    const GLOSSARY            = 'glossary';
    const HELP                = 'help';
    const HOSTS               = 'hosts';
    const HUB                 = 'hub';
    const ICON                = 'icon';
    const INDEX               = 'index';
    const ITEM                = 'item';
    const LAST                = 'last';
    const LATEST_VERSION      = 'latest-version';
    const LICENSE             = 'license';
    const LRDD                = 'lrdd';
    const MEMENTO             = 'memento';
    const MONITOR             = 'monitor';
    const MONITOR_GROUP       = 'monitor-group';
    const NEXT                = 'next';
    const NEXT_ARCHIVE        = 'next-archive';
    const NOFOLLOW            = 'nofollow';
    const NOREFERRER          = 'noreferrer';
    const ORIGINAL            = 'original';
    const PAYMENT             = 'payment';
    const PREDECESSOR_VERSION = 'predecessor-version';
    const PREFETCH            = 'prefetch';
    const PREV                = 'prev';
    const PREVIEW             = 'preview';
    const PREVIOUS            = 'previous';
    const PREV_ARCHIVE        = 'prev-archive';
    const PRIVACY_POLICY      = 'privacy-policy';
    const PROFILE             = 'profile';
    const RELATED             = 'related';
    const REPLIES             = 'replies';
    const SEARCH              = 'search';
    const SECTION             = 'section';
    const SELF                = 'self';
    const SERVICE             = 'service';
    const START               = 'start';
    const STYLESHEET          = 'stylesheet';
    const SUBSECTION          = 'subsection';
    const SUCCESSOR_VERSION   = 'successor-version';
    const TAG                 = 'tag';
    const TERMS_OF_SERVICE    = 'terms-of-service';
    const TIMEGATE            = 'timegate';
    const TIMEMAP             = 'timemap';
    const TYPE                = 'type';
    const UP                  = 'up';
    const VERSION_HISTORY     = 'version-history';
    const VIA                 = 'via';
    const WORKING_COPY        = 'working-copy';
    const WORKING_COPY_OF     = 'working-copy-of';
}
