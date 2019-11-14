<?php
/**
 * Модель комментариев
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase\Comments;

use ExportBase\MySQL;
use ExportBase\Engine;

class CommentsModel
{
	protected $db;

	public function __construct() {
		$this->db = new MySQL();
	}

	/**
	 * Выборка одного комментария по ID
	 *
	 * @param 	integer 	$id 	Идентификатор комментария
	 * @return 	array
	 */
	public function get( $id )
	{
		$id = intval( $id );

		return $this->db->super_query("
			SELECT 
				* 
			FROM 
				comments 
			WHERE 
				id = '{$id}'
			LIMIT
				1
		");
	}

	/**
	 * Выборка списка комментариев
	 *
	 * @param 	integer 	$limit 	Количество на страницу
	 * @return 	array
	 */
	public function getAll( $limit )
	{
		$limit = intval( $limit ) > 1 ? intval( $limit ) : intval(Engine::$config['limit_comments']);

		return $this->db->super_query("
			SELECT
				* 
			FROM 
				comments 
			ORDER BY 
				`date` DESC 
			LIMIT 
				0, {$limit}
		", true);
	}

	/**
	 * Удаление комментария из базы данных
	 *
	 * @param 	integer 	$id 	Идентификатор комментария
	 */
	public function remove( $id )
	{
		$id = intval( $id );

		$this->db->query("
			DELETE FROM 
				comments 
			WHERE 
				id = '{$id}' 
			LIMIT 
				1
		");
	}

	/**
	 * Добавление комментария в базу данных
	 *
	 * @param 	string 	$author	Имя пользователя
	 * @param 	string 	$text 	Текст комментария
	 * @return 	integer
	 */
	public function add( $author, $text )
	{
		$author = $this->db->safesql( $author );
		$text = $this->db->safesql( $text );
		$date = date( "Y-m-d H:i:s", time() );

		$this->db->query("
			INSERT INTO 
				comments 
					(`date`, `author`, `text`) 
				VALUES 
					('{$date}', '{$author}', '{$text}')
		");

		return $this->db->insert_id();
	}
}