<?php
	require_once "sys/init.php";
	if (isset($_GET['type']) && $_GET['type'] != "") {
		$type = $_GET['type'];
	}
	if($type == "list"):
?>
	<h1><a href='./'>toDo Lists Manager</a><small>/Add new list</small></h1>
	<form action="actionsList.php?act=add" method="POST">
	  <div class="form-group">
	  	<input required="required" type="text" name="caption" class="form-control" placeholder="List caption">
	  </div>
	  <button type="submit" class="btn btn-default">Create a list</button>
	</form>
<? elseif($type == 'task'): 
   $listId = $_GET['listId'];
   $currentList = $lists->getCurrentList($listId)->fetch();
   $captionForTitle = (strlen($currentList['caption']) > 7) ? substr($currentList['caption'], 0, 12).'..."' : $currentList['caption'].'"';
   $title = '"'.$captionForTitle;
?>
	<h1><a href='./'>toDo Lists Manager</a><small>/Add new task into <?=$title?></small></h1>
	<form action="actionsTask.php?act=add&listId=<?=$listId?>" method="POST">
	  <div class="form-group">
	    <input required="required" type="text" name="title" class="form-control" placeholder="Task caption">
	  </div>
	  <div class="form-group">
	    <textarea name="description" class="form-control" rows="3" placeholder="Task description"></textarea>
	  </div>
	  <div class="form-group">
		<input type="date" name="expiredBy" class="form-control">
	  </div>
	  <button type="submit" class="btn btn-default">Create task</button>
	</form>
<?
	elseif($type == 'editTask'):

	$taskId = $_GET['taskId'];
	$task = $tasks->getCurrentTaskById($taskId)->fetch();
	$checkedDisActive = "";
	$checkedActive = ($task['active']) ? "checked" : $checkedDisActive = "checked";
?>
	<h1>
		<a href='./'>toDo Lists Manager</a>
		<small>/
		<a href="viewList.php?listId=<?= $task['listId']?>">
		<?= $task['title']?>
		</a>/Edit
		</small>
	</h1>
	<form action="actionsTask.php?act=edit&taskId=<?=$_GET['taskId']?>" method="POST">
	  <div class="form-group">
		<div class="btn-group" data-toggle="buttons">
    	  <label class="btn btn-primary active">
    	  	<input name="isActive" type="radio" <?= $checkedActive?> value="1">Is active task
    	  </label>
    	  <label class="btn btn-primary">
    	  	<input name="isActive" type="radio" <?= $checkedDisActive?> value="0">Is disactive task
    	  </label>
    	</div>
      </div>
	  <div class="form-group">
	    <input required="required" type="text" name="title" class="form-control" placeholder="Task caption" value="<?= $task['title']?>">
	  </div>
	  <div class="form-group">
	    <textarea name="description" class="form-control" rows="3" placeholder="Task description" ><?=$task['description']?></textarea>
	  </div>
	  <div class="form-group">
		<input required="required" type="date" name="expiredBy" class="form-control" value="<?= $task['expiredBy']?>">
	  </div>
	  <button type="submit" class="btn btn-default">Edit task</button>
	</form>
<? endif; ?>
</body>
</html>