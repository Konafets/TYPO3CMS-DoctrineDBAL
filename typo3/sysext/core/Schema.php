<?php
$schema = new \Doctrine\DBAL\Schema\Schema();

// be_groups
$beGroups = $schema->createTable('be_groups');
$beGroups->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$beGroups->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beGroups->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beGroups->addColumn('title', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$beGroups->addColumn('non_exclude_fields', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('explicit_allowdeny', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('allowed_languages', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$beGroups->addColumn('custom_options', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('db_mountpoints', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('pagetypes_select', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$beGroups->addColumn('tables_select', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('tables_modify', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beGroups->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beGroups->addColumn('groupMods', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('file_mountpoints', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('file_permissions', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('hidden', 'boolean', array('notnull' => TRUE, 'default' => '0'));
$beGroups->addColumn('inc_access_lists', 'boolean', array('notnull' => TRUE, 'default' => '0'));
$beGroups->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('lockToDomain', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$beGroups->addColumn('deleted', 'boolean', array('notnull' => TRUE, 'default' => '0'));
$beGroups->addColumn('TSconfig', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('subgroup', 'text', array('length' => 65535, 'notnull' => FALSE));
$beGroups->addColumn('hide_in_lists', 'boolean', array('notnull' => TRUE, 'default' => '0'));
$beGroups->addColumn('workspace_perms', 'boolean', array('notnull' => TRUE, 'default' => '1'));
$beGroups->addColumn('category_perms', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$beGroups->setPrimaryKey(array('uid'));
$beGroups->addIndex(array('pid'));


// be_sessions
$beSessions = $schema->createTable('be_sessions');
$beSessions->addColumn('ses_id', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$beSessions->addColumn('ses_name', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$beSessions->addColumn('ses_iplock', 'string', array('length' => 39, 'default' => '', 'notnull' => TRUE));
$beSessions->addColumn('ses_hashlock', 'integer', array('default' => '0', 'notnull' => TRUE));
$beSessions->addColumn('ses_userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beSessions->addColumn('ses_tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', '' => TRUE));
// longtext
$beSessions->addColumn('ses_data', 'text', array('notnull' => FALSE));
$beSessions->addColumn('ses_backuserid', 'integer', array('notnull' => TRUE, 'default' => '0'));
$beSessions->setPrimaryKey(array('ses_id', 'ses_name'));
$beSessions->addIndex(array('ses_tstamp'), 'be_session_ses_tstamp');


// be_users
$beUsers = $schema->createTable('be_users');
$beUsers->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$beUsers->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('username', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$beUsers->addColumn('password', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$beUsers->addColumn('admin', 'boolean', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('usergroup', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$beUsers->addColumn('disable', 'boolean', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
// char(2)
$beUsers->addColumn('lang', 'string', array('length' => 2, 'default' => '', 'notnull' => TRUE, 'fixed' => TRUE));
$beUsers->addColumn('email', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
// text
$beUsers->addColumn('db_mountpoints', 'text', array('length' => 65535, 'notnull' => FALSE));
$beUsers->addColumn('options', 'boolean', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('realName', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
// text
$beUsers->addColumn('userMods', 'text', array('length' => 65535, 'notnull' => FALSE));
$beUsers->addColumn('allowed_languages', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
// mediumtext
$beUsers->addColumn('uc', 'text', array('length' => 16777215, 'notnull' => FALSE));
// text
$beUsers->addColumn('file_mountpoints', 'text', array('length' => 65535, 'notnull' => FALSE));
// text
$beUsers->addColumn('file_permissions', 'text', array('length' => 65535, 'notnull' => FALSE));
$beUsers->addColumn('workspace_perms', 'boolean', array('default' => '1', 'notnull' => TRUE));
$beUsers->addColumn('lockToDomain', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$beUsers->addColumn('disableIPlock', 'boolean', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
// text
$beUsers->addColumn('TSconfig', 'text', array('length' => 65535, 'notnull' => FALSE));
$beUsers->addColumn('lastlogin', 'integer', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('createdByAction', 'integer', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('usergroup_cached_list', 'text', array('length' => 65535, 'notnull' => FALSE));
$beUsers->addColumn('workspace_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$beUsers->addColumn('workspace_preview', 'boolean', array('default' => '1', 'notnull' => TRUE));
$beUsers->addColumn('category_perms', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$beUsers->setPrimaryKey(array('uid'));
$beUsers->addIndex(array('pid'), 'be_users_pid_idx');
$beUsers->addIndex(array('username'), 'be_users_username');


// cache_imagesizes
$cacheImagesizes = $schema->createTable('cache_imagesizes');
$cacheImagesizes->addColumn('md5hash', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$cacheImagesizes->addColumn('md5filename', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$cacheImagesizes->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$cacheImagesizes->addColumn('filename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
// mediuminteger
$cacheImagesizes->addColumn('imagewidth', 'integer', array('length' => 16777215, 'unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
// mediuminteger
$cacheImagesizes->addColumn('imageheight', 'integer', array('length' => 16777215, 'unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$cacheImagesizes->setPrimaryKey(array('md5filename'));


// pages
$pages = $schema->createTable('pages');
$pages->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$pages->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_label', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('perms_userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('perms_groupid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('perms_user', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('perms_group', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('perms_everybody', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('editlock', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('doktype', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
// text
$pages->addColumn('TSconfig', 'text', array('length' => 65535, 'notnull' => FALSE));
$pages->addColumn('storage_pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('is_siteroot', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('php_tree_stop', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('tx_impexp_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('url', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('urltype', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('shortcut', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('shortcut_mode', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('no_cache', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('fe_group', 'string', array('length' => 100, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('subtitle', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('layout', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$pages->addColumn('url_scheme', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('target', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
// text
$pages->addColumn('media', 'text', array('length' => 65535, 'notnull' => FALSE));
$pages->addColumn('lastUpdated', 'integer', array('default' => '0', 'notnull' => TRUE));
// text
$pages->addColumn('keywords', 'text', array('length' => 65535, 'notnull' => FALSE));
$pages->addColumn('cache_timeout', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('cache_tags', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('newUntil', 'integer', array('default' => '0', 'notnull' => TRUE));
// text
$pages->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$pages->addColumn('no_search', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('SYS_LASTCHANGED', 'integer', array('default' => '0', 'notnull' => TRUE));
// text
$pages->addColumn('abstract', 'text', array('length' => 65535, 'notnull' => FALSE));
$pages->addColumn('module', 'string', array('default' => '', 'notnull' => TRUE));
$pages->addColumn('extendToSubpages', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('author', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('author_email', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('nav_title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('nav_hide', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('content_from_pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('mount_pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('mount_pid_ol', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('alias', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('l18n_cfg', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('fe_login_mode', 'boolean', array('default' => '0', 'notnull' => TRUE));
$pages->addColumn('backend_layout', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$pages->addColumn('backend_layout_next_level', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$pages->setPrimaryKey(array('uid'));
$pages->addIndex(array('t3ver_oid', 't3ver_wsid'), 'pages_t3ver_oid_idx');
$pages->addIndex(array('pid', 'deleted', 'sorting'), 'pages_idx');
$pages->addIndex(array('alias'), 'pages_alias');
$pages->addIndex(array('deleted', 'hidden', 'is_siteroot'), 'pages_determineSiteRoot');


// sys_be_shortcuts
$sysBeShortcuts = $schema->createTable('sys_be_shortcuts');
$sysBeShortcuts->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysBeShortcuts->addColumn('userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysBeShortcuts->addColumn('module_name', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
// text
$sysBeShortcuts->addColumn('url', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysBeShortcuts->addColumn('description', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysBeShortcuts->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysBeShortcuts->addColumn('sc_group', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysBeShortcuts->setPrimaryKey(array('uid'));
$sysBeShortcuts->addIndex(array('userid'), 'sys_be_shortcuts_event');


// sys_category_record_mm
$sysCategoryRecordMm = $schema->createTable('sys_category_record_mm');
$sysCategoryRecordMm->addColumn('uid_local', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategoryRecordMm->addColumn('uid_foreign', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategoryRecordMm->addColumn('tablenames', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysCategoryRecordMm->addColumn('fieldname', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysCategoryRecordMm->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategoryRecordMm->addColumn('sorting_foreign', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategoryRecordMm->addIndex(array('uid_local', 'uid_foreign'), 'sys_category_record_mm_uid_local_foreign');
$sysCategoryRecordMm->addIndex(array('uid_foreign', 'tablenames'), 'sys_category_record_mm_uid_foreign_tablenames');


// sys_category
$sysCategory = $schema->createTable('sys_category');
$sysCategory->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysCategory->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_label', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('l10n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('l10n_diffsource', 'blob', array('length' => 16777215, 'notnull' => TRUE));
$sysCategory->addColumn('title', 'text', array('length' => 255, 'notnull' => TRUE));
$sysCategory->addColumn('description', 'text', array('length' => 65535, 'notnull' => TRUE));
$sysCategory->addColumn('parent', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->addColumn('items', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCategory->setPrimaryKey(array('uid'));
$sysCategory->addIndex(array('pid'), 'sys_category_pid_idx');
$sysCategory->addIndex(array('t3ver_oid', 't3ver_wsid'), 'sys_category_t3ver_oid_idx');
$sysCategory->addIndex(array('parent'), 'sys_category_parent');
$sysCategory->addIndex(array('pid', 'deleted', 'sys_language_uid'), 'sys_category_list');


// sys_collection_entries
$sysCollectionEntries = $schema->createTable('sys_collection_entries');
$sysCollectionEntries->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysCollectionEntries->addColumn('uid_local', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollectionEntries->addColumn('uid_foreign', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollectionEntries->addColumn('tablenames', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysCollectionEntries->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollectionEntries->addIndex(array('uid_local'), 'sys_collection_entries_uid_local');
$sysCollectionEntries->addIndex(array('uid_foreign'), 'sys_collection_entries_uid_foreign');
$sysCollectionEntries->setPrimaryKey(array('uid'));


// sys_collection
$sysCollection = $schema->createTable('sys_collection');
$sysCollection->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysCollection->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_label', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('l10n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('l10n_diffsource', 'text', array('length' => 16777215, 'notnull' => FALSE));
$sysCollection->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('starttime', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('endtime', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('fe_group', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->addColumn('title', 'text', array('length' => 255, 'notnull' => FALSE));
$sysCollection->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysCollection->addColumn('type', 'string', array('length' => 32, 'default' => 'static', 'notnull' => TRUE));
$sysCollection->addColumn('table_name', 'text', array('length' => 255, 'notnull' => FALSE));
$sysCollection->addColumn('items', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysCollection->setPrimaryKey(array('uid'));
$sysCollection->addIndex(array('pid', 'deleted'), 'sys_collection_pid_idx');
$sysCollection->addIndex(array('t3ver_oid', 't3ver_wsid'), 'sys_collection_t3ver_oid_idx');


// sys_file_collection
$sysFileCollection = $schema->createTable('sys_file_collection');
$sysFileCollection->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFileCollection->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_label', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('l10n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('l10n_diffsource', 'text', array('length' => 16777215, 'notnull' => FALSE));
$sysFileCollection->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('starttime', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('endtime', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('title', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileCollection->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileCollection->addColumn('type', 'string', array('length' => 30, 'default' => 'static', 'notnull' => TRUE));
$sysFileCollection->addColumn('files', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('storage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->addColumn('folder', 'text', array('length' => 65535, 'notnull' => TRUE));
$sysFileCollection->addColumn('category', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileCollection->setPrimaryKey(array('uid'));
$sysFileCollection->addIndex(array('pid', 'deleted'), 'sys_file_collection_pid_idx');
$sysFileCollection->addIndex(array('t3ver_oid', 't3ver_wsid'), 'sys_file_collection_t3ver_oid_idx');


// sys_file_metadata
$sysFileMetadata = $schema->createTable('sys_file_metadata');
$sysFileMetadata->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFileMetadata->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('l10n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
// meduimblob
$sysFileMetadata->addColumn('l10n_diffsource', 'blob', array('length' => 16777215, 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_label', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('file', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('title', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileMetadata->addColumn('width', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('height', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileMetadata->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileMetadata->addColumn('alternative', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileMetadata->setPrimaryKey(array('uid'));
$sysFileMetadata->addIndex(array('file'), 'sys_file_metadata_file');
$sysFileMetadata->addIndex(array('t3ver_oid', 't3ver_wsid'), 'sys_file_metadata_t3ver_oid_idx');
$sysFileMetadata->addIndex(array('l10n_parent', 'sys_language_uid'), 'sys_file_metadata_fal_filelist');


// sys_filemounts
$sysFilemounts = $schema->createTable('sys_filemounts');
$sysFilemounts->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysFilemounts->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysFilemounts->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysFilemounts->addColumn('title', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysFilemounts->addColumn('path', 'string', array('length' => 120, 'default' => '', 'notnull' => TRUE));
$sysFilemounts->addColumn('base', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFilemounts->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFilemounts->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFilemounts->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysFilemounts->setPrimaryKey(array('uid'));
$sysFilemounts->addIndex(array('pid'), 'sys_filemounts_pid_idx');


// sys_file_processedfile
$sysFileProcessedfile = $schema->createTable('sys_file_processedfile');
$sysFileProcessedfile->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFileProcessedfile->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('storage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('original', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('identifier', 'string', array('length' => 512, 'default' => '', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('name', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileProcessedfile->addColumn('configuration', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileProcessedfile->addColumn('configurationsha1', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('originalfilesha1', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('task_type', 'string', array('length' => 200, 'default' => '', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('checksum', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('width', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->addColumn('height', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileProcessedfile->setPrimaryKey(array('uid'));
$sysFileProcessedfile->addIndex(array('original', 'task_type', 'configurationsha1'), 'sys_file_processedfile_combined_1');


// sys_file_reference
$sysFileReference = $schema->createTable('sys_file_reference');
$sysFileReference->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFileReference->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('cruser_id', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_oid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_wsid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_label', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_state', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_stage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3ver_move_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('t3_origuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('l10n_parent', 'integer', array('default' => '0', 'notnull' => TRUE));
// mediumblob
$sysFileReference->addColumn('l10n_diffsource', 'blob', array('length' => 16777215, 'notnull' => TRUE));
$sysFileReference->addColumn('uid_local', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('uid_foreign', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('tablenames', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$sysFileReference->addColumn('fieldname', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$sysFileReference->addColumn('sorting_foreign', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileReference->addColumn('table_local', 'string', array('length' => 64, 'default' => '', 'notnull' => TRUE));
$sysFileReference->addColumn('title', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileReference->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileReference->addColumn('alternative', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileReference->addColumn('link', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileReference->addColumn('downloadname', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileReference->setPrimaryKey(array('uid'));
$sysFileReference->addIndex(array('pid', 'deleted'), 'sys_file_reference_idx');
//$sysFileReference->addIndex(array('tablenames', 'fieldname'), 'sys_file_reference_tablenames_fieldname');
$sysFileReference->addIndex(array('deleted'), 'sys_file_reference_deleted');
$sysFileReference->addIndex(array('uid_foreign'), 'sys_file_reference_uid_foreign');


// sys_file
$sysFile = $schema->createTable('sys_file');
$sysFile->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFile->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('last_indexed', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('missing', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('storage', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('type', 'string', array('length' => 10, 'default' => '', 'notnull' => TRUE));
$sysFile->addColumn('metadata', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('identifier', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFile->addColumn('identifier_hash', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysFile->addColumn('folder_hash', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysFile->addColumn('extension', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFile->addColumn('mime_type', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFile->addColumn('name', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFile->addColumn('sha1', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFile->addColumn('size', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('creation_date', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->addColumn('modification_date', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFile->setPrimaryKey(array('uid'));
$sysFile->addIndex(array('storage', 'identifier_hash'), 'sys_file_sel01');
$sysFile->addIndex(array('storage', 'folder_hash'), 'sys_file_folder');
$sysFile->addIndex(array('tstamp'), 'sys_file_tstamp');
$sysFile->addIndex(array('last_indexed'), 'sys_file_lastindex');
//$sysFile->addIndex(array('sha1'), 'sys_file_sha1');


// sys_file_storage
$sysFileStorage = $schema->createTable('sys_file_storage');
$sysFileStorage->addColumn('uid', 'integer', array('notnull' => TRUE, 'autoincrement' => TRUE));
$sysFileStorage->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('name', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
// text
$sysFileStorage->addColumn('description', 'text', array('length' => 65535, 'notnull' => FALSE));
// tinytext
$sysFileStorage->addColumn('driver', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileStorage->addColumn('configuration', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysFileStorage->addColumn('is_default', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('is_browsable', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('is_public', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('is_writable', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysFileStorage->addColumn('is_online', 'boolean', array('default' => '1', 'notnull' => TRUE));
$sysFileStorage->addColumn('processingfolder', 'text', array('length' => 255, 'notnull' => FALSE));
$sysFileStorage->setPrimaryKey(array('uid'));
$sysFileStorage->addIndex(array('pid', 'deleted'), 'sys_file_storage_idx');
$sysFileStorage->addIndex(array('deleted', 'hidden'), 'sys_file_storage_deleted_hidden');


// sys_history
$sysHistory = $schema->createTable('sys_history');
$sysHistory->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysHistory->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysHistory->addColumn('sys_log_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysHistory->addColumn('history_data', 'text', array('length' => 16777215, 'notnull' => FALSE));
$sysHistory->addColumn('fieldlist', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysHistory->addColumn('recuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysHistory->addColumn('tablename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysHistory->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysHistory->addColumn('history_files', 'text', array('length' => 16777215, 'notnull' => FALSE));
$sysHistory->addColumn('snapshot', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysHistory->setPrimaryKey(array('uid'));
$sysHistory->addIndex(array('pid'), 'sys_history_pid_idx');
$sysHistory->addIndex(array('tablename', 'recuid'), 'sys_history_recordident_1');
$sysHistory->addIndex(array('tablename', 'tstamp'), 'sys_history_recordident_2');
$sysHistory->addIndex(array('sys_log_uid'), 'sys_history_sys_log_uid');


// sys_language
$sysLanguage = $schema->createTable('sys_language');
$sysLanguage->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysLanguage->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLanguage->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLanguage->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLanguage->addColumn('title', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$sysLanguage->addColumn('flag', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$sysLanguage->addColumn('static_lang_isocode', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLanguage->setPrimaryKey(array('uid'));
$sysLanguage->addIndex(array('pid'), 'sys_language_pid_idx');


// sys_lockedrecords
$sysLockedrecords = $schema->createTable('sys_lockedrecords');
$sysLockedrecords->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysLockedrecords->addColumn('userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLockedrecords->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLockedrecords->addColumn('record_table', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysLockedrecords->addColumn('record_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysLockedrecords->addColumn('record_pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysLockedrecords->addColumn('username', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$sysLockedrecords->addColumn('feuserid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLockedrecords->setPrimaryKey(array('uid'));
$sysLockedrecords->addIndex(array('userid', 'tstamp'), 'sys_lockedrecords_event');


// sys_log
$sysLog = $schema->createTable('sys_log');
$sysLog->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysLog->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('userid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('action', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('recuid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('tablename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysLog->addColumn('recpid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('error', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('details', 'text', array('length' => 65535, 'notnull' => TRUE));
$sysLog->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('type', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('details_nr', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('IP', 'string', array('length' => 39, 'default' => '', 'notnull' => TRUE));
$sysLog->addColumn('log_data', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysLog->addColumn('event_pid', 'integer', array('default' => '-1', 'notnull' => TRUE));
$sysLog->addColumn('workspace', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('NEWid', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$sysLog->addColumn('request_id', 'string', array('length' => 13, 'default' => '', 'notnull' => TRUE));
$sysLog->addColumn('time_micro', 'float', array('default' => '0', 'notnull'));
$sysLog->addColumn('component', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysLog->addColumn('level', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysLog->addColumn('message', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysLog->addColumn('data', 'text', array('length' => 65535, 'notnull' => FALSE));
$sysLog->setPrimaryKey(array('uid'));
$sysLog->addIndex(array('pid'), 'sys_log_pid_idx');
$sysLog->addIndex(array('userid', 'event_pid'), 'sys_log_event');
$sysLog->addIndex(array('recuid', 'uid'), 'sys_log_recuidIdx');
$sysLog->addIndex(array('type', 'action', 'tstamp'), 'sys_log_user_auth');
$sysLog->addIndex(array('request_id'), 'sys_log_request');


// sys_news
$sysNews = $schema->createTable('sys_news');
$sysNews->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysNews->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNews->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
// mediumtext
$sysNews->addColumn('content', 'text', array('length' => 16777215, 'notnull' => FALSE));
$sysNews->setPrimaryKey(array('uid'));
$sysNews->addIndex(array('pid'), 'sys_news_pid_idx');


// sys_refindex
$sysRefindex = $schema->createTable('sys_refindex');
$sysRefindex->addColumn('hash', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('tablename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('recuid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysRefindex->addColumn('field', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('flexpointer', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('softref_key', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('softref_id', 'string', array('length' => 40, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysRefindex->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysRefindex->addColumn('ref_table', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysRefindex->addColumn('ref_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysRefindex->addColumn('ref_string', 'string', array('length' => 200, 'default' => '', 'notnull' => TRUE));
$sysRefindex->setPrimaryKey(array('hash'));
$sysRefindex->addIndex(array('tablename', 'recuid'), 'sys_refindex_lookup_rec');
$sysRefindex->addIndex(array('ref_table', 'ref_uid'), 'sys_refinex_lookup_uid');
$sysRefindex->addIndex(array('ref_string'), 'sys_refindex_lookup_string');


// sys_registry
$sysRegistry = $schema->createTable('sys_registry');
$sysRegistry->addColumn('uid', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'autoincrement' => TRUE));
$sysRegistry->addColumn('entry_namespace', 'string', array('length' => 128, 'default' => '', 'notnull' => TRUE));
$sysRegistry->addColumn('entry_key', 'string', array('length' => 128, 'default' => '', 'notnull' => TRUE));
// text
$sysRegistry->addColumn('entry_value', 'blob', array('length' => 65535));
$sysRegistry->setPrimaryKey(array('uid'));
$sysRegistry->addUniqueIndex(array('entry_namespace', 'entry_key'), 'entry_identifier');


return $schema;
