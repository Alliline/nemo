<?php
/**
 * Загрузка изображений
 *
 * @source https://www.tiny.cloud/docs/advanced/php-upload-handler/
 */

namespace ExportBase\Lib;

use ExportBase\Engine;

class upload
{
    protected $folder;
    protected $max_size;
    protected $extensions;

    public function __construct()
    {
        $this->folder = DIRECTORY_SEPARATOR . Engine::$config['file_folder'] . DIRECTORY_SEPARATOR;
        $this->maxsize = Engine::$config['file_maxsize'];
        $this->extensions = Engine::$config['file_extensions'];
    }

    /**
     * Загрузка файла на сервер
     *
     * @param   array   $file   Данные о временном файле
     */
    public function upload( $file )
    {
        $file_ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
        $file_name = time() . '_' . $file['name'];
        $file_path = $this->folder . $file_name;

        @header("HTTP/1.1 400");

        // Если временный файл не сущетсвует
        if( !is_uploaded_file( $file['tmp_name'] ) ) {
            return Engine::$lang['error_files_upload'];
        }

        // Проверка корректности имени
        if( preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $file['name']) ) {
            return Engine::$lang['error_files_name'];
        }

        // Максимально допустимый размер
        if( $file['size'] > $this->maxsize * 1000 * 1000 ) {
            return Engine::$lang['error_files_size'];
        }
        
        // Расширение (формат) файла
        if( !in_array( $file_ext, $this->extensions ) ) {
            return Engine::$lang['error_files_extension'];
        }
        
        // Копирование в директорию
        if( move_uploaded_file( $file['tmp_name'], ROOT_DIR . $file_path ) ) {

            @header("HTTP/1.1 200");
            
            return json_encode(array(
                'location' => $file_path
            ));
        }
        
        return false;
    }
}