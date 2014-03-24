<?php

$schema = new Doctrine\DBAL\Schema\Schema();

// tx_rtehtmlarea_acronym
$txRtehtmlareaAcronym = $schema->createTable('tx_rtehtmlarea_acronym');
$txRtehtmlareaAcronym->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('starttime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('endtime', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('sys_language_uid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('type', 'boolean', array('default' => '1', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('term', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('acronym', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txRtehtmlareaAcronym->addColumn('static_lang_isocode', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txRtehtmlareaAcronym->setPrimaryKey(array('uid'));
$txRtehtmlareaAcronym->addIndex(array('pid'), 'tx_rtehtmlarea_acronym_idx');

return $schema;
