<?php

namespace Models\Database;

/**
 * @author Bang
 */
class LogTables {

    const CreateSql = "(
                            `id`  int(20) NOT NULL AUTO_INCREMENT ,
                            `day`  int(11) NOT NULL ,
                            `hour`  int(11) NOT NULL ,
                            `action`  varchar(150) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL ,
                            `request`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                            `response`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
                            `request_id`  varchar(50) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL ,
                             `client_request_id`  varchar(50) CHARACTER SET ascii COLLATE ascii_general_ci NULL DEFAULT NULL ,
                            `time`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                            `span_ms`  varchar(35) CHARACTER SET ascii COLLATE ascii_general_ci NULL DEFAULT NULL ,
                            `error_code`  varchar(35) CHARACTER SET ascii COLLATE ascii_general_ci NULL DEFAULT NULL ,
                            PRIMARY KEY (`id`),
                            INDEX `day_index` USING BTREE (`day`) ,
                            INDEX `hour_index` USING BTREE (`hour`) ,
                            INDEX `action_index` USING BTREE (`action`) ,
                            INDEX `error_code_index` USING BTREE (`error_code`) ,
                            INDEX `request_id_index` USING BTREE (`request_id`) ,
                            INDEX `client_request_id_index` USING BTREE (`client_request_id`) 
                        )
                        ENGINE=InnoDB
                        DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
                        AUTO_INCREMENT=1
                        ROW_FORMAT=COMPACT
                        ;";

}
