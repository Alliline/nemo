<?php
/**
 * Класс для работы с базой данных
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase;

use ExportBase\Lib\db;

include_once ROOT_DIR . '/data/connect.php';

class MySQL extends db {}