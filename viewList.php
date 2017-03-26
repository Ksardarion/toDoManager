<?php 
	require_once "/sys/init.php";
	if (!isset($_GET['listId']) || $_GET['listId'] == "") {
		$err = "Please, select a list of tasks!";
		$title = "Error";
	} else {
		require_once "sys/initDataFromDB.php";
		$listId = $_GET['listId'];
		$currentList = $lists->getCurrentList($listId);
		$currentList = $currentList->fetch();
		$title = "Tasks from ".$currentList['caption'];
	}
?>
	<?php 
	  if (isset($err)) {
	?>
	  <h1><a href='./'>toDo Lists Manager</a><small>/Error</small></h1>
	  <div class="alert alert-danger" role="alert">
	  	<?= $err ?>
	  </div>
	<?php
	  } else {
	  	echo "<h1><a href='./'>toDo Lists Manager</a><small>/Tasks from \"".$currentList['caption']."\"</small><a style='float: right;' class='btn btn-primary btn-lg' href='creations.php?type=task&listId=".$_GET['listId']."' role='button'>Add new task</a></h1>";
	  	echo "<div class='tasks'>";
	  	$task = $tasks->getTasksFromList($_GET['listId']);
	  	while ($assocTasksArray = $task->fetch()) { 
	?>
	      <div class="panel panel-default">
  	    	<div class="panel-heading">
        	  <h3 class="panel-title"><?= $assocTasksArray['title']?></h3>
				<div class="actions">
			  	  <a href="creations.php?type=editTask&taskId=<?= $assocTasksArray['id']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
			  	  <a href="actionsTask.php?act=delete&taskId=<?= $assocTasksArray['id']?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				</div>
  	    	</div>
  	      <div class="panel-body">
			<?= $assocTasksArray['description']?>
  	      </div>
 	      </div>
	<?php
	  }
	  echo "</div>";
	  if (!$task->rowCount()) {
	  	echo "<div class='alert alert-warning' role='alert'>This list haven`t tasks</div>";
	  }
	  }
	?>
</body>
</html>