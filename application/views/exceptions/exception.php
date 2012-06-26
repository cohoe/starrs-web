<div class="span<?=(isset($span))?$span:4;?> alert alert-error">
	<h1>Error:</h1>
	<br />
	<p>Message: <?=$exception->getMessage();?></p>
	<p>Type: <?=get_class($exception);?></p>
</div>
