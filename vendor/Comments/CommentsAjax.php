<?php
/**
 * AJAX-действия для комметариев
 * 
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase\Comments;

use ExportBase\Engine;
use ExportBase\Lib\upload;
use ExportBase\Lib\captcha;
use ExportBase\Comments\CommentsModel;
use ExportBase\Comments\CommentsController;

class CommentsAjax
{
	protected $model;
	protected $files;

	public function __construct() {
		$this->model = new CommentsModel();
		$this->files = new upload();
	}

	/**
	 * Добавление нового комментария
	 *
	 * @return 	mixed
	 */
	public function add()
	{
		$author = isset($_REQUEST['name']) ? htmlspecialchars( strip_tags( trim( $_REQUEST['name'] ) ) ) : '';
		$text = isset($_REQUEST['text']) ? htmlspecialchars( trim( $_REQUEST['text'] ) ) : '';

		if( !$this->checkCaptcha() || empty($author) || empty($text) ) {
			return false;
		}

		$id = $this->model->add( $author, $text );

		$comments = new CommentsController;
		$comments = $comments->view( 1, $id );

		return '<div id="comments-animate">' . $comments . '</div>';
	}

	/**
	 * Удаление комментария
	 *
	 * @return 	mixed
	 */
	public function remove()
	{
		$row = $this->model->get( $_REQUEST['id'] );

		if( $row['id'] > 0 ) {
			$this->model->remove( $row['id'] );
			return $row['id'];
		}

		return false;
	}

	/**
	 * Генерация капчи
	 *
	 * @return 	string
	 */
	public function captcha()
	{
		$captcha = new captcha();
		$_SESSION['captcha'] = $captcha->getKeyString();

		return '';
	}

	/**
	 * Проверка правильного ввода капчи
	 *
	 * @return 	boolean
	 */
	public function checkCaptcha()
	{
		if( !isset($_SESSION['captcha']) || $_REQUEST['captcha'] !== $_SESSION['captcha'] ) {
			return false;
		} else return true;
	}

	/**
	 * Загрузка изображений
	 * 
	 * @return 	string
	 */
	public function upload()
	{
		if( !isset($_FILES) || !count($_FILES) ) return false;
		
		$file = @reset($_FILES);
		return $this->files->upload( $file );
	}

}