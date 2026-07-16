<?php

require_once('pdo_database.php');

class DB {

    private static $driver = 'pdo_database';
    private static $instance = null;

    /**
     * Singleton de conexión PDO
     */
    private static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new self::$driver([
                'dbtype' => TYPEDB,
                'dbhost' => HOSTDB,
                'dbuser' => USERDB,
                'dbpass' => PASSDB,
                'dbname' => NAMEDB
            ]);
        }
        return self::$instance;
    }

    public static function insert_record($table, $params, $config = []) {
        return self::getConnection()->insert_record($table, $params, $config);
    }

    public static function update_record($table, $params) {
        return self::getConnection()->update_record($table, $params);
    }

    public static function get_record($table, $params) {
        return self::getConnection()->get_record($table, $params);
    }

    public static function get_records($table, $params, $sortfields = []) {
        return self::getConnection()->get_records($table, $params, $sortfields);
    }

    public static function delete_records($table, $params) {
        return self::getConnection()->delete_records($table, $params);
    }

    public static function query($sql) {
        return self::getConnection()->query($sql);
    }

    public static function next_row($rst) {
        return $rst->fetch();
    }

    public static function row_count($rst) {
        return $rst->rowCount();
    }

    public static function table_exists($params) {
        return self::getConnection()->table_exists($params);
    }

    public static function get_info_columns($params) {
        return self::getConnection()->get_info_columns($params);
    }

    public static function get_info_keys($params) {
        return self::getConnection()->get_info_keys($params);
    }
}