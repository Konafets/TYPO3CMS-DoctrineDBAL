<?php

$schema = new Doctrine\DBAL\Schema\Schema();

// cache_typo3temp_log
$cacheTypo3tempLog = $schema->createTable('cache_typo3temp_log');
$cacheTypo3tempLog->addColumn('md5hash', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$cacheTypo3tempLog->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$cacheTypo3tempLog->addColumn('filename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$cacheTypo3tempLog->addColumn('orig_filename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$cacheTypo3tempLog->setPrimaryKey(array('md5hash'));


// cache_md5params
$cacheMd5params = $schema->createTable('cache_md5params');
$cacheMd5params->addColumn('md5hash', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$cacheMd5params->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$cacheMd5params->addColumn('type', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$cacheMd5params->addColumn('params', 'text', array('length' => 65535));
$cacheMd5params->setPrimaryKey(array('md5hash'));


// cache_treelist
$cacheTreelist = $schema->createTable('cache_treelist');
$cacheTreelist->addColumn('md5hash', 'string', array('length' => 32, 'fixed' => TRUE, 'default' => '', 'notnull' => TRUE));
$cacheTreelist->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$cacheTreelist->addColumn('treelist', 'text', array('length' => 65535));
$cacheTreelist->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$cacheTreelist->addColumn('expires', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$cacheTreelist->setPrimaryKey(array('md5hash'));


// fe_groups
$feGroups = $schema->createTable('fe_groups');
$feGroups->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$feGroups->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('title', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feGroups->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('lockToDomain', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feGroups->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$feGroups->addColumn('description', 'text', array('length' => 65535));
$feGroups->addColumn('subgroup', 'text', array('length' => 255));
$feGroups->addColumn('TSconfig', 'text', array('length' => 65535));
$feGroups->setPrimaryKey(array('uid'));
$feGroups->addIndex(array('pid'), 'fe_groups_pid_idx');


// fe_session_data
$feSessionData = $schema->createTable('fe_session_data');
$feSessionData->addColumn('hash', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$feSessionData->addColumn('content', 'blob', array('length' => 16777215));
$feSessionData->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feSessionData->setPrimaryKey(array('hash'));
$feSessionData->addIndex(array('tstamp'), 'fe_session_data_tstamp');


// fe_sessions
$feSessions = $schema->createTable('fe_sessions');
$feSessions->addColumn('ses_id', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$feSessions->addColumn('ses_name', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$feSessions->addColumn('ses_iplock', 'string', array('length' => 39, 'default' => '', 'notnull' => TRUE));
$feSessions->addColumn('ses_hashlock', 'integer', array('default' => '0', 'notnull' => TRUE));
$feSessions->addColumn('ses_userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feSessions->addColumn('ses_tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feSessions->addColumn('ses_data', 'blob', array('length' => 65535));
$feSessions->addColumn('ses_permanent', 'boolean', array('default' => '0', 'notnull' => TRUE));
$feSessions->setPrimaryKey(array('ses_id','ses_name'));
$feSessions->addIndex(array('ses_tstamp'), 'fe_sessions_ses_tstamp');


// fe_users
$feUsers = $schema->createTable('fe_users');
$feUsers->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$feUsers->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('username', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('password', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('usergroup', 'text', array('length' => 255));
$feUsers->addColumn('disable', 'boolean', array('default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('name', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('first_name', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('middle_name', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('last_name', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('address', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('telephone', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('fax', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('email', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('lockToDomain', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('uc', 'blob', array('length' => 65535));
$feUsers->addColumn('title', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('zip', 'string', array('length' => 10, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('city', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('country', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('www', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('company', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$feUsers->addColumn('image', 'text', array('length' => 255));
$feUsers->addColumn('TSconfig', 'text', array('length' => 65535));
$feUsers->addColumn('fe_cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('lastlogin', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->addColumn('is_online', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$feUsers->setPrimaryKey(array('uid'));
$feUsers->addIndex(array('pid', 'username'), 'fe_users_idx');
$feUsers->addIndex(array('username'), 'fe_users_username');
$feUsers->addIndex(array('is_online'), 'fe_users_is_online');


// pages_language_overlay
$pagesLanguageOverlay = $schema->createTable('pages_language_overlay');
$pagesLanguageOverlay->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('doktype', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_label', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_state', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('sys_language_uid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('subtitle', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('nav_title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('media', 'text', array('length' => 65535));
$pagesLanguageOverlay->addColumn('keywords', 'text', array('length' => 65535));
$pagesLanguageOverlay->addColumn('description', 'text', array('length' => 65535));
$pagesLanguageOverlay->addColumn('abstract', 'text', array('length' => 65535));
$pagesLanguageOverlay->addColumn('author', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('author_email', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('tx_impexp_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('l18n_diffsource', 'blob', array('length' => 16777215));
$pagesLanguageOverlay->addColumn('url', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('urltype', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('shortcut', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->addColumn('shortcut_mode', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pagesLanguageOverlay->setPrimaryKey(array('uid'));
$pagesLanguageOverlay->addIndex(array('t3ver_oid', 't3ver_wsid'), 'pages_language_overlay_t3ver_oid');
$pagesLanguageOverlay->addIndex(array('pid', 'sys_language_uid'), 'pages_language_overlay_idx');


// sys_domain
$sysDomain = $schema->createTable('sys_domain');
$sysDomain->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$sysDomain->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('domainName', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$sysDomain->addColumn('redirectTo', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysDomain->addColumn('redirectHttpStatusCode', 'integer', array('unsigned' => TRUE, 'default' => '301', 'notnull' => TRUE));
$sysDomain->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('prepend_params', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysDomain->addColumn('forced', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysDomain->setPrimaryKey(array('uid'));
$sysDomain->addIndex(array('pid'), 'sys_domain_pid_idx');
$sysDomain->addIndex(array('redirectTo', 'hidden'), 'sys_domain_getSysDomain');


// sys_template
$sysTemplate = $schema->createTable('sys_template');
$sysTemplate->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$sysTemplate->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_label', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_state', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysTemplate->addColumn('sitetitle', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysTemplate->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('root', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('clear', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('include_static_file', 'text', array('length' => 65535));
$sysTemplate->addColumn('constants', 'text', array('length' => 65535));
$sysTemplate->addColumn('config', 'text', array('length' => 65535));
$sysTemplate->addColumn('nextLevel', 'string', array('length' => 5, 'default' => '', 'notnull' => TRUE));
$sysTemplate->addColumn('description', 'text', array('length' => 65535));
$sysTemplate->addColumn('basedOn', 'text', array('length' => 255));
$sysTemplate->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('includeStaticAfterBasedOn', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('static_file_mode', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysTemplate->addColumn('tx_impexp_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysTemplate->setPrimaryKey(array('uid'));
$sysTemplate->addIndex(array('t3ver_oid', 't3ver_wsid'), 'sys_template_t3ver_oid');
$sysTemplate->addIndex(array('pid', 'deleted', 'hidden', 'sorting'), 'sys_template_idx');


// tt_content
$ttContent = $schema->createTable('tt_content');
$ttContent->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$ttContent->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_label', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_state', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('CType', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('header', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('header_position', 'string', array('length' => 6, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('bodytext', 'text', array('length' => 16777215));
// Even though we're using FAL and an IRRE field for images
// now, it needs to stay "text" for the migration to work
$ttContent->addColumn('image', 'text', array('length' => 65535));
$ttContent->addColumn('imagewidth', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('imageorient', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('imagecaption', 'text', array('length' => 65535));
$ttContent->addColumn('imagecols', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('imageborder', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('media', 'text', array('length' => 65535));
$ttContent->addColumn('layout', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('cols', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('records', 'text', array('length' => 65535));
$ttContent->addColumn('pages', 'text', array('length' => 255));
$ttContent->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('colPos', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('subheader', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('spaceBefore', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('spaceAfter', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('fe_group', 'string', array('length' => 100, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('header_link', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('imagecaption_position', 'string', array('length' => 6, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('image_link', 'text', array('length' => 65535));
$ttContent->addColumn('image_zoom', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('image_noRows', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('image_effects', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('image_compression', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('altText', 'text', array('length' => 65535));
$ttContent->addColumn('titleText', 'text', array('length' => 65535));
$ttContent->addColumn('longdescURL', 'text', array('length' => 65535));
$ttContent->addColumn('header_layout', 'string', array('length' => 30, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('menu_type', 'string', array('length' => 30, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('list_type', 'string', array('length' => 255, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('table_border', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('table_cellspacing', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('table_cellpadding', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('table_bgColor', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('select_key', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('sectionIndex', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('linkToTop', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('file_collections', 'text', array('length' => 65535));
$ttContent->addColumn('filelink_size', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('filelink_sorting', 'text', array('length' => 255, 'notnull' => TRUE));
$ttContent->addColumn('target', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('section_frame', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('date', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('multimedia', 'text', array('length' => 255));
$ttContent->addColumn('image_frames', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('recursive', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('imageheight', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('rte_enabled', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('tx_impexp_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('pi_flexform', 'text', array('length' => 16777215));
$ttContent->addColumn('accessibility_title', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('accessibility_bypass', 'boolean', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('accessibility_bypass_text', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$ttContent->addColumn('l18n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
$ttContent->addColumn('l18n_diffsource', 'blob', array('length' => 16777215));
$ttContent->addColumn('selected_categories', 'text', array('length' => 65535));
$ttContent->addColumn('category_field', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$ttContent->setPrimaryKey(array('uid'));
$ttContent->addIndex(array('t3ver_oid', 't3ver_wsid'), 'tt_conetent_t3ver_oid');
$ttContent->addIndex(array('pid', 'sorting'), 'tt_content_idx'); 
$ttContent->addIndex(array('l18n_parent', 'sys_language_uid'), 'tt_content_language');


// backend_layout
$backendLayout = $schema->createTable('backend_layout');
$backendLayout->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$backendLayout->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_label', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_state', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$backendLayout->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$backendLayout->addColumn('description', 'text', array('length' => 65535, 'notnull' => TRUE));
$backendLayout->addColumn('config', 'text', array('length' => 65535, 'notnull' => TRUE));
$backendLayout->addColumn('icon', 'text', array('length' => 65535, 'notnull' => TRUE));
$backendLayout->setPrimaryKey(array('uid'));
$backendLayout->addIndex(array('pid'), 'backend_layout_idx');
$backendLayout->addIndex(array('t3ver_oid', 't3ver_wsid'), 'backend_layout_t3ver_oid');

return $schema;
