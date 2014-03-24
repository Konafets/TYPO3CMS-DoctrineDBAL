<?php

$schema = new Doctrine\DBAL\Schema\Schema();


// index_phash
$indexPhash = $schema->createTable('index_phash');
$indexPhash->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('phash_grouping', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('cHashParams', 'blob', array('length' => 65535));
$indexPhash->addColumn('data_filename', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('data_page_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('data_page_reg1', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('data_page_type', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('data_page_mp', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('gr_list', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('item_type', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('item_title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('item_description', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexPhash->addColumn('item_mtime', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('item_size', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('contentHash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('parsetime', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('sys_language_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('item_crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('externalUrl', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('recordUid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('freeIndexUid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->addColumn('freeIndexSetId', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexPhash->setPrimaryKey(array('phash'));
$indexPhash->addIndex(array('phash_grouping'), 'phash_grouping');
$indexPhash->addIndex(array('freeIndexUid'), 'freeIndexUid');


// index_fulltext
$indexFulltext = $schema->createTable('index_fulltext');
$indexFulltext->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexFulltext->addColumn('fulltextdata', 'text', array('length' => 16777215));
$indexFulltext->addColumn('metaphonedata', 'text', array('length' => 16777215, 'notnull' => TRUE));
$indexFulltext->setPrimaryKey(array('phash'));


// index_rel
$indexRel = $schema->createTable('index_rel');
$indexRel->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexRel->addColumn('wid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexRel->addColumn('count', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexRel->addColumn('first', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexRel->addColumn('freq', 'smallint', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexRel->addColumn('flags', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexRel->setPrimaryKey(array('phash', 'wid'));
$indexRel->addIndex(array('wid', 'phash'), 'wid');


// index_words
$indexWords = $schema->createTable('index_words');
$indexWords->addColumn('wid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexWords->addColumn('baseword', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexWords->addColumn('metaphone', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexWords->addColumn('is_stopword', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexWords->setPrimaryKey(array('wid'));
$indexWords->addIndex(array('baseword', 'wid'), 'baseword');
$indexWords->addIndex(array('metaphone', 'wid'), 'metaphone');


// index_section
$indexSection = $schema->createTable('index_section');
$indexSection->addColumn('uniqid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$indexSection->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexSection->addColumn('phash_t3', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexSection->addColumn('rl0', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexSection->addColumn('rl1', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexSection->addColumn('rl2', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexSection->addColumn('page_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexSection->setPrimaryKey(array('uniqid'));
$indexSection->addIndex(array('phash', 'rl0'), 'joinkey');
//$indexSection->addIndex('phash', 'page_id'), 'phash_pid');
$indexSection->addIndex(array('page_id'), 'page_id');
$indexSection->addIndex(array('rl0', 'rl1', 'phash'), 'rl0');
$indexSection->addIndex(array('rl0', 'phash'), 'rl0_2');


// index_grlist
$indexGrlist = $schema->createTable('index_grlist');
$indexGrlist->addColumn('uniqid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$indexGrlist->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexGrlist->addColumn('phash_x', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexGrlist->addColumn('hash_gr_list', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexGrlist->addColumn('gr_list', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexGrlist->setPrimaryKey(array('uniqid'));
$indexGrlist->addIndex(array('phash', 'hash_gr_list'), 'joinkey');
$indexGrlist->addIndex(array('phash_x', 'hash_gr_list'), 'phash_grouping');


// index_stat_search
$indexStatSearch = $schema->createTable('index_stat_search');
$indexStatSearch->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$indexStatSearch->addColumn('searchstring', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexStatSearch->addColumn('searchoptions', 'blob', array('length' => 65535));
$indexStatSearch->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexStatSearch->addColumn('feuser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexStatSearch->addColumn('cookie', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexStatSearch->addColumn('IP', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexStatSearch->addColumn('hits', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexStatSearch->setPrimaryKey(array('uid'));


// index_debug
$indexDebug = $schema->createTable('index_debug');
$indexDebug->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexDebug->addColumn('debuginfo', 'text', array('length' => 16777215));
$indexDebug->setPrimaryKey(array('phash'));


// index_config
$indexConfig = $schema->createTable('index_config');
$indexConfig->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$indexConfig->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('cruser_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('starttime', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('set_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('session_data', 'text', array('length' => 16777215));
$indexConfig->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('description', 'text', array('length' => 65535));
$indexConfig->addColumn('type', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('depth', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('table2index', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('alternative_source_pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('get_params', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('fieldlist', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('externalUrl', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('indexcfgs', 'text', array('length' => 65535));
$indexConfig->addColumn('chashcalc', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('filepath', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('extensions', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$indexConfig->addColumn('timer_next_indexing', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('timer_frequency', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('timer_offset', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('url_deny', 'text', array('length' => 65535));
$indexConfig->addColumn('recordsbatch', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexConfig->addColumn('records_indexonchange', 'boolean', array('default' => '0', 'notnull' => TRUE));
$indexConfig->setPrimaryKey(array('uid'));
$indexConfig->addIndex(array('pid'), 'index_config_idx');


// index_stat_word
$indexStatWord = $schema->createTable('index_stat_word');
$indexStatWord->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$indexStatWord->addColumn('word', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$indexStatWord->addColumn('index_stat_search_id', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexStatWord->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexStatWord->addColumn('pageid', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexStatWord->setPrimaryKey(array('uid'));
$indexStatWord->addIndex(array('tstamp', 'word'), 'index_stat_word_tstamp');

return $schema;
