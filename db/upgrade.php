<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file keeps track of upgrades to the paypal enrolment plugin
 *
 * @package    enrol_metabulk
 * @copyright  2015 Mihir Thakkar
 * @author     Mihir Thakkar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_enrol_metabulk_upgrade($oldversion) {
    global $CFG, $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2015052104) {

        // Define table enrol_metabulk to be created.
        $table = new xmldb_table('enrol_metabulk');

        // Adding fields to table enrol_metabulk.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('enrolid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('groupid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table enrol_metabulk.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('enrolid', XMLDB_KEY_FOREIGN, array('enrolid'), 'enrol', array('id'));

        // Conditionally launch create table for enrol_metabulk.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Metabulk savepoint reached.
        upgrade_plugin_savepoint(true, 2015052104, 'enrol', 'metabulk');
    }

    return true;
}
