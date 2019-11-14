<?php
/**
 * Контроллер комментариев
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase\Comments;

use ExportBase\Message;
use ExportBase\Templates;
use ExportBase\Comments\CommentsModel;

class CommentsController
{
	protected $tpl = null;
	protected $model = null;
	protected $count = 1;

	public function __construct() {
		$this->tpl = new Templates;
		$this->model = new CommentsModel();
	}

	/**
	 * Вывод списка комментариев
	 *
	 * @param 	integer 	$limit 	Количество на страницу
	 * @param 	integer 	$id 	Индентификатор (если нужен один коммент)
	 * @return 	string
	 */
	public function view( $limit = 1, $id = 0 )
	{
		$limit = intval( $limit );
		$id = intval( $id );

		$data = array();

		if( $id < 1 ) {
			$data = $this->model->getAll( $limit );
			$this->count = count( $data );
		} else $data[] = $this->model->get( $id );

		$this->tpl->load( 'comments' );

		foreach( $data as $row )
		{
			$this->tpl->set( '{id}', $row['id'] );
			$this->tpl->set( '{date}', $row['date'] );
			$this->tpl->set( '{author}', stripcslashes( $row['author'] ) );
			$this->tpl->set( '{text}', html_entity_decode( stripcslashes( $row['text'] ) ) );

			$this->tpl->compile('comments');
		}

		$this->tpl->clear();

		if( empty( $this->tpl->result['comments'] ) ) {
			$this->tpl->result['comments'] = Message::view( 'error', 'error_notfound_comments' );
		}

		return $this->tpl->result['comments'];
	}

	/**
	 * Вывод количества комментариев
	 *
	 * @return 	integer 
	 */
	public function counter() {
		return $this->count;
	}

}