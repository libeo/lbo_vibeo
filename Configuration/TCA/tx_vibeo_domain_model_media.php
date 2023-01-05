<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,

        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,subtitle,author,description,path,url,image,track,',
        'iconfile' => 'EXT:lbo_vibeo/Resources/Public/Icons/vibeo.svg'

    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, subtitle, author, description, path, url, image, track,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_vibeo_domain_model_media',
                'foreign_table_where' => 'AND {#tx_vibeo_domain_model_media}.{#pid}=###CURRENT_PID### AND {#tx_vibeo_domain_model_media}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'renderType' => 'inputDateTime', 'checkbox' => 0,
                'default' => 0,
            ),
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'renderType' => 'inputDateTime', 'checkbox' => 0,
                'default' => 0,
            ),
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'subtitle' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'author' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.author',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
            ),
        ],
        'path' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.path',
            'config' => [
                'type' => 'input',
                'size' => '50',
                'max' => '256',
                'renderType' => 'inputLink',
                'softref' => 'typolink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'mail,page,spec,url,folder,telephone',
                            'blindLinkFields' => 'class,params,target,title',
                            'allowedExtensions' => 'MP4, WEBM, OGG, MPEG, M4V, OGV, MOV, RTMP, AAC, MP1, MP2, MP3, MPG, M4A, OGA, WAV, FLV, WMV',
                        ],
                    ],
                ],
            ],
        ],
        'url' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'image' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.image',
            'config' => [
                'type' => 'input',
                'size' => '50',
                'max' => '256',
                'renderType' => 'inputLink',
                'softref' => 'typolink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'mail,page,spec,url,folder,telephone',
                            'blindLinkFields' => 'class,params,target,title',
                            'allowedExtensions' => 'JPG,JPEG,PNG,BMP,GIF',
                        ],
                    ],
                ],
            ],
        ],
        'track' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lbo_vibeo/Resources/Private/Language/locallang_db.xlf:tx_vibeo_domain_model_media.track',
            'config' => [
                'type' => 'input',
                'size' => '50',
                'max' => '256',
                'renderType' => 'inputLink',
                'softref' => 'typolink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'mail,page,spec,url,folder,telephone',
                            'blindLinkFields' => 'class,params,target,title',
                            'allowedExtensions' => 'VTT, TTML, SRT, TXT, CSV, XML',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
