<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Nemo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="HandheldFriendly" content="True">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="theme-color" content="#ffffff">
	<meta name="msapplication-TileColor" content="#ffffff">
	<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
	<link rel="dns-prefetch" href="https://ajax.googleapis.com">
	<link rel="dns-prefetch" href="https://cdn.tiny.cloud">
	<link charset="UTF-8" href='/themes/assets/reset.css' rel='stylesheet' media="all">
	<link charset="UTF-8" href='/themes/assets/styles.css' rel='stylesheet' media="all">
</head>
<body>

	<div class="wr db">

		<article class="article db mgb mgt">
			<div class="aName db mgb"><h1 class="fb4x">Тестовое задание</h1></div>
			<div class="aText db tj text">
				<figure>
					<img src="/uploads/img.jpg" alt="Random image">
					<figcaption class="tc silver fs3x">Image caption</figcaption>
				</figure>
				<br>
				<p>Мы опубликовали программу Девятой Вебмастерской, которая пройдёт 22 ноября. Тема конференции — Customer Journey. Это путь, который проходит клиент от возникновения потребности в товаре до превращения в лояльного покупателя.</p>
				<br>
				<p>Наши эксперты расскажут о том, как бизнесу анализировать клиентский опыт и находить точки роста, как эффективно решать задачи маркетинга и продукта. Кроме того, представители сервисов Яндекса подготовили много интересных анонсов, но расскажем мы о них только на самой конференции.</p>
			</div>
		</article>
		
		<div class="counter db mgb"><h2 class="fb">Комментарии (<span id="counter">{counter}</span>)</h2></div>

		<div class="addComments db pdb mgb">
			<form action="" method="post" id="add-comments" enctype="multipart/form-data">
				<div class="db mgb">
					<label from="name" class="label db sure fs2x">Имя:</label>
					<input type="text" name="name" id="comment_name" placeholder="Введите имя" required />
				</div>
				<div class="db mgb">
					<label from="text" class="label db sure fs2x">Текст:</label>
					<textarea id="comment_text" name="text" placeholder="Введите текст Вашего комментария..." ></textarea>
				</div>
				<div class="db mgb">
					<label from="text" class="label db sure fs2x">Защитный код:</label>
					<div class="flexVert db">
						<span id="captcha" title="Обновить код" class="captcha di fl mgmr"></span>
						<input class="di fl" placeholder="Введите код с картинки" type="text" name="captcha" id="comment_captcha" required>
					</div>
				</div>
				<div class="db">
					<button class="btn" type="submit"><ion-icon name="add-circle"></ion-icon>&nbsp; <span>Добавить</span></button>
				</div>
				<input type="hidden" name="action" value="add" />
				<input name="image" type="file" id="upload" class="no" multiple>
			</form>
		</div>

		<div class="commentsList db" id="list-comments">
			{comments}
		</div>

	</div>

	<link charset="UTF-8" href='/themes/assets/engine.css' rel='stylesheet' media="all">
	
	<script src="https://cdn.jsdelivr.net/npm/ionicons@4.6.3/dist/ionicons/ionicons.js" integrity="sha256-pwVfHk0Ww15lVkpBsfCXxv3ivsEFaXrnoZQGh1cxaqM=" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>

	<script src="/themes/scripts/functions.js" defer></script>

</body>
</html>